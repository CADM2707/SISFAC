<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
$format="d/m/Y";


<<<<<<< HEAD
@$ayo=$_REQUEST['Ayo'];
@$sector=$_REQUEST['Sector'];
@$del=$_REQUEST['Del'];
@$al=$_REQUEST['Al'];

			
if($ayo != ""){ @$uno = " AND AYO=$ayo "; } else { @$uno = ""; }
if($sector != ""){ @$dos = " AND SECTOR=$sector "; } else { @$dos = ""; }
if($del != "" and $al != ""){ @$tres = " AND (PERIODO_INICIO between '$del' and '$al' or PERIODO_FIN between '$del' and '$al') "; } else { @$tres = ""; }

$sql_reporte ="SELECT AYO,ID_FACTURA,SECTOR,ID_USUARIO,R_SOCIAL,TOTAL_REDONDEADO,CVE_SITUACION,PERIODO_INICIO,PERIODO_FIN 
				FROM Factura FA
				WHERE CVE_SITUACION IN (4) $uno $dos $tres 
				and ID_FACTURA not in (select ID_FACTURA FROM [Facturacion].[dbo].[BitacoraTimbrado] BT where BT.ID_FACTURA = FA.ID_FACTURA and BT.AYO = FA.AYO)
				order by AYO, ID_FACTURA desc";
$res_reporte = sqlsrv_query($conn,$sql_reporte);
$cuantos_son = sqlsrv_has_rows($res_reporte);

// codigo html
$html = "";

if($cuantos_son === true){
$html.= "<form name='form_timbrado' method='post'>";
=======
 @$ayo=$_REQUEST['Ayo'];
 @$sector=$_REQUEST['Sector'];
 @$del=$_REQUEST['Del'];
 @$al=$_REQUEST['Al'];
 $html = "";
 
 // Consulta de la tabla

				//$count_reporte=sqlsrv_fetch_array($res_reporte);	
				//if($count_reporte>0){ 
 
 // codigo html
>>>>>>> 4429abca44dcb3015a82c3f3cae8b181bc7e2ea5
$html.=" <br>
<table class='table table-hover table-responsive' style='font-size:11px;'>
					<thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>AÑO</center></th>
						<th><center>ID FACTURA</center></th>
						<th><center>SECTOR</center></th>
						<th><center>ID USUARIO</center></th>
						<th><center>R. SOCIAL</center></th>
						<th><center>TOTAL REDONDEADO</center></th>
						<th><center>PERIODO INICIO</center></th>
						<th><center>PERIODO FIN</center></th>			
						<th><center>GENERAR TXT</center></th>			
						<th><center>DESCARGAR </center></th>			
					  </tr>
					</thead>
					<tbody>";
					
			if($ayo!=""){ @$uno = "AND AYO=$ayo"; } else { @$uno = ""; }
			if($sector!=""){ @$dos = "AND SECTOR=$sector"; } else { @$dos = ""; }
			if($del and $al !=""){ @$tres = "AND PERIODO_INICIO between '$del' and '$al' or PERIODO_FIN between '$del' and '$al'"; } else { @$tres = ""; }
					
					
					
					 $sql_reporte ="SELECT AYO,ID_RECIBO,SECTOR,ID_USUARIO,R_SOCIAL,TOTAL_REDONDEADO,CVE_SITUACION,PERIODO_INICIO,PERIODO_FIN
FROM Factura
WHERE CVE_SITUACION IN (4,5) $uno $dos $tres ";
				$res_reporte = sqlsrv_query($conn,$sql_reporte);
					
					// codigo php
						$b=0;
								while($row_reporte = sqlsrv_fetch_array($res_reporte)){	
								
								$a = $row_reporte['AYO'];
								$id = $row_reporte['ID_RECIBO'];
								$sec = $row_reporte['SECTOR'];
								$usu = $row_reporte['ID_USUARIO'];
								$rsoc = $row_reporte['R_SOCIAL'];
								$tot = $row_reporte['TOTAL_REDONDEADO'];
								$per1 = date_format($row_reporte['PERIODO_INICIO'], $format);
								$per2 = date_format($row_reporte['PERIODO_FIN'], $format);
								$sit = $row_reporte['CVE_SITUACION'];
								
								//$fecha= date_format($row_reporte['FECHA_ALTA'], $format);
								
									if($a%2==0){ $color='background-color:#E1EEF4';	}else{	$color='background-color:#FFFFFF';	}				
																							
<<<<<<< HEAD
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
							$html.="<input type='submit' name='gTimbrado' value='GENERAR TXT' class='btn btn-primary btn-sm center-block' formaction='archivotimbrado.php?ayo=$ayo&recibo=$id'>";
							$html.="</center></td>
=======
					    $html.="<tr style='$color; '>
							<td><center> $a </td>
							<td><center> $id </td>
							<td><center> $sec </td>
							<td><center> $usu </td>
							<td><center> ".htmlentities ($rsoc)." </td>
							<td><center> $tot </td>
							<td><center> $per1 </td>
							<td><center> $per2 </td>
							<td><center>"; if($sit==4){ $html.="
							<center><button type='button' class='btn btn-primary btn-sm' data-toggle='modal' onclick='variable( ".$a." , ".$usu." )' data-target='#myModal'>GENERAR TXT</button></center>"; }elseif ($sit==5){ $html.="<img src='../dist/img/verde.png' height='20'>";
							 } $html.="</center></td>
							<td><center>"; if($sit==5){ 
							$html.="<a href='excel_facturacion.php' class='btn btn-success btn-xs center-block'>DESCARGAR</a>
							 "; }else{	$html."<img src='../dist/img/rojo.png' height='20'>"; } $html.="</center></td>
>>>>>>> 4429abca44dcb3015a82c3f3cae8b181bc7e2ea5
					  </tr>";
					  if($sit==2){ $b++; }
					}	  	
<<<<<<< HEAD
					 $html.="<tr><td colspan='8'><center><br><br>&nbsp;</td>";
					 $html.="<td><center><br>";
					 $html.="<input type='submit' name='gmasivo' value='GENERAR TXT MASIVO' class='btn btn-info btn-sm center-block' formaction='archivomasivo.php?Ayo=$ayo&Sector=$sector&Del=$del&Al=$al'";
					 $html.="<br></center></td></tr>	
=======
					  $html.="<tr>
							<td colspan='8'><center> </td>
							
							<td><center>"; if($b>1){ 
							$html.="<a href='excel_facturacion.php'  class='btn btn-info btn-xs center-block'>MASIVO GENERAR TXT</a>";
							 }else{	$html.="<img src='../dist/img/rojo.png' height='20'>"; } $html.="</center></td>
							
							<td><center><button type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#myModal'>MASIVO DESCARGAR</button></center> </td>
							
					</tr>	
>>>>>>> 4429abca44dcb3015a82c3f3cae8b181bc7e2ea5
					</tbody>
				  </table>"; 
					  
		echo $html;			  

?>