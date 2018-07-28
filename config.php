<?php
session_start();

if (isset($_SESSION['PLACA'])) {    
    $nombre=$_SESSION['NOMBRE'];
    $sec=$_SESSION['SECTOR'];
    $dest=$_SESSION['DEST'];
    $idOp=$_SESSION['ID_OPERADOR'];
    include('conexiones/sqlsrv.php');
    $conn = connection_object();
} else {
//    echo("<script>window.location.replace(".BASE_URL."'Login.php');</script>");

define('BASE_URL2', 'http://' . $_SERVER['SERVER_NAME'] . ':8080/SISFAC/');

    header('Location:'.BASE_URL2.'Login.php');
}
    	    
	
  	