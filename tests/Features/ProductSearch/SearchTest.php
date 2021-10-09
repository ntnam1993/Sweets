<?php

namespace Tests\Features\ProductSearch;

use GuzzleHttp\Client;
use TestCase;

class SearchTest extends TestCase
{

    protected $client;
    protected $stationId;
    protected $subRegionSlug;
    protected $parentRegionSlug;
    protected $genreId;
    protected $keyword;
    protected $stationIdHaveProduct;
    protected $keywordHaveProduct;
    protected $keywordNoneHaveProduct;

    const NUMBER_OF_PRODUCT = 20;

    public function setUp()
    {
        parent::setUp();

        $this->client = new Client(['base_uri' => env('API_URL')]);
        $this->stationId = 791;
        $this->subRegionSlug = 'morioka';
        $this->parentRegionSlug = 'iwate';
        $this->genreId = 8;
        $this->keyword = 'akira';
        $this->stationIdHaveProduct = 2433;
        $this->keywordHaveProduct = 'ふたつ木';
        $this->keywordNoneHaveProduct = 'yukita';
    }

    private function getTotalProductsFromAPI()
    {
        $query = [
            'app_id' => env('APP_ID'),
            'pass' => env('PASS'),
        ];
        $response = $this->client->get('productgroupsearch', [
            'query' => $query,
        ]);
        return json_decode($response->getBody());
    }

    private function getStationSearchFromAPI($stationId = null, $keyword = null)
    {
        $query = [
            'app_id' => env('APP_ID'),
            'pass' => env('PASS'),
            'station' => $stationId,
            'keyword' => $keyword,
        ];

        $response = $this->client->get('productgroupsearch', [
            'query' => $query,
        ]);

        return json_decode($response->getBody());
    }

    public function testStationHaveProduct()
    {
        $productsFromAPI = $this->getStationSearchFromAPI($this->stationIdHaveProduct)->num_found;
        $this->visitRoute('product.index.station', $this->stationIdHaveProduct);
        $products = $this->crawler->filter('.ul-list-item-main > li')->count();
        $this->assertEquals($productsFromAPI, $products);
    }

    public function testStationKeywordHaveProduct()
    {
        $productsFromAPI = $this->getStationSearchFromAPI($this->stationIdHaveProduct, $this->keywordHaveProduct)->num_found;
        $this->visitRoute('product.index.station', [
            'station' => $this->stationIdHaveProduct,
            'keyword' => $this->keywordHaveProduct,
        ]);

        $products = $this->crawler->filter('.ul-list-item-main > li')->count();
        $this->assertEquals($products, $productsFromAPI);
    }

    public function testStationKeywordNoneHaveProduct()
    {
        $productsFromAPI = $this->getStationSearchFromAPI($this->stationIdHaveProduct, $this->keywordNoneHaveProduct)->num_found;
        $this->visitRoute('product.index.station', [
            'station' => $this->stationIdHaveProduct,
            'keyword' => $this->keywordNoneHaveProduct,
        ]);
        $this->assertEquals(0, $productsFromAPI);
    }

    public function testTotalNumberOfProduct()
    {
        $totalProductsFromAPI = $this->getTotalProductsFromAPI()->num_found;
        $this->visitRoute('product.index.all');
        $totalProduct = $this->getTotalProducts();
        $this->assertEquals($totalProductsFromAPI, $totalProduct);
    }

    public function testTotalNumberOfProductSP()
    {
        $totalProductsFromAPI = $this->getTotalProductsFromAPI()->num_found;
        $this->setMobileAgent()
            ->visitRoute('product.index.all');
        $totalProducts = $this->getTotalProductsSP();
        $this->assertEquals($totalProductsFromAPI, $totalProducts);
    }

    public function testTotalNumberOfPagePaginatedSP()
    {
        $this->setMobileAgent()
            ->visitRoute('product.index.all');
        $totalProducts = $this->getTotalProductsSP();
        $totalPages = $this->getNumberOfPagesSP();
        $this->assertEquals(ceil($totalProducts / self::NUMBER_OF_PRODUCT), $totalPages);
    }

    public function testNumberOfProductInPageSP()
    {
        $this->setMobileAgent()
            ->visitRoute('product.index.all');
        $totalProducts = $this->getTotalProductsSP();
        $totalPages = $this->getNumberOfPagesSP();
        if ($totalProducts > self::NUMBER_OF_PRODUCT) {
            for ($i = 1; $i < $totalPages; $i++) {
                if (1 == $i || ceil($totalPages / 2) == $i || ($totalPages - 1) == $i) {
                    $this->visit('/all?page=' . $i);
                    $this->assertEquals(self::NUMBER_OF_PRODUCT, $this->getNumberOfShownProductSP());
                }
            }
        }
    }

    public function testRemoveSearchIconSP()
    {
        $this->setMobileAgent()
            ->visitRoute('product.index.all');
        $imgSearch = $this->crawler->filter('img[class="icon-search-green"]')->count();
        $this->assertEquals(0, $imgSearch);
    }

    public function testRemoveTabsProductsSP()
    {
        $this->setMobileAgent()
            ->visitRoute('product.index.all');
        $tabs = $this->crawler->filter('ul.ul-tab-mn')->count();
        $this->assertEquals(0, $tabs);
    }

