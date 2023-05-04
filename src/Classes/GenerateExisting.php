<?php

namespace Twm\LaravelInvoice\Classes;

class GenerateExisting
{
    public static function generate($invoice, $name, $type = null)
    {
        return (new Generator($invoice, $name))->generate($type);
    }
}
