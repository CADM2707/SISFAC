<?php
include_once '../config.php';
include_once '../head.html';
include_once '../menuLat.php';

@$ayo = $_REQUEST['ayo'];
@$sector = $_REQUEST['sector'];
@$del = $_REQUEST['del'];
@$al = $_REQUEST['al'];

$f_del = date("d/m/Y", strtotime($del));
$f_al = date("d/m/Y", strtotime($al));

if($ayo != ""){ @$q_ayo = " AND AYO_PAGO=$ayo "; } else { @$q_ayo = ""; }
if($sector != ""){ @$q_sector = " AND SECTOR=$sector "; } else { @$q_sector = ""; }
if($del != "" and $al != ""){  @$q_fecha = " AND FECHA_APLICADO BETWEEN '$f_del' AND '$f_al' "; } else { @$q_fecha = ""; }

$sql_lista="select T1.SECTOR,T1.AYO,T1.ID_FACTURA,T2.AYO_PAGO,T2.ID_PAGO,T2.MONTO_APLICADO,T2.FECHA_APLICADO,T1.ID_USUARIO,T1.R_SOCIAL,CVE_PAGO_SIT
			FROM Factura T1
			INNER JOIN Pago_Factura T2 ON T1.AYO=T2.AYO AND T1.ID_FACTURA =T2.ID_FACTURA
			WHERE  T1.CVE_TIPO_FACTURA<11
			AND CVE_PAGO_SIT IN (2,3) $q_ayo $q_sector $q_fecha
			ORDER BY T1.AYO DESC,T1.ID_FACTURA";
$res_lista = sqlsrv_query($conn,$sql_lista);
$cuantos_son = sqlsrv_has_rows($res_lista);

$sql_ayo="select DISTINCT(ayo)  from seCTOR.DBO.C_PERIODO_QNAS";
$res_ayo = sqlsrv_query($conn,$sql_ayo);

$sql_qna="select DISTINCT(Qna)  from seCTOR.DBO.C_PERIODO_QNAS";
$res_qna = sqlsrv_query($conn,$sql_qna);

$sql_sector="select SECTOR from sector.dbo.C_Sector where SECTOR>50 GROUP BY SECTOR ORDER BY SECTOR";
$res_sector = sqlsrv_query($conn,$sql_sector);
?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper" style=" background-color: white;">
		<!--Titulos de encabezado de la pagina-->
		<section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
			<h1>
				TIMBRADO PAGOS (REP)
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
				<table align="center" border="0" width="70%">
					<tr>
					  <td align="center" width="11%">
					      <center><label>SECTOR:</label></center>
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
					  <td align="center" width="11%">
					        <center><label>AÑO:</label></center>
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
								<center><label>DEL:</label></center>
								<input type="date" name="del"  value="<?php echo $del;?>" id="del"  style="text-align:center;" onchange="es_vacio3()" class="form-control" >
					  </td>
					  <td width="5%">&nbsp;</td>
					  <td align="center" width="11%">
								<center><label>AL:</label></center>
								<input type="date" name="al"  value="<?php echo $al;?>" id="al" style="text-align:center;" onchange="es_vacio4()"  class="form-control" >
					  </td>
					</tr>

					<tr>
					  <td colspan="7"><br>
						  <input name="enviar" id="enviar" type="submit" value="Buscar" class="btn btn-primary" />
					  </td>
					</tr>
				 </table>
				</form>

				<?php if(@$_REQUEST["enviar"] == "Buscar"){ ?>
				<?php if($cuantos_son === true){ ?>
				<br>

				<table class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:12px;'>
					<thead>
					  <tr>
						<td align="center" class="bg-primary"><b>SECTOR</td>
						<td align="center" class="bg-primary"><b>AÑO FACTURA</td>
						<td align="center" class="bg-primary"><b>FACTURA</td>
						<td align="center" class="bg-primary"><b>AÑO PAGO</td>
						<td align="center" class="bg-primary"><b>ID PAGO</td>
						<td align="center" class="bg-primary"><b>MONTO</td>
						<td align="center" class="bg-primary"><b>FECHA DE APLICACIÓN</td>
						<td align="center" class="bg-primary"><b>USUARIO</td>
						<td align="center" class="bg-primary"><b>RAZÓN SOCIAL</td>
					  </tr>
					</thead>
					  <tbody>				
				<?php
					$i=1;
					while($row_lista = sqlsrv_fetch_array($res_lista)){
						  if($i%2==0){ $color="#E1EEF4"; } else{ $color="#FFFFFF"; }

				?>
						<tr bgcolor="<?php echo $color; ?>">
							<td><?php echo $row_lista['SECTOR']; ?>
							<td><?php echo $row_lista['AYO']; ?>
							<td><?php echo $row_lista['ID_FACTURA']; ?>
							<td><?php echo $row_lista['AYO_PAGO']; ?>
							<td><?php echo $row_lista['ID_PAGO']; ?>
							<td><?php echo number_format($row_lista['MONTO_APLICADO'],2); ?>
							<td><?php echo date_format($row_lista['FECHA_APLICADO'], 'd/m/Y'); ?>
							<td><?php echo $row_lista['ID_USUARIO']; ?>
							<td><?php echo utf8_encode($row_lista['R_SOCIAL']); ?>
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
