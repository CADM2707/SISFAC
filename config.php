<?php
session_start();

if (isset($_SESSION['CVE_PERFIL'])) {
    $perfil=$_SESSION['CVE_PERFIL'];
    $nombre=$_SESSION['NOMBRE'];
    $Apep=$_SESSION['APELLIDOP'];
    $ApeM=$_SESSION['APELLIDOM'];
} else {
//    echo("<script>window.location.replace(".BASE_URL."'Login.php');</script>");
define('BASE_URL2', 'http://' . $_SERVER['SERVER_NAME'] . ':8080/SISFAC/');     
    header('Location:'.BASE_URL2.'Login.php');
}
    	    
	include('conexiones/sqlsrv.php');
	$conn = connection_object();
        
 
