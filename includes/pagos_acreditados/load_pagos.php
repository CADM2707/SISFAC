<?php

include '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();
$format = "d/m/Y";

$html = "";
$ayo = "";
$pagos = "";
$tipoPago = "";

$id_usuario = $_SESSION['NOMBRE'];

isset($_REQUEST['PAGOS']) ? $pagos = $_REQUEST['PAGOS'] : "";


if ($pagos != "") {

    isset($_REQUEST['AYO']) ? $ayo = $_REQUEST['AYO'] : "";
    isset($_REQUEST['TIPO_PAGO']) ? $tipoPago = $_REQUEST['TIPO_PAGO'] : "";

    switch ($tipoPago) {
        case 1:
            $tipoPago = "CVE_PAGO_SIT in (3,4)";
            break;
        case 2:
            $tipoPago = "CVE_PAGO_SIT = 4";
            break;
        case 3:
            $tipoPago = "CVE_PAGO_SIT = 3";
            break;
        default:
            $tipo_pago = "";
            break;
    }

    if ($ayo != "") {
        $ayo = "T1.AYO_PAGO=$ayo and";
    }
    if($ayo!="" and $tipoPago!=""){
        $and="and";
    }else{
        $and="";
    }
   $queryPagos = "select T1.AYO_PAGO,T1.ID_PAGO,T2.DESCRIPCION TIPO_PAGO,MONTO,ISNULL(APLICADO,0)APLICADO,MONTO-ISNULL(APLICADO,0) POR_APLICAR,FECHA_PAGO,REFERENCIA,OBSERVACION From pago T1
                    INNER JOIN C_Pago_Tipo T2 ON T1.CVE_PAGO_TIPO=T2.CVE_PAGO_TIPO
                    LEFT OUTER JOIN (SELECT AYO_PAGO,ID_PAGO, SUM(MONTO_APLICADO) APLICADO FROM PAGO_FACTURA GROUP BY AYO_PAGO,ID_PAGO ) T3 ON T1.AYO_PAGO=T3.AYO_PAGO AND T1.ID_PAGO=T3.ID_PAGO
                    where $tipoPago $and $ayo  ID_USUARIO='$id_usuario'";


    $executeQuery = sqlsrv_query($conn, $queryPagos);

    $html .= "<table class='table table-bordered table-hover table-responsive table-striped' id='tableRes'>
                            <thead>
                                <th>#</th>
                                <th>AÑO</th>
                                <th>ID PAGO</th>
                                <th>TIPO PAGO</th>                                
                                <th>MONTO</th>                                
                                <th>MONTO APLICADO</th>                                
                                <th>MONTO POR APLICAR</th>                                
                                <th>FECHA PAGO</th>                                
                                <th>REFERENCIA</th>
                                <th>OBSERVACIONES</th>                                
                                <th>DETALLES</th>                                
                            </thead>
                            <tbody>";

    $cont = 1;
    while ($row = sqlsrv_fetch_array($executeQuery)) {

        $ayo_pago = $row['AYO_PAGO'];
        $id_pago = $row['ID_PAGO'];
        $tipo_pago = $row['TIPO_PAGO'];
        $monto = number_format($row['MONTO']);        
        $monto2 = '"' . ($row['MONTO']) . '"';
        $fecha_pago = date_format($row['FECHA_PAGO'], $format);
        $referencia = utf8_encode($row['REFERENCIA']);
        $observacion = utf8_encode($row['OBSERVACION']);
        $montoA= number_format($row['APLICADO']);        
        $montoPA=number_format($row['POR_APLICAR']);
        $cont2 = '"' . $cont . '"';
        $disabled="";
        $bgColorM="";
        if($montoPA==0){
            $disabled="disabled='true'";
             $bgColorM="2";
        }else if($montoPA>0){
            $bgColorM="1";
        }else if($montoPA<0){
            $bgColorM="3";
        }
        $html .= "
                                <tr>
                                    <td>$cont</td>
                                    <td>$ayo_pago</td>
                                    <td>$id_pago</td>
                                    <td>$tipo_pago</td>
                                    <td><input type='text' id='$cont' disabled='true' value='$monto' class='form form-control text-center bg-color-Beige'></td>
                                    <td><input type='text' id='MA$cont' disabled='true' value='$montoA' class='form form-control text-center bg-color-Beige'></td>
                                    <td><input type='text' id='MPA$cont' disabled='true' value='$montoPA' class='form form-control text-center bg-color-Beige'></td>
                                    <td>$fecha_pago</td>
                                    <td>$referencia</td>
                                    <td>$observacion</td>
                                    <td>
                                        <button onclick='AsignaPagoPago ($id_pago,$cont2,$ayo_pago,$bgColorM)' type='button' class='btn bg-orange' >
                                            <i class='fa fa-plus-square'></i> &nbsp;ASIGNAR PAGO
                                        </button>
                                    </td>                                    
                                </tr>                                 
                           ";

        $cont++;
    }
    $html .= " </tbody>
                        </table>                        
                        ";
}

if (isset($_REQUEST['FACTURASDPT'])) {

    $queryFacturas = "select AYO,ID_FACTURA,FOLIO_SAT,PERIODO_INICIO,PERIODO_FIN,IMPORTE,PAGO,SALDO,OBSERVACION 
                    from V_FACTURAS where  ID_USUARIO='$id_usuario' and SITUACION ='timbrada' and SALDO>0";

    $executeFac = sqlsrv_query($conn, $queryFacturas);

    $html .= "<hr><button onclick='ValidarPago()' type='button' class='btn bg-orange' >
                                            <i class='fa fa-plus-square'></i> &nbsp;ASIGNAR PAGOS
                                        </button>
                                        <table class='table table-bordered table-hover table-responsive table-striped' id='tableFac'>
                            <thead>
                                <th>#</th>
                                <th>AÑO</th>
                                <th>ID FACTURA</th>
                                <th>FOLIO SAT</th>                                
                                <th>PERIODO</th>                                
                                <th>IMPORTE PAGO</th>                                
                                <th>PAGO</th>                                
                                <th>SALDO</th>
                                <th>OBSERVACIONES</th>                                                                
                                <th>ASIGNAR</th>                                                                                                                                                             
                            </thead>
                            <tbody>";

    $cont = 1;

    while ($row = sqlsrv_fetch_array($executeFac)) {
        $ayo = $row['AYO'];
        $id_factura = $row['ID_FACTURA'];
        $folio_sat = $row['FOLIO_SAT'];
        $periodo_inicio = date_format($row['PERIODO_INICIO'], $format);
        $periodo_fin = date_format($row['PERIODO_FIN'], $format);
        $importe = number_format( $row['IMPORTE']);
        $pago = number_format($row['PAGO']);
        $saldo = number_format($row['SALDO']);
        $observacion = $row['OBSERVACION'];

        $html .= "
                                <tr>
                                    <td>$cont</td>
                                    <td>$ayo</td>
                                    <td>$id_factura</td>
                                    <td>$folio_sat</td>
                                    <td>$periodo_inicio al $periodo_fin</td>
                                    <td>$importe</td>
                                    <td>$pago</td>
                                    <td>$saldo</td>
                                    <td>$observacion</td>
                                    <td>
                                    <input type='number' id='F$cont' onchange='updateMPA($cont)' style=' background-color: #FFF3C3;' value='' class='form form-control text-center'>
                                    </td>                                                                        
                                </tr>                                 
                           ";

        $cont++;
    }
    $html .= " </tbody>
                        </table>                        
                        ";
//                                            <td></td>
//                                    <td>$fecha_pago</td>
//                                    <td>$referencia</td>
}
echo $html;
