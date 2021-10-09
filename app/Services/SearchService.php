<?php

namespace App\Services;

use App\Category;
use App\Region;
use App\Station;

class SearchService extends EparkService
{
    public function __construct() {
        parent::__construct();

    }

    /**
     * get cookie by search shop region
     * @return [type]           [description]
     */

    public function getCookieRegion()
    {
        $region = '';
        $regionName = '';
        $sub_region_special = [];
        $sub_region_special_name = '';
        $parentRegionSlug = '';
        $dataSearchOld = !empty($_COOKIE['data_search']) ? $_COOKIE['data_search'] : '';
        $dataSearchOld = json_decode($dataSearchOld);
        $parentRegion = '';
        $station = '';
        if(!request()->has('search_all') && !request()->has('current_location')){
            if(!empty($dataSearchOld->station)) {
                $station = Station::where('station_id',$dataSearchOld->station)->first();
                if ($station->region_id) {
                    $region = Region::where('region_category_id',$station->region_id)->where('level',Region::LEVEL1)->first();
                    if ($region) {
                        $dataSearchOld->parentRegion = $region->slug;
                    }
                }
            }
            if(!empty($dataSearchOld->parentRegion) || !empty($dataSearchOld->region)){
                $parentRegion = $dataSearchOld->parentRegion;
                $parentRegion = Region::where('slug',$parentRegion)->where('level',Region::LEVEL1)->first();
                if ($parentRegion) {
                    if ($parentRegion->region_category_id == 780) {
                        $real_region_category_id = 780;
                        $parentRegion->region_category_id = 783;
                        $region = Region::where('region_category_id',$parentRegion->region_category_id)->first();
                        $parentRegionSlug = $region->slug;
                    }else{
                        $parentRegionSlug = $parentRegion->slug;
                    }
                    $region       = Region::where('parent_region_category_id',$parentRegion->region_category_id)->orderBy('order_no')->get();
                    $regionName   = $parentRegion->category_name;
                }
                $station = Station::select('prov_code','rail_line_id')->where('region_id',$parentRegion->region_category_id)->first();
            }
        }
        $cp_code = !empty($dataSearchOld->cp_code) ? $dataSearchOld->cp_code : '';
        if (!empty($parentRegion) && (in_array($parentRegion->slug, Region::SPECIAL_REGION_SEARCH) || is_numeric(strpos($parentRegion->slug, Region::TOKYO_REGION)))) {
            foreach ($region as $key => $r) {
                if ( mb_strpos($r->category_name, Region::CHARACTER_SPECIAL_NAME) ) {
                    array_push($sub_region_special, $r);
                    unset($region[$key]);
                }
            }
            $sub_region_special_name = is_numeric(strpos($parentRegion->slug, Region::TOKYO_REGION )) ? Region::SPECIAL_REGION_SEARCH_NAME[Region::TOKYO_REGION] : Region::SPECIAL_REGION_SEARCH_NAME[$parentRegion->slug];
        }
        return [
            'region' => $region,
            'regionName' => $regionName,
            'sub_region_special' => $sub_region_special,
            'sub_region_special_name' => $sub_region_special_name,
            'parentRegionSlug' => $parentRegionSlug,
            'cp_code' => $cp_code,
            'parentRegionId' => ($parentRegion != '') ? $parentRegion->region_category_id : '',
            'station' => !empty($station) ? $station : '',
            'real_region_category_id' => !empty($real_region_category_id) ? $real_region_category_id : '',
        ];
    }

