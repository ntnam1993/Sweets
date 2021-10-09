<?php

namespace App\Adapters;

class ReservationAdapter
{
    public function normalizeResponse(\stdClass $response)
    {
        if (empty($response)) {
            return (object) [];
        }
        $response->num_found = $response->total_count;
        $response->items = $response->list;
        unset($response->total_count);
        unset($response->list);
        return $response;
    }
}
