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
$id_usuario2= isset($_REQUEST['ID_USUARIO2'])?$_REQUEST['ID_USUARIO2']:"";
$externo= isset($_REQUEST['EXTERNO'])?$_REQUEST['EXTERNO']:0;
isset($_REQUEST['PAGOS']) ? $pagos = $_REQUEST['PAGOS'] : "";
isset($_REQUEST['AYO_PAGO'])?$ayo_pago_Fac = $_REQUEST['AYO_PAGO']:$ayo_pago_Fac="";
isset($_REQUEST['ID_PAGO'])?$id_pago_Fac=$_REQUEST['ID_PAGO']:$id_pago_Fac="";

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

   $queryPagos = "select T1.AYO_PAGO,T1.ID_PAGO,T2.DESCRIPCION TIPO_PAGO,MONTO,case when  T1.CVE_PAGO_SIT = 8 then 0 else ISNULL(APLICADO,0) end APLICADO, case when  T1.CVE_PAGO_SIT = 8 then 0 else MONTO-ISNULL(APLICADO,0) end  POR_APLICAR,FECHA_PAGO,REFERENCIA,OBSERVACION,T4.DESCRIPCION
                       From pago T1
                       INNER JOIN C_Pago_Tipo T2 ON T1.CVE_PAGO_TIPO=T2.CVE_PAGO_TIPO
                       inner join  C_Pago_Situacion T4 on T1.CVE_PAGO_SIT=T4.CVE_PAGO_SIT
                       LEFT OUTER JOIN (SELECT AYO_PAGO,ID_PAGO, SUM(MONTO_APLICADO) APLICADO FROM PAGO_FACTURA GROUP BY AYO_PAGO,ID_PAGO ) T3 ON T1.AYO_PAGO=T3.AYO_PAGO AND T1.ID_PAGO=T3.ID_PAGO
                       where ID_USUARIO='$id_usuario' $tipoPago $and $ayo Order By FECHA_PAGO desc ";


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
        $tipo_pago = $row['TIPO_PAGO'];
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
            case "Cancelado":
                $bgEstatus="#FFC3C3";
                 $disabled="disabled='true'";
                break;
            case "Aplicado Totalmente":
                $bgEstatus="";
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
    
//    ********************* Cargar select con cuentas  *******************
    
    
    $_SESSION['TOTAL_PAGO_ASIGNADO']=0;

    if($externo==1){
        
        $queryFacturas = "select AYO,ID_FACTURA,FOLIO_SAT,PERIODO_INICIO,PERIODO_FIN,IMPORTE,PAGO,SALDO,OBSERVACION
                    from V_FACTURAS where  ID_USUARIO='$id_usuario2' and SITUACION ='timbrada' and SALDO>0";
        
    }else{
        $queryFacturas = "select AYO,ID_FACTURA,FOLIO_SAT,PERIODO_INICIO,PERIODO_FIN,IMPORTE,PAGO,SALDO,OBSERVACION
                    from V_FACTURAS where  ID_USUARIO='$id_usuario2' and SITUACION ='timbrada' and SALDO>0";

    }
    
    $executeFac = sqlsrv_query($conn, $queryFacturas);
    $html .= "<hr>
    <div class='row'>        
            <button disabled='true' id='btnValida' type='button'  onclick='laodPrepago()' class='btn bg-orange' >
                <i class='fa fa-plus-square'></i> &nbsp;ASIGNAR PAGOS
            </button>
            <button onclick='clearAsignaPago()' type='button' class='btn bg-blue' >
                        <i class='fa fa-refresh'></i> &nbsp;LIMPIAR CAMPOS
            </button>        
    </div>
    <br>                    
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
                          <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                              <div class='modal-header' style=' background-color: #2C3E50;'>
                                <h5 class='modal-title' id='exampleModalLabel' style='display:inline'></h5>
                                <button type='button' data-target='#exampleModal' data-toggle='modal' class='close' aria-label='Close'>
                                  <span aria-hidden='true'>&times;</span>
                                </button>
                                <center><h5 style='color:white; display:inline;'><b>VISTA PREVIA DE PAGOS</b></h5></center>
                              </div>
                              <div class='modal-body'>
                                <h4><label style='color:#1C4773'> ¿Está seguro de realizar estos pagos?</label></h4>                                
                                <table class='table table-bordered table-hover table-striped'>
                                    <thead>
                                        <tr>
                                            <th style=' background-color: #34495E'></th>
                                            <th style=' background-color: #34495E' colspan='5'>FACTURA</th>
                                            <th style=' background-color: #34495E' colspan='4'>PAGO</th>
                                        </tr>                                        
                                        <tr>
                                            <th>#</th>
                                            <th>AÑO</th>
                                            <th>ID FACTURA</th>
                                            <th>IMPORTE</th>
                                            <th>PAGO</th>
                                            <th>SALDO</th>                                            
                                            <th>ID</th>                                               
                                            <th>FECHA PAGO</th>                                            
                                            <th>MONTO ASIGNADO</th>                                            
                                            <th>ESTATUS</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody id='contenidoTb'>                                        
                                    </tbody>
                                </table>
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
