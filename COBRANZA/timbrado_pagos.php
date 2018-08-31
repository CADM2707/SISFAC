<?php
include_once '../config.php';
include_once '../head.html';
include_once '../menuLat.php';

@$ayo = $_REQUEST['ayo'];
@$sector = $_REQUEST['sector'];
@$del = $_REQUEST['del'];
@$al = $_REQUEST['al'];
@$que_tipo = $_REQUEST['tipoi'];
@$idusuario = $_REQUEST['idusuario'];
@$facturai = $_REQUEST['facturai'];

$f_del = date("Y/m/d", strtotime($del));
$f_al = date("Y/m/d", strtotime($al));

if($ayo != ""){ @$q_ayo = " AND AYO_PAGO=$ayo "; } else { @$q_ayo = ""; }
if($sector != ""){ @$q_sector = " AND SECTOR=$sector "; } else { @$q_sector = ""; }
if($del != "" and $al != ""){  @$q_fecha = " AND (FECHA_APLICADO between '$f_del' and '$f_al') "; } else { @$q_fecha = ""; }
if(@$idusuario != 0){ $q_usuario = " AND ID_USUARIO = '$idusuario' "; } else{ $q_usuario = ""; }
if(@$facturai != 0){ $q_factura = " AND T1.ID_FACTURA = $facturai "; } else{ $q_factura = ""; }

if(@$que_tipo == 0){ 
   @$q_tipo = " AND CVE_PAGO_SIT IN (2) "; 
   @$q_tipoc = " UNION
                select T1.SECTOR,T1.AYO,T1.ID_FACTURA,T2.AYO_PAGO,T2.ID_PAGO,T2.MONTO_APLICADO,T2.FECHA_APLICADO,T1.ID_USUARIO,T1.R_SOCIAL,CVE_PAGO_SIT
			    FROM Factura T1
			    INNER JOIN Pago_Factura T2 ON T1.AYO=T2.AYO AND T1.ID_FACTURA =T2.ID_FACTURA
			    WHERE  T1.CVE_TIPO_FACTURA<11 and CVE_PAGO_SIT IN (3)
			    $q_ayo $q_sector $q_fecha $q_usuario $q_factura 
				and T1.ID_FACTURA in (select ID_FACTURA FROM [Facturacion].[dbo].[BitacoraTimbrado] BT where BT.ID_FACTURA = T1.ID_FACTURA and BT.AYO = T1.AYO AND TIMBRADO=2) ";
	@$q_tipod = "";
}
if(@$que_tipo == 2){ @$q_tipo = " AND CVE_PAGO_SIT IN (2) "; $q_tipoc = ""; $q_tipod = ""; }
if(@$que_tipo == 3){ 
   @$q_tipo = " AND CVE_PAGO_SIT IN (3) "; 
   @$q_tipod = " and T1.ID_FACTURA in (select ID_FACTURA FROM [Facturacion].[dbo].[BitacoraTimbrado] BT where BT.ID_FACTURA = T1.ID_FACTURA and BT.AYO = T1.AYO AND TIMBRADO=2) ";
   @$q_tipoc = "";
}

$sql_lista="select T1.SECTOR,T1.AYO,T1.ID_FACTURA,T2.AYO_PAGO,T2.ID_PAGO,T2.MONTO_APLICADO,T2.FECHA_APLICADO,T1.ID_USUARIO,T1.R_SOCIAL,CVE_PAGO_SIT
			FROM Factura T1
			INNER JOIN Pago_Factura T2 ON T1.AYO=T2.AYO AND T1.ID_FACTURA =T2.ID_FACTURA
			WHERE  T1.CVE_TIPO_FACTURA<11 AND CVE_PAGO_SIT=5
			$q_tipo $q_ayo $q_sector $q_fecha $q_usuario $q_factura
			$q_tipoc
			$q_tipod
			ORDER BY T1.AYO DESC,T1.ID_FACTURA DESC";
$res_lista = sqlsrv_query($conn,$sql_lista);
$cuantos_son = sqlsrv_has_rows($res_lista);

$sql_ayo="select DISTINCT(ayo)  from seCTOR.DBO.C_PERIODO_QNAS ORDER BY AYO DESC";
$res_ayo = sqlsrv_query($conn,$sql_ayo);

