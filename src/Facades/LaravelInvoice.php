<?php

namespace Twm\LaravelInvoice\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelInvoice extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravelinvoice'
    }
}
