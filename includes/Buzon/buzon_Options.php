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
        $loadRemisor="select VUP.ID_USUARIO,VUP.R_SOCIAL from [Bitacora].[dbo].[Cliente_Padron] CP
	   inner JOIN 
	   [Facturacion].dbo.v_usuario_padron VUP on VUP.ID_USUARIO= CP.ID_USUARIO
            order by VUP.R_SOCIAL asc
           ";
        
        $execue=sqlsrv_query($conn,$loadRemisor);
        
        while($row=sqlsrv_fetch_array($execue)){
            $r_social= utf8_decode($row['R_SOCIAL']);
            $id_usuario=$row['ID_USUARIO'];
            $html.="<option value='$id_usuario'> $r_social</option>";
        }                
    }   
}
 echo $html;
