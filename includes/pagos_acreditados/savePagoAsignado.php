<?php

include '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();
$format = "Y-m-d";
$numRows = 0;
$idPagoAsig = 0;
$html=2;

isset($_REQUEST['totalRows']) ? $numRows = $_REQUEST['totalRows'] : $numRows = 0;
isset($_REQUEST['idPagoAsigna']) ? $idPagoAsig = $_REQUEST['idPagoAsigna'] : $idPagoAsig = "";
isset($_REQUEST['idAyoAsigna']) ? $idayoAsig = $_REQUEST['idAyoAsigna'] : $idayoAsig = "";

isset($_REQUEST['idUsuario']) ? $id_usuario = $_REQUEST['idUsuario'] : $id_usuario = "";
isset($_REQUEST['idFechaPago']) ? $fecha_pago = $_REQUEST['idFechaPago'] : $fecha_pago = "";
isset($_REQUEST['montoAsigna']) ? $monto_asignado = $_REQUEST['montoAsigna'] : $monto_asignado = 0;
isset($_REQUEST['montoAplicado']) ? $monto_aplicado = $_REQUEST['montoAplicado'] : $monto_aplicado = 0;
isset($_REQUEST['montoPorAplicar']) ? $monto_por_Aplicar = $_REQUEST['montoPorAplicar'] : $monto_por_Aplicar = 0;
isset($_REQUEST['Ref']) ? $referencia_pago = $_REQUEST['Ref'] : $referencia_pago = "";
isset($_REQUEST['noCuenta']) ? $no_cuenta = $_REQUEST['noCuenta'] : $no_cuenta = "";


$ayo=substr($fecha_pago, 6);
$mes=substr($fecha_pago, 0,2);
$dia=substr($fecha_pago, 3,-5);
$fecha=date($dia."-".$mes."-".$ayo);
$id_registro="";

if($id_usuario!="" and $monto_asignado !="" and $fecha_pago !="" and $referencia_pago !="" and $no_cuenta!=""){
    $queryIdentifica = "SP_Cliente_Pago '$id_usuario',$monto_asignado, '$fecha','$referencia_pago',$no_cuenta ";
            if ($exec = sqlsrv_query($conn, $queryIdentifica)) {
                $row= sqlsrv_fetch_array($exec);
               $id_registro=$row[0];
            }
            $html=3;
}

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