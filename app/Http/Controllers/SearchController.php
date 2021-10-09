<?php

namespace App\Http\Controllers;

use App\Adapters\PagingAdapter;
use App\Adapters\ShopSearchAdapter;
use App\Adapters\TitleDescriptionKeywordH1Adapter;
use App\Category;
use App\Keyword;
use App\Region;
use App\Services\CommentService;
use App\Services\CouponService;
use App\Services\KeywordService;
use App\Services\ProductService;
use App\Services\SearchService;
use App\Services\ShopService;
use App\Shop;
use App\Station;
use Exception;
use Illuminate\Http\Request;
use Log;
use Route;
use App\Repositories\Eloquents\InformationRequestEloquent;

class SearchController extends BaseController
{

    protected $pagingAdapter;
    protected $productService;
    protected $shopService;
    protected $commentService;
    protected $couponService;
    protected $keywordService;
    protected $searchService;

    const JAVASCRIPT_TIMEOUT_RSS = 10000; // 10s

    public function __construct(
        PagingAdapter $pagingAdapter,
        ShopService $shopService,
        CommentService $commentService,
        ProductService $productService,
        CouponService $couponService,
        TitleDescriptionKeywordH1Adapter $titleDescriptionKeywordH1Adapter,
        ShopSearchAdapter $shopSearchAdapter,
        InformationRequestEloquent $informationRequest,
        KeywordService $keywordService,
        SearchService $searchService
    ) {
        parent::__construct();

        $this->pagingAdapter = $pagingAdapter;
        $this->shopService = $shopService;
        $this->commentService = $commentService;
        $this->productService = $productService;
        $this->couponService = $couponService;
        $this->titleDescriptionKeywordH1Adapter = $titleDescriptionKeywordH1Adapter;
        $this->shopSearchAdapter = $shopSearchAdapter;
        $this->informationRequest = $informationRequest;
        $this->keywordService = $keywordService;
        $this->searchService = $searchService;
    }

    /**
     * @author chuong
     * search index
     */
    public function index(Request $request)
    {
        if ($this->isMobile) {
            return $this->processFormSearch($request);
        }
        return redirect('/');
    }

    /**
     * @author chuong
     * search regions
     * @param $id
     */
    public function regions()
    {
        $productCategories = Category::mainCategories()->orderBy('order_no')->get();
        $regions = Region::mainCategories()->orderBy('order_no')->get();
        $dataRegions = $this->getRootRegions();
        return view('search.' . $this->path . 'regions', compact('dataRegions', 'regions', 'productCategories'));
    }

    /**
     * @author chuong
     * search current location
     * @param $id
     */
    public function currentLocation(Request $request)
    {
        $productCategories = Category::mainCategories()->orderBy('order_no')->get();
        $regions = Region::mainCategories()->orderBy('order_no')->get();
        $dataRegions = $this->getRootRegions();
        return view('search.' . $this->path . 'current-location', compact('dataRegions', 'productCategories', 'regions'));
    }

    public function getLocation(Request $request)
    {
        $coordinates = [
            'min_latitude' => $request->data[2][0],
            'min_longitude' => $request->data[2][1],
            'max_latitude' => $request->data[1][0],
            'max_longitude' => $request->data[1][1],
        ];

        return json_encode($coordinates);
    }

    public function prefectures()
    {
        $prefectures = Station::prefectures()->orderBy('prov_rank_no')->get();
        return view('search.' . $this->path . 'prefecture', compact('prefectures'));
    }

    public function railLines($prefectureId)
    {
        $railLines = Station::railLines($prefectureId)
            ->orderBy('rail_line_rank_no')
            ->get();

        return view('search.' . $this->path . 'rail-line', compact('railLines', 'prefectureId'));
    }

    /**
     * @author chuong
     * search station
     * @param $id
     */
    public function stations($prefectureId, $railLineId)
    {
        $stations = Station::stations($prefectureId, $railLineId)
            ->orderBy('station_rank_no')
            ->get();

        return view('search.' . $this->path . 'station', compact('stations'));
    }

    /**
     * @author chuong
     * get list product
     */

