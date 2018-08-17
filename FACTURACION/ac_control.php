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

	$sql_per="select * from C_PERIODO";
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

           
			<?php if(@$usuario == ""){?>	
			 <div  class="col-md-12 col-sm-12 col-xs-12"><br>
				<button name="boton"  value="reporte" class="btn btn-primary center-block">BUSCAR</button>
			</div>
			
			<?php } ?>
			
            <?php if(@$usuario !=""){?>
            <div class="left">
                <a style="margin-button: 15px; width:200px" class="btn btn-warning" href="ac_control.php">Nueva Busqueda</a>
            </div> 

           <?php } ?>
             <?php

				if(@$_REQUEST["boton"] == "reporte" OR @$tip_fac!="" or @$usuario!="" or @$usu!="" ){
			     $sql_reporte ="select R_SOCIAL,RFC,SECTOR,DESTACAMENTO,convert(date,FECHA_ALTA) FECHA_ALTA, SITUACION from sector.dbo.v_usuario_padron where ID_USUARIO='$usuario'";
				$res_reporte = sqlsrv_query($conn,$sql_reporte);

				$sql_datos ="select ID_USUARIO_FACTURA,p.CVE_TIPO_FACTURA,t.TIPO_FACTURA,PERIODO_FACTURACION,TURNO_CONTRATO,JERARQUIA,ADICIONALES,CORREO,CUENTA,BANCO,p.CVE_FORMATO,f.FORMATO from Parametros_Facturacion p
left outer join C_Tipo_Factura t on p.CVE_TIPO_FACTURA = t.CVE_TIPO_FACTURA
left outer join c_formato f on p.CVE_FORMATO = f.ID_FORMATO
WHERE ID_USUARIO ='$usuario'";
				$res_datos = sqlsrv_query($conn,$sql_datos);

				 ?>
				<br><br>
	<center>
		<div class="panel-body" style="width:100%">
				<?php $row_reporte = sqlsrv_fetch_array($res_reporte, SQLSRV_FETCH_ASSOC);

				@$fecha= date_format($row_reporte['FECHA_ALTA'], $format);

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
				@$banco1 = $row_datos['BANCO'];



				?>

                <h2><?php echo $usuario.' '.utf8_encode($row_reporte['R_SOCIAL']).' '; ?></h2>
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
                
                <!--//////////////////////////////////////// Consulta segunda-->
                <?php 
				if(@$usu!="" and @$usu!=@$id_fac){
					$sql_usu ="select R_SOCIAL,RFC,SECTOR,DESTACAMENTO,convert(date,FECHA_ALTA) FECHA_ALTA, SITUACION from sector.dbo.v_usuario_padron 
					where ID_USUARIO='$usu'";				
				}else{
					$sql_usu ="select R_SOCIAL,RFC,SECTOR,DESTACAMENTO,convert(date,FECHA_ALTA) FECHA_ALTA, SITUACION from sector.dbo.v_usuario_padron 
					where ID_USUARIO='$id_fac'";				
				}
								
				$res_usu = sqlsrv_query($conn,$sql_usu); 				
				$row_usu = sqlsrv_fetch_array($res_usu, SQLSRV_FETCH_ASSOC);				
				?>
                
                <div  class="col-md-5 col-sm-5 col-xs-5"></div>
                <div  class="col-md-2 col-sm-2 col-xs-2"><br>
							<center><label>ID USUARIO FACTURA:</label></center>
							<input type="text" name="usu" class="form-control" id="usu"  onChange="this.form.submit()"
                            value="<?php if(@$usu!="" and @$usu!=@$id_fac){ echo @$usu; } else { echo @$id_fac; }?>" >
						</div><br><br>
                <br><br>
                <h2><?php 
					if(@$usu!="" and @$usu!=@$id_fac){ echo $usu.' '.utf8_encode($row_usu['R_SOCIAL']).' '; } else { echo $id_fac.' '.utf8_encode($row_usu['R_SOCIAL']).' '; }
					 ?></h2>
                <div  class="col-md-2 col-sm-2 col-xs-2"></div>
                <div  class="col-md-2 col-sm-2 col-xs-2">
					<center><label>	RFC:</label></center>
					<input type="text" name=""  value="<?php echo $row_usu['RFC'];?>" style="text-align:center;"  class="form-control" disabled >
				</div>
				
				<div  class="col-md-2 col-sm-2 col-xs-2">
					<center><label>	SITUACION:</label></center>
					<input type="text" name=""  value="<?php echo $row_usu['SITUACION'];?>" style="text-align:center;"  class="form-control"  disabled>
				</div>
				<div  class="col-md-2 col-sm-2 col-xs-2">
					<center><label>	SECTOR:</label></center>
					<input type="text" name=""  value="<?php echo $row_usu['SECTOR'];?>" style="text-align:center;"  class="form-control"  disabled>
				</div>
				<div  class="col-md-2 col-sm-2 col-xs-2">
					<center><label>	DESTACAMENTO:</label></center>
					<input type="text" name=""  value="<?php echo $row_usu['DESTACAMENTO'];?>" style="text-align:center;"  class="form-control"  disabled>
				</div><BR><BR><BR><BR>
                
                
                <!-- ////////////// -->
                
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

								if(@$per == @$row_per['ID_PERIODO']){
										?>
									<option value="<?php echo @$row_per['ID_PERIODO']; ?>" selected><?php echo @$row_per['PERIODO']; ?></option>
								<?php } else {?>
                                <option value="<?php echo @$row_per['ID_PERIODO']; ?>" ><?php echo @$row_per['PERIODO']; ?></option>
                                <?php }
								} ?>
							</select>
						</div>


                        <div  class="col-md-3 col-sm-3 col-xs-3"><br>
							<center><label>TURNOS CONTRATO:</label></center>
							<select name="tur" class="form-control" style="text-align:center;" id="tur" >
								<option value="" selected="selected">SELECC...</option>
                                <?php if(@$tur == "1"){?>
							    <option value="1" selected>SI</option>
                                <option value="0" >NO</option>
                                <?php } if(@$tur == "0"){?>
                                <option value="1" >SI</option>
                                <option value="0" selected>NO</option>
                                <?php } if(@$tur == ""){?>
                                <option value="1" >SI</option>
                                <option value="0" >NO</option>
                                <?php } ?>
							</select>
						</div>

                        <div  class="col-md-3 col-sm-3 col-xs-3"><br>
							<center><label>PAGA JERARQUIA:</label></center>
							<select name="jerar" class="form-control" style="text-align:center;" id="jerar" >
								<option value="" selected="selected">SELECC...</option>
							    <?php if(@$jerar == "1"){?>
                                <option value="1" selected>SI</option>
                                <option value="0" >NO</option>
                                <?php } if(@$jerar == "0"){?>
                                <option value="1" >SI</option>
                                <option value="0" selected>NO</option>
                                <?php } if(@$jerar == ""){?>
                                <option value="1" >SI</option>
                                <option value="0" >NO</option>
                                <?php } ?>
							</select>
						</div>

                        <div  class="col-md-3 col-sm-3 col-xs-3"><br>
							<center><label>PAGA ADICIONALES:</label></center>
							<select name="adi" class="form-control" style="text-align:center;" id="adi" >
								<option value="" selected="selected">SELECC...</option>
							    <?php if(@$adi == "1"){?>
                                <option value="1" selected>SI</option>
                                <option value="0" >NO</option>
                                <?php } if(@$adi == "0"){?>
                                <option value="1" >SI</option>
                                <option value="0" selected>NO</option>
                                <?php } if(@$adi == ""){?>
                                <option value="1" >SI</option>
                                <option value="0" >NO</option>
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
							<?php $sql_ban = "select * from C_Banco";
								  $res_ban = sqlsrv_query($conn,$sql_ban);
								
							?>
							<select name="banco" class="form-control" style="text-align:center;"  id="banco" >
								<option value="" selected="selected">SELECC...</option>
								<?php	while($row_ban = sqlsrv_fetch_array($res_ban)){

								if(@$row_datos['BANCO']==@$row_ban['ID_BANCO'] or  @$_REQUEST['banco'] == @$row_ban['BANCO']){
										?>
									<option value="<?php echo @$row_ban['ID_BANCO']; ?>" selected><?php echo @$row_ban['BANCO']; ?></option>
								<?php } else {?>
                                <option value="<?php echo @$row_ban['ID_BANCO']; ?>" ><?php echo @$row_ban['BANCO']; ?></option>
                                <?php }
								} ?>
							</select>
							
						</div>

				<div  class="col-md-12 col-sm-12 col-xs-12"><br>
				    
					<button  type="button" onclick="detalle(<?php echo $usuario; ?>)" class="btn btn-primary center-block">ACTUALIZAR</button>
				</div>

                        <div id="tb3" style="display: none;"></div>

				<?php }	?>

</form>
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
            
            <?php include_once '../footer.html'; ?>

          <script>
		  
function detalle(usuario){
	var usuario = usuario;
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
				usuario : usuario
            },
            success: function (data)
            {
                $("#tb3").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("tb3").style.display="block";
            }
        });

return false;
//        $('#myModaldestto').modal('show');

    }
            </script>
