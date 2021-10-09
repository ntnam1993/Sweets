<?php

namespace App\Builders;

use Route;

class ShopPagesBreadcrumbBuilder extends Builder
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

        switch (Route::currentRouteName()) {
            case 'shop.info':
                $list[] = ['text' => 'ショップ情報'];
                break;

            case 'shop.coupon':
                $list[] = ['text' => 'クーポン'];
                break;

            case 'shop.menu':
                $list[] = ['text' => 'メニュー'];
                break;

            case 'shop.map':
                $list[] = ['text' => '地図'];
                break;

            case 'shop.comments':
                $list[] = ['text' => '口コミ'];
                break;

            case 'shop.comment_detail':
                $list[] = [
                    'url' => route('shop.comments', $this->data['shopId']),
                    'text' => '口コミ',
                ];
                $list[] = ['text' => $this->data['comment']->items[0]->content_title];
                break;
        }

        return $list;
    }
}
