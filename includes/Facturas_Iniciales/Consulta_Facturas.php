<?php
include_once '../../conexiones/sqlsrv.php';
$conn = connection_object();

$ayo = isset($_REQUEST['AYO']) ? $_REQUEST['AYO'] : "";
$situacion = isset($_REQUEST['SITUACION']) ? $_REQUEST['SITUACION'] : "";
$p1 = isset($_REQUEST['PERIODO1']) ? $_REQUEST['PERIODO1'] : "";
$p2 = isset($_REQUEST['PERIODO2']) ? $_REQUEST['PERIODO2'] : "";
$id_usr =isset($_REQUEST['USUARIO']) ? $_REQUEST['USUARIO'] : "";
$addCOde="";
$html="";
$format="d/m/Y";

if($ayo!="" || $situacion!="" || $p1!="" || $p1!="" || $id_usr!=""){
    $addCOde="where";
}
if($ayo!=""){ $addCOde.=" AYO =$ayo";}
if($ayo!="" and $situacion!=""){ 
    $addCOde.=" and OBSERVACION='$situacion'";    
} else if( $ayo=="" and $situacion!=""){
    $addCOde.=" OBSERVACION='$situacion'";
}

if($situacion!="" and ($p1!="" or $p2!="")){ 
    $addCOde.=" and (PERIODO_INICIO BETWEEN '$p1' and '$p2' or PERIODO_FIN BETWEEN '$p1' and '$p2')";
}else if($situacion=="" and ($p1!="" or $p2!="")){
    $addCOde.=" (PERIODO_INICIO BETWEEN '$p1' and '$p2' or PERIODO_FIN BETWEEN '$p1' and '$p2')";
}
if((($p1!="" or $p2!="") and $id_usr!="") || $ayo!="" || $situacion!=""){
    $addCOde.=" and id_usuario ='$id_usr' ";
}else{
    $addCOde.=" id_usuario ='$id_usr' ";
}

$query="select * from [dbo].[V_FACTURAS] $addCOde";
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
                                <th>DETALLE PAGOS</th>
                            </thead>
                            <tbody>";
    $lineas=0;
    while($row=sqlsrv_fetch_array($execue)){
     $lineas++;
    $id_usu= $row['ID_USUARIO'];
    $r_social= $row['R_SOCIAL'];
    $ayoRes= $row['AYO'];
    $idRecibo= $row['ID_FACTURA'];
    $imp= number_format($row['IMPORTE']);
    $periodo= date_format($row['PERIODO_INICIO'], $format) .' - '.date_format($row['PERIODO_FIN'], $format);
    $pago= number_format($row['PAGO']);
    $obs= $row['OBSERVACION'];
    $saldo= number_format($row['SALDO']);
    $folioSAT= $row['FOLIO_SAT'];

    
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
                                    <td>
                                        <button onclick='verPago ($idRecibo,$ayoRes)' type='button' class='btn btn-warning' >
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
    $html=1;
}


echo $html;