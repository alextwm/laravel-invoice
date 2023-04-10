<?php

namespace Twm\LaravelInvoice\Classes;

class GenerateExisting
{
   public static function generate($invoice, $name)
   {
      return (new Generator($invoice, $name))->generate();
   }
}
