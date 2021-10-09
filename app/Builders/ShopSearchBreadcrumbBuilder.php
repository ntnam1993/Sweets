<?php

namespace App\Builders;

class ShopSearchBreadcrumbBuilder extends Builder
{
    protected $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $list = [];
        $list[] = ['url' => '/', 'text' => 'EPARKスイーツガイド'];

        if (!empty($this->data['parentRegion'])) {
            $list[] = [
                'url' => route('shopsearch.region', array_merge(['region' => $this->data['parentRegion']->slug, 'sub_region' => ''])),
                'text' => $this->data['parentRegion']->category_name,
            ];
        }

        if (
            !empty($this->data['region']) &&
            !empty($this->data['parentRegion']) &&
            $this->data['region']->region_category_id != $this->data['parentRegion']->region_category_id
        ) {
            $list[] = [
                'url' => route('shopsearch.region', array_merge(['region' => $this->data['parentRegion']->slug, 'sub_region' => $this->data['region']->slug])),
                'text' => $this->data['region']->category_name,
            ];
        }

        if (!empty($this->data['searchResult']['station'])) {
            $list[] = [
                // 'url' => route('shopsearch.station', array_merge(['station' => $this->data['stationId']])),
                'url' => '#',
                'text' => $this->data['searchResult']['station'],
            ];
        }
        if (!empty($this->data['categoryId'])) {
            $list[] = [
                'url' => '#',
                'text' => $this->data['searchResult']['genre'],
            ];
        }
        if(request()->has('pos')){
            $list[] = ['text' => '現在地周辺のケーキ屋さん・スイーツ店'];
        } elseif (!empty($this->data['params']['keyword'])){
            $list[] = ['text' => $this->data['params']['keyword'] . 'のケーキ屋さん・スイーツ店'];
        } elseif (empty($this->data['parentRegion'])) {
            $list[] = ['text' => '全国のケーキ屋さん・スイーツ店'];
        } else{
            $list[] = ['text' => 'ケーキ屋さん・スイーツ店'];
        }

        return $list;
    }
}