    public function testRemoveBlackBarBottomSP()
    {
        $this->setMobileAgent()
            ->visitRoute('product.index.all');
        $blackBar = $this->crawler->filter('div.show-price-gps')->count();
        $this->assertEquals(0, $blackBar);
    }

    public function testGenreTitleSP()
    {
        $this->setMobileAgent()
            ->visitRoute('product.index.all', ['genre_id' => $this->genreId])
            ->see('デザートで見つかった商品');
    }

    public function testStationTitleSP()
    {
        $this->setMobileAgent()
            ->visitRoute('product.index.station', ['station' => $this->stationId])
            ->seeJP('花巻駅で見つかった商品');
    }

    public function testSubRegionTitelSP()
    {
        $this->setMobileAgent()
            ->visitRoute('product.index', ['sub_region' => $this->subRegionSlug])
            ->see('盛岡市で見つかった商品');
    }

    public function testRegionTitleSP()
    {
        $this->setMobileAgent()
            ->visitRoute('product.index', ['region' => $this->parentRegionSlug, 'sub_region' => $this->subRegionSlug])
            ->see('盛岡市で見つかった商品');
    }

    public function testPriorityGenreAndTextTitleSP()
    {
        $query = [
            'genre_id' => $this->genreId,
            'keyword' => $this->keyword,
        ];
        $this->setMobileAgent()
            ->visitRoute('product.index.all', $query)
            ->see('デザートで見つかった商品');
    }

    public function testPriorityGenreTitleSP()
    {
        $query = [
            'region' => $this->parentRegionSlug,
            'sub_region' => $this->subRegionSlug,
            'genre_id' => $this->genreId,
            'keyword' => $this->keyword,
        ];
        $this->setMobileAgent()
            ->visitRoute('product.index', $query)
            ->see('デザートで見つかった商品');
    }

    public function testTextSearchTitleSP()
    {
        $this->setMobileAgent()
            ->visitRoute('product.index.all', ['keyword' => $this->keyword])
            ->see('akiraで見つかった商品');
    }

    private function getTotalProductsSP()
    {
        $totalProducts = $this->crawler->filter('.shoplist-ctrl div.total')->first()->text();
        $totalProducts = trim($totalProducts, '件');
        return intval($totalProducts);
    }

    private function getNumberOfPagesSP()
    {
        $totalPages = $this->crawler->filter('.paging ul li')->last()->text();
        return $totalPages;
    }

    private function getNumberOfShownProductSP()
    {
        return $this->crawler->filter('ul.ul-lists-list > li.list-item-detail')->count();
    }

    public function testTotalNumberOfPagePaginated()
    {
        $totalProduct = $totalPages = 0;
        $this->visitRoute('product.index.all')
            ->pipe(function () use (&$totalProduct, &$totalPages) {
                $totalProduct = $this->getTotalProducts();
                $totalPages = $this->getNumberOfPages();
            })
            ->assertEquals(ceil($totalProduct / self::NUMBER_OF_PRODUCT), $totalPages);
        echo PHP_EOL . "Total Product: {$totalProduct}";
        echo PHP_EOL . "Total Pages  : {$totalPages}";
    }

    public function testNumberOfProductInLastPage()
    {
        $this->visitRoute('product.index.all');
        $totalProduct = $this->getTotalProducts();
        $totalPages = $this->getNumberOfPages();
        if ($totalProduct <= self::NUMBER_OF_PRODUCT) {
            $totalPages = 1;
        }
        $numberOfProductInLastPage = $totalProduct - ($totalPages - 1) * self::NUMBER_OF_PRODUCT;
        echo PHP_EOL . "Total Product: {$totalProduct}";
        echo PHP_EOL . "Total Pages: {$totalPages}";
        echo PHP_EOL . "Total Shown: {$numberOfProductInLastPage}";
        $this->visit('/all?page=' . $totalPages);
        $this->assertEquals($numberOfProductInLastPage, $this->getNumberOfShownProduct());
    }

    public function testNumberOfProductInPage()
    {
        $this->visitRoute('product.index.all');
        $totalProduct = $this->getTotalProducts();
        $totalPages = $this->getNumberOfPages();
        if ($totalProduct > self::NUMBER_OF_PRODUCT) {
            for ($i = 1; $i < $totalPages; $i++) {
                if (1 == $i || ceil($totalPages / 2) == $i || ($totalPages - 1) == $i) {
                    $this->visit('/all?page=' . $i);
                    $this->assertEquals(self::NUMBER_OF_PRODUCT, $this->getNumberOfShownProduct());
                }
            }
        }
    }

    private function getTotalProducts()
    {
        $totalProduct = $this->crawler->filter('.p-bot-mn strong')->first()->text();
        $totalProduct = trim($totalProduct, '件');
        return intval($totalProduct);
    }

    private function getNumberOfPages()
    {
        $totalPages = $this->crawler->filter('.paging ul li')->last()->text();
        return $totalPages;
    }

    private function getNumberOfShownProduct()
    {
        return $this->crawler->filter('.ul-list-item-main > li')->count();
    }
}
