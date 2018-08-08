<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 session_start();
 $idOp=$_SESSION['ID_OPERADOR'];
 @$usuario=$_REQUEST['Usuario'];
 @$servicio=$_REQUEST['Servicio'];
 @$leyenda=$_REQUEST['Leyenda'];
 $format="d/m/Y"; 
 $html = "";
				$sql_reporte ="exec facturacion.dbo.[sp_Captura_leyenda] 1,'$usuario',$servicio,'$leyenda',$idOp";
				$res_reporte = sqlsrv_query($conn,$sql_reporte );
				$row_reporte = sqlsrv_fetch_array($res_reporte);
				$mensaje=trim($row_reporte['MENSAJE']);
				$html.="<div  class='col-md-12 col-sm-12 col-xs-12'>&nbsp;<br></div>
				<div  class='col-md-12 col-sm-12 col-xs-12' >";
				if($mensaje=='TIENE UNA SOLICITUD PENDIENTE, NO SE PUEDE SOLICITAR NUEVA LEYENDA HASTA QUE SE VALIDE O CANCELE  LA  ACTUAL'){ 
				$html.="				
					<div class='alert alert-danger'>
						<strong>$mensaje</strong>
					</div>
					";
					}if($mensaje=='SOLICITUD CAPTURADA CORRECTAMENTE'){	
				$html.="
					<div class='alert alert-success'>
					  <strong>$mensaje</strong> 
					</div>";
			 } 
				$html.="
				</div>"	  ;
		echo $html;			  
		
?>		<script>
			function r() { location.href="sec_leyenda.php?usuario=<?php echo $usuario; ?>&servicio=<?php echo $servicio; ?>" } 
			setTimeout ("r()", 4000);
		</script>