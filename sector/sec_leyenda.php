<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
		
		@$usuario=$_REQUEST['Usu'];
		@$servicio=$_REQUEST['Ser'];
		@$anio=$_REQUEST['Anio'];
		@$qnas=$_REQUEST['Qnas'];
		@$sql_reporte ="exec sp_Consulta_Leyenda  '$usuario',$servicio";
		@$res_reporte = sqlsrv_query($conn,$sql_reporte );
		@$row =sqlsrv_fetch_array(@$res_reporte);
		@$leyenda_sql=trim($row['LEYENDA']);

    
?>      
				<input type="hidden" value="<?php echo $usuario; ?>" id="usu"  name="usu" >
				<input type="hidden" value="<?php echo $servicio; ?>" id="servi"  name="servi" >
				<?php if($leyenda_sql==""){ ?>
						<input type="hidden" value="1" id="accion"  name="accion" >
				<?php }if($leyenda_sql!=""){ ?>
					<input type="hidden" value="2" id="accion"  name="accion" >
				<?php } ?>
	   
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
	 <div class='modal fade' id='myModalCharts3' role='dialog'>
	<div class='modal-dialog mymodal modal-lg' style=' width: 55% !important'>         
			<div class='modal-content'>
				<div class='modal-header title_left' style='background-color: #2C3E50;'>
					<button type='button' class='close' data-dismiss='modal' style=' background-color: white;'>&nbsp&nbsp;&times;&nbsp&nbsp;</button>
					<h4 class='modal-title' style='color: white;'><img width='2%'  src='../dist/img/pa2.png'><center></center></h4>
				</div>
				<div style='text-align: center'><br>
					<h4 style=' color: #1B4C7C; font-weight: 600'>LEYENDA</h4><hr>
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
						<td><center>$colonia </td>
						<td><center>$entidad</td>
						<td><center> ".utf8_encode(@$localidad)."</td>
						<td><center>$cp </td>
						<td><center>$anio </td>
						<td><center>$qnas </td>
					  </tr>
					</table>  
					<div  class='col-md-3 col-sm-3 col-xs-3'>	</div>
					<div  class='col-md-6 col-sm-6 col-xs-6'>	
						<center><label>LEYENDA:</label></center>
						<textarea class='form-control' rows='5' id='leyenda' name='leyenda' >$leyenda_sql</textarea>
					</div>	
					<div  class='col-md-12 col-sm-12 col-xs-12'><br>			
						<button  type='button' onclick='Leyenda()' class='btn btn-primary center-block'>GUARDAR</button>
					</div>
						<div id='consulta_datos' style='display: none;'></div>
					</div>
					<div class='modal-footer'>   <br><br> <br><br> <br><br>
									
									</div>
								</div>      
							</div>
						</div>					"; ?>
				
<script>

	
</script>	


