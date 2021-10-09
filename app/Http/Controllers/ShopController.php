<?php
namespace App\Http\Controllers;

use App\Adapters\PagingAdapter;
use App\Adapters\RegionAdapter;
use App\Region;
use App\Repositories\Eloquents\InformationRequestEloquent;
use App\Review;
use App\Services\CommentService;
use App\Services\ProductService;
use App\Services\ShopService;
use App\Shop;
use Illuminate\Http\Request;

class ShopController extends BaseController
{

    protected $regionAdapter;
    protected $pagingAdapter;
    protected $shopService;
    protected $commentService;
    protected $productService;
    protected $informationRequest;

    public function __construct(
        RegionAdapter $regionAdapter,
        PagingAdapter $pagingAdapter,
        ShopService $shopService,
        CommentService $commentService,
        ProductService $productService,
        InformationRequestEloquent $informationRequest
    ) {
        parent::__construct();
        $this->regionAdapter = $regionAdapter;
        $this->pagingAdapter = $pagingAdapter;
        $this->shopService = $shopService;
        $this->commentService = $commentService;
        $this->productService = $productService;
        $this->informationRequest = $informationRequest;
    }

    /**
     * @author chuong
     * get shop detail
     * @param $id
     */
    public function index(Request $request, $id, $amp_data = null)
    {
        // Gets shop detail and shop's comments
        $shopId = $id;
        $listShop = [];
        list($shop, $comments) = $this->shopService->getShopItem($shopId, [
            'comments' => [
                'disp_count' => 3,
                'disp_start' => 1,
            ],
        ]);
        // get all shop images from reviews
        $commentsJson = json_encode($comments, JSON_UNESCAPED_SLASHES);
        preg_match_all('/{"image":"(.+)"/U', $commentsJson, $images);
        $shopImages = $images[1];
        $shop = new Shop($shop);

        if (empty($shop->exist()) || (isset($shop->item) && count($shop->item) < 1)) {
            return $this->noShopSearch();
        }

        // Counts coupons
        $coupons = (array) $shop->item->sweetsguide_coupon_informations;
        $numCoupon = count_not_null($coupons);

        // Counts photos
        $numPhoto = 0;
        foreach ($shop->item->shop_news as $shopNew) {
            if (!empty($shopNew) && '' != $shopNew->news_img && 1 == $shopNew->display_flg) {
                $numPhoto++;
            }
        }

        // Counts relatedlinks
        $count = 0;
        for ($i = 1; $i <= 4; $i++) {
            if (!empty($shop->item->{"related_links_title$i"})) {
                $count++;
            }
        }

        // Encodes coordinate
        $encodedCoordinate = '';
        if (!empty($shop->item->addr_longitude) && !empty($shop->item->addr_latitude)) {
            $encodedCoordinate = encodeCoordinate($shop->item->addr_longitude, $shop->item->addr_latitude);
        }

        $prefectureId = !empty($shop->item->category_2) ? $shop->item->category_2->category_id : null;
        $citySiblings = [];
        if (!empty($prefectureId)) {
            $citySiblings = $this->getCitySiblingsByPrefectureId($prefectureId); //Get region childs of this product's region
        }

        if (!empty($shop->item->contract_tp) && $shop->item->contract_tp == 1 && !empty($shop->item->category_2->category_id)) {
            $numberCheck = $this->isMobile ? 4 : 5;
            $query = [
                'catg' => $shop->item->category_2->category_id
            ];
            $tmp = $this->getListShop($query)->items;
            foreach ($tmp as $key => $value) {
                if ( (($value->contract_tp == 2) || ($value->contract_tp == 3)) && !empty($value->shop_shopowner_id) ) {
                    $listShop[$key] = $value;
                }
                if (count($listShop) >= $numberCheck) {
                    break;
                }
            }
        }

        $postReviewUrl = $this->getPostReviewUrl($shopId, $shop->item->facility_name);

        list($region, $subRegion) = $this->regionAdapter->getRegionAndSubRegionByShopItem($shop->item);

        // get reservable products of the shop given by $shopId
        // the data in $products are used to show on PC page, and
        // the data in $get4ProductReservable are used to show on smart phone page
        list($products, $get4ProductReservable) = $this->getShopProducts($shopId);
        $productReservable = count($get4ProductReservable) > 0 ? 1 : 0;
        $requestCount = $this->informationRequest->countByShop($shopId);
        $userRequested = $this->informationRequest->findByShop($shopId, ['id'])->count() ? true : false;

        view()->share('breadcrumb', (new \App\Builders\ShopPagesBreadcrumbBuilder(compact('shopId', 'shop', 'region', 'subRegion')))->build());
        if ($this->isMobile) {
          if ($amp_data) {
            $amp_data = $this->shopService->getAndConvertDataFromShop($shop);
            return view('shop.' . $this->path . 'amp', compact('shopId','amp_data', 'listShop',  'shop', 'offTimes', 'numCoupon', 'numPhoto', 'comments', 'count', 'postReviewUrl', 'shopImages', 'region', 'subRegion', 'productReservable', 'requestCount', 'userRequested', 'products', 'get4ProductReservable'));
          }
            return view('shop.' . $this->path . 'index', compact('shopId','listShop',  'shop', 'offTimes', 'numCoupon', 'numPhoto', 'comments', 'count', 'postReviewUrl', 'shopImages', 'region', 'subRegion', 'productReservable', 'requestCount', 'userRequested', 'products', 'get4ProductReservable'));
        } else {
            return view('shop.' . $this->path . 'index', compact('shopId','listShop', 'shop', 'numCoupon', 'numPhoto', 'comments', 'count', 'encodedCoordinate', 'products', 'postReviewUrl', 'parentRegions', 'citySiblings', 'shopImages', 'region', 'subRegion', 'productReservable', 'requestCount', 'userRequested'));
        }
    }

