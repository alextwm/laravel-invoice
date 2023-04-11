<?php

namespace Twm\LaravelInvoice\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceFile extends Model
{
   protected $guarded = ['id'];

   public function invoice()
   {
      return $this->belongsTo(Invoice::class);
   }
}