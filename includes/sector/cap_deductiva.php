<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 session_start();
 @$usuario=$_REQUEST['Usuario'];
 @$servicio=$_REQUEST['Servicio'];
 @$ayo=$_REQUEST['Ayo'];
 @$qna=$_REQUEST['Qna'];
 $format="d/m/Y"; 
 $html = "";
 $sql_deductiva="select CVE_TIPO_DEDUCTIVA,DEDUCTIVA from C_Deductivas where CVE_TIPO_DEDUCTIVA IN (1,2)";       
 $res_deductiva = sqlsrv_query( $conn,$sql_deductiva);
  @$sec=$_SESSION['SECTOR'];	 					
				
				$sql_agrega ="EXEC  [dbo].[sp_Consulta_Usuario] '$usuario' ,$sec";
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_CLIENT_BUFFERED );
				$stmt = sqlsrv_query( $conn, $sql_agrega , $params, $options );

				$row_count = sqlsrv_num_rows( $stmt );
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
				if($row_count>0){
				 @$html.="<br><br>
				<div  class='col-md-12 col-sm-12 col-xs-12'><br><center><a href='reportes/rep_sec_deductivas.php?usuario=$usuario&servicio=$servicio&ayo=$ayo&qna=$qna'  class='btn btn-warning btn-sm' >Reporte</a><br></div>
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
						<td><center> ".utf8_encode($colonia)." </td>
						<td><center> ".utf8_encode($entidad)."</td>
						<td><center> ".utf8_encode($localidad)."</td>
						<td><center> $cp</td>
					  </tr>
					</table>  ";
				
				$sql_consulta ="EXEC  [dbo].[sp_Consulta_Deductivas] '$usuario',$servicio,$ayo,$qna";
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
							@$s_cantidad=@$s_cantidad+$cantidad;
							@$s_monto=@$s_monto+$monto;
							if(@$s_cantidad>0){ $s_cantidad=number_format(@$s_cantidad, 2, '.', ','); }
							if(@$s_monto>0){ $s_monto=number_format(@$s_monto, 2, '.', ','); }
					  
					 $html.=" <tr>
						<td><center>$deductiva</td>
						<td><center>$cantidad</td>
						<td><center>$monto</td>
					  </tr>";
					   } if(@$s_cantidad>0){
					$html.=" <tr style='background-color:#e09f9f;'>
						<td><center>TOTAL</td>
						<td><center>$s_cantidad</td>
						<td><center>$s_monto</td>
					  </tr>"; }
					$html.="</table>  
					</center><br><br><br><br>";
					

					
					$html.="	<div  class='col-md-2 col-sm-2 col-xs-2'></div>
						<div  class='col-md-2 col-sm-2 col-xs-2'>	
							<center><label>TIPO:</label></center>
							<select name='tipo' class='form-control' style='text-align:center;'  id='tipo' >
								<option value='' selected='selected'>SELECC...</option>
								<option value=1 >POR TURNOS</option>
								<option value=2 >POR PORCENTAJE</option>
								</select> 
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
						$html.="</select> 
						</div>
						<div  class='col-md-2 col-sm-2 col-xs-2'>
							<center><label>LEYENDA :</label></center>
							<input type='text' name='leyenda'    id='leyenda' style='text-align:center;'  class='form-control'  >
						</div>
						<div  class='col-md-12 col-sm-12 col-xs-12'><br>			
							<button  type='button' onclick='Deductiva()' class='btn btn-primary center-block'>GUARDAR</button>
						</div>";
 
 
					  
				  
		}else{
			@$html.="<br><br><br><br><div class='alert alert-danger' role='alert'>
									<strong>NO EXISTEN RESULTADOS</strong>
								</div>";
			
		}
		echo $html;	
?>


