<?php

namespace App\Services;

use App\Keyword;
use App\Region;

class KeywordService extends EparkService
{
    protected $fullUrl;
    protected $currentUrl;
    protected $routeName;

    private static $listSearchAll = ['shopsearch.all' => 1, 'product.index.all' => 1];

    public function __construct() {
        parent::__construct();
        $this->fullUrl = url()->full();
        $this->currentUrl = url()->current();
        $this->routeName = \Request::route()->getName();
    }

    public function checkKeyword($keyword)
    {
        if (!strlen($keyword)) {
            return '';
        }
        $infoKeyword = Keyword::where('keywords',$keyword)->first();
        if (!isset($infoKeyword)) {
            return '';
        }
        switch ($infoKeyword->type) {
            case Keyword::AREA:
                $new_url = $this->processURLWithArea($infoKeyword->condition_id);
                break;
            case Keyword::GENRE:
                $new_url = $this->processUrlWithGenre($infoKeyword->condition_id);
                break;
            case Keyword::STATION:
                $new_url = $this->processUrlWithStation($infoKeyword->condition_id);
                break;
            default:
                $new_url = $this->fullUrl;
                break;
        }
        if (!$new_url) {
            return '';
        }
        return [
            'status' => Keyword::REDIRECT,
            'url'    => $new_url
        ];
    }

    private function processUrlWithGenre($condition_id)
    {
        if (preg_match('/[?]/',$this->fullUrl)) {
            $this->fullUrl = $this->fullUrl . "&genre_id=" . $condition_id;
        }else {
            $this->fullUrl = $this->fullUrl . "?genre_id=" . $condition_id;
        }
        return $this->addArgument($this->fullUrl);
    }

    private function processUrlWithStation($condition_id)
    {
        if ( isset(self::$listSearchAll[$this->routeName]) ) {
            $stationPart = "/station/" . $condition_id;
            $new_url = str_replace("/all", $stationPart, $this->fullUrl);
        }else {
            $routeNames = ['shopsearch.station' => 1, 'product.index.station' => 1];
            if ( isset($routeNames[$this->routeName]) ) {
                $this->currentUrl = route($this->routeName, ['station' => $condition_id]);
            }
            $new_url = $this->addArgument($this->currentUrl);
        }
        return $new_url;
    }

    private function processURLWithArea($condition_id)
    {
        $region = Region::where('region_category_id',$condition_id)->first();
        if ( empty($region) || !count($region) ) {
            return false;
        }

        if ($region->level == Region::LEVEL1) {
            $regionPart = "/" . $region->slug;
        }else{
            $sub_region = $region;
            $region     = Region::where('region_category_id',$sub_region->parent_region_category_id)->first();
            if ( empty($region) || !count($region) ) {
                $region = $sub_region;
            }else{
                $regionPart = "/" . $region->slug . "/" . $sub_region->slug;
            }
        }

        if ( isset(self::$listSearchAll[$this->routeName]) ) {
            $new_url = str_replace("/all", $regionPart, $this->fullUrl);
        }else {
            $routeNames = ['shopsearch.region' => 1, 'product.index' => 1];
            if ( isset($routeNames[$this->routeName]) ) {
                $this->currentUrl = route($this->routeName, ['region' => $region->slug, 'sub_region' => !empty($sub_region) ? $sub_region->slug : '']);
            }
            $new_url = $this->addArgument($this->currentUrl);
        }
        return $new_url;
    }

    private function addArgument($new_url)
    {
        $parse   = parse_url($this->fullUrl, PHP_URL_QUERY);
        $parse   = parse_str($parse, $output);
        if ( !count($output) ) {
            return $new_url;
        }

        if ( array_key_exists("keyword",$output) ) {
            unset($output['keyword']);
        }

        $uri_parts = [];
        foreach ($output as $key => $value) {
            $uri_parts[] = sprintf('%s=%s', $key, $value);
        }
        return sprintf("%s?%s", $this->currentUrl, implode("&", $uri_parts));
    }
}
