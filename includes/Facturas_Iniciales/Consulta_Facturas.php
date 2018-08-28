<?php
include_once '../../conexiones/sqlsrv.php';
$conn = connection_object();

$ayo = isset($_REQUEST['AYO']) ? $_REQUEST['AYO'] : "";
$situacion = isset($_REQUEST['SITUACION']) ? $_REQUEST['SITUACION'] : "";
$p1 = isset($_REQUEST['PERIODO1']) ? $_REQUEST['PERIODO1'] : "";
$p2 = isset($_REQUEST['PERIODO2']) ? $_REQUEST['PERIODO2'] : "";
$id_usr =isset($_REQUEST['USUARIO']) ? $_REQUEST['USUARIO'] : "";
$fecha =isset($_REQUEST['FECHAS']) ? $_REQUEST['FECHAS'] : "";
$addCOde="where ID_USUARIO='$id_usr'";
$html="";
$format="Y/m/d";

if($ayo!=""){ $addCOde.=" and AYO =$ayo";}
//if($ayo!="" and $situacion!=""){ 
//    $addCOde.=" and OBSERVACION='$situacion'";    
//} else if( $ayo=="" and $situacion!=""){
//    $addCOde.=" OBSERVACION='$situacion'";
//}
//
if(($p1!="" or $p2!="") and $fecha!=""){ 
    if($fecha==2){
        $addCOde.=" and (FECHA_EMISION BETWEEN '$p1' and '$p2')";
    }else if($fecha==1){
        if($p1!="" ){
            $addCOde.=" and PERIODO_INICIO like '%$p1%'";
        }else if($p2!=""){
            $addCOde.=" and PERIODO_FIN like '%$p2%'";
        }
    }
}
if($situacion!=""){
   $addCOde.=" and OBSERVACION='$situacion'";
}

$query="select * from [dbo].[V_FACTURAS] $addCOde Order By AYO DESC";
$execue=sqlsrv_query($conn,$query);

 $html.="<table class='table table-bordered table-hover table-responsive table-striped' id='tableRes'>
                            <thead>
                                <th>#</th>
                                <th>AÑO</th>
                                <th>ID RECIBO</th>
                                <th>PERIODO</th>                                
                                <th>TURNOS</th>                                
                                <th>IMPORTE</th>                                
                                <th>PAGO</th>
                                <th>OBSERVACIONES</th>
                                <th>SALDO</th>
                                <th>FOLIO SAT</th>
                                <th>SITUACION</th>
                                <th>DETALLE PAGOS</th>
                            </thead>
                            <tbody>";
    $lineas=0;
    while($row=sqlsrv_fetch_array($execue)){
     $lineas++;
    $id_usu= $row['ID_USUARIO'];
    $r_social= $row['R_SOCIAL'];
    $ayoRes= $row['AYO'];
    $cve_situacion= $row['SITUACION'];
    $idRecibo= $row['ID_FACTURA'];
    $imp= number_format($row['IMPORTE']);
    if(isset($row['PERIODO_INICIO']) and isset($row['PERIODO_FIN'])){ 
        $periodo= date_format($row['PERIODO_INICIO'], $format) .' - '.date_format($row['PERIODO_FIN'], $format);         
    }else{
        $periodo="<span style='color:red'>SIN FECHA<span>";
    }
    $pago= number_format($row['PAGO']);
    $obs= $row['OBSERVACION'];
    $saldo= number_format($row['SALDO']);
    $folioSAT= $row['FOLIO_SAT'];
    $disabled="";    
    if($obs =='NO PAGADA'){
        $disabled="disabled='true'";        
    }
    
    $html.="
                                <tr>
                                    <td>$lineas</td>
                                    <td>$ayoRes</td>
                                    <td>$idRecibo</td>
                                    <td>$periodo</td>
                                    <td></td>
                                    <td>$$imp</td>
                                    <td>$$pago</td>
                                    <td>$obs</td>
                                    <td>$$saldo</td>                                    
                                    <td>$folioSAT</td>                                    
                                    <td>$cve_situacion</td>                                    
                                    <td>
                                        <button $disabled onclick='verPago ($idRecibo,$ayoRes)' type='button' class='btn btn-warning' >
                                            <i class='fa  fa-file-pdf-o'></i> VER
                                        </button>
                                    </td>
                                </tr>                                                               
                           ";
}


if( $lineas>0){ 
   $html .= " </tbody>
                        </table>";
}else{
//    $html=1;
}


echo $html;