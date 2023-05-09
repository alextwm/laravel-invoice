<?php

namespace Twm\LaravelInvoice\Classes;

use Twm\LaravelInvoice\Models\Invoice;
use Twm\LaravelInvoice\Models\InvoiceLine;
use Twm\LaravelInvoice\Traits\InvoiceTrait;

class UpdateInvoice
{
   use InvoiceTrait;

   public static $lines = [];

   public static function update($invoiceId, $lines)
   {
      $invoice = Invoice::find($invoiceId);

      foreach($lines as $line) 
      {
         foreach ($lines as $line) {
            $line = InvoiceLine::create([
                'invoice_id' => $invoice->id,
                'product_name' => $line->name,
                'unit' => $line->unit,
                'cota' => $line->cota,
                'quantity' => $line->quantity,
                'price' => $line->price,
                'pret_fara_tva' => $line->pret_fara_tva,
                'valoare_fara_tva' => $line->valoare_fara_tva,
                'valoare_tva' => $line->valoare_tva,
                'discount' => $line->discount,
            ]);

            if ($invoice->taxare_inversa) {
                $line->valoare_tva = 0;
                $line->save();
            }

            array_push(self::$lines, $line);
        }

        $invoice->update([
            'total_fara_tva' => self::total_value(self::$lines),
            'total_tva' => self::total_vat(self::$lines),
        ]);

        $invoice->update([
            'total_general' => $invoice->total_fara_tva + $invoice->total_tva,
        ]);

        return true;
      }
   }
}