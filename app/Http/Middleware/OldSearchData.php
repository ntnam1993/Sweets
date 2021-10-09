<?php

namespace App\Http\Middleware;

use App\Keyword;
use App\Services\KeywordService;
use App\Services\SearchService;
use Closure;

class OldSearchData
{
    protected $keywordService;
    protected $searchService;
    protected $routeName;
    private static $listSearchAll = ['shopsearch.all' => 1, 'product.index.all' => 1];
    private static $listShopSearch = ['shopsearch.index' => 1, 'shopsearch.all' => 1, 'shopsearch.station' => 1, 'shopsearch.region' => 1];

    public function __construct(KeywordService $keywordService, SearchService $searchService)
    {
        $this->keywordService = $keywordService;
        $this->searchService = $searchService;
        $this->routeName = \Request::route()->getName();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!empty($request->remove_search_cookie)) {
            $_COOKIE['data_search'] = '';
        }
        $newurl = '';
        if ($request->has('keyword')) {
            $keyword = $request->keyword;
            $checkKeyword = $this->keywordService->checkKeyword($keyword);
            if ( $checkKeyword != '' && isset($checkKeyword['status']) && $checkKeyword['status'] == Keyword::REDIRECT ) {
                $newurl = $checkKeyword['url'];
            }
        }
        if (!$newurl) {
            if( !request()->has('search_all') && !request()->has('current_location') && isset(self::$listSearchAll[$this->routeName]) ){
                $dataSearchOld = !empty($_COOKIE['data_search']) ? $_COOKIE['data_search'] : '';
                if(!empty($dataSearchOld)){
                    $dataSearchOld = json_decode($dataSearchOld);

                    if (empty($dataSearchOld)) {
                        $dataSearchOld = (object) [];
                    }
                    $params = $request->all();
                    if(!empty($dataSearchOld->parentRegion) || !empty($dataSearchOld->region)){
                        if(\Route::currentRouteName() == 'product.index.all'){
                            $newurl = route('product.index', array_merge(['region' => $dataSearchOld->parentRegion], ['sub_region' => ''], $params));
                        }else{
                            $newurl = route('shopsearch.region', array_merge(['region' => $dataSearchOld->parentRegion], ['sub_region' => ''], $params));
                        }
                    }
                }
            }
        }
        if (isset(self::$listShopSearch[$this->routeName])) {
            $getCookieRegion = $this->searchService->getCookieRegion();
            if (isset($request->no_cp_coupon)) {
                $cookieValue['cp_code'] = '';
                setcookie('data_search', json_encode($cookieValue), time() + (86400 * 30 * 12 * 10), "/", env('APP_HOST_NAME'), true); // 10 year

                $newurl = $duplicate = ($newurl != '') ? $newurl : url()->full();
                $duplicate = parse_url($duplicate);
                $otherUrl = $duplicate['scheme'].'://'.$duplicate['host'].$duplicate['path'];

                $parse   = parse_url($newurl, PHP_URL_QUERY);
                $parse   = parse_str($parse, $output);

                if ( array_key_exists("cp_code",$output) ) {
                    unset($output['cp_code']);
                }
                if ( array_key_exists("no_cp_coupon",$output) ) {
                    unset($output['no_cp_coupon']);
                }
                $uri_parts = [];
                if (count($output)) {
                    foreach ($output as $key => $value) {
                        if (!empty($value)) {
                            $uri_parts[] = sprintf('%s=%s', $key, $value);
                        }
                    }
                }
                $newurl = sprintf("%s?%s", $otherUrl, implode("&", $uri_parts));
            }elseif(!empty($getCookieRegion) && !empty($getCookieRegion['cp_code']) && !isset($_GET['cp_code'])) {
                $cpCode = $getCookieRegion['cp_code'];
                $newurl = ($newurl != '') ? $newurl : url()->full();
                $newurl = preg_match('/[?]/',$newurl) ? $newurl . "&cp_code=" . $cpCode : $newurl . "?cp_code=" . $cpCode;
            }
        }

        if ($newurl != '') {
            return redirect($newurl);
        }

        return $next($request);
    }
}
