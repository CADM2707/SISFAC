<?php
include_once '../config.php';
include_once '../head.html';
include_once '../menuLat.php';

@$ayo = $_REQUEST['ayo'];
@$del = $_REQUEST['del'];
@$al = $_REQUEST['al'];
@$que_tipo = $_REQUEST['tipoi'];
@$montop = trim($_REQUEST['montop']);
@$referenciai = trim($_REQUEST['referenciai']);

$f_del = date("Y/m/d", strtotime($del));
$f_al = date("Y/m/d", strtotime($al));


if(@$_REQUEST["sube"] == "" AND @$_REQUEST["identificar"] != ""){
	foreach($_POST as $clave=>$valor){
	if($clave == "identificar" OR $valor == "ASIGNAR PAGO"){
	   //echo "El valor de $clave es: $valor"."<br>";
	   if($clave == "identificar"){
	      $datos_update = explode("***", $valor);
	      $idpago_update = $datos_update[0];
	      $ayopago_update = $datos_update[1];
	   }
	   if($valor == "ASIGNAR PAGO"){
	      $user_update = explode("***", $clave);
		  $iduser_update = $user_update[1];
	   }
	   if(@$idpago_update != "" AND @$ayopago_update != "" AND @$iduser_update != ""){
	      @$sql_pago = "UPDATE [Facturacion].[dbo].pago SET CVE_PAGO_SIT = 2, ID_USUARIO = '$iduser_update' WHERE ID_PAGO = $idpago_update AND AYO_PAGO = $ayopago_update";
	      $res_pago = sqlsrv_query($conn,$sql_pago);
		  @$si_pago = sqlsrv_rows_affected($res_pago);
	   }
	}
}
}


if($ayo != ""){ @$q_ayo = " AND AYO_PAGO=$ayo "; } else { @$q_ayo = ""; }
if($del != "" and $al != ""){  @$q_fecha = " AND (Cast(FECHA_PAGO As Date) between '$f_del' and '$f_al') "; } else { @$q_fecha = ""; }
if(@$montop != ""){ $q_monto = " AND MONTO = $montop "; } else{ $q_monto = ""; }
if(@$referenciai != ""){ $q_referencia = " AND REFERENCIA like '%$referenciai%' "; } else{ $q_referencia = ""; }

if(@$que_tipo == 0){ $q_tipo = " where CVE_PAGO_SIT = 1 and (ID_USUARIO is NULL OR ID_USUARIO = '') "; } 
if(@$que_tipo == 1){ $q_tipo = " where CVE_PAGO_SIT = 1 and (ID_USUARIO is NULL OR ID_USUARIO = '') "; } 
if(@$que_tipo == 2){ $q_tipo = " where CVE_PAGO_SIT = 2 and (ID_USUARIO is NOT NULL OR ID_USUARIO <> '') "; }

