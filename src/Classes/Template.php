<?php

namespace Twm\LaravelInvoice\Classes;

use Carbon\Carbon;
use Twm\LaravelInvoice\Models\Invoice;

class Template extends Pdf
{
   public function generate(Invoice $invoice)
   {
      $pdf = new Pdf();
      $pdf->AddPage();
      $pdf->SetFont('Arial', 'B', 11);
      $pdf->SetLeftMargin(5);
      $pdf->Line(5, 5, 5, 270);
      $pdf->Line(205, 5, 205, 270);
      $pdf->Line(5, 5, 205, 5);
      $pdf->Line(5, 270, 205, 270);

      $this->head($pdf, $invoice);
      $this->middle($pdf, $invoice);
      $this->foot($pdf, $invoice);

      $pdf->Output('D', 'test.pdf');
   }

   public function head($pdf, $invoice)
   {
      $pdf->SetY(10);
      $pdf->SetX(8);
      $pdf->SetFont('Arial', '', 9);
      $pdf->SetCharSpacing(0.1);
      $pdf->MultiAlignCell(60, 5, 'Furnizor : '.$invoice->provider_name."\nNr.ord.reg.com./an : ".$invoice->provider_reg_com_nr."\nA.F./C.U.I. : ".$invoice->provider_cui."\nSediul : ".$invoice->provider_address."\nContul : ".$invoice->provider_bank."\nBanca : ".$invoice->provider_iban, 0, 0, 'L', false);

      $pdf->SetY(35);
      $pdf->SetX(75);
      $pdf->SetFont('Arial', 'B', 16);
      $pdf->MultiCell(60, 6, 'FACTURA FISCALA', 0, 'C', false);

      $pdf->SetY(50);
      $pdf->SetX(76);
      $pdf->SetFont('Arial', '', 7);

      $pdf->Cell(60, 25, '', 1, 0);
      $pdf->SetY(52);
      $pdf->SetX(78);
      $pdf->MultiAlignCell(50, 5, 'Seria: ............... Nr. .................', 0, 0, 'L', false);
      $pdf->SetY(57);
      $pdf->SetX(78);
      $pdf->MultiAlignCell(50, 5, 'Din data (ziua,luna,anul) : ........................', 0, 0, 'L', false);
      $pdf->SetY(62);
      $pdf->SetX(78);
      $pdf->MultiAlignCell(50, 5, 'Nr. aviz de insotire a marfii : ........................', 0, 0, 'L', false);
      $pdf->SetY(67);
      $pdf->SetX(78);
      $pdf->MultiAlignCell(50, 5, '(daca este cazul)', 0, 0, 'C', false);

      // $pdf->SetY(57);
      // $pdf->SetX(78);
      // $pdf->MultiAlignCell(50,5,'Din data (ziua,luna,anul) : ........................', 0,0,'L',false);
      // $pdf->SetY(62);
      // $pdf->SetX(78);
      // $pdf->MultiAlignCell(50,5,"Nr. aviz de insotire a marfii : ........................", 0,0,'L',false);
      // $pdf->SetY(67);
      // $pdf->SetX(78);
      // $pdf->MultiAlignCell(50,5,"(daca este cazul)", 0,0,'C',false);

      $pdf->SetFont('Arial', '', 9);
      $pdf->SetY(10);
      $pdf->SetX(140);
      $pdf->MultiAlignCell(60, 5, 'Client : '.$invoice->customer_name."\nNr.ord.reg.com./an : ".$invoice->customer_reg_com_nr."\nA.F./C.U.I. : ".$invoice->customer_cui."\nSediul : ".$invoice->customer_address."\nContul : ".$invoice->customer_iban."\nBanca : ".$invoice->customer_bank, 0, 0, 'L', false);

      $pdf->SetFont('Arial', '', 8);
      $pdf->SetY(49);
      $pdf->SetX(88);
      $pdf->Write(10, $invoice->serial);

      $pdf->SetY(49);
      $pdf->SetX(105);
      $pdf->Write(10, $invoice->number);

      $pdf->SetY(53.5);
      $pdf->SetX(110);
      $pdf->Write(10, Carbon::parse($invoice->emited_date)->format('d-m-Y'));

      // $pdf->SetY(48.5);
      // $pdf->SetX(115);
      // $pdf->Write(10,4323);

      $pdf->Image(config('invoice.logo'), 70, 8, 70, 20);
   }

