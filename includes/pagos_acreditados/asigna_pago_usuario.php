<?php

include '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();
$format = "Y-m-d";
$respuesta[0] = 2;
$id_registro = "";
$id_Ope=$_SESSION['ID_OPERADOR'];
isset($_REQUEST['idUsuario']) ? $id_usuario = $_REQUEST['idUsuario'] : $id_usuario = "";
isset($_REQUEST['idFechaPago']) ? $fecha_pago = $_REQUEST['idFechaPago'] : $fecha_pago = "";
isset($_REQUEST['montoAsigna']) ? $monto_asignado = $_REQUEST['montoAsigna'] : $monto_asignado = 0;
//isset($_REQUEST['montoAplicado']) ? $monto_aplicado = $_REQUEST['montoAplicado'] : $monto_aplicado = 0;
//isset($_REQUEST['montoPorAplicar']) ? $monto_por_Aplicar = $_REQUEST['montoPorAplicar'] : $monto_por_Aplicar = 0;
isset($_REQUEST['Ref']) ? $referencia_pago = $_REQUEST['Ref'] : $referencia_pago = "";
//isset($_REQUEST['noCuenta']) ? $no_cuenta = $_REQUEST['noCuenta'] : $no_cuenta = "";

isset($_REQUEST['idPagoAsigna']) ? $idPagoAsig = $_REQUEST['idPagoAsigna'] : $idPagoAsig = "";
isset($_REQUEST['idAyoAsigna']) ? $idayoAsig = $_REQUEST['idAyoAsigna'] : $idayoAsig = "";
isset($_REQUEST['tipoREP2']) ? $tipoREP = $_REQUEST['tipoREP2'] : $tipoREP = 1;

$ayo = substr($fecha_pago, 6);
$mes = substr($fecha_pago, 0, 2);
$dia = substr($fecha_pago, 3, -5);
$fecha = date($dia . "-" . $mes . "-" . $ayo);

$QuerDatosBancarios = "select * from Metodo_Pago T1 
            inner join [dbo].[C_Banco] T2 on T1.ID_BANCO=T2.ID_BANCO
            where ID_USUARIO='$id_usuario' and CVE_SITUACION=1";

$exec = sqlsrv_query($conn, $QuerDatosBancarios);
$row = sqlsrv_fetch_array($exec);
$id_cuenta = $row['ID_REGISTRO'];

if ($id_cuenta == "") {
    $respuesta[0] = 4;
} else if ($id_usuario != "" and $monto_asignado != "" and $fecha_pago != "" and $referencia_pago != "" and $id_cuenta != "") {
    $respuesta[0] = 3;
    $queryIdentifica = "[dbo].[sp_Cliente_Pago_Manual] $idPagoAsig,$idayoAsig,'$id_usuario',$id_cuenta,$id_Ope,$tipoREP";
    if ($exec = sqlsrv_query($conn, $queryIdentifica)) {
        $row = sqlsrv_fetch_array($exec);
        $respuesta[1] = $row[0];
        $respuesta[0] = 1;
    }    
}

echo json_encode($respuesta);
