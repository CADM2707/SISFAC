<?php
set_time_limit(0);

include_once '../config.php';

ini_set('zend.ze1_compatibility_mode', 0); 

@$ayo=$_REQUEST['Ayo'];
@$sector=$_REQUEST['Sector'];
@$del=$_REQUEST['Del'];
@$al=$_REQUEST['Al'];
		
if($ayo != ""){ @$uno = " AND AYO=$ayo "; } else { @$uno = ""; }
if($sector != ""){ @$dos = " AND SECTOR=$sector "; } else { @$dos = ""; }
if($del != "" and $al != ""){ @$tres = " AND (PERIODO_INICIO between '$del' and '$al' or PERIODO_FIN between '$del' and '$al') "; } else { @$tres = ""; }
					
$hoy = date("dmYHis");  
$ruta = 'timbre/';
$nomdir = $ruta.$hoy.'.zip';

	$sql24="SELECT AYO,ID_FACTURA,SECTOR,ID_USUARIO,R_SOCIAL,TOTAL_REDONDEADO,CVE_SITUACION,PERIODO_INICIO,PERIODO_FIN 
			FROM Factura FA
			WHERE CVE_SITUACION IN (4) $uno $dos $tres 
			and ID_FACTURA not in (select ID_FACTURA FROM [Facturacion].[dbo].[BitacoraTimbrado] BT where BT.ID_FACTURA = FA.ID_FACTURA and BT.AYO = FA.AYO)
			order by AYO, ID_FACTURA desc";       
	$res24 = sqlsrv_query($conn,$sql24);
	
while($row24 = sqlsrv_fetch_array($res24)){

$ayo=$row24['AYO'];
$numr=$row24['ID_FACTURA'];

$nombre=$ayo.$numr.'.txt';

$sql = "EXECUTE [Facturacion].[dbo].sp_Datos_Timbrado $ayo,$numr,$idOp";
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



