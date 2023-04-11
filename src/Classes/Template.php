<?php

namespace Twm\LaravelInvoice\Classes;

use Carbon\Carbon;

class Template extends Pdf
{
   public $infoInvoice;

   public $infoFooter;

   public function Header()
   {
      $this->SetY(5);
      $this->SetX(8);
      $this->SetFont('helvetica', 'B', 9);
      $this->SetCharSpacing(0.1);
      $this->Write(10, 'Furnizor');
      $this->SetFont('helvetica', 'B', 12);
      $this->SetY(14);
      $this->SetX(8);
      $this->MultiAlignCell(50, 5, $this->infoInvoice->provider_name, 0, 1, 'L', false);
      $this->SetFont('helvetica', '', 9);
      $this->SetX(8);
      $this->MultiAlignCell(60, 5, 'Nr.ord.reg.com./an : '.$this->infoInvoice->provider_reg_com_nr."\nA.F./C.U.I. : ".$this->infoInvoice->provider_cui."\nSediul : ".$this->infoInvoice->provider_address."\nContul : ".$this->infoInvoice->provider_bank."\nBanca : ".$this->infoInvoice->provider_iban, 0, 0, 'L', false);

      $this->SetY(5);
      $this->SetX(140);
      $this->SetFont('helvetica', 'B', 9);
      $this->SetCharSpacing(0.1);
      $this->Write(10, 'Client');
      $this->SetFont('helvetica', 'B', 12);
      $this->SetY(14);
      $this->SetX(140);
      $this->MultiAlignCell(50, 5, $this->infoInvoice->customer_name, 0, 1, 'L', false);
      $this->SetFont('helvetica', '', 9);
      $this->SetX(140);
      $this->MultiAlignCell(60, 5, 'Nr.ord.reg.com./an : '.$this->infoInvoice->customer_reg_com_nr."\nA.F./C.U.I. : ".$this->infoInvoice->customer_cui."\nSediul : ".$this->infoInvoice->customer_address."\nJudetul : ".$this->infoInvoice->customer_county."\nContul : ".$this->infoInvoice->customer_bank."\nBanca : ".$this->infoInvoice->customer_iban, 0, 0, 'L', false);

      $this->SetFont('helvetica', 'B', 16);
      $this->SetY(35);
      $this->SetX(75);
      $this->MultiCell(60, 6, 'FACTURA FISCALA', 0, 'C', false);

      $this->SetY(48);
      $this->SetX(76);
      $this->SetFont('helvetica', '', 7);
      $this->SetDrawColor(0, 0, 0);
      $this->MultiCell(60, 25, '', 1, 'L', false);
      $this->SetY(50);
      $this->SetX(78);
      $this->MultiAlignCell(50, 5, 'Seria: ............... Nr. .................', 0, 0, 'L', false);
      $this->SetY(55);
      $this->SetX(78);
      $this->MultiAlignCell(50, 5, 'Din data (ziua,luna,anul) : ........................', 0, 0, 'L', false);
      $this->SetY(60);
      $this->SetX(78);
      $this->MultiAlignCell(50, 5, 'Nr. aviz de insotire a marfii : ........................', 0, 0, 'L', false);
      $this->SetY(65);
      $this->SetX(78);
      $this->MultiAlignCell(50, 5, '(daca este cazul)', 0, 0, 'C', false);

      $this->SetFont('helvetica', '', 8);

      $this->SetY(47);
      $this->SetX(88);
      $this->Write(10, $this->infoInvoice->serial);

      $this->SetY(47);
      $this->SetX(105);
      $this->Write(10, $this->infoInvoice->number);

      $this->SetY(51.5);
      $this->SetX(110);
      $this->Write(10, Carbon::parse($this->infoInvoice->emited_date)->format('d-m-Y'));

      if($this->infoInvoice->taxare_inversa) {
         $this->SetY(71);
         $this->SetX(76);
         $this->SetFont('helvetica','B',10);
         $this->Cell(60,10,'TAXARE INVERSA',0,0,'C');
      }
      
      $this->Image(config('invoice.logo'), 70, 8, 50, 18);
      
      $this->SetLeftMargin(5);
      $this->Line(5, 5, 5, 270);
      $this->Line(205, 5, 205, 270);
      $this->Line(5, 5, 205, 5);
      $this->Line(5, 270, 205, 270);
      $this->SetFont('helvetica', '', 9);
      $this->SetY(80);
      $this->SetX(5);
      $this->SetFont('helvetica', '', 7);

      $this->MultiAlignCell(10, 8, 'Nr. Crt.', 1, 0, 'C', false);
      $this->MultiAlignCell(75, 8, 'Denumirea produselor sau a serviciilor', 1, 0, 'C', false);
      $this->MultiAlignCell(10, 8, 'UM', 1, 0, 'C', false);
      $this->MultiAlignCell(15, 8, 'Cantitate', 1, 0, 'C', false);
      $this->MultiAlignCell(15, 4, 'Cota TVA (%)', 1, 0, 'C', false);
      $this->MultiAlignCell(35, 4, "Pret unitar (fara T.V.A.)\n-lei-", 1, 0, 'C', false);
      $this->MultiAlignCell(20, 4, "Valoare\n-lei-", 1, 0, 'C', false);
      $this->MultiAlignCell(20, 4, "Valoare\nT.V.A. -lei-", 1, 0, 'C', false);
      $this->SetY(88);
      $this->SetX(5);
      $this->MultiAlignCell(10, 4, '0', 1, 0, 'C', false);
      $this->MultiAlignCell(75, 4, '1', 1, 0, 'C', false);
      $this->MultiAlignCell(10, 4, '2', 1, 0, 'C', false);
      $this->MultiAlignCell(15, 4, '3', 1, 0, 'C', false);
      $this->MultiAlignCell(15, 4, '4', 1, 0, 'C', false);
      $this->MultiAlignCell(35, 4, '5', 1, 0, 'C', false);
      $this->MultiAlignCell(20, 4, '6 (3x5)', 1, 0, 'C', false);
      $this->MultiAlignCell(20, 4, '7', 1, 1, 'C', false);
   }

