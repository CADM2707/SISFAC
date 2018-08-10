<?php

include '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();
$html = "";
$ayo = "";
$pagos = "";
$tipoPago = "";

isset($_REQUEST['PAGOS']) ? $pagos = $_REQUEST['PAGOS'] : NULL;
isset($_REQUEST['AYO']) ? $ayo = $_REQUEST['AYO'] : NULL;
isset($_REQUEST['TIPO_PAGO']) ? $tipoPago = $_REQUEST['TIPO_PAGO'] : NULL;

//if($tipoPago==1){
//    $tipoPago="CVE_PAGO_SIT in (3,4)";
//}e
switch ($tipoPago) {
    case 1:
    $tipoPago="CVE_PAGO_SIT in (3,4) and";
        break;
    case 2:
        $tipoPago="CVE_PAGO_SIT = 4 and";
        break;
    case 3:
        $tipoPago="CVE_PAGO_SIT = 3 and";
        break;
    default:
        $tipo_pago="";
        break;
}

if($ayo!="" and $pagos != "" and $tipoPago != ""){
    $queryPagos="select AYO_PAGO,ID_PAGO,T2.DESCRIPCION TIPO_PAGO,MONTO,FECHA_PAGO,REFERENCIA,OBSERVACION From pago T1
                 INNER JOIN C_Pago_Tipo T2 ON T1.CVE_PAGO_TIPO=T2.CVE_PAGO_TIPO
                 where $tipoPago  AYO_PAGO=2018 and ID_USUARIO='31377'";
}