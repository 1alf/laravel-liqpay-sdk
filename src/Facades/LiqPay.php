<?php

namespace ALF\LiqPay\Facades;

use ALF\LiqPay\LiqPay as LiqPayClient;

class LiqPay extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return LiqPayClient::class;
    }
}
