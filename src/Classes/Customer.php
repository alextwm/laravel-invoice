<?php

namespace Twm\LaravelInvoice\Classes;

class Customer
{
   public $fields;

   public function __construct($fields)
   {
      foreach($fields as $key => $value) {
         $this->{$key} = $value;
      }
   }
}