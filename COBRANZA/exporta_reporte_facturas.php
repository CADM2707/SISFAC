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
@$ayo = $_REQUEST['ayo'];
@$del = $_REQUEST['del'];
@$al = $_REQUEST['al'];
@$idusuario = trim($_REQUEST['idusuario']);
@$tfactura = trim($_REQUEST['tfactura']);
@$sfactura = trim($_REQUEST['sfactura']);

$f_del = date("Y/m/d", strtotime($del));
$f_al = date("Y/m/d", strtotime($al));

if(@$sector != ""){ @$q_sector = " AND SECTOR = $sector "; } else { @$q_sector = ""; }
if(@$ayo != ""){ @$q_ayo = " AND AYO = $ayo "; } else { @$q_ayo = ""; }
if(@$del != "" and @$al != ""){  @$q_fecha = " AND ((PERIODO_INICIO between '$f_del' and '$f_al') OR (PERIODO_FIN between '$f_del' and '$f_al')) "; } else { @$q_fecha = ""; }
if(@$idusuario != ""){ @$q_usuario = " AND ID_USUARIO = '$idusuario' "; } else{ @$q_usuario = ""; }
if(@$tfactura != ""){ @$q_tfactura = " AND CVE_TIPO_FACTURA = $tfactura "; }  else{ @$q_tfactura = ""; }
if(@$sfactura != ""){ @$q_sfactura = " AND CVE_SITUACION = $sfactura "; } else{ @$q_sfactura = ""; }


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
             FROM [Facturacion].[dbo].[Factura]
			 WHERE ID_FACTURA IS NOT NULL
			 $q_ayo $q_fecha $q_usuario $q_tfactura $q_sfactura
			 $q_sector
			 ORDER BY AYO DESC";
$res = sqlsrv_query($conn,$sql);

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=exporta_facturas.xls");
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
					
					if($dividir[$e] == "CVE_TIPO_FACTURA"){ 
					        $sql_tfactura = "SELECT [CVE_TIPO_FACTURA],[TIPO_FACTURA] FROM [Facturacion].[dbo].[C_Tipo_Factura] WHERE CVE_TIPO_FACTURA = ". $row[$dividir[$e]];
							$res_tfactura = sqlsrv_query($conn,$sql_tfactura);
                            $row_tfactura = sqlsrv_fetch_array($res_tfactura);
                            echo strtoupper(utf8_encode($row_tfactura['TIPO_FACTURA']));							
				    }
									
					else if($dividir[$e] == "FECHA_EMISION"){ echo date_format($row[$dividir[$e]], 'd/m/Y'); }
					
					else if($dividir[$e] == "SUBTOTAL"){ echo number_format($row[$dividir[$e]],2); }
					
					else if($dividir[$e] == "IVA"){ echo number_format($row[$dividir[$e]],2); }
					
					else if($dividir[$e] == "TOTAL"){ echo number_format($row[$dividir[$e]],2); }
					
					else if($dividir[$e] == "TOTAL_REDONDEADO"){ echo number_format($row[$dividir[$e]],2); }
					
					else if($dividir[$e] == "PERIODO_INICIO"){ echo date_format($row[$dividir[$e]], 'd/m/Y'); }
					
					else if($dividir[$e] == "PERIODO_FIN"){ echo date_format($row[$dividir[$e]], 'd/m/Y'); }
						
					else if($dividir[$e] == "CVE_SITUACION"){ 
					        $sql_sfactura = "SELECT [CVE_SITUACION],[SITUACION] FROM [Facturacion].[dbo].[Factura_C_Situacion] WHERE CVE_SITUACION = ". $row[$dividir[$e]];
							$res_sfactura = sqlsrv_query($conn,$sql_sfactura);
                            $row_sfactura = sqlsrv_fetch_array($res_sfactura);
                            echo strtoupper(utf8_encode($row_sfactura['SITUACION']));							
				    }
					
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