<?php
include_once '../config.php';
include_once '../head.html';
include_once '../menuLat.php';

require_once 'PHPExcel/Classes/PHPExcel.php';

if(@$_REQUEST["enviar"] == "Procesar Archivo Seleccionado" OR @$_REQUEST["enviar"] == "1"){

  if(@$_REQUEST["narchivo"] == ""){
	 $archivo = $_FILES["archivo"]['name'];
	 if ($archivo != "") {
		 echo $hoy = date("d-m-Y H-i-s");
		 $destino2 =  "Archivos/".$hoy.'_'.$archivo;
		 $nombre_archivo =  "Archivos/".$hoy.'_'.$archivo;
		 if (copy($_FILES['archivo']['tmp_name'],$destino2)){ }
	}
  }
  if(@$_REQUEST["narchivo"] != ""){
	   @$nombre_archivo = $_REQUEST["narchivo"];
  }
}
?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper" style=" background-color: white;">
		<!--Titulos de encabezado de la pagina-->
		<section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
			<h1>
				PAGO POR LÍNEA DE CAPTURA
			</h1>
			<br>
		</section>
		<!-- FIN DE Titulos de encabezado de la pagina-->

		<section class="content" >
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-lg-12 col-xs-12 text-center">
				<!-- ------------------------ area de trabajo ------------------------ -->				
			 <?php if(@$_REQUEST["enviar"] == "" OR @$_REQUEST["sube"] == "NO, SUBIR OTRO ARCHIVO"){ ?>
				<form action="" method="post" enctype="multipart/form-data" name="subir" id="subir">
				<table align="center" border="0">
					<tr>
					  <td colspan = "3">
					  <b>SUBIR ARCHIVO</b>
					  <br><br>
					  </td>
					</tr>
					<tr>
					  <td align="center">
						  <input name="archivo" type="file" class="form-control" required="reuired" />
					  </td>
					  <td>
					  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  </td>
					  <td>
						  <input name="enviar" id="enviar" type="submit" value="Procesar Archivo Seleccionado" class="btn btn-primary" />
					  </td>
					</tr>
				 </table>
				</form>
			 <?php } ?>

				<?php
				if(@$_REQUEST["enviar"] == "Procesar Archivo Seleccionado" OR @$_REQUEST["sube"] == "SI, GUARDAR ARCHIVO"){
					if(@$_REQUEST["enviar"] != "1"){
				?>

				<font style='border-collapse:collapse;border-color:#ddd;font-size:18px;'> <b> ¿ES CORRECTA LA INFORMACIÓN? </b> </font>

				<br><br>
				<form action="" method="post">
				<table align="center" border="0">
				  <tr>
					  <td align="center">
						  <input name="sube" id="sube" type="submit" value="NO, SUBIR OTRO ARCHIVO" class="btn btn-danger" />
					  </td>
					  <td>
					  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  </td>
					  <td>
						  <input name="sube" id="sube" type="submit" value="SI, GUARDAR ARCHIVO" class="btn btn-success" />

						  <input name="enviar" id="enviar" type="hidden" value="1" />
						  <input name="narchivo" id="narchivo" type="hidden" value="<?php echo $nombre_archivo; ?>" />
					  </td>
					</tr>
				</table>
				</form>
				<br>
					<?php } ?>

				<?php if(@$_REQUEST["enviar"] == "1"){ ?>
						 <div class="alert alert-success"> <font style='font-size:16px;'> <b> LA INFORMACIÓN SE GUARDÓ CON ÉXITO </b> </font> </div>
				<?php } ?>

				<table    class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:12px;'>
					<thead>
					  <tr>
					    <td align="center" class="bg-primary"><b>#</b></td>
						<td align="center" class="bg-primary"><b>BANCO</b></td>
						<td align="center" class="bg-primary"><b>SUCURSAL</b></td>
						<td align="center" class="bg-primary"><b>REFERENCIA BANCARIA</b></td>
						<td align="center" class="bg-primary"><b>LINEA DE CAPTURA</b></td>
						<td align="center" class="bg-primary"><b>FECHA DE PAGO</b></td>
						<td align="center" class="bg-primary"><b>IMPORTE</b></td>
						<td align="center" class="bg-primary"><b>FORMA DE PAGO</b></td>
						<td align="center" class="bg-primary"><b>CUENTA PAGADORA</b></td>
						<td align="center" class="bg-primary"><b></b></td>
					  </tr>
					</thead>
					  <tbody>

				<?php
					$inputFileType = PHPExcel_IOFactory::identify($nombre_archivo);
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$objPHPExcel = $objReader->load($nombre_archivo);
					$sheet = $objPHPExcel->getSheet(0);
					$highestRow = $sheet->getHighestRow();
					$highestColumn = $sheet->getHighestColumn();

					$i=1;
					for ($row = 1; $row <= $highestRow; $row++){
						 $dato_banco = $sheet->getCell('A'.$row)->getValue();
						 $dato_sucursal = $sheet->getCell('B'.$row)->getValue();
						 $dato_referencia = $sheet->getCell('C'.$row)->getValue();
						 $dato_lcaptura = $sheet->getCell('D'.$row)->getValue();
						 $dato_fpago = PHPExcel_Style_NumberFormat::toFormattedString($sheet->getCell('E'.$row)->getValue(), 'YYYY/mm/dd');
						 $dato_importe = $sheet->getCell('F'.$row)->getValue();
						 $dato_formapag = $sheet->getCell('G'.$row)->getValue();
						 $dato_cuentapag = $sheet->getCell('H'.$row)->getValue();

						 if(@$_REQUEST["enviar"] == "1"){
							@$sql_exister = "select COUNT(*) as HAYR  
							                from [Facturacion].[dbo].pago 
											where REFERENCIA = '$dato_lcaptura' AND FECHA_PAGO = '$dato_fpago' AND MONTO = $dato_importe";
							$res_exister = sqlsrv_query($conn,$sql_exister);
							$row_exister = sqlsrv_fetch_array($res_exister);
							$si_exister = $row_exister['HAYR'];
							
							if($si_exister == 0){
								@$sql_inserta = "INSERT INTO [Facturacion].[dbo].Linea_Captura (ID_PAGO,BANCO,SUCURSAL,REFERENCIA_BANCO,LINEA_CAPTURA,FECHA_PAGO,IMPORTE,FORMA_PAGO,CUENTA_PAGADORA)
												VALUES (NULL,'$dato_banco','$dato_sucursal','$dato_referencia','$dato_lcaptura','$dato_fpago',$dato_importe,'$dato_formapag','$dato_cuentapag')";
								$res_inserta = sqlsrv_query($conn,$sql_inserta);
								//echo $sql_inserta . "<br>";

								$fecha = explode("/", $dato_fpago);
								$ayo_pago = $fecha[0];

								$sql_max = "select isnull(max(ID_PAGO)+1,0) as MAX from [Facturacion].[dbo].pago";
								$res_max = sqlsrv_query($conn,$sql_max);
								$row_max = sqlsrv_fetch_array($res_max);
								$id_pago = $row_max['0'];

								$str_banco = strtoupper(trim($dato_banco));

								$sql_banco = "SELECT ID_BANCO FROM [Facturacion].[dbo].c_banco where UPPER(RTRIM(LTRIM(BANCO))) = '$str_banco'";
								$res_banco = sqlsrv_query($conn,$sql_banco);
								$row_banco = sqlsrv_fetch_array($res_banco);
								$id_banco = $row_banco['ID_BANCO'];

								if($id_banco == ""){ $id_banco = 0; }

								@$sql_pago = "INSERT INTO [Facturacion].[dbo].pago (AYO_PAGO,ID_PAGO,CVE_PAGO_TIPO,MONTO,FECHA_PAGO,FECHA_CAPTURA,REFERENCIA,OBSERVACION,CVE_DESTINO,CVE_PAGO_SIT,ID_OPERADOR,ID_BANCO,SUCURSAL,ID_USUARIO)
											  VALUES ($ayo_pago,$id_pago,31,$dato_importe,'$dato_fpago',GETDATE(),'$dato_lcaptura',NULL,NULL,1,$idOp,$id_banco,'$dato_sucursal',NULL)";
								$res_pago = sqlsrv_query($conn,$sql_pago);
								//echo $sql_pago . "<br>";
								$no_imprimer = 0;
							}
							else{ $no_imprimer = 1; }
						 }
						 if($i%2==0){ $color="#E1EEF4";	} else{	$color="#FFFFFF"; }
				?>
						<tr bgcolor="<?php echo $color; ?>">
						    <td><?php echo $i; ?>
							<td><?php echo $sheet->getCell("A".$row)->getValue(); ?>
							<td><?php echo $sheet->getCell("B".$row)->getValue(); ?>
							<td><?php echo $sheet->getCell("C".$row)->getValue(); ?>
							<td><?php echo $sheet->getCell("D".$row)->getValue(); ?>
							<td><?php echo PHPExcel_Style_NumberFormat::toFormattedString($sheet->getCell('E'.$row)->getValue(), 'dd/mm/YYYY'); ?>
							<td><?php echo number_format($sheet->getCell("F".$row)->getValue(),2); ?>
							<td><?php echo $sheet->getCell("G".$row)->getValue(); ?>
							<td><?php echo $sheet->getCell("H".$row)->getValue(); ?>
							
							<td>
							<?php if(@$no_imprimer == 1){ ?> 
							<font style='color:#D53032;font-size:11px;'><b>YA EXISTE ESTE REGISTRO, NO SE ACTUALIZÓ</b></font>
							<?php } ?>
							</td>
						</tr>
				<?php $i++; } ?>

				</tbody>
				</table>

				<?php } ?>

				<!-- ------------------------ fin area de trabajo ------------------------ -->
			</div>
		</div>
	</section>
	</div>

	<?php include_once '../footer.html'; ?>
