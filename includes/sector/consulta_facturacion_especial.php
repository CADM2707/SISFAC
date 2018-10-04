<style>
.right {
    text-align: right;
    float: right;
}
</style>
<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 session_start();
 $idOp=$_SESSION['ID_OPERADOR'];
 
 
 @$usuario=$_REQUEST['Usuario']; 
 @$ayo=$_REQUEST['Ayo']; 
 @$qna=$_REQUEST['Qna']; 
 @$ini=$_REQUEST['Inicio']; 
 @$fin=$_REQUEST['Fin']; 
 
 if(@$_REQUEST['Ayo'] >0){$ayo = $ayo;} else {$ayo = 'NULL';}
 if(@$_REQUEST['Qna'] >0){$qna = $qna;} else {$qna = 'NULL';}
 
 if(@$_REQUEST['Inicio'] != ""){$ini = $ini;} else {$ini = NULL;} 
 if(@$_REQUEST['Fin'] != ""){$fin = $fin;} else {$fin = NULL;} 
 @$sec=$_SESSION['SECTOR'];	 
  
 
 $format="d/m/Y"; 
 $html = "";
				$sql_agrega ="EXEC  [dbo].[sp_Consulta_Usuario] '$usuario',$sec";
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_CLIENT_BUFFERED );
				$stmt = sqlsrv_query( $conn, $sql_agrega , $params, $options );
				$row_agrega2 = sqlsrv_num_rows( $stmt );
				$row_agrega = sqlsrv_fetch_array($stmt);
				
				$id=$row_agrega['ID_USUARIO']; 
				$sector=$row_agrega['SECTOR']; 
				$destacamento=$row_agrega['DESTACAMENTO']; 
				$rfc=$row_agrega['RFC']; 
				$social=$row_agrega['R_SOCIAL']; 
				$domicilio=$row_agrega['DOMICILIO']; 
				$colonia=$row_agrega['COLONIA']; 
				$entidad=$row_agrega['ENTIDAD']; 
				$localidad=$row_agrega['LOCALIDAD']; 
				$cp=$row_agrega['CP'];
				$sql_previo="EXEC [sp_Consulta_Previo] '$usuario',$ayo,$qna";
				$res_previo = sqlsrv_query( $conn,$sql_previo);
				$row_previo = sqlsrv_fetch_array($res_previo);
				$c_fact=$row_previo['CVE_TIPO_FACTURA']; 
				$c_form=$row_previo['CVE_FORMATO']; 
				if($row_agrega2>0){
					$html.="<br><br><div class='right'>";
					if(@$c_fact<11){
						$html.="<a style='color:#337ab7;' href='../descargables/sector/pdf_previo_fact_esp.php?Ayo=$ayo&Qna=$qna&usuario=$usuario' target='_blank' data-toggle='modal' ><center><img src='../dist/img/fact.png' width='60px'></center></a>";
					}else if(@$c_form==1 and @$c_fact>10){
						$html.="<a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_1.php?ayo=$ayo&qna=$qna&usuario=$usuario' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='60px'></center></a>";
					}else if(@$c_form==2 and @$c_fact>10){
						$html.="<a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_2.php?ayo=$ayo&qna=$qna&usuario=$usuario' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='60px'></center></a>";
					}else if(@$c_form==3 and @$c_fact>10){
						$html.="<a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_3.php?ayo=$ayo&qna=$qna&usuario=$usuario' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='60px'></center></a>";
					}else if(@$c_form==4 and @$c_fact>10){
						$html.="<a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_4.php?ayo=$ayo&qna=$qna&usuario=$usuario' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='60px'></center></a>";
					}else if(@$c_form==5 and @$c_fact>10){
						$html.="<a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_5.php?ayo=$ayo&qna=$qna&usuario=$usuario' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='60px'></center></a>";
					}else if(@$c_form==6 and @$c_fact>10){
						$html.="<a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_6.php?ayo=$ayo&qna=$qna&usuario=$usuario' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='60px'></center></a>";
					}else if(@$c_form==7 and @$c_fact>10){
						$html.="<a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_7.php?ayo=$ayo&qna=$qna&usuario=$usuario' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='60px'></center></a>";
					}else{
						$html.="-";
					}
				$html .="</div><br><br><br>
				<div  class='col-md-12 col-sm-12 col-xs-12'><br></div>
				<h3>DATOS DEL USUARIO</h3>
				<table class='table table-hover table-responsive' style='font-size:11px;'>
					<thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>ID USUARIO</center></th>						
						<th><center>RAZON SOCIAL</center></th>
						<th><center>RFC</center></th>						
						<th><center>SECTOR</center></th>
						<th><center>DEST.</center></th>
					  </tr>
					  </thead>
						<tr>
						<td><center> $id</td>
						<td><center> ".utf8_encode($social)." </td>
						<td><center> $rfc</td>
						<td><center> $sector</td>
						<td><center> $destacamento</td>
					  </tr>
					  <thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>DOMICILIO</center></th>						
						<th><center>COLONIA</center></th>
						<th><center>ENTIDAD</center></th>						
						<th><center>LOCALIDAD</center></th>
						<th><center>C.P.</center></th>
					  </tr>
					  </thead>
						<tr>
						<td><center> ".utf8_encode($domicilio)."</td>
						<td><center> $colonia </td>
						<td><center> $entidad</td>
						<td><center> ".utf8_encode($localidad)."</td>
						<td><center> $cp</td>
					  </tr>
					</table>  ";
			 	$sql_reporte ="exec sp_Consulta_Factura_Especial '$usuario',$ayo,$qna, '$ini', '$fin'";
				$res_reporte = sqlsrv_query( $conn,$sql_reporte);
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_CLIENT_BUFFERED );
				$stmt = sqlsrv_query( $conn, $sql_reporte , $params, $options );

				$row_count = sqlsrv_num_rows( $stmt );
				if($row_count>0){
			
				$html .= "  
					<h3>DESGLOSE DE FACTURAS</h3>				
				  <table class='table table-hover table-responsive' style='font-size:11px;'>
					<thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>AÑO</center></th>						
						<th><center>QNA.</center></th>						
						<th><center>TURNOS</center></th>						
						<th><center>TARIFA</center></th>						
						<th><center>IMPORTE</center></th>						
						<th><center>SUBTOTAL</center></th>						
						<th><center>IVA</center></th>
						<th><center>TOTAL</center></th>						
						<th><center>LEYENDA</center></th>
						<th><center>MONTO</center></th>
						<th><center>LEYENDA DEDUCTIVA</center></th>
						<th><center>BORRAR</center></th>
						
					  </tr>
					</thead>
					<tbody>"; $a=1;
							while($row_reporte = sqlsrv_fetch_array(@$stmt)){									
								if($a%2==0){ $color="background-color:#E1EEF4";	}else{	$color="background-color:#FFFFFF";	}
								$subtotal=$row_reporte['SUBTOTAL'];								
								if($row_reporte['IVA']!=""){ $iva=number_format(@$row_reporte['IVA'], 2, '.', ',');	}
								$iva2=$row_reporte['IVA'];
								$ayo=@$row_reporte['AYO'];
								$des=@$row_reporte['ID_DESGLOSE'];
								$qna=@$row_reporte['QNA'];
								$id_fac=@$row_reporte['ID_FACTURA'];
								$total=@$row_reporte['TOTAL'];
								$leyenda=@$row_reporte['LEYENDA'];								
								$monto=@$row_reporte['MONTO'];								
								$t_monto=@$t_monto+$monto;
								$t_total=@$t_total+$total;
								$t_iva=@$t_iva+@$iva2;
								$t_subtotal=@$t_subtotal+$subtotal;
								$deductiva=@$row_reporte['LEYENDA_DEDUCTIVAS'];		

							if($row_reporte['IMPORTE']!=""){ $imp=number_format(@$row_reporte['IMPORTE'], 2, '.', ',');	}
							if($row_reporte['TARIFA']!=""){ $tar=number_format(@$row_reporte['TARIFA'], 2, '.', ',');	}
							if($row_reporte['TURNOS']!=""){ $tur=number_format(@$row_reporte['TURNOS'], 2, '.', ',');	}
								
						$html .="<tr style='$color'>
							<td><center> $ayo</td>
							<td><center> $qna</td>
							<td><center> $tur</td>
							<td><center> $tar</td>
							<td><center> $imp</td>
							<td><center> $subtotal</td>
							<td><center> $iva </td>
							<td><center> $total</td>
							<td><center> $leyenda</td>							
							<td><center> $monto</td>							
							<td><center> $deductiva</td>							
							<td><center> <button  type='button' onclick='Borrar( $id_fac , $ayo , $des )' class='btn btn-sm btn-danger center-block'>x</button></td>							
					  </tr>";
					     }	
							$html .="<tr style='background-color:#eff290;'>
							<td><center> </td>
							<td><center> </td>
							<td><center> </td>
							<td><center> </td>
							<td><center> </td>
							<td><center> $t_subtotal</td>
							<td><center> $t_iva </td>
							<td><center> $t_total</td>
							<td><center> </td>							
							<td><center> $t_monto</td>							
							<td><center> </td>							
							<td><center> </td>							
					  </tr>";	
					$html.="</tbody>
				  </table>";
				  }else{
					  @$html.="<div class='alert alert-danger' role='alert'>
								<strong>NO EXISTE DESGLOSE DE LA FACTURA</strong>
							</div>";
				  }
						
						
					$html.="
							<div class='col-md-11'></div>
							<div class='col-md-1'>
								<input type='button' class='btn btn-success' id='add_cancion()' onClick='addCancion()' value='+' /></div>
							</div><br><br><br>
							<div class='row' id='tutilos'   style='display: none;'>
								<div class='row' >
									<div class='col-md-12' style='background-color:#337ab7; color:white; '>
										<label ><center>CAPTURA DE DESGLOSE</center> </label>
									</div>
								</div>
								<div class='row'>
									<div class='col-md-8' style='background-color:#337ab7; color:white; '><label>DESGLOSE</label></div>
									<div class='col-md-4' style='background-color:#274d6d; color:white; '><label>DEDUCTIVAS</label></div>
								</div>
								<div class='row'>	
									<div class='col-md-2'  style='background-color:#337ab7; color:white; '><label>TURNOS:</label></div>
									<div class='col-md-2'  style='background-color:#337ab7; color:white; '><label>TARIFA</label></div>
									<div class='col-md-2'  style='background-color:#337ab7; color:white; '><label>IMPORTE</label></div>
									<div class='col-md-2'  style='background-color:#337ab7; color:white; '><label>LEYENDA</label></div>
									<div class='col-md-2'  style='background-color:#274d6d; color:white; '><label>MONTO</label></div>
									<div class='col-md-2'  style='background-color:#274d6d; color:white; '><label>LEYENDA</label></div>
								</div>	<br>
							</div>
							<div class='row' id='canciones'>
							</div>
							<div  class='col-md-12 col-sm-12 col-xs-12' id='boton' style='display: none;'><br>
							<button  type='button' onclick='Reporte()' class='btn btn-primary center-block'>GUARDAR FACTURA ESPECIAL</button>
							
						</div>
							";
							
	
	}else{
	 @$html.="<BR><BR><BR><BR><BR>	<div class='alert alert-danger' role='alert'>
				<strong>NO EXISTE RESULTADOS CON LOS FILTROS INGRESADOS</strong>
			</div>";
	}

echo $html;	
?>
