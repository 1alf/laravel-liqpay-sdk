<?php

namespace ALF\LiqPay;

class LiqPayServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        if (function_exists('config_path')) { // function not available and 'publish' not relevant in Lumen
            $this->publishes(
                [
                    __DIR__ . '/../config/liqpay.php' => config_path('liqpay.php'),
                ],
                'config'
            );
        }
    }

    public function register()
    {
        $this->app->bind(
            'liqpay',
            function () {
                return new LiqPay(config('liqpay.public_key'), config('liqpay.private_key'));
            }
        );
    }

    public function provides()
    {
        return ['liqpay'];
    }
}
