<?php

namespace Twm\LaravelInvoice\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

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