<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('letters_only', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^[[:alpha:]]+$/', $value);
        });

        Validator::extend('true_url', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^\b((https?:\/\/www\.)|(https?:\/\/)|(www\.))(\w+\.[a-z.]+)([^ ,\n]*)$/', $value);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}