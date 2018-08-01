<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
$format="d/m/Y";


 @$ayo=$_REQUEST['Ayo'];
 @$sector=$_REQUEST['Sector'];
 @$del=$_REQUEST['Del'];
 @$al=$_REQUEST['Al'];
 $html = "";
 
 // Consulta de la tabla

				//$count_reporte=sqlsrv_fetch_array($res_reporte);	
				//if($count_reporte>0){ 
 
 // codigo html
$html.=" <br>
<table class='table table-hover table-responsive' style='font-size:11px;'>
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
					  </tr>";
					  if($sit==2){ $b++; }
					}	  	
					  $html.="<tr>
							<td colspan='8'><center> </td>
							
							<td><center>"; if($b>1){ 
							$html.="<a href='excel_facturacion.php'  class='btn btn-info btn-xs center-block'>MASIVO GENERAR TXT</a>";
							 }else{	$html.="<img src='../dist/img/rojo.png' height='20'>"; } $html.="</center></td>
							
							<td><center><button type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#myModal'>MASIVO DESCARGAR</button></center> </td>
							
					</tr>	
					</tbody>
				  </table>"; 
					  
		echo $html;			  

?>