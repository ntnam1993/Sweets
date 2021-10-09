<?php
namespace App\Http\Controllers;

use App\Category;
use App\Region;
use App\Services\CommentService;
use App\Services\SearchService;
use App\Station;
use Exception;
use Illuminate\Http\Request;
use Log;

class HomeController extends BaseController
{

    protected $commentService;
    protected $searchService;

    public function __construct(CommentService $commentService, SearchService $searchService)
    {
        parent::__construct();

        $this->commentService = $commentService;
        $this->searchService = $searchService;
    }

    /**
     * @author chuong
     * index
     * @param $id
     */
    public function index(Request $request)
    {
        // get comments on top page
        // $query = [
        //     'disp_count' => 6,
        //     'disp_fg' => 1,
        //     'order' => 'comment_date_desc',
        // ];
        // $comments = $this->commentService->search($query)->getBody();

        $isLoggedIn = $this->checkLogin();

        // define register url
        $loginUri = $this->isMobile ? 'member_sp/registration' : 'member_pc/registration';

        $getCookieRegion = [];
        setcookie('data_search', null, -1, "/", env('APP_HOST_NAME'), true);

        $defaultRegion = Region::defaultRegion();

        $urlSweetsEC = config('common.URL_SWEETS_EC_STAGING');
        if(env('APP_ENV') == 'production')
            $urlSweetsEC = config('common.URL_SWEETS_EC_PRODUCT');

        return view('home.' . $this->path . 'index', compact('defaultRegion', 'comments', 'isLoggedIn', 'getCookieRegion', 'urlSweetsEC'));
    }

    public function getRailLines(Request $request)
    {
        $prefectureId = $request->prefectureId;
        $railLines = Station::railLines($request->prefectureId)
            ->orderBy('rail_line_rank_no')
            ->get();

        $rootStationName = $request->rootName;
        $provName = $request->provName;
        return view('home.' . $this->path . 'rail-lines', compact('railLines', 'prefectureId', 'rootStationName', 'provName'));
    }

    public function getStations(Request $request)
    {
        $isShopSearch = $request->isShopSearch;
        $sortShopSearch = $request->sortShopSearch;
        $provName = $request->provName;
        $stationName = $request->stationName;
        $railLineId = $request->railLineId;
        $stationId = $request->station_id;
        $stations = Station::stations($request->prefectureId, $request->railLineId)
            ->orderBy('station_rank_no')
            ->get();
        $viewBlade = ($request->isTopPC) ? 'stations' : (('shopsearch.region' == $isShopSearch || 'shopsearch.station' == $isShopSearch || 'shopsearch.all' == $isShopSearch || 'shopsearch.index' == $isShopSearch) ? 'stations-shop' : 'stations');
        return view('home.' . $this->path . $viewBlade, compact('isShopSearch', 'railLineId', 'stations', 'provName', 'stationName', 'stationId', 'sortShopSearch'));
    }

    public function countReference(Request $request)
    {
        try {
            $commentId = $request->comment_id;
            $query = [
                'comment_id' => $commentId,
                'cookie_val' => csrf_token(),
                'count' => 1,
            ];
            $comments = $this->commentService->addReferenceCount($query)->getBody();
            if ('1' != $comments->status) {
                throw new Exception('Error');
            }
            return $comments;
        } catch (\Exception $e) {
            return json_encode(0);
        }
    }

    public function getSubRegion($parentRegionId)
    {
        return Region::where('parent_region_category_id', $parentRegionId)
            ->orderBy('order_no')
            ->get();
    }

    public function getGenres(Request $request)
    {
        $categoryName = $request->data_category_name;
        $genreId = $request->genre_id;
        $categoryId = $request->category_id;
        $categories = Category::where('parent_product_category_id', $genreId)->get();
        return view('product.sub-region', compact('categories', 'categoryId', 'genreId', 'categoryName'));
    }

    public function postLeaveAccount(Request $request)
    {
        // clear user session after leaving account
        $referer = $request->headers->get('referer');
        if (env('EPARK_ACCOUNT') . 'member_pc/withdrawal/complete' == $referer) {
            return redirect(env('SWEETS_LOGOUT_ENDPOINT'));
        }
        return redirect()->route('index');
    }

    public function redirect(Request $request)
    {
        if ($request->has('SITE_CODE') && $request->has('redirect_url')) {
            $redirectUrl = $request->redirect_url;
            $redirectUrl = urldecode($redirectUrl);
            $checkRedirectUrl = strpos($redirectUrl, env('REDIRECT_URI_COOKIE'));
            if ($checkRedirectUrl === 0) {
                $siteCode = $request->SITE_CODE;
                $cookie = cookie('site_code', $siteCode, 24 * 60, '/', env('DOMAIN_COOKIE'), true);

                //target_query list
                $white_list = [
                    'utm_source'   => '' ,
                    'utm_medium'   => '' ,
                    'utm_content'  => '' ,
                    'utm_campaign' => '' ,
                    'utm_term'     => '' ,
                    '_ga'          => '' ,
                ];

                //redirect url parse
                if($request->has('redirect_url')){
                    $redirect_url = $request->redirect_url;
                } else {
                    abort(404);
                }

                // add query to white_list
                $parts = parse_url($redirect_url);
                if(isset($parts['query'])){
                    parse_str($parts['query'], $query);
                    foreach($query as $key => $val){
                        $white_list[$key] = $val;
                    }
                }

                //optimisation query
                foreach($white_list as $key => $val){
                    // white_list value overwrite
                    if(isset($_GET[$key])){
                        $white_list[$key] = $_GET[$key];
                    }
                    // unset if empty
                    if(empty($white_list[$key])){
                        unset($white_list[$key]);
                    }
                }

                //build redirect url
                $add_query = http_build_query($white_list);
                $redirect_target = !empty($add_query) ? "{$parts['scheme']}://{$parts['host']}{$parts['path']}?{$add_query}" : "{$parts['scheme']}://{$parts['host']}{$parts['path']}";
                return redirect($redirect_target, 301)->cookie($cookie);
            }
            return redirect('/', 301);
        }
        return redirect('/', 301);

    }

    /**
     * get subregions by parent region id
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getSubRegions(Request $request)
    {
        $parentRegionId = $request->parent_region_id;
        if (!$parentRegionId) {
            return '';
        }
        $isShopSearch = $request->isShopSearch;
        $parentRegionName = $request->parent_region_name;
        $regionId = $request->region_id;

        $slug = Region::getRegionNameById($parentRegionId)->slug;
        $subCategories = $this->getSubRegion($parentRegionId);
        $station = $provName = '';
        $params = [];

        if (780 == $parentRegionId) {
            //get stations of tokyo-searchfromcitycounty instead of tokyo-citycenter
            $station = Station::where('region_id', 783)->first();
        } else {
            $station = Station::where('region_id', $parentRegionId)->first();
        }

        if (!empty($station)) {
            $provName = $station->prov_name;
        }

        $tokyo = 0;
        if ($request->has('tokyo')) {
            $tokyo = $request->tokyo;
        }

        if ($request->has('cp_code') && !empty($request->cp_code)) {
            $params['cp_code'] = $request->cp_code;
        }

        return view('home.' . $this->path . 'sub-region', compact('isShopSearch', 'tokyo', 'subCategories', 'slug', 'regionId', 'parentRegionId', 'parentRegionName', 'provName', 'params'))->render();
    }

    public function error()
    {
        return view('errors.' . $this->path . '404');
    }
}
