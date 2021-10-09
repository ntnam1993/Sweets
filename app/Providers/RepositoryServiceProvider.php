<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    protected $binders = [
        \App\Repositories\Contracts\InformationRequestRepository::class => \App\Repositories\Eloquents\InformationRequestEloquent::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->binders as $interface => $eloquent) {
            $this->app->bind($interface, $eloquent);
        }
    }
}
