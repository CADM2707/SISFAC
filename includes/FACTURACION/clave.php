<?php

include_once '../../config.php';

  @$usur=$_REQUEST['usur'];
 

$sql_reporte ="execute sp_alta_cliente '$usur'";
$res_reporte = sqlsrv_query($conn,$sql_reporte);
$row_reporte = sqlsrv_fetch_array($res_reporte);

							  

if($sql_reporte!=""){ ?><br>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>SE HA CREADO CORRECTAMENTE TU CUENTA DE ACCESO</strong>  
					</div>
                    
                    
				<?php }else{ ?><br>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>NO SE HA PODIDO CREAR TU CUENTA DE ACCESO</strong>  
					</div>
                    
				<?php } 

?>