    public function lists(Request $request, $region = null, $sub_region = null, $stationId = null)
    {
        $parentRegionId = isset($region) ? $region->id : '';
        $subRegionId = isset($sub_region) ? $sub_region->id : '';
        $regionId = !empty($subRegionId) ? $subRegionId : $parentRegionId;
        $region = $regionId;
        $productCategories = Category::mainCategories()->orderBy('order_no')->get();
        $regions = Region::mainCategories()->orderBy('order_no')->get();
        $dataRegions = $this->getRootRegions();

        list($query,$page,$rows, $productLimit) = $this->searchService->processParamForProductSearch($request, $stationId, $region);

        $promises = [
            $this->productService->requestAsyncProductGroupSearch($query),
        ];
        $results = \GuzzleHttp\Promise\unwrap($promises);
        $products = json_decode($results[0]->getBody());

        if ('0' != $products->status) {
            abort(404);
        }

        $paging = $this->pagingAdapter->fromAPI($products, $page, $rows);

        $prefectures = Station::prefectures()->orderBy('prov_rank_no')->get();

        // Responses
        $viewFile = 'product.' . $this->path . 'lists';
        $params = $request->all();
        $javascriptTimeoutRss= self::JAVASCRIPT_TIMEOUT_RSS;

        // Get area, genre, station, cakesize from search request

        list($regionName, $parentRegion) = $this->searchService->getInforSearchWithParentRegion($parentRegionId);

        list($provCode, $provName, $searchResult, $station, $region) = $this->searchService->getInforSearchWithRegion($regionId, $parentRegionId);

        list($region,$regionName, $parentRegionId, $parentRegionName, $stationProvCode, $stationRailLineId, $stationName, $railLineName, $provName, $searchResult, $parentRegion, $station) = $this->searchService->getInforSearchWithStation($stationId, $regionName, $searchResult, $parentRegion, $station, $parentRegionId, $provName, $region);

        list($categoryId, $parentCategoryId, $parentCategoryLevel, $parentCategoryName, $searchResult) = $this->searchService->getInforSearchWithGenre($params, $searchResult);

        if ($region != null || $sub_region != null || $stationId != null || $region != null) {
            unset($request['pos']);
            unset($request['current_location']);
        }

        for ($i = 3; $i <= 11; $i++) {
            if (!empty($params['size' . $i])) {
                $cakeSize[] = $i . '号';
                $searchResult['size'] = implode(',', $cakeSize);
            }
        }
        //to identify that this is the product list page
        $isProdList = true;

        // Get full url except 'keyword' param
        $output = $request->except('keyword');
        $fullUrlExceptKeyword = $request->fullUrl();
        if (!empty($output)) {
            $fullUrlExceptKeyword = $request->fullUrlWithQuery($output);
        }

        $searchLink = $this->getShopSearchLink();
        $headingStatement = $this->getSearchTitle($searchResult, $stationName, $regionName, false);
        $regionsSidebar = $this->getSidebarList();
        $output = request()->all();
        // build canonical Url
        $allowedParamsForCanonical = ['genre_id', 'keyword', 'sort', 'reserve'];
        $canonicalParams = array_filter($output, function ($key) use ($allowedParamsForCanonical) {
            return in_array($key, $allowedParamsForCanonical);
        }, ARRAY_FILTER_USE_KEY);

        $data = compact('fullUrlExceptKeyword', 'stationId', 'regionId', 'prefectures', 'paging', 'dataRegions', 'products', 'productCategories', 'regions', 'params', 'searchResult', 'parentRegion', 'searchParams', 'regionName', 'parentRegionName', 'parentRegionId', 'category', 'parentCategory', 'categoryId', 'parentCategoryId', 'parentCategoryLevel', 'parentCategoryName', 'stationProvCode', 'stationRailLineId', 'stationName', 'railLineName', 'provName', 'provCode', 'rootName', 'isProdList', 'productLimit', 'searchLink', 'headingStatement', 'regionsSidebar', 'region', 'canonicalParams', 'javascriptTimeoutRss');

        // Building breadcrumb items
        view()->share('breadcrumb', (new \App\Builders\ProductSearchBreadcrumbBuilder($data))->build());

        $titleDescriptionKeywordH1 = $this->titleDescriptionKeywordH1Adapter->getTitleDescriptionKeywordH1ForSearch($request, $data);
        $data['titleDescriptionKeywordH1'] = $titleDescriptionKeywordH1;
        $this->setCookieDataSearch($data);
        return [
            'view' => $viewFile,
            'data' => $data,
        ];
    }

