<?php

namespace App\Http\Controllers;

use App\Adapters\CouponAdapter;
use App\Services\CouponService;
use App\Services\PassportService;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CouponController extends BaseController
{

    const CP_CODE_PARAM_NAME = 'cp_code';
    const CP_CODE_UNUSED_TXT = '未利用';
    const CP_CODE_USED_TXT = '利用済み';
    const CODE_TXT_VIEW = 'view';
    const CODE_TXT_URL = 'url';
    const CODE_TXT_500 = 'abort_500';
    const UNUSED_COUPON_NUMBER = 0;
    const CODE_RESPONSE_500 = 500;

    protected $couponService;
    protected $passportService;
    protected $couponAdapter;

    public function __construct(
        CouponService $couponService,
        PassportService $passportService,
        CouponAdapter $couponAdapter
    ) {
        parent::__construct();

        $this->couponService = $couponService;
        $this->passportService = $passportService;
        $this->couponAdapter = $couponAdapter;
    }

    public function index(Request $request)
    {
        // Handling whether cp_code is not exists in request
        if (!$request->has(self::CP_CODE_PARAM_NAME)) {
            return view("coupon.errors.{$this->path}ui1");
        }
        $cp_code = $request->cp_code;
        $product_id = isset($request->product_id) ? $request->product_id : '';

        // Handling Exception
        try {
            $coupon = $this->couponService->getCoupon($cp_code)->getBody();

            if ($this->checkLogin()) {
                $accessToken = $this->accessToken;
                $options = [
                    'access_token' => $accessToken,
                ];

                $passportResponse = $this->passportService->token($options)->getBody();
                if (!$passportResponse) {
                    return redirect(env('SWEETS_REISSUE_TOKENS_ENDPOINT') . '?callerPageType=1&afterLoginPath=' . urlencode(getCurrentPathWithQuery()));
                }
                $passportIds = collect($passportResponse->passport_array)->pluck('passport_id')->toArray();

                if (!empty($coupon->passport_id) && !in_array($coupon->passport_id, $passportIds)) {
                    return view("coupon.errors.{$this->path}box", [
                        'error_message' => 'クーポン取得条件を満たしておりません。',
                    ]);
                }

                // if cp_code have plan_id not null
                $planId = $coupon->plan_id;
                $usageFrequency = 0;
                if ($planId) {
                    $result =  $this->processCouponSpecial($coupon, $planId, $this->getEparkMemberId());
                    switch ($result['code']) {
                        case self::CODE_TXT_URL: {
                            // redirect with change status Done
                            Log::info('API changeStatusOfPoint update Done -> redirectUrl: ' . $result['url']);
                            return redirect($result['url']);
                            break;
                        }
                        case self::CODE_TXT_VIEW: {
                            Log::info('save Coupon Special -> return view error: ' . $result['view']);
                            return view($result['view']);
                            break;
                        }
                        case self::CODE_TXT_500: {
                            Log::info('save Coupon Special -> return view error 500: ' . $result['abort_500']);
                            abort(self::CODE_RESPONSE_500, $result['abort_500']);
                            break;
                        }
                        default:
                            break;
                    }
                    // write log account login and cp_code
                    Log::info('Coupon special account: ', ['epark_member_id' => $this->getEparkMemberId(), 'cp_code' => $cp_code]);
                }elseif(!empty($coupon->usage_frequency)){
                    $usageFrequency = $coupon->usage_frequency;
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return view("coupon.errors.{$this->path}ui2");
        }

        // Handling Error Response
        if ('0' != $coupon->status) {
            return $this->couponAdapter->handleGetResponse($coupon);
        }

        return view("coupon.{$this->path}index", compact('coupon', 'product_id', 'cp_code', 'usageFrequency'));
    }

    /**
     * Thanks page (/coupon/thanks)
     * @param  Request $request
     * @return View
     */
    public function save(Request $request)
    {
        // Whether there is no cp_code provided
        if (empty($request->cp_code)) {
            abort(self::CODE_RESPONSE_500, 'There\'s no cp_code.');
        }

        // Retrieve cp_code from request
        $cp_code = $request->cp_code;
        $get_count = $request->get_count;
        $product_id = isset($request->product_id) ? $request->product_id : '';
        $redirectUrl = url('mypage/coupon');
        if ($product_id) {
            $redirectUrl = route('product.detail', $product_id);
        }

        // Handle login state and send back to /coupon?cp_coupon
        // if user not logged in
        if (!$this->checkLogin()) {
            return redirect()->route('coupon.index', compact('cp_code', 'product_id'));
        }

        // Get coupon_id from API by passing cp_code from request
        $coupon = $this->couponService->getCoupon($cp_code)->getBody();

        view()->share('coupon', $coupon);
        view()->share('redirectUrl', $redirectUrl);

        $this->processSaveCoupon($coupon, $this->getEparkMemberId(), false, $get_count);

        return view("coupon.{$this->path}thanks");
    }

    private function processSaveCoupon($coupon, $eparkMemberId, $isCouponSpecial = false, $getCount = 0, $dataGetCodeStatus = [])
    {
        // Handling Exception
        try {
            $couponId = $coupon->coupon_id;
            $response = $this->couponService->saveCoupon($eparkMemberId, $couponId, $getCount)->getBody();

            /**
             * Handle response is empty
             */
            if (empty($response)) {
                if ($isCouponSpecial) {
                    return [
                        'code' => self::CODE_TXT_VIEW,
                        'view' => "coupon.errors.{$this->path}ui2"
                    ];
                }

                return view("coupon.errors.{$this->path}ui2");
            }
        } catch (RequestException $e) {
            Log::error($e->getMessage());
            if ($isCouponSpecial) {
                return [
                    'code' => self::CODE_TXT_VIEW,
                    'view' => "coupon.errors.{$this->path}ui2"
                ];
            }

            return view("coupon.errors.{$this->path}ui2");
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            if ($isCouponSpecial) {
                return [
                    'code' => self::CODE_TXT_500,
                    'abort_500' => $e->getMessage()
                ];
            }
            abort(self::CODE_RESPONSE_500, $e->getMessage());
        }

        if ($isCouponSpecial) {
            // Error Handling
            if ('0' != $response->status) {
                return [
                    'code' => self::CODE_TXT_VIEW,
                    'view' => "coupon.errors.{$this->path}ui2"
                ];
            }

            // OK
            $planId = $coupon->plan_id;
            return $this->processChangeStatusOfPoint($planId, $dataGetCodeStatus, $response->redirect_url, $eparkMemberId);
        }

        // Error Handling
        if ('0' != $response->status) {
            return $this->couponAdapter->handleSaveResponse($response, $coupon);
        }
        if (!empty($response->redirect_url)) {
            view()->share('redirectUrl', $response->redirect_url);
        }
    }

    private function processCouponSpecial($coupon, $planId, $eparkMemberId)
    {
        try {
            $dataGetCodeStatus = $this->couponService->getCodeStatus($planId, $eparkMemberId);

            // check api fail
            if (is_bool($dataGetCodeStatus) && !$dataGetCodeStatus) {
                Log::error('API getCodeStatus fail -> show ui2');
                return [
                    'code' => self::CODE_TXT_VIEW,
                    'view' => "coupon.errors.{$this->path}ui2"
                ];
            }

            // check api fail
            if (is_object($dataGetCodeStatus) && $dataGetCodeStatus->error_code == '1001') {
                Log::error('API getCodeStatus fail (error_code == 1001) -> show ui3');
                return [
                    'code' => self::CODE_TXT_VIEW,
                    'view' => "coupon.errors.{$this->path}ui3"
                ];
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'code' => self::CODE_TXT_500,
                'abort_500' => $e->getMessage()
            ];
        }

        // count coupon unused
        $dataGetCodeStatusUnused = [];
        $unusedCouponNumber = self::UNUSED_COUPON_NUMBER;
        if (!empty($dataGetCodeStatus)) {
            foreach ($dataGetCodeStatus as $value) {
                if (isset($value->status) && $value->status == self::CP_CODE_UNUSED_TXT) {
                    $dataGetCodeStatusUnused[] = $value;
                    $unusedCouponNumber++;
                }
            }
        }

        // check $unusedCouponNumber = 0
        if ($unusedCouponNumber == self::UNUSED_COUPON_NUMBER) {
            Log::error('unusedCouponNumber = '. self::UNUSED_COUPON_NUMBER .' so system will show ui3');
            // return screen error without unused coupon
            return [
                'code' => self::CODE_TXT_VIEW,
                'view' => "coupon.errors.{$this->path}ui3"
            ];
        }

        // save coupon
        return $this->processSaveCoupon($coupon, $eparkMemberId, true, $unusedCouponNumber, $dataGetCodeStatusUnused);
    }

    private function processChangeStatusOfPoint($planId, $dataGetCodeStatus, $redirectUrl, $eparkMemberId)
    {
        $couponStatus = self::CP_CODE_USED_TXT;
        if (!empty($dataGetCodeStatus)) {
            foreach ($dataGetCodeStatus as $code) {
                try {
                    $couponCode = $code->coupon_code;
                    $statusChange = $this->couponService->changeStatusOfPoint($planId, $couponCode, $couponStatus, $eparkMemberId);
                    if ((isset($statusChange->error_code) && in_array($statusChange->error_code, ['1001', '2001'])) || (is_bool($statusChange) && !$statusChange)) {
                        Log::error($statusChange->error_message);
                        return [
                            'code' => self::CODE_TXT_VIEW,
                            'view' => "coupon.errors.{$this->path}ui2"
                        ];
                    }

                    Log::info('Change Status Of Point was successful.', ['plan_id' => $planId, 'coupon_code' => $couponCode, 'coupon_status' => $couponStatus]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }
            }
        }

        return [
            'code' => self::CODE_TXT_URL,
            'url' => $redirectUrl
        ];
    }

    private function getEparkMemberId()
    {
        return $this->eparkMemberId;
    }
}
