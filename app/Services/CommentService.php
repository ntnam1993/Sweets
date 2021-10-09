<?php

namespace App\Services;

use GuzzleHttp\Client;

class CommentService extends Service
{

    protected $authCode;
    protected $serviceId;
    protected $shopOwnerId;
    protected $query;

    public function __construct()
    {
        parent::__construct();
        $this->authCode = env('SHOP_AUTH_CODE') . '_' . env('SWEETS_AUTH_CODE');
        $this->serviceId = env('SHOP_SERVICE_ID') . '_' . env('SWEETS_SERVICE_ID');
        $this->shopOwnerId = env('SHOP_OWNER_ID');

        $this->query = [
            'service_id' => $this->serviceId,
            'auth_code' => $this->authCode,
            'shopowner_id' => $this->shopOwnerId,
        ];
    }

    public function uri()
    {
        return env('API_URL_COMMENT');
    }

    public function search($query = [])
    {
        $this->searchAsync($query);
        $this->response = $this->response->wait();
        return $this;
    }

    public function searchAsync($query = [])
    {
        $this->query = array_merge($this->query, $query);
        $this->response = $this->client->requestAsync('GET', 'search', ['query' => $this->query]);
        return $this;
    }

    public function addReferenceCount($query)
    {
        $this->query = array_merge($this->query, $query);
        $this->response = $this->client->request('GET', 'addreferencecount', ['query' => $this->query]);
        return $this;
    }
}
