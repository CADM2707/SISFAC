<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
		$ope=0;
		@$usuario=$_REQUEST['usuario'];
		@$servicio=$_REQUEST['servicio'];
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
			
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        LEYENDA  <a href="sec_solicitud.php" class='btn btn-warning pull-right'><i class="fa fa-undo" aria-hidden="true"></i> Regresar</a>
                        <small></small>
                    </h1>                    
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
				
			<div  class="col-md-3 col-sm-3 col-xs-3">	</div>
			<div  class="col-md-6 col-sm-6 col-xs-6">	
				<center><label>LEYENDA:</label></center>
				<textarea class="form-control" rows="5" id="leyenda" name="leyenda" ><?php echo $leyenda_sql; ?></textarea>
			</div>	
			<div  class="col-md-12 col-sm-12 col-xs-12"><br>			
				<button  type="button" onclick="Leyenda()" class="btn btn-primary center-block">GUARDAR</button>
			</div>					
			<div id="consulta_datos"  style="display: none;">	</div> 	
			
			  
			
                    </div>                                    
                </div>                
            </section>
            </div>
            
            <?php include_once '../footer.html'; ?>
          
<script>
function Leyenda(){
        var url = "<?php echo BASE_URL; ?>includes/sector/captura_leyenda.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Usuario: $('#usu').val(),
				Servicio: $('#servi').val(),
				Accion: $('#accion').val(),
				Leyenda: $('#leyenda').val()
            },
            success: function (data)
            {
                $("#consulta_datos").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("consulta_datos").style.display="block";                  
            }
        });
    }		
	
	
</script>	


