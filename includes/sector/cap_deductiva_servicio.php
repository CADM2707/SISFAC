<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();

 @$usuario=$_REQUEST['Usuario'];
 $format="d/m/Y"; 
 $html = "";
 $sql_deductiva="select CVE_TIPO_DEDUCTIVA,DEDUCTIVA from C_Deductivas";       
 $res_deductiva = sqlsrv_query( $conn,$sql_deductiva);
		$html.="	<div  class='col-md-2 col-sm-2 col-xs-2'>
						<center><label>SERVICIO:</label></center>				
						<select name='servicio' class='form-control' id='servicio' onchange='Servicio()'>
							<option value='' selected='selected'>SELECC...</option>";
						$sql_servicio="SELECT ID_SERVICIO,MARCA FROM SECTOR.DBO.Usuario_Servicio WHERE ID_USUARIO='$usuario'";       
						$res_servicio = sqlsrv_query( $conn,$sql_servicio); 		
						while($row_servicio = sqlsrv_fetch_array($res_servicio)){ 						
				$html.="<option value=".$row_servicio['ID_SERVICIO'].">".$row_servicio['ID_SERVICIO'].' - '.$row_servicio['MARCA']."</option>";
								  } 
					$html.="		</select>     
					</div>";
					  
		echo $html;			  

?>


