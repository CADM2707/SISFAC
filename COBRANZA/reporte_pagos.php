<?php
include_once '../config.php';
include_once '../head.html';
include_once '../menuLat.php';

@$ayo = $_REQUEST['ayo'];
@$sector = $_REQUEST['sector'];
@$del = $_REQUEST['del'];
@$al = $_REQUEST['al'];
@$idusuario = trim($_REQUEST['idusuario']);

$f_del = date("Y/m/d", strtotime($del));
$f_al = date("Y/m/d", strtotime($al));


$sql_ayo="select DISTINCT(AYO_PAGO)  FROM [Facturacion].[dbo].[Pago] ORDER BY AYO_PAGO DESC";
$res_ayo = sqlsrv_query($conn,$sql_ayo);

$sql_sector="select SECTOR from sector.dbo.C_Sector where SECTOR>50 GROUP BY SECTOR ORDER BY SECTOR";
$res_sector = sqlsrv_query($conn,$sql_sector);
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
                                      if($row_ayo['AYO_PAGO'] == $_REQUEST['ayo']){
								?>
									     <option value="<?php echo @$row_ayo['AYO_PAGO']; ?>" selected="selected"><?php echo @$row_ayo['AYO_PAGO']; ?></option>
								<?php
								      }
                                      else{
							    ?>
								         <option value="<?php echo @$row_ayo['AYO_PAGO']; ?>"><?php echo @$row_ayo['AYO_PAGO']; ?></option>
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
						<td width="50%"><font face="Tahoma, Geneva, sans-serif" color="#003366" size="3"><b>Selecciona los campos a Exportar</b></font> <br><br><br> </td>						
					</tr>
					<tr align="center">
						<td>
						<table align="center" width="99%" border="0">
						
						<?php
						$sql_datos = "select * FROM [Facturacion].[dbo].[Pago]";
						$res_datos = sqlsrv_query($conn,$sql_datos);
						$i = 0;
						foreach(sqlsrv_field_metadata($res_datos) as $fieldMetadata){
						        if($i == 0){ echo "<tr>"; }
                                foreach($fieldMetadata as $name => $value) {
								     if($name == "Name"){
						?>   
										<td>
										<input type="checkbox" value="<?php echo $value; ?>" name="DATOS-<?php echo $value; ?>" /> 
										<?php echo $value; ?>
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