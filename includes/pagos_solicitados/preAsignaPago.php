<?php

$respuesta = array();
//$totalAsignado = 0;
$montoAplicado=0;
$montoPago = isset($_REQUEST['montoPago']) ? str_replace(',', '', $_REQUEST['montoPago']) : 0;
$montoPorAplicar = isset($_REQUEST['montoPorAplicar']) ? str_replace(',', '', $_REQUEST['montoPorAplicar']) : 0;
//$montoAplicado = isset($_REQUEST['montoAplicado']) ? str_replace(',', '', $_REQUEST['montoAplicado']) : 0;
$numRows = isset($_REQUEST['totalRows']) ? $_REQUEST['totalRows'] : 0;



for ($i = 1; $i <= $numRows; $i++) {
    $montoAplicado+=isset($_REQUEST['F'.$i]) ? str_replace(',', '', floatval($_REQUEST['F'.$i])) : 0;    
}
//echo $montoAplicado;

$montoPorAplicar=$montoPago-$montoAplicado;

//$mPAplicar = isset($_REQUEST['MPA'])? str_replace(',', '', $_REQUEST['MPA']):0;
//$mAplicado = isset($_REQUEST['MA'])?  str_replace(',', '', $_REQUEST['MA'] ):0;
//$monto =isset($_REQUEST['MONTO'])?  str_replace(',', '', $_REQUEST['MONTO'] ):0;
//$mAsignado= isset($_REQUEST['MASIGNADO'])?  str_replace(',', '', $_REQUEST['MASIGNADO']):0;     
//$importe= isset($_REQUEST['IMPORTE'])? str_replace(',', '', $_REQUEST['IMPORTE']):0;
//$pago= isset($_REQUEST['PAGO'])? str_replace(',', '', $_REQUEST['PAGO']):0;
//$saldo= isset($_REQUEST['SALDO'])? str_replace(',', '', $_REQUEST['SALDO']):0;
//if(($mPAplicar-($mAsignado+$totalAsignado))<0){
//    $respuesta[0]=2;
//    $totalAsignado +=$mAsignado;
//    $resp2=$mPAplicar-$totalAsignado;
//    $respuesta[1]=number_format($totalAsignado,2);
//    $respuesta[2]= number_format($resp2,2);
////    $myObj->name
//}else{
//    $totalAsignado +=$mAsignado;
//    $r1=$mAplicado+$totalAsignado;
//    $r2=$mPAplicar-$totalAsignado;
//    $respuesta[0]=1;
//    $respuesta[1]=number_format($r1,2);
//    $respuesta[2]= number_format($r2,2);    
//}
echo json_encode($respuesta);

