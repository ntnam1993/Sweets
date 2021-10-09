<?php

namespace Tests\Traits;

use App\Http\Middleware\EncryptCookies;

trait PageInteractionTrait
{

    /**
     * See function with Japanese Encoding
     * @param  string  $text
     * @param  boolean $negate
     */
    public function seeJP($text, $negate = false)
    {
        parent::see(mb_convert_encoding($text, 'SJIS'), $negate);
        return $this;
    }

    /**
     * @param array|string $cookies
     * @return $this
     */
    protected function disableCookiesEncryption($cookies)
    {
        $this->app->resolving(EncryptCookies::class, function ($object) use ($cookies) {
            $object->disableFor($cookies);
        });

        return $this;
    }

    /**
     * Override call method to store cookies for next request
     */
    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        $response = parent::call($method, $uri, $parameters, $this->cookies ?: $cookies, $files, $server, $content);
        $cookiesResult = [];
        foreach ($response->headers->getCookies() as $cookie) {
            $cookiesResult[$cookie->getName()] = $cookie->getValue();
        }
        $this->cookies = $cookiesResult;
        return $this->response = $response;
    }
}
