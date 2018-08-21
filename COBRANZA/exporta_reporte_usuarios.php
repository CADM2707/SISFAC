<?php
error_reporting(0);

$serverName = '10.13.211.240'; //IP DEL SERVIDOR
$connectionOptions = array(
	'Database' => 'Facturacion',
	'Uid' => 'sa',
	'PWD' => 'S1st3m4s'
);
$conn = sqlsrv_connect($serverName, $connectionOptions);

@$sector = $_REQUEST['sector'];
@$situacion = $_REQUEST['situacion'];
@$region = $_REQUEST['region'];
@$tusuario = $_REQUEST['tusuario'];
@$tsector = $_REQUEST['tsector'];


if(@$sector != ""){ @$q_sector = " AND SECTOR = $sector "; } else { @$q_sector = ""; }
if(@$situacion != ""){ @$q_situacion = " AND CVE_SITUACION = $situacion "; } else { @$q_situacion = ""; }
if(@$region != ""){ @$q_region = " AND ID_REGION = $region "; } else { @$q_region = ""; }
if(@$tusuario != ""){ @$q_tusuario = " AND CVE_TIPO_USUARIO = $tusuario "; } else { @$q_tusuario = ""; }
if(@$tsector != ""){ @$q_tsector = " AND CVE_SECTOR = $tsector "; } else { @$q_tsector = ""; }


foreach($_POST as $nombre_campo => $valor){
	    //echo $nombre_campo . " -- " . $valor . "<br>"; Cast(FECHA_PAGO As Date) as FECHA_PAGO
		$div_campo = explode("-", $nombre_campo);
		 
		if($div_campo[0] == "DATOS"){
		   $datos_cunsulta =  $datos_cunsulta . $valor . ",";
		   $datos_pintar .= "<th align='center' bgcolor='#006699'><font face='Tahoma, Geneva, sans-serif' color='#ffffff'><b>".str_replace("_", " ",$valor)."</b></font></th>";
		}
}
$datos_cunsulta = trim($datos_cunsulta, ','); 
//echo "<br>".$datos_pintar;


$sql = "SELECT  $datos_cunsulta
             FROM [Facturacion].[dbo].[V_usuario_padron]
			 WHERE ID_USUARIO IS NOT NULL
			 $q_sector $q_situacion $q_region $q_tusuario $q_tsector 
			 ORDER BY ID_USUARIO";
$res = sqlsrv_query($conn,$sql);

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=exporta_usuarios.xls");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EXPORTAR DATOS</title>
</head>

<body>

<table cellpadding="5" cellspacing="1" border="1">
   <thead>
      <tr>
        <th align='center' bgcolor='#006699'><font face='Tahoma, Geneva, sans-serif' color='#ffffff'><b>#</b></font></th>
        <?php echo $datos_pintar; ?>
      </tr>
   </thead>
   <tbody>
   
   <?php 
   $i=1;
   while($row = sqlsrv_fetch_array($res)){
   ?>
			<tr>
				<td><?php echo $i; ?></td>
				<?php 
				$dividir = explode(",", $datos_cunsulta);
				$cuantos = substr_count($datos_cunsulta, ',');
				for($e=0; $e <= $cuantos; $e++){
					echo "<td>";
					
					if($dividir[$e] == "FECHA_ALTA"){ echo date_format($row[$dividir[$e]], 'd/m/Y'); }
					
					else{ echo utf8_encode($row[$dividir[$e]]); }	
					
					echo "</td>";
				}
				?>
			</tr>
   <?php
   $i++;
   }
   ?>
   
   </tbody>
</table>

</body>
</html>