<?php

include_once '../../config.php';

  @$pago = $_REQUEST['pagos'];
  @$ayo_pago = $_REQUEST['ayo'];
  @$ayo_fac = $_REQUEST['ayo_fac'];
  @$id_factura = $_REQUEST['id_fac'];
  @$monto = $_REQUEST['monto'];
  @$reg = $_REQUEST['reg'];
 

echo $sql_reporte ="execute facturacion.dbo.SP_Aplica_Pago $pago, $ayo_pago, $id_factura, $ayo_fac, $monto";
$res_reporte = sqlsrv_query($conn,$sql_reporte);
							  

if($res_reporte != ""){ ?><br>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>SE HA APLICADO PAGO CORRECTAMENTE</strong>  
					</div>
                    
                    
				<?php }else{ ?><br>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>NO SE HA PODIDO PAGO</strong>  
					</div>
                    
				<?php } 

?>