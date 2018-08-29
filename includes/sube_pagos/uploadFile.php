<?php

include '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();

$format = "d-m-Y";
$id_usuario = $_SESSION['NOMBRE'];
$monto = $_REQUEST['monto_pago'];
$banco_pago = $_REQUEST['noCuenta'];
$referencia = $_REQUEST['referencia_pago'];
//$fecha_pago = date($format,strtotime($_REQUEST['fecha_pago']));
$fecha_pago = $_REQUEST['fecha_pago'];
$hora = $_REQUEST['hora_pago'];

//$hora = "00:00";
$row="";
$respuesta=array();

echo $query = "SP_Cliente_Pago '$id_usuario',$monto,'$fecha_pago','$hora','$referencia',$banco_pago";

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


