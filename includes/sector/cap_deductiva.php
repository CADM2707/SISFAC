<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 
 @$usuario=$_REQUEST['Usuario'];
 @$servicio=$_REQUEST['Servicio'];
 $format="d/m/Y"; 
 $html = "";
 $sql_deductiva="select CVE_TIPO_DEDUCTIVA,DEDUCTIVA from C_Deductivas";       
 $res_deductiva = sqlsrv_query( $conn,$sql_deductiva);
  				
				
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
				 @$html.="<br><br>
				<div  class='col-md-12 col-sm-12 col-xs-12'><br><center><a href='reportes/rep_sec_deductivas.php?usuario=$usuario&servicio=$servicio'  class='btn btn-warning btn-sm' >Reporte</a><br></div>
				<br><br><br><br><h3>DATOS DEL USUARIO</h3>
				<table class='table table-hover table-responsive' style='font-size:11px;'>
					<thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>ID USUARIO</center></th>						
						<th><center>SERVICIO</center></th>						
						<th><center>RAZON SOCIAL</center></th>
						<th><center>RFC</center></th>						
						<th><center>SECTOR</center></th>
						<th><center>DEST.</center></th>
					  </tr>
					  </thead>
						<tr>
						<td><center> $id</td>
						<td><center> $servicio </td>
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
				
				$sql_consulta ="EXEC  [dbo].[sp_Consulta_Deductivas] '$usuario',$servicio";
				$res_consulta = sqlsrv_query($conn,$sql_consulta);
				
				
				$html.="<center><br><br>
				<table class='table table-hover table-responsive' style='font-size:11px; width:50%;'>
					<thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>DEDUCTIVA</center></th>						
						<th><center>CANTIDAD</center></th>
						<th><center>MONTO</center></th>						
					  </tr>
					  </thead>";
					  
						while($row_consulta = sqlsrv_fetch_array($res_consulta)){
							$deductiva=utf8_encode($row_consulta['DEDUCTIVA']); 
							$cantidad=$row_consulta['CANTIDAD']; 
							$monto=$row_consulta['MONTO']; 							
					  
					 $html.=" <tr>
						<td><center>$deductiva</td>
						<td><center>$cantidad</td>
						<td><center>$monto</td>
					  </tr>";
					   } 
					$html.="</table>  
					</center><br><br><br><br>";
					

					
					$html.="	<div  class='col-md-2 col-sm-2 col-xs-2'></div>
						<div  class='col-md-2 col-sm-2 col-xs-2'>
							<center><label>AÑO:</label></center>
							<input type='number' name='ayo'  id='ayo'  style='text-align:center;'   class='form-control' >
						</div>
						<div  class='col-md-2 col-sm-2 col-xs-2'>
							<center><label>QNA:</label></center>
							<input type='number' name='qna'  id='qna'  style='text-align:center;'   class='form-control' >
						</div>
						<div  class='col-md-2 col-sm-2 col-xs-2'>
							<center><label>CANTIDAD :</label></center>
							<input type='text' name='cantidad'    id='cantidad' style='text-align:center;'  class='form-control'  >
						</div>
						<div  class='col-md-2 col-sm-2 col-xs-2'>	
							<center><label>DEDUCTIVA:</label></center>
							<select name='deductiva' class='form-control' style='text-align:center;'  id='deductiva' >
								<option value='' selected='selected'>SELECC...</option>";
									while($row_deductiva = sqlsrv_fetch_array($res_deductiva)){  								
									$html.="<option value=".$row_deductiva['CVE_TIPO_DEDUCTIVA'].">".utf8_encode($row_deductiva['DEDUCTIVA'])."</option>";
								 } 
						$html.="	</select> 
						</div>
						<div  class='col-md-12 col-sm-12 col-xs-12'><br>			
							<button  type='button' onclick='Deductiva()' class='btn btn-primary center-block'>GUARDAR</button>
						</div>";
 
 
					  
		echo $html;			  

?>


