<?php

namespace ALF\LiqPay\Facades;

use ALF\LiqPay\LiqPay;

class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return LiqPay::class;
    }
}
