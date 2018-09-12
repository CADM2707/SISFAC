<?php
set_time_limit(0);

include_once '../config.php';

ini_set('zend.ze1_compatibility_mode', 0); 

$tipo = $_REQUEST['tipo'];
$ayo_fac = $_REQUEST['ayo_fac'];
$fol_fac = $_REQUEST['fol_fac'];
$ayo_pag = $_REQUEST['ayo_pag'];
$fol_pag = $_REQUEST['fol_pag'];

$hoy = date("dmYHis");  
$ruta = 'timbre/';
$nomdir = $ruta.$hoy.'.zip';

$nombre=$ayo_fac.$fol_fac.'.txt';

$sql = "EXECUTE [Facturacion].[dbo].sp_Datos_Timbrado_REP $ayo_fac,$fol_fac,$fol_pag,$ayo_pag";
$res = sqlsrv_query($conn,$sql);	


  $fp = fopen("timbre/$ayo_fac$fol_fac.txt","a");

    
		
while($row = sqlsrv_fetch_array($res)){
	   $descripcion = $row['DESCRIPCION']."\n";
	  fwrite($fp,$descripcion.PHP_EOL);
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



 
 // Creamos las cabezeras que forzaran la descarga del archivo como archivo zip.
 header("Content-type: application/octet-stream");
 header("Content-disposition: attachment; filename=$nomdir");
 // leemos el archivo creado
 readfile($nomdir);
 // Por último eliminamos el archivo temporal creado
 //unlink($nomdir);//Destruye el archivo temporal
?>



