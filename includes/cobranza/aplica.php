<?php

include_once '../../config.php';

  @$pago = $_REQUEST['pagos'];
  @$ayo_pago = $_REQUEST['ayo'];
  @$reg = $_REQUEST['reg'];
  @$usu = $_REQUEST['usu'];
 
 $html = "";
 
 $sqlselect_fac = "
SELECT psd.ID_REGISTRO,	psd.AYO,psd.ID_FACTURA,	psd.MONTO FROM [Facturacion].[dbo].[Pago] PG
left outer join [Facturacion].[dbo].[Pago_Solicitud] PS on PS.MONTO = PG.MONTO AND PS.REFERENCIA = PG.REFERENCIA AND Cast(PS.FECHA_PAGO As Date) = Cast(PG.FECHA_PAGO As Date)
inner join facturacion.dbo.Pago_Solicitud_Detalle psd on ps.ID_REGISTRO=psd.ID_REGISTRO
where psd.ID_REGISTRO=$reg";
$ressqlselect_fac = sqlsrv_query($conn,$sqlselect_fac);

while($row_lista = sqlsrv_fetch_array($ressqlselect_fac)){
	$id_factura = $row_lista['ID_FACTURA'];
	$ayo_fac = $row_lista['AYO'];
	$monto = $row_lista['MONTO'];
	
$sql_reporte ="execute facturacion.dbo.SP_Aplica_Pago $pago, $ayo_pago, $id_factura, $ayo_fac, $monto,'$usu'";
@$res_reporte = sqlsrv_query($conn,$sql_reporte);
}
							  

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