   public function middle($pdf, $invoice)
   {
      $pdf->SetFont('Arial', '', 9);
      $pdf->SetY(80);
      $pdf->SetX(5);
      $pdf->SetFont('Arial', '', 7);

      $pdf->MultiAlignCell(10, 8, 'Nr. Crt.', 1, 0, 'C', false);
      $pdf->MultiAlignCell(75, 8, 'Denumirea produselor sau a serviciilor', 1, 0, 'C', false);
      $pdf->MultiAlignCell(10, 8, 'UM', 1, 0, 'C', false);
      $pdf->MultiAlignCell(15, 8, 'Cantitate', 1, 0, 'C', false);
      $pdf->MultiAlignCell(15, 4, 'Cota TVA (%)', 1, 0, 'C', false);
      $pdf->MultiAlignCell(35, 4, "Pret unitar (fara T.V.A.)\n-lei-", 1, 0, 'C', false);
      $pdf->MultiAlignCell(20, 4, "Valoare\n-lei-", 1, 0, 'C', false);
      $pdf->MultiAlignCell(20, 4, "Valoare\nT.V.A. -lei-", 1, 0, 'C', false);
      $pdf->SetY(88);
      $pdf->SetX(5);
      $pdf->MultiAlignCell(10, 4, '0', 1, 0, 'C', false);
      $pdf->MultiAlignCell(75, 4, '1', 1, 0, 'C', false);
      $pdf->MultiAlignCell(10, 4, '2', 1, 0, 'C', false);
      $pdf->MultiAlignCell(15, 4, '3', 1, 0, 'C', false);
      $pdf->MultiAlignCell(15, 4, '4', 1, 0, 'C', false);
      $pdf->MultiAlignCell(35, 4, '5', 1, 0, 'C', false);
      $pdf->MultiAlignCell(20, 4, '6', 1, 0, 'C', false);
      $pdf->MultiAlignCell(20, 4, '7', 1, 1, 'C', false);

      $pdf->SetFont('Arial', '', 8);

      $index = 0;

      $nr = 50;
      foreach ($invoice->lines as $line) {
         $index++;
         $pdf->MultiAlignCell(10, 10, $index, 0, 0, 'C', false);
         $pdf->MultiAlignCell(75, 10, $line->product_name, 0, 0, 'L', false);
         $pdf->MultiAlignCell(10, 10, $line->unit, 0, 0, 'C', false);
         $pdf->MultiAlignCell(15, 10, $line->quantity, 0, 0, 'C', false);
         $pdf->MultiAlignCell(15, 10, $invoice->cota_tva, 0, 0, 'C', false);
         $pdf->MultiAlignCell(35, 10, $line->pret_fara_tva, 0, 0, 'C', false);
         $pdf->MultiAlignCell(20, 10, $line->valoare_fara_tva, 0, 0, 'C', false);
         $pdf->MultiAlignCell(20, 10, $line->valoare_tva, 0, 1, 'C', false);
      }

      $pdf->Line(15, 80, 15, 230);
      $pdf->Line(90, 80, 90, 230);
      $pdf->Line(100, 80, 100, 230);
      $pdf->Line(115, 80, 115, 230);
      $pdf->Line(130, 80, 130, 230);
      $pdf->Line(165, 80, 165, 230);
      $pdf->Line(185, 80, 185, 230);

      $pdf->Line(5, 230, 205, 230);
   }

   public function foot($pdf, $invoice)
   {
      $pdf->Line(45, 230, 45, 270);
      $pdf->Line(115, 230, 115, 270);
      $pdf->Line(115, 250, 205, 250);
      $pdf->Line(165, 230, 165, 270);
      $pdf->Line(185, 230, 185, 250);

      $pdf->SetFont('Arial', '', 10);
      $pdf->SetY(232);
      $pdf->SetX(10);
      $pdf->MultiAlignCell(30, 5, "Semnatura si\nstampila\nfurnizorului", 0, 0, 'C', false);
      $pdf->SetFont('Arial', '', 8);
      $pdf->SetY(230);
      $pdf->SetX(45);
      $pdf->MultiCell(60, 5, "Date privind expeditia\nNumele delegatului: ......................\nB.I / C.I. seria ............... nr. ................ eliberat(a) ......................\nMijloc de transport: AUTO\nNr. inmatriculare: ..................");

      $pdf->SetFont('Arial', '', 10);
      $pdf->SetY(235);
      $pdf->SetX(135);
      $pdf->Write(10, 'Total');
      $pdf->SetY(252);
      $pdf->SetX(125);
      $pdf->Write(10, 'Total de plata');
      $pdf->SetY(257);
      $pdf->SetX(125);
      $pdf->Write(10, '(col.5 + col.6)');

      $pdf->SetFont('Arial', '', 8);
      $pdf->SetY(235);
      $pdf->SetX(167);
      $pdf->Write(10, '');

      $pdf->SetY(235);
      $pdf->SetX(186);
      $pdf->Write(10, '');

      $pdf->SetY(255);
      $pdf->SetX(168);
      $pdf->SetFont('Arial', 'B', 10);
      $pdf->Write(10, '');
   }
}
