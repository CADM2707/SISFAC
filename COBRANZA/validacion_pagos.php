<?php
include_once '../config.php';
include_once '../head.html';
include_once '../menuLat.php';

@$ayo = $_REQUEST['ayo'];
@$sector = $_REQUEST['sector'];
@$del = $_REQUEST['del'];
@$al = $_REQUEST['al'];
@$que_tipo = $_REQUEST['tipoi'];
@$idusuario = trim($_REQUEST['idusuario']);
@$referenciai = trim($_REQUEST['referenciai']);

$f_del = date("Y/m/d", strtotime($del));
$f_al = date("Y/m/d", strtotime($al));

if(@$_REQUEST["sube"] == "IDENTIFICAR PAGO"){
	foreach($_POST as $clave=>$valor){
		if($clave != "enviar" AND $clave != "sube" AND $clave == "identificar"){
		   //echo "El valor de $clave es: $valor"."<br>";
		   $datos_update = explode("***", $valor);
		   $idpago_update = $datos_update[0];
		   $idreg_update = $datos_update[1];
		   $iduser_update = $datos_update[2];
		   $ayo_update = $datos_update[3];
		   
		   @$sql_pago = "UPDATE [Facturacion].[dbo].pago SET CVE_PAGO_SIT = 2, ID_USUARIO = '$iduser_update' WHERE ID_PAGO = $idpago_update AND AYO_PAGO = $ayo_update";
		   $res_pago = sqlsrv_query($conn,$sql_pago);
		   
		   @$sql_solicitud = "UPDATE [Facturacion].[dbo].Pago_Solicitud SET CVE_SITUACION = 2 WHERE ID_REGISTRO = $idreg_update AND ID_USUARIO = '$iduser_update'";
		   $res_solicitud = sqlsrv_query($conn,$sql_solicitud);
		   
		   @$si_pago = sqlsrv_rows_affected($res_pago);
		   @$si_soli = sqlsrv_rows_affected($res_solicitud);
		}
	}
}

if($sector != ""){ @$q_sector = " AND SECTOR=$sector "; } else { @$q_sector = ""; }
if($ayo != ""){ @$q_ayo = " AND AYO_PAGO=$ayo "; } else { @$q_ayo = ""; }
if($del != "" and $al != ""){  @$q_fecha = " AND (PG.FECHA_PAGO between '$f_del' and '$f_al') "; } else { @$q_fecha = ""; }
if(@$idusuario != ""){ $q_usuario = " AND UP.ID_USUARIO = '$idusuario' "; } else{ $q_usuario = ""; }
if(@$referenciai != ""){ $q_referencia = " AND PG.REFERENCIA like '%$referenciai%' "; } else{ $q_referencia = ""; }


/*if(@$que_tipo == 0){ $q_tipo = " where PS.CVE_SITUACION = 2 and (PG.ID_USUARIO is NULL OR PG.ID_USUARIO = '') "; } 
if(@$que_tipo == 1){ $q_tipo = " where PS.CVE_SITUACION = 2 and (PG.ID_USUARIO is NULL OR PG.ID_USUARIO = '') "; } */
if(@$que_tipo == 0){ $q_tipo = " where PS.CVE_SITUACION = 2 "; } 
if(@$que_tipo == 1){ $q_tipo = " where PS.CVE_SITUACION = 2 "; } 
if(@$que_tipo == 2){ $q_tipo = " where PG.CVE_PAGO_SIT IN (3,5) and PS.CVE_SITUACION = 3 and (PG.ID_USUARIO is NOT NULL AND PG.ID_USUARIO <> '') "; }

 $sql_lista="SELECT 