    public function processParamForProductSearch($request, $stationId, $region)
    {
        $start = 0;
        $sort = !empty($request->sort) ? $request->sort : 0;
        $epark_payment_use_flag = !empty($request->epark_payment_use_flag) ? $request->epark_payment_use_flag : '';
        $productLimit = config('common.product_search_limit');
        $price = $request->price;
        $price500 = '';
        $price500_1000 = '';
        $price1000_2000 = '';
        $price2000_3000 = '';
        $price3000 = '';
        switch ($price) {
            case 'price500':
                $price500 = 1;
                break;
            case 'price500_1000':
                $price500 = 1;
                $price500_1000 = 1;
                break;
            case 'price1000_2000':
                $price500 = 1;
                $price500_1000 = 1;
                $price1000_2000 = 1;
                break;
            case 'price2000_3000':
                $price500 = 1;
                $price500_1000 = 1;
                $price1000_2000 = 1;
                $price2000_3000 = 1;
                break;
            case 'price3000':
                $price3000 = 1;
                break;
        }
        $reserve = 1;

        $size3 = checkNotNullReturnTrue($request->size3);
        $size4 = checkNotNullReturnTrue($request->size4);
        $size5 = checkNotNullReturnTrue($request->size5);
        $size6 = checkNotNullReturnTrue($request->size6);
        $size7 = checkNotNullReturnTrue($request->size7);
        $size8 = checkNotNullReturnTrue($request->size8);
        $size9 = checkNotNullReturnTrue($request->size9);
        $size10 = checkNotNullReturnTrue($request->size10);
        $size11 = checkNotNullReturnTrue($request->size11);

        // condition for station and freeword
        $keyword = $request->has('keyword') ? $request->keyword : '';

        $reservation_flag = $request->has('reservation_flag') ? $request->reservation_flag : '';

        if (strpos($request->receipt_date, '-')) {
            $find = ['-'];
            $receipt_date = str_replace($find, '/', $request->receipt_date);
        } else {
            $find = ['日'];
            $receipt_date = str_replace($find, '', $request->receipt_date);
            $find2 = ['年', '月'];
            $receipt_date = str_replace($find2, '/', $receipt_date);
        }

        $page = $request->page;
        $rows = $productLimit;
        if ($page > 0) {
            $start = ($rows * $page) - $rows;
        }
        $appId = env('APP_ID');
        $pass = env('PASS');
        $coordinates = json_decode($request->coordinates);
        if (!empty($coordinates)) {
            $min_latitude = $coordinates->min_latitude;
            $min_longitude = $coordinates->min_longitude;
            $max_latitude = $coordinates->max_latitude;
            $max_longitude = $coordinates->max_longitude;
        } else {
            $min_latitude = null;
            $min_longitude = null;
            $max_latitude = null;
            $max_longitude = null;
        }

        $geo_latitude = null;
        $geo_longitude = null;
        if ($request->has('pos')) {
            $pos = json_decode(urldecode($request->pos));

            $geo_latitude = $pos->lat;
            $geo_longitude = $pos->lng;
        }

        $query = [
            'app_id' => $appId,
            'pass' => $pass,
            'station' => $stationId,
            'price500' => $price500,
            'price500_1000' => $price500_1000,
            'price1000_2000' => $price1000_2000,
            'price2000_3000' => $price2000_3000,
            'price3000' => $price3000,
            'reserve' => $reserve,
            'genre_id' => $request->genre_id,
            'catg' => $region,
            'sort' => $sort,
            'start' => $start,
            'rows' => $rows,
            'size3' => $size3,
            'size4' => $size4,
            'size5' => $size5,
            'size6' => $size6,
            'size7' => $size7,
            'size8' => $size8,
            'size9' => $size9,
            'size10' => $size10,
            'size11' => $size11,
            'keyword' => $keyword,
            'min_latitude' => $min_latitude,
            'min_longitude' => $min_longitude,
            'max_latitude' => $max_latitude,
            'max_longitude' => $max_longitude,
            'geo_latitude' => $geo_latitude,
            'geo_longitude' => $geo_longitude,
            'reservation_flag' => $reservation_flag,
            'epark_payment_use_flag' => $epark_payment_use_flag,
            'receivable_date' => $receipt_date,
            'fields' => 'main_image_s,train_line1,exit_station1,product_id,facility_name,product_name,product_price,product_comment_num,product_comment_evaluate_total,product_image1,product_size,station1,means1,time_required1,reservation_flg,shop_id,product_description1,product_price_by_size,min_product_price,epark_payment_use_flag',
        ];

        if ('not_specified' == $price) {
            unset($query[$price]);
        }

        return [
            $query, $page, $rows, $productLimit
        ];
    }

    public function getInforSearchWithRegion($regionId, $parentRegionId)
    {
        $provName = $provCode = $station = $region = '';
        $searchResult = [];
        if (!empty($regionId)) {
            $region = Region::getRegionNameById($regionId);
            if (!empty($region)) {
                $searchResult['region'] = $region->category_name;
            }
            $station = Station::where('region_id', $regionId)->first();
            $subRegions = Region::where('parent_region_category_id', $parentRegionId)->get();
            if ($subRegions->count()) {
                $station = Station::where('region_id', $parentRegionId)->first();
                if (780 == $parentRegionId) {
                    $station = Station::where('region_id', 783)->first();
                }
            }
            if (!empty($station)) {
                $provCode = $station->prov_code;
                $provName = $station->prov_name;
            }
        }

        return [
            $provCode,
            $provName,
            $searchResult,
            $station,
            $region
        ];
    }

