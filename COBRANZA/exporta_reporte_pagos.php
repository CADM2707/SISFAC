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
@$tpago = trim($_REQUEST['tpago']);
@$spago = trim($_REQUEST['spago']);

$f_del = date("Y/m/d", strtotime($del));
$f_al = date("Y/m/d", strtotime($al));

if(@$sector != ""){ @$q_sector = " AND ID_USUARIO IN (SELECT ID_USUARIO FROM [Facturacion].[dbo].V_usuario_padron WHERE SECTOR = $sector) "; } else { @$q_sector = ""; }
if(@$ayo != ""){ @$q_ayo = " AND AYO_PAGO=$ayo "; } else { @$q_ayo = ""; }
if(@$del != "" and @$al != ""){  @$q_fecha = " AND (FECHA_PAGO between '$f_del' and '$f_al') "; } else { @$q_fecha = ""; }
if(@$idusuario != ""){ @$q_usuario = " AND ID_USUARIO = '$idusuario' "; } else{ @$q_usuario = ""; }
if(@$tpago != ""){ if($tpago == 7){ @$q_tpago = " AND (CVE_PAGO_TIPO = $tpago OR REFERENCIA LIKE '%CHEQUE%' OR REFERENCIA LIKE '%DEP S B COBRO%') "; } else{ @$q_tpago = " AND CVE_PAGO_TIPO = $tpago "; } }  else{ @$q_tpago = ""; }
if(@$spago != ""){ @$q_spago = " AND CVE_PAGO_SIT = $spago "; } else{ @$q_spago = ""; }


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
             FROM [Facturacion].[dbo].[Pago]
			 WHERE ID_PAGO IS NOT NULL
			 $q_ayo $q_fecha $q_usuario $q_tpago $q_spago
			 $q_sector
			 ORDER BY AYO_PAGO DESC";
$res = sqlsrv_query($conn,$sql);

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=exporta_pagos.xls");
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
					
					if($dividir[$e] == "FECHA_PAGO"){ echo date_format($row[$dividir[$e]], 'd/m/Y'); }
					
					else if($dividir[$e] == "FECHA_CAPTURA"){ echo date_format($row[$dividir[$e]], 'd/m/Y'); }
					
					else if($dividir[$e] == "MONTO"){ echo number_format($row[$dividir[$e]],2); }
					
					else if($dividir[$e] == "CVE_PAGO_TIPO"){ 
					        $sql_tpago = "SELECT DESCRIPCION FROM [Facturacion].[dbo].[C_Pago_Tipo] WHERE CVE_PAGO_TIPO = ". $row[$dividir[$e]];
							$res_tpago = sqlsrv_query($conn,$sql_tpago);
                            $row_tpago = sqlsrv_fetch_array($res_tpago);
                            echo strtoupper(utf8_encode($row_tpago['DESCRIPCION']));							
				    }
					
					else if($dividir[$e] == "CVE_PAGO_SIT"){ 
					        $sql_spago = "SELECT DESCRIPCION FROM [Facturacion].[dbo].[C_Pago_Situacion] WHERE CVE_PAGO_SIT = ". $row[$dividir[$e]];
							$res_spago = sqlsrv_query($conn,$sql_spago);
                            $row_spago = sqlsrv_fetch_array($res_spago);
                            echo strtoupper(utf8_encode($row_spago['DESCRIPCION']));							
				    }
					
					else if($dividir[$e] == "ID_BANCO"){ 
					        $sql_bpago = "SELECT BANCO FROM [Facturacion].[dbo].[C_Banco] WHERE ID_BANCO = ". $row[$dividir[$e]];
							$res_bpago = sqlsrv_query($conn,$sql_bpago);
                            $row_bpago = sqlsrv_fetch_array($res_bpago);
                            echo strtoupper(utf8_encode($row_bpago['BANCO']));							
				    }
					
					else if($dividir[$e] == "ID_USUARIO"){ 
					        $sql_upago = "SELECT R_SOCIAL FROM [Facturacion].[dbo].[V_usuario_padron] WHERE ID_USUARIO = '". $row[$dividir[$e]] . "'";
							$res_upago = sqlsrv_query($conn,$sql_upago);
                            $row_upago = sqlsrv_fetch_array($res_upago);
                            echo $row[$dividir[$e]] . " " . strtoupper(utf8_encode($row_upago['R_SOCIAL']));							
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