<?php

namespace App\Adapters;

class ShopSearchAdapter
{
    /**
     * Get category lookup array by shop
     *
     * @param  mixed $shops
     * @return array
     */
    public function categoriesByShops($shops)
    {
        $categories = [];
        $cateLookup = listPatternGenres();
        foreach ($shops as $id => $shop) {
            $categories[$id] = [];
            $handledProducts = !empty($shop->handled_product) ? explode(',', $shop->handled_product) : [];

            foreach ($handledProducts as $category) {
                if (array_search($category, $cateLookup)) {
                    // Find category's id in category lookup
                    $cateId = array_search($category, $cateLookup);
                    $categories[$id][$cateId] = $category;
                }
            }

            ksort($categories[$id]);
        }

        return $categories;
    }
}
