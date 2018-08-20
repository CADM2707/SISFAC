<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();


 @$qnas=$_REQUEST['Qnas'];
 @$anio=$_REQUEST['Anio'];
 @$soli=$_REQUEST['Soli'];
 

					

 $sql_reporte ="update Turnos_Facturacion set CVE_SITUACION=2 where AYO=$anio and QNA=$qnas and ID_SOLICITUD=$soli";
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
  
?>