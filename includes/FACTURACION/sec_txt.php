<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
$format="d/m/Y";


@$ayo= isset($_REQUEST['Ayo'])?0:$_REQUEST['Ayo'];
@$sector= isset($_REQUEST['Sector'])?0:$_REQUEST['Sector'];
@$del= isset($_REQUEST['Del'])?0:$_REQUEST['Del'];
@$al= isset($_REQUEST['Al'])?0:$_REQUEST['Al'];

			
if($ayo != ""){ @$uno = " AND AYO=$ayo "; } else { @$uno = ""; }
if($sector != ""){ @$dos = " AND SECTOR=$sector "; } else { @$dos = ""; }
if($del != "" and $al != ""){ @$tres = " AND (PERIODO_INICIO between '$del' and '$al' or PERIODO_FIN between '$del' and '$al') "; } else { @$tres = ""; }

$sql_reporte ="SELECT AYO,ID_RECIBO,SECTOR,ID_USUARIO,R_SOCIAL,TOTAL_REDONDEADO,CVE_SITUACION,PERIODO_INICIO,PERIODO_FIN 
				FROM Factura FA
				WHERE CVE_SITUACION IN (4) $uno $dos $tres 
				and ID_RECIBO not in (select ID_RECIBO FROM [Facturacion].[dbo].[BitacoraTimbrado] BT where BT.ID_RECIBO = FA.ID_RECIBO and BT.AYO = FA.AYO)
				order by AYO, ID_RECIBO desc";
$res_reporte = sqlsrv_query($conn,$sql_reporte);
$cuantos_son = sqlsrv_has_rows($res_reporte);

// codigo html
$html = "";

if($cuantos_son === true){
$html.= "<form name='form_timbrado' method='post'>";
$html.=" <br>
       <table class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:12px;'>
					<thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>AÑO</center></th>
						<th><center>ID RECIBO</center></th>
						<th><center>SECTOR</center></th>
						<th><center>ID USUARIO</center></th>
						<th><center>R. SOCIAL</center></th>
						<th><center>TOTAL REDONDEADO</center></th>
						<th><center>PERIODO INICIO</center></th>
						<th><center>PERIODO FIN</center></th>			
						<th width=50px><center></center></th>						
					  </tr>
					</thead>
					<tbody>";
		
	
	// codigo php
						$i=1;
								while($row_reporte = sqlsrv_fetch_array($res_reporte)){	
								
								$ayo = $row_reporte['AYO'];
								$id = $row_reporte['ID_RECIBO'];
								$sec = $row_reporte['SECTOR'];
								$usu = $row_reporte['ID_USUARIO'];
								$rsoc = $row_reporte['R_SOCIAL'];
								$tot = $row_reporte['TOTAL_REDONDEADO'];
								$per1 = date_format($row_reporte['PERIODO_INICIO'], $format);
								$per2 = date_format($row_reporte['PERIODO_FIN'], $format);
								$sit = $row_reporte['CVE_SITUACION'];
								
								//$fecha= date_format($row_reporte['FECHA_ALTA'], $format);
								
							if($i%2==0){ $color='background-color:#E1EEF4';	}else{	$color='background-color:#FFFFFF';	}				
																							
					        $html.="<tr style='$color; '>
							<td><center> $ayo </center></td>
							<td><center> $id </center></td>
							<td><center> $sec </center></td>
							<td><center> $usu </center></td>
							<td><center> ".utf8_encode($rsoc)." </center></td>
							<td><center> ". number_format($tot,2) ." </center></td>
							<td><center> $per1 </center></td>
							<td><center> $per2 </center></td>";
		
							$html.= "<td><center>";
							$html.="<input type='button' name='gTimbrado' value='GENERAR TXT' class='btn btn-primary btn-sm center-block' onclick='timbrado($ayo,$id)'>";
							$html.="</center></td>
					  </tr>";
					  $i++;
					}	  	
					 $html.="<tr><td colspan='8'><center><br><br>&nbsp;</td>";
					 $html.="<td><center><br>";
					 $html.="<input type='submit' name='gmasivo' value='GENERAR TXT MASIVO' class='btn btn-info btn-sm center-block' formaction='archivomasivo.php?Ayo=$ayo&Sector=$sector&Del=$del&Al=$al'";
					 $html.="<br></center></td></tr>	
					</tbody>
				  </table>"; 
		$html.= "</form>";
					  	
}
else{
	$html.= "<br><br><br><br><br><br><br><br><br><div class='alert alert-danger'> <font style='font-size:16px;'> <b> NO EXISTEN REGISTROS </b> </font> </div>";
}		

echo $html;	

?>