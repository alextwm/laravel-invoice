<?php

namespace Twm\LaravelInvoice\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Twm\LaravelInvoice\Models\InvoiceFile;

trait SaveFilesTrait
{
   public function storeFile($name,$disk)
   {
      InvoiceFile::create([
         'invoice_id' => $this->invoice->id,
         'name' => Str::random(50).'.pdf',
         'original_name' => $name,
         'size' => File::size(Storage::disk($disk)->path('').$name),
         'mime_type' => 'application/pdf',
         'path' => Storage::disk($disk)->path('').$name
      ]);

      return;
   }
}