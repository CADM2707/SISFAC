<?php

$mPAplicar = isset($_REQUEST['MPA'])? str_replace(',', '', $_REQUEST['MPA']):"";
$mAplicado = isset($_REQUEST['MA'])?  str_replace(',', '', $_REQUEST['MA'] ):"";
$monto =isset($_REQUEST['MONTO'])?  str_replace(',', '', $_REQUEST['MONTO'] ):"";
$mAsignado= isset($_REQUEST['MASIGNADO'])? str_replace(',', '', $_REQUEST['MASIGNADO']):"";     
$importe= isset($_REQUEST['IMPORTE'])? str_replace(',', '', $_REQUEST['IMPORTE']):"";
$pago= isset($_REQUEST['PAGO'])? str_replace(',', '', $_REQUEST['PAGO']):"";
$saldo= isset($_REQUEST['SALDO'])? str_replace(',', '', $_REQUEST['SALDO']):"";

if(($mPAplicar-$mAsignado)<=0){
    echo "2";
}