    public function getShopSearchLink()
    {
        $current_route_name = \Route::currentRouteName();
        $searchLink = '';
        $routeParams = [];
        $queryExcepted = fullQueryOnly(['region', 'sub_region', 'station', 'keyword', 'genre_id', 'reservation_flag']);
        if ('product.index.all' == $current_route_name) {
            $searchLink = route('shopsearch.all');
        } elseif ('product.index.station' == $current_route_name) {
            $routeParams['station'] = request()->route('station');
            $searchLink = route('shopsearch.station', $routeParams);
        } elseif ('product.index' == $current_route_name) {
            $routeParams['region'] = request()->route('region');
            $routeParams['sub_region'] = request()->route('sub_region');
            $searchLink = route('shopsearch.region', $routeParams);
        }
        if (!empty($searchLink) && !empty($queryExcepted)) {
            $searchLink .= '?' . $queryExcepted;
        }
        return $searchLink;
    }

    private function checkRedirectWithPageParam($currentPage, $allItem, $data, $params, $routeRedirect)
    {
        $url = '';
        if ($allItem > 0) {
            $numPage = $data['data']['paging']['numPage'];
            if ($currentPage >= $numPage) {
                $params = checkPaginateForList($params, $data, $numPage, $allItem);
                if (!empty($params['status'])) {
                    $url = route($routeRedirect, $params['params']);
                }
            } elseif ($currentPage < 1) {
                unset($params['page']);
                $url = route($routeRedirect, $params);
            }
        }elseif ($currentPage != 1) {
            $params['page'] = 1;
            $url = route($routeRedirect, $params);
        }

        if ($url != '') {
            return [
                'redirect' => true,
                'url'      => $url
            ];
        }else{
            return '';
        }

    }

    public function searchAll(Request $request)
    {
        $data = $this->lists($request);
        $params = $request->all();
        $allItem = $data['data']['products']->num_found;
        if ($request->has('page')) {
            $result = $this->checkRedirectWithPageParam($request->page, $allItem, $data, $params,'product.index.all');
            if (is_array($result) && !empty($result['redirect'])) {
                return redirect($result['url']);
            }
        }
        if ($request->ajax()) {
            return $data;
        }
        return view($data['view'], $data['data']);
    }

    public function searchByRegion(Request $request, $regionSlug, $sub_regionSlug = null)
    {
        $sub_region = null;
        $region = Region::where('slug', $regionSlug)->where('level', 1)->first();
        if (empty($region)) {
            abort(404);
        }

        if (!empty($sub_regionSlug)) {
            $sub_region = Region::where('slug', $sub_regionSlug)->where('level', 2)->where('parent_region_category_id', $region->region_category_id)->first();
            if (empty($sub_region)) {
                abort(404);
            }
        }

        $data = $this->lists($request, $region, $sub_region);
        $params = $request->all();
        $allItem = $data['data']['products']->num_found;
        if ($request->has('page')) {
            $params['region'] = $regionSlug;
            $params['sub_region'] = !empty($sub_regionSlug) ? $sub_regionSlug : '';
            $result = $this->checkRedirectWithPageParam($request->page, $allItem, $data, $params,'product.index');
            if (is_array($result) && !empty($result['redirect'])) {
                return redirect($result['url']);
            }
        }
        if ($request->ajax()) {
            return $data;
        }
        return view($data['view'], $data['data']);
    }

    public function searchByStation(Request $request, $stationId)
    {
        $data = $this->lists($request, $region = null, $sub_region = null, $stationId);
        $params = $request->all();
        $allItem = $data['data']['products']->num_found;
        if ($request->has('page')) {
            $params['station'] = $stationId;
            $result = $this->checkRedirectWithPageParam($request->page, $allItem, $data, $params,'product.index.station');
            if (is_array($result) && !empty($result['redirect'])) {
                return redirect($result['url']);
            }
        }
        if ($request->ajax()) {
            return $data;
        }
        return view($data['view'], $data['data']);
    }

