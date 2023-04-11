<?php

namespace Twm\LaravelInvoice\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
   /**
    * Twm\LaravelInvoice\Models
    *
    * @property float $valoare_tva
    */
   protected $guarded = ['id'];

   public function invoice()
   {
      return $this->belongsTo(Invoice::class);
   }
}
