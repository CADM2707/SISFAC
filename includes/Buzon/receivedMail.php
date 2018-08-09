<?php
date_default_timezone_set('America/Mexico_City');
include_once '../../conexiones/sqlsrv.php';
$conn = connection_object();
$html = "";
$format="d/m/Y";
$format2="d/m/Y H:i";

$fecha_serv = date_create(date ('Y-m-d H:i:s', time()));

//echo $fecha_serv = date_timestamp_get($fecha_serv);
echo "<br>";

session_start();

$idOp = $_SESSION['ID_OPERADOR'];

$queryOp = "select ID_OPERADOR,ID_PROGRAMA from BITACORA.DBO.Programa_Perfil where (ID_PROGRAMA=41 or ID_PROGRAMA=72 ) and ID_OPERADOR='$idOp'";
$execue = sqlsrv_query($conn, $queryOp);
if ($row = sqlsrv_fetch_array($execue)) {
    if ($row['ID_PROGRAMA'] == 41) {
        $idOp = "FACTURACION";
    } else if ($row['ID_PROGRAMA'] == 72) {
        $idOp = "COBRANZA";
    }
}

$queryLoadMail = "select BD.ID_DESTINATARIO,FECHA,REMITENTE,VUP.R_SOCIAL,ASUNTO,SINTESIS from [dbo].[Buzon_Destinatario] BD
                    inner JOIN [dbo].[Buzon] BZ on BD.ID_REGISTRO=BZ.ID_REGISTRO
                    inner join [Facturacion].dbo.v_usuario_padron VUP on VUP.ID_USUARIO=REMITENTE
                  where ID_DESTINATARIO='$idOp'";
//
//ID_DESTINATARIO	FECHA	REMITENTE	R_SOCIAL	ASUNTO	SINTESIS
$executeQuer = sqlsrv_query($conn, $queryLoadMail);

while ($row=sqlsrv_fetch_array($executeQuer)){
    $dest =$row['ID_DESTINATARIO'];
    $fecha = date_format($row['FECHA'], $format);
//    $fecha2= date_timestamp_get($row['FECHA']);
    $fecha2= date_create(date_format($row['FECHA'], $format2));
    $remitente =$row['REMITENTE'];
    $r_social =$row['R_SOCIAL'];
    $asunto =$row['ASUNTO'];
    $mensaje =$row['SINTESIS'];
    
//    $fecha2
//    $fecha_serv
    
    $hace= date_diff($fecha2,$fecha_serv);
    echo $hace->format('%y');
//    echo "/";
//    echo $hace->format('%m mes(es)');
//    echo "/";
//    echo $hace->format('%d dia(s)');
//    echo ":";
//    echo $hace->format('%i minutos');
//    echo ":";
//    echo $hace->format('%i seg');
//    print_r($hace);
//    echo date_format($hace, $format2);
    echo "<br>";
//    $fecha_rest= ($fecha_serv - $fecha2);
//    echo $fecha_rest=date_format($fecha_rest, $format2);
//    
    
    $html.="<tr>
                <td class='mailbox-star'>
                    <a href='#'><i class='fa fa-envelope-o text-blue'></i></a>
                </td>
                <td class='mailbox-name'>
                    <a href='read-mail.html'>$r_social</a>
                </td>
                <td class='mailbox-subject'>
                    <b>$asunto</b> - $mensaje
                </td>
                <td class='mailbox-attachment'>                
                </td>
                <td class='mailbox-date'>
                    <b>Recibido:</b> $fecha
                </td>
                <td class='mailbox-date'>
                    <b>Hace:</b>  - 
                </td>
            </tr>";
}

echo $html;
