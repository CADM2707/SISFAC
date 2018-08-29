<?php
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=reporte_deductivas.xls");

include_once '../../config.php';
$usuario= $_REQUEST['usuario'];   
@$servicio=$_REQUEST['servicio'];
@$ayo=$_REQUEST['ayo'];
@$qna=$_REQUEST['qna'];
	$sql_agrega ="EXEC  [dbo].[sp_Consulta_Usuario] '$usuario'";
				$res_agrega = sqlsrv_query($conn,$sql_agrega);
				$row_agrega = sqlsrv_fetch_array($res_agrega);
				$id=$row_agrega['ID_USUARIO']; 
				$sector=$row_agrega['SECTOR']; 
				$destacamento=$row_agrega['DESTACAMENTO']; 
				$rfc=$row_agrega['RFC']; 
				$social=$row_agrega['R_SOCIAL']; 
				$domicilio=$row_agrega['DOMICILIO']; 
				$colonia=$row_agrega['COLONIA']; 
				$entidad=$row_agrega['ENTIDAD']; 
				$localidad=$row_agrega['LOCALIDAD']; 
				$cp=$row_agrega['CP']; 
				 
				
				
?>      

<table align="center" style="border: 1px solid #006699;" cellpadding="5" cellspacing="1" border="1">
					<thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>ID USUARIO</center></th>						
						<th><center>SERVICIO</center></th>						
						<th><center>RAZON SOCIAL</center></th>
						<th><center>RFC</center></th>						
						<th><center>SECTOR</center></th>
						<th><center>DEST.</center></th>
					  </tr>
					  </thead>
						<tr>
						<td><center><?php echo $id; ?></td>
						<td><center><?php echo  $servicio; ?> </td>
						<td><center><?php echo  $social; ?> </td>
						<td><center><?php echo  $rfc; ?></td>
						<td><center><?php echo  $sector; ?></td>
						<td><center><?php echo  $destacamento; ?></td>
					  </tr>
					  <thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>DOMICILIO</center></th>						
						<th><center>COLONIA</center></th>
						<th><center>ENTIDAD</center></th>						
						<th><center>LOCALIDAD</center></th>
						<th colspan="2"><center>C.P.</center></th>
					  </tr>
					  </thead>
						<tr>
						<td><center><?php echo utf8_encode($domicilio); ?></td>
						<td><center><?php echo  $colonia; ?> </td>
						<td><center><?php echo  $entidad; ?></td>
						<td><center><?php echo utf8_encode($localidad); ?></td>
						<td colspan="2"><center><?php echo  $cp; ?></td>
					  </tr>
					</table>  
					
<table align="center" cellpadding="5" cellspacing="1" ><tr><td>&nbsp;</td></tr>	</table>					
					
<table align="center" cellpadding="5" cellspacing="1" >		
	<tr>
		<td style="width:25%;">&nbsp;</td>
		<td style="width:50%;">
			<table align="center" style="border: 1px solid #006699;" cellpadding="5" cellspacing="1" border="1">
				<thead>
					<tr style='background-color:#337ab7; color:white; '>
						<th><center>DEDUCTIVA</center></th>						
						<th><center>CANTIDAD</center></th>
						<th><center>MONTO</center></th>						
						</tr>
						</thead>
			   <?php
				$sql_consulta ="EXEC  [dbo].[sp_Consulta_Deductivas] '$usuario',$servicio,$ayo,$qna";
				$res_consulta = sqlsrv_query($conn,$sql_consulta);
				while($row_consulta = sqlsrv_fetch_array($res_consulta)){
					$deductiva=utf8_encode($row_consulta['DEDUCTIVA']); 
					$cantidad=$row_consulta['CANTIDAD']; 
					$monto=$row_consulta['MONTO']; 
			   ?>
				   <tr>
						<td><center><?php echo utf8_decode($deductiva);?></td>
						<td><center><?php echo $cantidad;?></td>
						<td><center><?php echo $monto;?></td>
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









