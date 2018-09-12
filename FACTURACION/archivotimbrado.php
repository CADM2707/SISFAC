<?php
set_time_limit(0);

include_once '../config.php';

ini_set('zend.ze1_compatibility_mode', 0); 

$tipo = $_REQUEST['tipo'];
$ayo = $_REQUEST['ayo'];
$numrecibo = $_REQUEST['recibo'];
$idOP;

$hoy = date("dmYHis");  
$ruta = 'timbre/';
$nomdir = $ruta.$hoy.'.zip';

	
$nombre=$ayo.$numrecibo.'.txt';

echo $sql = "EXECUTE [Facturacion].[dbo].sp_Datos_Timbrado $ayo,$numrecibo,$idOp";
$res = sqlsrv_query($conn,$sql);	


  $fp = fopen("timbre/$ayo$numrecibo.txt","a");

    
		
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



 
 // Creamos las cabezeras que forzaran la descarga del archivo como archivo zip.
 header("Content-type: application/octet-stream");
 header("Content-disposition: attachment; filename=$nomdir");
 // leemos el archivo creado
 readfile($nomdir);
 // Por último eliminamos el archivo temporal creado
 //unlink($nomdir);//Destruye el archivo temporal
?>



