<?php

namespace Twm\LaravelInvoice\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Twm\LaravelInvoice\Models
 *
 * @property float $valoare_tva
*/

class InvoiceLine extends Model
{
   protected $guarded = ['id'];

   public function invoice()
   {
      return $this->belongsTo(Invoice::class);
   }
}
