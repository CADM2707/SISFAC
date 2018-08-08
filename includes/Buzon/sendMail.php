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
        $queryOp = "declare @max as int
            select @max=isnull(MAX(id_registro)+1,1) from BUZON
            insert into BUZON
                    (ID_REGISTRO,REMITENTE,ASUNTO,CVE_ESTADO,SINTESIS)
            values
                    (@max,'$idOp','$asunto',1,'$contenido')
                    select @max
            ";
    } else {
        $queryOp = "select ID_OPERADOR,ID_PROGRAMA from BITACORA.DBO.Programa_Perfil where (ID_PROGRAMA=41 or ID_PROGRAMA=72 ) and ID_OPERADOR='$idOp'";
        $execue = sqlsrv_query($conn, $queryOp);
        if ($row = sqlsrv_fetch_array($execue)) {
            if ($row['ID_PROGRAMA'] == 41) {
                $idOp = "FACTURACION";
            } else if ($row['ID_PROGRAMA'] == 72) {
                $idOp = "COBRANZA";
            }

            $query = "declare @max as int
            select @max=isnull(MAX(id_registro)+1,1) from BUZON
            insert into BUZON
                    (ID_REGISTRO,REMITENTE,ASUNTO,CVE_ESTADO,SINTESIS)
            values
                    (@max,'$idOp','$asunto',1,'$contenido')
                    select @max as ID_REGISTRO
            ";
        }
    }
    
    $execute = sqlsrv_query($conn, $query);
    echo $query;
    $row = sqlsrv_fetch_array($execute);
    echo $row['ID_REGISTRO'];
    if ( $id_registro = $row['ID_REGISTRO'] !="" ) {
       
        $query = "";        

        for ($i = 0; $i <= count($destinatario); $i++) {
            $query = "insert into Buzon_Destinatario values ($id_registro,'" . $destinatario[$i] . "')";            
            echo $insertDest =sqlsrv_query($conn,$query);
        }               
    }
}

