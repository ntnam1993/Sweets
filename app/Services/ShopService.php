<?php

namespace App\Services;

class ShopService extends EparkService
{

    protected $commentService;
    protected $productService;

    public function __construct(
        CommentService $commentService,
        ProductService $productService
    ) {
        parent::__construct();

        $this->commentService = $commentService;
        $this->productService = $productService;
    }

    public function findAsync($shopId)
    {
        $query = array_merge($this->defaultQuery, ['id' => $shopId]);
        $this->response = $this->client->requestAsync('GET', 'shopitems', compact('query'));
        return $this;
    }

    public function searchAsync($query)
    {
        $query = array_merge($this->defaultQuery, $query);
        $this->response = $this->client->requestAsync('GET', 'shopsearch', compact('query'));
        return $this;
    }

    public function getShopItem($shopId, $includes = [])
    {
        $this->findAsync($shopId);
        if (empty($includes)) {
            return $this->getBodyAsync();
        }
        $promises = [$this->response];
        foreach ($includes as $key => $query) {
            switch ($key) {
                case 'comments':
                    if (!array_key_exists('disp_fg', $query)) {
                        $query['disp_fg'] = 1;
                    }
                    if (!array_key_exists('order', $query)) {
                        $query['order'] = 'comment_date_desc';
                    }
                    if (!array_key_exists('target_id', $query)) {
                        $query['target_id'] = $shopId;
                    }
                    $query = array_merge($query);
                    $promises[] = $this->commentService->searchAsync($query)->getResponse();
                    break;
                case 'products':
                    $query['id'] = $shopId;
                    $query = array_merge($query);
                    $promises[] = $this->productService->requestAsyncShopProduct($query)->getResponse();
                    break;
                case 'comment':
                    if (!array_key_exists('target_id', $query)) {
                        $query['target_id'] = $shopId;
                    }
                    $query = array_merge($query);
                    $promises[] = $this->commentService->searchAsync($query)->getResponse();
                    break;
            }
        }
        $results = \GuzzleHttp\Promise\unwrap($promises);
        $resolve = [$this->parse($results[0])];
        $index = 1;
        foreach ($includes as $value) {
            $resolve[] = $this->parse($results[$index]);
            $index++;
        }
        return $resolve;
    }

    /**
     * Get all product with given shopId
     *
     * @param  mixed $shopId Shop's id
     * @return \App\Service\ShopService
     */
    public function products($shopId, array $options = [])
    {
        $query = array_merge($this->defaultQuery, $options, [
            'id' => $shopId
        ]);

        $this->response = $this->client->request('GET', 'shopproduct', [
            'query' => $query,

        ]);
        return $this;
    }

    /*
    * @author nam.nt
    * @return data used for amp page
    */

    public function getAndConvertDataFromShop($shop)
    {
      $shopName = isset($shop->item->facility_name) ? $shop->item->facility_name : '';
      $stationName = isset($shop->item->station1) ? $shop->item->station1 : '';
      $imageOg  = isset($shop->item->sub_image1) ? $shop->item->sub_image1 : '';

      $district = !empty($shop->item->district) ? $shop->item->district : '';
      $buildingName = !empty($shop->item->building_name) ? $shop->item->building_name : '';

      if ($district && $buildingName) {
        $streetAddress = $district.$buildingName;
      }else{
        if ($district) {
          $streetAddress = $district;
        }else{
          $streetAddress = $buildingName;
        }
      }

      $prov_name = !empty($shop->item->prov_name) ? $shop->item->prov_name : '';
      $city = !empty($shop->item->city) ? $shop->item->city : '';
      $tel_no = !empty($shop->item->tel_no) ? $shop->item->tel_no : '';

      return [
        'shopName' => $shopName,
        'stationName' => $stationName,
        'imageOg' => $imageOg,
        'streetAddress' => $streetAddress,
        'prov_name' => $prov_name,
        'tel_no' => $tel_no,
        'city' => $city,
      ];
    }
}
