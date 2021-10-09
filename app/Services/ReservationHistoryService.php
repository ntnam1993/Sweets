<?php

namespace App\Services;

use GuzzleHttp\Client;

class ReservationHistoryService extends Service
{

    public function uri()
    {
        return env('URL_API_HISTORY');
    }

    public function requestAsyncReservationHistory($params = [])
    {
        $this->response = $this->client->requestAsync('POST', 'find?', [
            'query' => $params
        ]);
        return $this->response;
    }

}