    public function getRailLinesById(Request $request)
    {
        $station = $prefectureId = $provName = $rootStationName = '';

        if (!empty($request->station_id)) {
            $station = Station::where('station_id', $request->station_id)->first();
        }

        if (!empty($station)) {
            $prefectureId = $station->prov_code;
            $provName = $station->prov_name;
        }

        $rootStations = $this->getRootStation();
        foreach ($rootStations as $values) {
            foreach ($values as $val) {
                if ($val['prov_code'] == $prefectureId) {
                    $rootStationName = $val['root'];
                }
            }
        }

        $railLines = Station::railLines($prefectureId)
            ->orderBy('rail_line_rank_no')
            ->get();
        $viewBlade = ($request->isTopPC) ? 'rail-lines' : 'rail-lines';
        return view('home.' . $this->path . $viewBlade, compact('railLines', 'prefectureId', 'rootStationName', 'provName'));
    }

    public function listsShop(Request $request, $region = null, $sub_region = null, $stationId = null)
    {
        $parentRegionId = isset($region) ? $region->id : '';
        $subRegionId = isset($sub_region) ? $sub_region->id : '';
        $regionId = !empty($subRegionId) ? $subRegionId : $parentRegionId;
        $region = $regionId;
        $start = 0;
        $rows = 20;
        $no_cp_coupon = '';

        // condition for station and freeword
        $keyword = $request->has('keyword') ? $request->keyword : '';
        $sort = $request->has('sort') ? $request->sort : 3;
        $reservation_flag = $request->has('reservation_flag') ? $request->reservation_flag : '';
        $epark_payment_use_flag = $request->has('epark_payment_use_flag') ? $request->epark_payment_use_flag : '';

        $query = [
            'catg' => $region,
            'keyword' => $keyword,
            'reservation_flag' => $reservation_flag,
            'epark_payment_use_flag' => $epark_payment_use_flag,
            'sort' => $sort,
            'start' => $start,
            'genre_id' => $request->genre_id,
            'rows' => $rows,
            'fields' => 'catalog_id,catalog_name,page_title,meta_keyword,meta_description,post_code,prov_code,city,district,building_name,addr_latitude,addr_longitude,related_links_title1,related_links_url1,related_links_title2,related_links_url2,related_links_title3,related_links_url3,related_links_title4,related_links_url4,train_line1,station1,exit_station1,means1,time_required1,train_line2,station2,exit_station2,means2,time_required2,train_line3,station3,exit_station3,means3,time_required3,train_line4,station4,exit_station4,means4,time_required4,train_line5,station5,exit_station5,means5,time_required5,catch_copy,list_comment,coupon_tab,main_image_s,comment_num,comment_evaluate_total,calendar_comment,introdyctory_essay,epark_payment_use_flag,shop_shopowner_id,contract_tp,prov_name,compatible_service,handled_product,main_image_url,images_url,ppc_data,start_time1,end_time1,monday1,tuesday1,wednesday1,thursday1,friday1,saturday1,sunday1,holiday1,start_time2,end_time2,monday2,tuesday2,wednesday2,thursday2,friday2,saturday2,sunday2,holiday2,start_time3,end_time3,monday3,tuesday3,wednesday3,thursday3,friday3,saturday3,sunday3,holiday3,start_time4,end_time4,monday4,tuesday4,wednesday4,thursday4,friday4,saturday4,sunday4,holiday4,main_image_url',
        ];
        if ($reservation_flag) {
            $query['reservation_flag'] = $request->reservation_flag;
        }

        if (!empty($request->epark_payment_use_flag)) {
            $query['epark_payment_use_flag'] = $request->epark_payment_use_flag;
        }

        if (!empty($stationId)) {
            $query['station'] = $stationId;
        }
        $page = $request->page;
        if ($page > 0) {
            $start = ($rows * $page) - 20;
        }
        $query['start'] = $start;

        // Send API for searching shops
        if ($request->has('cp_code')) {
            // Get coupon for shopsearch follow cp_code
            $cpCode = $request->cp_code;
            $coupon = $this->couponService->getCoupon($cpCode)->getBody();
            if ( '0' != $coupon->status && !('400' == $coupon->status && ( $coupon->errors->code == "5232" || $coupon->errors->code == "5234") ) ) {
                $coupon = null;
            }
            $query['cp_code'] = $request->cp_code;
        }

        $shops = $this->getListShop($query);
        $javascriptTimeoutRss= self::JAVASCRIPT_TIMEOUT_RSS;
        if (!isset($shops->items) || '0' !== $shops->status) {
            abort(404);
        }
        $paging = $this->pagingAdapter->fromAPI($shops, $page, $rows);
        $prefectures = Station::prefectures()->orderBy('prov_rank_no')->get();
        $dataRegions = $this->getRootRegions();
        // Get area, genre, station, cakesize from search request
        $params = $request->all();

        list($regionName, $parentRegion) = $this->searchService->getInforSearchWithParentRegion($parentRegionId);

        list($provCode, $provName, $searchResult, $station, $region) = $this->searchService->getInforSearchWithRegion($regionId, $parentRegionId);

        list($region,$regionName, $parentRegionId, $parentRegionName, $stationProvCode, $stationRailLineId, $stationName, $railLineName, $provName, $searchResult, $parentRegion, $station) = $this->searchService->getInforSearchWithStation($stationId, $regionName, $searchResult, $parentRegion, $station, $parentRegionId, $provName, $region);

        list($categoryId, $parentCategoryId, $parentCategoryLevel, $parentCategoryName, $searchResult) = $this->searchService->getInforSearchWithGenre($params, $searchResult);

        if ($region != null || $sub_region != null || $stationId != null || $region != null) {
            unset($request['pos']);
            unset($request['current_location']);
        }

        if (request()->has('pos')) {
            $queryString = $this->searchService->searchShopWithPosParam($request, $query, $sub_region);
            $shops = $this->getListShop($queryString);
            $page = $request->page;

            $paging = $this->pagingAdapter->fromAPI($shops, $page, $rows);
        }
        // Link to product search
        $searchLink = $this->getProductSearchLink();

        if (request()->has('map_search')) {
            $map_search = view('shop.mobile.partials.map_shop_modal', compact('shops'))->render();
        }

        $headingStatement = $this->getSearchTitle($searchResult, $stationName, $regionName);

        if ($this->isMobile && ('current-location' == $request->next || "1" == $request->map)) {
            $infoShopSearch['infoShopSearch'] = $shops;
            $data = compact('dataRegions', 'prefectures', 'shops', 'stationId', 'regionId', 'paging', 'searchResult', 'parentRegion', 'regionName', 'parentRegionName', 'parentRegionId', 'categoryId', 'parentCategoryId', 'parentCategoryLevel', 'parentCategoryName', 'stationProvCode', 'stationRailLineId', 'stationName', 'railLineName', 'provName', 'provCode', 'region', 'coupon', 'searchLink', 'map_search', 'station', 'headingStatement', 'sub_region');
            $titleDescriptionKeywordH1 = $this->titleDescriptionKeywordH1Adapter->getTitleDescriptionKeywordH1ForShopSearch($request, $data);
            $data['titleDescriptionKeywordH1'] = $titleDescriptionKeywordH1;

            // Building breadcrumb items
            view()->share('breadcrumb', (new \App\Builders\ShopSearchBreadcrumbBuilder($data))->build());

            $viewFile = 'shop.' . $this->path . 'search-map';
            return [
                'view' => $viewFile,
                'data' => $data,
            ];
        }
        $productCategories = Category::mainCategories()->orderBy('order_no')->get();


        // Regions list
        $regionsSidebar = $this->getSidebarList();
        // Produces shop category list for each shop item
        $shopCategories = [];

        if (!empty($shops->items)) {
            $shopCategories = $this->shopSearchAdapter->categoriesByShops($shops->items);
            // Get data for request button
            $shopInfoRequestButton = $this->getInfoRequestButton($shops->items);
        }
        $data = compact('dataRegions', 'prefectures', 'shops', 'stationId', 'regionId', 'paging', 'searchResult', 'parentRegion', 'regionName', 'parentRegionName', 'parentRegionId', 'categoryId', 'parentCategoryId', 'parentCategoryLevel', 'parentCategoryName', 'stationProvCode', 'stationRailLineId', 'stationName', 'railLineName', 'provName', 'provCode', 'productCategories', 'searchLink', 'headingStatement', 'regionsSidebar', 'region', 'coupon', 'shopCategories','shopInfoRequestButton', 'map_search', 'station', 'sub_region', 'no_cp_coupon', 'javascriptTimeoutRss', 'params');
        $titleDescriptionKeywordH1 = $this->titleDescriptionKeywordH1Adapter->getTitleDescriptionKeywordH1ForShopSearch($request, $data);
        $data['titleDescriptionKeywordH1'] = $titleDescriptionKeywordH1;

        // Building breadcrumb items
        view()->share('breadcrumb', (new \App\Builders\ShopSearchBreadcrumbBuilder($data))->build());
        $viewFile = 'shop.' . $this->path . 'lists';
        $this->setCookieDataSearch($data);
        return [
            'view' => $viewFile,
            'data' => $data,
        ];
    }

