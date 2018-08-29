<?php

include '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();
$sec=$_REQUEST['Sec'];
$html="";
		 
        echo  $loadRemisor="select ID_USUARIO,R_SOCIAL from V_usuario_padron where Sector=$sec AND CVE_TIPO_USUARIO IN (1,4) ORDER BY CVE_SITUACION ASC, ID_USUARIO ASC
           ";

			$execue=sqlsrv_query($conn,$loadRemisor);
       $html.="<option value=''> SELECCIONAR</option>";
        while($row=sqlsrv_fetch_array($execue)){
            $r_social= utf8_encode($row['R_SOCIAL']);
            $id_usuario=$row['ID_USUARIO'];
            $html.="<option value='$id_usuario'> $id_usuario - $r_social </option>";
        }
        


 echo $html;
