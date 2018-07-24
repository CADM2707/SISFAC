<?php
include_once '../../conexiones/sqlsrv.php';
$conn = connection_object();

$ayo = isset($_REQUEST['AYO']) ? $_REQUEST['AYO'] : "";
$situacion = isset($_REQUEST['SITUACION']) ? $_REQUEST['SITUACION'] : "";

$addCOde="";
$html="";

if($ayo!="" || $situacion!=""){
    $addCOde="where";
}
if($ayo!=""){ $addCOde.=" AYO =$ayo";}
if($ayo!="" and $situacion!=""){ $addCOde.=" and";}
if($situacion!=""){ $addCOde.=" OBSERVACION='$situacion'";}

$query="select * from [dbo].[V_FACTURAS] $addCOde";
$execue=sqlsrv_query($conn,$query);

$html.="<table class='table table-bordered table-hover table-responsive table-striped'>
                            <thead>
                                <th>ID USUARIO</th>
                                <th>R. SOCIAL</th>
                                <th>AÑO.</th>
                                <th>QNA.</th>
                                <th>IMP.</th>
                                <th>SITUACION</th>
                                <th>FACTURA</th>
                                <th>REP</th>
                            </thead>
                            <tbody>";

while($row=sqlsrv_fetch_array($execue)){.0
    
    
    $id_usu= $row['ID_USUARIO'];
    $r_social= $row['R_SOCIAL'];
    $ayoRes= $row['AYO'];
    $qna= $row[''];
    $imp= $row[''];
    $situacionRes= $row[''];
    $fac= $row[''];
    $rep= $row[''];
    
    $html.="
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><button type='button' class='btn btn-primary' ><i class='fa  fa-file-pdf-o'></i> PDF &nbsp;| &nbsp;<i class='fa fa-file-excel-o'></i> XML</button></td>
                                    <td><button type='button' class='btn btn-warning' ><i class='fa  fa-list-ul'></i>&nbsp; DETALLES</button></td>
                                </tr>                                                               
                           ";
}

$html .= " </tbody>
                        </table>";
echo $html;