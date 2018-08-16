<?php

include_once '../../config.php';

 @$a=$_REQUEST['a'];
 @$id=$_REQUEST['id'];
 @$observacion=$_REQUEST['observacion'];
 

$sql_reporte ="execute sp_Cancela_Factura $id, $a, $idOp, '$observacion'";
$res_reporte = sqlsrv_query($conn,$sql_reporte);
							  

if($sql_reporte!=""){ ?><br>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>SE HA CANCELADO CORRECTAMENTE</strong>  
					</div>
                    
                    <meta http-equiv="refresh" content="5">
				<?php }else{ ?><br>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>NO SE HA PODIDO CANCELAR</strong>  
					</div>
                    <meta http-equiv="refresh" content="5">
				<?php } 

?>