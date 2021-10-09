<?php

namespace App\Providers;

use App\Helpers\EparkEncrypter;
use App\Http\Controllers\BaseController;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['request']->server->set('HTTPS', true);
        view()->composer('*', function ($view) {
            $current_route_name = \Route::currentRouteName();
            $base = app(BaseController::class);
            $isLogin = $base->checkLogin();
            $view->with(compact('current_route_name', 'isLogin'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Client::class, function ($app, $config) {
            $config['verify'] = false;

            return new Client($config);
        });

        // Binding EparkEncrypter
        $this->app->bind(EparkEncrypter::class, function ($app) {
            $config = $app->make('config')->get('app');

            if (Str::startsWith($key = $config['key'], 'base64:')) {
                $key = base64_decode(substr($key, 7));
            }

            return new EparkEncrypter($key, $config['cipher']);
        });
    }
}
