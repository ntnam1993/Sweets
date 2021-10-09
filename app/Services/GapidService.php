<?php

namespace App\Services;

use GuzzleHttp\Exception\RequestException;

class GapidService extends Service
{
    protected $appId;
    protected $pass;

    protected $defaultQuery = [];

    public function __construct()
    {
        $this->appId = env('APP_ID');
        $this->pass = env('PASS');

        $this->defaultQuery = [
            'app_id' => $this->appId,
            'pass' => $this->pass,
        ];
    }

    public function uri()
    {
        return env('POINT_INQUIRY_URL');
    }

    
    public function getTotalPoint($query)
    {
        try {
            $query = array_merge($this->defaultQuery, $query);
            $this->response = $this->client->requestAsync('GET', 'inquiry' , compact('query'));
            return $this->response;
        } catch (RequestException $e) {
            Log::error($e->getMessage());
            return null;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }
    
}
