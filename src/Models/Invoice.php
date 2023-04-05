<?php

namespace Twm\LaravelInvoice\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
   protected $guarded = ['id'];

   public function lines()
   {
      return $this->hasMany(InvoiceLine::class);
   }

   public function client()
   {
      return $this->belongsTo(Client::class);
   }
}
