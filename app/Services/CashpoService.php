<?php

namespace App\Services;

use App\Helpers\EparkEncrypter;
use App\Shop;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class CashpoService
{
    const VALUE_TYPE_DEFAULT=1;
    protected $passportService;
    protected $eparkEncrypter;

    public function __construct(PassportService $passportService, EparkEncrypter $eparkEncrypter)
    {
        $this->passportService = $passportService;
        $this->eparkEncrypter = $eparkEncrypter;
    }

    public function getCashpo($accessToken, $eparkMemberId)
    {
        $url = env('INQUIRY_BALANCE_ACCESS_TOKEN');
        $headers = array(
            "Authorization: Bearer $accessToken",
        );
        $postData = array(
                'epark_member_id' => $eparkMemberId,
                'value_type_id'   => self::VALUE_TYPE_DEFAULT
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, config('common.API_TIMEOUT'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $responseBody = curl_exec($ch);
        if(curl_errno($ch)) {
            //
        }
        curl_close($ch);
        if ($responseBody) {
            return [
                json_decode($responseBody)->available_balance_value,
                json_decode($responseBody)->expire_date,
            ];
        }else{
            return [
                0,
                null
            ];
        }
    }

    public function processSaveCouponCashpo($dataCouponCashpo, $shopCoupon, $parentAndChildProduct)
    {
        $cashpoPrice = $shopCoupon->cashpo_price;
        if ($shopCoupon->cashpo_rate) {
            $cashpoPrice = ($parentAndChildProduct['product_price'] * $shopCoupon->cashpo_rate)/100;
        }
        if ($shopCoupon->cashpo_price > $parentAndChildProduct['product_price']){
            $cashpoPrice =$parentAndChildProduct['product_price'];
        }
        if (ceil($cashpoPrice) > 0) {
            $cashpoCoupons = [
                'price' => ceil($cashpoPrice),
                'receiptable_from' =>  $shopCoupon->receiptable_period_start,
                'receiptable_to' => $shopCoupon->receiptable_period_end
            ];
            array_push($dataCouponCashpo[$parentAndChildProduct['product_id']]['cashpo_coupons'], $cashpoCoupons);
        }
        return $dataCouponCashpo;
    }

    public function processSaveDirectCoupon($dataCouponCashpo, $shopCoupon, $parentAndChildProduct)
    {
        $discountPrice = $shopCoupon->discount_price;
        if ($shopCoupon->discount_type == Shop::COUPON_TYPE_DIRECT_RATIO) {
            $discountPrice = ($parentAndChildProduct['product_price'] * $shopCoupon->discount_rate)/100;
        }
        if ($shopCoupon->discount_price > $parentAndChildProduct['product_price']) {
            $discountPrice = $parentAndChildProduct['product_price'];
        }
        if (ceil($discountPrice) > 0) {
            $direct_coupons = [
                'price' => ceil($discountPrice),
                'receiptable_from' =>  $shopCoupon->receiptable_period_start,
                'receiptable_to' => $shopCoupon->receiptable_period_end
            ];
            array_push($dataCouponCashpo[$parentAndChildProduct['product_id']]['direct_coupons'], $direct_coupons);
        }
        return $dataCouponCashpo;
    }
}
