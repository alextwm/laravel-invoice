<?php

namespace Twm\LaravelInvoice\Classes;

use Twm\LaravelInvoice\Classes\Template;

class GenerateExisting
{
   public static function generate($invoice,$name)
   {
      return (new Generator($invoice,$name))->generate();
   }
}