<?php
date_default_timezone_set('America/Mexico_City');
include_once '../../conexiones/sqlsrv.php';
$conn = connection_object();
$html = "";
$format="d/m/Y";
$format2="d/m/Y H:i";
$format3="d/m/Y h:i a";

$fecha_serv = date_create(date ('Y-m-d H:i:s', time()));


session_start();

$idOp = $_SESSION['ID_OPERADOR'];
if($idOp=='007'){
    $idOp = $_SESSION['NOMBRE'];
}
$switcher="ID_DESTINATARIO";
$queryOp = "select ID_OPERADOR,ID_PROGRAMA from BITACORA.DBO.Programa_Perfil where (ID_PROGRAMA=41 or ID_PROGRAMA=72 ) and ID_OPERADOR='$idOp'";
$execue = sqlsrv_query($conn, $queryOp);
if ($row = sqlsrv_fetch_array($execue)) {
    if ($row['ID_PROGRAMA'] == 41) {
        $idOp = "FACTURACION";
    } else if ($row['ID_PROGRAMA'] == 72) {
        $idOp = "COBRANZA";
    }
    $switcher="REMITENTE";
}

  $queryLoadMail = "select BD.ID_REGISTRO,BD.ID_DESTINATARIO,FECHA,REMITENTE,VUP.R_SOCIAL,ASUNTO,BZ.CVE_ESTADO from [dbo].[Buzon_Destinatario] BD
                    inner JOIN [dbo].[Buzon] BZ on BD.ID_REGISTRO=BZ.ID_REGISTRO
                    inner join [Facturacion].dbo.v_usuario_padron VUP on VUP.ID_USUARIO=$switcher
                  where ID_DESTINATARIO='$idOp'";
//
//ID_DESTINATARIO	FECHA	REMITENTE	R_SOCIAL	ASUNTO	SINTESIS
$executeQuer = sqlsrv_query($conn, $queryLoadMail);
$count1=1;
while ($row=sqlsrv_fetch_array($executeQuer)){
    $dest =$row['ID_DESTINATARIO'];
    $fecha = date_format($row['FECHA'], $format3);    
    $fecha3 = '"'.date_format($row['FECHA'], $format3).'"';    
//    $fecha2= date_timestamp_get($row['FECHA']);
    $fecha2= date_create(date_format($row['FECHA'], $format2));
    $remitente ='"'.$row['REMITENTE'].'"';
    $r_social ='"'.$row['R_SOCIAL'].'"';
    $r_social2 =$row['R_SOCIAL'];
    $asunto ='"'.$row['ASUNTO'].'"';
    $asunto2 =$row['ASUNTO'];
    $id_registro =$row['ID_REGISTRO'];
    $estado=$row['CVE_ESTADO'];
    if($estado==1){
        $estado="Nuevo"; 
        $class="unread";
        $iconEnvelope="fa fa-envelope-o";
    }else{
     $estado="Leído";   
     $class="read";
     $iconEnvelope="fa fa-envelope-open-o";
    }    
    
    $estado2='"'.$estado.'"';
//    $fecha2
//    $fecha_serv
    
//    $hace= date_diff($fecha2,$fecha_serv);
//    $ayo = $hace->format('%y');
//    $mes = $hace->format('%m');
//    $dia = $hace->format('%d');
//    $hora = $hace->format('%h');
//    $minutos = $hace->format('%i');
//        
//    $fecha_antiguedad="";    
//    $cant="";
//    if($ayo!='0'){
//        if($ayo!='1'){$cant='s';} else {$cant="";}
//        $fecha_antiguedad.=$ayo.' año'.$cant.' ';
//    }else if($mes!='0'){
//        if($mes!='1'){$cant='es';} else {$cant="";}
//        $fecha_antiguedad.=$mes.' mes'.$cant.' ';
//    }else if($dia!='0'){
//        if($dia!='1'){$cant='s';} else {$cant="";}
//        $fecha_antiguedad.=$dia.' dia'.$cant.' ';
//    }else if($hora!='0'){
//        if($hora!='1'){$cant='s';} else {$cant="";}
//        $fecha_antiguedad.=$hora.' hora'.$cant.' ';
//    }else if($minutos!='0'){
//        if($minutos!='1'){$cant='s';} else {$cant="";}
//        $fecha_antiguedad.=$minutos.' minuto'.$cant.' ';
//    }
    
    $html.="<tr class='$class' style='cursor: pointer' onclick='readMail($count1,$id_registro,$asunto,$r_social,$remitente,$fecha3,$estado2)' id='$count1'>
                <td class='mailbox-star'><b><span style='color:#1F618D'>$count1</span><b></td>
                <td class='mailbox-star'>
                    <a href='#'><i id='i$count1' class='$iconEnvelope text-blue'></i><label id='txt$count1'>&nbsp;&nbsp;$estado<label></a>
                </td>
                <td class='mailbox-name'>
                    <a href='#' style='text-decoration:none'>$r_social2</a>
                </td>
                <td class='mailbox-subject'>
                    <b><span style='color:#1F618D'>Asunto:</span></b> $asunto2
                </td>
                <td class='mailbox-attachment'>                
                </td>
                <td class='mailbox-date'>
                    <b><span style='color:#1F618D'>Recibido:</span></b> $fecha
                </td>
            </tr>";
    $count1++;
}

echo $html;
