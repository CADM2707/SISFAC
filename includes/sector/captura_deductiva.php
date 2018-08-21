<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 session_start();
 $idOp=$_SESSION['ID_OPERADOR'];
 @$usuario=$_REQUEST['Usuario'];
 @$servicio=$_REQUEST['Servicio'];
 @$deductiva=$_REQUEST['Deductiva'];
 @$monto=$_REQUEST['Monto'];
 @$cantidad=$_REQUEST['Cantidad'];
 @$ayo=$_REQUEST['Ayo'];
 @$qna=$_REQUEST['Qna'];
 $format="d/m/Y"; 
 $html = "";
				$sql_reporte ="exec sp_Captura_Deductiva '$usuario',$servicio,$deductiva,$cantidad,$ayo,$qna";
				$res_reporte = sqlsrv_query($conn,$sql_reporte );
				$row_reporte = sqlsrv_fetch_array($res_reporte);
				$mensaje=trim($row_reporte['MENSAJE']);
				if($mensaje="DEDUCTIVA REGISTRADA CORRECTAMENTE"){
				$html.="				
				<div  class='col-md-12 col-sm-12 col-xs-12'>&nbsp;<br></div>
				<div  class='col-md-12 col-sm-12 col-xs-12' >
					<div class='alert alert-success'>
					  <strong>$mensaje</strong> 
					</div>";
					}else{	
				$html.="
					<div class='alert alert-danger'>
						<strong>CUIDADO! NO SE GUARDO EL REGISTRO</strong>
					</div>
				</div>
				";
			 } 
					  
		echo $html;			  
		
?>		<!--<script>
			function r() { location.href="sec_deductivas.php" } 
			setTimeout ("r()", 4000);
		</script>-->