PG.AYO_PAGO,PG.CVE_PAGO_TIPO as CVE_PAGO_TIPO_PAGO,PG.MONTO as MONTO_PAGO,Cast(PG.FECHA_PAGO As Date) as FECHA_PAGO,PG.REFERENCIA as REFERENCIA_PAGO,PG.ID_BANCO as ID_BANCO_PAGO,PG.SUCURSAL as SUCURSAL_PAGO,PG.ID_PAGO,PG.CVE_PAGO_SIT,
Cast(PS.FECHA_PAGO As Date) as FECHA_PAGO_SOLICITUD,PS.MONTO as MONTO_SOLICITUD,PS.REFERENCIA as REFERENCIA_SOLICITUD,PS.CUENTA as ID_BANCO_SOLICITUD,PS.ID_REGISTRO,PS.CVE_SITUACION,
UP.ID_USUARIO,UP.R_SOCIAL,UP.SECTOR,UP.DESTACAMENTO, ID_REGISTRO
FROM [Facturacion].[dbo].[Pago] PG
left outer join [Facturacion].[dbo].[Pago_Solicitud] PS on PS.MONTO = PG.MONTO AND PS.REFERENCIA = PG.REFERENCIA AND Cast(PS.FECHA_PAGO As Date) = Cast(PG.FECHA_PAGO As Date)
inner join [Facturacion].[dbo].V_usuario_padron UP on UP.ID_USUARIO = PS.ID_USUARIO AND UP.CVE_SITUACION = 1
$q_tipo
$q_sector $q_ayo $q_fecha $q_usuario $q_referencia
GROUP BY 
PG.AYO_PAGO,PG.CVE_PAGO_TIPO,PG.MONTO,Cast(PG.FECHA_PAGO As Date),PG.REFERENCIA,PG.ID_BANCO,PG.SUCURSAL,PG.ID_PAGO,PG.CVE_PAGO_SIT,
Cast(PS.FECHA_PAGO As Date),PS.MONTO,PS.REFERENCIA,PS.CUENTA,PS.ID_REGISTRO,PS.CVE_SITUACION,
UP.ID_USUARIO,UP.R_SOCIAL,UP.SECTOR,UP.DESTACAMENTO
ORDER BY SECTOR, DESTACAMENTO, R_SOCIAL";
$res_lista = sqlsrv_query($conn,$sql_lista);
$cuantos_son = sqlsrv_has_rows($res_lista);

$sql_ayo="select DISTINCT(ayo)  from SECTOR.DBO.C_PERIODO_QNAS ORDER BY AYO DESC";
$res_ayo = sqlsrv_query($conn,$sql_ayo);

$sql_qna="select DISTINCT(Qna)  from SECTOR.DBO.C_PERIODO_QNAS";
$res_qna = sqlsrv_query($conn,$sql_qna);

$sql_sector="select SECTOR from sector.dbo.C_Sector where SECTOR>50 GROUP BY SECTOR ORDER BY SECTOR";
$res_sector = sqlsrv_query($conn,$sql_sector);

