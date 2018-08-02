<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
	session_start();
	$idOp=$_SESSION['ID_OPERADOR'];	
		
		
		/*				
		@CVE_SITUACION AS TINYINT
		*/
		$sql_situacion="select CVE_SITUACION,SITUACION from facturacion.dbo.Factura_C_Situacion";       
		$res_situacion = sqlsrv_query($conn,$sql_situacion); 
	
	
		@$usuario=$_REQUEST['usuario'];
		@$servicio=$_REQUEST['servicio'];
		@$sql_reporte ="exec facturacion.dbo.sp_Inserta_Leyenda 3,'$usuario',$servicio,'',$ope";
		@$res_reporte = sqlsrv_query($conn,$sql_reporte );
		@$row =sqlsrv_fetch_array(@$res_reporte);
		@$leyenda_sql=trim($row['LEYENDA']);
		@$sql_reporte2 ="select R_SOCIAL from sector.dbo.v_usuario_padron where ID_USUARIO='$usuario'";
		@$res_reporte2 = sqlsrv_query( $conn,$sql_reporte2);
		@$row2 = sqlsrv_fetch_array($res_reporte2);
		@$social_sql=trim($row2['R_SOCIAL']);
		
?>   

<script language="javascript" type="text/javascript">
  function Id_usuario(){
  var accion = document.getElementById("accion").value;
	  if(accion !=""  ){
		document.getElementById("datos_usuario").style.display="block";
	  }
	}

  </script>
  
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        FACTURACION ESPECIAL
                        <small></small>
                    </h1>                    
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center">   
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>ID USUARIO:</label></center>
							<input type="text" name="usuario" onchange="Id_usuario()"  value="<?php echo $usuario;?>" id="usuario" style="text-align:center;"  class="form-control"  >
						</div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>AÑO:</label></center>
							<input type="number" name="ayo"  id="ayo" value="<?php echo @$ayo;?>" style="text-align:center;"   class="form-control" >
						</div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>SUBTOTAL:</label></center>
							<input type="text" name="subtotal" id="subtotal"  value="<?php echo @$subtotal;?>" style="text-align:center;"  class="form-control"  >
						</div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>IVA:</label></center>
							<input type="text" name="iva" id="iva"  value="<?php echo @$iva;?>" style="text-align:center;"  class="form-control"  >
						</div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>FOLIO SAT:</label></center>
							<input type="text" name="folio_sat" id="folio_sat"  value="<?php echo @$folio_sat;?>" style="text-align:center;"  class="form-control"  >
						</div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>TOTAL:</label></center>
							<input type="text" name="total" id="total"  value="<?php echo @$total;?>" style="text-align:center;"  class="form-control"  >
						</div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>TIMBRADO:</label></center>
							<input type="text" name="timbrado" id="timbrado"  value="<?php echo @$timbrado;?>" style="text-align:center;"  class="form-control"  >
						</div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>TOTAL REDONDEADO:</label></center>
							<input type="text" name="total_r" id="total_r"  value="<?php echo @$total_r;?>" style="text-align:center;"  class="form-control"  >
						</div>
						<div  class="col-md-4 col-sm-4 col-xs-4">	
							<center><label>IMPORTE LETRA:</label></center>
							<input type="text" name="importe_letra" id="importe_letra" value="<?php echo @$importe_letra;?>" style="text-align:center;"  class="form-control" >
						</div>
						<div  class="col-md-4 col-sm-4 col-xs-4">	
							<center><label>PERIDO LETRA:</label></center>
							<input type="text" name="periodo_letra" id="periodo_letra" value="<?php echo @$periodo_letra;?>" style="text-align:center;"  class="form-control" >
						</div>
						<div  class="col-md-3 col-sm-3 col-xs-3">	
							<center><label>FECHA EMISION:</label></center>
							<input type="date" name="fecha_e" id="fecha_e" value="<?php echo @$fecha_e;?>" style="text-align:center;"  class="form-control" >
						</div>
						<div  class="col-md-3 col-sm-3 col-xs-3">	
							<center><label>PERIODO INICIO:</label></center>
							<input type="date" name="inicio" id="inicio" value="<?php echo @$inicio;?>" style="text-align:center;"  class="form-control" >
						</div>
						<div  class="col-md-3 col-sm-3 col-xs-3">	
							<center><label>PERIODO FIN:</label></center>
							<input type="date" name="fin" id="fin" value="<?php echo @$fin;?>" style="text-align:center;"  class="form-control" >
						</div>
						<div  class="col-md-2 col-sm-2 col-xs-2">	
							<center><label>SITUACION:</label></center>
							<select name="situacion" class="form-control" style="text-align:center;"  id="situacion" >
								<option value="" selected="selected">SELECC...</option>
								<?php	while($row_situacion = sqlsrv_fetch_array($res_situacion)){  ?>
									<option value="<?php echo $row_situacion['CVE_SITUACION']; ?>" ><?php echo $row_situacion['SITUACION']; ?></option>
								<?php } ?>
							</select> 
						</div>
						<div  class="col-md-12 col-sm-12 col-xs-12"><br>
							<button  type="button" onclick="Reporte()" class="btn btn-primary center-block">GUARDAR FACTURA ESPECIAL</button>
						</div><br><br><br><br><br><br><br><br>
						<div id="consulta_datos"  style="display: none;">	</div> 
						<div id="datos_usuario"  style="display: none;">	</div> 
			
                                                       
                </div>                
            </section>
            </div>
            
            <?php include_once '../footer.html'; ?>
 
          
<script>	
	function Reporte(){
        var url = "<?php echo BASE_URL; ?>includes/sector/agregar_facturacion_especial.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {

				Usuario: $('#usuario').val(),
				Ayo: $('#ayo').val(),
				Subtotal: $('#subtotal').val(),
				Iva: $('#iva').val(),
				Folio_sat: $('#folio_sat').val(),
				Total: $('#total').val(),
				Timbrado: $('#timbrado').val(),
				Total_r: $('#total_r').val(),
				Importe_letra: $('#importe_letra').val(),
				Periodo_letra: $('#periodo_letra').val(),
				Fecha_e: $('#fecha_e').val(),
				Inicio: $('#inicio').val(),
				Fin: $('#fin').val(),
				Situacion: $('#situacion').val()
				
            },
            success: function (data)
            {
                $("#consulta_datos").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("consulta_datos").style.display="block";   
				   
						
            }
        }); 
		var url = "<?php echo BASE_URL; ?>includes/sector/consulta_facturacion_especial.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Usuario: $('#usuario').val()				
            },
            success: function (data)
            {
               $("#datos_usuario").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("datos_usuario").style.display="block";					
            }
        });
    }	
	function Id_usuario(){
        var url = "<?php echo BASE_URL; ?>includes/sector/consulta_facturacion_especial.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Usuario: $('#usuario').val()
            },
            success: function (data)
            {
                $("#consulta_datos").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("consulta_datos").style.display="block";                  
            }
        });
    }	
</script>
   