   public function Footer()
   {
      $this->Line(45, 230, 45, 270);
      $this->Line(115, 230, 115, 270);
      $this->Line(115, 250, 205, 250);
      $this->Line(165, 230, 165, 270);
      $this->Line(185, 230, 185, 250);

      $this->SetFont('helvetica', '', 10);
      $this->SetY(232);
      $this->SetX(10);
      $this->MultiAlignCell(30, 5, "Semnatura si\nstampila\nfurnizorului", 0, 0, 'C', false);
      $this->SetFont('helvetica', '', 8);
      $this->SetY(230);
      $this->SetX(45);
      $this->MultiCell(60, 5, "Date privind expeditia\nNumele delegatului: ......................\nB.I / C.I. seria ............... nr. ................ eliberat(a) ......................\nMijloc de transport: ...............\nNr. inmatriculare: ..................");

      $this->Image(config('invoice.button_link'), 45, 260, 35, 9, '', $this->infoInvoice->payment_url);

      $this->SetFont('helvetica', '', 10);
      $this->SetY(235);
      $this->SetX(135);
      $this->Write(10, 'Total');
      $this->SetY(252);
      $this->SetX(125);
      $this->Write(10, 'Total de plata');
      $this->SetY(257);
      $this->SetX(125);
      $this->Write(10, '(col.6 + col.7)');

      $this->SetFont('helvetica', '', 8);
      $this->SetY(235);
      $this->SetX(167);
      $this->Write(10, $this->infoInvoice->total_fara_tva);

      $this->SetY(235);
      $this->SetX(186);
      $this->Write(10, $this->infoInvoice->total_tva);

      $this->SetY(255);
      $this->SetX(175);
      $this->SetFont('helvetica', 'B', 10);
      $this->Write(10, $this->infoInvoice->total_general);

      $this->SetFont('helvetica', '', 8);
      $this->SetY(-28);
      $this->Write(10, 'Termen de plata: '.Carbon::parse($this->infoInvoice->termen_de_plata)->format('d/m/Y'));

      $this->SetFont('helvetica', '', 7);
      $this->SetY(-24);
      $this->SetTextColor(128, 126, 124);
      $this->Write(10, 'Factura este valabila fara semnatura si stampila, conform art. 319 alin. 29 din legea 227/2015');

      $this->SetY(-12);
      $this->SetTextColor(0, 0, 0);
      $this->Cell(200, 5, 'Pagina '.$this->PageNo().'/{nb}', 0, 0, 'C');
   }
}
