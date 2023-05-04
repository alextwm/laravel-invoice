<?php

namespace Twm\LaravelInvoice\Classes;

use Twm\LaravelInvoice\Traits\InvoiceTrait;

class Line
{
    use InvoiceTrait;

    public $name;

    public $unit;

    public $quantity;

    public $price;

    public $pret_fara_tva;

    public $valoare_fara_tva;

    public $valoare_tva;

    public $discount;

    public $cota;

    public $type;

    public function name(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function unit(string $unit)
    {
        $this->unit = $unit;

        return $this;
    }

    public function quantity(float $quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function price(float $price, bool $type)
    {
        $this->type = $type;
        $this->price = $price;

        return $this;
    }

    public function cota(int $cota)
    {
        $this->cota = $cota;

        return $this;
    }

    public function pret_fara_tva(int $cota)
    {
        if(!$this->type) {
            $this->pret_fara_tva = $this->price;
            return $this;
        }
        $this->pret_fara_tva = $this->price_without_vat($this->price, $cota);

        return $this;
    }

    public function valoare_fara_tva(int $cota)
    {
        if(!$this->type) {
            $pret = ($this->price * (1 + $cota/100)); 
            $this->valoare_fara_tva = $this->quantity * $pret;
            return $this;
        }
        $this->valoare_fara_tva = $this->value_without_vat($this->quantity, $this->price, $cota);

        return $this;
    }

    public function valoare_tva(int $cota)
    {
        if(!$this->type) {
            $pret = ($this->price * (1 + $cota/100)); 
            $this->valoare_tva = $this->quantity * ($pret - $this->price);
            return $this;
        }
        $this->valoare_tva = $this->vat_value($this->quantity, $this->price, $cota);

        return $this;
    }

    public function discount($percent)
    {
        $this->discount = $percent;
        $this->price = -($percent / 100) * $this->price;

        return $this;
    }
}
