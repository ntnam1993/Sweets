<?php

namespace App\Http\Controllers;

use App\Adapters\RegionAdapter;
use App\Region;
use App\Review;
use App\Services\CommentService;
use App\Services\PortalService;
use App\Shop;
use App\Services\ProductService;
use App\Services\ReservationService;
use App\Services\ShopService;
use App\Station;
use Config;
use App\Helpers\EparkEncrypter;
use Util;
use Illuminate\Support\Str;

class BaseController extends Controller
{
    const COUPON_CODE = 'reservation_500off_20190329';
    const NO_SHOP = 'no-shop';
    const NO_PRODUCT = 'no-product';
    const EXPIRED_COOKIE = 90 * 24 * 60; // 90 days
    const TOKEN_NAME = 'sweets_tokens';
    const GAPID = 'gapid';

    protected $agent;
    protected $path;
    protected $isMobile;
    protected $linkApiCoupon;
    protected $loginLink;
    protected $logoutLink;
    protected $encrypter;
    protected $isLogin;
    protected $accessToken;
    protected $eparkMemberId;
    protected $portalService;

    public function __construct()
    {
        $this->agent = \App::make('agent');
        // render PC view for iPad
        $this->isMobile = $this->agent->isMobile() && !$this->agent->isIpad() ? true : false;
        $this->path = $this->isMobile ? 'mobile.' : '';

        $this->linkApiCoupon = env('COUPON_HEADER_LINK_V2');

        $this->loginLink = env('SWEETS_LOGIN_ENDPOINT' . ($this->isMobile ? '_SP' : '')) . '?callerPageType=1&afterLoginPath=' . urlencode(getCurrentPathWithQuery());
        $this->logoutLink = env('SWEETS_LOGOUT_ENDPOINT' . ($this->isMobile ? '_SP' : '')) . '?callerPageType=1&afterLoginPath=' . urlencode(getCurrentPathWithQuery());

        $this->portalService = new PortalService();
        if (Str::startsWith($key = config('app.key'), 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }
        $this->encrypter = new EparkEncrypter($key, config('app.cipher'));
        $this->isLogin = $this->isLogin();

        view()->share('linkApiCoupon', $this->linkApiCoupon);
        view()->share('loginLink', $this->loginLink);
        view()->share('logoutLink', $this->logoutLink);
        view()->share('isMobile', $this->isMobile);
        view()->share('linkPath', $this->getPathToECInFooter());
        view()->share('isLogin', $this->isLogin);
    }

    public function getPathToECInFooter()
    {
        $linkPath = config('common.URL_SWEETS_EC_STAGING');
        if (env('APP_ENV') == 'production') {
            $linkPath = config('common.URL_SWEETS_EC_PRODUCT');
        }
        if ($this->isMobile) {
            $linkPath = $linkPath.'/sp';
        }
        return $linkPath;
    }

    public function getRootRegions()
    {
        $regions0 = Region::mainCategories()->whereIn('region_category_id', [2, 7, 10, 13, 16, 19, 20])->orderBy('order_no')->get();
        $regions1 = Region::mainCategories()->whereIn('region_category_id', [780, 783, 50, 56, 60, 65, 68, 69])->orderBy('order_no')->get();
        $regions2 = Region::mainCategories()->whereIn('region_category_id', [74, 80, 83, 87, 88, 91, 92, 95, 98, 101])->orderBy('order_no')->get();
        $regions3 = Region::mainCategories()->whereIn('region_category_id', [103, 111, 117, 120, 123, 126])->orderBy('order_no')->get();
        $regions4 = Region::mainCategories()->whereIn('region_category_id', [130, 134, 138, 139, 140, 143, 146, 147, 150])->orderBy('order_no')->get();
        $regions5 = Region::mainCategories()->whereIn('region_category_id', [154, 159, 160, 163, 166, 169, 172, 175])->orderBy('order_no')->get();
        $rootRegions = Region::ROOT_REGIONS;
        foreach ($rootRegions as $key => $value) {
            $dataRegions[$value] = ${'regions' . $key};
        }
        return $dataRegions;
    }

    public function getRootStation()
    {
        $station0 = Station::prefectures()->orderBy('prov_rank_no')->skip(0)->take(7)->get();
        $station1 = Station::prefectures()->orderBy('prov_rank_no')->skip(7)->take(7)->get();
        $station2 = Station::prefectures()->orderBy('prov_rank_no')->skip(14)->take(10)->get();
        $station3 = Station::prefectures()->orderBy('prov_rank_no')->skip(24)->take(6)->get();
        $station4 = Station::prefectures()->orderBy('prov_rank_no')->skip(30)->take(9)->get();
        $station5 = Station::prefectures()->orderBy('prov_rank_no')->skip(39)->take(8)->get();
        $rootStations = Region::ROOT_REGIONS;
        foreach ($rootStations as $key => $value) {
            $dataStations[$value] = ${'station' . $key};
            foreach (${'station' . $key} as $val) {
                $val['root'] = $value;
            }
        }
        return $dataStations;
    }

    public function checkLogin()
    {
        return $this->isLogin;
    }

    // Get the different days from today to the latest receipt date
    public function getDiffLatestReceiptDate($productId = null)
    {
        $params = [
            'products[0][product_id]' => !empty(request()->product_id) ? request()->product_id : $productId,
            'products[0][product_count]' => !empty(request()->product_count) ? request()->product_count : 1,
        ];
        $reservationService = app(ReservationService::class);
        $promises = [
            $reservationService->requestAsyncReceiptDate($params),
        ];
        $results = \GuzzleHttp\Promise\unwrap($promises);
        $resReceipDate = json_decode($results[0]->getBody());
        $ret = [
            'reservable' => false,
            'firstReceiptDate' => '',
            'listDateReserve' => []
        ];
        try {
            if ('0' == $resReceipDate->status) {
                $receiptDates = (array) json_decode($results[0]->getBody())->receipt_date;
                if (count($receiptDates) > 0) {
                    $listDateReserveFormat = [];
                    $latestDate = array_keys($receiptDates)[0];
                    $todayFormat = date('m月d日', strtotime($latestDate));
                    $listDateReserve = array_keys($receiptDates);
                    if (count($listDateReserve)) {
                        foreach ($listDateReserve as $key => $dateReserve) {
                            $listDateReserveFormat[$key] = date('Y-m-d', strtotime($dateReserve));
                        }
                    }
                    $ret['firstReceiptDate'] = $todayFormat . convertToWeekday(strtotime($latestDate));
                    $ret['reservable'] = true;
                    $ret['listDateReserve'] = $listDateReserveFormat;
                }
            }
        } catch (\Exception $e) {
            return $ret;
        }

        return $ret;
    }

    public function getNearDayReceive($productId)
    {
        $params = [
            'products[0][product_id]' => $productId,
            'products[0][product_count]' => 1,
        ];
        $reservationService = app(ReservationService::class);
        $promises = [
            $reservationService->requestAsyncReceiptDate($params),
        ];
        $results = \GuzzleHttp\Promise\unwrap($promises);
        $resReceipDate = json_decode($results[0]->getBody());
        $nearDayReceive = '';
        try {
            if ('0' == $resReceipDate->status) {
                $nearDayReceive = $resReceipDate->receipt_date;
                foreach ($nearDayReceive as $key => $value) {
                    $nearDayReceive = $key;
                    break;
                }
                return $nearDayReceive;
            }
        } catch (\Exception $e) {
            return $nearDayReceive;
        }
        return $nearDayReceive;
    }

    /**
     * get post review url for a shop
     * @param  [type] $shopId   [description]
     * @param  [type] $shopName [description]
     * @return [type]           [description]
     */
    protected function getPostReviewUrl($shopId, $shopName)
    {
        $sp = $this->isMobile ? '/sp' : '';
        $postReviewUrl = env('REVIEW_DOMAIN') . $sp . '/login/userReviews?serviceId=' . env('SHOP_SERVICE_ID') . '&id=' . $shopId . '&catalog=' . urlencode($shopName) . '&returnUrl=' . request()->url();
        return $postReviewUrl;
    }

    public function noShopSearch()
    {
        if ($this->isMobile) {
            return response()->view('search.error-shop.mobile.error', [], 404);
        }
        return response()->view('search.error-shop.error', [], 404);
    }

    public function getListParamProductPage($request, $productId, $flo = false)
    {
        $productService = new ProductService();
        $commentService = new CommentService();
        $shopService = new ShopService($commentService, $productService);
        $regionAdapter = new RegionAdapter();

        $mxNumProducts = 4;

        list($dispCount, $rows) = empty($this->path) ? [5, 5] : [3, 0];
        $item = $productService->getProductItem($productId);
        if (!isset($item->item) || '0' != $item->status) {
            return [
                'status' => self::NO_PRODUCT
            ];
        }

        /**
         * Handling Redirect to parent_id if exists
         */

        if (!empty($item->item->parent_id) && is_numeric($item->item->parent_id)) {
            return [
                null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,$item->item->parent_id //redirect == true
            ];
        }

        $shopId = $item->item->shop_id;
        $options['order'] = 'comment_date_desc';
        $results = $this->getComments($dispCount, 1, $shopId, $options, $commentService);
        $comments = new Review($results);
        $shop = $shopService->getShopItem($shopId);
        if (!isset($shop->item) || '0' != $shop->status || ( $flo && $shop->item->parent_shopowner_id != config('common.SHOP_FLO_OWNER') )) {
            abort(404);
        }elseif($flo) {
            list($viewFile, $parentAndChildProducts) = $this->buildViewAndParentChildProductFLO($item, $productId);
        }else{
            // Build breadcrumb
            view()->share('breadcrumb', (new \App\Builders\ProductPagesBreadcrumbBuilder(compact('item', 'shopId', 'shop', 'region', 'subRegion')))->build());
            list($viewFile, $parentAndChildProducts) = $this->buildViewAndParentChildProduct($item, $productId);
        }

        $shop = new Shop($shop);

        $isLogin = $this->checkLogin();

        // Defines post review url
        $postReviewUrl = $this->getPostReviewUrl($shopId, $shop->item->facility_name);

        // Gets viewed products from cookie
        $viewedProducts = json_decode($request->cookie('viewed_products'), true);
        $currentDate = date('Y/m/d');
        // Adds current product to viewed stack then saves to cookies
        if (empty($viewedProducts)) {
            $viewedProducts = ['id' => $productId, 'currentDate' => $currentDate];
            $arrViewProds = [];
            $arrViewProds[] = $viewedProducts;
            $cookie = cookie('viewed_products', json_encode($arrViewProds), self::EXPIRED_COOKIE);
        } else {
            // Moves to top if exists
            $flg = 0;
            foreach ($viewedProducts as $keyViewProd => $arrViewProd) {
                if (!isset($arrViewProd['id'])) {
                    $viewedProducts = [];
                    $viewedProducts[] = ['id' => $productId, 'currentDate' => $currentDate];
                    break;
                } elseif ($arrViewProd['id'] == $productId) {
                    unset($viewedProducts[$keyViewProd]);
                    $itemIns = ['id' => $productId, 'currentDate' => $currentDate];
                    $tmpArray[] = $itemIns;
                    $tmpArray = array_merge($tmpArray, $viewedProducts);
                    $viewedProducts = $tmpArray;
                    break;
                } else {
                    $flg++;
                }
            }
            if (count($viewedProducts) == $flg) {
                $itemIns = ['id' => $productId, 'currentDate' => $currentDate];
                $tmpArray[] = $itemIns;
                $tmpArray = array_merge($tmpArray, $viewedProducts);
                $viewedProducts = $tmpArray;
            }
            $cookie = cookie('viewed_products', json_encode($viewedProducts), self::EXPIRED_COOKIE);
        }

        $prefectureId = !empty($shop->item->category_2) ? $shop->item->category_2->category_id : null;
        $citySiblings = [];
        if (!empty($prefectureId)) {
            $citySiblings = $this->getCitySiblingsByPrefectureId($prefectureId); //Get region childs of this product's region
        }

        // Responses with cookie

        $isMobile = $this->isMobile;
        // get four reservable products of this product's shop
        $get4ProductReservable = $this->getReservableProducts($shopId, $mxNumProducts, $productService);
        ksort($parentAndChildProducts);
        /** Get region and subRegion via injected {class RegionAdapter} */

        list($region, $subRegion) = $regionAdapter->getRegionAndSubRegionByShopItem($shop->item);
        $numCoupon = count_not_null((array) $shop->item->sweetsguide_coupon_informations);

        $categoryProduct1 = [
            'product_category_id' => '',
            'category_name' => ''
        ];
        if (!empty($item->item->category_products) && !empty($item->item->category_products[0]) && !empty($item->item->category_products[0]->category_product_1)) {
            $categoryProduct1['product_category_id'] = $item->item->category_products[0]->category_product_1->product_category_id;
            $categoryProduct1['category_name'] = $item->item->category_products[0]->category_product_1->category_name;
        }

        $couponCode = self::COUPON_CODE;

        return [
            $parentAndChildProducts,
            $isMobile,
            $get4ProductReservable,
            $isLogin,
            $item,
            $shop,
            $productId,
            $comments,
            $shopId,
            $postReviewUrl,
            $viewedProducts,
            $citySiblings,
            $region,
            $subRegion,
            $numCoupon,
            $categoryProduct1,
            $couponCode,
            $cookie,
            $viewFile,
            null //redirect == null, no redirect
        ];
    }

    private function getComments($dispCount = 1, $dispStart = 1, $targetId = null, $options = [], $commentService)
    {
        $query = [
            'disp_count' => $dispCount,
            'disp_start' => $dispStart,
            'target_id' => $targetId,
            'disp_fg' => 1,
        ];
        if (!empty($options)) {
            $query = array_merge($query, $options);
        }

        return $commentService->search($query)->getBody();
    }

    //Get city siblings of this product shop address
    public function getCitySiblingsByPrefectureId($prefectureId)
    {
        $citySiblings = [];
        $parentRegion = Region::where('region_category_id', $prefectureId)->first();
        if (!empty($parentRegion) && !empty($parentRegion->parent_region_category_id)) {
            $citySiblings = Region::where('parent_region_category_id', $parentRegion->parent_region_category_id)
                ->orderBy('order_no')
                ->get();
        }
        return $citySiblings;
    }

    private function buildViewAndParentChildProductFLO($item, $productId)
    {
        $viewFile = 'floprestige.' . $this->path . 'detail';
        $parentAndChildProducts[$item->item->product_size] = [
            'product_id' => $productId,
            'product_size' => $item->item->product_size,
            'product_price' => $item->item->product_price,
            'shop_discount' => $item->item->shop_discount,
            'portal_discount' => $item->item->portal_discount,
            'reservation_flg' => $item->item->reservation_flg,
        ];
        foreach ($item->item->child_data as $key => $value) {
            $parentAndChildProducts[$value->product_size] = [
                'product_id' => $key,
                'product_size' => $value->product_size,
                'product_price' => $value->product_price,
                'shop_discount' => $value->shop_discount,
                'portal_discount' => $value->portal_discount,
                'reservation_flg' => $value->reservation_flg,
            ];
        }
        return [
            $viewFile,
            $parentAndChildProducts
        ];
    }

    private function buildViewAndParentChildProduct($item, $productId)
    {
        $viewFile = 'product.' . $this->path . 'detail';
        $parentAndChildProducts[$item->item->product_size] = [
            'product_id' => $productId,
            'product_size' => $item->item->product_size,
            'product_price' => $item->item->product_price,
            'portal_discount' => $item->item->portal_discount,
            'reservation_flg' => $item->item->reservation_flg,
        ];
        foreach ($item->item->child_data as $key => $value) {
            $product_price = getProductPrice($value);
            $parentAndChildProducts[$value->product_size] = [
                'product_id' => $key,
                'product_size' => $value->product_size,
                'product_price' => $product_price,
                'reservation_flg' => $value->reservation_flg,
            ];
        }
        return [
            $viewFile,
            $parentAndChildProducts
        ];
    }
    /**
     * Request the search product API to get reservable products of the given shop
     *
     * @param string $shopId The shop's Id
     * @param int $mxNumProducts The maximum number of reservable products will be retrieved
     *
     * @return array A list of reservable products
     */
    private function getReservableProducts($shopId, $mxNumProducts = 4, $productService)
    {
        // results' holder
        $reservableProducts = [];
        // parameters to request to the product search API
        $start = 0;
        $params = [
            'shop_id' => $shopId,
            'rows'    => 50,
            'start'   => $start,
            'sort'    => 0
        ];
        // a temporary var to hold counted value
        $reservableProductsCnt = 0;
        // request to the API to search products of the given shop
        do {
            $products = $productService->getProductSearch($params);
            $numFound = isset($products->num_found) ? (int) $products->num_found : 0;
            foreach ($products->items as $product) {
                if ('1' == $product->reservation_flg
                    && $mxNumProducts > $reservableProductsCnt) {
                    $reservableProducts[] = $product;
                    $reservableProductsCnt++;
                }
                if ($mxNumProducts == $reservableProductsCnt) {
                    break 2;
                }
            }
            $start += 50;
            $params['start'] = $start;
        } while ($numFound - $start > 0);
        return $reservableProducts;
    }

    public function getListParamShopMenuPage($request, $id, $informationRequest, $flo = false)
    {
        $shopService = new ShopService(new CommentService(), new ProductService());
        $regionAdapter = new RegionAdapter();

        $shopId = $id;

        // Gets queries
        $page = !empty($request->page) ? $request->page : 1;
        $rows = ('mobile.' == $this->path) ? 21 : 20;
        $start = ($rows * $page) - $rows;
        $sort = 0;

        $shop = $shopService->getShopItem($id);

        $products = $shopService->products($id,
            compact('start', 'rows', 'sort')
        )->getBody();

        $shop = new Shop($shop);
        $paging = $this->pagingAdapter->fromAPI($products, $page, $rows);

        if (empty($shop->exist()) || (!isset($shop->item) && count($shop->item) < 1)) {
            return [
                'status' => self::NO_SHOP,
            ];
        }

        if ($flo ) {
            if ($shop->item->parent_shopowner_id != config('common.SHOP_FLO_OWNER')) {
                abort(404);
            }
            $viewFile = 'floprestige.'.$this->path.'menu';
            $numCoupon = 0;
        }else{
            $coupons = (array) $shop->item->sweetsguide_coupon_informations;
            $numCoupon = count_not_null($coupons);
            $viewFile = 'shop.'.$this->path.'menu';
        }
        // change to productList to avoid namesake
        list($productList, $get4ProductReservable) = $this->getShopProducts($shopId);
        $productReservable = count($get4ProductReservable) > 0 ? 1 : 0;
        /** Get region and subRegion via regionAdapter */
        list($region, $subRegion) = $regionAdapter->getRegionAndSubRegionByShopItem($shop->item);
        $requestCount = $informationRequest->countByShop($shopId);
        $userRequested = $informationRequest->findByShop($shopId, ['id'])->count() ? true : false;

        view()->share('breadcrumb', (new \App\Builders\ShopPagesBreadcrumbBuilder(compact('shopId', 'shop', 'region', 'subRegion')))->build());
        $dataResponse = [
            $viewFile,
            $shopId,
            $products,
            $shop,
            $region,
            $subRegion,
            $paging,
            $numCoupon,
            $productReservable,
            $requestCount,
            $userRequested
        ];
        return $dataResponse;
    }

    /**
     * Request the search product API to get shop's products
     *
     * @param string $shopId The shop's Id
     *
     * @return array List of products [PC's products, reservable flag, reservable products]
     */
    public function getShopProducts($shopId)
    {
        $mxPcPageProducts = 5;
        $mxSpPageProducts = 4;
        // results' holders
        $reservablePcProducts = [];
        // parameters to request to the product search API
        $params = [
            'shop_id' => $shopId,
            'rows'    => 5,
            'start'   => 0,
            'sort'    => 0,
            'reserve' => 1
        ];
        // request to the API to search products of the given shop
        $reservablePcProductsCnt = 0;
        $products = $this->productService->getProductSearch($params);
        foreach ($products->items as $product) {
            if ('1' == $product->reservation_flg && $mxPcPageProducts > $reservablePcProductsCnt) {
                $reservablePcProducts[] = $product;
                $reservablePcProductsCnt++;
            }
        }
        // build reservable product list for smart phone page
        if ($reservablePcProductsCnt > $mxSpPageProducts) {
            $reservableSpProducts = array_slice($reservablePcProducts, 0 , $mxSpPageProducts);
        } else {
            $reservableSpProducts = $reservablePcProducts;
        }
        // build reservable product list for smart phone page
        return [$reservablePcProducts, $reservableSpProducts];
    }

    public function getListParamShopMapPage($id, $informationRequest, $flo = false)
    {
        $shopService = new ShopService(new CommentService(), new ProductService());
        $regionAdapter = new RegionAdapter();

        $shopId = $id;
        $shop = $shopService->getShopItem($shopId);
        $shop = new Shop($shop);

        if (empty($shop->exist()) || (!isset($shop->item) && count($shop->item) < 1)) {
            return [
                'status' => self::NO_SHOP,
            ];
        }
        list($region, $subRegion) = $regionAdapter->getRegionAndSubRegionByShopItem($shop->item);
        if ($flo ) {
            if ($shop->item->parent_shopowner_id != config('common.SHOP_FLO_OWNER')) {
                abort(404);
            }
            $viewFile = 'floprestige.'.$this->path.'map';
        }else{
            $coupons = (array) $shop->item->sweetsguide_coupon_informations;
            $numCoupon = count_not_null($coupons);
            $viewFile = 'shop.'.$this->path.'map';
            view()->share('breadcrumb', (new \App\Builders\ShopPagesBreadcrumbBuilder(compact('shopId', 'shop', 'region', 'subRegion')))->build());
            view()->share('numCoupon', $numCoupon);
        }
        list($products, $get4ProductReservable) = $this->getShopProducts($shopId);
        $productReservable = count($get4ProductReservable) > 0 ? 1 : 0;
        $requestCount = $informationRequest->countByShop($shopId);
        $userRequested = $informationRequest->findByShop($shopId, ['id'])->count() ? true : false;

        $dataResponse = [
            $viewFile,
            $shopId,
            $shop,
            $region,
            $subRegion,
            $productReservable,
            $requestCount,
            $userRequested
        ];
        return $dataResponse;
    }

    private function isLogin()
    {
        $isLogin = false;
        // If Cookie has sweets_token value
        if (!empty($_COOKIE[static::TOKEN_NAME])) {
            // Get token from cookies
            $sweetsToken = $_COOKIE[static::TOKEN_NAME];

            // Decrypt sweets_tokens
            $sweetsToken = $this->encrypter->decrypt($sweetsToken);

            if ($this->isValidHashCode($sweetsToken)) {
                $this->accessToken = $sweetsToken['accessToken'];
                $this->eparkMemberId = $sweetsToken['eparkMemberId'];
                view()->share('eparkMemberId', $this->eparkMemberId);
                if (empty($_COOKIE[static::GAPID])) {
                    $this->setGAPID($sweetsToken);
                    $this->shareGAPID();
                }
                $isLogin = true;
            } else {
                $this->removeTokenCookie();
            }
        }

        return $isLogin;
    }

    /**
     * Validating hash code from cookies (sweets_token)
     *
     * @param  array  $token
     *
     * @return bool
     */
    private function isValidHashCode(array $token)
    {
        if (
            empty($token['hashCode']) ||
            empty($token['refreshToken']) ||
            empty($token['eparkMemberId']) ||
            empty($token['accessToken'])
        ) {
            return false;
        }

        $preHased = [
            $token['accessToken'], $token['refreshToken'], $token['eparkMemberId'],
        ];

        return Util::stringToHash($preHased) == $token['hashCode'];
    }

    private function removeTokenCookie()
    {
        setcookie(static::TOKEN_NAME, '', time() - 3600);
    }

    public function getGAPID($token) {
        $access_token = $token['accessToken'];
        $refresh_token = $token['refreshToken'];

        // Call portalMemberRefer
        $memberInfo = $this->portalService->sweetsMemberRefer(
            compact('access_token', 'refresh_token')
        );
        $gapid = $memberInfo->getBody()->gapid;
        return $gapid;
    }

    public function setGAPID($token) {
        $gapid = $this->getGAPID($token);
        setcookie('gapid', $gapid, time()+2592000, "/");
    }

    private function shareGAPID()
    {
        $gapid = $_COOKIE['gapid'];
        // share gapid to view
        view()->share('gapid', $gapid);
    }
}
