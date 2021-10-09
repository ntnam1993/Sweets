<?php
namespace App\Http\Controllers;

use App\Adapters\RegionAdapter;
use App\Region;
use App\Review;
use App\Services\CashpoService;
use App\Services\CommentService;
use App\Services\CouponService;
use App\Services\ProductService;
use App\Services\ShopService;
use App\Shop;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    const COUPON_TYPE_AVALIABLE = 1;

    protected $regionAdapter;
    protected $shopService;
    protected $productService;
    protected $cashpoService;
    protected $couponService;

    public function __construct(
        RegionAdapter $regionAdapter,
        ShopService $shopService,
        CommentService $commentService,
        ProductService $productService,
        CashpoService $cashpoService,
        CouponService $couponService
    ) {
        parent::__construct();

        $this->regionAdapter = $regionAdapter;
        $this->shopService = $shopService;
        $this->commentService = $commentService;
        $this->productService = $productService;
        $this->cashpoService = $cashpoService;
        $this->couponService = $couponService;
    }

    /**
     * Gets product detail
     *
     * @param Request $request
     * @param string $id
     *
     * @author chuong
     * @modified thanhnt1@greenglobal.vn
     */
    public function detail(Request $request, $id, $amp_data = null)
    {
        $getListParamProductPage = $this->getListParamProductPage($request, $id);
        if (!empty($getListParamProductPage['status'])) {
            return $this->noShopSearch();
        }
        list($parentAndChildProducts,
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
            $redirectParrentId) = $getListParamProductPage;

        if ($redirectParrentId) {
            return redirect(route('product.detail', ['id' => $redirectParrentId]), 301);
        }

        if ($amp_data) {
          $amp_data = $this->productService->getAndConvertDataFromProduct($item, $shop);
          $data = compact('amp_data','parentAndChildProducts', 'isMobile', 'get4ProductReservable', 'isLogin', 'item', 'shop', 'productId', 'comments', 'shopId', 'postReviewUrl', 'viewedProducts', 'citySiblings', 'region', 'subRegion', 'numCoupon', 'categoryProduct1', 'couponCode');
          return response(view('product.' . $this->path . 'amp', $data))
              ->withCookie($cookie);
        }

        //new flow check cashpo and coupon, task 2315
        $cashpo = 0;
        $cashpoExpireDate = 0;
        $dataJsonCouponCashpo = json_encode([]);
        if ($isLogin) {
            if ($shop->item->epark_payment_use_flag != Shop::SHOP_CAN_NOT_PAY_IN_EPARK) {
                list($cashpo, $cashpoExpireDate) = $this->cashpoService->getCashpo($this->accessToken, $this->eparkMemberId);
                $cashpoExpireDate = calculateExpireDate($cashpoExpireDate);
                $shopCoupon = $this->couponService->getMembersCoupon(['shop_id' => $shopId], $this->eparkMemberId)->getBody();
                if ($shopCoupon->status == Shop::STATUS_USER_HAVE_COUPON) {
                    $dataJsonCouponCashpo = $this->firstChooseCoupon($shopCoupon->data, $parentAndChildProducts);
                }
            }else{
                $shopCoupon = $this->couponService->getMembersCoupon(['shop_id' => $shopId], $this->eparkMemberId)->getBody();
                if ($shopCoupon->status == Shop::STATUS_USER_HAVE_COUPON) {
                    $dataJsonCouponCashpo = $this->firstChooseCoupon($shopCoupon->data, $parentAndChildProducts, true);
                }
            }
        }
        $data = compact('parentAndChildProducts', 'isMobile', 'get4ProductReservable', 'isLogin', 'item', 'shop', 'productId', 'comments', 'shopId', 'postReviewUrl', 'viewedProducts', 'citySiblings', 'region', 'subRegion', 'numCoupon', 'categoryProduct1', 'couponCode','dataJsonCouponCashpo', 'cashpo', 'cashpoExpireDate');
        return response(view($viewFile, $data))
            ->withCookie($cookie);
    }
    public function firstChooseCoupon($shopCoupons, $parentAndChildProducts, $shopCanNotPayInEpark = false)
    {
        if (count($parentAndChildProducts)) {
            $dataCouponCashpo = [];
            foreach($parentAndChildProducts as $parentAndChildProduct) {
                $dataCouponCashpo[$parentAndChildProduct['product_id']] = [
                        'cashpo_coupons' => [],
                        'direct_coupons' => []
                    ];
                foreach($shopCoupons as $shopCoupon) {
                    $parentAndChildProduct['product_price'] = $parentAndChildProduct['product_price'] ? $parentAndChildProduct['product_price'] : 0;
                    if (!$this->checkCouponAvaliable($shopCoupon, $parentAndChildProduct['product_price'])) {
                        continue;
                    }
                    if (!$shopCanNotPayInEpark) {
                        if ($shopCoupon->discount_type == Shop::COUPON_TYPE_SAVE_CASHPO) {
                            $dataCouponCashpo = $this->cashpoService->processSaveCouponCashpo($dataCouponCashpo, $shopCoupon, $parentAndChildProduct);
                        }else{
                            $dataCouponCashpo = $this->cashpoService->processSaveDirectCoupon($dataCouponCashpo, $shopCoupon, $parentAndChildProduct);
                        }
                    }else{
                        if ($shopCoupon->discount_type == Shop::COUPON_TYPE_SAVE_CASHPO) {
                            $dataCouponCashpo = $this->cashpoService->processSaveCouponCashpo($dataCouponCashpo, $shopCoupon, $parentAndChildProduct);
                        }
                    }
                }
            }
            return json_encode($dataCouponCashpo);
        }
        return json_encode([]);
    }
    public function checkCouponAvaliable($shopCoupon, $productPrice)
    {
        return isset($shopCoupon->coupon_type)
            && $shopCoupon->coupon_type == self::COUPON_TYPE_AVALIABLE
            && strtotime($shopCoupon->coupon_validity_period_start) < time()
            && time() < strtotime($shopCoupon->coupon_validity_period_end)
            && $productPrice >= $shopCoupon->available_price;
    }

    public function amp(Request $request, $id)
    {
      return self::detail($request, $id, 'amp');
    }

    public function commentsProduct(Request $request, $id)
    {
        $item = $this->productService->getProductItem($id);
        if (empty($item->item)) {
            abort(500);
        }
        if (!isset($item->item) && count($item->item)) {
            return $this->noShopSearch();
        }
        $shopId = $item->item->shop_id;
        return redirect(route('shop.comments', $shopId), 301);
    }

    public function commentDetail(Request $request, $id, $commentId)
    {
        $item = $this->productService->getProductItem($id);
        if (empty($item->item)) {
            abort(500);
        }
        if (!isset($item->item) && count($item->item)) {
            return $this->noShopSearch();
        }
        $shopId = $item->item->shop_id;
        return redirect(route('shop.comments', $shopId), 301);
    }

    public function likeComment(Request $request)
    {
        $commentId = $request->commentId;
        $serviceId = $request->dataServiceId;
        if ('sweetsshop' == $serviceId) {
            $auth_code = env('SHOP_AUTH_CODE');
        } else {
            $auth_code = env('SWEETS_AUTH_CODE');
        }
        $query = [
            'auth_code' => $auth_code,
            'shopowner_id' => env('SHOP_OWNER_ID'),
            'service_id' => $serviceId,
            'comment_id' => $commentId,
            'cookie_val' => $request->_token,
            'count' => 1,
        ];
        try {
            $comment = $this->commentService->addReferenceCount($query)->getBody();
            if ('1' != $comment->status) {
                throw new \Exception();
            }
            $data = $comment->item->reference_count;
            return json_encode($data);
        } catch (\Exception $e) {
            return json_encode(false);
        }
    }

    public function getOtherItemOfShop(Request $request)
    {
        $productId = $request->productId;
        $query = [
            'rows' => 6,
            'sort' => 0,
            'shop_id' => $request->shopId,
        ];
        $products = $this->productService->getProductSearch($query);
        if (!isset($products->items) || '0' != $products->status) {
            return '';
        }
        return view('product.' . $this->path . 'other-product-of-shop', compact('products', 'productId'));
    }

    public function getProductItem(Request $request, $productId)
    {
        $params = ['visit_reservation' => 1];
        $item = $this->productService->getProductItem($productId, $params);
        if (!isset($item->item) || '0' != $item->status) {
            return response()->json([]);
        }
        return response()->json($item);
    }

    public function checkReceiptDate(Request $request)
    {
        $productId = $request->product_id;
        $diffLatestReceiptDate = $this->getDiffLatestReceiptDate($productId);
        $reservable = $diffLatestReceiptDate['reservable'];
        $firstReceiptDate = $diffLatestReceiptDate['firstReceiptDate'];
        $listDateReserve = $diffLatestReceiptDate['listDateReserve'];
        return response()->json(['firstReceiptDate' => $firstReceiptDate, 'reservable' => $reservable, 'listDateReserve' => $listDateReserve]);
    }
}
