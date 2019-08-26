<?php

namespace YouCan\FPay\Providers;

use Illuminate\Support\ServiceProvider;
use YouCan\FPay\Api\Requestor;

class LaravelProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Requestor::class, function () {
            return new Requestor(env('CLIENT_ID'), env('MERCHANT_KEY'), env('MERCHANT_CODE'));
        });
    }
}