<?php

error_reporting(0);

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=ajuste_sin_elementos.xls");

include_once '../../config.php';
 @$ayo=$_REQUEST['ayo'];
 @$usuario=$_REQUEST['usuario'];
 @$qna=$_REQUEST['qna'];
 $format="d/m/Y";	
	$html = "";
$html.="
<table    class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:10px;'>
<thead>   
  <tr>
    <td align='center' class='bg-primary'><b>ID ELEMENTO</td>
    <td align='center' class='bg-primary'><b>NOMBRE</td>
    <td align='center' class='bg-primary'><b>MARCA</td>
    <td align='center' class='bg-primary'><b>TIPO TURNO</td>
    <td align='center' class='bg-primary'><b>FECHA</td>
  </tr>
 </thead>
  <tbody>";
  $SQL="exec sp_Consulta_Detalle_Turnos '$usuario',$qna,$ayo";
  $res = sqlsrv_query( $conn,$SQL);
 
	while($row = sqlsrv_fetch_array($res)){		
		$fecha=date_format($row['FECHA'], $format); 
		$marca=$row['MARCA'];
		$elemento=$row['ID_ELEMENTO'];
		$nombre=$row['NOMBRE'];
		$turno=$row['TIPO_TURNO'];		
  $html.="<tr>
   <td> $elemento </td>
   <td>".utf8_encode($nombre)." </td>
   <td> $marca </td>
   <td> $turno </td>
   <td> $fecha </td>";
	  
	$html.="</tr>";
	}
     
	 $html.="
  </tbody>
</table>";
					  
		echo $html;	