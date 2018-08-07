<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 @$ayo=$_REQUEST['Ayo'];
 @$situacion=$_REQUEST['Situacion'];
 @$usuario=$_REQUEST['Usuario'];
 @$inicios=$_REQUEST['Inicio'];
 @$fins=$_REQUEST['Fin'];
 $format="d/m/Y";
 $html = "";
$html.="<table    class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:10px;'>
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
  $SQL="select * from V_FACTURAS where ID_FACTURA is not null ";
  if(@$ayo!=""){ $SQL=$SQL." and AYO=$ayo"; }
  if(@$situacion!=""){ $SQL=$SQL." and SITUACION='$situacion'"; }
  if(@$usuario!=""){ $SQL=$SQL." and ID_USUARIO='$usuario'"; }
  if(@$inicios!="" and $fins!=""){ $SQL=$SQL." and PERIODO_INICIO='$inicios' AND PERIODO_FIN='$fins'"; }
  $res = sqlsrv_query( $conn,$SQL);
 
	while($row = sqlsrv_fetch_array($res)){		
		$inicio=date_format($row['PERIODO_INICIO'], $format); 
		$fin=date_format($row['PERIODO_FIN'], $format); 
		$ayo=$row['AYO'];
		$recibo=$row['ID_FACTURA'];
		$situacion=$row['SITUACION'];
		$usuario=$row['ID_USUARIO'];	
		$social=utf8_encode($row['R_SOCIAL']);	
		$importe=$row['IMPORTE'];	
		$pago=$row['PAGO'];	
		$observacion=$row['OBSERVACION'];	
		$saldo=$row['SALDO'];	
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
					  
		echo $html;			  

?>