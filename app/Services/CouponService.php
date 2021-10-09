<?php

namespace App\Services;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class CouponService extends EparkService
{
    /**
     * Get coupon
     * @param  string $cp_code
     * @return \App\Services\CouponService
     */
    public function getCoupon($cp_code)
    {
        $query = array_merge($this->defaultQuery, compact('cp_code'));
        $this->response = $this->client->request('GET', 'getcoupon', [
            'query' => $query
        ]);
        return $this;
    }

    /**
     * Save Coupont
     * @param  string $coupon_id
     * @return \App\Services\CouponService
     */
    public function saveCoupon($eparkMemberId, $coupon_id, $get_count = 0)
    {
        $query = array_merge($this->defaultQuery, [
            'member_id' => $eparkMemberId,
        ]);

        $payload = $get_count == 0 ? compact('coupon_id') : compact('coupon_id', 'get_count');
        $this->response = $this->client->request('POST', 'savecoupon', [
            'query' => $query,
            'form_params' => $payload
        ]);
        return $this;
    }

    public function getMembersCoupon($payload = [], $eparkMemberId = null)
    {
        if ($eparkMemberId) {
            $payload = array_merge([
                'member_id' => $eparkMemberId,
            ], $payload);
        }

        $this->response = $this->client->request('POST', 'getmemberscoupon', [
            'query' => $this->defaultQuery,
            'form_params' => $payload
        ]);

        return $this;
    }

    public function getCodeStatus($planId, $eparkMemberId)
    {
        $url = env('GET_CODE_STATUS_URL');
        $postData = array(
            'plan_id' => $planId,
            'epark_id' => $eparkMemberId
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, config('common.API_TIMEOUT'));
        $responseBody = curl_exec($ch);
        if (curl_errno($ch)) {
            // エラー
            return false;
        }
        curl_close($ch);

        // catch case change domain then response is null
        if (json_decode($responseBody) == null)
            return false;

        return json_decode($responseBody);
    }

    public function changeStatusOfPoint($planId, $couponCode, $couponStatus, $eparkMemberId)
    {
        $url = env('CHANGE_STATUS_OF_POINT_URL');
        $postData = array(
            'plan_id' => $planId,
            'epark_id' => $eparkMemberId,
            'coupon_code'=> $couponCode,
            'coupon_status' => $couponStatus
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, config('common.API_TIMEOUT'));
        $responseBody = curl_exec($ch);
        if(curl_errno($ch)) {
            // エラー
            return false;
        }
        curl_close($ch);

        // catch case change domain then response is null
        if (json_decode($responseBody) == null)
            return false;

        return json_decode($responseBody);
    }
}
