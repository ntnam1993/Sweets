<?php

namespace App\Builders;

class ProductSearchBreadcrumbBuilder extends Builder
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
                'url' => route('product.index', array_merge(['region' => $this->data['parentRegion']->slug, 'sub_region' => ''], $this->data['canonicalParams'])),
                'text' => $this->data['parentRegion']->category_name,
            ];
        }

        if (
            !empty($this->data['region']) &&
            !empty($this->data['parentRegion']) &&
            $this->data['region']->region_category_id != $this->data['parentRegion']->region_category_id
        ) {
            $list[] = [
                'url' => route('product.index', array_merge(['region' => $this->data['parentRegion']->slug, 'sub_region' => $this->data['region']->slug], $this->data['canonicalParams'])),
                'text' => $this->data['region']->category_name,
            ];
        }

        if (!empty($this->data['searchResult']['station']) && !empty($this->data['parentRegion'])) {
            $list[] = [
                'url' => route('product.index', array_merge(['region' => $this->data['parentRegion']->slug, 'sub_region' => ''], $this->data['canonicalParams'])),
                'text' => $this->data['searchResult']['station'],
            ];
        }

        if (!empty($this->data['categoryId'])) {
            $list[] = [
                'url' => '#',
                'text' => '誕生日ケーキ・ホールケーキ',
            ];
        }

        if (!empty($this->data['category'])) {
            $list[] = [
                'url' => '#',
                'text' => $this->data['category']->category_name,
            ];
        }

        if (!empty($this->data['params']['keyword'])) {
            $list[] = ['text' => $this->data['params']['keyword'] . 'の一覧'];
        }elseif(!empty($this->data['parentRegion'])){
            $list[] = ['text' => '誕生日ケーキやスイーツの一覧'];
        } else {
            $list[] = ['text' => '全国の誕生日ケーキやスイーツの一覧'];
        }

        return $list;
    }
}
