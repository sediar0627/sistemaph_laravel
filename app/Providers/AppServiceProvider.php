<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultstringLength(191);

        Validator::extend('phone', function ($attribute, $value, $params, $validator) {
            if (!is_numeric($value)) {
                return false;
            }
            return true;
        }, 'Este valor no es un numero de telefono.');
    }
}
