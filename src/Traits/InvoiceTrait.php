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
      $current = ($cota / 100) * $price;

      return number_format($price - $current, 2, '.', '');
   }

   public static function value_without_vat($qty, $price, $cota)
   {
      $value = ($cota / 100) * ($price * $qty);

      return number_format(($price * $qty) - $value, 2, '.', '');
   }

   public static function vat_value($qty, $price, $cota)
   {
      $value = ($cota / 100) * $price;

      return number_format($value * $qty, 2, '.', '');
   }

   public static function total_value($items)
   {
      $value = 0;

      foreach ($items as $item) {
         $value += $item->valoare_fara_tva;
      }

      return number_format($value, 2, '.', '');
   }

   public static function total_vat($items)
   {
      $value = 0;

      foreach ($items as $item) {
         $value += $item->valoare_tva;
      }

      return number_format($value, 2, '.', '');
   }
}
