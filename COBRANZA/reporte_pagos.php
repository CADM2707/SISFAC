<?php
include_once '../config.php';
include_once '../head.html';
include_once '../menuLat.php';

$sql_ayo = "select DISTINCT(AYO_PAGO)  FROM [Facturacion].[dbo].[Pago] ORDER BY AYO_PAGO DESC";
$res_ayo = sqlsrv_query($conn,$sql_ayo);

$sql_sector = "select SECTOR from sector.dbo.C_Sector where SECTOR>50 GROUP BY SECTOR ORDER BY SECTOR";
$res_sector = sqlsrv_query($conn,$sql_sector);

$sql_tpago = "SELECT TP.CVE_PAGO_TIPO, DESCRIPCION FROM 
			 [Facturacion].[dbo].[C_Pago_Tipo] TP
			 inner join [Facturacion].[dbo].[Pago] PA on PA.CVE_PAGO_TIPO = TP.CVE_PAGO_TIPO
			 GROUP BY TP.CVE_PAGO_TIPO, DESCRIPCION
			 ORDER BY TP.CVE_PAGO_TIPO";
$res_tpago = sqlsrv_query($conn,$sql_tpago);

$sql_spago = "SELECT PS.CVE_PAGO_SIT, PS.DESCRIPCION 
			 FROM [Facturacion].[dbo].[C_Pago_Situacion] PS
			 inner join [Facturacion].[dbo].[Pago] PA on PA.CVE_PAGO_SIT = PS.CVE_PAGO_SIT
			 GROUP BY PS.CVE_PAGO_SIT, PS.DESCRIPCION
			 ORDER BY PS.CVE_PAGO_SIT";
$res_spago = sqlsrv_query($conn,$sql_spago);
?>
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper" style=" background-color: white;">
		<!--Titulos de encabezado de la pagina-->
		<section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
			<h1>
				REPORTE DE PAGOS
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
				<table align="center" border="0" width="100%">
					<tr>
					  <td align="center">
					      <center><label>SECTOR</label></center>
						  <select name="sector" class="form-control" id="sector">
								<option value="" selected="selected">SELECC...</option>
								<?php while($row_sector = sqlsrv_fetch_array($res_sector)){ ?>
								         <option value="<?php echo @$row_sector['SECTOR']; ?>"><?php echo @$row_sector['SECTOR']; ?></option>
						        <?php } ?>
						   </select>
					  </td>
					  <td width="2%">&nbsp;</td>
					  <td align="center">
					        <center><label>AÑO</label></center>
							<select name="ayo" class="form-control" style="text-align:center;"  onchange="es_vacio()"   id="ayo"  onBlur="es_vacio()" >
								<option value="">SELECC...</option>
								<?php while($row_ayo = sqlsrv_fetch_array($res_ayo)){ ?>
								         <option value="<?php echo @$row_ayo['AYO_PAGO']; ?>"><?php echo @$row_ayo['AYO_PAGO']; ?></option>
						        <?php } ?>
							</select>
					  </td>
					  <td width="2%">&nbsp;</td>
					  <td align="center" width="7%">
								<center><label>DEL</label></center>
								<input type="date" name="del"  value="<?php echo $del;?>" id="del"  style="text-align:center;" onchange="es_vacio3()" class="form-control" >
					  </td>
					  <td width="2%">&nbsp;</td>
					  <td align="center" width="7%">
								<center><label>AL</label></center>
								<input type="date" name="al"  value="<?php echo $al;?>" id="al" style="text-align:center;" onchange="es_vacio4()"  class="form-control" >
					  </td>
					  <td width="2%">&nbsp;</td>
					  <td align="center"  width="9%">
								<center><label>ID USUARIO</label></center>
								<input type="text" name="idusuario"  value="<?php echo @$idusuario;?>" id="idusuario" class="form-control" style="text-align:center;">
					  </td>
					  <td width="2%">&nbsp;</td>
					  <td align="center">
					        <center><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TIPO PAGO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></center>
							<select name="tpago" class="form-control" style="text-align:center;"  id="tpago" />
								<option value="">SELECC...</option>
								<?php while($row_tpago = sqlsrv_fetch_array($res_tpago)){ ?>
								         <option value="<?php echo @$row_tpago['CVE_PAGO_TIPO']; ?>"><?php echo strtoupper(utf8_encode(@$row_tpago['DESCRIPCION'])); ?></option>
						        <?php } ?>
							</select>
					  </td>
					  <td width="2%">&nbsp;</td>
					  <td align="center">
					        <center><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SITUACIÓN PAGO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></center>
							<select name="spago" class="form-control" style="text-align:center;"  id="spago" />
								<option value="">SELECC...</option>
								<?php while($row_spago = sqlsrv_fetch_array($res_spago)){ ?>
								         <option value="<?php echo @$row_spago['CVE_PAGO_SIT']; ?>"><?php echo strtoupper(utf8_encode(@$row_spago['DESCRIPCION'])); ?></option>
						        <?php } ?>
							</select>
					  </td>
                    </tr>
					 </table>
					
					<br><br>
					
					<table align="center" border="0" width="88%">
					<tr align="center">
						<td width="50%"><br /></td>      
					</tr>
					
					<tr align="left">
						<td width="50%"><input type="checkbox" onclick="marcar(this);" /> <font face="Tahoma, Geneva, sans-serif" color="#003366" size="2"><b>Marcar/Desmarcar Todos</b></font></td>      
					</tr>
					
					<tr align="center" class="th_solo">
						<td width="50%"><font face="Tahoma, Geneva, sans-serif" color="#003366" size="3"><b>Selecciona los campos a exportar</b></font> <br><br><br> </td>						
					</tr>
					<tr align="center">
						<td>
						<table align="center" width="99%" border="0">
						
						<?php
						$sql_datos = "select top 1 * FROM [Facturacion].[dbo].[Pago]";
						$res_datos = sqlsrv_query($conn,$sql_datos);
						$i = 0;
						foreach(sqlsrv_field_metadata($res_datos) as $fieldMetadata){
						        if($i == 0){ echo "<tr>"; }
                                foreach($fieldMetadata as $name => $value) {
								     if($name == "Name"){
						?>   
										<td>
										<input type="checkbox" value="<?php echo $value; ?>" name="DATOS-<?php echo $value; ?>" /> 
										<?php echo str_replace("_", " ", $value); ?>
										</td>
						<?php
								     }
							    }
								$i++;
								if($i == 7){ echo "</tr>"; $i = 0; }
						 } 
						 ?> 
						</tr>
						</table> 
						</td>
					</tr>
					
					<tr align="center">
						<td colspan="3">
						<br /><br /><br />
						<input type="submit" name="exportar" id="exportar" value="Exportar Datos" class="btn btn-primary" formtarget="_blank" formaction="exporta_reporte_pagos.php">
						<br /><br />
						</td>
					</tr>
					</table>
					
			</form>
                
				

				<!-- ------------------------ fin area de trabajo ------------------------ -->
			</div>
		</div>
	</section>
	</div>
		
	<?php include_once '../footer.html'; ?>
	
	<script type="text/javascript">
	function marcar(source) 
	{
		checkboxes=document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
		for(i=0;i<checkboxes.length;i++) //recoremos todos los controles
		{
			if(checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
			{
				checkboxes[i].checked=source.checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
			}
		}
	}
	</script>