<?php

namespace Twm\LaravelInvoice\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Twm\LaravelInvoice\Facades\LaravelInvoice
 */
class LaravelInvoice extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Twm\LaravelInvoice\LaravelInvoice::class;
    }
}
