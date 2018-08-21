<?php
include_once '../config.php';
include_once '../head.html';
include_once '../menuLat.php';

require_once '../PHPExcel/Classes/PHPExcel.php';

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
				FOLIO FISCAL
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

				<table class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:12px;'>
					<thead>
					  <tr>
					    <td align="center" class="bg-primary"><b>#</b></td>
						<td align="center" class="bg-primary"><b>FOLIO FISCAL</b></td>
						<td align="center" class="bg-primary"><b>RFC EMISOR</b></td>
						<td align="center" class="bg-primary"><b>RFC RECEPTOR</b></td>
						<td align="center" class="bg-primary"><b>FECHA TIMBRADO</b></td>
						<td align="center" class="bg-primary"><b>TOTAL</b></td>
						<td align="center" class="bg-primary"><b>VERSION</b></td>
						<td align="center" class="bg-primary"><b>TOTAL TRASLADADOS</b></td>
						<td align="center" class="bg-primary"><b>TOTAL RETENIDOS</b></td>
						<td align="center" class="bg-primary"><b>SERIE</b></td>
						<td align="center" class="bg-primary"><b>FOLIO</b></td>
						<td align="center" class="bg-primary"><b>CONFIRMACION</b></td>
						<td align="center" class="bg-primary"><b>ESTATUS SAT</b></td>
						<td align="center" class="bg-primary"><b>OBSERVACIONES</b></td>
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
						 $dato_folio = $sheet->getCell('A'.$row)->getValue();
						 $dato_emisor = $sheet->getCell('B'.$row)->getValue();
						 $dato_receptor = $sheet->getCell('C'.$row)->getValue();
						 $dato_ftimbrado = $sheet->getCell('D'.$row)->getValue();
						 $dato_total = $sheet->getCell('E'.$row)->getValue();
						 $dato_version = $sheet->getCell('F'.$row)->getValue();
						 $dato_tottras = $sheet->getCell('G'.$row)->getValue();
						 $dato_totret = $sheet->getCell('H'.$row)->getValue();
						 $dato_serie = $sheet->getCell('I'.$row)->getValue();
						 $dato_factura = $sheet->getCell('J'.$row)->getValue();
						 $dato_confirma = $sheet->getCell('K'.$row)->getValue();
						 $dato_estatus = $sheet->getCell('L'.$row)->getValue();
						 $dato_observa = $sheet->getCell('M'.$row)->getValue();
						 
						 $fecha = explode(" ", $dato_ftimbrado);
						 $ayo_p = $fecha[0];
						 $fechap = explode("/", $ayo_p);
						 $ayo_pago = $fechap[2];

						 if(@$_REQUEST["enviar"] == "1"){
							@$sql_exister = "select COUNT(*) as HAYR  
							                from [Facturacion].[dbo].Factura 
											where AYO = $ayo_pago AND ID_FACTURA = $dato_factura";
							$res_exister = sqlsrv_query($conn,$sql_exister);
							$row_exister = sqlsrv_fetch_array($res_exister);
							$si_exister = $row_exister['HAYR']; 
							
                            if($si_exister > 0){							
								@$sql_existe = "select COUNT(*) as HAY  
												from [Facturacion].[dbo].Factura 
												where AYO = $ayo_pago AND ID_FACTURA = $dato_factura AND (FOLIO_SAT IS NOT NULL OR FOLIO_SAT <> '')";
								$res_existe = sqlsrv_query($conn,$sql_existe);
								$row_existe = sqlsrv_fetch_array($res_existe);
								$si_existe = $row_existe['HAY'];
								//echo $sql_existe . "<br><br>";

								if($si_existe == 0){
								   @$sql_prep = "update [Facturacion].[dbo].Factura SET FOLIO_SAT = '$dato_folio' 
												 where AYO = $ayo_pago AND ID_FACTURA = $dato_factura";
								   $res_prep = sqlsrv_query($conn,$sql_prep);
								   //echo $sql_prep . "<br>";
								   $no_imprime = 0;
								}
								else{ $no_imprime = 1; }
								$no_imprimer = 0;
							}
							else{ $no_imprimer = 1; }
						 }

						if($i%2==0){ $color="#E1EEF4"; } else{ $color="#FFFFFF"; }
				?>
						<tr bgcolor="<?php echo $color; ?>">
						    <td><?php echo $i; ?>
							<td><?php echo $sheet->getCell("A".$row)->getValue(); ?>
							<td><?php echo $sheet->getCell("B".$row)->getValue(); ?>
							<td><?php echo $sheet->getCell("C".$row)->getValue(); ?>
							<td><?php echo $sheet->getCell("D".$row)->getValue(); ?>
							<td><?php if($sheet->getCell("E".$row)->getValue() != NULL){ echo number_format($sheet->getCell("E".$row)->getValue(),2); } ?>
							<td><?php echo $sheet->getCell("F".$row)->getValue(); ?>
							<td><?php if($sheet->getCell("G".$row)->getValue() != NULL){ echo number_format($sheet->getCell("G".$row)->getValue(),2); } ?>
							<td><?php if($sheet->getCell("H".$row)->getValue() != NULL){ echo number_format($sheet->getCell("H".$row)->getValue(),2); } ?>
							<td><?php echo $sheet->getCell("I".$row)->getValue(); ?>
							<td><?php echo $sheet->getCell("J".$row)->getValue(); ?>
							<td><?php echo $sheet->getCell("K".$row)->getValue(); ?>
							<td><?php echo $sheet->getCell("L".$row)->getValue(); ?>
							<td><?php echo $sheet->getCell("M".$row)->getValue(); ?>
							<td>
							<?php if(@$no_imprime == 1){ ?> 
							<font style='color:#D53032;font-size:11px;'><b>YA TIENE FOLIO FISCAL, NO SE ACTUALIZÓ</b></font>
							<?php } ?>
							
							<?php if(@$no_imprimer == 1){ ?> 
							<font style='color:#D53032;font-size:11px;'><b>NO EXISTE EL REGISTRO, NO SE ACTUALIZÓ</b></font>
							<?php } ?>
							
							</td>
						</tr>
					<?php $i++; }  ?>

				</tbody>
				</table>

				<?php } ?>
				<!-- ------------------------ fin area de trabajo ------------------------ -->
			</div>
		</div>
	</section>
	</div>

	<?php include_once '../footer.html'; ?>
