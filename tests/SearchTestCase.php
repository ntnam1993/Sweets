<?php

namespace Tests;

use GuzzleHttp\Client;
use TestCase;

class SearchTestCase extends TestCase
{

    protected $client;
    protected $defaultQuery = [];

    public function __construct()
    {
        $client = new Client(['base_uri' => env('API_URL')]);
        $this->defaultQuery = [
            'app_id' => env('APP_ID'),
            'pass' => env('PASS'),
            'sort' => 0,
        ];
    }

    public function request($method, $uri, $query)
    {
        $response = $this->client->request($method, $uri);
        $response = json_decode($response->getBody());
        return $response;
    }

    public function productSearch($query = [])
    {
        $query = array_merge($this->defaultQuery, $query);
        return $this->request('GET', 'productgroupsearch', $query);
    }

    public function shopSearch($query = [])
    {
        $query = array_merge($this->defaultQuery, $query);
        return $this->request('GET', 'productgroupsearch', $query);
    }

}