$datetime1 = new DateTime("now");
?>
<style>
tbody>tr:hover {
     background-color: transparent !important;
}
</style>
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper" style=" background-color: white;">
		<!--Titulos de encabezado de la pagina-->
		<section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
			<h1>
				VALIDAR PAGOS
			</h1>
			<br>
		</section>
		<!-- FIN DE Titulos de encabezado de la pagina-->

		<section class="content" >
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-lg-12 col-xs-12 text-center">
				<!-- ------------------------ area de trabajo ------------------------ -->

               <form action="" method="post" name="subir" id="subir">
				<table align="center" border="0" width="88%">
					<tr>
					  <td align="center" width="7%">
					      <center><label>SECTOR</label></center>
						  <select name="sector" class="form-control" id="sector">
								<option value="" selected="selected">SELECC...</option>
								<?php	while($row_sector = sqlsrv_fetch_array($res_sector)){
								        if($row_sector['SECTOR'] == $_REQUEST['sector']){
								?>
									     <option value="<?php echo @$row_sector['SECTOR']; ?>" selected="selected"><?php echo @$row_sector['SECTOR']; ?></option>
								<?php
								      }
                                      else{
							    ?>
								         <option value="<?php echo @$row_sector['SECTOR']; ?>"><?php echo @$row_sector['SECTOR']; ?></option>
						        <?php } } ?>
						   </select>
					  </td>
					  <td width="5%">&nbsp;</td>
					  <td align="center" width="7%">
					        <center><label>AÑO</label></center>
							<select name="ayo" class="form-control" style="text-align:center;"  onchange="es_vacio()"   id="ayo"  onBlur="es_vacio()" >
								<option value="">SELECC...</option>
								<?php
								while($row_ayo = sqlsrv_fetch_array($res_ayo)){
                                      if($row_ayo['ayo'] == $_REQUEST['ayo']){
								?>
									     <option value="<?php echo @$row_ayo['ayo']; ?>" selected="selected"><?php echo @$row_ayo['ayo']; ?></option>
								<?php
								      }
                                      else{
							    ?>
								         <option value="<?php echo @$row_ayo['ayo']; ?>"><?php echo @$row_ayo['ayo']; ?></option>
						        <?php } } ?>
							</select>
					  </td>
					  <td width="5%">&nbsp;</td>
					  <td align="center" width="7%">
								<center><label>DEL</label></center>
								<input type="date" name="del"  value="<?php echo $del;?>" id="del"  style="text-align:center;" onchange="es_vacio3()" class="form-control" >
					  </td>
					  <td width="5%">&nbsp;</td>
					  <td align="center" width="7%">
								<center><label>AL</label></center>
								<input type="date" name="al"  value="<?php echo $al;?>" id="al" style="text-align:center;" onchange="es_vacio4()"  class="form-control" >
					  </td>
					  <td width="5%">&nbsp;</td>
					  <td align="center" width="11%">
								<center><label>ID USUARIO</label></center>
								<input type="text" name="idusuario"  value="<?php echo @$idusuario;?>" id="idusuario" class="form-control" style="text-align:center;">
					  </td>
					  <td width="5%">&nbsp;</td>
					  <td align="center" width="11%">
								<center><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REFERENCIA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></center>
								<input type="text" name="referenciai"  value="<?php echo @$referenciai;?>" id="referenciai" class="form-control" style="text-align:center;" />
					  </td>
					  <td width="5%">&nbsp;</td>
					  <td align="center" width="11%">
					        <center><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TIPO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></center>
							<select name="tipoi" class="form-control" style="text-align:center;"  id="tipoi" />
								<option value="0">SELECC...</option>
								<?php 
								      if(@$_REQUEST['tipoi'] == 1){ @$t1 = "selected='selected'";  @$t2 = ""; } 
								      if(@$_REQUEST['tipoi'] == 2){ @$t2 = "selected='selected'";  @$t1 = ""; }
								?>
									 <option value="1" <?php echo @$t1; ?>>VALIDAR</option>
									 <option value="2" <?php echo @$t2; ?>>VALIDADOS</option>
							</select>
					  </td>
                    </tr>
					<tr>
					  <td colspan="13"><br>
						  <input name="enviar" id="enviar" type="submit" value="Buscar" class="btn btn-primary" />
					  </td>
					</tr>
				 </table>
				</form>
                
				<?php if(@$_REQUEST["sube"] == "IDENTIFICAR PAGO"){ ?>
				<?php if(@$si_pago == 1 AND @$si_soli == 1){ ?>
				         <br>
				         <div class="alert alert-success"> <strong>EL PAGO SE IDENTIFICÓ CORRECTAMENTE</strong> </div>
				<?php } else{ ?>
				         <br>
				         <div class="alert alert-danger"> <strong>OCURRIO UN PROBLEMA AL IDENTIFICAR EL PAGO</strong> </div>
				<?php } ?>
				<?php } ?>
				
				<?php if(@$_REQUEST["enviar"] == "Buscar"){ ?>
				<?php if($cuantos_son === true){ ?>
				<br>
				<div id="tb8" ></div> 
			    <div id="tb9" ></div> 
				<br>
				<div id="tb10">
				<table id ="tabla1" class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:12px;'>
					<thead>
					  <tr>
					    <td align="center" class="bg-primary"><b>#</b></td>
					    <td align="center" class="bg-primary"><b>AÑO PAGO</b></td>
						<td align="center" class="bg-primary"><b>MONTO PAGO</b></td>
						<td align="center" class="bg-primary"><b>FECHA PAGO</b></td>
						<td align="center" class="bg-primary"><b>REFERENCIA PAGO</b></td>
						<td align="center" color="#3f436c"><b>MONTO PAGO SOLICITUD</b></td>
						<td align="center" color="#3f436c"><b>FECHA PAGO SOLICITUD</b></td>
						<td align="center" color="#3f436c"><b>REFERENCIA PAGO SOLICITUD</b></td>
						<td align="center" color="#3f436c"><b>MONTO APLICADO</b></td>
						<td align="center" color="#3f436c"><b>MONTO POR APLICAR</b></td>
						<td align="center" class="bg-primary"><b>USUARIO</b></td>
						<td align="center" class="bg-primary"><b>RAZÓN SOCIAL</b></td>
						<td align="center" class="bg-primary"><b>SECTOR</b></td>
						<td align="center" class="bg-primary"><b>DEST</b></td>
						<td align="center" class="bg-primary"><b></b></td>
					  </tr>
					</thead>
					  <tbody>				
				<?php
					$i=1;
					$tim = 1;
					while($row_lista = sqlsrv_fetch_array($res_lista)){
						  $monto_pago = $row_lista['MONTO_PAGO'];
						  $id_registro = $row_lista['ID_REGISTRO'];
						  
						  $sql_psd = "select isnull(sum(MONTO),0) MONTO_PSD from Pago_Solicitud_Detalle where ID_REGISTRO = $id_registro";
						  $res_psd = sqlsrv_query($conn,$sql_psd);
						  $row_psd = sqlsrv_fetch_array($res_psd);
						  $monto_aplicado = $row_psd['MONTO_PSD'];
						   
						  $por_aplicar = $monto_pago-$monto_aplicado;
						
						
						  if($i%2==0){ $color="#E1EEF4"; } else{ $color="#FFFFFF"; }
						  $nombre_input = $row_lista['ID_PAGO']."***".$row_lista['ID_REGISTRO']."***".$row_lista['ID_USUARIO']."***".$row_lista['AYO_PAGO'];
						  
						  $id_usu=$row_lista['ID_USUARIO'];
						  
						  $cadena = $row_lista['REFERENCIA_PAGO'];
						  $buscar_cheque1 = "CHEQ";
						  $buscar_cheque2 = "DEP S B COBRO";
						  $resultado_cheque1 = strpos($cadena, $buscar_cheque1);
						  $resultado_cheque2 = strpos($cadena, $buscar_cheque2);
						  
						  if($resultado_cheque1 !== FALSE OR $resultado_cheque2 !== FALSE OR $row_lista['CVE_PAGO_TIPO_PAGO'] == 7){ 
							 $datetime2 = $row_lista['FECHA_PAGO'];
							 $interval = date_diff($datetime2, $datetime1);
						     
							  if($interval->format('%R%a') > 3){ $cve_pago_tipo = 1;  }
							  else if($interval->format('%R%a') <= 3){ $cve_pago_tipo = 2; }
						  }
						  else{ $cve_pago_tipo = 3; }
				?>
						<tr bgcolor="<?php echo $color; ?>">
						    <td><?php echo $i; ?></td>
							<td><?php echo $row_lista['AYO_PAGO']; ?></td>
							<td><?php echo "$".number_format($monto_pago,2); ?></td>
							<td><?php echo date_format($row_lista['FECHA_PAGO'], 'd/m/Y');  ?></td>
							<td><?php echo $row_lista['REFERENCIA_PAGO']; ?></td>
							<td><?php echo number_format($row_lista['MONTO_SOLICITUD'],2); ?></td>
							<td><?php echo date_format($row_lista['FECHA_PAGO_SOLICITUD'], 'd/m/Y');  ?></td>
							
							<td>
							<?php 
							$tiene_pdf = "../includes/sube_pagos/comprobante_pago/$id_registro.pdf";
							if(file_exists($tiene_pdf)){
								echo "<a data-fancybox class='btn btn-warning' data-type='iframe' data-src='../includes/sube_pagos/comprobante_pago/$id_registro.pdf' href='javascript:;'>";
							    echo $row_lista['REFERENCIA_SOLICITUD']; 
								echo "</a>";
							}
							else{ echo $row_lista['REFERENCIA_SOLICITUD']; }
							?>
							</td>
							<td><?php echo "$".number_format($monto_aplicado,2); ?></td>
							<td><?php echo "$".number_format($por_aplicar,2); ?></td>
							<td><?php echo $id_usu; ?></td>
							<td><?php echo utf8_encode($row_lista['R_SOCIAL']); ?></td>
							<td><?php echo utf8_encode($row_lista['SECTOR']); ?></td>
							<td><?php echo utf8_encode($row_lista['DESTACAMENTO']); ?></td>
							
							<td>
							    <?php if($row_lista['CVE_SITUACION'] == 2){ ?>
									<form action="" method="post" name="identificap_<?php echo $nombre_input; ?>" id="identificap_<?php echo $nombre_input; ?>" onsubmit="return pregunta();">
										<input type="hidden" name="enviar" value="Buscar" />
										<input type="hidden" name="sector" value="<?php echo $sector; ?>" />
										<input type="hidden" name="ayo" value="<?php echo $ayo; ?>" />
										<input type="hidden" name="del" value="<?php echo $del; ?>" />
										<input type="hidden" name="al" value="<?php echo $al; ?>" />
										<input type="hidden" name="tipoi" value="<?php echo $que_tipo; ?>" />
										<input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>" />
										<input type="hidden" name="referenciai" value="<?php echo $referenciai; ?>" />
										<input type="hidden" name="identificar" value="<?php echo $nombre_input; ?>" />	
										
										
										<?php if($cve_pago_tipo == 1 OR $cve_pago_tipo == 3){ ?>
										<button id="vf<?php echo $i;?>" type='button' onclick="visualiza(<?php echo $row_lista['ID_REGISTRO']?>,<?php echo $row_lista['ID_PAGO']?>,<?php echo $row_lista['AYO_PAGO']?>,<?php echo "'".$id_usu."'"?>,<?php echo $monto_aplicado;?>,<?php echo $por_aplicar;?>,<?php echo $monto_pago;?>,'#vf<?php echo $i;?>')" class='btn btn-primary btn-sm' data-toggle='modal' >VALIDAR</button>
										<?php } ?>
										
										<?php if($cve_pago_tipo == 2){ ?>
										<button type='button' class='btn btn-danger btn-sm' data-toggle='modal'><?php echo $interval->format('%R%a'); ?> DÍAS DEL PAGO</button></center>
										<?php } ?>
										
										
								    </form>
								<?php } ?>
							    
								<?php if($row_lista['CVE_SITUACION'] == 3){ ?>
									  <button type='button' class='btn btn-success btn-sm' data-toggle='modal'>PAGO VALIDADO</button></center>
								<?php } ?>
							</td>
							
						</tr>
				<?php $i++; } ?>

				</tbody>
				</table>
				</div>
				<?php } else{ ?>
				<br><div class='alert alert-danger'> <font style='font-size:16px;'> <b> NO EXISTEN REGISTROS </b> </font> </div>
				<?php } } ?>

				<!-- ------------------------ fin area de trabajo ------------------------ -->
				
				 <div>
                    <div class='modal' id='myModalCharts' role='ialog'>
                        <div class='modal-dialog mymodal modal-lg' style=' width: 55% !important'>         
                            <!-- Modal content-->
                            <div class='modal-content'>
                                <div class='modal-header title_left' style=' background-color: #2C3E50;'>
                                    <button type='button' class='close' data-dismiss='modal' style=' background-color: white;'>&nbsp&nbsp;&times;&nbsp&nbsp;</button>
                                    <h4 class='modal-title' style=' color: white;'><img width='2%'  src='../dist/img/pa2.png'><center></center></h4>
                                </div>
                                <div id="tb3" ></div> 
								
								
                            </div>      
                        </div>
                    </div>
					
					
					
				<div class='modal' id='myModalCharts1' role='ialog'>
                        <div class='modal-dialog mymodal modal-lg' style=' width: 55% !important'>         
                            <!-- Modal content-->
                            <div class='modal-content'>
                                <div class='modal-header title_left' style=' background-color: #2C3E50;'>
                                    <button type='button' class='close' data-dismiss='modal' style=' background-color: white;'>&nbsp&nbsp;&times;&nbsp&nbsp;</button>
                                    <h4 class='modal-title' style=' color: white;'><img width='2%'  src='../dist/img/pa2.png'><center></center></h4>
                                </div>
								<div class='col-md-12'><br></div>
								<div style='text-align: center'><br>
									<h4 style=' color: #1B4C7C; font-weight: 600'>¿Estas seguro de VALIDAR este PAGO? Ya NO podrás MODIFICARLO posteriormente.</h4><hr>
								</div> 
                                <div class='modal-footer'>  <br>
								
								<div id="tb4" ></div> 
                                
								
                            </div>      
                        </div>
                    </div>
					
					
					<div id="tb4" ></div> 
					
                </div>   
				
				<div class='modal' id='myModalCharts2' role='ialog'>
                        <div class='modal-dialog mymodal modal-lg' style=' width: 55% !important'>         
                            <!-- Modal content-->
                            <div class='modal-content'>
                                <div class='modal-header title_left' style=' background-color: #2C3E50;'>
                                    <button type='button' class='close' data-dismiss='modal' style=' background-color: white;'>&nbsp&nbsp;&times;&nbsp&nbsp;</button>
                                    <h4 class='modal-title' style=' color: white;'><img width='2%'  src='../dist/img/pa2.png'><center></center></h4>
                                </div>
								<div class='col-md-12'><br></div>
								<div style='text-align: center'><br>
									<h4 style=' color: #1B4C7C; font-weight: 600'>¿Estas seguro de CANCELAR este PAGO?.</h4><hr>
								</div> 
                                <div class='modal-footer'>  <br>
								
								<div id="tb6" ></div> 
                                
								
                            </div>      
                        </div>
                    </div>
					
					
					<div id="tb5" ></div> 
					
                </div>
				
				
			</div>
			
		</div>
	</section>
	</div>
		
	<?php include_once '../footer.html'; ?>
	<script src="js/jquery-1.11.0.min.js"></script> 
	<script language="JavaScript">
	var boton = "";
