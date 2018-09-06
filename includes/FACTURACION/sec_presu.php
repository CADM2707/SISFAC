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

if($usu!="" and @$cinco ==""){ @$tres = "AND ID_USUARIO='$usu'"; } else { @$tres = ""; }

if($del and $al !="" and @$cinco ==""){ @$cuatro = "AND PERIODO_INICIO between '$del' and '$al' and PERIODO_FIN between '$del' and '$al'"; } else { @$cuatro = ""; }

if($del and $al and $usu !="") { @$cinco = "AND ID_USUARIO='$usu' AND PERIODO_INICIO between '$del' and '$al' and PERIODO_FIN between '$del' and '$al'"; } else { @$cinco = "";}

if($del and $al and $usu and $sector !="") { @$seis = "AND ID_USUARIO='$usu' AND SECTOR=$sector AND PERIODO_INICIO between '$del' and '$al' and PERIODO_FIN between '$del' and '$al'";} else { @$seis = "";}

if($del and $al and $sector !="") { @$once = "AND SECTOR=$sector AND PERIODO_INICIO between '$del' and '$al' and PERIODO_FIN between '$del' and '$al'"; } else { @$once = "";}

if($usu and $sector and $ayo !=""){ @$siete = "AND ID_USUARIO='$usu' AND SECTOR=$sector AND AYO=$ayo"; } else { @$siete = ""; }

if($usu and $sector !=""){ @$ocho = "AND ID_USUARIO='$usu' AND SECTOR=$sector"; } else { @$ocho =""; }

if($usu and $ayo !=""){ @$nueve = "AND ID_USUARIO='$usu' AND AYO=$ayo"; } else { @$nueve =""; }

if($sector and $ayo !=""){ @$diez = "AND SECTOR=$sector AND AYO=$ayo"; } else { @$diez =""; }


				$sql_reporte ="select AYO,ID_FACTURA,F.CVE_TIPO_FACTURA,T.TIPO_FACTURA,F.ID_USUARIO,SECTOR,DESTACAMENTO,R_SOCIAL,TOTAL, TIMBRADO,F.CVE_SITUACION, S.SITUACION, P.CVE_FORMATO from Factura F
inner join Factura_C_Situacion S ON F.CVE_SITUACION = S.CVE_SITUACION
inner join C_Tipo_Factura T ON F.CVE_TIPO_FACTURA = T.CVE_TIPO_FACTURA
inner join Parametros_Facturacion P on P.ID_USUARIO = F.ID_USUARIO
WHERE F.CVE_SITUACION IN (4,5) and F.CVE_TIPO_FACTURA >=11 $uno $dos $tres $cuatro $cinco $seis $siete $ocho $nueve $diez $once";
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
								@$c_form=$row_reporte['CVE_FORMATO'];
								

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
							<td><center> $tot </center></td>";
							
							if(@$c_form==1){
							
							$html.="<td><center> <a href='../includes/facturacion/pdf_informe_presupuestal_p1.php?usuario=$usu&ayo=$a&recibo=$id' target='_blank'><img src='../dist/img/pdf.png' height='20'></a></center></td>";
							
							} else if(@$c_form==2){
								
							$html.="<td><center> <a href='../includes/facturacion/pdf_informe_presupuestal_p2.php?usuario=$usu&ayo=$a&recibo=$id' target='_blank'><img src='../dist/img/pdf.png' height='20'></a></center></td>";	
							
							} else if(@$c_form==3){
							
							$html.="<td><center> <a href='../includes/facturacion/pdf_informe_presupuestal_p3.php?usuario=$usu&ayo=$a&recibo=$id' target='_blank'><img src='../dist/img/pdf.png' height='20'></a></center></td>";	
							
							} else if(@$c_form==4){
								
							$html.="<td><center> <a href='../includes/facturacion/pdf_informe_presupuestal_p4.php?usuario=$usu&ayo=$a&recibo=$id' target='_blank'><img src='../dist/img/pdf.png' height='20'></a></center></td>";	
							
							} else if(@$c_form==5){
							
							$html.="<td><center> <a href='../includes/facturacion/pdf_informe_presupuestal_p5.php?usuario=$usu&ayo=$a&recibo=$id' target='_blank'><img src='../dist/img/pdf.png' height='20'></a></center></td>";
							
							
							} else if(@$c_form==6){
								
							$html.="<td><center> <a href='../includes/facturacion/pdf_informe_presupuestal_p6.php?usuario=$usu&ayo=$a&recibo=$id' target='_blank'><img src='../dist/img/pdf.png' height='20'></a></center></td>";	
							
							} else if(@$c_form==7){
							
							$html.="<td><center> <a href='../includes/facturacion/pdf_informe_presupuestal_p7.php?usuario=$usu&ayo=$a&recibo=$id' target='_blank'><img src='../dist/img/pdf.png' height='20'></a></center></td>";	
							
							} else if(@$c_form==8){
								
							$html.="<td><center> <a href='../includes/facturacion/pdf_informe_presupuestal_p8.php?usuario=$usu&ayo=$a&recibo=$id' target='_blank'><img src='../dist/img/pdf.png' height='20'></a></center></td>";	
							
							} else if(@$c_form==9){
							
							$html.="<td><center> <a href='../includes/facturacion/pdf_informe_presupuestal_p9.php?usuario=$usu&ayo=$a&recibo=$id' target='_blank'><img src='../dist/img/pdf.png' height='20'></a></center></td>";
							
							
							} else if(@$c_form==10){
							
							$html.="<td><center> <a href='../includes/facturacion/pdf_informe_presupuestal_p10.php?usuario=$usu&ayo=$a&recibo=$id' target='_blank'><img src='../dist/img/pdf.png' height='20'></a></center></td>";	
							
							} else if(@$c_form==11){
								
							$html.="<td><center> <a href='../includes/facturacion/pdf_informe_presupuestal_p11.php?usuario=$usu&ayo=$a&recibo=$id' target='_blank'><img src='../dist/img/pdf.png' height='20'></a></center></td>";	
							
							} else if(@$c_form==12){
							
							$html.="<td><center> <a href='../includes/facturacion/pdf_informe_presupuestal_p12.php?usuario=$usu&ayo=$a&recibo=$id' target='_blank'><img src='../dist/img/pdf.png' height='20'></a></center></td>";
							
							}
							
							
					$html.="</tr>";
					}
					  $html.="
					</tbody>
				  </table>";
				  
				  
				  if(@$a==""){ $html.="<br>
					<div class='alert alert-danger alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<strong>NO EXISTEN DATOS</strong>  
					</div>
                    <meta http-equiv='refresh' content='5'>";
				 } 
					
				

		echo $html;

?>
