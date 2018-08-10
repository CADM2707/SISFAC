<?php

include '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();
$format="d/m/Y";

$html = "";
$ayo = "";
$pagos = "";
$tipoPago = "";


isset($_REQUEST['PAGOS']) ? $pagos = $_REQUEST['PAGOS'] : NULL;
isset($_REQUEST['AYO']) ? $ayo = $_REQUEST['AYO'] : NULL;
isset($_REQUEST['TIPO_PAGO']) ? $tipoPago = $_REQUEST['TIPO_PAGO'] : NULL;

//if($tipoPago==1){
//    $tipoPago="CVE_PAGO_SIT in (3,4)";
//}e
switch ($tipoPago) {
    case 1:
    $tipoPago="CVE_PAGO_SIT in (3,4) and";
        break;
    case 2:
        $tipoPago="CVE_PAGO_SIT = 4 and";
        break;
    case 3:
        $tipoPago="CVE_PAGO_SIT = 3 and";
        break;
    default:
        $tipo_pago="";
        break;
}

if($ayo!="" and $pagos != "" and $tipoPago != ""){
     $queryPagos="select AYO_PAGO,ID_PAGO,T2.DESCRIPCION TIPO_PAGO,MONTO,FECHA_PAGO,REFERENCIA,OBSERVACION From pago T1
                 INNER JOIN C_Pago_Tipo T2 ON T1.CVE_PAGO_TIPO=T2.CVE_PAGO_TIPO
                 where $tipoPago  AYO_PAGO=2018 and ID_USUARIO='31377'";
     
     $executeQuery = sqlsrv_query($conn,$queryPagos);
     
      $html.="<table class='table table-bordered table-hover table-responsive table-striped' id='tableRes'>
                            <thead>
                                <th>#</th>
                                <th>AÑO</th>
                                <th>ID PAGO</th>
                                <th>TIPO PAGO</th>                                
                                <th>MONTO</th>                                
                                <th>FECHA PAGO</th>                                
                                <th>REFERENCIA</th>
                                <th>OBSERVACIONES</th>                                
                            </thead>
                            <tbody>";
      
      $cont=1;
     while ($row = sqlsrv_fetch_array($executeQuery)) {
         
        $ayo_pago = $row = ['AYO_PAGO'];
        $id_pago = $row = ['ID_PAGO'];
        $tipo_pago = $row = ['TIPO_PAGO'];
        $monto = number_format($row = ['MONTO']);
        $fecha_pago = date_format($row = ['FECHA_PAGO'],$format);
        $referencia = $row = ['REFERENCIA'];
        $observacion = $row = ['OBSERVACION'];
        
        						
         $html.="
                                <tr>
                                    <td>$cont</td>
                                    <td>$ayo_pago</td>
                                    <td>$id_pago</td>
                                    <td>$tipo_pago</td>
                                    <td>$$monto</td>
                                    <td>$fecha_pago</td>
                                    <td>$referencia</td>
                                    <td>$observacion</td>
                                    <td>
                                        <button onclick='verPago ()' type='button' class='btn btn-warning' >
                                            <i class='fa  fa-file-pdf-o'></i> VER
                                        </button>
                                    </td>
                                </tr>                                                               
                           ";
         
        $cont++;
    }if( $cont>0){ 
   $html .= " </tbody>
                        </table>";
}else{
    $html=1;
}


echo $html;
}