    /**
     * @author chuong
     * shop detail coupon
     * @param $id
     */
    public function coupon($id)
    {
        $shopId = $id;
        $shop = $this->shopService->getShopItem($shopId);

        $shop = new Shop($shop);
        if (empty($shop->exist())) {
            return $this->noShopSearch();
        }

        $coupons = (array) $shop->item->sweetsguide_coupon_informations;
        $numCoupon = count_not_null($coupons);
        list($products, $get4ProductReservable) = $this->getShopProducts($shopId);
        $productReservable = count($get4ProductReservable) > 0 ? 1 : 0;

        list($region, $subRegion) = $this->regionAdapter->getRegionAndSubRegionByShopItem($shop->item);
        $requestCount = $this->informationRequest->countByShop($shopId);
        $userRequested = $this->informationRequest->findByShop($shopId, ['id'])->count() ? true : false;

        view()->share('breadcrumb', (new \App\Builders\ShopPagesBreadcrumbBuilder(compact('shopId', 'shop', 'region', 'subRegion')))->build());

        return view('shop.' . $this->path . 'coupon', compact('shopId', 'shop', 'coupons', 'numCoupon', 'region', 'subRegion', 'productReservable', 'requestCount', 'userRequested'));
    }

    public function amp(Request $request, $id)
    {
      return self::index($request, $id, 'amp');
    }

    /**
     * @author chuong
     * shop detail menu
     * @param $id
     */
    public function menu(Request $request, $id)
    {
        $listParamShopMenu = $this->getListParamShopMenuPage($request, $id, $this->informationRequest);
        if ( isset($listParamShopMenu['status']) && $listParamShopMenu['status'] == BaseController::NO_SHOP ) {
            return $this->noShopSearch();
        }
        list($viewFile,
            $shopId,
            $products,
            $shop,
            $region,
            $subRegion,
            $paging,
            $numCoupon,
            $productReservable,
            $requestCount,
            $userRequested) = $listParamShopMenu;

        return view($viewFile, compact('shopId', 'products', 'shop', 'region', 'subRegion', 'paging', 'numCoupon', 'productReservable', 'requestCount', 'userRequested'));
    }

    /**
     * @author chuong
     * shop detail map
     * @param $id
     */
    public function map($id)
    {
        $listParamShopMap = $this->getListParamShopMapPage($id, $this->informationRequest);
        if ( isset($listParamShopMap['status']) && $listParamShopMap['status'] == BaseController::NO_SHOP ) {
            return $this->noShopSearch();
        }
        list($viewFile,
            $shopId,
            $shop,
            $region,
            $subRegion,
            $productReservable,
            $requestCount,
            $userRequested) = $listParamShopMap;
        return view($viewFile, compact('shopId', 'shop', 'region', 'subRegion', 'productReservable', 'requestCount', 'userRequested'));
    }

