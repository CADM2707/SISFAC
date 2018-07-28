<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 
 @$usuario=$_REQUEST['Usuario'];
 $format="d/m/Y"; 
 $html = "";
 	
							$sql_razon ="select R_SOCIAL,RFC from sector.dbo.v_usuario_padron where ID_USUARIO='$usuario'";
							$res_razon = sqlsrv_query( $conn,$sql_razon);
							$row_razon = sqlsrv_fetch_array($res_razon);
							$r_social=$row_razon['R_SOCIAL'];
							$rfc=$row_razon['RFC']; 
	$html = "			<div  class='col-md-12 col-sm-12 col-xs-12'>
							<center><h2><b>$usuario - $r_social <br> $rfc</b></h2></center>
						</div>
						<div  class='col-md-3 col-sm-3 col-xs-3'>
							<center><label>TURNOS:</label></center>
							<input type='number' name='turnos' id='turnos'  style='text-align:center;'   class='form-control' >
						</div>
						<div  class='col-md-3 col-sm-3 col-xs-3'>
							<center><label>AÑO:</label></center>
							<input type='number' name='ayo'  id='ayo' style='text-align:center;'   class='form-control' >
						</div>
						<div  class='col-md-3 col-sm-3 col-xs-3'>
							<center><label>QUINCENA:</label></center>
							<input type='number' name='qna' id='qna'   style='text-align:center;'  class='form-control' >
						</div>
						
						<div  class='col-md-3 col-sm-3 col-xs-3'>
							<center><label>SERVICIO:</label></center>				
							<select name='servicio' class='form-control' id='servicio'>
								<option value='' selected='selected'>SELECC...</option>";
								$sql_servicio="SELECT ID_SERVICIO,MARCA FROM SECTOR.DBO.Usuario_Servicio WHERE ID_USUARIO='$usuario'";       
								$res_servicio = sqlsrv_query( $conn,$sql_servicio); 		
								while($row_servicio = sqlsrv_fetch_array($res_servicio)){ 						
					$html.= "	<option value=".$row_servicio['ID_SERVICIO']." >".$row_servicio['ID_SERVICIO'].' - '.$row_servicio['MARCA']."</option>";
								 }
					$html.= "		</select>     
						</div>
						<div  class='col-md-12 col-sm-12 col-xs-12'><br>
						<button  type='button' onclick='Agregar_ajuste()' class='btn btn-primary center-block'>AGREGAR AJUSTE</button>
						</div>
						";
 
 
					  
		echo $html;			  

?>


