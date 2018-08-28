<?php

include '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();
$format = "d/m/Y";
$numRows=0;
$idPagoAsig=0;

 isset($_REQUEST['totalRows'])? $numRows = $_REQUEST['totalRows']: $numRows = 0;
 isset($_REQUEST['idPagoAsigna'])?$idPagoAsig = $_REQUEST['idPagoAsigna']:$idPagoAsig = "";
 isset($_REQUEST['idAyoAsigna'])?$idayoAsig = $_REQUEST['idAyoAsigna']:$idayoAsig = "";
// isset($_REQUEST['montoAsigna'])?$_REQUEST['']:0; 

if($numRows>0){
    
    $cont=1;
while($cont<=$numRows){
   $id_factura="ID_FACTURA".$cont;   
   $ayo_factura="AYO".$cont;   
   $monto_Aplicado="F".$cont;   
   
   $id_factura = $_REQUEST[$id_factura];
   $ayo_factura = $_REQUEST[$ayo_factura];
   $monto_Aplicado = floatval($_REQUEST[$monto_Aplicado]?$_REQUEST[$monto_Aplicado]:0);
   
   if($monto_Aplicado>0){
      echo  $query="SP_Aplica_Pago $idPagoAsig,$idayoAsig,$id_factura,$ayo_factura,$monto_Aplicado";   
//        if($exec=sqlsrv_query($conn,$query)){
//            echo 1;
//        } else {
//            echo 2;
//        }
   }
      
    $cont++;
}    
    
}