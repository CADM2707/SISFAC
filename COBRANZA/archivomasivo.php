<?php
set_time_limit(0);

include_once '../config.php';

ini_set('zend.ze1_compatibility_mode', 0);

@$ayo = $_REQUEST['Ayo'];
@$sector = $_REQUEST['Sector'];
@$del = $_REQUEST['Del'];
@$al = $_REQUEST['Al'];
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

$hoy = date("dmYHis");
$ruta = 'timbre/';
$nomdir = $ruta.$hoy.'.zip';

$sql24="select T1.SECTOR,T1.AYO,T1.ID_FACTURA,T2.AYO_PAGO,T2.ID_PAGO,T2.MONTO_APLICADO,T2.FECHA_APLICADO,T1.ID_USUARIO,T1.R_SOCIAL,CVE_PAGO_SIT
		FROM Factura T1
		INNER JOIN Pago_Factura T2 ON T1.AYO=T2.AYO AND T1.ID_FACTURA =T2.ID_FACTURA
		WHERE  T1.CVE_TIPO_FACTURA<11
		$q_tipo $q_ayo $q_sector $q_fecha $q_usuario $q_factura
		$q_tipoc
		$q_tipod
		ORDER BY T1.AYO DESC,T1.ID_FACTURA DESC";
$res24 = sqlsrv_query($conn,$sql24);

while($row24 = sqlsrv_fetch_array($res24)){

$ayo_fac = $row24['AYO'];
$fol_fac = $row24['ID_FACTURA'];
$ayo_pag = $row24['AYO_PAGO'];
$fol_pag = $row24['ID_PAGO'];

if($row24['CVE_PAGO_SIT'] == 2){ $tipo = 1; }
if($row24['CVE_PAGO_SIT'] == 3){ $tipo = 2; }

$nombre=$ayo_fac.$fol_fac.'.txt';

$sql = "EXECUTE [Facturacion].[dbo].sp_Datos_Timbrado_REP $ayo_fac,$fol_fac,$fol_pag,$ayo_pag,$idOp,$tipo";
$res = sqlsrv_query($conn,$sql);

//echo $sql."<br>";
  $fp = fopen("timbre/$ayo_fac$fol_fac.txt","a");



while($row = sqlsrv_fetch_array($res)){
	  fwrite($fp,$row['DESCRIPCION'].PHP_EOL);
}
fwrite($fp,  PHP_EOL);


fclose($fp);

$root = "timbre/";
$file = basename($nombre);
$path = $root.$file;

$type = '';
//echo $path;
if (is_file($path)) { $size = filesize($path);
if (function_exists('mime_content_type')) { $type = mime_content_type($path);
} else if (function_exists('finfo_file')) { $info = finfo_open(FILEINFO_MIME);
$type = finfo_file($info, $path); finfo_close($info);
} if ($type == '') { $type = "application/force-download"; }

}

$zip = new ZipArchive;
$res = $zip->open($nomdir, ZipArchive::CREATE);
if ($res === TRUE) {
    $zip->addFile($path);
    $zip->close();
} else {
}

unlink($path);//Destruye el archivo temporal
}


 // Creamos las cabezeras que forzaran la descarga del archivo como archivo zip.
 header("Content-type: application/octet-stream");
 header("Content-disposition: attachment; filename=$nomdir");
 // leemos el archivo creado
 readfile($nomdir);
 // Por �ltimo eliminamos el archivo temporal creado
 //unlink($nomdir);//Destruye el archivo temporal
 
?>
