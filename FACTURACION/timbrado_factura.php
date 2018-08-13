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

if($ayo != ""){ @$q_ayo = " AND AYO=$ayo "; } else { @$q_ayo = ""; }
if($sector != ""){ @$q_sector = " AND SECTOR=$sector "; } else { @$q_sector = ""; }
if($del != "" and $al != ""){  @$q_fecha = " AND (PERIODO_INICIO between '$f_del' and '$f_al' AND PERIODO_FIN between '$f_del' and '$f_al') "; } else { @$q_fecha = ""; }
if(@$idusuario != 0){ $q_usuario = " AND ID_USUARIO = '$idusuario' "; } else{ $q_usuario = ""; }
if(@$facturai != 0){ $q_factura = " AND ID_FACTURA = $facturai "; } else{ $q_factura = ""; }

if(@$que_tipo == 0){ 
   @$q_tipo = " CVE_SITUACION IN (4) "; 
   @$q_tipoc = " UNION
                SELECT AYO,ID_FACTURA,SECTOR,ID_USUARIO,R_SOCIAL,TOTAL_REDONDEADO,CVE_SITUACION,PERIODO_INICIO,PERIODO_FIN
			    FROM Factura FA
			    WHERE CVE_SITUACION IN (5) $q_ayo $q_sector $q_fecha $q_usuario $q_factura 
				and ID_FACTURA in (select ID_FACTURA FROM [Facturacion].[dbo].[BitacoraTimbrado] BT where BT.ID_FACTURA = FA.ID_FACTURA and BT.AYO = FA.AYO AND TIMBRADO=1)";
	@$q_tipod = "";
}
if(@$que_tipo == 4){ @$q_tipo = " CVE_SITUACION IN (4) "; $q_tipoc = ""; $q_tipod = ""; }
if(@$que_tipo == 5){ 
   @$q_tipo = " CVE_SITUACION IN (5) "; 
   @$q_tipod = " and FA.ID_FACTURA in (select ID_FACTURA FROM [Facturacion].[dbo].[BitacoraTimbrado] BT where BT.ID_FACTURA = FA.ID_FACTURA and BT.AYO = FA.AYO AND TIMBRADO=1) ";
   @$q_tipoc = "";
}

$sql_lista="SELECT AYO,ID_FACTURA,SECTOR,ID_USUARIO,R_SOCIAL,TOTAL_REDONDEADO,CVE_SITUACION,PERIODO_INICIO,PERIODO_FIN
			FROM Factura FA
			WHERE $q_tipo $q_ayo $q_sector $q_fecha $q_usuario $q_factura
			$q_tipoc
			$q_tipod
			order by AYO desc, ID_FACTURA desc";
$res_lista = sqlsrv_query($conn,$sql_lista);
$cuantos_son = sqlsrv_has_rows($res_lista);

$sql_ayo="select DISTINCT(ayo)  from seCTOR.DBO.C_PERIODO_QNAS ORDER BY AYO DESC";
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
				TIMBRADO FACTURAS
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
								      if(@$_REQUEST['tipoi'] == 4){ @$t4 = "selected='selected'";  @$t5 = ""; } 
								      if(@$_REQUEST['tipoi'] == 5){ @$t5 = "selected='selected'";  @$t4 = ""; }
								?>
									 <option value="4" <?php echo @$t4; ?>>PARA TIMBRAR</option>
									 <option value="5" <?php echo @$t5; ?>>PARA DESCARGAR</option>
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
						<td align="center" class="bg-primary"><b>AÑO</b></td>
						<td align="center" class="bg-primary"><b>FACTURA</b></td>
						<td align="center" class="bg-primary"><b>SECTOR</b></td>
						<td align="center" class="bg-primary"><b>ID USUARIO</b></td>
						<td align="center" class="bg-primary"><b>RAZÓN SOCIAL</b></td>
						<td align="center" class="bg-primary"><b>TOTAL REDONDEADO</b></td>
						<td align="center" class="bg-primary"><b>PERIODO INICIO</b></td>
						<td align="center" class="bg-primary"><b>PERIODO FIN</b></td>
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
							<td><?php echo $row_lista['AYO']; ?></td>
							<td><?php echo $row_lista['ID_FACTURA']; ?></td>
							<td><?php echo $row_lista['SECTOR']; ?></td>
							<td><?php echo $row_lista['ID_USUARIO']; ?></td>
							<td><?php echo utf8_encode($row_lista['R_SOCIAL']); ?></td>
							<td><?php if($row_lista['TOTAL_REDONDEADO'] != ""){ echo number_format($row_lista['TOTAL_REDONDEADO'],2); } ?></td>
							<td><?php if($row_lista['PERIODO_INICIO'] != ""){ echo date_format($row_lista['PERIODO_INICIO'], 'Y/m/d'); } ?></td>
							<td><?php if($row_lista['PERIODO_FIN'] != ""){ echo date_format($row_lista['PERIODO_FIN'], 'Y/m/d'); } ?></td>
							
							<?php if($row_lista['CVE_SITUACION'] == 4){ ?>
							<td><input name="sube" id="sube" type="submit" value="GENERAR TXT" class="btn btn-primary btn-sm center-block" onclick="actualizar();" formaction="archivotimbrado.php?tipo=1&ayo=<?php echo $row_lista['AYO']; ?>&recibo=<?php echo $row_lista['ID_FACTURA']; ?>" /></td>
							<?php $tim++; } if($row_lista['CVE_SITUACION'] == 5){ ?>
							<td><input name="sube" id="sube" type="submit" value="DESCARGAR TXT" class="btn btn-success btn-sm center-block" onclick="actualizar();" formaction="archivotimbrado.php?tipo=2&ayo=<?php echo $row_lista['AYO']; ?>&recibo=<?php echo $row_lista['ID_FACTURA']; ?>" /></td>
							<?php } ?>
							
						</tr>
				<?php $i++; } $masi = $i*115; ?>
				
				<?php if($tim == $i AND $tim > 5){ ?>
				<tr><td colspan='9'><center><br><br>&nbsp;</td>
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