    public function getListShop($query)
    {
        $promises = [
            $this->shopService->searchAsync($query)->getResponse(),
        ];
        $results = \GuzzleHttp\Promise\unwrap($promises);
        return json_decode($results[0]->getBody());
    }

    public function getSidebarList()
    {
        $current_route_name = \Route::currentRouteName();
        if (in_array($current_route_name, ['shopsearch.all', 'product.index.all'])) {
            return [];
        }
        if (in_array($current_route_name, ['product.index.station', 'shopsearch.station'])) {
            $station = Station::where('station_id', request()->route('station'))->first();
            if (empty($station)) {
                return [];
            }
            $region = $station->region;
        } else {
            $region = request()->route('region');
            $region = Region::where('slug', $region)->first();
        }

        if (empty($region)) {
            return [];
        }

        $stations = $region->stations()->ordered()->get(['station_id', 'station_name'])->groupBy('station_name')->map(
            function ($item) {
                return $item->first();
            }
        );
        // Not Tokyo, Kanagawa, Saitama
        if (
            !in_array($region->region_category_id, [50, 56, 780, 783]) &&
            !in_array($region->parent_region_category_id, [780, 783])
        ) {
            $subRegions = $region->subRegions();
            return [
                'subRegions' => $subRegions,
                'stations' => $stations,
            ];
        } else {
            if (in_array($region->region_category_id, [50, 56])) {
                return [
                    'subRegions' => $region->subRegions(),
                    'stations' => $stations,
                ];
            } elseif (
                in_array($region->region_category_id, [780, 783]) ||
                in_array($region->parent_region_category_id, [780, 783])
            ) {
                $stations = Station::tokyoStations()->ordered()->get(['station_id', 'station_name'])->groupBy('station_name')->map(
                    function ($item) {
                        return $item->first();
                    }
                );
                return [
                    'subRegions' => $region->tokyoSubRegions(),
                    'areas' => $region->tokyoAreas(),
                    'stations' => $stations,
                ];
            }
        }
    }