/*	function pregunta(){
		if (confirm('¿Estas seguro de IDENTIFICAR este PAGO? Ya NO podrás MODIFICARLO posteriormente.')){
		   document.form.submit();
		}
		else{ return false; }
	}*/
	
	function visualiza(reg,pagos,ayo,usu,aplicado,por_aplicar,pagado,id_boton){
		boton = id_boton;
		
		var url = "<?php echo BASE_URL; ?>includes/cobranza/opciones_usuariov.php";
	$.ajax({
            type: "POST",
            url: url,
            data: {
				reg : reg,
				pagos : pagos,
				ayo : ayo,
				usu : usu,
				aplicado : aplicado,
				por_aplicar : por_aplicar,
				pagado : pagado
            },
            success: function (data)
            {
                $("#tb3").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("tb3").style.display="block"; 
				
				
				$("#myModalCharts").modal("show");
            }
        });
		return false;
    }
	
	function aplica_pago(pagos,ayo,reg,usu){
		
		var url = "<?php echo BASE_URL; ?>includes/cobranza/modalv.php";
		
        $.ajax({
            type: "POST",
            url: url,
            data: {
				pagos : pagos,
				ayo : ayo,
				reg : reg,
				usu : usu
				
            },
            success: function (data)
            {
				
                $("#tb4").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("tb4").style.display="block"; 
                $("#myModalCharts1").modal("show");				
				//detalle(); 	
				
            }
        });
		
		return false;
        			
            
    }
	
	function cancela_pago(pagos,ayo,reg,usu){
		
		var url = "<?php echo BASE_URL; ?>includes/cobranza/modal_cancela.php";
		
        $.ajax({
            type: "POST",
            url: url,
            data: {
				pagos : pagos,
				ayo : ayo,
				reg : reg,
				usu : usu,
				obs_c: $('#obs_cancela').val()
				
            },
            success: function (data)
            {
				
                $("#tb6").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("tb6").style.display="block"; 
                $("#myModalCharts2").modal("show");				
				//detalle(); 	
				 //$('#tb10').load('identificar_pagos.php');
				
            }
        });
		
		return false;
        			
            
    }
	
	function aplica(pagos,ayo,reg,usu){
		var id_boton = boton;
		console.log(boton);
		var url = "<?php echo BASE_URL; ?>includes/cobranza/valida.php";
		
        $.ajax({
            type: "POST",
            url: url,
            data: {
				pagos : pagos,
				ayo : ayo,
				reg : reg,
				usu : usu
				
            },
            success: function (data)
            {		
				 $("#myModalCharts1").modal("hide");
				$("#myModalCharts").modal("hide");					 
				//visualiza(reg,pagos,ayo,usu,id_boton);
				//$(id_boton).click();
				$("#tb8").html(data); // Mostrar la respuestas del script PHP.
				$("#enviar").click();
                document.getElementById("tb8").style.display="block";
				  
            }
        });
		
		return false;
        			
            
    }

	function cancela(pagos,ayo,reg,usu){
		var id_boton = boton;
		console.log(boton);
		var url = "<?php echo BASE_URL; ?>includes/cobranza/cancela.php";
		
        $.ajax({
            type: "POST",
            url: url,
            data: {
				pagos : pagos,
				ayo : ayo,
				reg : reg,
				usu : usu,
				obs_c: $('#obs_cancela').val()
				
            },
            success: function (data)
            {		
				 $("#myModalCharts2").modal("hide");
                 $("#myModalCharts").modal("hide");				 
				//visualiza(reg,pagos,ayo,usu,id_boton);
				//$(id_boton).click();
				$("#tb9").html(data); // Mostrar la respuestas del script PHP.
				$("#enviar").click();
				document.getElementById("tb9").style.display="block";
            }
        });
		
		return false;
        			
            
    }
	
	
	
	
	

	

	$(document).ready(function() {
		setTimeout(function() {
			$(".alert-success").fadeOut(1500);
		},3000);
	});
	$(document).ready(function() {
		setTimeout(function() {
			$(".alert-danger").fadeOut(1500);
		},3000);
	});
	</script>
	
	
	