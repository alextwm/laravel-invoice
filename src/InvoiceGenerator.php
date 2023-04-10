<?php

namespace Twm\LaravelInvoice;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Twm\LaravelInvoice\Classes\Generator;
use Twm\LaravelInvoice\Models\Invoice as InvoiceModel;
use Twm\LaravelInvoice\Models\InvoiceLine;
use Twm\LaravelInvoice\Traits\InvoiceTrait;

class InvoiceGenerator
{
   use InvoiceTrait;

   public $invoice;

   public $name;

   public $disk;

   public $lines = [];

   public static function init()
   {
      return new static;
   }

   public function make($vars)
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
          'customer_iban' => $vars['customer_iban'],
          'customer_bank' => $vars['customer_bank'],
          'customer_county' => array_key_exists('customer_county', $vars) ? $vars['customer_county'] : null,
          'provider_name' => $vars['provider_name'],
          'provider_reg_com_nr' => $vars['provider_reg_com_nr'],
          'provider_cui' => $vars['provider_cui'],
          'provider_address' => $vars['provider_address'],
          'provider_iban' => $vars['provider_iban'],
          'provider_bank' => $vars['provider_bank'],
          'provider_capital' => array_key_exists('provider_capital', $vars) ? $vars['provider_capital'] : null,
          'cota' => $vars['cota'],
          'termen_de_plata' => Carbon::parse($vars['termen_de_plata'])->format('Y-m-d'),
          'payment_url' => $vars['payment_url'],
      ]);

      return $this;
   }

   public function lines($items)
   {
      foreach ($items as $item) {
         InvoiceLine::create([
             'invoice_id' => $this->invoice->id,
             'product_name' => $item->name,
             'unit' => $item->unit,
             'quantity' => $item->quantity,
             'price' => $item->price,
             'pret_fara_tva' => $item->pret_fara_tva,
             'valoare_fara_tva' => $item->valoare_fara_tva,
             'valoare_tva' => $item->valoare_tva,
         ]);

         array_push($this->lines, $item);
      }

      $this->invoice->update([
          'total_fara_tva' => self::total_value($this->lines),
          'total_tva' => self::total_vat($this->lines),
      ]);

      $this->invoice->update([
          'total_general' => $this->invoice->total_fara_tva + $this->invoice->total_tva,
      ]);

      return $this;
   }

   public function generate($name, $disk)
   {
      $this->name = $name;
      $this->disk = $disk;
      (new Generator($this->invoice, $name, $disk))->generate();

      return redirect()->back();
   }

   public function download()
   {
      return response()->download(Storage::disk($this->disk)->path('').$this->name);
   }
}
