<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
$format="d/m/Y";


 @$ayo=$_REQUEST['Ayo'];
 @$usu=$_REQUEST['Usu'];
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
						<th><center>ID FACTURA</center></th>
						<th><center>ID USUARIO</center></th>
						<th><center>SECTOR</center></th>
						<th><center>DESTACAMENTO</center></th>
						<th><center>R. SOCIAL</center></th>
						
								
						<th><center>SITUACION</center></th>
						<th><center>TOTAL</center></th>	
						<th><center>FORMATO</center></th>		
					  </tr>
					</thead>
					<tbody>";
					
			if($ayo!=""){ @$uno = "AND AYO=$ayo"; } else { @$uno = ""; }
			if($sector!=""){ @$dos = "AND SECTOR=$sector"; } else { @$dos = ""; }
			if($usu!=""){ @$tres = "AND ID_USUARIO='$usu'"; } else { @$tres = ""; }
			if($del and $al !=""){ @$cuatro = "AND PERIODO_INICIO between '$del' and '$al' or PERIODO_FIN between '$del' and '$al'"; } else { @$cuatro = ""; }
					
					$sql_reporte ="select AYO,ID_FACTURA,F.CVE_TIPO_FACTURA,T.TIPO_FACTURA,ID_USUARIO,SECTOR,DESTACAMENTO,R_SOCIAL,TOTAL, TIMBRADO,F.CVE_SITUACION, S.SITUACION from Factura F
inner join Factura_C_Situacion S ON F.CVE_SITUACION = S.CVE_SITUACION
inner join C_Tipo_Factura T ON F.CVE_TIPO_FACTURA = T.CVE_TIPO_FACTURA
WHERE F.CVE_SITUACION IN (4,5) $uno $dos $tres $cuatro";
				$res_reporte = sqlsrv_query($conn,$sql_reporte);
					
					// codigo php
						$b=0;
								while($row_reporte = sqlsrv_fetch_array($res_reporte)){	
								
								@$a = $row_reporte['AYO'];
								@$id = $row_reporte['ID_FACTURA'];
								@$usu = $row_reporte['ID_USUARIO'];
								@$sec = $row_reporte['SECTOR'];
								@$des = $row_reporte['DESTACAMENTO'];
								@$rsoc = $row_reporte['R_SOCIAL'];
								@$sit = $row_reporte['SITUACION'];
								@$tot = $row_reporte['TOTAL'];
								
								//$fecha= date_format($row_reporte['FECHA_ALTA'], $format);
								
									if($a%2==0){ $color='background-color:#E1EEF4';	}else{	$color='background-color:#FFFFFF';	}				
																							
					    $html.="<tr style='$color; '>
							<td><center> $a </td>
							<td><center> $id </td>
							<td><center> $usu </td>
							<td><center> $sec </td>
							<td><center> $des </td>
							<td><center> ".htmlentities ($rsoc)." </td>
							<td><center> $sit </center></td>
							<td><center> $tot </center></td>
							<td><center> <a href='../includes/FACTURACION/pdf_informe_presupuestal.php'><img src='../dist/img/pdf.png' height='20'></a></center></td>
					  </tr>";
					}	  	
					  $html.="
					</tbody>
				  </table>"; 
					  
		echo $html;			  

?>