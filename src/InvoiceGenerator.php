<?php

namespace Twm\LaravelInvoice;

use Illuminate\Support\Facades\Storage;
use Twm\LaravelInvoice\Classes\Template;
use Twm\LaravelInvoice\Models\InvoiceLine;
use Twm\LaravelInvoice\Traits\InvoiceTrait;
use Twm\LaravelInvoice\Models\Invoice as InvoiceModel;

class InvoiceGenerator
{
   use InvoiceTrait;
   
   public $invoice;

   public $name;
   public $disk;

   public $lines = [];

   public static function query() 
   {
      return new static;
   }

   public function init($vars)
   {
      $this->invoice = InvoiceModel::create([
         'serial' => config('invoice.serial'),
         'number' => self::getNumber(),
         'emited_date' => now()->format('Y-m-d'),
         'client_id' => $vars['client_id'],
         'customer_name' => $vars['customer_name'],
         'customer_reg_com_nr' => $vars['customer_reg_com_nr'],
         'customer_cui' => $vars['customer_cui'],
         'customer_address' => $vars['customer_address'],
         'customer_iban' => $vars['customer_bank'],
         'customer_bank' => $vars['customer_bank'],
         'provider_name' => $vars['provider_name'],
         'provider_reg_com_nr' => $vars['provider_reg_com_nr'],
         'provider_cui' => $vars['provider_cui'],
         'provider_address' => $vars['provider_address'],
         'provider_iban' => $vars['provider_iban'],
         'provider_bank' => $vars['provider_bank'],
      ]);

      return $this;
   }

   public function lines($items)
   {
      foreach($items as $item)
      {
         InvoiceLine::create([
            'invoice_id' => $this->invoice->id,
            'product_name' => $item->name,
            'unit' => $item->unit,
            'quantity' => $item->quantity,
            'price' => $item->price,
            'pret_fara_tva' => $item->pret_fara_tva,
            'valoare_fara_tva' => $item->valoare_fara_tva,
            'valoare_tva' => $item->valoare_tva 
         ]);

         array_push($this->lines,$item);
      }

      return $this;
   }

   public function generate($disk,$name) 
   {
      $this->name = $name;
      $this->disk = $disk;
      (new Template)->generate($this->invoice,$disk,$name);

      return redirect()->back();
   }

   public function download()
   {
      return response()->download(Storage::disk($this->disk)->path('').$this->name);
   }
}
