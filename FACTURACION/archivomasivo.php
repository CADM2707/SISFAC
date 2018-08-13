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

$f_del = date("d/m/Y", strtotime($del));
$f_al = date("d/m/Y", strtotime($al));

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

$hoy = date("dmYHis");
$ruta = 'timbre/';
$nomdir = $ruta.$hoy.'.zip';

$sql24="SELECT AYO,ID_FACTURA,SECTOR,ID_USUARIO,R_SOCIAL,TOTAL_REDONDEADO,CVE_SITUACION,PERIODO_INICIO,PERIODO_FIN
		FROM Factura FA
		WHERE $q_tipo $q_ayo $q_sector $q_fecha $q_usuario $q_factura
		$q_tipoc
		$q_tipod
		order by AYO desc, ID_FACTURA desc";
$res24 = sqlsrv_query($conn,$sql24);

while($row24 = sqlsrv_fetch_array($res24)){

$ayo=$row24['AYO'];
$numr=$row24['ID_FACTURA'];

if($row24['CVE_SITUACION'] == 4){ $tipo = 1; }
if($row24['CVE_SITUACION'] == 5){ $tipo = 2; }

$nombre=$ayo.$numr.'.txt';

$sql = "EXECUTE [Facturacion].[dbo].sp_Datos_Timbrado $ayo,$numr,$idOp,$tipo";
$res = sqlsrv_query($conn,$sql);


  $fp = fopen("timbre/$ayo$numr.txt","a");



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
