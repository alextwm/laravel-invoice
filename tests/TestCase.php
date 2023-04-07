<?php

namespace Twm\LaravelInvoice\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
   public function setUp(): void
   {
      parent::setUp();

      Factory::guessFactoryNamesUsing(
         fn ($modelName) => 'Twm\\LaravelInvoice\\Database\\Factories\\'.class_basename($modelName).'Factory'
      );
   }

   public function getEnvironmentSetup($app)
   {
      // config()->set('database.default','testing');

      $migrations = [
          include(__DIR__.'/../database/migrations/create_invoices_table.php'),
          include(__DIR__.'/../database/migrations/create_invoice_lines_table.php'),
          include(__DIR__.'/../database/migrations/create_numbers_table.php'),
      ];

      foreach ($migrations as $migration) {
         $migration->down();
         $migration->up();
      }
   }
}
