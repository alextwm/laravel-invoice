<?php

namespace Twm\LaravelInvoice\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'provider_bank' => 'array'
    ];
    
    public function lines()
    {
        return $this->hasMany(InvoiceLine::class);
    }

    public function storno()
    {
        return $this->belongsTo(Invoice::class, 'storno_invoice_id');
    }

    public function file()
    {
        return $this->hasOne(InvoiceFile::class);
    }
}
