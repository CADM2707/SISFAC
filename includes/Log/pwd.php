<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();      
$format="d/m/Y";
$formatTIme="H:i:s";
$html="";
session_start();

//$usr=$_REQUEST['usrcompstat']? $_REQUEST['usrcompstat'] : NULL ;
$pwd=$_REQUEST['Pwd1']? $_REQUEST['Pwd1']:"" ;
$id_usr=isset($_SESSION['USUARIO'])?$_SESSION['USUARIO']:"";

$searchlog="update USUARIOS_LOG set contrasena='$pwd' where id_usuarios=$id_usr";

if ((sqlsrv_query($conn,$searchlog)) and $id_usr!="") {
    $html=1;    
}else{
    $html=0;
}
echo $html;

?>