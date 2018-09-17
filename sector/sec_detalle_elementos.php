<?php
    include_once '../config.php';
	 @$ayo=$_REQUEST['Anio2'];
	 @$qna=$_REQUEST['Qnas2'];
	 @$usuario=$_REQUEST['Usu2'];
	 @$fatiga=$_REQUEST['Soli2'];
	 @$servicio=$_REQUEST['Servi2']; 
	 $format="d/m/Y";
	 if(@$fatiga==1){
		$sql="exec sp_Consulta_Detalle_Turnos '$usuario',$qna,$ayo,$servicio";
		$titulo="TURNOS NORMALES";
	 }if(@$fatiga==2){
		$sql="exec sp_Consulta_Detalle_Turnos_TD   '$usuario',$qna,$ayo,$servicio";
		$titulo="TURNOS DESCANSO";
	 }if(@$fatiga==3){
		$sql="exec sp_Consulta_Detalle_Turnos_TF  '$usuario',$qna,$ayo,$servicio";
		$titulo="TURNOS FESTIVO";
	 }if(@$fatiga==4){
		$sql="exec sp_Detalle_Turno_Ajuste $ayo,$qna,'$usuario',1,$servicio";
			$titulo="TURNOS AJUSTE MAS ";
	 }if(@$fatiga==5){
		$sql="exec sp_Detalle_Turno_Ajuste $ayo,$qna,'$usuario',2,$servicio";
		$titulo="TURNOS AJUSTE MENOS";
	 }if(@$fatiga==6){
		$sql="exec sp_Detalle_Turno_Ajuste_Ext $ayo,$qna,'$usuario',1,$servicio";
			$titulo="TURNOS AJUSTE EXTEMPORANEO MAS ";
	 }if(@$fatiga==7){
		$sql="exec sp_Detalle_Turno_Ajuste_Ext $ayo,$qna,'$usuario',2,$servicio";
		$titulo="TURNOS AJUSTE EXTEMPORANEO MENOS";
	 }if(@$fatiga==8){
		$sql="exec sp_Detalle_Deductivas $ayo,$qna,'$usuario',$servicio";
		$titulo="DEDUCTIVAS";
	 }if(@$fatiga==9){
		$sql="exec sp_Consulta_Detalle_FTUA '$usuario',$qna,$ayo,$servicio";
		$titulo="TURNOS USUARIO  ";
	 }if(@$fatiga==10){
		$sql="exec sp_Consulta_Detalle_TA '$usuario',$qna,$ayo,$servicio";
		$titulo="TURNOS ADICIONAL CONTRATO ";
	 }if(@$fatiga==11){
		$sql="exec [sp_Consulta_Detalle_F_JERARQUIA] '$usuario',$qna,$ayo,$servicio";
		$titulo="FATIGA JERARQUIA ";
	 }if(@$fatiga==12){
		$sql="exec [sp_Detalle_Turno_Ajuste_Sin_El] '$usuario',$ayo,$qna,$servicio";
		$titulo="TURNOS AJUSTE SIN ELEMENTO ";
	 }
	
		$res = sqlsrv_query( $conn,$sql);
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
			
	
	@$html.="	<div class='modal fade' id='myModalCharts2' role='dialog'>
	<div class='modal-dialog mymodal modal-lg' style=' width: 55% !important'>         
			<div class='modal-content'>
				<div class='modal-header title_left' style='background-color: #2C3E50;'>
					<button type='button' class='close' data-dismiss='modal' style=' background-color: white;'>&nbsp&nbsp;&times;&nbsp&nbsp;</button>
					<h4 class='modal-title' style='color: white;'><img width='2%'  src='../dist/img/pa2.png'><center></center></h4>
				</div>
				<div style='text-align: center'><br>
					<h4 style=' color: #1B4C7C; font-weight: 600'><?php echo @$titulo; ?></h4><hr>
				</div>  
				<div class='col-md-12'>
				<div  class='col-md-12 col-sm-12 col-xs-12'><br></div>
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
						<td><center>$id</td>
						<td><center>$servicio</td>
						<td colspan='2' ><center>".utf8_encode($social)."</center> </td>
						<td><center>$rfc</td>
						<td><center>$sector</td>
						<td><center>$destacamento</td>
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
						<td><center>".utf8_encode(@$domicilio)."</td>
						<td><center>".utf8_encode(@$colonia)." </td>
						<td><center>".utf8_encode(@$entidad)."</td>
						<td><center> ".utf8_encode(@$localidad)."</td>
						<td><center>$cp </td>
						<td><center>$ayo </td>
						<td><center>$qna </td>
					  </tr>
					</table>  
					<div  class='col-md-12 col-sm-12 col-xs-12'><br><center><a href='reportes/ajuste_sin_elementos.php?ayo=$ayo&qna=$qna&usuario=$usuario&fatiga=$fatiga&servicio=$servicio' class='btn btn-warning btn-sm' >Reporte</a><br></div><br><br><br><br>
					<table    class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:10px;'>
					<caption><center><h2>$titulo</h2></center></caption><thead>   
  <tr>";
	if(@$fatiga==6 or @$fatiga==7 OR @$fatiga==4 or @$fatiga==5 or @$fatiga==1 or @$fatiga==2 or @$fatiga==3 ){ 
	@$html.="	<td align='center' class='bg-primary'><b>ID ELEMENTO</td>
		<td align='center' class='bg-primary'><b>NOMBRE</td>
		<td align='center' class='bg-primary'><b>TIPO TURNO</td>
		<td align='center' class='bg-primary'><b>FECHA</td>";
	 } if(@$fatiga==8){ 
	@$html.="<td align='center' class='bg-primary'><b>NUMERO</td>
		<td align='center' class='bg-primary'><b>DEDUCTIVA</td>";
	 } if(@$fatiga==9 or @$fatiga==10 or @$fatiga==11){ 
	@$html.="<td align='center' class='bg-primary'><b>ID ELEMENTO</td>
		<td align='center' class='bg-primary'><b>NOMBRE</td>";
	 }if(@$fatiga==9){ 
	@$html.="<td align='center' class='bg-primary'><b>TURNO PREMIO</td>
		<td align='center' class='bg-primary'><b>FECHA</td>";
	 }if(@$fatiga==10){ 
	@$html.="<td align='center' class='bg-primary'><b>TIPO TURNO</td>
		<td align='center' class='bg-primary'><b>FECHA</td>";
	 }if(@$fatiga==11){ 
	@$html.="<td align='center' class='bg-primary'><b>F. JERARQUIA</td>
		<td align='center' class='bg-primary'><b>TIPO JERARQUIA</td>";
	 }
	if(@$fatiga==12){ 
	@$html.="
		<td align='center' class='bg-primary'><b>OPERADOR</td>
		<td align='center' class='bg-primary'><b>FECHA</td>
		<td align='center' class='bg-primary'><b>CANTIDAD</td>";
	 }	 
