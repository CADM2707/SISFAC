<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();      
session_start();

$id_usuario = $_SESSION['NOMBRE'];
$monto = $_REQUEST['monto_pago'];
$banco_pago = $_REQUEST['banco_pago'];
$referencia = $_REQUEST['referencia_pago'];
$fecha_pago = $_REQUEST['fecha_pago'];

$query="Sp_Alta_Pago_Solicitud '$id_usuario','$fecha_pago',$monto,'$referencia',$banco_pago";

  $nombre_temporal=$_FILES['baucher']['tmp_name'];
  $nombre=$_FILES['baucher']['name'];
  $destination="comprobante_pago/";
  $ext = pathinfo($nombre, PATHINFO_EXTENSION);
  if($ext=='pdf'){
      $destination.="1.pdf";
      if(!move_uploaded_file($nombre_temporal, $destination)){
//          echo 1;
      } else {
//          echo 3;
      }
  }else{
//      echo 2;
  }
  
  
//echo "hola";
?>