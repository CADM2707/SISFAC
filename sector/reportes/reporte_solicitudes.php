<?php

error_reporting(0);

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=reporte_solicitudes.xls");

include_once '../../config.php';
@$usuario=$_REQUEST['usuario'];
 @$ayo=$_REQUEST['ayo'];
 @$sec=$_REQUEST['sec'];
 @$dest=$_REQUEST['dest'];
 $format="d/m/Y";	
?>      
<table align="center" cellpadding="5" cellspacing="1" >		
	<tr>
		<td style="width:25%;">&nbsp;</td>
		<td style="width:50%;">
<table align="center" style="border: 1px solid #006699;" cellpadding="5" cellspacing="1" border="1">
	<thead>
		<tr style='background-color:#337ab7; color:white; '>
			<td align='center' class='bg-primary'><b>ID FACTURA</td>
			<td align='center' class='bg-primary'><b>ID USUARIO</td>
			<td align='center' class='bg-primary'><b>RFC</td>
			<td align='center' class='bg-primary'><b>R. SOCIAL</td>
			<td align='center' class='bg-primary'><b>TIPO FACTURA</td>
			<td align='center' class='bg-primary'><b>SECTOR</td>
			<td align='center' class='bg-primary'><b>DEST.</td>
			<td align='center' class='bg-primary'><b>FECHA EMISION</td>
			<td align='center' class='bg-primary'><b>IMPORTE LETRA</td>
			<td align='center' class='bg-primary'><b>PERIODO INICIO</td>
			<td align='center' class='bg-primary'><b>PERIODO FIN</td>
			<td align='center' class='bg-primary'><b>SITUACION</td>			
		</tr>
	</thead>
<?php
$SQL="SELECT ID_FACTURA,ID_USUARIO,RFC,R_SOCIAL,TIPO_FACTURA,SECTOR,DESTACAMENTO,FECHA_EMISION,IMPORTE_LETRA,PERIODO_INICIO,PERIODO_FIN,SITUACION  From FACTURACION.DBO.Factura F
     INNER JOIN Facturacion.DBO.C_Tipo_Factura CF ON F.CVE_TIPO_FACTURA=CF.CVE_TIPO_FACTURA
     INNER JOIN Facturacion.DBO.XXC_Situacion  XS ON F.CVE_SITUACION=XS.CVE_SITUACION
	 where ID_FACTURA is not null ";
  if(@$ayo!=""){ $SQL=$SQL." and AYO=$ayo"; }
  if(@$sec!=""){ $SQL=$SQL." and SECTOR='$sec'"; }
  if(@$dest!=""){ $SQL=$SQL." and DESTACAMENTO='$dest'"; }
  
  $res = sqlsrv_query( $conn,$SQL);
	while($row = sqlsrv_fetch_array($res)){
		$inicio=date_format($row['PERIODO_INICIO'], $format); 
		$fin=date_format($row['PERIODO_FIN'], $format); 
		$emision=date_format(@$row['FECHA_EMISION'], $format); 
		$id=$row['ID_FACTURA'];
		$usuario=$row['ID_USUARIO'];	
		$rfc=$row['RFC'];
		$social=utf8_encode($row['R_SOCIAL']);	
		$factura=$row['TIPO_FACTURA'];	
		$sector=$row['SECTOR'];	
		$des=$row['DESTACAMENTO'];	
		$impo=$row['IMPORTE_LETRA'];	
		$situacion=$row['SITUACION'];	
	?>
		<tr>
			<td><?php echo $id; ?></td>
		    <td><?php echo $usuario; ?> </td>
		    <td><?php echo $rfc; ?> </td>
		    <td><?php echo utf8_decode($social); ?> </td>
		    <td><?php echo $factura; ?> </td>
		    <td><?php echo $sector; ?> </td>
		    <td><?php echo $des; ?> </td>
		    <td><?php echo $emision; ?> </td>
		    <td><?php echo $impo; ?> </td>
		    <td><?php echo $inicio; ?> </td>
		    <td><?php echo $fin; ?> </td>
		    <td><?php echo $situacion; ?> </td>
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

