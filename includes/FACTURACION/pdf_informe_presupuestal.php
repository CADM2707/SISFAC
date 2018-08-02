
<?php 
session_start(); 

require('../conexion.php');
$conne2 = conecta2();
 $sector=@$_REQUEST['sector'];
$destacamento=@$_REQUEST['destacamento'];
$destabueno=@$_REQUEST['destabueno'];


	
require('../FPDF/fpdf.php');

class PDF extends FPDF
{
	
	function Header()
	
{
$this->SetFont('Arial','B',15);

 
	$this->Image('../img/pa.png',10,13,20);
	$this->Image('../img/cdmx.png',155,13,50);
	$this->SetFillColor(171,178,185);
	$this->SetTextColor(255,255,255);
	$this->SetTextColor(0,0,0);
	$this->Ln(4);
	$this->Cell(170,8,utf8_decode('GOBIERNO DE LA CIUDAD DE MÉXICO'),0,0,'C',0);
    // Salto de línea
   	//$this->Ln(8);
	$this->Ln(10);
	$this->SetFont('Arial','B',11);
	$this->Cell(170,7,utf8_decode("Secretaría de Seguridad Pública de la Ciudad de México"),0,0,'C',0);
	$this->Ln(20);
	
}
		function Footer()
{

}
}


	
$pdf=new PDF();



	$dia=date('d');
	$mes=date('m');
	if($mes==1){  $mes2='Enero'; }
	if($mes==2){  $mes2='Febrero'; }
	if($mes==3){  $mes2='Marzo'; }
	if($mes==4){  $mes2='Abril'; }
	if($mes==5){  $mes2='Mayo'; }
	if($mes==6){  $mes2='Junio'; }
	if($mes==7){  $mes2='Julio'; }
	if($mes==8){  $mes2='Agosto'; }
	if($mes==9){  $mes2='Septiembre'; }
	if($mes==10){ $mes2='Octubre'; }
	if($mes==11){ $mes2='Noviembre'; }
	if($mes==12){ $mes2='Diciembre'; }
	$ayo=date('Y');
	
		$pdf->AddPage();
		
		$pdf->SetFont('Arial','B',12);
		$pdf->SetFillColor(171,178,185);
		$pdf->SetTextColor(0,0,0);
		$pdf->MultiCell(190,5,utf8_decode('INFORME PRESUPUESTAL DE LIQUIDACIONES A CARGO DE LAS UNIDADES EJECUTORAS DEL GASTO, USUARIAS DE LOS SERVICIOS DE LA POICÍA AUXILIAR DE LA CIUDAD DE MÉXICO'),0,'C');
		
		$sqltn="declare 
		@usuario  varchar(15)='32024-03' ,
		@ayo int =2017,
		@recibo int=663190,
		@qna int = 12
		select ID_RECIBO,r.ID_USUARIO,r.SECTOR,r.DESTACAMENTO,R_SOCIAL,DOMICILIO,COLONIA,RFC,ENTIDAD,LOCALIDAD,CP,TOTAL,IMPORTE_LETRA,PERIODO_LETRA,LEYENDA ,ID_FORMATO 
		from recibo r
		inner join usuario_formato uf on r.ID_USUARIO=uf.ID_USUARIO
		inner join tipo_formato tf on uf.TIPO_FORMATO=tf.ID_FORMATO
		where ayo=@ayo and R.ID_USUARIO=@usuario and ID_RECIBO=@recibo"; 
		$restn = mssql_query($sqltn, $conne2);
		$rowtn = mssql_fetch_array($restn);
		$recibo=$rowtn['ID_RECIBO'];
		$usuario=$rowtn['ID_USUARIO'];
		$sector=$rowtn['SECTOR'];
		$formato=$rowtn['ID_FORMATO'];
		$destacamento=$rowtn['DESTACAMENTO'];
		$razon=$rowtn['R_SOCIAL'];
		$domicilio=$rowtn['DOMICILIO'];
		$colonia=$rowtn['COLONIA'];
		$entidad=$rowtn['ENTIDAD'];
		$localidad=$rowtn['LOCALIDAD'];
		$cp=$rowtn['CP'];
		$rfc=$rowtn['RFC'];
		$total=$rowtn['TOTAL'];
		$importe_letra=$rowtn['IMPORTE_LETRA'];
		$periodo=$rowtn['PERIODO_LETRA'];
		$leyenda=$rowtn['LEYENDA'];
		
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(170,10,"FOLIO E ",0,0,'R',0);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(20,10," $recibo",0,0,'L',0);
		$pdf->Ln(10);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(120,10,"UNIDAD EJECUTORA  DEL GASTO QUE RECIBE LOS SERVICIOS",1,0,'C',1);
		$pdf->Cell(10,5,"",0,0,'C',0);
		$pdf->Cell(60,10,"FECHA Y LUGAR DE EMISION",1,0,'C',1);
		$pdf->Ln(10);
		$pdf->Cell(120,25,"",1,0,'C',0);
		$pdf->Cell(10,5,"",0,0,'C',0);
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(60,10,utf8_decode("Ciudad de México a, $dia de $mes2 del $ayo"),1,0,'C',0);
		$pdf->Ln(10);
		$pdf->Cell(130,10,"",0,0,'L',0);
		$pdf->Cell(60,15,"",1,0,'L',0);
		$pdf->Ln(-.1);
		$pdf->Cell(130,10,"",0,0,'L',0);
		$pdf->Cell(30,5,"",0,0,'L',0);
		$pdf->Cell(30,5,"Unidad:  $sector",0,0,'L',0);
		$pdf->Ln(5);
		$pdf->Cell(130,10,"",0,0,'L',0);
		$pdf->Cell(30,5,"Usuario:  $usuario",0,0,'L',0);
		$pdf->Cell(30,5,"Grupo:  0",0,0,'L',0);
		$pdf->Ln(5);
		$pdf->Cell(130,10,"",0,0,'L',0);
		$pdf->Cell(30,5,"",0,0,'L',0);
		$pdf->Cell(30,5,"Dest.:  $destacamento",0,0,'L',0);
		
		$pdf->SetFont('Arial','',7);
		$pdf->Ln(-20);
		$pdf->MultiCell(120,4,"$razon");
		if($formato==6){
			$direccion="$domicilio $colonia $entidad $localidad $cp  R.F.C.$rfc";
			$pdf->Ln(5);	
			$pdf->MultiCell(120,4,"$direccion");
			$pdf->Ln(-15);	
		}
		
		
		$pdf->SetFont('Arial','',10);
		$pdf->Ln(25);
		$pdf->MultiCell(190,4,("$leyenda"),0,'J');
		$pdf->SetFont('Arial','B',8);
		$pdf->Ln(10);
		$pdf->Cell(190,10,utf8_decode("DESCRIPCIÓN DEL SERVICIO"),1,0,'C',1);
		$sqltn3="select TURNOS,TARIFA,IMPORTE from Recibos_Desglose where ayo=2017  and ID_RECIBO=663190 and id_usuario='32024-03' "; 
		$restn3 = mssql_query($sqltn3, $conne2);
		$pdf->Ln(10);
		if($formato==1 or $formato==4 or $formato==5 or $formato==6){
		$pdf->Cell(60,10,utf8_decode("SERVICIO"),0,0,'C',0);
		$pdf->Cell(40,10,utf8_decode("TURNOS"),0,0,'C',0);
		$pdf->Cell(45,10,utf8_decode("TARIFA"),0,0,'R',0);
		$pdf->Cell(40,10,utf8_decode("IMPORTE"),0,0,'R',0);
		}if($formato==3){
		$pdf->Cell(25,10,utf8_decode("ELEMENTOS"),0,0,'C',0);
		$pdf->Cell(25,10,utf8_decode("HORARIO"),0,0,'C',0);
		$pdf->Cell(25,10,utf8_decode("TURNOS"),0,0,'C',0);
		$pdf->Cell(25,10,utf8_decode("TARIFA"),0,0,'C',0);
		$pdf->Cell(25,10,utf8_decode("IMPORTE"),0,0,'C',0);
		}
		if($formato==2){
		$pdf->Cell(25,10,utf8_decode("ELEMENTOS"),0,0,'C',0);
		$pdf->Cell(25,10,utf8_decode("DIAS"),0,0,'C',0);
		$pdf->Cell(25,10,utf8_decode("HORARIO"),0,0,'C',0);
		$pdf->Cell(25,10,utf8_decode("TURNOS"),0,0,'C',0);
		$pdf->Cell(25,10,utf8_decode("TARIFA"),0,0,'C',0);
		$pdf->Cell(25,10,utf8_decode("IMPORTE"),0,0,'C',0);
		}
		$pdf->Ln(10);
		$pdf->SetFont('Arial','',8);
		while($rowtn3 = mssql_fetch_array($restn3)){
			$turnos=$rowtn3['TURNOS'];
			$tarifa=$rowtn3['TARIFA'];
			$importe=$rowtn3['IMPORTE'];
			if($formato==1 or $formato==4 or $formato==5 or $formato==6){
				$pdf->Cell(60,5,utf8_decode(""),0,0,'C',0);
				$pdf->Cell(40,5,number_format($turnos, 0, '.', ','),0,0,'C',0);
				$pdf->Cell(45,5,'$ '.number_format($tarifa, 2, '.', ','),0,0,'R',0);
				$pdf->Cell(40,5,'$ '.number_format($importe, 2, '.', ','),0,0,'R',0);
			}if($formato==3){
				$pdf->Cell(25,5,utf8_decode(""),0,0,'C',0);
				$pdf->Cell(25,5,utf8_decode(""),0,0,'C',0);
				$pdf->Cell(25,5,number_format($turnos, 0, '.', ','),0,0,'C',0);
				$pdf->Cell(25,5,'$ '.number_format($tarifa, 2, '.', ','),0,0,'R',0);
				$pdf->Cell(25,5,'$ '.number_format($importe, 2, '.', ','),0,0,'R',0);
			}if($formato==2){
				$pdf->Cell(25,5,utf8_decode(""),0,0,'C',0);
				$pdf->Cell(25,5,utf8_decode(""),0,0,'C',0);
				$pdf->Cell(25,5,utf8_decode(""),0,0,'C',0);
				$pdf->Cell(25,5,number_format($turnos, 0, '.', ','),0,0,'C',0);
				$pdf->Cell(25,5,'$ '.number_format($tarifa, 2, '.', ','),0,0,'R',0);
				$pdf->Cell(25,5,'$ '.number_format($importe, 2, '.', ','),0,0,'R',0);
			}	
			$pdf->Ln(5);
		}
		$pdf->SetFont('Arial','B',8);
		$pdf->Ln(8);
		$pdf->Cell(25,10,utf8_decode("PERÍODO"),1,0,'C',1);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(90,10,utf8_decode("$periodo"),1,0,'C',0);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(10,10,"",0,0,'C',0);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(20,10,"IMPORTE",1,0,'C',1);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(45,10,'$'.number_format($total, 2, '.', ','),1,0,'R',0);
		$pdf->Ln(15);
		$pdf->Cell(190,10,"IMPORTE CON LETRA",1,0,'C',1);
		$pdf->Ln(10);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(190,10,"$importe_letra",1,0,'C',0);
		$pdf->SetFont('Arial','B',8);
		$pdf->Ln(15);
		$pdf->Cell(90,10,utf8_decode("SELLO Y FIRMA DE LA P.A.C.M."),1,0,'C',1);
		$pdf->Cell(10,10,"",0,0,'C',0);
		$pdf->Cell(90,10,utf8_decode("FIRMA DE CONFORMIDAD DE USUARIO"),1,0,'C',1);
		$pdf->Ln(10);
		$pdf->Cell(90,25,utf8_decode(""),1,0,'C',0);
		$pdf->Cell(10,20,"",0,0,'C',0);
		$pdf->Cell(90,25,utf8_decode(""),1,0,'C',0);
		$pdf->Ln(17);
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(90,5,utf8_decode("MTRO. JUAN MANUEL GARCÍA GERARDO"),0,0,'C',0);
		$pdf->Ln(4);
		$pdf->Cell(90,5,utf8_decode("DIRECTOR DE FINANZAS DE LA P.A.C.M."),0,0,'C',0);
		$pdf->Ln(-11);
		//$pdf->Cell(90,20,utf8_decode(""),0,0,'C',0);
		//$pdf->Cell(10,20,"",0,0,'C',0);
		//$pdf->Cell(90,15,utf8_decode(""),0,0,'C',0);
		//$pdf->Cell(45,15,utf8_decode(""),1,0,'C',0);
		
		$pdf->Ln(10);
		
$pdf->Ln(15);


$pdf->Ln(15);

$pdf->Output();

?>