    public function getSearchTitle($searchResult, $stationName, $regionName, $isShopSearch = true)
    {
        $headingStatement = $isShopSearch ? ['ケーキ屋さん'] : ['一覧'];
        if (request()->has('genre_id') && !empty($searchResult['genre'])) {
            $headingStatement[] = $searchResult['genre'];
        }
        if (!empty(request()->route('sub_region')) || !empty(request()->route('station'))) {
            if (!empty(request()->route('sub_region'))) {
                $headingStatement[] = $searchResult['region'];
            } elseif (!empty(request()->route('station'))) {
                $headingStatement[] = $stationName;
            }
        }
        if (!empty(request()->route('region'))) {
            $headingStatement[] = $regionName;
        }
        if (!empty(request()->keyword)) {
            $headingStatement[] = request()->keyword;
        }
        if (1 === count($headingStatement)) {
            $headingStatement = $isShopSearch ? '全国のケーキ屋さん' : '全国の誕生日ケーキやスイーツの一覧';
        } else {
            $headingStatement = array_reverse($headingStatement);
            $headingStatement = implode('の', $headingStatement);
        }
        return $headingStatement;
    }

    public function getProductSearchLink()
    {
        // Link to product search
        $current_route_name = \Route::currentRouteName();
        $searchLink = '';
        $routeParams = [];
        $queryExcepted = fullQueryOnly(['region', 'sub_region', 'station', 'keyword', 'genre_id', 'reservation_flag']);
        if ('shopsearch.all' == $current_route_name) {
            $searchLink = route('product.index.all');
        } elseif ('shopsearch.station' == $current_route_name) {
            $routeParams['station'] = request()->route('station');
            $searchLink = route('product.index.station', $routeParams);
        } elseif ('shopsearch.region' == $current_route_name) {
            $routeParams['region'] = request()->route('region');
            $routeParams['sub_region'] = request()->route('sub_region');
            $searchLink = route('product.index', $routeParams);
        }
        if (!empty($searchLink) && !empty($queryExcepted)) {
            $searchLink .= '?' . $queryExcepted;
        }
        return $searchLink;
    }

