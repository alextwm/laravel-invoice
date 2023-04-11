<?php

namespace Twm\LaravelInvoice\Classes;

use Illuminate\Support\Facades\Storage;

class Generator extends Pdf
{
   public $invoice;

   public $name;

   public $disk;

   public function __construct($invoice, $name, $disk = '')
   {
      $this->invoice = $invoice;
      $this->name = $name;
      $this->disk = $disk;
   }

   public function generate()
   {
      $pdf = new Template();
      $pdf->AliasNbPages();
      $this->invoiceInfo($pdf);
      $this->lines($pdf);
      if ($this->disk) {
         return $pdf->Output('F', Storage::disk($this->disk)->path('').'/'.$this->name);
      } else {
         return $pdf->Output('D', $this->name);
      }
   }

   public function invoiceInfo($pdf)
   {
      $pdf->infoInvoice = $this->invoice;
   }

   public function lines($pdf)
   {
      $pdf->AddPage();
      $pdf->SetDrawColor(0, 0, 0);
      $pdf->SetFont('helvetica', '', 8);

      $index = 0;

      $currentY = 94;
      $coordonataY = 0;

      foreach ($this->invoice->lines as $line) {
         $index++;
         if ($currentY < $coordonataY) {
            $currentY = $coordonataY + 4;
         }

         $pdf->SetY($currentY);
         $pdf->SetX(5);
         $pdf->Cell(10, 5, $index, 0, 0, 'C');
         $pdf->SetY($currentY);
         $pdf->SetX(15);
         $pdf->MultiCell(70, 4, $line->product_name, 0, 'L', 0);
         $coordonataY = $pdf->GetY();
         $pdf->SetY($currentY);
         $pdf->SetX(90);
         $pdf->Cell(10, 5, $line->unit, 0, 0, 'C');
         $pdf->SetY($currentY);
         $pdf->SetX(100);
         $pdf->Cell(15, 5, $line->quantity, 0, 0, 'C');
         $pdf->SetY($currentY);
         $pdf->SetX(115);
         $pdf->Cell(15, 5, $line->cota, 0, 0, 'C');
         $pdf->SetY($currentY);
         $pdf->SetX(130);
         $pdf->Cell(35, 5, $line->pret_fara_tva, 0, 0, 'C');
         $pdf->SetY($currentY);
         $pdf->SetX(165);
         $pdf->Cell(20, 5, $line->valoare_fara_tva, 0, 0, 'C');
         $pdf->SetY($currentY);
         $pdf->SetX(185);
         $pdf->Cell(20, 5, $line->valoare_tva, 0, 0, 'C');
      }

      $pdf->Line(15, 90, 15, 230);
      $pdf->Line(90, 90, 90, 230);
      $pdf->Line(100, 90, 100, 230);
      $pdf->Line(115, 90, 115, 230);
      $pdf->Line(130, 90, 130, 230);
      $pdf->Line(165, 90, 165, 230);
      $pdf->Line(185, 90, 185, 230);

      $pdf->Line(5, 230, 205, 230);

      if ($this->invoice->storno_invoice_id) {
         $pdf->SetY(222);
         $pdf->SetX(16);
         $pdf->Write(10, 'Storno la factura seria '.$this->invoice->storno->serial.' nr.'.$this->invoice->storno->number);
      }
   }
}
