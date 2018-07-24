<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
	extract($_POST);
	$format="d/m/Y";
	
?>                        
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        TABLERO DE CONTROL
                        <small>Panel de control</small>
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
                        <form  method="POST" class="centrado" >
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
					if(@$tip_fac==1){ $var1='selected'; }
					if(@$tip_fac==2){ $var2='selected'; }
					if(@$informe==1){ $var11='selected'; }
					if(@$informe==2){ $var22='selected'; }
					if(@$informe==3){ $var33='selected'; }
					if(@$informe==4){ $var44='selected'; }
					if(@$periodo==1){ $var111='selected'; }
					if(@$periodo==2){ $var222='selected'; }
					if(@$jera==1){ $var1111='selected'; }
					if(@$jera==2){ $var2222='selected'; }
					if(@$adi==1){ $var11111='selected'; }
					if(@$adi==2){ $var22222='selected'; }
					if(@$cont==1){ $var91='selected'; }
					if(@$cont==2){ $vra92='selected'; }
				if(@$_REQUEST["boton"] == "reporte" OR @$tip_fac!="" ){ 
			    $sql_reporte ="select R_SOCIAL,RFC,SECTOR,DESTACAMENTO,convert(date,FECHA_ALTA) FECHA_ALTA, SITUACION from sector.dbo.v_usuario_padron where ID_USUARIO='$usuario'";
				$res_reporte = sqlsrv_query($conn,$sql_reporte);
				//$res_reporte;
				//$count_reporte = sqlsrv_fetch_array($res_reporte, SQLSRV_FETCH_ASSOC);	
				//echo $count_reporte;
				//if($count_reporte>0){ ?>
				<br><br><br><br><br><br>
	<center>
		<div class="panel-body" style="width:100%">
				<?php 					$row_reporte = sqlsrv_fetch_array($res_reporte, SQLSRV_FETCH_ASSOC); 
				
//				echo date($format, strtotime($row_reporte['FECHA_ALTA']));
//                                $date=new DateTime();
//                               echo $date=$row_reporte['FECHA_ALTA'];
//				echo date($format, new DateTime());
//                                echo date_create('d-m-Y',$row_reporte['FECHA_ALTA']);
                                 $fecha=date_format($row_reporte['FECHA_ALTA'], $format);                                
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
				<div  class="col-md-3 col-sm-3 col-xs-3">
					<center><label>	ID USUARIO FACTURA:</label></center>
					<input type="text" name="fac"  value="<?php echo @$fac;?>" style="text-align:center;"  class="form-control"  >
				</div>
				<div  class="col-md-3 col-sm-3 col-xs-3">
					<center><label>	TIPO DE FACTURA:</label></center>
					<select class="form-control" name="tip_fac"  onChange="this.form.submit()"   required="required">
						<option value=""  >SELECCIONA...</option>		
						<option value="1"  <?php echo $var1; ?> >FACTURA</option>		
						<option value="2"  <?php echo $var2; ?> >INFORME</option>		
					</select> 
				</div>
				<?php if($tip_fac==2){?>
				<div  class="col-md-3 col-sm-3 col-xs-3">
					<center><label>INFORME:</label></center>
					<select class="form-control" name="informe"     required="required">
						<option value=""  >SELECCIONA...</option>		
						<option value="1"  <?php echo $var11; ?> >FORMATO 1</option>		
						<option value="2"  <?php echo $var22; ?> >FORMATO 2</option>		
						<option value="3"  <?php echo $var33; ?> >FORMATO 3</option>		
						<option value="4"  <?php echo $var44; ?> >FORMATO 4</option>		
					</select> 
				</div>	
				<?php } ?>
				<div  class="col-md-3 col-sm-3 col-xs-3">
					<center><label>	PERIODO DE FACTURACION:</label></center>
					<select class="form-control" name="periodo"    required="required">
						<option value=""  >SELECCIONA...</option>		
						<option value="1"  <?php echo $var111; ?> >15 DIAS</option>		
						<option value="2"  <?php echo $var222; ?> >30 DIAS</option>		
					</select> 
				</div>
				<div  class="col-md-3 col-sm-3 col-xs-3">
					<center><label>	TURNOS CONTRATO:</label></center>
					<select class="form-control" name="cont"     required="required">
						<option value=""  >SELECCIONA...</option>		
						<option value="1"  <?php echo $var91; ?> >SI</option>		
						<option value="2"  <?php echo $var92; ?> >NO</option>			
					</select> 
				</div>
				<div  class="col-md-3 col-sm-3 col-xs-3">
					<center><label>	PAGA JERARQUIA:</label></center>
					<select class="form-control" name="jera"    required="required">
						<option value=""  >SELECCIONA...</option>		
						<option value="1"  <?php echo $var1111; ?> >SI</option>		
						<option value="2"  <?php echo $var2222; ?> >NO</option>		
					</select> 
				</div>
				<div  class="col-md-3 col-sm-3 col-xs-3">
					<center><label>	PAGA ADICIONALES:</label></center>
					<select class="form-control" name="adi"    required="required">
						<option value=""  >SELECCIONA...</option>		
						<option value="1"  <?php echo $var11111; ?> >SI</option>		
						<option value="2"  <?php echo $var22222; ?> >NO</option>		
					</select> 
				</div>
				<div  class="col-md-3 col-sm-3 col-xs-3">
					<center><label>	CORREO ELECTRONICO:</label></center>
					<input type="text" name="correo"  value="<?php echo $correo;?>" style="text-align:center;"  class="form-control"  >
				</div>
				<div  class="col-md-3 col-sm-3 col-xs-3">
					<center><label>	CUENTA:</label></center>
					<input type="text" name="cuenta"  value="<?php echo $cuenta; ?>" style="text-align:center;"  class="form-control"  >
				</div>
				<div  class="col-md-3 col-sm-3 col-xs-3">
					<center><label>	BANCO:</label></center>
					<input type="text" name="banco"  value="<?php echo $banco; ?>" style="text-align:center;"  class="form-control"  >
				</div>
				<div  class="col-md-12 col-sm-12 col-xs-12"><br>
					<button name="boton"  value="reporte2" class="btn btn-primary center-block">GUARDAR</button>
				</div>
						
				<?php }	?>
				
		
			</div>
		</div>
	</center>
	<?php // } ?>
		<?php if(@$_REQUEST["boton"] == "reporte2" ){ ?><BR>
					<div class="alert alert-success">
					  <strong>EXITO!</strong> DATOS GUARDADOS
					</div>
				<?php } ?>
			</div>
	
		
	
	
	
	<br><br>
	</div>
             
             
                        </div>
                       
                    </div>                                    
                </div>                
            </section>
            </div>
            </form>
            <?php include_once 'footer.html'; ?>
            <script>