    public function searchShopAll(Request $request)
    {
        $data = $this->listsShop($request, $region = null, $sub_region = null, $stationId = null);
        $params = $request->all();
        $allItem = $data['data']['shops']->num_found;
        $data['data']['params'] = $params;
        if ($request->has('page')) {
            $result = $this->checkRedirectWithPageParam($request->page, $allItem, $data, $params,'shopsearch.all');
            if (is_array($result) && !empty($result['redirect'])) {
                return redirect($result['url']);
            }
        }
        if ($request->ajax()) {
            return $data;
        }
        return view($data['view'], $data['data']);
    }

    public function searchShopByRegion(Request $request, $regionSlug, $sub_regionSlug = null)
    {
        $sub_region = null;
        $region = Region::where('slug', $regionSlug)->where('level', 1)->first();
        if (empty($region)) {
            abort(404);
        }

        if (!empty($sub_regionSlug)) {
            $sub_region = Region::where('slug', $sub_regionSlug)->where('level', 2)->where('parent_region_category_id', $region->region_category_id)->first();
            if (empty($sub_region)) {
                abort(404);
            }
        }
        $data = $this->listsShop($request, $region, $sub_region, $stationId = null);
        $data['data']['lat'] = !empty($data['data']['region']->lat) ? $data['data']['region']->lat : '';
        $data['data']['long'] = !empty($data['data']['region']->long) ? $data['data']['region']->long : '';
        $params = $request->all();
        $allItem = $data['data']['shops']->num_found;
        if ($request->has('page')) {
            $params['region'] = $regionSlug;
            $params['sub_region'] = !empty($sub_regionSlug) ? $sub_regionSlug : '';
            $result = $this->checkRedirectWithPageParam($request->page, $allItem, $data, $params, 'shopsearch.region');
            if (is_array($result) && !empty($result['redirect'])) {
                return redirect($result['url']);
            }
        }
        if ($request->ajax()) {
            return $data;
        }
        return view($data['view'], $data['data']);
    }

    public function searchShopByStation(Request $request, $stationId)
    {
        $data = $this->listsShop($request, $region = null, $sub_region = null, $stationId);
        $data['data']['lat'] = !empty($data['data']['station']->lat) ? $data['data']['station']->lat : '';
        $data['data']['long'] = !empty($data['data']['station']->long) ? $data['data']['station']->long : '';
        $params = $request->all();
        $allItem = $data['data']['shops']->num_found;
        if ($request->has('page')) {
            $params['station'] = $stationId;
            $result = $this->checkRedirectWithPageParam($request->page, $allItem, $data, $params,'shopsearch.station');
            if (is_array($result) && !empty($result['redirect'])) {
                return redirect($result['url']);
            }
        }
        if ($request->ajax()) {
            return $data;
        }
        return view($data['view'], $data['data']);
    }

    public function searchShopIndex(Request $request)
    {
        if ($this->isMobile) {
            return $this->processFormSearch($request);
        }
        return redirect(route('shopsearch.all'), 301);
    }

    public function getInfoRequestButton($shops)
    {
        $shopInfoRequestBtn = [];
        foreach ($shops as $shopId => $shop) {
            $shopInfoRequestBtn[$shopId]['requestCount'] = $this->informationRequest->countByShop($shopId);
            $shopInfoRequestBtn[$shopId]['userRequested'] = $this->informationRequest->findByShop($shopId, ['id'])->count() ? true : false;
        }
        return $shopInfoRequestBtn;
    }

