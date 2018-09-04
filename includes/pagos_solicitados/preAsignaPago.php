<?php

 $totalAsignado=0;
$mPAplicar = isset($_REQUEST['MPA'])? str_replace(',', '', $_REQUEST['MPA']):0;
$mAplicado = isset($_REQUEST['MA'])?  str_replace(',', '', $_REQUEST['MA'] ):0;
$monto =isset($_REQUEST['MONTO'])?  str_replace(',', '', $_REQUEST['MONTO'] ):0;
$mAsignado= isset($_REQUEST['MASIGNADO'])?  str_replace(',', '', $_REQUEST['MASIGNADO']):0;     
$importe= isset($_REQUEST['IMPORTE'])? str_replace(',', '', $_REQUEST['IMPORTE']):0;
$pago= isset($_REQUEST['PAGO'])? str_replace(',', '', $_REQUEST['PAGO']):0;
$saldo= isset($_REQUEST['SALDO'])? str_replace(',', '', $_REQUEST['SALDO']):0;

$respuesta = array();

if(($mPAplicar-($mAsignado+$totalAsignado))<0){
    $respuesta[0]=2;
    $totalAsignado +=$mAsignado;
    $respuesta[1]=number_format($totalAsignado);
    $respuesta[2]= number_format($mPAplicar-$totalAsignado);
//    $myObj->name
}else{
    $totalAsignado +=$mAsignado;
    
    $respuesta[0]=1;
    $respuesta[1]=number_format($mAplicado+$totalAsignado);
    $respuesta[2]= number_format($mPAplicar-$totalAsignado);    
}
echo json_encode($respuesta);

