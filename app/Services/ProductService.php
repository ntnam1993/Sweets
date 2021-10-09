<?php

namespace App\Services;

class ProductService extends EparkService
{

    public function getProductItem($productId, $params = [])
    {
        $query = array_merge($this->defaultQuery, ['product_id' => $productId]);
        $query = array_merge($query, $params);
        $this->response = $this->client->request('GET', 'productitems', compact('query'));
        return $this->getBody();
    }

    public function requestAsyncProducts($productId)
    {
        $query = array_merge($this->defaultQuery, ['product_id' => $productId]);
        $this->response = $this->client->requestAsync('GET', 'productitems', compact('query'));
        return $this->response;
    }

    public function getProductSearch($params = [])
    {
        $query = array_merge($this->defaultQuery, $params);
        $this->response = $this->client->request('GET', 'productgroupsearch', compact('query'));
        return $this->getBody();
    }

    public function requestAsyncProductGroupSearch($query = [])
    {
        $this->response = $this->client->requestAsync('GET', 'productgroupsearch', compact('query'));
        return $this->response;
    }

    public function requestAsyncShopProduct($query)
    {
        $query = array_merge($this->defaultQuery, $query);
        $this->response = $this->client->requestAsync('GET', 'shopproduct', compact('query'));
        return $this;
    }
    public function getAndConvertDataFromProduct($item, $shop)
    {
      $image = '';
      $description = '';
      for($i=1; $i<=10; $i++) {
        $product_image = "product_image$i";
        $product_description = "product_description$i";
        if (!empty($item->item->$product_image) && empty($image)) {
            $image = $item->item->$product_image;
        }
        if (!empty($item->item->$product_description) && empty($description)) {
            $description = $item->item->$product_description;
        }
        if (!empty($image) && !empty($description)) break;
      }
      $productName = isset($item->item->product_name) ? $item->item->product_name : '';
      $shopName = isset($shop->item->facility_name) ? $shop->item->facility_name : '';
      $title = $productName.' ('.$shopName.')'.'｜EPARKスイーツガイド';
      $imageOg  = isset($item->item->product_image1) ? $item->item->product_image1 : '';

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
        'productName' => $productName,
        'title' => $title,
        'imageOg' => $imageOg,
        'streetAddress' => $streetAddress,
        'prov_name' => $prov_name,
        'tel_no' => $tel_no,
        'city' => $city,
      ];
    }
}
