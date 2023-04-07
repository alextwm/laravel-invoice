<?php

namespace Twm\LaravelInvoice\Tests;

use Twm\LaravelInvoice\Models\Invoice;
use Faker\Generator as Faker;

class InvoiceTest extends TestCase
{
   public function setUp(): void
   {
      parent::setUp();
   }

   /** @test */
   public function it_can_create_invoice()
   {
      $myModels = Invoice::factory(5)->create();

      $this->assertCount(5,$myModels);
   }

   /** @test */
   public function it_can_load_invoices()
   {
      $myModels = Invoice::factory(5)->create();

      $this->assertEquals(5,$myInvoices);
   }
}