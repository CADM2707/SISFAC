<?php

error_reporting(0);

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=REPORTE_AJUSTE_DATOS.xls");

include_once '../../config.php';
@$usuario=$_REQUEST['usuario'];
 @$ayo=$_REQUEST['ayo'];
 @$qna=$_REQUEST['qna'];
 @$ope=$_REQUEST['ope'];
 @$fecha=$_REQUEST['fecha']; 
 $format="d/m/Y"; 			
?>      
<table align="center" cellpadding="5" cellspacing="1" >		
	<tr>
		<td style="width:25%;">&nbsp;</td>
		<td style="width:50%;">
<table align="center" style="border: 1px solid #006699;" cellpadding="5" cellspacing="1" border="1">
	<thead>
		<tr style='background-color:#337ab7; color:white; '>
			<th><center>ID</center></th>						
			<th><center>A&Ntilde;O</center></th>
			<th><center>QNA.</center></th>						
			<th><center>ID USUARIO</center></th>
			<th><center>ID SERVICIO</center></th>
			<th><center>TURNOS</center></th>
			<th><center>ID OPERADOR</center></th>
			<th><center>FECHA</center></th>					
		</tr>
	</thead>
<?php
if($usuario!=""){ @$sql_usu=" and ID_USUARIO='$usuario' ";  }
if($ayo!=""){ @$sql_ayo=" and AYO='$ayo' ";  }
if($qna!=""){ @$sql_qna=" and QNA='$qna' ";  }
if($ope!=""){ @$sql_ope=" and ID_OPERADOR='$ope' ";  }
if($fecha!=""){ @$sql_fecha=" and FECHA='$fecha' ";  }	
$sql_reporte =" select ID_SOLICITUD,ID_USUARIO,ID_SERVICIO,AYO,QNA,TURNOS,ID_OPERADOR,FECHA from Ajuste_Turnos_Contrato where ID_SOLICITUD IS NOT NULL $sql_usu $sql_ayo $sql_qna $sql_ope $sql_fecha";

$res_reporte = sqlsrv_query( $conn,$sql_reporte);
	while($row_reporte = sqlsrv_fetch_array(@$res_reporte)){									
		$fecha1=date_format($row_reporte['FECHA'], $format); 
		if(@$a%2==0){ $color="background-color:#E1EEF4";	}else{	$color="background-color:#FFFFFF";	}
		$ayo=$row_reporte['AYO'];
		$qna=$row_reporte['QNA'];
		$id=$row_reporte['ID_SOLICITUD'];
		$usu=$row_reporte['ID_USUARIO'];
		$turnos=$row_reporte['TURNOS'];
		$ope=$row_reporte['ID_OPERADOR'];
		$servicio=$row_reporte['ID_SERVICIO'];
	?>
		<tr>
			<td><center><?php echo $id;?></td>
			<td><center><?php echo $ayo ;?></td>
			<td><center><?php echo $qna;?></td>
			<td><center><?php echo $usu;?></td>
			<td><center><?php echo $servicio;?></td>
			<td><center><?php echo $turnos;?></td>							
			<td><center><?php echo $ope;?></td>
			<td><center><?php echo $fecha1;?> </td>
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

