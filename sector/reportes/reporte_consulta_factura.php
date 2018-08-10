<?php

error_reporting(0);

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=REPORTE_CONSULTA_FACTURA.xls");

include_once '../../config.php';
 @$ayo=$_REQUEST['ayo'];
 @$situacion=$_REQUEST['situacion'];
 @$usuario=$_REQUEST['usuario'];
 @$inicios=$_REQUEST['inicios'];
 @$fins=$_REQUEST['fins'];
 $format="d/m/Y"; 			
?>      
<table align="center" cellpadding="5" cellspacing="1" >		
	<tr>
		
		<td style="width:50%;">
<table align="center" style="border: 1px solid #006699;" cellpadding="5" cellspacing="1" border="1">
	<thead>
		<tr style='background-color:#337ab7; color:white; '>
			<td align='center' class='bg-primary'><b>A&Ntilde;O</td>
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
<?php
$SQL="select * from V_FACTURAS where ID_FACTURA is not null ";
  if(@$ayo!=""){ $SQL=$SQL." and AYO=$ayo"; }
  if(@$situacion!=""){ $SQL=$SQL." and SITUACION='$situacion'"; }
  if(@$usuario!=""){ $SQL=$SQL." and ID_USUARIO='$usuario'"; }
  if(@$inicios!="" and $fins!=""){ $SQL=$SQL." and PERIODO_INICIO='$inicios' AND PERIODO_FIN='$fins'"; }
  $res = sqlsrv_query( $conn,$SQL);
 
	while($row = sqlsrv_fetch_array($res)){		
		if(@$row['PERIODO_INICIO']!=""){ $inicio=date_format(@$row['PERIODO_INICIO'], $format); }else{	$inicio=""; }
		if(@$row['PERIODO_FIN']!=""){ $fin=date_format(@$row['PERIODO_FIN'], $format); }else{	$fin=""; }
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
	?>
		<tr>
			<td><?php echo $ayo; ?></td>
		    <td><?php echo $recibo; ?></td>
		    <td><?php echo $situacion; ?></td>
		    <td><?php echo $inicio; ?></td>
		    <td><?php echo $fin; ?></td>
		    <td><?php echo $usuario; ?></td>
		    <td><?php echo utf8_decode($social); ?></td>
		    <td><?php echo $importe; ?></td>
		    <td><?php echo $pago; ?></td>
		    <td><?php echo $observacion; ?></td>
		    <td><?php echo $saldo; ?></td>
		    <td><?php echo $folio; ?></td>
		</tr>
<?php 
	}
?>
	</tbody>
</table>
</td>
		<td style="width:25%;">&nbsp;</td>
	</tr>
</table>

