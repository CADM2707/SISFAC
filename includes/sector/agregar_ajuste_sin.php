<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 session_start();
 $idOp=$_SESSION['ID_OPERADOR'];
 @$usuario=$_REQUEST['Usuario'];
 @$ayo=$_REQUEST['Ayo'];
 @$qna=$_REQUEST['Qna'];
 @$turnos=$_REQUEST['Turnos'];
 @$ope=$_REQUEST['Ope'];
 @$servicio=$_REQUEST['Servicio'];
 $format="d/m/Y"; 
 $html = "";
				$sql_agrega ="exec sp_Captura_Turnos_Ajuste_Sin_Ele '$usuario',$servicio,$ayo,$qna,$turnos,$idOp";
				$res_agrega = sqlsrv_query($conn,$sql_agrega);
				$row_agrega = sqlsrv_fetch_array($res_agrega);
				$mensaje=$row_agrega['MENSAJE']; 
				if($mensaje=="AJUSTE CAPTURADO CORRECTAMENTE"){ 
				$html.="				
				<div  class='col-md-12 col-sm-12 col-xs-12'>&nbsp;<br></div>
				<div  class='col-md-12 col-sm-12 col-xs-12' >
					<div class='alert alert-success'>
					  <strong>EXITO!</strong> $mensaje
					</div>";
					}else if($mensaje=="NO SE PUEDEN AJUSTAR TURNOS A SOLICITUDES YA PROCESADAS"){	
				$html.="
					<div class='alert alert-danger'>
						<strong>CUIDADO!</strong> $mensaje
					</div>
				</div>";
			 } 
					  
		echo $html;			  

?>