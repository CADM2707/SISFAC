<?php

include_once '../../config.php';

  @$pago = $_REQUEST['pagos'];
  @$ayo_pago = $_REQUEST['ayo'];
  @$reg = $_REQUEST['reg'];
  @$usu = $_REQUEST['usu'];
 
 $html = "";

	
$sql_reporte ="update Pago_Solicitud set CVE_SITUACION=2 where ID_REGISTRO=$reg ";
@$res_reporte = sqlsrv_query($conn,$sql_reporte);

$sql_reporte1 ="update Pago set ID_USUARIO='$usu' where ID_PAGO=$pago and AYO_PAGO=$ayo_pago and ID_USUARIO is null";
@$res_reporte2 = sqlsrv_query($conn,$sql_reporte1);
							  

if(@$res_reporte != ""){ 
$html .= "
<br>
					<div class='alert alert-success alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<strong>SE HA APLICADO PAGO CORRECTAMENTE</strong>  
					</div>
 ";                   
                    
				 }else{ 
$html .= "				<br>
					<div class='alert alert-danger alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<strong>NO SE HA PODIDO PAGO</strong>  
					</div>
                    
				";
				} 

echo $html;