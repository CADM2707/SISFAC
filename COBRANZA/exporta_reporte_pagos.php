<?php
error_reporting(0);
 
//include_once "../config.php";

include_once "PHPExcel/Classes/PHPExcel.php";


foreach($_POST as $nombre_campo => $valor){
			 $div_campo = explode("-", $nombre_campo);
			 
			 if($valor != "" AND $div_campo[0] != "DATOS" AND $nombre_campo != "exportar"){ echo $nombre_campo . " -- " . $valor . "<br>"; }
			 
			 if($div_campo[0] == "DATOS"){
				$datos_cunsulta =  $datos_cunsulta . $valor . ",";
				$datos_pintar .= "<th align='center' bgcolor='#006699'>".str_replace("_", " ",$valor)."</th>";
			 }
}
echo $datos_cunsulta = trim($datos_cunsulta, ','); 
//echo "<br>".$datos_pintar;



/*
$objPHPExcel = new PHPExcel();

$objPHPExcel->
getProperties()
->setCreator("SISFAC")
->setLastModifiedBy("SISFAC")
->setTitle("Exportar Pagos")
->setSubject("Exportar Pagos")
->setDescription("Exportar Pagos")
->setKeywords("Exportar Pagos")
->setCategory("Exportar Pagos");


// Set fonts
$objPHPExcel->setActiveSheetIndex(0)
->getStyle('A1:C1')->getFont()->setName('Arial Black');


$objPHPExcel->setActiveSheetIndex(0)
->setCellValue("A1", "Nombre")
->setCellValue("B1", "E-mail")
->setCellValue("C1", "Twitter")
->setCellValue("A2", "David")
->setCellValue("B2", "dvd@gmail.com")
->setCellValue("C2", "@davidvd");

$objPHPExcel->getActiveSheet()->setTitle("Pagos");
$objPHPExcel->setActiveSheetIndex(0);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;filename=Exporta_Pagos.xls");
header("Cache-Control: max-age=0");

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel5");
$objWriter->save("php://output");
exit;
*/
?>