    public function setCookieDataSearch($data = "")
    {
        if ($data) {
            $cookieName = 'data_search';
            $cookieValue = [];
            if (!empty($data['stationId'])) {
                $station = Station::where('station_id',$data['stationId'])->first();
                $region = Region::where('region_category_id',$station->region_id)->first();
            }elseif(!empty($data['parentRegion']) && !empty($data['region'])){
                if ($data['region']->region_category_id == $data['parentRegion']->region_category_id){
                    $region = $data['parentRegion'];
                }else{
                    $region = Region::where('region_category_id',$data['region']->parent_region_category_id)->first();
                }
            }elseif ( !empty($data['parentRegion']) ) {
                $region = $data['parentRegion'];
            }

            if (!empty($data['coupon'])) {
                $cookieValue['cp_code'] =  $data['coupon']->cp_code;
            }
            $cookieValue['parentRegion'] = !empty($region->slug) ? $region->slug : '';
            $cookieValue = json_encode($cookieValue);
            setcookie($cookieName, $cookieValue, time() + (86400 * 30 * 12 * 10), "/", env('APP_HOST_NAME'), true); // 10 year
        }
    }

    public function getSubRegionsById(Request $request)
    {
        $id_region = $request->id;
        $regions = \App\Region::find($id_region);
        return [
            'html' => view('partials.components.mobile.layouts.sub_region',
                    compact('regions'))->render()
            ];
    }

    private function processFormSearch($request)
    {
        $data['data']['prefectures'] = Station::prefectures()->orderBy('prov_rank_no')->get();
        $data['data']['productCategories'] = Category::mainCategories()->orderBy('order_no')->get();
        $isLoggedIn = $this->checkLogin();
        $data['data']['isLoggedIn'] = $isLoggedIn;

        // define
        $data['data']['urlFormShop'] = route('shopsearch.all');
        $data['data']['urlFormProduct'] = route('product.index.all');
        // Get coupon for shopsearch follow cp_code
        if ($request->has('cp_code')) {
            $cpCode = $request->cp_code;
            $coupon = $this->couponService->getCoupon($cpCode)->getBody();
            if ( '0' != $coupon->status && !('400' == $coupon->status && ( $coupon->errors->code == "5232" || $coupon->errors->code == "5234") ) ) {
                $coupon = null;
            }
            $data['data']['coupon'] = $coupon;
        }

        $data['data']['parentRegionId'] = '';
        if (!empty($request->station_id)) {
            $data['data']['stationId'] = $request->station_id;
            $data['data']['urlFormShop'] = route('shopsearch.station', $request->station_id);
            $data['data']['urlFormProduct'] = route('product.index.station', $request->station_id);
            $station = Station::where('station_id', $request->station_id)->first();
            if (!empty($station)) {
                $data['data']['searchResult']['station'] = $station->station_name;
            }
        } elseif (!empty($request->region_id)) {
            $data['data']['regionId'] = $request->region_id;
            $region = Region::getRegionNameById($request->region_id);
            if (!empty($region)) {
                if (0 == $region->parent_region_category_id) {
                    $data['data']['urlFormShop'] = route('shopsearch.region', $region->slug);
                    $data['data']['urlFormProduct'] = route('product.index', $region->slug);
                } else {
                    $parentRegion = Region::where('region_category_id', $region->parent_region_category_id)->first();
                    $parentRegionSlug = $parentRegion->slug;
                    $data['data']['urlFormShop'] = route('shopsearch.region', [$parentRegionSlug, $region->slug]);
                    $data['data']['urlFormProduct'] = route('product.index', [$parentRegionSlug, $region->slug]);
                }
                $data['data']['searchResult']['region'] = $region->category_name;
            }
            $data['data']['parentRegionId'] = $request->parent_region_id;
        }
        if (isset($request->no_cp_coupon)) {
            $cookieValue['cp_code'] = '';
            setcookie('data_search', json_encode($cookieValue), time() + (86400 * 30 * 12 * 10), "/", env('APP_HOST_NAME'), true); // 10 year
        }

        $data['data']['referer'] = $request->headers->get('referer');
        $data['data']['getCookieRegion'] = $this->searchService->getCookieRegion();
        $data['data']['tab_search'] = empty($request->tab_search) || $request->tab_search == 'shop' ? 'shop' : 'product';
        $data['data']['keywordShop'] = $request->keyword;
        $data['data']['keywordProduct'] = $request->keyword;
        $data['data']['regionNameDefault'] = Shop::REGION_NAME_DEFAULT;
        $data['data']['genreNameDefault'] = Shop::GENRE_NAME_DEFAULT;
        $data['data']['keywordNameDefault'] = Shop::KEYWORD_NAME_DEFAULT;

        return view('search.' . $this->path . 'index', $data['data']);
    }
}

