<?php

include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 session_start();
 @$ayo=$_REQUEST['Ayo'];
 @$situacion=$_REQUEST['Situacion'];
 @$usuario=$_REQUEST['Usuario'];
 @$inicios=$_REQUEST['Inicio'];
 @$fins=$_REQUEST['Fin'];
 $format="d/m/Y";
 $html = "";
 @$sec=$_SESSION['SECTOR'];	 
 
 $sql="select AYO,SECTOR,ID_FACTURA,SITUACION,cast(PERIODO_INICIO as date) PERIODO_INICIO,cast (PERIODO_FIN as date) PERIODO_FIN,ID_USUARIO,R_SOCIAL,IMPORTE,PAGO,OBSERVACION,SALDO,FOLIO_SAT from V_FACTURAS where ID_FACTURA is not null ";
  $sql=$sql." and SECTOR=$sec"; 
  if(@$ayo!=""){ $sql=$sql." and AYO=$ayo"; }
  if(@$situacion!=""){ $sql=$sql." and SITUACION='$situacion'"; }
  if(@$usuario!=""){ $sql=$sql." and ID_USUARIO='$usuario'"; }
  if(@$inicios!="" and $fins!=""){ $sql=$sql." and PERIODO_INICIO='$inicios' AND PERIODO_FIN='$fins'"; }
  
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn, $sql , $params, $options );
$row_count = sqlsrv_num_rows( $stmt );
if($row_count>0){  
$html.="
<div  class='col-md-12 col-sm-12 col-xs-12'><br><center><a href='reportes/reporte_consulta_factura.php?ayo=$ayo&situacion=$situacion&usuario=$usuario&inicios=$inicios&fins=$fins'  class='btn btn-warning btn-sm' >Reporte</a><br></div>
<div  class='col-md-12 col-sm-12 col-xs-12'>&nbsp;</div>
<div  class='col-md-12 col-sm-12 col-xs-12'>
<table    class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:14px;'>
<thead>   
  <tr>
    <td align='center' class='bg-primary'><b>AÑO</td>
    <td align='center' class='bg-primary'><b>ID RECIBO</td>
    <td align='center' class='bg-primary'><b>SITUACION</td>
    <td align='center' class='bg-primary'><b>PERIODO INICIO</td>
    <td align='center' class='bg-primary'><b>PERIODO FIN </td>
    <td align='center' class='bg-primary'><b>ID USUARIO</td>
    <td align='center' class='bg-primary'><b>R. SOCIAL</td>
    <td align='center' class='bg-primary'><b>IMPORTE</td>
    <td align='center' class='bg-primary'><b>PAGO</td>
    <td align='center' class='bg-primary'><b>OBSERVACION</td>
    <td align='center' class='bg-primary'><b>SALDO</td>
    <td align='center' class='bg-primary'><b>FOLIO SAT</td>
  </tr>
 </thead>
  <tbody>";
 
	while($row = sqlsrv_fetch_array($stmt)){		
		if(@$row['PERIODO_INICIO']!=""){ $inicio=date_format(@$row['PERIODO_INICIO'], $format); }else{	$inicio=""; }
		if(@$row['PERIODO_FIN']!=""){ $fin=date_format(@$row['PERIODO_FIN'], $format); }else{	$fin=""; }
		$ayo=$row['AYO'];
		$recibo=$row['ID_FACTURA'];
		$situacion=$row['SITUACION'];
		$usuario=$row['ID_USUARIO'];	
		$social=utf8_encode($row['R_SOCIAL']);	
		if($row['IMPORTE']>0){
		$importe=number_format(@$row['IMPORTE'], 2, '.', ','); 
		}
		$pago=$row['PAGO'];	if($pago>0){  $pago=number_format(@$row['PAGO'], 2, '.', ',');  }else{ $pago=0; }
		$observacion=$row['OBSERVACION'];	
		$saldo=$row['SALDO'];	if($saldo>0){ $saldo=number_format(@$row['SALDO'], 2, '.', ',');   }else{ $saldo=0; }
		$folio=$row['FOLIO_SAT'];	
		
		
  $html.="<tr>
   <td> $ayo </td>
   <td> $recibo </td>
   <td> $situacion </td>
   <td> $inicio </td>
   <td> $fin </td>
   <td> $usuario </td>
   <td> $social </td>
   <td> $importe </td>
   <td> $pago </td>
   <td> $observacion </td>
   <td> $saldo </td>
   <td> $folio </td>

  
	";
	  
	$html.="</tr>";
	}
     
	 $html.="
  </tbody>
</table>";
		}else{
		
		@$html.="<br><br><br><br><br><br><div class='alert alert-danger' role='alert'>
				<strong>NO EXISTEN RESULTADOS CON LOS FILTROS SELECCIONADOS</strong>
			</div>";
		}			  
		echo $html;			  
		
?>