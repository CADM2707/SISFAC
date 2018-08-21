<?php
session_start();

if (isset($_SESSION['PLACA'])) {    
    $nombre=$_SESSION['NOMBRE'];
    $sec=$_SESSION['SECTOR'];
    $dest=$_SESSION['DEST'];
    $idOp=$_SESSION['ID_OPERADOR'];
    $query=$_SESSION['MENU'];
    include('conexiones/sqlsrv.php');
    $conn = connection_object();
    date_default_timezone_set('America/Mexico_City');
} else {
//    echo("<script>window.location.replace(".BASE_URL."'Login.php');</script>");

define('BASE_URL2', 'http://' . $_SERVER['SERVER_NAME'] . '/SISFAC/');

    header('Location:'.BASE_URL2.'Login.php');
}

	
  	