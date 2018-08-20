<?php

error_reporting(0);
include_once '../../config.php';
 @$servicio=$_REQUEST['servicio'];
	 @$fatiga=$_REQUEST['fatiga'];
	 @$ayo=$_REQUEST['ayo'];
	 @$usuario=$_REQUEST['usuario'];
	 @$qna=$_REQUEST['qna'];
	 $format="d/m/Y";
	 if(@$fatiga==6){
		$sql="exec sp_Detalle_Turno_Ajuste_Ext $ayo,$qna,'$usuario',1";
			$titulo="TURNOS AJUSTE EXTEMPORANEO MAS ";
	 }if(@$fatiga==7){
		$sql="exec sp_Detalle_Turno_Ajuste_Ext $ayo,$qna,'$usuario',2";
		$titulo="TURNOS AJUSTE EXTEMPORANEO MENOS";
	 }if(@$fatiga==4){
		$sql="exec sp_Detalle_Turno_Ajuste $ayo,$qna,'$usuario',1";
			$titulo="TURNOS AJUSTE MAS ";
	 }if(@$fatiga==5){
		$sql="exec sp_Detalle_Turno_Ajuste $ayo,$qna,'$usuario',2";
		$titulo="TURNOS AJUSTE MENOS";
	 }if(@$fatiga==8){
		$sql="exec sp_Detalle_Deductivas $ayo,$qna,'$usuario'";
		$titulo="DEDUCTIVAS";
	 }if(@$fatiga==1){
		$sql="exec sp_Consulta_Detalle_Turnos '$usuario',$qna,$ayo";
		$titulo="TURNOS NORMALES";
	 }if(@$fatiga==2){
		$sql="exec sp_Consulta_Detalle_Turnos_TD   '$usuario',$qna,$ayo";
		$titulo="TURNOS DESCANSO";
	 }if(@$fatiga==3){
		$sql="exec sp_Consulta_Detalle_Turnos_TF  '$usuario',$qna,$ayo";
		$titulo="TURNOS FESTIVO";
	 }
	
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=$titulo.xls");


		$res = sqlsrv_query( $conn,$sql);
?>      
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center"> 
				<?php $sql_agrega ="EXEC  [dbo].[sp_Consulta_Usuario] '$usuario'";
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
				echo @$html .="
				
				<h3>DATOS DEL USUARIO</h3>
				<table class='table table-hover table-responsive' style='font-size:11px;'>
					<thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>ID USUARIO</center></th>						
						<th><center>SERVICIO</center></th>						
						<th colspan='2'><center>RAZON SOCIAL</center></th>
						<th><center>RFC</center></th>						
						<th><center>SECTOR</center></th>
						<th><center>DEST.</center></th>
					  </tr>
					  </thead>
						<tr>
						<td><center> $id</td>
						<td ><center> $servicio </td>
						<td colspan='2' ><center> $social</center> </td>
						<td><center> $rfc</td>
						<td><center> $sector</td>
						<td><center> $destacamento</td>
					  </tr>
					  <thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>DOMICILIO</center></th>						
						<th><center>COLONIA</center></th>
						<th><center>ENTIDAD</center></th>						
						<th><center>LOCALIDAD</center></th>
						<th><center>C.P.</center></th>
						<th><center>AÑO</center></th>
						<th><center>QNA.</center></th>
					  </tr>
					  </thead>
						<tr>
						<td><center> ".utf8_encode($domicilio)."</td>
						<td><center> $colonia </td>
						<td><center> $entidad</td>
						<td><center> ".utf8_encode($localidad)."</td>
						<td><center> $cp</td>
						<td><center> $ayo</td>
						<td><center> $qna</td>
					  </tr>
					</table>  "; ?>					
					<?php 
						$html = "";
$html.="
<table    class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:10px;'>
<caption><center><h2>$titulo</h2></center></caption>
<thead>   
  <tr>";
	if($fatiga==6 or $fatiga==7 OR $fatiga==4 or $fatiga==5 or $fatiga==1 or $fatiga==2 or $fatiga==3 ){
		$html.=" <td align='center' class='bg-primary'><b>ID ELEMENTO</td>
		<td align='center' class='bg-primary'><b>NOMBRE</td>
		<td align='center' class='bg-primary'><b>TIPO TURNO</td>
		<td align='center' class='bg-primary'><b>FECHA</td>";
	} if($fatiga==8){
		$html.=" <td align='center' class='bg-primary'><b>NUMERO</td>";	
		$html.=" <td align='center' class='bg-primary'><b>DEDUCTIVA</td>";	
	} 
	
 $html.=" </tr>
 </thead>
  <tbody>";
	while($row = sqlsrv_fetch_array($res)){		
		if($fatiga==6 or $fatiga==7  OR $fatiga==4 or $fatiga==5 or $fatiga==1 or $fatiga==2 or $fatiga==3){
			$fecha=date_format($row['FECHA'], $format); 
			$elemento=$row['ID_ELEMENTO'];
			$nombre=$row['NOMBRE'];
			$turno=$row['TIPO_TURNO'];		
		}if($fatiga==8){
			$numero=$row['NUM_DEDUCTIVAS'];
			$deductiva=$row['DEDUCTIVA'];
		}
		$html.="<tr>";
		if($fatiga==6 or $fatiga==7  OR $fatiga==4 or $fatiga==5 or $fatiga==1 or $fatiga==2 or $fatiga==3){
			$html.=" <td> $elemento </td>
			<td>".utf8_encode($nombre)." </td>
			<td> $turno </td>
			<td> $fecha </td>";
		}if($fatiga==8){
			$html.=" <td> $numero </td>";	
			$html.=" <td> $deductiva </td>";	
		}		
		
		$html.="</tr>";
	}
     
	 $html.="
  </tbody>
</table>";
					  
		echo $html;	
					?>