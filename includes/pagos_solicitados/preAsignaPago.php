<?php

$respuesta = array();
//$totalAsignado = 0;
$montoAplicado=0.00;
$montoPorAplicar=0.00;
$montoPago = isset($_REQUEST['montoPago']) ? str_replace(',', '', floatval($_REQUEST['montoPago'])) : 0;
$numRows = isset($_REQUEST['totalRows']) ? $_REQUEST['totalRows'] : 0;

for ($i = 1; $i <= $numRows; $i++) {
   $montoAplicado+=isset($_REQUEST['F'.$i]) ? str_replace(',', '', floatval($_REQUEST['F'.$i])) : 0;    
}

$montoPorAplicar=$montoPago-$montoAplicado;

if($montoPorAplicar<0){
    $respuesta[0]=2;
    $montoPorAplicar;
}else{
    $respuesta[0]=1;
    $respuesta[1]=number_format($montoAplicado,2);
    $respuesta[2]= number_format($montoPorAplicar,2);    
}
echo json_encode($respuesta);

