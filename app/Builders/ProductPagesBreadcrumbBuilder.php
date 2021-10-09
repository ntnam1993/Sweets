<?php

namespace App\Builders;

use Route;

class ProductPagesBreadcrumbBuilder extends Builder
{
    protected $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $list = [];

        $list[] = ['url' => route('index'), 'text' => 'EPARKスイーツガイド'];

        if (!empty($this->data['region'])) {
            $region = $this->data['region'];

            $list[] = [
                'url' => route('shopsearch.region', [$region->slug]),
                'text' => $region->category_name,
            ];

            if (!empty($this->data['subRegion'])) {
                $subRegion = $this->data['subRegion'];

                $list[] = [
                    'url' => route('shopsearch.region', [$region->slug, $subRegion->slug]),
                    'text' => $subRegion->category_name,
                ];
            }
        }

        $list[] = [
            'url' => route('shop.index', $this->data['shopId']),
            'text' => $this->data['shop']->item->facility_name,
        ];

        $list[] = [
            'text' => $this->data['item']->item->product_name,
        ];

        return $list;
    }
}
