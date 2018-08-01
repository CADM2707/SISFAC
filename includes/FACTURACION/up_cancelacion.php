<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();


 @$a=$_REQUEST['a'];
 @$id=$_REQUEST['id'];
 

					

$sql_reporte ="update factura set CVE_SITUACION = 3 where AYO =$a and ID_RECIBO =$id";
$res_reporte = sqlsrv_query($conn,$sql_reporte);
							  

if($sql_reporte!=""){ ?><br>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>SE HA CANCELADO CORRECTAMENTE</strong>  
					</div>
				<?php }else{ ?><br>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>NO SE HA PODIDO CANCELAR</strong>  
					</div>
				<?php } 

?>