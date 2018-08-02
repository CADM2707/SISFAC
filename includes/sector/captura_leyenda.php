<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 session_start();
 $idOp=$_SESSION['ID_OPERADOR'];
 @$usuario=$_REQUEST['Usuario'];
 @$servicio=$_REQUEST['Servicio'];
 @$accion=$_REQUEST['Accion'];
 @$leyenda=$_REQUEST['Leyenda'];
 $format="d/m/Y"; 
 $html = "";
				$sql_reporte ="exec facturacion.dbo.[sp_Captura_leyenda] $accion,'$usuario',$servicio,'$leyenda',$idOp";
				$res_reporte = sqlsrv_query($conn,$sql_reporte );
				if($res_reporte>0){ 
				$html.="				
				<div  class='col-md-12 col-sm-12 col-xs-12'>&nbsp;<br></div>
				<div  class='col-md-12 col-sm-12 col-xs-12' >
					<div class='alert alert-success'>
					  <strong>EXITO!</strong> 
					</div>";
					}else{	
				$html.="
					<div class='alert alert-danger'>
						<strong>CUIDADO!</strong>
					</div>
				</div>
				";
			 } 
					  
		echo $html;			  
		
?>		<script>
			function r() { location.href="sec_leyenda.php?usuario=<?php echo $usuario; ?>&servicio=<?php echo $servicio; ?>" } 
			setTimeout ("r()", 4000);
		</script>