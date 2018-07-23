<?php
session_start();

if (isset($_SESSION['CVE_PERFIL'])) {
    $perfil=$_SESSION['CVE_PERFIL'];
    $nombre=$_SESSION['NOMBRE'];
    $Apep=$_SESSION['APELLIDOP'];
    $ApeM=$_SESSION['APELLIDOM'];
} else {
//    echo("<script>window.location.replace(".BASE_URL."'Login.php');</script>");
    header('Location:'.BASE_URL.'Login.php');
}
    
	$nombre="Carlos Diaz";
    define('BASE_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/SISFAC/');
	include('conexiones/sqlsrv.php');
	$conn = connection_object();
        
 
