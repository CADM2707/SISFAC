
<?php 
session_start(); 

//require('conexion.php');
//$conne = conecta();
$sector=@$_REQUEST['sector'];
$destacamento=@$_REQUEST['destacamento'];
$destabueno=@$_REQUEST['destabueno'];

	
require('../../fpdf/fpdf.php');

class PDF extends FPDF
{
	function Header()
{
	$this->SetFont('Arial','B',9);
	$this->Image('../../dist/img/logo_fact.png',20,10,45);
	$this->SetFillColor(255,61,170);
	$this->SetTextColor(255,255,255);
	$this->SetTextColor(0,0,0);
	$this->Ln(16);
	$this->Cell(190,8,utf8_decode('GOBIERNO DE LA CIUDAD DE MÉXICO'),0,0,'C',0);
	$this->Ln(5);	
	$this->Cell(190,7,utf8_decode("GDF9712054NA"),0,0,'C',0);
	$this->Ln(15);
	
	
	$this->Ln(-36);
	$this->SetFont('Arial','B',9);
	$this->SetTextColor(255,255,255);
	$this->Cell(135);
	$this->Cell(55,5,utf8_decode("Folio Fiscal"),0,0,'C',1);
	$this->Ln(5);
	$this->SetTextColor(0,0,0);
	$this->Cell(135);
	$this->SetFont('Arial','',7);
	$this->Cell(55,5,utf8_decode("011C1780-F808-41E3-AE0B-D50C48A73BBC"),0,0,'C',0);
	$this->Ln(5);
	$this->SetFont('Arial','B',9);
	$this->SetTextColor(255,255,255);
	$this->Cell(135);
	$this->Cell(55,5,utf8_decode("Fecha y Hora de Emisión"),0,0,'C',1);
	$this->Ln(5);
	$this->SetTextColor(0,0,0);
	$this->Cell(135);
	$this->SetFont('Arial','',7);
	$this->Cell(55,5,date('d-m-Y H:i'),0,0,'C',0);
	$this->Ln(5);
	$this->SetFont('Arial','B',9);
	$this->SetTextColor(255,255,255);
	$this->Cell(135);
	$this->Cell(55,5,utf8_decode("Fecha y Hora de Certificación"),0,0,'C',1);
	$this->Ln(5);
	$this->SetTextColor(0,0,0);
	$this->Cell(135);
	$this->SetFont('Arial','',7);
	$this->Cell(55,5,date('d-m-Y H:i'),0,0,'C',0);
	$this->Ln(5);
	$this->SetFont('Arial','B',9);
	$this->SetTextColor(255,255,255);
	$this->Cell(135);
	$this->Cell(28,5,utf8_decode("Serie"),0,0,'C',1);
	$this->Cell(27,5,utf8_decode("Folio"),0,0,'C',1);
	$this->Ln(5);
	$this->SetTextColor(0,0,0);
	$this->Cell(135);
	$this->SetFont('Arial','',7);
	$this->Cell(28,5,utf8_decode("PA73"),0,0,'C',0);
	$this->Cell(27,5,utf8_decode("195689"),0,0,'C',0);
	$this->Ln(5);
	
	
	
	
	$this->SetTextColor(255,61,170);
	$this->Cell(19,5,utf8_decode("Régimen Fiscal:"),0,0,'L',0);
	$this->SetTextColor(0,0,0);
	$this->Cell(32,5,utf8_decode("603"),0,0,'L',0);
	$this->SetTextColor(255,61,170);
	$this->Cell(27,5,utf8_decode("Lugar de Expedición:"),0,0,'R',0);
	$this->SetTextColor(0,0,0);
	$this->Cell(32,5,utf8_decode("06350"),0,0,'L',0);
	$this->SetTextColor(255,61,170);
	$this->Cell(48,5,utf8_decode("No. de Certificado Emisor:"),0,0,'R',0);
	$this->SetTextColor(0,0,0);
	$this->Cell(32,5,utf8_decode("00001000000408799122"),0,0,'R',0);
	
	
	$this->Ln(8);
	
	
}
		function Footer(){	
	$this->Ln(1);
	$this->SetTextColor(0,0,0);
	$this->Cell(190,5,utf8_decode("ESTE DOCUMENTO ES UNA REPRESENTACIÓN IMPRESA DE UN CFDI"),0,0,'C',0);
	$this->Ln(4);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,utf8_decode('Página '.$this->PageNo()),0,0,'L');
		
		}
}
	
