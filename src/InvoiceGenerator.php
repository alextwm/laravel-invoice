<?php

namespace Twm\LaravelInvoice;

use Illuminate\Support\Facades\Storage;
use Twm\LaravelInvoice\Classes\Generator;
use Twm\LaravelInvoice\Models\Invoice as InvoiceModel;
use Twm\LaravelInvoice\Models\InvoiceLine;
use Twm\LaravelInvoice\Traits\InvoiceTrait;
use Twm\LaravelInvoice\Traits\SaveFilesTrait;

class InvoiceGenerator
{
    use InvoiceTrait, SaveFilesTrait;

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
            'serial' => $this->key_exists('serial', $vars),
            'number' => $this->key_exists('serial', $vars) ? self::getNumber($vars['serial']) : null,
            'emited_date' => now()->format('Y-m-d'),
            'client_id' => $this->key_exists('client_id', $vars),
            'customer_name' => $this->key_exists('customer_name', $vars),
            'customer_reg_com_nr' => $this->key_exists('customer_reg_com_nr', $vars),
            'customer_cui' => $this->key_exists('customer_cui', $vars),
            'customer_address' => $this->key_exists('customer_address', $vars),
            'customer_iban' => $this->key_exists('customer_iban', $vars),
            'customer_bank' => $this->key_exists('customer_bank', $vars),
            'customer_county' => $this->key_exists('customer_county', $vars),
            'provider_name' => $this->key_exists('provider_name', $vars),
            'provider_reg_com_nr' => $this->key_exists('provider_reg_com_nr', $vars),
            'provider_cui' => $this->key_exists('provider_cui', $vars),
            'provider_address' => $this->key_exists('provider_address', $vars),
            'provider_iban' => $this->key_exists('provider_iban', $vars),
            'provider_bank' => $this->key_exists('provider_bank', $vars),
            'provider_capital' => $this->key_exists('provider_capital', $vars),
            'provider_phone' => $this->key_exists('provider_phone', $vars),
            'provider_email' => $this->key_exists('provider_email', $vars),
            'provider_website' => $this->key_exists('provider_website', $vars),
            'cota' => $this->key_exists('cota', $vars),
            'termen_de_plata' => $this->key_exists('termen_de_plata', $vars),
            'payment_url' => $this->key_exists('payment_url', $vars),
            'storno_invoice_id' => $this->key_exists('storno_invoice_id', $vars),
            'taxare_inversa' => array_key_exists('taxare_inversa', $vars) ? $vars['taxare_inversa'] : false,
        ]);

        return $this;
    }

    public function lines($items)
    {
        foreach ($items as $item) {
            $line = InvoiceLine::create([
                'invoice_id' => $this->invoice->id,
                'product_name' => iconv("UTF-8","ISO-8859-1//TRANSLIT//IGNORE",$item->name),
                'unit' => $item->unit,
                'cota' => $item->cota,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'pret_fara_tva' => $item->pret_fara_tva,
                'valoare_fara_tva' => $item->valoare_fara_tva,
                'valoare_tva' => $item->valoare_tva,
                'discount' => $item->discount,
            ]);

            if ($this->invoice->taxare_inversa) {
                $line->valoare_tva = 0;
                $line->save();
            }

            array_push($this->lines, $line);
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

        $this->storeFile($name, $disk);

        return redirect()->back();
    }

    public function download()
    {
        return response()->download(Storage::disk($this->disk)->path('').$this->name);
    }

    private function key_exists($key, $array)
    {
        return array_key_exists($key, $array) ? iconv("UTF-8","ISO-8859-1//TRANSLIT//IGNORE",$array[$key]) : null;
    }
}
