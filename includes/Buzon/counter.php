<?php
date_default_timezone_set('America/Mexico_City');
include_once '../../conexiones/sqlsrv.php';
$conn = connection_object();
$html = "";
$format="d/m/Y";
$format2="d/m/Y H:i";
$format3="d/m/Y h:i a";
$respuesta=array();
$fecha_serv = date_create(date ('Y-m-d H:i:s', time()));


session_start();

$idOp = $_SESSION['ID_OPERADOR'];
if($idOp=='007'){
    $idOp = $_SESSION['NOMBRE'];
}
$addCodeFC="inner join [Facturacion].dbo.v_usuario_padron VUP on VUP.ID_USUARIO=REMITENTE";
$heads="*";
$queryOp = "select ID_OPERADOR,ID_PROGRAMA from BITACORA.DBO.Programa_Perfil where (ID_PROGRAMA=41 or ID_PROGRAMA=72 ) and ID_OPERADOR='$idOp'";
$execue = sqlsrv_query($conn, $queryOp);
if ($row = sqlsrv_fetch_array($execue)) {
    if ($row['ID_PROGRAMA'] == 41) {
        $idOp = "FACTURACION";
    } else if ($row['ID_PROGRAMA'] == 72) {
        $idOp = "COBRANZA";
    }
    $switcher="REMITENTE";
    $addCodeFC=""; 
    $heads="BD.ID_REGISTRO,ID_DESTINATARIO,FECHA,REMITENTE,ASUNTO,CVE_ESTADO,SINTESIS,ID_REFENCIA ";
}

$queryCounSendtMail = "select 
COUNT(BD.ID_REGISTRO) 
from [dbo].[Buzon_Destinatario] BD 
inner JOIN [dbo].[Buzon] BZ on BD.ID_REGISTRO=BZ.ID_REGISTRO 
inner join [Facturacion].dbo.v_usuario_padron VUP on VUP.ID_USUARIO=ID_DESTINATARIO 
where ID_DESTINATARIO='$idOp'
union
select 
COUNT(BD.ID_REGISTRO) 
from [dbo].[Buzon_Destinatario] BD 
inner JOIN [dbo].[Buzon] BZ on BD.ID_REGISTRO=BZ.ID_REGISTRO 
where REMITENTE='$idOp'";

$executeQuer = sqlsrv_query($conn, $queryCounSendtMail);
$cont=0;
while($CounSendtMail=sqlsrv_fetch_array($executeQuer)){
    $respuesta[$cont]=$CounSendtMail[0];
    $cont++;
}

$query="select 
$heads
from [dbo].[Buzon_Destinatario] BD 
inner JOIN [dbo].[Buzon] BZ on BD.ID_REGISTRO=BZ.ID_REGISTRO 
$addCodeFC
where REMITENTE='$idOp' order by FECHA desc";

$execQuery=sqlsrv_query($conn, $query);

$count1=0;
while ($row=sqlsrv_fetch_array($execQuery)){
    $count1++;
    $dest =$row['ID_DESTINATARIO'];
    $fecha = date_format($row['FECHA'], $format3);    
    $fecha3 = '"'.date_format($row['FECHA'], $format3).'"';    
//    $fecha2= date_timestamp_get($row['FECHA']);
    $fecha2= date_create(date_format($row['FECHA'], $format2));
    $remitente ='"'.$row['ID_DESTINATARIO'].'"';    
    if ($idOp=="FACTURACION") {
        $r_social ='"FACTURACION"';
        $r_social2 ='"FACTURACION"';
    }else{
        $r_social ='"'.isset($row['R_SOCIAL'])?$row['R_SOCIAL']:"".'"';
        $r_social2 =isset($row['R_SOCIAL'])?$row['R_SOCIAL']:""; 
    }
    
    $asunto ='"'.$row['ASUNTO'].'"';
    $asunto2 =$row['ASUNTO'];
    $id_registro =$row['ID_REGISTRO'];
    $estado=$row['CVE_ESTADO'];

     $estado="Envíado";   
     $class="read";
     $iconEnvelope="fa fa-envelope-o";
    

  $estado2='"'.$estado.'"';
  
   $html.="<tr class='$class' style='cursor: pointer' onclick='readMail($count1,$id_registro,$asunto,$r_social,$remitente,$fecha3,$estado2)' id='$count1'>
                <td class='mailbox-star'><b><span style='color:#1F618D'>$count1</span><b></td>
                <td class='mailbox-star'>
                    <a href='#'><i id='i$count1' class='$iconEnvelope text-blue'></i><label id='txt$count1'>&nbsp;&nbsp;$estado<label></a>
                </td>
                <td class='mailbox-name'>
                    <a href='#' style='text-decoration:none'>$r_social2</a>
                </td>
                <td class='mailbox-subject' style='text-align:left !important'>
                    <b><span style='color:#1F618D'>Asunto:</span></b> $asunto2
                </td>
                <td class='mailbox-attachment'>                
                </td>
                <td class='mailbox-date'>
                    <b><span style='color:#1F618D'>Enviado:</span></b> $fecha
                </td>
            </tr>";    
}
if($respuesta[0]==0){
    $respuesta[0]=$count1;
}
if($html==""){
    $html="<tr class=' text-center'>
            <td rowspan='7'><i><label style='color:#1F618D !important'>Mensajes enviados (0 Mensajes)</label></i></td>
           </tr>";
}
$respuesta[2]=$html;

echo json_encode($respuesta);
