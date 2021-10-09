<?php

namespace Tests\Features\ShopSearch;

use GuzzleHttp\Client;
use TestCase;

class SearchTest extends TestCase
{
    protected $stationId;
    protected $keywordNoneHaveShop;
    protected $keywordHaveShop;

    public function setUp()
    {
        parent::setUp();

        $this->client = new Client(['base_uri' => env('API_URL')]);
        $this->stationId = 2430;
        $this->keywordNoneHaveShop = 'akira';
        $this->keywordHaveShop = 'Salon de The Un Gateau';
    }

    private function getStationSearchFromAPI($stationId = null, $keyword = null)
    {
        $query = [
            'app_id' => env('APP_ID'),
            'pass' => env('PASS'),
            'station' => $stationId,
            'keyword' => $keyword,
        ];

        $response = $this->client->get('shopsearch', [
            'query' => $query,
        ]);

        return json_decode($response->getBody());
    }

    public function testStationHaveShop()
    {
        $shopsFromAPI = $this->getStationSearchFromAPI($this->stationId)->num_found;
        $this->visitRoute('shopsearch.station', $this->stationId);
        $shops = $this->crawler->filter('.ul-list-shop-main > li')->count();
        $this->assertEquals($shops, $shopsFromAPI);
    }

    public function testKeywordHaveShop()
    {
        $shopsFromAPI = $this->getStationSearchFromAPI($this->stationId, $this->keywordHaveShop)->num_found;
        $this->visitRoute('shopsearch.station', [
            'station' => $this->stationId,
            'keyword' => $this->keywordHaveShop,
        ]);
        $shops = $this->crawler->filter('.ul-list-shop-main > li')->count();
        $this->assertEquals($shops, $shopsFromAPI);
    }

    public function testKeywordNoneHaveShop()
    {
        $shopsFromAPI = $this->getStationSearchFromAPI($this->stationId, $this->keywordNoneHaveShop)->num_found;
        $this->visitRoute('shopsearch.station', [
            'station' => $this->stationId,
            'keyword' => $this->keywordNoneHaveShop,
        ]);
        $shops = $this->crawler->filter('.ul-list-shop-main > li')->count();
        $this->assertEquals($shops, $shopsFromAPI);
    }
}
