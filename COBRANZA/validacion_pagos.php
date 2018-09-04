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

if(@$_REQUEST["sube"] == "VALIDAR PAGO"){
	foreach($_POST as $clave=>$valor){
		if($clave != "enviar" AND $clave != "sube" AND $clave == "identificar"){
		   //echo "El valor de $clave es: $valor"."<br>";
		   $datos_update = explode("***", $valor);
		   $idpago_update = $datos_update[0];
		   $iduser_update = $datos_update[1];
		   $ayopago_update = $datos_update[2];
		   $montopago_update = $datos_update[3];
		   $fechapago_update = $datos_update[4];
		   
		   @$sql_pago = "UPDATE [Facturacion].[dbo].pago SET CVE_PAGO_SIT = 3 
		                 WHERE ID_PAGO = $idpago_update AND ID_USUARIO = '$iduser_update' AND AYO_PAGO = $ayopago_update AND MONTO = $montopago_update AND FECHA_PAGO = '$fechapago_update' AND CVE_PAGO_SIT = 2";
		   $res_pago = sqlsrv_query($conn,$sql_pago);
		   	
		   $sql_factura = "select ID_PAGO, ID_FACTURA, AYO, AYO_PAGO from Pago_Factura where CVE_PAGO_SIT = 2 and ID_PAGO = $idpago_update and AYO_PAGO = $ayopago_update ORDER BY ID_FACTURA";
		   $res_factura = sqlsrv_query($conn,$sql_factura);
		   while($row_factura = sqlsrv_fetch_array($res_factura)){
				 $sql = "EXECUTE [Facturacion].[dbo].sp_Datos_Timbrado_REP $row_factura[AYO],$row_factura[ID_FACTURA],$row_factura[ID_PAGO],$row_factura[AYO_PAGO],$idOp,1";
                 $res = sqlsrv_query($conn,$sql);
		   }
		   
		   $sql_sol = "SELECT COUNT(*) as CUANTOS FROM [Facturacion].[dbo].Pago_Solicitud WHERE ID_USUARIO = '$iduser_update' AND MONTO = $montopago_update AND FECHA_PAGO = '$fechapago_update' AND CVE_SITUACION = 2";
		   $res_sol = sqlsrv_query($conn,$sql_sol);
		   $row_sol = sqlsrv_fetch_array($res_sol);
		   
		   if($row_sol['CUANTOS'] > 0){			  
			   @$sql_solicitud = "UPDATE [Facturacion].[dbo].Pago_Solicitud SET CVE_SITUACION = 3 
								  WHERE ID_USUARIO = '$iduser_update' AND MONTO = $montopago_update AND FECHA_PAGO = '$fechapago_update' AND CVE_SITUACION = 2";
			   $res_solicitud = sqlsrv_query($conn,$sql_solicitud);
			   @$si_soli = sqlsrv_rows_affected($res_solicitud);
		   }
		   else{ @$si_soli = 1; }
		   
		   @$si_pago = sqlsrv_rows_affected($res_pago);
		}
	}
}

if(@$_REQUEST["sube"] == "CANCELAR"){
	foreach($_POST as $clave=>$valor){
		if($clave != "enviar" AND $clave != "sube" AND $clave == "identificar"){
		   //echo "El valor de $clave es: $valor"."<br>";
		   $datos_update = explode("***", $valor);
		   $idpago_update = $datos_update[0];
		   $iduser_update = $datos_update[1];
		   $ayopago_update = $datos_update[2];
		   $montopago_update = $datos_update[3];
		   $fechapago_update = $datos_update[4];
		   $situacion_update = $datos_update[5];
		   
		   @$sql_pago = "UPDATE [Facturacion].[dbo].pago SET CVE_PAGO_SIT = 1, ID_USUARIO = NULL 
		                 WHERE ID_PAGO = $idpago_update AND ID_USUARIO = '$iduser_update' AND AYO_PAGO = $ayopago_update AND MONTO = $montopago_update AND FECHA_PAGO = '$fechapago_update' AND CVE_PAGO_SIT = $situacion_update";
		   $res_pago = sqlsrv_query($conn,$sql_pago);
		   
		   $sql_sol = "SELECT COUNT(*) as CUANTOS FROM [Facturacion].[dbo].Pago_Solicitud WHERE ID_USUARIO = '$iduser_update' AND MONTO = $montopago_update AND FECHA_PAGO = '$fechapago_update' AND CVE_SITUACION = $situacion_update";
		   $res_sol = sqlsrv_query($conn,$sql_sol);
		   $row_sol = sqlsrv_fetch_array($res_sol);
		   
		   if($row_sol['CUANTOS'] > 0){			  
			   @$sql_solicitud = "UPDATE [Facturacion].[dbo].Pago_Solicitud SET CVE_SITUACION = 1 
								  WHERE ID_USUARIO = '$iduser_update' AND MONTO = $montopago_update AND FECHA_PAGO = '$fechapago_update' AND CVE_SITUACION = $situacion_update";
			   $res_solicitud = sqlsrv_query($conn,$sql_solicitud);
			   @$si_solic = sqlsrv_rows_affected($res_solicitud);
		   }
		   else{ @$si_solic = 1; }
		   
		   @$si_pagoc = sqlsrv_rows_affected($res_pago);
		}
	}
}

