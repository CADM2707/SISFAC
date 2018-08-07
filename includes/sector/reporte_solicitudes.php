<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 @$ayo=$_REQUEST['Ayo'];
 @$sec=$_REQUEST['Sec'];
 @$dest=$_REQUEST['Destacamento'];
 $format="d/m/Y";
 $html = "";
$html.="<table    class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:10px;'>
<thead>   
  <tr>
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
  <tbody>";
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
		
  $html.="<tr>
   <td> $id </td>
   <td> $usuario </td>
   <td> $rfc </td>
   <td> $social </td>
   <td> $factura </td>
   <td> $sector </td>
   <td> $des </td>
   <td> $emision </td>
   <td> $impo </td>
   <td> $inicio </td>
   <td> $fin </td>
   <td> $situacion </td>

  
	";
	  
	$html.="</tr>";
	}
     
	 $html.="
  </tbody>
</table>";
					  
		echo $html;			  

?>