    public function comments(Request $request, $id)
    {
        // Stores shopId
        $shopId = $id;
        $params = $request->all();
        $count = 10;
        $page = !empty($request->page) ? $request->page : 1;
        $start = $count * ($page - 1) + 1;

        // Prepares query
        $query = [
            'disp_start' => $start,
            'disp_count' => $count,
            'order' => 'comment_date_desc', // Default parameter
        ];

        if ($request->has('order')) {
            $query['order'] = $request->order;
        }

        // Gets data
        list($shop, $shopComments) = $this->shopService->getShopItem($id, [
            'comments' => $query,
        ]);

        $numFound = $shopComments->num_found;
        $paging = $this->pagingAdapter->fromAPI($shopComments, $page, $count);
        $shop = new Shop($shop);

        if (empty($shop->exist())) {
            return $this->noShopSearch();
        }

        $postReviewUrl = $this->getPostReviewUrl($shopId, $shop->item->facility_name);

        list($region, $subRegion) = $this->regionAdapter->getRegionAndSubRegionByShopItem($shop->item);

        $coupons = (array) $shop->item->sweetsguide_coupon_informations;
        $numCoupon = count_not_null($coupons);
        list($products, $get4ProductReservable) = $this->getShopProducts($shopId);
        $productReservable = count($get4ProductReservable) > 0 ? 1 : 0;
        $requestCount = $this->informationRequest->countByShop($shopId);
        $userRequested = $this->informationRequest->findByShop($shopId, ['id'])->count() ? true : false;

        view()->share('breadcrumb', (new \App\Builders\ShopPagesBreadcrumbBuilder(compact('shopId', 'shop', 'region', 'subRegion')))->build());

        return view('shop.' . $this->path . 'comments', compact('shopId', 'shopComments', 'shop', 'numFound', 'postReviewUrl', 'region', 'subRegion', 'paging', 'params', 'numCoupon', 'productReservable', 'requestCount', 'userRequested'));
    }

    /**
     * Gets comment detailed
     *
     * @param Request $request
     * @param string $id
     * @param string $commentId
     *
     * @return response
     *
     * @author chuong
     * @modified thanhnt1@greenglobal.vn
     */
    public function commentDetail(Request $request, $id, $commentId)
    {
        $shopId = $id;
        list($shop, $comment) = $this->shopService->getShopItem($id, [
            'comment' => [
                'comment_id' => $commentId,
            ],
        ]);
        if (empty($shop->item) || empty($comment->items)) {
            return $this->noShopSearch();
        }
        list($region, $subRegion) = $this->regionAdapter->getRegionAndSubRegionByShopItem($shop->item);

        view()->share('breadcrumb', (new \App\Builders\ShopPagesBreadcrumbBuilder(compact('shopId', 'shop', 'comment', 'region', 'subRegion')))->build());

        return view('shop.' . $this->path . 'comment-detail', compact('shopId', 'shop', 'comment', 'commentId', 'region', 'subRegion'));
    }

    public function likeComment(Request $request)
    {
        $commentId = $request->commentId;
        $query = [
            'comment_id' => $commentId,
            'cookie_val' => $request->_token,
            'count' => 1,
        ];
        $comment = $this->commentService->addReferenceCount($query)->getBody();
        if ('1' == $comment->status) {
            $data = $comment->item->reference_count;
            return json_encode($data);
        }
    }

    /**
     * Get menu widget from shop
     * @param  Request $request
     * @param  mixed  $id
     */
    public function widget(Request $request, $id)
    {
        // Get all products from API
        $start = 0;
        $rows = 50;
        $count = $request->count;
        if (is_numeric($count)) {
            if ($count < 0 || $count > 50) {
                $count = 50;
            }
        } else {
            $count = 50;
        }
        $params = [
            'shop_id' => $id,
            'sort' => 0,
            'rows' => $rows,
            'start' => $start,
        ];
        $productsReservable = [];
        $countFlg = 0;
        if ($count > 0) {
            do {
                $products = $this->productService->getProductSearch($params);
                if (!empty($products->items && !empty($products->num_found) && $products->num_found > 0) ) {
                    $numFound = $products->num_found;
                    foreach ($products->items as $value) {
                        if ('1' == $value->reservation_flg) {
                            $productsReservable[] = $value;
                            $countFlg = count($productsReservable);
                            if ($countFlg >= $count) {
                                break;
                            }
                        }
                    }
                    $params['start'] += $rows;
                    if ($params['start'] > $numFound) {
                        break;
                    }
                } else {
                    break;
                }
            } while ($countFlg < $count);
        }
        return view('shop.widget', compact('productsReservable'));
    }

    public function getLatestReviewOfShop(Request $request)
    {
        $shopId = $request->shopId;
        $promises = [
            $this->commentService->searchAsync(['target_id' => $shopId, 'disp_fg' => 1, 'order' => 'comment_date_desc'])->getResponse(),
        ];
        $results = \GuzzleHttp\Promise\unwrap($promises);
        $latestReview = json_decode($results[0]->getBody());
        $content = '';
        if (isset($latestReview->items[0])) {
            $content = $latestReview->items[0]->content;
            if ($this->isMobile) {
                $content = subString($content, 24);
            } else {
                $content = subString($content, 30);
            }
        }
        return $content;
    }

    public function getListShop($query)
    {
        $promises = [
            $this->shopService->searchAsync($query)->getResponse(),
        ];
        $results = \GuzzleHttp\Promise\unwrap($promises);
        return json_decode($results[0]->getBody());
    }
}
