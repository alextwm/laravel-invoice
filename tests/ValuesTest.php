<?php

namespace Twm\LaravelInvoice\Tests;

use Twm\LaravelInvoice\InvoiceGenerator;

class ValuesTest extends TestCase
{
   /** @test  */
   public function it_can_resolve_price_without_vat()
   {
      $simulatePrice = 50;
      $simulateTVA = 19;

      $expectResult = 40.5;

      $result = InvoiceGenerator::price_without_vat($simulatePrice,$simulateTVA);
      $this->assertEquals($expectResult, $result);
   }

   /** @test */
   public function it_can_resolve_value_without_vat()
   {
      $simulatePrice = 50;
      $simulateQuantity = 6;
      $simulateTVA = 19;

      $expectResult = 243;
      
      $result = InvoiceGenerator::value_without_vat($simulateQuantity,$simulatePrice,$simulateTVA);

      $this->assertEquals($expectResult,$result);
   }

   /** @test */
   public function it_can_resolve_vat_value()
   {
      $simulatePrice = 50;
      $simulateQuantity = 6;
      $simulateTVA = 19;

      $expectResult = 57;

      $result = InvoiceGenerator::vat_value($simulateQuantity,$simulatePrice,$simulateTVA);

      $this->assertEquals($expectResult,$result);
   }
}