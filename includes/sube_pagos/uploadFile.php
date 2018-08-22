<?php

include '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();

$id_usuario = $_SESSION['NOMBRE'];
$monto = $_REQUEST['monto_pago'];
$banco_pago = $_REQUEST['noCuenta'];
$referencia = $_REQUEST['referencia_pago'];
$fecha_pago = $_REQUEST['fecha_pago'];
$row="";
$respuesta=array();

$query = "Sp_Alta_Pago_Solicitud '$id_usuario','$fecha_pago',$monto,'$referencia',$banco_pago";

$execue = sqlsrv_query($conn, $query);
$row = sqlsrv_fetch_array($execue);

if ($row[0]!="") {
    $id = $row[0];

    $nombre_temporal = $_FILES['baucher']['tmp_name'];
    $nombre = $_FILES['baucher']['name'];
    $destination = "comprobante_pago/";
    $ext = pathinfo($nombre, PATHINFO_EXTENSION);
    
    if ($ext == 'pdf') {
        $destination .= $id.".pdf";
        if (move_uploaded_file($nombre_temporal, $destination)) {
          $respuesta[0]= 1;
          $respuesta[1]= $id;
          
        } else {
          $respuesta[0]=3;
          $respuesta[1]=0;
        }
    } else {
      $respuesta[0]=2;
      $respuesta[1]=0;
    }
}


echo json_encode($respuesta);
?>