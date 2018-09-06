<?php

include '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();
$format = "Y-m-d";
$numRows = 0;
$idPagoAsig = 0;
$html=2;
$id_registro="";

isset($_REQUEST['totalRows']) ? $numRows = $_REQUEST['totalRows'] : $numRows = 0;
isset($_REQUEST['idPagoAsigna']) ? $idPagoAsig = $_REQUEST['idPagoAsigna'] : $idPagoAsig = "";
isset($_REQUEST['idAyoAsigna']) ? $idayoAsig = $_REQUEST['idAyoAsigna'] : $idayoAsig = "";
isset($_REQUEST['idregistro']) ? $id_registro = $_REQUEST['idregistro'] : $id_registro = "";

//**********************          Falta       ****************

if ($numRows > 0 and $id_registro!="") {

    $cont = 1;
    while ($cont <= $numRows) {
        $id_factura = "ID_FACTURA" . $cont;
        $ayo_factura = "AYO" . $cont;
        $monto_Aplicado = "F" . $cont;

        $id_factura = isset($_REQUEST[$id_factura])?$_REQUEST[$id_factura]:0;
        $ayo_factura = isset($_REQUEST[$ayo_factura])?$_REQUEST[$ayo_factura]:0;
        $monto_Aplicado = isset($_REQUEST[$monto_Aplicado])? floatval($_REQUEST[$monto_Aplicado]) :0;

        if ($monto_Aplicado > 0 and $id_factura!="" and $ayo_factura!="") {
          $query = "[dbo].[SP_ClientePago_Detalle] $id_registro,$id_factura,$ayo_factura,$monto_Aplicado";
            if ($exec = sqlsrv_query($conn, $query)) {
                $html = 1;
            }
        }
        $cont++;
    }
}

echo $html;