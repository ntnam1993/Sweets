<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;

class LoginController extends BaseController
{
    public function getLogin(Request $req)
    {
        // if it's already logged in
        $isLogin = $this->checkLogin();
        if ($isLogin) {
            return redirect(url('mypage'));
        }

        $referrer = '';
        $loginUrl = route('login.epark');

        if ($req->has('afterLoginUrl')) {
            $afterLoginUrl = urldecode($req->afterLoginUrl);
            $santinizedAfterLoginUrl = filter_var($afterLoginUrl, FILTER_SANITIZE_URL);

            if (!filter_var($santinizedAfterLoginUrl, FILTER_VALIDATE_URL)) {
                abort(500);
            }

            // check afterLoginUrl is a valid URL
            // if it's current site
            if (strpos(parse_url($afterLoginUrl, PHP_URL_HOST), request()->getHttpHost()) === 0) {
                $referrer = $afterLoginUrl;
            } else {
                // if it's an external site
                $supportedServices = config('common.external_services');
                $isASupportedService = false;

                foreach ($supportedServices as $key => $service) {
                    if (preg_match('/^(.*\.)?' . $service . '$/', parse_url($afterLoginUrl, PHP_URL_HOST))) {
                        $isASupportedService = true;
                        break;
                    }
                }

                if (!$isASupportedService) {
                    abort(500);
                }

                $referrer = $afterLoginUrl;
            }
        }

        // define login url with afterLoginUrl
        if ($referrer) {
            $loginUrl = route('login.epark', ['afterLoginUrl' => override_urlencode($referrer)]);
        }

        return view('login.' . $this->path . 'login', compact('loginUrl'));
    }

    /**
     * @author chuong
     */
    public function getLoginEpark()
    {
        if ($this->checkLogin()) {
            return redirect()->route('index');
        }
    }

    public function getLogout(Request $req)
    {
        $referrer = '';
        $logoutUrl = env('SWEETS_LOGOUT_ENDPOINT' . ($this->isMobile ? '_SP' : '')) . '?callerPageType=1&afterLoginPath=' . urlencode(getCurrentPathWithQuery());

        if ($req->has('afterLogoutUrl')) {
            $afterLogoutUrl = urldecode($req->afterLogoutUrl);
            $santinizedAfterLogoutUrl = filter_var($afterLogoutUrl, FILTER_SANITIZE_URL);

            if (!filter_var($santinizedAfterLogoutUrl, FILTER_VALIDATE_URL)) {
                abort(500);
            }

            // check afterLogoutUrl is a valid URL
            // if it's current site
            if (strpos(parse_url($afterLogoutUrl, PHP_URL_HOST), request()->getHttpHost()) === 0) {
                $referrer = $afterLogoutUrl;
            } else {
                // if it's an external site
                $supportedServices = config('common.external_services');
                $isASupportedService = false;

                foreach ($supportedServices as $key => $service) {
                    if (preg_match('/^(.*\.)?' . $service . '$/', parse_url($afterLogoutUrl, PHP_URL_HOST))) {
                        $isASupportedService = true;
                        break;
                    }
                }

                if (!$isASupportedService) {
                    abort(500);
                }

                $referrer = $afterLogoutUrl;
            }
        }

        // define logout url with afterLogoutUrl
        if ($referrer) {
            $logoutUrl = env('SWEETS_LOGOUT_ENDPOINT') . '?‘callerPageType=1?afterLogoutPath=' . $referrer;
        }

        return redirect($logoutUrl);
    }
}