@$html.="	 </tr>
 </thead>
  <tbody>";
	while($row = sqlsrv_fetch_array($res)){		
		if(@$fatiga==6 or @$fatiga==7  OR @$fatiga==4 or @$fatiga==5 or @$fatiga==1 or @$fatiga==2 or @$fatiga==3){
			$fecha=date_format($row['FECHA'], $format); 
			$elemento=$row['ID_ELEMENTO'];
			$nombre=$row['NOMBRE'];
			$turno=$row['TIPO_TURNO'];		
		}if(@$fatiga==8){
			$numero=$row['NUM_DEDUCTIVAS'];
			$deductiva=$row['DEDUCTIVA'];
		}if(@$fatiga==9 OR @$fatiga==10 OR @$fatiga==11 ){
			$elemento=$row['ID_ELEMENTO'];
			$nombre=$row['NOMBRE'];
		}if(@$fatiga==9){
			$turno=$row['TurnoPremio'];
			$fecha=date_format($row['FECHA'], $format); 
		}if(@$fatiga==10){
			$turno=$row['TIPO_TURNO'];
			$fecha=date_format($row['FECHA'], $format); 
		}if(@$fatiga==11){
			$f_jera=$row['F_JERARQUIA'];
			$t_jera=$row['TIPO_JERARQUIA'];
		}if(@$fatiga==12){
			$ope=$row['OPERADOR'];
			$fecha=date_format($row['FECHA'], $format); 
			$cantidad=$row['CANTIDAD'];
			
		}
		
		
		
		
		@$html.="<tr>";
		 if(@$fatiga==6 or @$fatiga==7  OR @$fatiga==4 or @$fatiga==5 or @$fatiga==1 or @$fatiga==2 or @$fatiga==3){ 
			@$html.="	 <td> $elemento</td>
			<td>".utf8_encode($nombre)."  </td>
			<td>  $turno   </td>
			<td>  $fecha   </td>";
		 }if(@$fatiga==8){ 
			@$html.="	 <td>  $numero  </td>
			<td>  ".utf8_encode($deductiva)." </td>";
		 }if(@$fatiga==9 OR @$fatiga==10 OR @$fatiga==11 ){
			@$html.="	 <td> $elemento</td>
			<td>".utf8_encode($nombre)."  </td>";	
		 }if(@$fatiga==9){
			@$html.="	 <td> $turno</td>
			<td> $fecha  </td>";
		 }if(@$fatiga==10){
			@$html.="	 <td> $turno</td>
			<td> $fecha  </td>";
		 }if(@$fatiga==11){
			@$html.="	 <td> $f_jera</td>
			<td>$t_jera  </td>";
		}if(@$fatiga==12){
			@$html.="	 
			<td> $ope</td>
			<td> $fecha</td>
			<td> $cantidad</td>";
		}
		
		
		@$html.="</tr>";
	 } 
     
	@$html.="
  </tbody>
</table>	
					
				</div>
			
				<div class='modal-footer'>   <br><br> <br><br> <br><br>
				
				</div>
			</div>      
		</div>
	</div>";
				
				
				
					  
		echo @$html;	
					?>
				
	
          






