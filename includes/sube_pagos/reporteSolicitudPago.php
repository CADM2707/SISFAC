<?php
include_once '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();
$html = "";
$format="d/m/Y";
$id_usuario = $_SESSION['NOMBRE'];

$query="select t1.ID_REGISTRO,FECHA_PAGO,MONTO,REFERENCIA,t2.NO_CUENTA,t4.BANCO,t3.DESCRIPCION situacion
        from Pago_Solicitud t1
            left outer join  Metodo_Pago t2 on t1.CUENTA=t2.ID_REGISTRO and t1.ID_USUARIO=t2.ID_USUARIO
            left outer join  C_Pago_Situacion t3 on t1.CVE_SITUACION=t3.CVE_PAGO_SIT
            left outer join  c_banco t4 on t2.ID_BANCO=t4.ID_BANCO
        where t1.ID_USUARIO='$id_usuario' order by t1.ID_REGISTRO DESC";


    $executeQuery = sqlsrv_query($conn, $query);

    $html .= "<table class='table table-bordered table-hover table-responsive table-striped' id='tableFac'>
                            <thead>
                                <th>#</th>
                                <th>ID REGISTRO</th>
                                <th>FECHA DE PAGO</th>
                                <th>MONTO</th>                                
                                <th>REFERENCIA</th>                               
                                <th>NO. CUENTA</th>                                
                                <th>BANCO</th>                                
                                <th>ESTATUS</th>
                                <th>COMPROBANTE</th>
                            </thead>
                            <tbody>";

    $cont = 1;
    while ($row = sqlsrv_fetch_array($executeQuery)) {
//  id_registro	fecha_pago	monto	referencia	no_cuenta	banco	situacion

        $id_registro = $row['ID_REGISTRO'];
        $fecha_pago = date_format($row['FECHA_PAGO'], $format);
        $monto = number_format($row['MONTO']);
        $referencia = $row['REFERENCIA'];
        $no_cuenta = $row['NO_CUENTA'];        
        $banco = $row['BANCO'];
        $situacion = $row['situacion'];                             
        $pdf="comprobante_pago/$id_registro.pdf";
        if(!file_exists($pdf)){            
            $pdf="<a autofocus='false' data-fancybox class='btn btn-warning' href='../includes/sube_pagos/comprobante_pago/0.jpg' title='Directivas'>
                    <i class='fa fa-file-pdf-o'></i> &nbsp;VER
                  </a> ";
        }else{            
            $pdf="<a data-fancybox class='btn btn-warning' data-type='iframe' data-src='../includes/sube_pagos/comprobante_pago/$id_registro.pdf' href='javascript:;'>
                                        <i class='fa fa-file-pdf-o'></i> &nbsp;VER
                                    </a>";
        }
        $html .= "
                                <tr>
                                    <td>$cont</td>
                                    <td>$id_registro</td>
                                    <td>$fecha_pago</td>
                                    <td>$monto</td>                                                                                   
                                    <td>$referencia</td>                                                                                   
                                    <td>$no_cuenta</td>                                                                                   
                                    <td>$banco</td>                                                                                   
                                    <td>$situacion</td>                                                                                   
                                    <td>$pdf</td>                                                                                   
                                </tr>                                 
                           ";

        $cont++;
    }
   echo $html .= " </tbody>
                        </table>                        
                        ";