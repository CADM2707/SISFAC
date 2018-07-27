<?php

include_once '../../conexiones/sqlsrv.php';
$conn = connection_object();
$html="";

$id_usuario = isset($_REQUEST['ID_USUARIO']) ? $_REQUEST['ID_USUARIO']:0;
//********************* COMPLETAR PARA EL UPDATE *****************************

if($id_usuario){
    $search="SELECT NOMBRE,TELEFONO,EMAIL from  [Bitacora].[dbo].[Cliente_Padron] where LOGIN='$id_usuario'";
    $execue=sqlsrv_query($conn,$search);
    
    if ($row = sqlsrv_fetch_array($execue)) {
        $nombre=$row['NOMBRE'];
        $tel=$row['TELEFONO'];        
        $email=$row['EMAIL'];        
        
        $html="
                        <div class='col-lg-3 col-xs-3 text-center'>
                            <label><i class='fa fa-user'></i> &nbsp;NOMBRE ENCARGADO</label>
                            <input value='$nombre' required='' name='encargado'  type='text' class='form form-control'>
                        </div>                                        
                        <div class='col-lg-3 col-xs-3 text-center'>
                            <label><i class='fa fa-phone'></i> &nbsp;TELEFONO</label>
                            <input value='$tel' required='' maxlength='8' minlength='8' name='telefono' type='tel' class='form form-control'>
                        </div>                                        
                        <div class='col-lg-3 col-xs-3 text-center'>
                            <label><i class='fa fa-envelope'></i> &nbsp;E-mail</label>
                            <input value='$email' required='' name='email' type='email' class='form form-control'>
                        </div>
                   ";
    }
}

if(isset($_REQUEST['BANK'])){

    $query="select * from [dbo].[C_Banco]";
    $exe=sqlsrv_query($conn,$query);
    $html="<option disabled='true' selected='true' value=''> Selecciona </option>";
    
    while($row=sqlsrv_fetch_array($exe)){
        
        $id=$row['ID_BANCO'];
        $bank=$row['BANCO'];
        
        $html.="<option value='$id'> $bank </option>";
    }
}

//*************************************** TIPO PAGO **********************************************
if(isset($_REQUEST['PAGO'])){

    $query="select * from [dbo].[C_Pago_Tipo] where cve_pago_tipo NOT IN (2,3)";
    $exe=sqlsrv_query($conn,$query);
    $html="<option disabled='true' selected='true' value=''> Selecciona </option>";
    
    while($row=sqlsrv_fetch_array($exe)){
        
        $id=$row['CVE_PAGO_TIPO'];
        $desc= utf8_encode( $row['DESCRIPCION']);
        
        $html.="<option value='$id'> $desc </option>";
    }
}
echo $html;
