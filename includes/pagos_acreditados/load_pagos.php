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

isset($_REQUEST['AYO_PAGO'])?$ayo_pago_Fac = $_REQUEST['AYO_PAGO']:$ayo_pago_Fac="";
isset($_REQUEST['ID_PAGO'])?$id_pago_Fac=$_REQUEST['ID_PAGO']:$id_pago_Fac="";
 
if ($pagos != "" ) {

    isset($_REQUEST['AYO']) ? $ayo = $_REQUEST['AYO'] : "";
    isset($_REQUEST['TIPO_PAGO']) ? $tipoPago = $_REQUEST['TIPO_PAGO'] : "";

    switch ($tipoPago) {
        case 1:
            $tipoPago = " and CVE_PAGO_SIT in (3,4)";
            break;
        case 2:
            $tipoPago = "and CVE_PAGO_SIT = 4";
            break;
        case 3:
            $tipoPago = " and CVE_PAGO_SIT = 3";
            break;
        default:
            $tipo_pago = "";
            break;
    }

    if ($ayo != "") {
        $ayo = "and T1.AYO_PAGO=$ayo";
    }
    if($ayo!="" and $tipoPago!=""){
        $and="";
    }else{
        $and="";
    }
   $queryPagos = "select T1.AYO_PAGO,T1.ID_PAGO,T2.DESCRIPCION TIPO_PAGO,MONTO,ISNULL(APLICADO,0)APLICADO,MONTO-ISNULL(APLICADO,0) POR_APLICAR,FECHA_PAGO,REFERENCIA,OBSERVACION From pago T1
                    INNER JOIN C_Pago_Tipo T2 ON T1.CVE_PAGO_TIPO=T2.CVE_PAGO_TIPO
                    LEFT OUTER JOIN (SELECT AYO_PAGO,ID_PAGO, SUM(MONTO_APLICADO) APLICADO FROM PAGO_FACTURA GROUP BY AYO_PAGO,ID_PAGO ) T3 ON T1.AYO_PAGO=T3.AYO_PAGO AND T1.ID_PAGO=T3.ID_PAGO
                    where ID_USUARIO='$id_usuario' $tipoPago $and $ayo Order By FECHA_PAGO desc ";


    $executeQuery = sqlsrv_query($conn, $queryPagos);

    $html .= "<table class='table table-bordered table-hover table-responsive table-striped' id='tableRes'>
                            <thead>
                                <th>#</th>
                                <th>AÑO</th>
                                <th>ID PAGO</th>
                                <th>TIPO PAGO</th>                                
                                <th>MONTO</th>                                .
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
                                        <button $disabled onclick='AsignaPagoPago($id_pago,$cont2,$ayo_pago,$bgColorM)' type='button' class='btn bg-orange' >
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

if (isset($_REQUEST['FACTURASDPT']) and $ayo_pago_Fac!="" and $id_pago_Fac!="") {
    $_SESSION['TOTAL_PAGO_ASIGNADO']=0;

    $queryFacturas = "select AYO,ID_FACTURA,FOLIO_SAT,PERIODO_INICIO,PERIODO_FIN,IMPORTE,PAGO,SALDO,OBSERVACION 
                    from V_FACTURAS where  ID_USUARIO='$id_usuario' and SITUACION ='timbrada' and SALDO>0";

    $executeFac = sqlsrv_query($conn, $queryFacturas);

    $html .= "<hr>                
                    <button type='button'  data-toggle='modal' data-target='#exampleModal' class='btn bg-orange' >
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
                                    <td>
                                        <input type='number' readonly='true' id='AYO$cont' name='AYO$cont' value='$ayo' class='form form-control text-center'>
                                    </td>
                                    <td>
                                        <input type='number' readonly='true' id='ID_FACTURA$cont' name='ID_FACTURA$cont' value='$id_factura' class='form form-control text-center'>
                                    </td>
                                    <td>
                                        $folio_sat
                                    </td>
                                    <td>$periodo_inicio al $periodo_fin</td>
                                    <td>
                                        $importe
                                    </td>
                                    <td>
                                        $pago
                                    </td>
                                    <td>
                                        $saldo
                                    </td>
                                    <td>$observacion</td>
                                    <td>
                                    <input type='number' id='F$cont' name='F$cont' onchange='updateMPA($cont,$importe,$pago,$saldo)' style=' background-color: #FFF3C3;' class='form form-control text-center'>
                                    </td>                                                                        
                                </tr>                                 
                           ";

        $cont++;
    }
    $cont=$cont-1;
    $html .= " </tbody>
                        </table>
                        <input type='hidden' value='$cont' id='totalRows' name='totalRows'>
                            
                        <div class='modal fade' id='exampleModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                          <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                              <div class='modal-header' style=' background-color: #2C3E50;'>
                                <h5 class='modal-title' id='exampleModalLabel' style='display:inline'></h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                  <span aria-hidden='true'>&times;</span>
                                </button>
                              </div>
                              <div class='modal-body'>
                                <h4><label> ¿Está seguro de realizar estos pagos?</label></h4>
                              </div>
                              <div class='modal-footer'>
                                <center>
                                <button type='button' class='btn btn-warning' data-target='#exampleModal' data-toggle='modal' >Cancelar</button>
                                <button type='button' class='btn btn-success' data-dismiss='modal' onclick='guardaPago()'>Guardar</button>
                                </center>
                              </div>
                            </div>
                          </div>
                        </div>
                        ";
}
echo $html;
