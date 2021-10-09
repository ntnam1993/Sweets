<?php
namespace App\Http\Controllers;

use App\Adapters\RegionAdapter;
use App\Region;
use App\Review;
use App\Services\CommentService;
use App\Services\ProductService;
use App\Services\ShopService;
use App\Shop;
use Illuminate\Http\Request;

class FloprestigeProductController extends BaseController
{
    const EXPIRED_COOKIE = 90 * 24 * 60; // 90 days

    protected $regionAdapter;
    protected $shopService;
    protected $productService;

    public function __construct(
        RegionAdapter $regionAdapter,
        ShopService $shopService,
        CommentService $commentService,
        ProductService $productService
    ) {
        parent::__construct();

        $this->regionAdapter = $regionAdapter;
        $this->shopService = $shopService;
        $this->commentService = $commentService;
        $this->productService = $productService;
    }

    /**
     * Gets product detail
     *
     * @param Request $request
     * @param string $id
     *
     * @author chuong
     * @modified nam.nt@neo-lab.vn
     */
    public function detail(Request $request, $shop_id, $id)
    {
        $getListParamProductPage = $this->getListParamProductPage($request, $id, true);
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
            return redirect(route('floprestige.shop.detail', ['shop_id' => $shop_id, 'product_id' => $redirectParrentId]), 301);
        }

        $data = compact('parentAndChildProducts', 'isMobile', 'get4ProductReservable', 'isLogin', 'item', 'shop', 'productId', 'comments', 'shopId', 'postReviewUrl', 'viewedProducts', 'citySiblings', 'region', 'subRegion', 'numCoupon', 'categoryProduct1', 'couponCode');

        return response(view($viewFile, $data))
            ->withCookie($cookie);
    }

    public function getOtherItemOfShop(Request $request)
    {
        $productId = $request->productId;
        $item = $this->productService->getProductItem($productId);
        $shopId = $item->item->shop_id;
        $query = [
            'rows' => 6,
            'sort' => 0,
            'shop_id' => $request->shopId,
        ];
        $products = $this->productService->getProductSearch($query);
        if (!isset($products->items) || '0' != $products->status) {
            return '';
        }
        return view('floprestige.' . $this->path . 'other-product-of-shop', compact('products', 'productId', 'shopId'));
    }
}
