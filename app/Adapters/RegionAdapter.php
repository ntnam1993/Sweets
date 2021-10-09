<?php

namespace App\Adapters;

use App\Region;

class RegionAdapter
{

    public function __construct() {}

    public function getRegionAndSubRegionByShopItem($shopItem)
    {
        $regionId = !empty($shopItem->category_1) ? $shopItem->category_1->category_id : '';
        $subRegionId = !empty($shopItem->category_2) ? $shopItem->category_2->category_id : '';
        $region = $subRegion = '';
        if (!empty($regionId)) {
            $region = Region::where('region_category_id', $regionId)->first();
        }
        if (!empty($subRegionId)) {
            $subRegion = Region::where('region_category_id', $subRegionId)->first();
        }
        return [$region, $subRegion];
    }
}
