<?php

namespace Twm\LaravelInvoice;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Twm\LaravelInvoice\Commands\LaravelInvoiceCommand;

class LaravelInvoiceServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-invoice')
            ->hasConfigFile()
            ->hasViews('invoices')
            ->hasMigration('create_invoices_table')
            ->hasMigration('create_invoice_lines_table')
            ->hasMigration('create_numbers_table')
            ->hasMigration('create_invoice_files_table')
            ->hasCommand(LaravelInvoiceCommand::class);
    }
}
