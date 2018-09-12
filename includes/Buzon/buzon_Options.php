<?php

include '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();
$html="";

if(isset($_REQUEST['CLIENTE']) and isset($_REQUEST['DESTINATARIO'])){

    $cliente=$_REQUEST['CLIENTE'];


    if($cliente=='SI'){

            $html.="<option value='FACTURACION'> FACTURACION</option>
                <option value='COBRANZA'> COBRANZA</option>";

    }else{
        $id_Op=$_SESSION['ID_OPERADOR'];
        $queryCliente="select ID_OPERADOR,ID_PROGRAMA from BITACORA.DBO.Programa_Perfil where (ID_PROGRAMA=41 or ID_PROGRAMA=72 ) and CVE_PERFIL=1 and ID_OPERADOR='$id_Op'";
        $executeCliente=sqlsrv_query($conn,$queryCliente);
        $row=sqlsrv_fetch_array($executeCliente);
        if(count($row)!=""){
            $html = destinatarios($conn);
        }else{
            $html.="<option value='FACTURACION'> FACTURACION</option>
                <option value='COBRANZA'> COBRANZA</option>";
        }

    }
}

if(isset($_REQUEST['id_registro'])? $id_registro = $_REQUEST['id_registro']:false){
    
   $queryContMsj="select SINTESIS,CVE_ESTADO from Buzon where ID_REGISTRO=$id_registro";
   $executeContMsj=sqlsrv_query($conn,$queryContMsj);
   
   if($row=sqlsrv_fetch_array($executeContMsj)){
       $html=$row['SINTESIS'];
       $estatus=$row['CVE_ESTADO'];
   }
   
   if($estatus==1){
       $queryUpdate="update Buzon set CVE_ESTADO=2 where ID_REGISTRO=$id_registro";
       $executeUpdate=sqlsrv_query($conn,$queryUpdate);
   }   
}




function destinatarios($conn){
    $html="";
            $loadRemisor="select VUP.ID_USUARIO,VUP.R_SOCIAL from [Bitacora].[dbo].[Cliente_Padron] CP
	   inner JOIN
	   [Facturacion].dbo.v_usuario_padron VUP on VUP.ID_USUARIO= CP.ID_USUARIO
            order by VUP.ID_USUARIO asc
           ";

        $execue=sqlsrv_query($conn,$loadRemisor);

        while($row=sqlsrv_fetch_array($execue)){
            $r_social= utf8_encode($row['R_SOCIAL']);
            $id_usuario=$row['ID_USUARIO'];
            $html.="<option value='$id_usuario'> $r_social - $id_usuario</option>";
        }
        return $html;
}


 echo $html;
