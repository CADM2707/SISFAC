<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();
$format = "d/m/Y";

$html = "";
$ayo = "";
$pagos = "";
$tipoPago = "";
$htb="";
$id_usuario = $_SESSION['NOMBRE'];

isset($_REQUEST['PAGOS']) ? $pagos = $_REQUEST['PAGOS'] : "";
isset($_REQUEST['AYO_PAGO'])?$ayo_pago_Fac = $_REQUEST['AYO_PAGO']:$ayo_pago_Fac="";
isset($_REQUEST['ID_PAGO'])?$id_pago_Fac=$_REQUEST['ID_PAGO']:$id_pago_Fac="";
$externo= isset($_REQUEST['EXTERNO'])?$_REQUEST['EXTERNO']:0;
$id_usuario2= isset($_REQUEST['ID_USUARIO2'])?$_REQUEST['ID_USUARIO2']:"";

if ($pagos != "" ) {

    isset($_REQUEST['AYO']) ? $ayo = $_REQUEST['AYO'] : "";
    isset($_REQUEST['TIPO_PAGO']) ? $tipoPago = $_REQUEST['TIPO_PAGO'] : "";

    switch ($tipoPago) {
        case 1:
            $tipoPago = " and T1.CVE_PAGO_SIT in (3,4,8)";
            break;
        case 2:
            $tipoPago = " and T1.CVE_PAGO_SIT = 4";
            break;
        case 3:
            $tipoPago = " and T1.CVE_PAGO_SIT = 3";
            break;
        case 4:
            $tipoPago = " and T1.CVE_PAGO_SIT = 8";
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

  $queryPagos = "(select T1.AYO_PAGO,T1.ID_PAGO,T2.DESCRIPCION TIPO_PAGO,MONTO,case when T1.CVE_PAGO_SIT = 8 then 0 else ISNULL(APLICADO,0) end APLICADO, case when T1.CVE_PAGO_SIT = 8 then 0 else MONTO-ISNULL(APLICADO,0) end POR_APLICAR,FECHA_PAGO,REFERENCIA,OBSERVACION,T4.DESCRIPCION
                        From pago T1 INNER JOIN C_Pago_Tipo T2 ON T1.CVE_PAGO_TIPO=T2.CVE_PAGO_TIPO inner join C_Pago_Situacion T4 on T1.CVE_PAGO_SIT=T4.CVE_PAGO_SIT
                        LEFT OUTER JOIN (SELECT AYO_PAGO,ID_PAGO, SUM(MONTO_APLICADO) APLICADO FROM PAGO_FACTURA GROUP BY AYO_PAGO,ID_PAGO ) T3 ON T1.AYO_PAGO=T3.AYO_PAGO AND T1.ID_PAGO=T3.ID_PAGO
                        where ID_USUARIO='$id_usuario' $tipoPago $and $ayo)
                        union 
                        (
                        select year(FECHA_REGISTRO),T1.ID_REGISTRO,T2.DESCRIPCION TIPO_PAGO,MONTO,0 APLICADO,
                            case when T1.CVE_SITUACION = 4 then 0 else MONTO end POR_APLICAR,FECHA_PAGO,REFERENCIA,OBSERVACIONES,T4.SITUACION_APLICADO
                            From Pago_Solicitud T1
                            INNER JOIN C_Pago_Tipo T2 ON T1.CVE_SITUACION=T2.CVE_PAGO_TIPO
                            inner join C_Pago_Situacion_Aplicado T4 on T1.CVE_SITUACION=T4.CVE_SITUACION_APLICADO
                        where ID_USUARIO='$id_usuario' and CVE_SITUACION_APLICADO<>3
                        )                                            
                        Order By FECHA_PAGO desc ";


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
                                <th>ESTATUS</th>
                                <th>OBSERVACIONES</th>
                                <th>DETALLES</th>
                            </thead>
                            <tbody>";

    $cont = 1;
    while ($row = sqlsrv_fetch_array($executeQuery)) {

        $ayo_pago = $row['AYO_PAGO'];
        $id_pago = $row['ID_PAGO'];
        $tipo_pago = utf8_encode($row['TIPO_PAGO']);
        $estatus = $row['DESCRIPCION'];
        $monto = number_format($row['MONTO'],2);
        $monto2 = '"' . ($row['MONTO']) . '"';
        $fecha_pago = date_format($row['FECHA_PAGO'], $format);
        $referencia = utf8_encode($row['REFERENCIA']);
        $observacion = utf8_encode($row['OBSERVACION']);
        $montoA= number_format($row['APLICADO'],2);
        $montoPA=number_format($row['POR_APLICAR'],2);
        $cont2 = '"' . $cont . '"';
        $disabled="";
        $bgColorM="";
        $bgEstatus="";
        switch ($estatus) {
            case "Aplicado Parcialmente":
                $bgEstatus="#CCC3FF";
                break;
            case "RECHAZADO":
                $bgEstatus="#FFC3C3";
                 $disabled="disabled='true'";
                break;
            case "Aplicado Totalmente":
                $bgEstatus="#C3FFD3";
                break;
            case "SOLICITADO":
                $bgEstatus="#C3E6FF";
                break;
            

            default:
                break;
        }
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
                                    <td style='background-color: $bgEstatus;'><label>$estatus</label></td>
                                    <td>$observacion</td>
                                    <td>
                                        <button $disabled onclick='AsignaPagoPago ($id_pago,$cont2,$ayo_pago,$bgColorM)' type='button' class='btn bg-orange' >
                                            <i class='fa fa-plus-square'></i> &nbsp;VER
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
    $_SESSION['TOTAL_PAGO_ASIGNADO']=0;

    $queryFacturas = "SELECT T1.AYO,T1.ID_FACTURA,PERIODO_INICIO,PERIODO_FIN,R_SOCIAL,FOLIO_SAT,IMPORTE,PAGO,SALDO,T2.OBSERVACION,FECHA_APLICADO
                      FROM Pago_Factura T1 INNER JOIN V_FACTURAS T2  ON  T1.AYO=T2.AYO AND T1.ID_FACTURA=T2.ID_FACTURA 
                      WHERE AYO_PAGO=$ayo_pago_Fac AND ID_PAGO=$id_pago_Fac";

    $executeFac = sqlsrv_query($conn, $queryFacturas);

    $html .= "<hr>                                        
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
                                <th>FECHA PAGO APLICADO</th>                               
                                <th>OBSERVACIONES</th>                                
                            </thead>
                            <tbody>";

    $cont = 1;

    while ($row = sqlsrv_fetch_array($executeFac)) {
        $ayo = $row['AYO'];
        $id_factura = $row['ID_FACTURA'];
        $folio_sat = $row['FOLIO_SAT'];
        $periodo_inicio = date_format($row['PERIODO_INICIO'], $format);
        $periodo_fin = date_format($row['PERIODO_FIN'], $format);
        $importe = number_format( $row['IMPORTE'],2);
        $pago = number_format($row['PAGO'],2);
        $saldo = number_format($row['SALDO'],2);
        $observacion = $row['OBSERVACION'];
        $FECHA_APLICADO=date_format($row['FECHA_APLICADO'],$format);
        $html .= "
        <tr>
            <td>$cont</td>
            <td>
                <input type='hidden' readonly='true' id='AYO$cont' name='AYO$cont' value='$ayo' class='form form-control text-center'>
                    $ayo
            </td>
            <td>
                <input type='hidden' readonly='true' id='ID_FACTURA$cont' name='ID_FACTURA$cont' value='$id_factura' class='form form-control text-center'>
                    $id_factura
            </td>
            <td>
                $folio_sat
            </td>
            <td>$periodo_inicio al $periodo_fin</td>
            <td>
                <input type='hidden' readonly='true' id='importeVal$cont' name='importeVal$cont' value='$importe' class='form form-control text-center'>
                    $importe
            </td>
            <td>
            <input type='hidden' readonly='true' id='pagoVal$cont' name='pagoVal$cont' value='$pago' class='form form-control text-center'>
                $pago
            </td>
            <td>
            <input type='hidden' readonly='true' id='saldoVal$cont' name='saldoVal$cont' value='$saldo' class='form form-control text-center'>
                $saldo
            </td>
            <td>$FECHA_APLICADO</td>
            <td>$observacion</td>
            
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


if (isset($_REQUEST['FACTURASDPT2'])) {
    
    $_SESSION['TOTAL_PAGO_ASIGNADO']=0;

    if($externo==1){
        
        $queryFacturas = "select AYO,ID_FACTURA,FOLIO_SAT,PERIODO_INICIO,PERIODO_FIN,IMPORTE,PAGO,SALDO,OBSERVACION
                    from V_FACTURAS where  ID_USUARIO='$id_usuario' and SITUACION ='timbrada' and SALDO>0 ORDER BY AYO desc";
        
    }else{
        $queryFacturas = "select AYO,ID_FACTURA,FOLIO_SAT,PERIODO_INICIO,PERIODO_FIN,IMPORTE,PAGO,SALDO,OBSERVACION
                    from V_FACTURAS where  ID_USUARIO='$id_usuario' and SITUACION ='timbrada' and SALDO>0 ORDER BY AYO desc";

    }
    
    $executeFac = sqlsrv_query($conn, $queryFacturas);

    $html .= "<hr>
                    <div class='row'>
                    <button type='button'  data-toggle='modal' data-target='#exampleModal' class='btn bg-orange' >
                        <i class='fa fa-plus-square'></i> &nbsp;ASIGNAR PAGOS
                    </button>
                    <button onclick='clearAsignaPago()' type='button' class='btn bg-blue' >
                        <i class='fa fa-refresh'></i> &nbsp;LIMPIAR CAMPOS
                    </button> 
                    </row>  <br><br>                 
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
        $importe = number_format( $row['IMPORTE'],2);
        $pago = number_format($row['PAGO'],2);
        $saldo = number_format($row['SALDO'],2);
        $observacion = $row['OBSERVACION'];

        $html .= "
        <tr>
            <td>$cont</td>
            <td>
                <input type='hidden' readonly='true' id='AYO$cont' name='AYO$cont' value='$ayo' class='form form-control text-center'>
                    $ayo
            </td>
            <td>
                <input type='hidden' readonly='true' id='ID_FACTURA$cont' name='ID_FACTURA$cont' value='$id_factura' class='form form-control text-center'>
                    $id_factura
            </td>
            <td>
                $folio_sat
            </td>
            <td>$periodo_inicio al $periodo_fin</td>
            <td>
                <input type='hidden' readonly='true' id='importeVal$cont' name='importeVal$cont' value='$importe' class='form form-control text-center'>
                    $importe
            </td>
            <td>
            <input type='hidden' readonly='true' id='pagoVal$cont' name='pagoVal$cont' value='$pago' class='form form-control text-center'>
                $pago
            </td>
            <td>
            <input type='hidden' readonly='true' id='saldoVal$cont' name='saldoVal$cont' value='$saldo' class='form form-control text-center'>
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





