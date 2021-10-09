<?php

namespace App\Adapters;

use App\Services\CouponService;
use Illuminate\Container\Container;
use Log;

class CouponAdapter
{

    protected $agent;
    protected $isMobile;
    protected $path;
    protected $couponService;

    public function __construct(
        Container $app,
        CouponService $couponService
    ) {
        $this->agent = $app->make('agent');

        $this->isMobile = $this->agent->isMobile() && !$this->agent->isIpad() ? true : false;
        $this->path = $this->isMobile ? 'mobile.' : '';
        $this->couponService = $couponService;
    }

    /**
     * Handling response from calling getcoupon api endpoint
     * @param  mixed $response
     * @return mixed
     */
    public function handleGetResponse($response)
    {
        $errors = is_array($response->errors) ? $response->errors[0] : $response->errors;

        switch ($errors->code) {
            case '2032':
            case '3214':
            case '5225':
                return view("coupon.errors.{$this->path}ui1");

            case '5229':
            case '5232':
                return view("coupon.errors.{$this->path}ui3");

            case '5223':
            case '5231':
            case '5233':
            case '5234':
                return view("coupon.errors.{$this->path}ui4");

            default:
                Log::error(
                    'Uncaught Exception while getting response from getcoupon api'
                    . PHP_EOL
                    . print_r($response, true)
                );
                return view("coupon.errors.{$this->path}ui2");
        }
    }

    /**
     * Handling response from calling savecoupon api endpoint
     * @param  mixed $response
     * @return mixed
     */
    public function handleSaveResponse($response, $coupon = null)
    {
        $errors = is_array($response->errors) ? $response->errors[0] : $response->errors;

        if (empty($errors->code)) {
            abort(500, 'Uncaught Exception while getting response from savecoupon api');
        }

        switch ($errors->code) {
            case '5224':
                $coupon_obtained = true;

                // Get redirect URL when it's acquired
                if (!empty($coupon) && !empty($coupon->redirect_url)) {
                    view()->share('redirectUrl', $coupon->redirect_url);
                }

                return view("coupon.{$this->path}thanks", compact('coupon_obtained'));

            case '3211':
            case '5222':
                return view("coupon.errors.{$this->path}ui1");

            case '3210':
            case '5221':
                return view("coupon.errors.{$this->path}ui2");

            case '5229':
            case '5232':
                return view("coupon.errors.{$this->path}ui3");

            case '5231':
            case '5233':
            case '5234':
                return view("coupon.errors.{$this->path}ui4");

            default:
                abort(
                    500,
                    'Uncaught Exception while getting response from savecoupon api'
                    . PHP_EOL
                    . print_r($response, true)
                );
        }
    }
}
