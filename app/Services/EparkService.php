<?php

namespace App\Services;

class EparkService extends Service
{

    protected $appId;
    protected $pass;

    protected $defaultQuery = [];

    public function __construct()
    {
        parent::__construct();
        $this->appId = env('APP_ID');
        $this->pass = env('PASS');

        $this->defaultQuery = [
            'app_id' => $this->appId,
            'pass' => $this->pass,
        ];
    }

    public function uri()
    {
        return env('API_URL');
    }

}
