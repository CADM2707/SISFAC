<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
    
?>      

  <?php 
  $usuario=$_REQUEST['usuario'];
  $servicio=$_REQUEST['servicio'];
  $sql_deductiva="select CVE_TIPO_DEDUCTIVA,DEDUCTIVA from C_Deductivas";       
  $res_deductiva = sqlsrv_query( $conn,$sql_deductiva);
  
  ?>		
			<input type="hidden" value="<?php echo $usuario; ?>" id="usu"  name="usu" >
			<input type="hidden" value="<?php echo $servicio; ?>" id="servi"  name="servi" >
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>DEDUCTIVAS<small></small></h1>                    
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
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
				<div  class='col-md-12 col-sm-12 col-xs-12'><br></div>
				<h3>DATOS DEL USUARIO</h3>
				<table class='table table-hover table-responsive' style='font-size:11px;'>
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
						<td><center> $id</td>
						<td><center> $servicio </td>
						<td><center> $social </td>
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
					  </tr>
					  </thead>
						<tr>
						<td><center> ".utf8_encode($domicilio)."</td>
						<td><center> $colonia </td>
						<td><center> $entidad</td>
						<td><center> ".utf8_encode($localidad)."</td>
						<td><center> $cp</td>
					  </tr>
					</table>  "; ?>
						<div  class="col-md-3 col-sm-3 col-xs-3"></div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>CANTIDAD :</label></center>
							<input type="text" name="cantidad"   value="<?php echo @$cantidad;?>" id="cantidad" style="text-align:center;"  class="form-control"  >
						</div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>MONTO:</label></center>
							<input type="number" name="monto"  id="monto" value="<?php echo @$monto;?>" style="text-align:center;"   class="form-control" >
						</div>
						<div  class="col-md-2 col-sm-2 col-xs-2">	
							<center><label>DEDUCTIVA:</label></center>
							<select name="deductiva" class="form-control" style="text-align:center;"  id="deductiva" >
								<option value="" selected="selected">SELECC...</option>
								<?php	while($row_deductiva = sqlsrv_fetch_array($res_deductiva)){  ?>
									<option value="<?php echo $row_deductiva['CVE_TIPO_DEDUCTIVA']; ?>" ><?php echo utf8_encode($row_deductiva['DEDUCTIVA']); ?></option>
								<?php } ?>
							</select> 
						</div>
						<div  class="col-md-12 col-sm-12 col-xs-12"><br>			
							<button  type="button" onclick="Deductiva()" class="btn btn-primary center-block">GUARDAR</button>
						</div>
						<div id="mensaje_deductiva"  style="display: none;">	</div> 	
				<?php 
				$sql_consulta ="EXEC  [dbo].[sp_Consulta_Deductivas] '$usuario',$servicio";
				
				/*$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
				$stmt = sqlsrv_query( $conn, $sql_consulta , $params, $options );
				$row_count = sqlsrv_num_rows( $stmt );*/
				//if($row_count>0){
					$res_consulta = sqlsrv_query($conn,$sql_consulta);
				?>
				
				<center><br><br><br><br><br><br><br>
				<table class='table table-hover table-responsive' style='font-size:11px; width:50%;'>
					<thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>DEDUCTIVA</center></th>						
						<th><center>CANTIDAD</center></th>
						<th><center>MONTO</center></th>						
					  </tr>
					  </thead>
					  <?php
						while($row_consulta = sqlsrv_fetch_array($res_consulta)){
							$deductiva=utf8_encode($row_consulta['DEDUCTIVA']); 
							$cantidad=$row_consulta['CANTIDAD']; 
							$monto=$row_consulta['MONTO']; 							
					  ?>
					  <tr>
						<td><center> <?php echo $deductiva; ?> </td>
						<td><center> <?php echo $cantidad; ?> </td>
						<td><center> <?php echo $monto; ?></td>
					  </tr>
					  <?php } ?>
					</table>  
					</center>
					<?php //}else{ ?><br><br><br><br><br><br>
						<!--<h2>NO EXISTEN REGISTROS DE DEDUCTIVAS CAPTURADAS</h2>-->
					<?php //} ?>
                    </div>                                    
                </div>                
            </section>
            </div>
            
            <?php include_once '../footer.html'; ?>
         
<script>
function Deductiva(){
        var url = "<?php echo BASE_URL; ?>includes/sector/captura_deductiva.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Usuario: $('#usu').val(),
				Servicio: $('#servi').val(),
				Deductiva: $('#deductiva').val(),
				Monto: $('#monto').val(),
				Cantidad: $('#cantidad').val()
            },
            success: function (data)
            {
                $("#mensaje_deductiva").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("mensaje_deductiva").style.display="block";                  
            }
        });
    }		
	
	
</script>


