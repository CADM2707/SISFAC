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

$sql_lista="select ID_PAGO,AYO_PAGO,CVE_PAGO_TIPO,MONTO,Cast(FECHA_PAGO As Date) as FECHA_PAGO,REFERENCIA,OBSERVACION,ID_BANCO,SUCURSAL,ID_USUARIO,CVE_PAGO_SIT
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
?>

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
				?>
						<tr bgcolor="<?php echo $color; ?>">
						    <td><?php echo $i; ?></td>
							<td><?php echo $row_lista['AYO_PAGO']; ?></td>
							<td><?php echo number_format($row_lista['MONTO'],2); ?></td>
							<td><?php if($row_lista['FECHA_PAGO'] != ""){ echo date_format($row_lista['FECHA_PAGO'], 'd/m/Y'); }  ?></td>
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
										<input name="sube" id="sube" type="submit" value="ASIGNAR PAGO A USUARIO" class="btn btn-primary btn-sm center-block" />
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
						<td><b><?php echo $row_datos['AYO_PAGO']; ?></b></td>
						<td><b><?php echo number_format($row_datos['MONTO'],2); ?></b></td>
						<td><b><?php if($row_datos['FECHA_PAGO'] != ""){ echo date_format($row_datos['FECHA_PAGO'], 'd/m/Y'); }  ?></b></td>
						<td><b><?php echo utf8_encode(str_replace("/", "", $row_datos['REFERENCIA'])); ?></b></td>
						<td><b><?php echo utf8_encode(str_replace("/", "", $row_datos['OBSERVACION'])); ?></b></td>
						<td><b><?php echo $row_tpago1['DESCRIPCION'];  ?></b></td>
						<td><b><?php echo $row_cbanco1['BANCO']; ?></b></td>
						<td><b><?php echo $row_datos['SUCURSAL']; ?></b></td>
						
						<?php if($row_datos['CVE_PAGO_SIT'] == 2){ ?>
						<td><?php echo $row_usuario['ID_USUARIO']; ?></td>
						<td><?php echo utf8_encode($row_usuario['R_SOCIAL']); ?></td>
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
				<table align="center" border="0" width="11%">
				  <tr><td>
				    <input type="hidden" name="enviar" value="Buscar" />
					<input type="hidden" name="ayo" value="<?php echo $ayo; ?>" />
					<input type="hidden" name="del" value="<?php echo $del; ?>" />
					<input type="hidden" name="al" value="<?php echo $al; ?>" />
					<input type="hidden" name="tipoi" value="<?php echo $que_tipo; ?>" />
					<input type="hidden" name="referenciai" value="<?php echo $referenciai; ?>" />
					<input type="hidden" name="montop" value="<?php echo $montop; ?>" />
					<input type="hidden" name="identificar" value="<?php echo $_REQUEST["identificar"]; ?>" />	
										
				    <input type="text" name="busqueda" id="busqueda" value="" placeholder="" maxlength="11" autocomplete="off" class="form-control" style="text-align:center;" onKeyUp="buscar();" />
				  </td></tr>
				</table>
				<div id="resultadoBusqueda"></div>
				</form>
				<?php } ?>
				
				<?php } ?>

				<!-- ------------------------ fin area de trabajo ------------------------ -->
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
	
	
	