<?php
$numRows = 0;
$idPagoAsig = 0;
$html=2;
$montoPorAplicar=0;
isset($_REQUEST['totalRows']) ? $numRows = $_REQUEST['totalRows'] : $numRows = 0;
isset($_REQUEST['idPagoAsigna']) ? $idPagoAsig = $_REQUEST['idPagoAsigna'] : $idPagoAsig = "";
isset($_REQUEST['idAyoAsigna']) ? $idayoAsig = $_REQUEST['idAyoAsigna'] : $idayoAsig = "";


if ($numRows > 0) {

    $cont = 1;
    while ($cont <= $numRows) {
        $id_factura = "ID_FACTURA" . $cont;
        $ayo_factura = "AYO" . $cont;
        $monto_Aplicado = "F" . $cont;

        $id_factura = isset($_REQUEST[$id_factura])?$_REQUEST[$id_factura]:"";
        $ayo_factura = isset($_REQUEST[$ayo_factura])?$_REQUEST[$ayo_factura]:"";
        $monto_Aplicado = isset($_REQUEST[$monto_Aplicado])? floatval($_REQUEST[$monto_Aplicado]) :0;

        if ($monto_Aplicado > 0 and $id_factura!="" and $ayo_factura!="") {
            
        }
        $cont++;
    }
}

echo $html;