$pdf=new PDF();
$pdf->AddPage();
		
	$pdf->SetFont('Arial','B',9);
	$pdf->SetFillColor(255,61,170);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(92,5,utf8_decode("Datos del Receptor"),0,0,'C',1);
	$pdf->Cell(6);
	$pdf->Cell(92,5,utf8_decode("Unidad Emisora"),0,0,'C',1);
	$pdf->Ln(5);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(213,219,219);
	$pdf->Cell(20,5,utf8_decode("R.F.C."),0,0,'C',1);
	$pdf->Cell(60,5,utf8_decode("Nombre del Receptor"),0,0,'C',1);
	$pdf->Cell(12,5,utf8_decode("Uso CFDI"),0,0,'C',1);
	$pdf->Cell(6);
	$pdf->Cell(92,5,utf8_decode("Nombre Unidad"),0,0,'C',1);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(20,5,utf8_decode("CAF110729PK3"),0,0,'C',0);
	$pdf->Cell(60,5,utf8_decode("CRUZ AZUL FUTBOL CLUB, A.C."),0,0,'C',0);
	$pdf->Cell(12,5,utf8_decode("G03"),0,0,'C',0);
	$pdf->Cell(6);
	$pdf->Cell(92,5,utf8_decode("11CD02 Policia Auxiliar"),0,0,'C',0);	
	$pdf->Ln(10);	
	
	/*		Conceptos		CONCEPTOS				Conceptos		CONCEPTOS				Conceptos		CONCEPTOS		*/
	/*		Conceptos		CONCEPTOS				Conceptos		CONCEPTOS				Conceptos		CONCEPTOS		*/
	/*		Conceptos		CONCEPTOS				Conceptos		CONCEPTOS				Conceptos		CONCEPTOS		*/
	$pdf->SetFont('Arial','B',9);
	$pdf->SetFillColor(255,61,170);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(190,5,utf8_decode("Conceptos"),0,0,'C',1);
	$pdf->Ln(5);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(213,219,219);
		$pdf->Cell(18,5,utf8_decode("Cantidad"),0,0,'L',1);
		$pdf->Cell(18,5,utf8_decode("Clave Unidad"),0,0,'C',1);
		$pdf->Cell(18,5,utf8_decode("Unidad"),0,0,'C',1);
		$pdf->Cell(20,5,utf8_decode("Clave Concepto"),0,0,'C',1);
		$pdf->Cell(55,5,utf8_decode("Descripción"),0,0,'C',1);
		$pdf->Cell(22,5,utf8_decode("No. Identificación"),0,0,'C',1);
		$pdf->Cell(20,5,utf8_decode("Valor Unitario"),0,0,'R',1);
		$pdf->Cell(19,5,utf8_decode("Importe"),0,0,'R',1);
	$pdf->Ln(5);
		for ($i = 1; $i <= 10; $i++) {
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(18,5,utf8_decode("1.00"),0,0,'L',0);
			$pdf->Cell(18,5,utf8_decode("A9"),0,0,'C',0);
			$pdf->Cell(18,5,utf8_decode("TARIFA"),0,0,'C',0);
			$pdf->Cell(20,5,utf8_decode("92101501"),0,0,'C',0);
			$pdf->Cell(55,5,utf8_decode("Turnos x Tarifa Supervisor General"),0,0,'L',0);
			$pdf->Cell(22,5,utf8_decode("28364"),0,0,'C',0);
			$pdf->Cell(20,5,utf8_decode("1960.00"),0,0,'R',0);
			$pdf->Cell(19,5,utf8_decode("21750.00"),0,0,'R',0);
			$pdf->Ln(5);	
		}
	$pdf->Ln(10);
	/*	DESGLOSE DE IMPUESTOS  TRASLADADOS Y RETENIDOS		DESGLOSE DE IMPUESTOS  TRASLADADOS Y RETENIDOS		DESGLOSE DE IMPUESTOS  TRASLADADOS Y RETENIDOS		DESGLOSE DE IMPUESTOS  TRASLADADOS Y RETENIDOS		DESGLOSE DE IMPUESTOS  TRASLADADOS Y RETENIDOS		DESGLOSE DE IMPUESTOS  TRASLADADOS Y RETENIDOS		DESGLOSE DE IMPUESTOS  TRASLADADOS Y RETENIDOS	*/
	$pdf->SetFont('Arial','B',9);
	$pdf->SetFillColor(255,61,170);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(92,5,utf8_decode("Desglose de Impuestos Trasladados"),0,0,'C',1);
	$pdf->Cell(6);
	$pdf->Cell(92,5,utf8_decode("Desglose de Impuestos Retenidos"),0,0,'C',1);
	$pdf->Ln(5);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(213,219,219);
	$pdf->Cell(23,5,utf8_decode("Impuesto"),0,0,'C',1);
	$pdf->Cell(23,5,utf8_decode("Tipo Factor"),0,0,'C',1);
	$pdf->Cell(23,5,utf8_decode("Tasa O Cuota"),0,0,'C',1);
	$pdf->Cell(23,5,utf8_decode("Importe"),0,0,'C',1);
	$pdf->Cell(6);
	$pdf->Cell(46,5,utf8_decode("Impuesto"),0,0,'C',1);
	$pdf->Cell(46,5,utf8_decode("Importe"),0,0,'C',1);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(23,5,utf8_decode("002-IVA"),0,0,'C',0);
	$pdf->Cell(23,5,utf8_decode("TASA"),0,0,'C',0);
	$pdf->Cell(23,5,utf8_decode("0.160000"),0,0,'C',0);
	$pdf->Cell(23,5,utf8_decode("$6,099.20"),0,0,'C',0);
	$pdf->Cell(6);
	$pdf->Cell(46,5,utf8_decode(""),0,0,'C',0);
	$pdf->Cell(46,5,utf8_decode(""),0,0,'C',0);	
	$pdf->Ln(10);	
		
	
	
	
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(213,219,219);
	$pdf->Cell(130,15,utf8_decode(""),0,0,'L',1);
	$pdf->Cell(-130);
	$pdf->Cell(130,5,utf8_decode("Importe con Letra:"),0,0,'L',0);
	
	$pdf->SetFont('Arial','',7);
	$pdf->Ln(4);
	$pdf->Cell(130,5,utf8_decode("CUARENTA Y CUATRO MIL DOSCIENTOS DIECINUEVE PESOS (20/100) M.N."),0,0,'L',0);
	
	
	$pdf->Ln(-5);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(135);
	$pdf->Cell(13,5,utf8_decode("Subtotal:"),0,0,'L',0);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(42,5,utf8_decode("$38,120.00"),0,0,'R',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(135);
	$pdf->Cell(13,5,utf8_decode("Importe Traslados:"),0,0,'L',0);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(42,5,utf8_decode("$6,099.20"),0,0,'R',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(135);
	$pdf->Cell(13,5,utf8_decode("Total:"),0,0,'L',0);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(42,5,utf8_decode("$44,218.20"),0,0,'R',0);
	$pdf->Ln(10);
	
	
	$pdf->SetTextColor(255,61,170);
	$pdf->Cell(31,5,utf8_decode("Moneda"),0,0,'C',0);
	$pdf->Cell(31,5,utf8_decode("Tipo Cambio"),0,0,'C',0);
	$pdf->Cell(31,5,utf8_decode("Tipo de Comprobante"),0,0,'C',0);
	$pdf->Cell(31,5,utf8_decode("Método de Pago"),0,0,'C',0);
	$pdf->Cell(31,5,utf8_decode("Forma de Pago"),0,0,'C',0);
	$pdf->SetTextColor(0,0,0);
	$pdf->Ln(4);
	$pdf->Cell(31,5,utf8_decode("MXN"),0,0,'C',0);
	$pdf->Cell(31,5,utf8_decode("1.00"),0,0,'C',0);
	$pdf->Cell(31,5,utf8_decode("Ingreso"),0,0,'C',0);
	$pdf->Cell(31,5,utf8_decode("PPD"),0,0,'C',0);
	$pdf->Cell(31,5,utf8_decode("99"),0,0,'C',0);
	$pdf->Ln(8);	
	$pdf->SetTextColor(255,61,170);
	$pdf->Cell(31,5,utf8_decode("Observaciones:"),0,0,'L',0);
	$pdf->SetTextColor(0,0,0);
	$pdf->Ln(4);
	$pdf->Cell(31,5,utf8_decode("PERIODO Del 2 al 2 DE MAYO DE 2018"),0,0,'L',0);
	$pdf->Ln(4);
	$pdf->Cell(31,5,utf8_decode("USUARIO 28364-54"),0,0,'L',0);
	$pdf->Ln(4);
	$pdf->Cell(31,5,utf8_decode("SECTOR 73"),0,0,'L',0);
	$pdf->Ln(5);
	$pdf->Image('../../dist/img/QR.png',163,220,40);
	
	
	$pdf->SetFont('Arial','',6);
	$pdf->SetTextColor(255,61,170);
	
	$pdf->Cell(45,5,utf8_decode("No. de Serie Certificado del Sat:"),0,0,'L',0);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(45,5,utf8_decode("00001000000405112669"),0,0,'C',0);
	$pdf->SetTextColor(255,61,170);
	$pdf->Cell(31,5,utf8_decode("Versión CFDI"),0,0,'C',0);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(31,5,utf8_decode("3.3"),0,0,'C',0);
	
	$pdf->SetTextColor(255,61,170);
	$pdf->Ln(3);
	$pdf->Cell(45,4,utf8_decode("Sello Digital del Emisor"),0,0,'L',0);
	$pdf->Ln(4);
	$pdf->SetTextColor(0,0,0);
	
	$pdf->MultiCell(0,3,utf8_decode("iG1qm83dUFDLnRbDzn1MJ+POjjpScPtm5ObB3N67RTuSgGsJzy4ZV2DrXCKfd0kiZMwFjkEhbEyeUuz68PsaX3Kl3e7KpqZhT6L8aAEnYsL9gFNNNSfGFPt844r0
aJoR81FQRrgIhIzHDXSBmUtvuX9DNsEzQwHJcL0aT0lsKF4OTQ8b62EtL1C3nU4sbanbuqo/UzVzL7iP3EJe3OepvT+MS6+8f+k1dHQawObS/wfQLJP/gL6rxj0NA
DHfQObUbcVQiFqq/SWMwTc9DWQBiXWENZLVm3+e5jgq9U3vz70rhT+1cQFwgPl2Zsiy1XlwvgUKneqYyI53O4SnlTXwoA=="));

	$pdf->SetTextColor(255,61,170);
	
	$pdf->Cell(45,4,utf8_decode("Cadena Original del Complemento de Certificación Digital SAT"),0,0,'L',0);
	$pdf->Ln(4);
	$pdf->SetTextColor(0,0,0);
	
	$pdf->MultiCell(0,3,utf8_decode("||1.1|7542936d-5276-4571-8522-fbaa34399260|2018-07-12T17:37:06|FID080111867||iG1qm83dUFDLnRbDzn1MJ+POjjpScPtm5ObB3N67RTuSgGsJzy4ZV2DrX
CKfd0kiZMwFjkEhbEyeUuz68PsaX3Kl3e7KpqZhT6L8aAEnYsL9gFNNNSfGFPt844r0aJoR81FQRrgIhIzHDXSBmUtvuX9DNsEzQwHJcL0aT0lsKF4OTQ8b62EtL1
C3nU4sbanbuqo/UzVzL7iP3EJe3OepvT+MS6+8f+k1dHQawObS/wfQLJP/gL6rxj0NADHfQObUbcVQiFqq/SWMwTc9DWQBiXWENZLVm3+e5jgq9U3vz70rhT+1c
QFwgPl2Zsiy1XlwvgUKneqYyI53O4SnlTXwoA==|00001000000405112669||"));

	$pdf->SetTextColor(255,61,170);
	
	$pdf->Cell(45,4,utf8_decode("Sello Digital del SAT"),0,0,'L',0);
	$pdf->Ln(4);
	$pdf->SetTextColor(0,0,0);
	
	$pdf->MultiCell(0,3,utf8_decode("mfG2BtdLjCNX3jvzui2SLoZ/oqi0gWvm/TVO03vTw4xBZdqYSIhjiOxS0X4G4x70G3NvRFWwOTVQ9FkSGhvla6v4K4SHa19HW1iDAmOTXn7SWZDZ2SRlAC3VirH
Q/mXFSKydqPV/iTAl0UyP53KidmkL7k29Vwc4p6U7tF8KppfCOPgCkyDjNJl7yieK6Eea+8+c+WYYGxaII0V72YRcPEGX+XfuzBTbodwhTutSG5HiX2wS0qz1wfEaq
7dDOYzgLpwWXV0xtGtLRgXNpAqHpJEjUQnO5p2EMa7i9ySwOEIkz9qCdWMFah6J/1KNa1hwFEClAwUpbGTn2taLL/PnZA=="));
	
	
	
	
$pdf->Output();

?>