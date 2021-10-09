<?php

use Tests\Traits\AgentTrait;
use Tests\Traits\PageInteractionTrait;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    use AgentTrait,
        PageInteractionTrait;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl;
    protected $user;
    protected $mockUser;
    protected $cookies;

    public function setUp()
    {
        parent::setUp();

        $this->baseUrl = env('APP_URL', 'http://localhost');
        $this->mockUser = [
            'gapid' => 'e325372f121da0fe1b83fe3e62dd5396ee4440ccd536686e0d73f3cb1cae43b9da2f627301d08ffa5fc44ee3444f62e0b90d399e31f67f4cf5d418f7d6f85471',
            'access_token' => 'f444a06e141879780c969993759caaa8e1e0c7d8',
            'refresh_token' => 'bacdedf2dac9c4de1f39d821a008ae28d6a9b7c4',
            'epark_member_id' => '16359364',
            'user_id' => '16359364',
            'portal_member_exist' => 2,
            'member_no' => 753,
            'email' => 'okinawa.qa+20170713@gmail.com',
            'last_name' => '沖縄',
            'first_name' => '太郎',
            'last_name_kana' => 'おきなわ',
            'first_name_kana' => 'たろう',
            'nick_name' => 'ケーキ大好き',
            'sex' => 1,
            'birthday' => '1999-03-11',
            'post_code' => '900-0015',
            'prov_code' => 47,
            'city' => '那覇市',
            'district' => '久茂地',
            'building_name' => '久茂地UFビル',
            'tel' => '09811223344',
            'shop_info_dly_fg' => 3,
        ];
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->cookies = [];
    }

    public function getRoutes($middleware = '', $excepts = [], $onlyOnce = false)
    {
        $routes = Route::getRoutes();
        $result = [];
        foreach ($routes as $route) {
            $middlewares = $route->middleware();
            if (empty($middleware) || in_array($middleware, $middlewares)) {
                if (in_array($route->getName(), $excepts)) {
                    continue;
                }
                if (!$onlyOnce || ($onlyOnce && count($middlewares) === 1)) {
                    $result[] = (object) [
                        'path' => $route->getPath(),
                        'name' => $route->getName(),
                        'action' => $route->getActionName(),
                        'middlewares' => $middlewares,
                    ];
                }
            }
        }
        return $result;
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }
}
