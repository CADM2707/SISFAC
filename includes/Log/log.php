<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();      
$format="d/m/Y";
$formatTIme="H:i:s";
$html="";
session_start();

$usr=$_REQUEST['usrcompstat']? $_REQUEST['usrcompstat'] : NULL ;
$pwd=$_REQUEST['passwordcompstat']? $_REQUEST['passwordcompstat']:NULL ;

 $searchlog="select  Acceso,id_usuarios from USUARIOS_LOG where id_usuarios=$usr and contrasena='$pwd' ";
$execue=sqlsrv_query($conn,$searchlog);

$row=sqlsrv_fetch_array($execue);
if ($row['Acceso']>0) {
    $html=1;
    $_SESSION['USUARIO']=$row['id_usuarios'];
    $_SESSION['perfil']=$row['Acceso'];
}else{
    $html=0;
}
echo $html;

?>