    public function getInforSearchWithStation($stationId, $regionName, $searchResult, $parentRegion, $station, $parentRegionId, $provName, $region)
    {
        $stationProvCode = $parentRegionName = $stationRailLineId = $stationName = $railLineName = '';
        if (!empty($stationId)) {
            $station = Station::where('station_id', $stationId)->first();
            if (!empty($station)) {
                $region = $station->region;
                $regionName = $station->prov_name;
                $searchResult['station'] = $station->station_name;
                $parentRegion = Region::where('region_category_id', $station->region_id)->first();
                if (!empty($parentRegion)) {
                    $parentRegionId = $parentRegion->region_category_id;
                    $parentRegionName = $parentRegion->category_name;
                }
                $stationProvCode = $station->prov_code;
                $stationRailLineId = $station->rail_line_id;
                $stationName = $station->station_name;
                $railLineName = $station->rail_line_name;
                $provName = $station->prov_name;
            }else{
                abort(404);
            }
        }

        return [
            $region,
            $regionName,
            $parentRegionId,
            $parentRegionName,
            $stationProvCode,
            $stationRailLineId,
            $stationName,
            $railLineName,
            $provName,
            $searchResult,
            $parentRegion,
            $station
        ];
    }

    public function getInforSearchWithGenre($params,$searchResult)
    {
        $categoryId = $parentCategoryId = $parentCategoryLevel = $parentCategoryName = '';
        if (!empty($params['genre_id'])) {
            $category = Category::getGenreNameById($params['genre_id']);
            if (!empty($category)) {
                $searchResult['genre'] = $category->category_name;
                $parentCategory = Category::getGenreNameById($category->parent_product_category_id);
                $categoryId = $params['genre_id'];
                if (!empty($parentCategory)) {
                    $parentCategoryId = $category->parent_product_category_id;
                    $parentCategoryLevel = $parentCategory->level;
                    $parentCategoryName = $parentCategory->category_name;
                }
            }
        }

        return [
            $categoryId, $parentCategoryId, $parentCategoryLevel, $parentCategoryName, $searchResult
        ];
    }

    public function getInforSearchWithParentRegion($parentRegionId)
    {
        $regionName = $parentRegion = '';
        if (!empty($parentRegionId)) {
            $parentRegion = Region::where('region_category_id', $parentRegionId)->first();
            if (!empty($parentRegion)) {
                //check if region is tokyo-citycenter
                if (780 == $parentRegion->region_category_id) {
                    //get stations of tokyo-searchfromcitycounty instead of tokyo-citycenter
                    $sibling = Station::tokyoStations()->take(1)->get();
                } else {
                    $sibling = $parentRegion->stations()->take(1)->get();
                }
                if ($sibling->count() > 0) {
                    $regionName = $sibling[0]->prov_name;
                } else {
                    $regionName = $parentRegion->category_name;
                }
            }
        }
        return [
          $regionName, $parentRegion
        ];
    }

    public function searchShopWithPosParam($request, $query, $sub_region)
    {
        $coordinates = json_decode(urldecode(request()->pos));
        $queryString = [
            'sort' => 1,
            'geo_latitude' => $coordinates->lat,
            'geo_longitude' => $coordinates->lng,
            'rows' => config('common.product_search_limit')
        ];

        $queryString = array_merge($queryString, $query);

        if (! empty($distance = request()->distance)) {
            $queryString['geo_distance'] = $distance;
        } else {
            switch (\Route::currentRouteName()) {
                case 'shopsearch.all':
                    if($request->has('current_location')){
                        $queryString['geo_distance'] = 3; //unit : km
                    }else{
                        $queryString['geo_distance'] = 2000;//unit : km
                    }
                    break;

                case 'shopsearch.region':
                    if ($sub_region) {
                        $queryString['geo_distance'] = 10;//unit : km
                    } else {
                        $queryString['geo_distance'] = 100;//unit : km
                    }
                    break;

                case 'shopsearch.station':
                    $queryString['geo_distance'] = 1;//unit : km
                    break;
            }
        }
        return $queryString;
    }
}