echo $sql_lista="select ID_PAGO,AYO_PAGO,CVE_PAGO_TIPO,MONTO,Cast(FECHA_PAGO As Date) as FECHA_PAGO,REFERENCIA,OBSERVACION,ID_BANCO,SUCURSAL,ID_USUARIO,CVE_PAGO_SIT
			from pago 
			$q_tipo $q_ayo $q_monto $q_referencia $q_fecha
			AND CVE_PAGO_TIPO <> 70
			ORDER BY AYO_PAGO,FECHA_PAGO";
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
				IDENTIFICAR PAGO MANUAL
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
					  <td align="center" width="11%">
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
					  <td align="center" width="11%">
								<center><label>DEL</label></center>
								<input type="date" name="del"  value="<?php echo $del;?>" id="del"  style="text-align:center;" onchange="es_vacio3()" class="form-control" >
					  </td>
					  <td width="5%">&nbsp;</td>
					  <td align="center" width="11%">
								<center><label>AL</label></center>
								<input type="date" name="al"  value="<?php echo $al;?>" id="al" style="text-align:center;" onchange="es_vacio4()"  class="form-control" >
					  </td>
					  <td width="5%">&nbsp;</td>
					  <td align="center" width="11%">
								<center><label>MONTO PAGO</label></center>
								<input type="text" name="montop"  value="<?php echo @$montop;?>" id="montop" class="form-control" style="text-align:center;">
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
									 <option value="1" <?php echo @$t1; ?>>IDENTIFICAR</option>
									 <option value="2" <?php echo @$t2; ?>>IDENTIFICADOS</option>
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
                
				<?php if(@$_REQUEST["enviar"] == "Buscar" AND @$_REQUEST["identificar"] == ""){ ?>
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
						<td align="center" class="bg-primary"><b>OBSERVACION</b></td>
						<td align="center" class="bg-primary"><b>TIPO DE PAGO</b></td>
						<td align="center" class="bg-primary"><b>BANCO</b></td>
						<td align="center" class="bg-primary"><b>SUCURSAL</b></td>
						
						<?php if(@$que_tipo == 2){ ?>
						<td align="center" class="bg-navy"><b>USUARIO</b></td>
						<td align="center" class="bg-navy"><b>RAZÓN SOCIAL</b></td>
						<?php } ?>
						
						<td align="center" class="bg-primary"><b></b></td>
					  </tr>
					</thead>
					  <tbody>				
				<?php
					$i=1;
					$tim = 1;
					while($row_lista = sqlsrv_fetch_array($res_lista)){
						  if($i%2==0){ $color="#E1EEF4"; } else{ $color="#FFFFFF"; }
						  $nombre_input = $row_lista['ID_PAGO']."***".$row_lista['AYO_PAGO'];
						  
						  $sql_usuario = "SELECT R_SOCIAL FROM V_usuario_padron WHERE ID_USUARIO = '$row_lista[ID_USUARIO]'";
                          $res_usuario = sqlsrv_query($conn,$sql_usuario);
						  $row_usuario = sqlsrv_fetch_array($res_usuario);
						  
						  $sql_tpago ="select DESCRIPCION from C_Pago_Tipo WHERE CVE_PAGO_TIPO = '$row_lista[CVE_PAGO_TIPO]'";
                          $res_tpago = sqlsrv_query($conn,$sql_tpago);
						  $row_tpago = sqlsrv_fetch_array($res_tpago);
						  
						  $sql_cbanco ="SELECT BANCO FROM C_Banco WHERE ID_BANCO = '$row_lista[ID_BANCO]'";
                          $res_cbanco = sqlsrv_query($conn,$sql_cbanco);
						  $row_cbanco = sqlsrv_fetch_array($res_cbanco);

						  $cadena = $row_lista['REFERENCIA'];
						  $buscar_cheque1 = "CHEQ";
						  $buscar_cheque2 = "DEP S B COBRO";
						  $resultado_cheque1 = strpos($cadena, $buscar_cheque1);
						  $resultado_cheque2 = strpos($cadena, $buscar_cheque2);
						  
						  if($resultado_cheque1 !== FALSE OR $resultado_cheque2 !== FALSE OR $row_lista['CVE_PAGO_TIPO'] == 7){ 
							 $datetime2 = $row_lista['FECHA_PAGO'];
							 $interval = date_diff($datetime2, $datetime1);
							 
							 //echo $interval->format('%R%a');
						     
							 if($interval->format('%R%a') > 3){ $cve_pago_tipo = 1;  }
							 else if($interval->format('%R%a') <= 3){ $cve_pago_tipo = 2; }
						  }
						  else{ $cve_pago_tipo = 3; }						  
				?>
						<tr bgcolor="<?php echo $color; ?>">
						    <td><?php echo $i; ?></td>
							<td><?php echo $row_lista['AYO_PAGO']; ?></td>							
							<td><?php echo number_format($row_lista['MONTO'],2); ?></td>
							<td>
                                                            <?php if($row_lista['FECHA_PAGO'] != ""){echo date_format($row_lista['FECHA_PAGO'], 'd/m/Y'); }  ?>                                                            
                                                        </td>
							<td><?php echo utf8_encode(str_replace("/", "", $row_lista['REFERENCIA'])); ?></td>
							<td><?php echo utf8_encode(str_replace("/", "", $row_lista['OBSERVACION'])); ?></td>
							<td><?php echo $row_tpago['DESCRIPCION'];  ?></td>
							<td><?php echo $row_cbanco['BANCO']; ?></td>
							<td><?php echo $row_lista['SUCURSAL']; ?></td>
							
							<?php if(@$que_tipo == 2){ ?>
							<td><?php echo $row_lista['ID_USUARIO']; ?></td>
							<td><?php echo utf8_encode($row_usuario['R_SOCIAL']); ?></td>
							<?php } ?>
							
							<td>
							    <?php if($row_lista['CVE_PAGO_SIT'] == 1 AND $row_lista['ID_USUARIO'] == ""){ ?>
									<form action="" method="post" name="identificap_<?php echo $nombre_input; ?>" id="identificap_<?php echo $nombre_input; ?>">
										<input type="hidden" name="enviar" value="Buscar" />
										<input type="hidden" name="ayo" value="<?php echo $ayo; ?>" />
										<input type="hidden" name="del" value="<?php echo $del; ?>" />
										<input type="hidden" name="al" value="<?php echo $al; ?>" />
										<input type="hidden" name="tipoi" value="<?php echo $que_tipo; ?>" />
										<input type="hidden" name="referenciai" value="<?php echo $referenciai; ?>" />
										<input type="hidden" name="montop" value="<?php echo $montop; ?>" />
										<input type="hidden" name="identificar" value="<?php echo $nombre_input; ?>" />

                                        <?php if($cve_pago_tipo == 1 OR $cve_pago_tipo == 3){ ?>										
										<input name="sube" id="sube" type="submit" value="ASIGNAR PAGO A USUARIO" class="btn btn-primary btn-sm center-block" />
										<?php } ?>
										
										<?php if($cve_pago_tipo == 2){ ?>
										<button type='button' class='btn btn-danger btn-sm' data-toggle='modal'><?php echo $interval->format('%R%a'); ?> DÍAS DEL PAGO</button></center>
										<?php } ?>
										
								    </form>
								<?php } ?>
							    
								<?php if($row_lista['CVE_PAGO_SIT'] == 2 AND $row_lista['ID_USUARIO'] != ""){ ?>
									  <button type='button' class='btn btn-success btn-sm' data-toggle='modal'>PAGO IDENTIFICADO</button></center>
								<?php } ?>
							</td>
							
						</tr>
				<?php $i++; } ?>

				</tbody>
				</table>
				
				<?php } else{ ?>
				<br><div class='alert alert-danger'> <font style='font-size:16px;'> <b> NO EXISTEN REGISTROS </b> </font> </div>
				<?php } } ?>
				
				
				<?php if(@$_REQUEST["sube"] == "ASIGNAR PAGO A USUARIO" OR @$_REQUEST["identificar"] != ""){ ?>
				
				<?php
				$datos_usuario = explode("***", $_REQUEST["identificar"]);
		        $idpago_usuario = $datos_usuario[0];
		        $aypago_usuario = $datos_usuario[1];
				
				$sql_datos = "select ID_PAGO,AYO_PAGO,CVE_PAGO_TIPO,MONTO,Cast(FECHA_PAGO As Date) as FECHA_PAGO,REFERENCIA,OBSERVACION,ID_BANCO,SUCURSAL,ID_USUARIO,CVE_PAGO_SIT
							 from pago WHERE ID_PAGO = $idpago_usuario AND AYO_PAGO = $aypago_usuario";
				$res_datos = sqlsrv_query($conn,$sql_datos);
				$row_datos = sqlsrv_fetch_array($res_datos);
				
				$sql_tpago1 = "select DESCRIPCION from C_Pago_Tipo WHERE CVE_PAGO_TIPO = '$row_datos[CVE_PAGO_TIPO]'";
				$res_tpago1 = sqlsrv_query($conn,$sql_tpago1);
				$row_tpago1 = sqlsrv_fetch_array($res_tpago1);
				  
				$sql_cbanco1 = "SELECT BANCO FROM C_Banco WHERE ID_BANCO = '$row_datos[ID_BANCO]'";
				$res_cbanco1 = sqlsrv_query($conn,$sql_cbanco1);
				$row_cbanco1 = sqlsrv_fetch_array($res_cbanco1);
				
				if($row_datos['CVE_PAGO_SIT'] == 2){
					$sql_usuario = "SELECT ID_USUARIO, R_SOCIAL FROM V_usuario_padron WHERE ID_USUARIO = '$row_datos[ID_USUARIO]'";
					$res_usuario = sqlsrv_query($conn,$sql_usuario);
					$row_usuario = sqlsrv_fetch_array($res_usuario);
				}
				?>
				
				<br>
				<br>
				<div> <font style='font-size:28px; color:#049300'> <b> ASIGNAR PAGO A USUARIO </b> </font> </div>
				<br>
				
				<table class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:12px;'>
					<thead>
					  <tr>
                                                <td align="center" class="bg-primary" hidden="true"><b>ID PAGO</b></td>
                                                <td align="center" class="bg-primary"><b>AÑO PAGO</b></td>
						<td align="center" class="bg-primary"><b>MONTO PAGO</b></td>
						<td align="center" class="bg-primary"><b>FECHA PAGO</b></td>
						<td align="center" class="bg-primary"><b>REFERENCIA PAGO</b></td>
						<td align="center" class="bg-primary"><b>OBSERVACION</b></td>
						<td align="center" class="bg-primary"><b>TIPO DE PAGO</b></td>
						<td align="center" class="bg-primary"><b>BANCO</b></td>
						<td align="center" class="bg-primary"><b>SUCURSAL</b></td>
						
						<?php if($row_datos['CVE_PAGO_SIT'] == 2){ ?>
						<td align="center" class="bg-navy"><b>USUARIO</b></td>
						<td align="center" class="bg-navy"><b>RAZÓN SOCIAL</b></td>
						<td align="center" class="bg-primary"><b></b></td>
						<?php } ?>
						
					  </tr>
					</thead>
					  <tbody>
					  <tr bgcolor="#E1EEF4">
                                              <td hidden="true"><b><?php echo $row_datos['ID_PAGO']; ?><input type="hidden" value="<?php echo  $row_datos['ID_PAGO']?>" id="IdPagoAsignado" ></b></td>
                                              <td><b><?php echo $row_datos['AYO_PAGO']; ?></b><input type="hidden" value="<?php echo  $row_datos['AYO_PAGO']?>" id="AyoPagoAsignado" ></td>
						<td><b><?php echo number_format($row_datos['MONTO'],2); ?></b><input type="hidden" value="<?php echo  $row_datos['MONTO']?>" id="MontoPagoAsignado" ></td>
						<td><b><?php if($row_datos['FECHA_PAGO'] != ""){ echo $fpm = date_format($row_datos['FECHA_PAGO'], 'd/m/Y'); }  ?></b>
                                                    <input type="hidden" id="fpmn" name="fpmn" value="<?php echo date_format($row_datos['FECHA_PAGO'], 'd/m/Y'); ?>">
                                                </td>
						<td><b><?php echo utf8_encode(str_replace("/", "", $row_datos['REFERENCIA'])); ?></b>
                                                    <input type="hidden" id="rfps" name="rfps" value="<?php echo $row_datos['REFERENCIA']; ?>">
                                                </td>
						<td><b><?php echo utf8_encode(str_replace("/", "", $row_datos['OBSERVACION'])); ?></b></td>
						<td><b><?php echo $row_tpago1['DESCRIPCION'];  ?></b></td>
						<td><b><?php echo $row_cbanco1['BANCO']; ?></b></td>
						<td><b><?php echo $row_datos['SUCURSAL']; ?></b></td>
						
						<?php if($row_datos['CVE_PAGO_SIT'] == 2){ ?>
						<td><?php echo $row_usuario['ID_USUARIO']; ?></td>
						<td><?php echo utf8_encode($row_usuario['R_SOCIAL']); ?>
                                                    
                                                </td>
						<td><button type='button' class='btn btn-success btn-sm' data-toggle='modal'>PAGO IDENTIFICADO</button></center></td>
						<?php } ?>
					  </tr>
					  </tbody>
				</table>
				
				<?php if(@$_REQUEST["sube"] == "" AND @$_REQUEST["identificar"] != ""){ ?>
				<?php if(@$si_pago == 1){ ?>
				         <br>
				         <div class="alert alert-success"> <strong>EL PAGO SE IDENTIFICÓ CORRECTAMENTE</strong> </div>
				<?php } else{ ?>
				         <br>
				         <div class="alert alert-danger"> <strong>OCURRIO UN PROBLEMA AL IDENTIFICAR EL PAGO</strong> </div>
				<?php } ?>
				<?php } ?>
				
				<?php if(@$_REQUEST["sube"] != "" AND @$_REQUEST["identificar"] != ""){ ?>
				<br>
				<div> <font style='font-size:16px; color:#000000'> <b> SELECCIONA USUARIO </b> </font> </div>
								
				<form accept-charset="utf-8" method="POST" onsubmit="return pregunta();">
				<table align="center" border="0" width="44%">
				  <tr><td>
				    <input type="hidden" name="enviar" value="Buscar" />
					<input type="hidden" name="ayo" value="<?php echo $ayo; ?>" />
					<input type="hidden" name="del" value="<?php echo $del; ?>" />
					<input type="hidden" name="al" value="<?php echo $al; ?>" />
					<input type="hidden" name="tipoi" value="<?php echo $que_tipo; ?>" />
					<input type="hidden" name="referenciai" value="<?php echo $referenciai; ?>" />
					<input type="hidden" name="montop" value="<?php echo $montop; ?>" />
					<input type="hidden" name="identificar" value="<?php echo $_REQUEST["identificar"]; ?>" />	
										
				    <input type="text" name="busqueda" id="busqueda" value="" placeholder="" maxlength="77" autocomplete="off" class="form-control" style="text-align:center;" onKeyUp="buscar();" />
				  </td></tr>
				</table>
				<div id="resultadoBusqueda"></div>
				</form>
				<?php } ?>
				
				<?php } ?>

				<!-- ------------------------ fin area de trabajo ------------------------ -->
			</div>
		</div>
                </div>
                <!--MOdal asigna Pago-->
                <div class="modal fade in"  tabindex="-1" tabindex="-1" role="dialog" id="myModalCharts" role="dialog" style="margin: 40px;overflow-y: auto;">
                    <div class="modal-dialog mymodal modal-lg" style=" width: 100% !important">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header title_left" style=" background-color: #2C3E50;">
                                <button type="button" class="close" data-dismiss="modal" style=" background-color: white;">&nbsp&nbsp;&times;&nbsp&nbsp;</button>
                                <span style="text-align: center">
                                    <h4 style=" color: white; font-weight: 600"><i class='fa fa-plus-square'></i> &nbsp;ASIGNA PAGO MANUAL.</h4>
                                </span>
                            </div>   
                            <div class="modal-body">   
                                <form id='validaPagos' name='validaPagos'>
                                    <input type="hidden" id="tipoREP2" name="tipoREP2" value="1" readonly="true">
                                    <div class="col-md-12">                                
                                        <div class="row pull-center" style="margin: 5px;">
                                            <div class="col-lg-4 col-xs-4 text-center"></div>
                                            <div class="col-lg-4 col-xs-4 text-center">
                                                <label style="font-weight: 600; color: #2471A3;">RAZÓN SOCIAL: <div id="R_SOCIAL_P"></div> </label>
                                            </div>
                                        </div><br>
                                    </div>
                                    <div class="row pull-center" style="margin: 5px;">
                                        <div class="col-lg-2 col-xs-2 text-center"></div>                                            
                                        <div class="col-lg-2 col-xs-2 text-center">                                            
                                            <label style="font-weight: 600; color: #2471A3;">ID USUARIO</label>
                                            <input style=" background-color: #FFF3C3;" type="text" readonly='true' id="idUsuario" name="idUsuario" class="form form-control text-center">
                                            <input style=" background-color: #FFF3C3;" type="hidden" readonly='true' id="idregistro" name="idregistro" class="form form-control text-center">
                                        </div>
                                        <div class="col-lg-2 col-xs-2 text-center">
                                            <label style="font-weight: 600; color: #2471A3;">ID PAGO</label>
                                            <input style=" background-color: #FFF3C3;" type="text" readonly='true' id="idPagoAsigna" name="idPagoAsigna" class="form form-control text-center">
                                        </div>
                                        <div class="col-lg-2 col-xs-2 text-center">                                            
                                            <label style="font-weight: 600; color: #2471A3;">FECHA PAGO</label>
                                            <input style=" background-color: #FFF3C3;" type="text" readonly='true' id="idFechaPago" name="idFechaPago" class="form form-control text-center">
                                        </div>                                        
                                        <div class="col-lg-2 col-xs-2 text-center">
                                            <label style="font-weight: 600; color: #2471A3;">AÑO DE PAGO</label>
                                            <input style=" background-color: #FFF3C3;" type="text" readonly='true' id="idAyoAsigna" name="idAyoAsigna" class="form form-control text-center">
                                        </div>
                                    </div>
                                    <div class="row pull-center" style="margin: 5px;">
                                        <div class="col-lg-2 col-xs-2 text-center"></div>   
                                        <div class="col-lg-2 col-xs-2 text-center">
                                            <label style="font-weight: 600; color: #2471A3;">MONTO</label>
                                            <input type="text" readonly='true' style=" background-color: #FFF3C3;"  id="montoAsigna" name="montoAsigna" class="form form-control text-center">
                                            <input  type="hidden" style=" background-color: #FFF3C3;" readonly='true' id="montoPago" name="montoPago" class="form form-control text-center">
                                        </div>                                
                                        <div class="col-lg-2 col-xs-2 text-center">
                                            <label style="font-weight: 600; color: #2471A3;">MONTO APLICADO</label>
                                            <input type="text" readonly='true' style=" background-color: #FFF3C3;"  id="montoAplicado" name="montoAplicado" class="form form-control text-center">
                                        </div>                                
                                        <div class="col-lg-2 col-xs-2 text-center">
                                            <label style="font-weight: 600; color: #2471A3;">MONTO POR APLICAR</label>
                                            <input type="text" readonly='true' style="  background-color: #FFF3C3;"  id="montoPorAplicar" name="montoPorAplicar" class="form form-control text-center">
                                        </div>                                
                                        <div class="col-lg-2 col-xs-2 text-center">
                                            <label style="font-weight: 600; color: #2471A3;">REFERENCIA</label>
                                            <input type="text" readonly='true' style="  background-color: #FFF3C3;"  id="Ref" name="Ref" class="form form-control text-center">
                                        </div>                                
                                    </div><br>
                                    <div class="row" style=" z-index: 100 !important">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4 text-center">
                                            <div class="" id="alert">
                                                <button type="button" class="close" data-dismiss="alert">x</button>
                                                <strong>Notificación: </strong>
                                                <div id="msg"></div>
                                            </div>   
                                        </div>
                                        <div class="col-md-4"></div>
                                    </div>
                                    <div class="row pull-center" style="margin: 5px;">
                                        <div class="col-lg-12 col-xs-12 text-center">                                                  
                                            <div id="tbFacturas" class="text-center"></div>                                           
                                        </div>
                                    </div>                               
                                    <hr> 
                                </form>
                            </div>                            
                        </div>
                        <div class="modal-footer">
                            <!--                <button type="button" class="close" data-dismiss="modal" style=" background-color: black;">&nbsp&nbsp;&times;&nbsp&nbsp;</button>-->
                        </div>
                    </div>
                </div>
            
                <div class='modal fade' id='respuesta' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header' style=' background-color: #2C3E50;'>
                            <h5 class='modal-title' id='exampleModalLabel' style='display:inline'></h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <center>
                            <h4><label> <span id="responsePago"></span></label></h4>
                            </center>
                        </div>
                        <div class='modal-footer'>
                            <center>
                                <button id="respuestaAsigPag" type='button' class='btn btn-primary' data-dismiss='modal'>Aceptar</button>                                
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        
        
        <!--******************************    Modal Asignar pago Usuario      *************************************-->
        <div class='modal fade' id='AsignaModalPago' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                          <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                              <div class='modal-header' style=' background-color: #2C3E50;'>
                                <h5 class='modal-title' id='exampleModalLabel' style='display:inline'></h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                  <span aria-hidden='true'>&times;</span>
                                </button>
                              </div>
                              <div class='modal-body'>
                                  <center>
                                    <h4><label> ¿Está seguro de asignar este pago al usuario <span id="usrModal" style=" color: red"></span>?</label></h4>
                                    <div class="row">
                                    <div class="col-lg-3 col-xs-3 text-center"></div>                        
                                    <div class="col-lg-6 col-xs-6 text-center">                        
                                        <label style="font-weight: 600; color: #2471A3;">TIPO REP</label>
                                        <select required="true" id="tipoREP" onchange="setREP()" name="tipoREP" class="form form-control">                                                                                              
                                            <option selected="true" value="1">POR FACTURA</option>
                                            <option  value="2" >POR PAGO</option>
                                        </select>                                                                                              
                                    </div>
                                    </div>
                                  </center>                                  
                              </div>
                              <div class='modal-footer'>
                                  <div class="row">
                                      <center>
                                <button type='button' class='btn btn-warning' data-target='#AsignaModalPago' data-toggle='modal' >Cancelar</button>
                                <button id="AsigPagoManBtn" type='button' class='btn btn-success' data-dismiss='modal' >Aceptar</button>
                                </center>
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>
	</section>
	</div>
		
	<?php include_once '../footer.html'; ?>
	
	<script language="JavaScript">
	function pregunta(){
		if (confirm('¿Estas seguro de IDENTIFICAR este PAGO? Ya NO podrás MODIFICARLO posteriormente.')){
		   document.form.submit();
		}
		else{ return false; }
	}
	</script> 
	
	<!--<script src="js/jquery-1.11.0.min.js"></script>--> 
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
	
	<script>
	$(document).ready(function() {
		$("#resultadoBusqueda").html('<p></p>');
	});

	function buscar() {
		var textoBusqueda = $("input#busqueda").val();
	 
		 if (textoBusqueda != "") {
			$.post("buscar_usuario.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
				$("#resultadoBusqueda").html(mensaje);
			 }); 
		 } else { 
			$("#resultadoBusqueda").html('<p></p>');
			};
	};
	</script>
	
	
        <script>
            
            function setREP(){
                $('#tipoREP2').val($('#tipoREP').val());
            }
              var $alerta = $("#alert");
                 var $msg = $('#msg');
                 
                 $alerta.hide();
                 $(".close").click(function () {
                   $alerta.hide();
                 });
                 
            function asignaPago(id_usuario,cont){  
                
                var id_pago = $("#IdPagoAsignado").val(); 
                var monto=$("#MontoPagoAsignado").val();
                var ayo_pago=$("#AyoPagoAsignado").val();
                
                $("#idAyoAsigna").val(ayo_pago); 
                $('#AsignaModalPago').modal('show');
                $("#idPagoAsigna").val(id_pago);
                $("#idFechaPago").val($("#fpmn").val());
                $("#idUsuario").val(id_usuario);   
                $("#montoAsigna").val(monto); 
                $("#montoPago").val(monto); 
                $("#Ref").val($("#rfps").val());                
                
                $("#AsigPagoManBtn").click( function(){
                    $('#AsignaModalPago').modal('hide');
                    var url = "<?php echo BASE_URL; ?>includes/pagos_acreditados/asigna_pago_usuario.php";
                        $.ajax({
                            type: "POST",
                            url: url,            
                            data: $("#validaPagos").serialize(),
                            dataType: "JSON",
                            success: function (data) {                                 
                                if(data[0]==1){
                                    $("#responsePago").text("Se a asignado el pago correctamente!");
                                    $("#idregistro").val(data[1]);
                                    $("#respuesta").modal('show');
                                    $("#respuestaAsigPag").click( function(){
                                       asignaPagoManual(id_usuario,cont,ayo_pago,id_pago); 
                                    });                                                                                       
                                }else if(data[0]==4){
                                    $("#responsePago").html("Ha ocurrido un problema al guardar el pago,<br> el usuario no tiene una cuenta bancaria activa!");                                      
                                }else if(data[0]==3){
                                    $("#responsePago").html("Ha ocurrido un problema al guardar el pago!");
                                }      
                                $("#respuesta").modal('show');
                            }
                        });       
                        
                    return false;             
                });


            }                                                
            
            function asignaPagoManual(id_usuario,cont,ayo_pago,id_pago){
                
                
//                 $("#usrModal").text(id_usuario);                
                $("#R_SOCIAL_P").text($("#"+cont+"rsocR").val());                                                                
                var monto=$("#MontoPagoAsignado").val();               
                $("#idFechaPago").val($("#fpmn").val());                                
                $("#montoAsigna").val(monto); 
                $("#montoPago").val(monto); 
                $("#montoAplicado").val(0); 
                $("#montoPorAplicar").val(monto);    
                $('#myModalCharts').modal('show');
                loadPagos(id_usuario,ayo_pago,id_pago)
            }
            
            function loadPagos(id_uduario,ayo_pago,id_pago){        
        var url = "<?php echo BASE_URL; ?>includes/pagos_acreditados/load_pagos.php";
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'html',
            data: {
                FACTURASDPT: 1,
                ID_USUARIO2:id_uduario,
                AYO_PAGO:ayo_pago,
                EXTERNO:1,
                ID_PAGO:id_pago
            },
            success: function (data) {
                $('#tbFacturas').html(data);                            
            }
        });

        return false;
    }
    
        function bancos(id_usuario) {
            console.log(id_usuario);
       var url = "<?php echo BASE_URL; ?>includes/admin_Cuenta/searchDatos.php";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                displayCuentas: 2,
                ID_USUARIO:id_usuario
            }, // Adjuntar los campos del formulario enviado.
            success: function (data)
            {                
                $("#noCuenta").html(data); // Mostrar la respuestas del script PHP.                
            }
        });
        
        return false;
    }
    
    
    function updateMPA(id,importe,pago,saldo){
           
    var mPAplicar=$("#montoPorAplicar").val();
    var mAplicado=$("#montoAplicado").val();
    var monto=$("#montoAsigna").val();
    var mAsignado=$('#F'+id).val();  
    $("#btnValida").removeAttr("disabled");
//    console.log(mPAplicar);
//    console.log(mAsignado);
//    console.log(monto);
//    console.log(mAsignado);
    
        var url = "<?php echo BASE_URL; ?>includes/pagos_solicitados/preAsignaPago.php";
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data:$("#validaPagos").serialize(),
            success: function (data)
            {                                
                
                if(data[0]==2){                    
                    $('#F'+id).val('');
                    $alerta.removeClass();
                    $alerta
                            .addClass('alert')
                            .addClass('alert-warning')
                            .addClass('alert-dismissible');
                    $msg.html('El monto que intenta asignar es superior al <b>MONTO POR APLICAR</b>!.');
                    $alerta.show();
                    setTimeout(function () {
                        $alerta.hide();                        
                    }, 5000);                    
                }else if(data[0]==1){                    
                    $("#montoAplicado").val(data[1]);
                    $("#montoPorAplicar").val(data[2]);
                    if(data[2]==0){
                        $("#montoPorAplicar").removeClass('bg-color-green')
                                 .removeClass('bg-color-red')
                                 .addClass('bg-color-Beige');
                    }
                }
                MontoPorAplica();
            }
        });
    
    return false;
}
           function guardaPago() {                           
        var url = "<?php echo BASE_URL; ?>includes/pagos_acreditados/savePagoAsignado.php";
        console.log($("#validaPagos").serialize());
        $.ajax({
            type: "POST",
            url: url,            
            data: $("#validaPagos").serialize(),
            success: function (data) {
                if(data==1){                    
                    $("#responsePago").text("Se a guardado correctamente el pago!");
                     $("#respuesta").modal('show');                                                                 
                        $("#enviar").click();                                        
                }else{
                    $("#responsePago").text("Ha ocurrido un problema al guardar el pago, intentelo nuevamente!");
                    $("#respuesta").modal('show'); 
//                     $("#enviar").click();  
                }
                
            }
        });       
        
        return false;            
    }
    
    
      function clearAsignaPago(){
        
        var numrows = $("#totalRows").val();
        
        for (var i = 1 ; i <= numrows ; i++ ){
            $('#F'+i).val('').prop("readonly", false); 
        }
        $("#montoPorAplicar").val($("#montoPago").val());        
        $("#montoAplicado").val(0);        
    }
    
    function MontoPorAplica(){        
         var numrows = $("#totalRows").val();
         var value = $("#montoPorAplicar").val();
         console.log(value);
        if(value == "0.00"){
            for (var i = 1 ; i <= numrows ; i++ ){
            $('#F'+i).prop("readonly", true);
        }
        }
    }
    
    function  laodPrepago(){
    
    var cont = $("#totalRows").val();
    var contenidoTb="";   
    var contador=1;
    for(var i =1; i <= cont; i++){
        
        var montoA =  $("#F"+i).val();        
        
        if(montoA!=""){
            
            var ayoFac = $("#AYO"+i).val();
            var idFac = $("#ID_FACTURA"+i).val();
            var importeVal = $("#importeVal"+i).val();
            var pagoVal = $("#pagoVal"+i).val();
            var saldoVal = $("#saldoVal"+i).val();
            var idPago=$("#idPagoAsigna").val();
            var idAyo=$("#idAyoAsigna").val();
            var estatus="PAGO PARCIAL";
            var comp1=0.00;
            var comp2=0.00;
            var bgColor="#FFC3C3";
            
            
            comp1=importeVal.replace(",","");
            comp2=montoA.replace(",","");
            
            console.log(parseFloat(comp1).toFixed(2));
            comp2=parseFloat(comp2).toFixed(2);
            
            if(parseFloat(comp1).toFixed(2) == comp2){
                estatus="PAGO TOTAL";
                bgColor="#C3FFD4";
            }
            
            contenidoTb +="<tr style='color:#004B97;font-weight: 600;'><td>"+contador+"</td><td>"+ayoFac+"</td><td>"+idFac+"</td><td>"+importeVal+"</td><td>"+pagoVal+"</td><td>"+saldoVal+"</td><td>"+idPago+"</td><td>"+idAyo+"</td><td>"+comp2.replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td style='background-color:"+bgColor+" '>"+estatus+"</td></tr>";
            
           contador++;
        }
       
    }
     $("#contenidoTb").html(contenidoTb);
    $("#exampleModal").modal("show");
    
    
}
        </script>