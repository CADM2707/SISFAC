<?php

include_once '../../conexiones/sqlsrv.php';
$conn = connection_object();
$html = "";
session_start();

$idOp = $_SESSION['ID_OPERADOR'];
$asunto = isset($_REQUEST['ASUNTO']) ? $_REQUEST['ASUNTO'] : "";
$contenido = isset($_REQUEST['CONTENIDO']) ? $_REQUEST['CONTENIDO'] : "";
$destinatario = isset($_REQUEST['DESTINATARIO']) ? $_REQUEST['DESTINATARIO'] : "";

if ($asunto != "" and $contenido != "" and $destinatario != "") {

    if ($_SESSION['CLIENTE'] == "SI") {
        $idOp = $_SESSION['NOMBRE'];
        $query = "sp_Buzon_guarda '$idOp','$asunto','$contenido'";
    } else {
        $queryOp = "select ID_OPERADOR,ID_PROGRAMA from BITACORA.DBO.Programa_Perfil where (ID_PROGRAMA=41 or ID_PROGRAMA=72 ) and ID_OPERADOR='$idOp'";
        $execue = sqlsrv_query($conn, $queryOp);
        if ($row = sqlsrv_fetch_array($execue)) {
            if ($row['ID_PROGRAMA'] == 41) {
                $idOp = "FACTURACION";
            } else if ($row['ID_PROGRAMA'] == 72) {
                $idOp = "COBRANZA";
            }

             $query = "sp_Buzon_guarda '$idOp','$asunto','$contenido'";
        }
    }

    $execute = sqlsrv_query($conn,$query);    
    $row = sqlsrv_fetch_array($execute);
    echo $id_registro=$row['ID_REGISTRO'];
    if ($id_registro != "") {

        $query = "";

        for ($i = 0; $i < count($destinatario); $i++) {
            echo $query = "insert into Buzon_Destinatario values ($id_registro,'" . $destinatario[$i] . "')";
            $insertDest = sqlsrv_query($conn, $query);
        }
    }
}

