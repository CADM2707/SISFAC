<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();
$idOp=$_SESSION['ID_OPERADOR'];

 @$anio=$_REQUEST['Anio'];
 @$qnas=$_REQUEST['Qnas'];
 @$soli=$_REQUEST['Soli'];
 @$tipo=$_REQUEST['tipo'];
 

 if(@$tipo==1){ //rechazar
	 $sql_up = "UPDATE Facturacion.DBO.Turnos_Facturacion SET CVE_SITUACION=3  WHERE ID_SOLICITUD=$soli AND AYO=$anio AND QNA=$qnas and CVE_SITUACION=2";
	 $res_up = sqlsrv_query($conn,$sql_up);
	 
	 if(@$res_up>0){ ?><br>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>LA SOLICITUD HA SIDO RECHAZADA</strong>  
					</div>
				<?php }else{ ?><br>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>ERROR AL RECHAZAR LA FACTURA</strong>  
					</div>
                   
				<?php } 
	 
 }
else if(@$tipo==2){


 $sql_reporte ="execute facturacion.[dbo].[sp_Inserta_Factura] $anio, $qnas, $soli, $idOp";
 $res_reporte = sqlsrv_query($conn,$sql_reporte);
							  

if($res_reporte>0){ ?><br>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>SOLICITUD DE FACTURA CORRECTAMENTE</strong>  
					</div>
				<?php }else{ ?><br>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>ERROR AL SOLICITAR LA FACTURA</strong>  
					</div>
                   
				<?php } 
}

?>