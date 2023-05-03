<?php

namespace Twm\LaravelInvoice\Traits;

use Twm\LaravelInvoice\Models\Number;

trait InvoiceTrait
{
   public static function getNumber()
   {
      $max = 0;

      $numberModel = Number::where('serial', config('invoice.serial'))->first();

      if ($numberModel) {

         $max = ++$numberModel->number;
         $numberModel->update([
             'number' => $max,
         ]);

         return $max;

      } else {
         Number::create([
             'serial' => config('invoice.serial'),
             'number' => 1,
         ]);

         return 1;
      }
   }

   public static function price_without_vat($price, $cota)
   {
      $vatPrice = ($price-($price/(1+$cota/100)));

      return $price - number_format($vatPrice,2,'.','');
   }

   public static function value_without_vat($qty, $price, $cota)
   {
      $value = ($cota / 100) * ($price * $qty);

      return ($price * $qty) - $value;
   }

   public static function vat_value($qty, $price, $cota)
   {
      $vatPrice = ($price-($price/(1+$cota/100)));
      
      return $qty * number_format($vatPrice,2,'.',''); 
   }

   public static function total_value($items)
   {
      $value = 0;

      foreach ($items as $item) {
         $value += $item->valoare_fara_tva;
      }

      return $value;   
   }

   public static function total_vat($items)
   {
      $value = 0;

      foreach ($items as $item) {
         $value += $item->valoare_tva;
      }

      return $value;
   }
}
