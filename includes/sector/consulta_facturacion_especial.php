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
 
  
 
 $format="d/m/Y"; 
 $html = "";
				$sql_agrega ="EXEC  [dbo].[sp_Consulta_Usuario] '$usuario'";
				$res_agrega = sqlsrv_query($conn,$sql_agrega);
				$row_agrega = sqlsrv_fetch_array($res_agrega);
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
				$html .="
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
						<td><center> $social </td>
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
				/*$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
				$stmt = sqlsrv_query( $conn, $sql_reporte , $params, $options );

				$row_count = sqlsrv_num_rows( $stmt );*/
				//if($row_count>0){
			
				$html .= "  
					<h3>DESGLOSE DE FACTURAS</h3>				
				  <table class='table table-hover table-responsive' style='font-size:11px;'>
					<thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>SUBTOTAL</center></th>						
						<th><center>IVA</center></th>
						<th><center>TOTAL</center></th>						
						<th><center>LEYENDA</center></th>
						<th><center>MONTO</center></th>
						<th><center>LEYENDA DEDUCTIVA</center></th>
						
					  </tr>
					</thead>
					<tbody>"; $a=1;
							while($row_reporte = sqlsrv_fetch_array(@$res_reporte)){									
								if($a%2==0){ $color="background-color:#E1EEF4";	}else{	$color="background-color:#FFFFFF";	}
								$subtotal=$row_reporte['SUBTOTAL'];								
								$iva=$row_reporte['IVA'];								
								$total=@$row_reporte['TOTAL'];
								$leyenda=@$row_reporte['LEYENDA'];								
								$monto=@$row_reporte['MONTO'];								
								$deductiva=@$row_reporte['DEDUCTIVA'];								
						$html .="<tr style='$color'>
							<td><center> $subtotal</td>
							<td><center> $iva </td>
							<td><center> $total</td>
							<td><center> $leyenda</td>							
							<td><center> $monto</td>							
							<td><center> ".utf8_encode($deductiva)."</td>							
					  </tr>";
					     }	  
					$html.="</tbody>
				  </table>";

						
						
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
							
echo $html;
?>
