<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory;

class CustomValidatorServiceProvider extends ServiceProvider
{

    protected $rules = [
        'email_length' => \App\Rules\EmailLengthRule::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $validator = $this->app->make(Factory::class);
        foreach ($this->rules as $name => $ruleClass) {
            $ruleInstance = $this->app->make($ruleClass);

            $validator->extend($name,
                function ($attribute, $value, $parameters) use ($ruleInstance) {
                    return $ruleInstance->passes($attribute, $value, $parameters);
                }
            );

            $validator->replacer($name,
                function ($message, $attribute, $rule, $parameters) use ($ruleInstance) {
                    return $ruleInstance->message($message, $attribute, $rule, $parameters);
                }
            );
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
