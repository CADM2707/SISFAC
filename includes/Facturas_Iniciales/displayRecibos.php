<?php
include_once '../../conexiones/sqlsrv.php';
$conn = connection_object();

$ID_FACTURA =$_REQUEST['ID_RECIBO'];
$ayo =$_REQUEST['AYO_RECIBO'];
$html="";
$format="Y/m/d";

$query="select AYO_PAGO,ID_PAGO,MONTO_APLICADO,FECHA_APLICADO,FOLIO_REP
        from facturacion.dbo.Pago_Factura where CVE_PAGO_SIT IN (3,5) AND ayo=$ayo and  ID_FACTURA=$ID_FACTURA";
$execute=sqlsrv_query($conn,$query);

$html.="<table class='table table-bordered table-hover table-responsive table-striped text-center' id='tablePagos'>
                            <thead>
                                <th>#</th>
                                <th>AÑO PAGO</th>
                                <th>ID PAGO</th>
                                <th>MONTO_APLICADO</th>                                
                                <th>FECHA_APLICADO</th>                                
                                <th>FOLIO_REP</th>                                
                            </thead>
                            <tbody>";
  $counter=0;
while($row=sqlsrv_fetch_array($execute)){
    $counter++;
    $ayo_pago=$row['AYO_PAGO'];
    $id_pago=$row['ID_PAGO'];
    $monto_aplicado=number_format($row['MONTO_APLICADO']);
    $fecha_aplicado=date_format($row['FECHA_APLICADO'], $format);
    $folio_rep=$row['FOLIO_REP'];
        
    $html.="
                                <tr>
                                    <td>$counter</td>
                                    <td>$ayo_pago</td>
                                    <td>$id_pago</td>
                                    <td>$$monto_aplicado</td>
                                    <td>$fecha_aplicado</td>
                                    <td>$folio_rep</td>                                      
                                </tr>                                                               
                           ";
}
echo $html .= " </tbody>
                        </table>";
