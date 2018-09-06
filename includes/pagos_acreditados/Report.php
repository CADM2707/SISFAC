<?php

include '../../conexiones/sqlsrv.php';

session_start();
$format = "d/m/Y";
$numRows = 0;
$idPagoAsig = 0;
$html="";

isset($_REQUEST['totalRows']) ? $numRows = $_REQUEST['totalRows'] : $numRows = 0;
isset($_REQUEST['idPagoAsigna']) ? $idPagoAsig = $_REQUEST['idPagoAsigna'] : $idPagoAsig = "";
isset($_REQUEST['idAyoAsigna']) ? $idayoAsig = $_REQUEST['idAyoAsigna'] : $idayoAsig = "";
// isset($_REQUEST['montoAsigna'])?$_REQUEST['']:0; 
if ($numRows > 0) {

    $cont = 1;
    $cont2=1;
    $html.="<table class='table table-bordered table-hover table-responsive table-striped'>
                            <thead>     
                                <th>#</th>
                                <th>AÑO</th>
                                <th>ID FACTURA</th>                                                                                           
                                <th>IMPORTE PAGO</th>                                
                                <th>PAGO</th>                                
                                <th>SALDO</th>                                
                                <th>ASIGNADO</th>                                
                            </thead>
                            <tbody>";
    while ($cont <= $numRows) {
        $id_factura = "ID_FACTURA" . $cont;
        $ayo_factura = "AYO" . $cont;
        $monto_Aplicado = "F" . $cont;                
        $id_factura = isset($_REQUEST[$id_factura])?$_REQUEST[$id_factura]:"";
        $ayo_factura = isset($_REQUEST[$ayo_factura])? $_REQUEST[$ayo_factura] : "";
        $monto_Aplicado = isset($_REQUEST[$monto_Aplicado])? floatval($_REQUEST[$monto_Aplicado]) :0;        

        if ($monto_Aplicado > 0 and $id_factura!="" and $ayo_factura!="") {
            
            $importe = "importeVal" . $cont;
            $pago = "pagoVal" . $cont;
            $saldo = "saldoVal" . $cont;
            
            $importe= isset($_REQUEST[$importe])? str_replace(',', '', $_REQUEST[$importe]):"";
            $pago= isset($_REQUEST[$pago])? str_replace(',', '', $_REQUEST[$pago]):"";
            $saldo= isset($_REQUEST[$saldo])? str_replace(',', '', $_REQUEST[$saldo]):"";
            
            $importe= number_format($importe,2);
            $pago= number_format($pago,2);
            $saldo= number_format($saldo,2);
            
            $html.=" <tr>
                        <td>$cont2</td>
                        <td>$ayo_factura</td>
                        <td>$id_factura</td>
                        <td>$ $importe</td>
                        <td>$ $pago</td>
                        <td>$ $saldo</td>                        
                        <td>$monto_Aplicado</td>                        
                    </tr>";
           $cont2++; 
        }
        $cont++;
    }
    $html.="</tbody>
                        </table>";
}

echo $html;

