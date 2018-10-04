
<?php 
session_start(); 

//require('conexion.php');
//$conne = conecta();
include '../../conexiones/sqlsrv.php';
$conn = connection_object();

 @$ayo=$_REQUEST['Ayo'];
 @$qna=$_REQUEST['Qna'];
 @$usuario=$_REQUEST['usuario'];
 
 	$sql_usu2="declare @usuf as varchar(15)
			select @usuf=ID_USUARIO_FACTURA  from Parametros_Facturacion  where ID_USUARIO='$usuario'
			select @usuf usuario2";
	$res_usu2 = sqlsrv_query( $conn,$sql_usu2);
	$row_usu2 = sqlsrv_fetch_array($res_usu2);
 	$usuario2=$row_usu2['usuario2'];
	if(@$usuario2!=""){ $usuario=$usuario2; }else{ $usuario=$usuario; }
 
 
	$sql_previo="EXEC [sp_Consulta_Previo] '$usuario',$ayo,$qna";
	$res_previo = sqlsrv_query( $conn,$sql_previo);
	$row_previo = sqlsrv_fetch_array($res_previo);
	//$format="Y/m/d";
	//$ini=date_format($c_row['FECHA_INI'], $format); 
	$id=$row_previo['ID_USUARIO']; 
	$sec=$row_previo['SECTOR']; 
	$dest=$row_previo['DESTACAMENTO']; 
	$rfc=$row_previo['RFC']; 
	$social=$row_previo['R_SOCIAL']; 
	$periodo=$row_previo['PERIODO_LETRA']; 
	@$sub2=$row_previo['SUBTOTAL']; 
	@$tded2=$row_previo['DEDUCCION']; 
	if($tded2>0){ @$tded=number_format($tded2, 2); }else { $tded=0; }
	if($sub2>0){ @$sub=number_format($sub2, 2); }else { $sub=0; }
	$iva2=$row_previo['IVA']; 
	if($iva2>0){ @$iva=number_format($iva2, 2); }else { $iva=0; }
	@$tot2=$row_previo['TOTAL']; 
	if($tot2>0){ @$tot=number_format($tot2, 2); }else { $tot=0; }
	@$c_fact=$row_previo['CVE_TIPO_FACTURA']; 
	@$c_form=$row_previo['CVE_FORMATO']; 
	@$letra=$row_previo['LETRA']; 
	
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
	$this->Cell(55,5,utf8_decode(""),0,0,'C',0);
	$this->Ln(5);
	$this->SetFont('Arial','B',9);
	$this->SetTextColor(255,255,255);
	$this->Cell(135);
	$this->Cell(55,5,utf8_decode("Fecha y Hora de Emisión"),0,0,'C',1);
	$this->Ln(5);
	$this->SetTextColor(0,0,0);
	$this->Cell(135);
	$this->SetFont('Arial','',7);
	$this->Cell(55,5,"",0,0,'C',0);
	$this->Ln(5);
	$this->SetFont('Arial','B',9);
	$this->SetTextColor(255,255,255);
	$this->Cell(135);
	$this->Cell(55,5,utf8_decode("Fecha y Hora de Certificación"),0,0,'C',1);
	$this->Ln(5);
	$this->SetTextColor(0,0,0);
	$this->Cell(135);
	$this->SetFont('Arial','',7);
	$this->Cell(55,5,"",0,0,'C',0);
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
	$this->Cell(28,5,utf8_decode(""),0,0,'C',0);
	$this->Cell(27,5,utf8_decode(""),0,0,'C',0);
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
	$pdf->Cell(20,5,utf8_decode($rfc),0,0,'C',0);
	$pdf->Cell(60,5,html_entity_decode(substr($social,0,40)),0,0,'C',0);
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
		$pdf->Cell(10,5,utf8_decode("#"),0,0,'C',1);
		$pdf->Cell(20,5,utf8_decode("Turnos"),0,0,'R',1);
		$pdf->Cell(60,5,utf8_decode("Concepto"),0,0,'L',1);
		$pdf->Cell(20,5,utf8_decode("Tarifa"),0,0,'R',1);
		$pdf->Cell(20,5,utf8_decode("Importe"),0,0,'R',1);
		$pdf->Cell(30,5,utf8_decode("Deductiva"),0,0,'R',1);
		$pdf->Cell(30,5,utf8_decode("Leyenda"),0,0,'R',1);
		
	$pdf->Ln(5);
 	//$sql_previo2="EXEC [sp_Consulta_Previo_des] '$usuario',$ayo,$qna";
 	$sql_previo2="EXEC [sp_Consulta_Previo_Des_FacE] '$usuario',$ayo,$qna";
	$res_previo2 = sqlsrv_query( $conn,$sql_previo2);
	while ($row_previo2 = sqlsrv_fetch_array($res_previo2)){
		$id_des=$row_previo2['ID_DESGLOSE']; 
		$turnos=$row_previo2['TURNOS']; 
		$tarifa2=$row_previo2['TARIFA']; 
		$deductiva=$row_previo2['MONTO_DEDUCTIVA']; 
		$leyendad=$row_previo2['LEYENDA_AJUSTE'];    
		if($tarifa2>0){ $tarifa=number_format($tarifa2, 2); }else { $tarifa=0; }
		$importe2=$row_previo2['IMPORTE']; 
		if($importe2>0){ $importe=number_format($importe2, 2); }else { $importe=0; }
		$leyenda=$row_previo2['LEYENDA']; 
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(10,5,utf8_decode($id_des),0,0,'L',0);
		$pdf->Cell(20,5,utf8_decode($turnos),0,0,'R',0);
		$pdf->Cell(60,5,utf8_decode($leyenda),0,0,'L',0);
		$pdf->Cell(20,5,$tarifa,0,0,'R',0);
		$pdf->Cell(20,5,$importe,0,0,'R',0);
		$pdf->Cell(30,5,$deductiva,0,0,'R',0);
		$pdf->Cell(30,5,$leyendad,0,0,'R',0);
		
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
	$pdf->Cell(23,5,utf8_decode("$iva"),0,0,'C',0);
	$pdf->Cell(6);
	$pdf->Cell(46,5,utf8_decode(""),0,0,'C',0);
	$pdf->Cell(46,5,utf8_decode(""),0,0,'C',0);	
	$pdf->Ln(10);	
		
	
	
	
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(213,219,219);
	$pdf->Cell(137,15,utf8_decode(""),0,0,'L',1);
	$pdf->Cell(-137);
	$pdf->Cell(137,5,utf8_decode("Importe con Letra:"),0,0,'L',0);
	
	$pdf->SetFont('Arial','',6);
	$pdf->Ln(4);
	$pdf->Cell(137,5,utf8_decode("$letra"),0,0,'L',0);
	
	
	$pdf->Ln(-5);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(139);
	$pdf->Cell(13,5,utf8_decode("Subtotal:"),0,0,'L',0);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(38,5,utf8_decode($sub),0,0,'R',0);
	$pdf->Ln(4);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(139);
	$pdf->Cell(13,5,utf8_decode("Descuentos:"),0,0,'L',0);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(38,5,utf8_decode($tded),0,0,'R',0);
	$pdf->Ln(4);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(139);
	$pdf->Cell(13,5,utf8_decode("Importe Traslados:"),0,0,'L',0);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(38,5,utf8_decode("$iva"),0,0,'R',0);
	$pdf->Ln(4);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(139);
	$pdf->Cell(13,5,utf8_decode("Total:"),0,0,'L',0);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(38,5,utf8_decode(@$tot),0,0,'R',0);
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
	$pdf->Cell(31,5,utf8_decode("PERIODO ".$periodo),0,0,'L',0);
	$pdf->Ln(4);
	$pdf->Cell(31,5,utf8_decode("USUARIO ".$id),0,0,'L',0);
	$pdf->Ln(4);
	$pdf->Cell(31,5,utf8_decode("SECTOR ".$sec),0,0,'L',0);
	$pdf->Ln(5);
	/* $pdf->Image('../../dist/img/QR.png',163,220,40); */
	
	
	/*$pdf->SetFont('Arial','',6);
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
	
	*/
	
	
$pdf->Output();

?>