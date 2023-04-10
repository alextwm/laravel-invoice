<?php

namespace Twm\LaravelInvoice\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Twm\LaravelInvoice\Models\Invoice;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'serial' => 'AA',
            'number' => 2,
            'emited_date' => '2023-01-02',
            'provider_name' => $this->faker->company(),
            'provider_reg_com_nr' => $this->faker->word(),
            'provider_cui' => $this->faker->word(),
            'provider_address' => $this->faker->address(),
            'provider_iban' => $this->faker->word(),
            'provider_bank' => $this->faker->word(),
            'provider_capital' => $this->faker->word(),
            'customer_name' => $this->faker->company(),
            'customer_reg_com_nr' => $this->faker->word(),
            'customer_cui' => $this->faker->word(),
            'customer_address' => $this->faker->address(),
            'customer_iban' => $this->faker->word(),
            'customer_bank' => $this->faker->word(),
            'customer_county' => $this->faker->word(),
            'cota' => 19
        ];
    }
}
