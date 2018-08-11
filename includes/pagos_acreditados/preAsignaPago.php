<?php

$mPAplicar = isset($_REQUEST['MPA'])? str_replace(',', '', $_REQUEST['MPA']):"";
$mAplicado = isset($_REQUEST['MA'])?  str_replace(',', '', $_REQUEST['MA'] ):"";
$monto =isset($_REQUEST['MONTO'])?  str_replace(',', '', $_REQUEST['MONTO'] ):"";
$mAsignado= isset($_REQUEST['MASIGNADO'])? str_replace(',', '', $_REQUEST['MASIGNADO']):"";

if(($mAplicado+$monto)>$mAsignado){
    echo "2";
}
