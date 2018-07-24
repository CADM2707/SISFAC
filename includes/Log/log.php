<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();      
$format="d/m/Y";
$formatTIme="H:i:s";
$html="";
session_start();

$usr=$_REQUEST['usrcompstat']? $_REQUEST['usrcompstat'] : NULL ;
$pwd=$_REQUEST['passwordcompstat']? $_REQUEST['passwordcompstat']:NULL ;

 $searchlog="EXECUTE BITACORA.DBO.SP_Acceso '$usr','$pwd'";
$execue=sqlsrv_query($conn,$searchlog);

$row=sqlsrv_fetch_array($execue);

if (isset($row['PLACA'])) {
    $html=1;
    $_SESSION['NOMBRE']=$row['NOMBRE'];
    $_SESSION['PLACA']=$row['PLACA'];
    $_SESSION['SECTOR']=$row['SECTOR'];
    $_SESSION['DEST']=$row['DEST'];
    $_SESSION['ID_OPERADOR']=$row['ID_OPERADOR'];
//    $_SESSION['APELLIDOM']=$row['APELLIDOM'];
//    $_SESSION['CVE_PERFIL']=$row['CVE_PERFIL'];
//    $_SESSION['perfil']=$row['Acceso'];
}else{
    $html=0;
}
echo $html;

?>