if($sector != ""){ @$q_sector = " AND SECTOR=$sector "; } else { @$q_sector = ""; }
if($ayo != ""){ @$q_ayo = " AND AYO_PAGO=$ayo "; } else { @$q_ayo = ""; }
if($del != "" and $al != ""){  @$q_fecha = " AND (PG.FECHA_PAGO between '$f_del' and '$f_al') "; } else { @$q_fecha = ""; }
if(@$idusuario != ""){ $q_usuario = " AND UP.ID_USUARIO = '$idusuario' "; } else{ $q_usuario = ""; }
if(@$referenciai != ""){ $q_referencia = " AND PG.REFERENCIA like '%$referenciai%' "; } else{ $q_referencia = ""; }

if(@$que_tipo == 0){ $q_tipo = " where PG.CVE_PAGO_SIT = 2 and (PG.ID_USUARIO is NOT NULL AND PG.ID_USUARIO <> '') "; $que_validado = 2; } 
if(@$que_tipo == 1){ $q_tipo = " where PG.CVE_PAGO_SIT = 2 and (PG.ID_USUARIO is NOT NULL AND PG.ID_USUARIO <> '') "; $que_validado = 2; } 
if(@$que_tipo == 2){ $q_tipo = " where PG.CVE_PAGO_SIT = 3 and (PG.ID_USUARIO is NOT NULL AND PG.ID_USUARIO <> '') "; $que_validado = 3; }

