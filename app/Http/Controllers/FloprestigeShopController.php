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

class FloprestigeShopController extends BaseController
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

    public function menu(Request $request, $id)
    {
        $listParamShopMenu = $this->getListParamShopMenuPage($request, $id, $this->informationRequest, true);
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
            $productReservable,
            $requestCount,
            $userRequested) = $listParamShopMenu;

        return view($viewFile, compact('shopId', 'products', 'shop', 'region', 'subRegion', 'paging', 'productReservable', 'requestCount', 'userRequested'));
    }

    public function map($id)
    {
        $listParamShopMap = $this->getListParamShopMapPage($id, $this->informationRequest, true);
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
}
