<?php

include_once '../../config.php';

  @$reg = $_REQUEST['reg'];
  @$obs_c = strtoupper($_REQUEST['obs_c']);
  $html="";
 
  $sqlselect_fac = "update Pago_Solicitud set CVE_SITUACION=4, OBSERVACIONES ='$obs_c' where ID_REGISTRO=$reg";
  $ressqlselect_fac = sqlsrv_query($conn,$sqlselect_fac);
					  

if($ressqlselect_fac != ""){ 

$html.="<br>
					<div class='alert alert-success alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<strong>SE HA CANCELADO PAGO CORRECTAMENTE</strong>  
					</div>
          ";          
                    
				 }else{ $html.= "
				 <br>
					<div class='alert alert-danger alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<strong>NO SE CANCELADO PODIDO PAGO</strong>  
					</div>
                    
		"; } 
echo $html;
?>