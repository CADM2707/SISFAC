<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
	extract($_POST);
	$format="d/m/Y";
	
?>     

<?php 
  //CONSULTAS	---		CONSULTAS	---		CONSULTAS	---		CONSULTAS	---
	$sql_fac="select CVE_TIPO_FACTURA,TIPO_FACTURA from C_Tipo_Factura";       
	$res_fac = sqlsrv_query($conn,$sql_fac); 
			  
	$sql_format="select ID_FORMATO,FORMATO from C_FORMATO";       
	$res_format = sqlsrv_query($conn,$sql_format); 
	
	$sql_per="select PERIODO from C_PERIODO";       
	$res_per = sqlsrv_query($conn,$sql_per); 			
  ?>
                     <form  method="POST" class="centrado" >
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        TABLERO DE CONTROL
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li style="font-size: ">
                            <a href=""><i class="fa fa-home"></i> Inicio</a>
                        </li>
                    </ol>
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center">   
                       <!-- <div id="cont">
                            Hola Soy un toggle
                        </div> -->
                        
                        <div class="row" >
                    <div  class="col-md-5 col-sm-5 col-xs-5"></div>
                    <div  class="col-md-2 col-sm-2 col-xs-2">
				<center><label>	USUARIO:</label></center>
				<input type="text" name="usuario"  value="<?php echo @$usuario;?>" style="text-align:center;"  class="form-control" required >
			</div>
           
                 
            
            <div  class="col-md-12 col-sm-12 col-xs-12"><br>
				<button name="boton"  value="reporte" class="btn btn-primary center-block">BUSCAR</button>
			</div>            
             
             
             <?php 
					
				if(@$_REQUEST["boton"] == "reporte" OR @$tip_fac!="" ){ 
			    $sql_reporte ="select R_SOCIAL,RFC,SECTOR,DESTACAMENTO,convert(date,FECHA_ALTA) FECHA_ALTA, SITUACION from sector.dbo.v_usuario_padron where ID_USUARIO='$usuario'";
				$res_reporte = sqlsrv_query($conn,$sql_reporte);
				 
				 $sql_datos ="select ID_USUARIO_FACTURA,p.CVE_TIPO_FACTURA,t.TIPO_FACTURA,PERIODO_FACTURACION,TURNO_CONTRATO,JERARQUIA,ADICIONALES,CORREO,CUENTA,BANCO,p.CVE_FORMATO,f.FORMATO from Parametros_Facturacion p
inner join C_Tipo_Factura t on p.CVE_TIPO_FACTURA = t.CVE_TIPO_FACTURA
inner join c_formato f on p.CVE_FORMATO = f.ID_FORMATO
WHERE ID_USUARIO ='$usuario'";
				$res_datos = sqlsrv_query($conn,$sql_datos);
				 
				 ?>
				<br><br><br><br><br><br>
	<center>
		<div class="panel-body" style="width:100%">
				<?php $row_reporte = sqlsrv_fetch_array($res_reporte, SQLSRV_FETCH_ASSOC); 
				
				$fecha= date_format($row_reporte['FECHA_ALTA'], $format);
				
				$row_datos = sqlsrv_fetch_array($res_datos, SQLSRV_FETCH_ASSOC);
				
				@$id_fac = $row_datos['ID_USUARIO_FACTURA'];
				@$tipo_fac = $row_datos['TIPO_FACTURA'];
				@$cvfac = $row_datos['CVE_TIPO_FACTURA'];
			    @$format = trim($row_datos['FORMATO']);
				@$cvfor = $row_datos['CVE_FORMATO'];
				@$per = $row_datos['PERIODO_FACTURACION'];
				@$tur = $row_datos['TURNO_CONTRATO'];
				@$jerar = $row_datos['JERARQUIA'];
				@$adi = $row_datos['ADICIONALES'];
				@$correo = $row_datos['CORREO'];
				@$cuenta = $row_datos['CUENTA'];
				@$banco = $row_datos['BANCO'];
				
				
				
				?>
				
                <h2><?php echo $usuario.' '.$row_reporte['R_SOCIAL'].' '; ?></h2>						
				<div  class="col-md-1 col-sm-1 col-xs-1"></div>
				<div  class="col-md-2 col-sm-2 col-xs-2">
					<center><label>	RFC:</label></center>
					<input type="text" name=""  value="<?php echo $row_reporte['RFC'];?>" style="text-align:center;"  class="form-control" disabled >
				</div>
				<div  class="col-md-2 col-sm-2 col-xs-2">
					<center><label>	ALTA:</label></center>
                                        <input type="text" name=""  value="<?php echo $fecha;?>" style="text-align:center;"  class="form-control" disabled >
				</div>
				<div  class="col-md-2 col-sm-2 col-xs-2">
					<center><label>	SITUACION:</label></center>
					<input type="text" name=""  value="<?php echo $row_reporte['SITUACION'];?>" style="text-align:center;"  class="form-control"  disabled>
				</div>
				<div  class="col-md-2 col-sm-2 col-xs-2">
					<center><label>	SECTOR:</label></center>
					<input type="text" name=""  value="<?php echo $row_reporte['SECTOR'];?>" style="text-align:center;"  class="form-control"  disabled>
				</div>
				<div  class="col-md-2 col-sm-2 col-xs-2">
					<center><label>	DESTACAMENTO:</label></center>
					<input type="text" name=""  value="<?php echo $row_reporte['DESTACAMENTO'];?>" style="text-align:center;"  class="form-control"  disabled>
				</div><BR><BR><BR><BR>
                
                
                <div  class="col-md-3 col-sm-3 col-xs-3"><br>
							<center><label>ID USUARIO FACTURA:</label></center>
							<input type="text" name="usu" class="form-control" id="usu" value="<?php echo @$id_fac;?>">
						</div>
                
                
                <div  class="col-md-3 col-sm-3 col-xs-3"><br>
							<center><label>TIPO FACTURA:</label></center>
							<select name="fac" class="form-control" style="text-align:center;"  id="fac"  >
								<option value="" selected="selected">SELECC...</option>
								<?php	
								  
								  while($row_fac = sqlsrv_fetch_array($res_fac)){ 	
								  
								  if(@$cvfac ==  $row_fac['CVE_TIPO_FACTURA']){	?>
									<option value="<?php echo @$row_fac['CVE_TIPO_FACTURA']; ?>" selected ><?php echo @$row_fac['TIPO_FACTURA']; ?></option>
                                    
								<?php } else {?>
                                <option value="<?php echo $row_fac['CVE_TIPO_FACTURA']; ?>" ><?php echo @$row_fac['TIPO_FACTURA']; ?></option>
                                <?php 
								}}
								
									?>
							</select>
						</div>	
                 
                 <div  class="col-md-3 col-sm-3 col-xs-3"><br>
							<center><label>FORMATO:</label></center>
							<select name="format" class="form-control" style="text-align:center;" id="format" >
								<option value="" selected="selected">SELECC...</option>
								<?php	
								
								while($row_format = sqlsrv_fetch_array($res_format)){ 
								if(@$cvfor == @$row_format['ID_FORMATO']){
								?>
                                <option value="<?php echo @$row_format['ID_FORMATO']; ?>" selected><?php echo @$row_format['FORMATO']; ?></option>
									
								<?php } else {
									
									 		?>
									<option value="<?php echo @$row_format['ID_FORMATO']; ?>" ><?php echo @$row_format['FORMATO']; ?></option>
								<?php }
								}
									
									 ?>
							</select>
						</div>	  
                        
                        
                        <div  class="col-md-3 col-sm-3 col-xs-3"><br>
							<center><label>PERIODO DE FACTURACION:</label></center>
							<select name="per" class="form-control" style="text-align:center;"  id="per" >
								<option value="" selected="selected">SELECC...</option>
								<?php	while($row_per = sqlsrv_fetch_array($res_per)){ 
								
								if(@$per == @$row_per['PERIODO']){
										?>
									<option value="<?php echo @$row_per['PERIODO']; ?>" selected><?php echo @$row_per['PERIODO']; ?></option>
								<?php } else {?>
                                <option value="<?php echo @$row_per['PERIODO']; ?>" ><?php echo @$row_per['PERIODO']; ?></option>
                                <?php }
								} ?>
							</select>
						</div>
                        
                        
                        <div  class="col-md-3 col-sm-3 col-xs-3"><br>
							<center><label>TURNOS CONTRATO:</label></center>
							<select name="tur" class="form-control" style="text-align:center;" id="tur" >
								<option value="" selected="selected">SELECC...</option>
                                <?php if(@$tur == "SI"){?>
							    <option value="SI" selected>SI</option>
                                <option value="NO" >NO</option>
                                <?php } if(@$tur == "NO"){?>
                                <option value="SI" >SI</option>
                                <option value="NO" selected>NO</option>
                                <?php } if(@$tur == ""){?>
                                <option value="SI" >SI</option>
                                <option value="NO" >NO</option>
                                <?php } ?>
							</select>
						</div>	
                        
                        <div  class="col-md-3 col-sm-3 col-xs-3"><br>
							<center><label>PAGA JERARQUIA:</label></center>
							<select name="jerar" class="form-control" style="text-align:center;" id="jerar" >
								<option value="" selected="selected">SELECC...</option>
							    <?php if(@$jerar == "SI"){?>
                                <option value="SI" selected>SI</option>
                                <option value="NO" >NO</option>
                                <?php } if(@$jerar == "NO"){?>
                                <option value="SI" >SI</option>
                                <option value="NO" selected>NO</option>
                                <?php } if(@$jerar == ""){?>
                                <option value="SI" >SI</option>
                                <option value="NO" >NO</option>
                                <?php } ?>
							</select>
						</div>	
                        
                        <div  class="col-md-3 col-sm-3 col-xs-3"><br>
							<center><label>PAGA ADICIONALES:</label></center>
							<select name="adi" class="form-control" style="text-align:center;" id="adi" >
								<option value="" selected="selected">SELECC...</option>
							    <?php if(@$adi == "SI"){?>
                                <option value="SI" selected>SI</option>
                                <option value="NO" >NO</option>
                                <?php } if(@$adi == "NO"){?>
                                <option value="SI" >SI</option>
                                <option value="NO" selected>NO</option>
                                <?php } if(@$adi == ""){?>
                                <option value="SI" >SI</option>
                                <option value="NO" >NO</option>
                                <?php } ?>
							</select>
						</div>	       
                        
                        <div  class="col-md-3 col-sm-3 col-xs-3"><br>
							<center><label>CORREO ELECTRONICO:</label></center>
							<input type="text" name="correo" class="form-control" id="correo" value="<?php echo @$correo;?>">
						</div>
                        
                        <div  class="col-md-3 col-sm-3 col-xs-3"><br>
							<center><label>CUENTA:</label></center>
							<input type="text" name="cuenta" class="form-control" id="cuenta" value="<?php echo @$cuenta;?>">
						</div>
                        
                        <div  class="col-md-3 col-sm-3 col-xs-3"><br>
							<center><label>BANCO:</label></center>
							<input type="text" name="banco" class="form-control" id="banco" value="<?php echo @$banco;?>">
						</div>
                        
				<div  class="col-md-12 col-sm-12 col-xs-12"><br>
					<button name="boton" onclick="detalle(<?php echo $usuario; ?>)" class="btn btn-primary center-block">ACTUALIZAR</button>
				</div>
						
                        <div id="tb3" style="display: none;"></div>
                        
				<?php }	?>
				
		
			</div>
		</div>
	</center>
			</div>
	<br><br>
	</div>
             
             
                        </div>
                       
                    </div>                                    
                </div>                
            </section>
            </div>
            </form>
            <?php include_once '../footer.html'; ?>
          
          <script>
function detalle(){
        var url = "<?php echo BASE_URL; ?>includes/FACTURACION/sec_control.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				usu: $('#usu').val(),
				fac: $('#fac').val(),
				format: $('#format').val(),
				per: $('#per').val(),
				tur: $('#tur').val(),
				jerar: $('#jerar').val(),
				adi: $('#adi').val(),
				correo: $('#correo').val(),
				cuenta: $('#cuenta').val(),
				banco: $('#banco').val(),
				id : usuario
            },
            success: function (data)
            {
                $("#tb3").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("tb3").style.display="block";                  
            }
        });
        

//        $('#myModaldestto').modal('show');

    }
            </script>
