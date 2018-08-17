<?php
error_reporting(0);
 
$serverName = '10.13.211.240'; //IP DEL SERVIDOR
$connectionOptions = array(
	'Database' => 'Facturacion',
	'Uid' => 'sa',
	'PWD' => 'S1st3m4s'
);
$conn = sqlsrv_connect($serverName, $connectionOptions);


include_once "PHPExcel/Classes/PHPExcel.php";

@$sector = $_REQUEST['sector'];
@$ayo = $_REQUEST['ayo'];
@$del = $_REQUEST['del'];
@$al = $_REQUEST['al'];
@$idusuario = trim($_REQUEST['idusuario']);
@$tpago = trim($_REQUEST['tpago']);
@$spago = trim($_REQUEST['spago']);

$f_del = date("Y/m/d", strtotime($del));
$f_al = date("Y/m/d", strtotime($al));

if(@$sector != ""){ @$q_sector = " AND ID_USUARIO IN (SELECT ID_USUARIO FROM [Facturacion].[dbo].V_usuario_padron WHERE SECTOR = $sector) "; } else { @$q_sector = ""; }
if(@$ayo != ""){ @$q_ayo = " AND AYO_PAGO=$ayo "; } else { @$q_ayo = ""; }
if(@$del != "" and @$al != ""){  @$q_fecha = " AND (FECHA_PAGO between '$f_del' and '$f_al') "; } else { @$q_fecha = ""; }
if(@$idusuario != ""){ @$q_usuario = " AND ID_USUARIO = '$idusuario' "; } else{ @$q_usuario = ""; }
if(@$tpago != ""){ @$q_tpago = " AND CVE_PAGO_TIPO = $tpago "; } else{ @$q_tpago = ""; }
if(@$spago != ""){ @$q_spago = " AND CVE_PAGO_SIT = $spago "; } else{ @$q_spago = ""; }


foreach($_POST as $nombre_campo => $valor){
	    //echo $nombre_campo . " -- " . $valor . "<br>"; 
		$div_campo = explode("-", $nombre_campo);
		 
		if($div_campo[0] == "DATOS"){
		   $datos_cunsulta =  $datos_cunsulta . $valor . ",";
		   //$datos_pintar .= "<th align='center' bgcolor='#006699'>".str_replace("_", " ",$valor)."</th>";
		}
}
$datos_cunsulta = trim($datos_cunsulta, ','); 
//echo "<br>".$datos_pintar;


$sql_pagos = "SELECT  $datos_cunsulta
             FROM [Facturacion].[dbo].[Pago]
			 WHERE ID_PAGO IS NOT NULL
			 $q_ayo $q_fecha $q_usuario $q_tpago $q_spago
			 $q_sector
			 ORDER BY AYO_PAGO DESC";
$res_pagos = sqlsrv_query($conn,$sql_pagos);


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
->getStyle('A1:Z1')->getFont()->setName('Arial Black');

$i=65;
foreach(sqlsrv_field_metadata($res_pagos) as $fieldMetadata){
	foreach($fieldMetadata as $name => $value) {
		 if($name == "Name"){ 
			 $objPHPExcel->setActiveSheetIndex(0) 
			 ->setCellValue(chr($i)."1", $value);
			 $i++;
		 }
	}
}

$i=65;
$rowNumber = 2;
while($row_pago = sqlsrv_fetch_array($res_pagos)){
   $campo = $row_pago[1];
   $objPHPExcel->setActiveSheetIndex(0)
   ->setCellValue(chr($i).$rowNumber, $campo);
	$rowNumber++;
	$i++;
}

$objPHPExcel->getActiveSheet()->setTitle("Pagos");
$objPHPExcel->setActiveSheetIndex(0);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;filename=Exporta_Pagos.xls");
header("Cache-Control: max-age=0");

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel5");
$objWriter->save("php://output");
exit;

?>