$sql_lista="SELECT 
PG.AYO_PAGO,PG.CVE_PAGO_TIPO as CVE_PAGO_TIPO_PAGO,PG.MONTO as MONTO_PAGO,Cast(PG.FECHA_PAGO As Date) as FECHA_PAGO,PG.REFERENCIA as REFERENCIA_PAGO,PG.ID_BANCO as ID_BANCO_PAGO,PG.SUCURSAL as SUCURSAL_PAGO,PG.ID_PAGO,PG.CVE_PAGO_SIT,
UP.ID_USUARIO,UP.R_SOCIAL,UP.SECTOR,UP.DESTACAMENTO
FROM [Facturacion].[dbo].[Pago] PG
inner join [Facturacion].[dbo].V_usuario_padron UP on UP.ID_USUARIO = PG.ID_USUARIO AND UP.CVE_SITUACION = 1
$q_tipo
$q_sector $q_ayo $q_fecha $q_usuario $q_referencia
GROUP BY 
PG.AYO_PAGO,PG.CVE_PAGO_TIPO,PG.MONTO,Cast(PG.FECHA_PAGO As Date),PG.REFERENCIA,PG.ID_BANCO,PG.SUCURSAL,PG.ID_PAGO,PG.CVE_PAGO_SIT,
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
                
				<?php if(@$_REQUEST["sube"] == "VALIDAR PAGO"){  
				         if(@$si_pago == 1 AND @$si_soli == 1){ ?>
				         <br>
				         <div class="alert alert-success"> <strong>EL PAGO SE VALIDÓ CORRECTAMENTE</strong> </div>
				<?php } else{ ?>
				         <br>
				         <div class="alert alert-danger"> <strong>OCURRIO UN PROBLEMA AL VALIDAR EL PAGO</strong> </div>
				<?php } } ?>
				
				<?php if(@$_REQUEST["sube"] == "CANCELAR"){  
				         if(@$si_pagoc == 1 AND @$si_solic == 1){ ?>
				         <br>
				         <div class="alert alert-success"> <strong>EL PAGO SE CANCELÓ CORRECTAMENTE</strong> </div>
				<?php } else{ ?>
				         <br>
				         <div class="alert alert-danger"> <strong>OCURRIO UN PROBLEMA AL CANCELAR EL PAGO</strong> </div>
				<?php } } ?>
				
				<?php if(@$_REQUEST["enviar"] == "Buscar"){ ?>
				<?php if($cuantos_son === true){ ?>
				
				<br>
				<table class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:12px;'>
					<thead>
					  <tr>
					    <td align="center" class="bg-primary"><b>#</b></td>
					    <td align="center" class="bg-primary"><b>AÑO PAGO</b></td>
						<td align="center" class="bg-primary"><b>MONTO PAGO</b></td>
						<td align="center" class="bg-primary"><b>FECHA PAGO</b></td>
						<td align="center" class="bg-primary"><b>REFERENCIA PAGO</b></td>
						<td align="center" class="bg-primary"><b>FACTURAS</b></td>
						<td align="center" class="bg-primary"><b>USUARIO</b></td>
						<td align="center" class="bg-primary"><b>RAZÓN SOCIAL</b></td>
						<td align="center" class="bg-primary"><b>SECTOR</b></td>
						<td align="center" class="bg-primary"><b>DEST</b></td>
						<td align="center" class="bg-primary"><b></b></td>
						<td align="center" class="bg-primary"><b></b></td>
					  </tr>
					</thead>
					  <tbody>				
				<?php
					$i=1;
					$tim = 1;
					while($row_lista = sqlsrv_fetch_array($res_lista)){
						  if($i%2==0){ $color="#E1EEF4"; } else{ $color="#FFFFFF"; }
						  
						  $sql_facturas = "select ID_FACTURA from Pago_Factura where CVE_PAGO_SIT = $que_validado and ID_PAGO = $row_lista[ID_PAGO] and AYO_PAGO = $row_lista[AYO_PAGO] ORDER BY ID_FACTURA";
                          $res_facturas = sqlsrv_query($conn,$sql_facturas);
						  $facturas = "";
						  while($row_facturas = sqlsrv_fetch_array($res_facturas)){
							    $facturas = $facturas . $row_facturas['ID_FACTURA'] . ", ";
						  }
						  $facturas = trim($facturas, ', ');
						  
						  $nombre_input = $row_lista['ID_PAGO']."***".$row_lista['ID_USUARIO']."***".$row_lista['AYO_PAGO']."***".$row_lista['MONTO_PAGO']."***".date_format($row_lista['FECHA_PAGO'], 'Y/m/d')."***". $row_lista['CVE_PAGO_SIT'];
				?>
						<tr bgcolor="<?php echo $color; ?>">
						    <td><?php echo $i; ?></td>
							<td><?php echo $row_lista['AYO_PAGO']; ?></td>
							<td><?php echo number_format($row_lista['MONTO_PAGO'],2); ?></td>
							<td><?php echo date_format($row_lista['FECHA_PAGO'], 'd/m/Y');  ?></td>
							<td><?php echo utf8_encode(str_replace("/", "", $row_lista['REFERENCIA_PAGO'])); ?></td>
							<td><?php echo $facturas; ?></td>
							<td><?php echo $row_lista['ID_USUARIO']; ?></td>
							<td><?php echo utf8_encode($row_lista['R_SOCIAL']); ?></td>
							<td><?php echo utf8_encode($row_lista['SECTOR']); ?></td>
							<td><?php echo utf8_encode($row_lista['DESTACAMENTO']); ?></td>
							
							<td>
							    <?php if($row_lista['CVE_PAGO_SIT'] == 2){ ?>
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
										
										<input name="sube" id="sube" type="submit" value="VALIDAR PAGO" class="btn btn-primary btn-sm center-block" />
								    </form>
								<?php } ?>
							    
								<?php if($row_lista['CVE_PAGO_SIT'] == 3){ ?>
									  <button type='button' class='btn btn-success btn-sm' data-toggle='modal'>PAGO VALIDADO</button></center>
								<?php } ?>
							</td>
							<td>
							<?php if($row_lista['CVE_PAGO_SIT'] != 3){ ?>
								    <form action="" method="post" name="identificac_<?php echo $nombre_input; ?>" id="identificac_<?php echo $nombre_input; ?>" onsubmit="return preguntac();">
									    <input type="hidden" name="enviar" value="Buscar" />
										<input type="hidden" name="sector" value="<?php echo $sector; ?>" />
										<input type="hidden" name="ayo" value="<?php echo $ayo; ?>" />
										<input type="hidden" name="del" value="<?php echo $del; ?>" />
										<input type="hidden" name="al" value="<?php echo $al; ?>" />
										<input type="hidden" name="tipoi" value="<?php echo $que_tipo; ?>" />
										<input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>" />
										<input type="hidden" name="referenciai" value="<?php echo $referenciai; ?>" />
										<input type="hidden" name="identificar" value="<?php echo $nombre_input; ?>" />	
							          <input name="sube" id="sube" type="submit" value="CANCELAR" class="btn btn-danger btn-sm center-block" />
									</form>
							<?php } ?>
							</td>
							
						</tr>
				<?php $i++; } ?>

				</tbody>
				</table>
				
				<?php } else{ ?>
				<br><div class='alert alert-danger'> <font style='font-size:16px;'> <b> NO EXISTEN REGISTROS </b> </font> </div>
				<?php } } ?>

				<!-- ------------------------ fin area de trabajo ------------------------ -->
			</div>
		</div>
	</section>
	</div>
		
	<?php include_once '../footer.html'; ?>
	
	<script language="JavaScript">
	function pregunta(){
		if (confirm('¿Estas seguro de VALIDAR este PAGO? Ya NO podrás MODIFICARLO posteriormente.')){
		   document.form.submit();
		}
		else{ return false; }
	}
	</script> 
	
	<script language="JavaScript">
	function preguntac(){
		if (confirm('¿Estas seguro de CANCELAR este PAGO?')){
		   document.form.submit();
		}
		else{ return false; }
	}
	</script> 
	
	<script src="js/jquery-1.11.0.min.js"></script> 
	<script type="text/javascript">
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
	
	
	