//                Funcion con ajax sinn formulario
//                function buttonGraf(sec) {
//                    
//                    var url = "<?php echo BASE_URL; ?>includes/facturacionEmitida/responseGrafFacEm.php";
//
//                    $.ajax({
//                        type: "POST",
//                        url: url,
//                        data: {
//                            UnoCal1: $('#UnoCal1').val(),                            
//                            Sector: sec
//                        },
//                        success: function (data)
//                        {
//                            $("#tb2").html(data); // Mostrar la respuestas del script PHP.
//                            document.getElementById("tb2").style.display="block";                               
//                        }
//                    });
//                    document.getElementById("Sec").value = sec;                              
//                    return false;
//                }
//*****************************************************************************************************************************

//        AJAX CON FORMULARIO
//    $('#formTb1').submit(function () {
//        var url = "<?php echo BASE_URL; ?>includes/facturacionEmitida/responseFactEm.php";
//        $.ajax({
//            type: "POST",
//            url: url,
//            data: $("#formTb1").serialize(), // Adjuntar los campos del formulario enviado.
//            success: function (data)
//            {
//                $("#tb1").html(data); // Mostrar la respuestas del script PHP.    
//                document.getElementById('tb2').style.display = "none";                                                             
//            }
//        });
//
//        return false;
//    });
            </script>



