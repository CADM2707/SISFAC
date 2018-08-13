<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 session_start();
 $idOp=$_SESSION['ID_OPERADOR'];
 @$usuario=$_REQUEST['Usuario'];
 @$ayo=$_REQUEST['Ayo'];
 @$qna=$_REQUEST['Qna'];
 @$turnos=$_REQUEST['Turnos'];
 @$importe=$_REQUEST['Importe'];
 @$tarifa=$_REQUEST['Tarifa'];
 @$leyenda=$_REQUEST['Leyenda'];
 
 $format="d/m/Y"; 
 $html = "";
				$sql_agrega ="exec [sp_Captura_Facturacion_Especial] 
				'$usuario',$ayo,$qna,$turnos,$tarifa,$importe,'$leyenda',$idOp";
				$res_agrega = sqlsrv_query($conn,$sql_agrega);
				$row_agrega = sqlsrv_fetch_array($res_agrega);
				$mensaje=$row_agrega['MENSAJE']; 
				if($mensaje=="CAPTURA DE FACTURA ESPECIAL CORRECTAMENTE"){ 
				$html.="				
				<br><br><br><div  class='col-md-12 col-sm-12 col-xs-12'>&nbsp;<br></div>
				<div  class='col-md-12 col-sm-12 col-xs-12' >
					<div class='alert alert-success' role='alert'>
					  <strong>EXITO!</strong> $mensaje
					</div>";
					}else if($mensaje=="NO PUEDE CAPTURAR LA FACTURA ESPECIAL, YA SE ENCUENTRA VALIDADA"){	
				$html.="
					<br><br><div class='alert alert-danger' role='alert'>
						<strong>CUIDADO!</strong> $mensaje
					</div>
				</div>";
			 } 
					  
		echo $html;			  

?>
		<script>
			function r() { location.href="sec_facturacion_especial.php" } 
			setTimeout ("r()", 5000);
		</script>
<script src="../dist/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() { 
    setTimeout(function() {
        $(".alert-success").fadeOut(3000);
    },4000);
});
$(document).ready(function() {
    setTimeout(function() {
        $(".alert-danger").fadeOut(3000);
    },4000);
});
</script>