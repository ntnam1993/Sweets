<?php

namespace App\Services;

class PassportService extends Service
{
    protected $apiUrl = '';
    protected $appId = '';
    protected $pass = '';

    public function uri()
    {
        $this->apiUrl = config('epark.passport.api_url');
        $this->appId = config('epark.passport.app_id');
        $this->pass = config('epark.passport.pass');

        return $this->apiUrl;
    }

    public function token($options = [])
    {
        $defaultQuery = [
            'app_id' => $this->appId,
            'pass' => $this->pass,
        ];
        $this->response = $this->client->request('GET', 'token', [
            'query' => array_merge($defaultQuery, $options),
        ]);

        return $this;
    }
}
