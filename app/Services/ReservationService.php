<?php

namespace App\Services;

class ReservationService extends EparkService
{
    public function getReceiptDates($params = [])
    {
        $arrReceiptDate = array_merge($this->defaultQuery, $params, ['timeout' => $this->timeout]);
        $query = http_build_query($arrReceiptDate);
        $query = urldecode($query);
        $this->response = $this->client->request('GET', 'receiptdate?' . $query);
        return $this->getBody();
    }

    public function requestAsyncReceiptDate($params = [])
    {
        $query = array_merge($this->defaultQuery, $params);
        $this->response = $this->client->requestAsync('GET', 'receiptdate', [
            'query' => $query
        ]);
        return $this->response;
    }

    public function postReserve($params = [])
    {
        $query = array_merge($this->defaultQuery, ['catalog_id' => $params['shopId']]);
        $query = http_build_query($query);
        $query = urldecode($query);
        $this->response = $this->client->request('POST', 'reserve?' . $query, [
            'multipart' => $params['output']
        ]);
        return $this->getBody();
    }
}