$sql_qna="select DISTINCT(Qna)  from seCTOR.DBO.C_PERIODO_QNAS";
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
				TIMBRADO PAGOS REP
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
					  <td align="center" width="8%">
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
					  <td align="center" width="8%">
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
								<center><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FACTURA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></center>
								<input type="text" name="facturai"  value="<?php echo @$facturai;?>" id="facturai" class="form-control" style="text-align:center;" />
					  </td>
					  <td width="5%">&nbsp;</td>
					  <td align="center" width="11%">
					        <center><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TIPO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></center>
							<select name="tipoi" class="form-control" style="text-align:center;"  id="tipoi" />
								<option value="0">SELECC...</option>
								<?php 
								      if(@$_REQUEST['tipoi'] == 2){ @$t2 = "selected='selected'";  @$t3 = ""; } 
								      if(@$_REQUEST['tipoi'] == 3){ @$t3 = "selected='selected'";  @$t2 = ""; }
								?>
									 <option value="2" <?php echo @$t2; ?>>PARA TIMBRAR</option>
									 <option value="3" <?php echo @$t3; ?>>PARA DESCARGAR</option>
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

				<?php if(@$_REQUEST["enviar"] == "Buscar"){ ?>
				<?php if($cuantos_son === true){ ?>
				<br>
                
				<form action="" method="post" name="timbrar" id="timbrar">
				<table class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:12px;'>
					<thead>
					  <tr>
					    <td align="center" class="bg-primary"><b>#</b></td>
					    <td align="center" class="bg-primary"><b>SECTOR</b></td>
						<td align="center" class="bg-primary"><b>AÑO FACTURA</b></td>
						<td align="center" class="bg-primary"><b>FACTURA</b></td>
						<td align="center" class="bg-primary"><b>AÑO PAGO</b></td>
						<td align="center" class="bg-primary"><b>ID PAGO</b></td>
						<td align="center" class="bg-primary"><b>MONTO</b></td>
						<td align="center" class="bg-primary"><b>FECHA DE APLICACIÓN</b></td>
						<td align="center" class="bg-primary"><b>USUARIO</b></td>
						<td align="center" class="bg-primary"><b>RAZÓN SOCIAL</b></td>
						<td align="center" class="bg-primary"><b></b></td>
					  </tr>
					</thead>
					  <tbody>				
				<?php
					$i=1;
					$tim = 1;
					while($row_lista = sqlsrv_fetch_array($res_lista)){
						  if($i%2==0){ $color="#E1EEF4"; } else{ $color="#FFFFFF"; }

				?>
						<tr bgcolor="<?php echo $color; ?>">
						    <td><?php echo $i; ?></td>
							<td><?php echo $row_lista['SECTOR']; ?></td>
							<td><?php echo $row_lista['AYO']; ?></td>
							<td><?php echo $row_lista['ID_FACTURA']; ?></td>
							<td><?php echo $row_lista['AYO_PAGO']; ?></td>
							<td><?php echo $row_lista['ID_PAGO']; ?></td>
							<td><?php echo number_format($row_lista['MONTO_APLICADO'],2); ?></td>
							<td><?php echo date_format($row_lista['FECHA_APLICADO'], 'd/m/Y'); ?></td>
							<td><?php echo $row_lista['ID_USUARIO']; ?></td>
							<td><?php echo utf8_encode($row_lista['R_SOCIAL']); ?></td>
							
							<?php if($row_lista['CVE_PAGO_SIT'] == 2){ ?>
							<td><input name="sube" id="sube" type="submit" value="GENERAR TXT" class="btn btn-primary btn-sm center-block" onclick="actualizar();" formaction="archivotimbrado.php?tipo=1&ayo_fac=<?php echo $row_lista['AYO']; ?>&fol_fac=<?php echo $row_lista['ID_FACTURA']; ?>&ayo_pag=<?php echo $row_lista['AYO_PAGO']; ?>&fol_pag=<?php echo $row_lista['ID_PAGO']; ?>" /></td>
							<?php $tim++; } if($row_lista['CVE_PAGO_SIT'] == 3){ ?>
							<td><input name="sube" id="sube" type="submit" value="DESCARGAR TXT" class="btn btn-success btn-sm center-block" onclick="actualizar();" formaction="archivotimbrado.php?tipo=2&ayo_fac=<?php echo $row_lista['AYO']; ?>&fol_fac=<?php echo $row_lista['ID_FACTURA']; ?>&ayo_pag=<?php echo $row_lista['AYO_PAGO']; ?>&fol_pag=<?php echo $row_lista['ID_PAGO']; ?>" /></td>
							<?php } ?>
							
						</tr>
				<?php $i++; } $masi = $i*444; ?>
				
				<?php if($tim == $i AND $tim > 5){ ?>
				<tr><td colspan='10'><center><br><br>&nbsp;</td>
				<td><center><br>
				<input type="submit" name="gmasivo" value="GENERAR TXT MASIVO" class="btn btn-info btn-sm center-block" onclick="actualizarm();" formaction="archivomasivo.php?Ayo=<?php echo $ayo; ?>&Sector=<?php echo $sector; ?>&Del=<?php echo $del; ?>&Al=<?php echo $al; ?>&tipoi=<?php echo $que_tipo; ?>&idusuario=<?php echo $idusuario; ?>&facturai=<?php echo $facturai; ?>">
				<br></center>
				</td>
				</tr>
				<?php } ?>

				</tbody>
				</table>
				</form>
				<?php } else{ ?>
				<br><div class='alert alert-danger'> <font style='font-size:16px;'> <b> NO EXISTEN REGISTROS </b> </font> </div>
				<?php } } ?>

				<!-- ------------------------ fin area de trabajo ------------------------ -->
			</div>
		</div>
	</section>
	</div>

	<?php include_once '../footer.html'; ?>
	
	<script>
	function actualizar(){ 
		window.location.reload(); 
		setTimeout ("actualizar()", 1500);
	}
	
	function actualizarm(){ 
		window.location.reload(); 
		setTimeout ("actualizarm()", <?php echo $masi; ?>);
	}
    </script>
