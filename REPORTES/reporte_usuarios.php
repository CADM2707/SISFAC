<?php
include_once '../config.php';
include_once '../head.html';
include_once '../menuLat.php';

$sql_sector = "select SECTOR from sector.dbo.C_Sector where SECTOR>50 GROUP BY SECTOR ORDER BY SECTOR";
$res_sector = sqlsrv_query($conn,$sql_sector);

$sql_situacion = "select CVE_SITUACION, SITUACION  FROM [Facturacion].[dbo].[V_usuario_padron] group BY CVE_SITUACION, SITUACION order by CVE_SITUACION";
$res_situacion = sqlsrv_query($conn,$sql_situacion);

$sql_region = "select ID_REGION, REGION  FROM [Facturacion].[dbo].[V_usuario_padron] where ID_REGION <> 0  group BY ID_REGION, REGION order by ID_REGION";
$res_region = sqlsrv_query($conn,$sql_region);

$sql_tusuario = "select CVE_TIPO_USUARIO, TIPO_USUARIO  FROM [Facturacion].[dbo].[V_usuario_padron] group BY CVE_TIPO_USUARIO, TIPO_USUARIO order by CVE_TIPO_USUARIO";
$res_tusuario = sqlsrv_query($conn,$sql_tusuario);

$sql_tsector = "select CVE_SECTOR, TIPO_SECTOR  FROM [Facturacion].[dbo].[V_usuario_padron] group BY CVE_SECTOR, TIPO_SECTOR order by CVE_SECTOR";
$res_tsector = sqlsrv_query($conn,$sql_tsector);
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
				REPORTE DE USUARIOS
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
					        <center><label>SITUACIÓN</label></center>
							<select name="situacion" class="form-control" style="text-align:center;"  onchange="es_vacio()"   id="situacion"  onBlur="es_vacio()" >
								<option value="">SELECC...</option>
								<?php while($row_situacion = sqlsrv_fetch_array($res_situacion)){ ?>
								         <option value="<?php echo @$row_situacion['CVE_SITUACION']; ?>"><?php echo @$row_situacion['SITUACION']; ?></option>
						        <?php } ?>
							</select>
					  </td>
					  <td width="2%">&nbsp;</td>
					  <td align="center">
					        <center><label>REGIÓN</label></center>
							<select name="region" class="form-control" style="text-align:center;"  onchange="es_vacio()"   id="region"  onBlur="es_vacio()" >
								<option value="">SELECC...</option>
								<?php while($row_region = sqlsrv_fetch_array($res_region)){ ?>
								         <option value="<?php echo @$row_region['ID_REGION']; ?>"><?php echo @$row_region['REGION']; ?></option>
						        <?php } ?>
							</select>
					  </td>
					  <td width="2%">&nbsp;</td>
					  <td align="center">
					        <center><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TIPO USUARIO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></center>
							<select name="tusuario" class="form-control" style="text-align:center;"  id="tusuario" />
								<option value="">SELECC...</option>
								<?php while($row_tusuario = sqlsrv_fetch_array($res_tusuario)){ ?>
								         <option value="<?php echo @$row_tusuario['CVE_TIPO_USUARIO']; ?>"><?php echo strtoupper(utf8_encode(@$row_tusuario['TIPO_USUARIO'])); ?></option>
						        <?php } ?>
							</select>
					  </td>
					  <td width="2%">&nbsp;</td>
					  <td align="center">
					        <center><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TIPO DE SECTOR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></center>
							<select name="tsector" class="form-control" style="text-align:center;"  id="tsector" />
								<option value="">SELECC...</option>
								<?php while($row_tsector = sqlsrv_fetch_array($res_tsector)){ ?>
								         <option value="<?php echo @$row_tsector['CVE_SECTOR']; ?>"><?php echo strtoupper(utf8_encode(@$row_tsector['TIPO_SECTOR'])); ?></option>
						        <?php } ?>
							</select>
					  </td>
                    </tr>
					 </table>
					
					<br><br>
					
					<table align="center" border="0" width="88%">
					<tr>
						<td><br /></td>      						     
					</tr>
					
                    <tr align="left" >
						<td style="text-align: left !important"><input type="checkbox" onclick="marcar(this);" /> <font face="Tahoma, Geneva, sans-serif" color="#003366" size="2"><b>Marcar/Desmarcar Todos</b></font></td>      
					</tr>
					
					<tr align="center">
						<td><font face="Tahoma, Geneva, sans-serif" color="#003366" size="3"><b>Selecciona los campos a exportar</b></font> <br><br><br> </td>						
					</tr>
					<tr>
						<td>
						<table align="center" width="88%" border="0">
						
						<?php
						$sql_datos = "SELECT TOP 1 ID_USUARIO,R_SOCIAL,RFC,SITUACION,SECTOR,DESTACAMENTO,REGION,TIPO_USUARIO,FECHA_ALTA,ACTIVIDAD,TIPO_SECTOR,SUBSECTOR,REPRESENTANTE,CARGO,TELEFONO 
						              FROM Facturacion.dbo.V_usuario_padron";
						$res_datos = sqlsrv_query($conn,$sql_datos);
						$i = 0;
						foreach(sqlsrv_field_metadata($res_datos) as $fieldMetadata){
						        if($i == 0){ echo "<tr>"; }
                                foreach($fieldMetadata as $name => $value) {
								     if($name == "Name"){
						?>   
										<td style="text-align: left !important">
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
						</table> 
						</td>
					</tr>
					
					<tr align="center">
						<td>
						<br /><br /><br />
						<input type="submit" name="exportar" id="exportar" value="Exportar Datos" class="btn btn-primary" formtarget="_blank" formaction="exporta_reporte_usuarios.php">
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