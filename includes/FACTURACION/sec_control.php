<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();


 @$id=$_REQUEST['usuario'];
 @$usu=$_REQUEST['usu'];
 @$fac=$_REQUEST['fac'];
 @$format=$_REQUEST['format'];
 @$per=$_REQUEST['per'];
 @$tur=$_REQUEST['tur'];
 @$jerar=$_REQUEST['jerar'];
 @$adi=$_REQUEST['adi'];
 @$correo=$_REQUEST['correo'];
 @$cuenta=$_REQUEST['cuenta'];
 @$banco=$_REQUEST['banco'];

if($usu !=""){$u_usu = " ID_USUARIO_FACTURA =$usu, ";} else {$u_usu="";}
	
if($fac !=""){$u_fac = " CVE_TIPO_FACTURA =$fac, ";} else {$u_fac="";}
	
if($per !=""){$u_per = " PERIODO_FACTURACION ='$per', ";} else {$u_per="";}

if($jerar !=""){$u_jerar = " JERARQUIA ='$jerar', ";} else {$u_jerar="";}
	
if($adi !=""){$u_adi = " ADICIONALES ='$adi', ";} else {$u_adi="";}
	
if($correo !=""){$u_correo = " CORREO ='$correo', ";} else {$u_correo="";}
	
if($cuenta !=""){$u_cuenta = " CUENTA =$cuenta, ";} else {$u_cuenta="";}
	
if($banco !=""){$u_banco = " BANCO ='$banco', ";} else {$u_banco="";}
	
if($format !=""){$u_format = " CVE_FORMATO = $format, ";} else {$u_format="";}		

 $var= $u_usu.$u_fac.$u_per.$u_jerar.$u_adi.$u_correo.$u_cuenta.$u_banco.$u_format;
 $var2= substr ($var, 0, -2);				

 $sql_reporte ="update Parametros_Facturacion set $var2 WHERE ID_USUARIO = '$id'";
$res_reporte = sqlsrv_query($conn,$sql_reporte);

?>