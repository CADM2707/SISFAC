<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 session_start();
 $idOp=$_SESSION['ID_OPERADOR'];
 @$usuario=$_REQUEST['Usuario'];
 @$ayo=$_REQUEST['Ayo'];
 @$subtotal=$_REQUEST['Subtotal'];
 @$iva=$_REQUEST['Iva'];
 @$folio_sat=$_REQUEST['Folio_sat'];
 @$total=$_REQUEST['Total'];
 @$timbrado=$_REQUEST['Timbrado'];
 @$total_r=$_REQUEST['Total_r'];
 @$importe_letra=$_REQUEST['Importe_letra'];
 @$periodo_letra=$_REQUEST['Periodo_letra'];
 @$fecha_e=$_REQUEST['Fecha_e'];
 @$inicio=$_REQUEST['Inicio'];
 @$fin=$_REQUEST['Fin'];
 @$situacion=$_REQUEST['Situacion']; 
 
 $format="d/m/Y"; 
 $html = "";
				$sql_agrega ="exec [sp_Captura_Facturacion_Especial] 
				$ayo,'$usuario','$fecha_e',$subtotal,$iva,$total,$total_r,'$importe_letra',
				'$periodo_letra','$inicio','$fin',$idOp,$timbrado,'$folio_sat',$situacion";
				$res_agrega = sqlsrv_query($conn,$sql_agrega);
				$row_agrega = sqlsrv_fetch_array($res_agrega);
				$mensaje=$row_agrega['MENSAJE']; 
				if($mensaje=="CAPTURA DE FACTURA ESPECIAL CORRECTAMENTE"){ 
				$html.="				
				<div  class='col-md-12 col-sm-12 col-xs-12'>&nbsp;<br></div>
				<div  class='col-md-12 col-sm-12 col-xs-12' >
					<div class='alert alert-success' role='alert'>
					  <strong>EXITO!</strong> $mensaje
					</div>";
					}else{	
				$html.="
					<div class='alert alert-danger' role='alert'>
						<strong>CUIDADO!</strong>NO SE GUARDO EL REGISTRO
					</div>
				</div>";
			 } 
					  
		echo $html;			  

?>
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