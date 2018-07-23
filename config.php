<?php

$nombre="Carlos Diaz";
    define('BASE_URL', 'http://' . $_SERVER['SERVER_NAME'] . ':8080/SISFAC/');
	include('conexiones/sqlsrv.php');
	$conn = connection_object();