<?php

include_once '../../conexiones/sqlsrv.php';
$conn = connection_object();
$html="";

$id_usuario = isset($_REQUEST['ID_USUARIO']) ? $_REQUEST['ID_USUARIO']:0;
//********************* COMPLETAR PARA EL UPDATE *****************************

if($id_usuario!='' and isset($_REQUEST['displayCuentas'])=='' ){
    $search="SELECT NOMBRE,TELEFONO,EMAIL from  [Bitacora].[dbo].[Cliente_Padron] where LOGIN='$id_usuario'";
    $execue=sqlsrv_query($conn,$search);
    
    $row = sqlsrv_fetch_array($execue);
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

if(isset($_REQUEST['banco_selec'])){
   $html= "<option disabled='true' selected='true' value=''> Selecciona </option>".banco($conn,0);   
}

if(isset($_REQUEST['BANK'])){    
    
    $query2="select (select MAX(ID_REGISTRO) from  [dbo].[Metodo_Pago] where ID_USUARIO='$id_usuario') Maximo,
            ID_USUARIO,	NO_CUENTA,	CVE_METODO_PAGO,	CVE_SITUACION,	ID_BANCO 
            from [dbo].[Metodo_Pago] where ID_REGISTRO=(select MAX(ID_REGISTRO) from  [dbo].[Metodo_Pago] where ID_USUARIO='$id_usuario') AND ID_USUARIO='$id_usuario'
            ";
    
    $no_cuenta='';
    $cve_pago="";
    $sel="selected='true'";
    $sel2="selected='true'";
    $selec_banco='';
    
    $Execute2=sqlsrv_query($conn,$query2);
    if($row=sqlsrv_fetch_array($Execute2)){
        $selec_banco= isset($row['ID_BANCO'])?$row['ID_BANCO']:'';
        $no_cuenta= isset($row['NO_CUENTA'])?$row['NO_CUENTA']:'';
        $cve_pago= isset($row['CVE_METODO_PAGO'])?$row['CVE_METODO_PAGO']:'';
       
        if($selec_banco)$sel='';
        if($cve_pago)$sel2='';
    }    
    $html="
          <div class='col-lg-1 col-xs-1 text-center'></div>
          <div class='col-lg-3 col-xs-3 text-center'>
              <label><i class='fa fa-bank'></i> &nbsp;BANCO</label>
                <select required='' id='tipo_banco' name='tipo_banco' class='form form-control'>
                  <option disabled='true' selected='true'  value=''> Selecciona </option>
                  ".$banco=banco($conn,'')."
                </select>
          </div>                                        
          <div class='col-lg-3 col-xs-3 text-center'>
              <label><i class='fa fa-credit-card'></i> &nbsp; NO. CUENTA</label>
              <input required='' name='no_cuenta' id='no_cuenta' value='' type='text' class='form form-control'>
                                            </div>                                        
          <div class='col-lg-3 col-xs-3 text-center'>
              <label><i class='fa fa-file-text-o'></i> &nbsp;TIPO PAGO</label>
              <select required='' id='tipo_pago'  name='tipo_pago' class='form form-control'>
                  <option selected='true' disabled='true' value=''> Selecciona </option>
                  ".$metodoPago=MetodoPago($conn,'')."
              </select>
          </div>
          <div class='col-lg-2 col-xs-2 text-center'>
              <br>
              <button class='btn btn-primary' type='submit'><i class='fa fa-save'></i> &nbsp;AGREGAR</button>
          </div>";
    
    
}

//*************************************** TIPO PAGO **********************************************
function MetodoPago($conn,$cve_pago){

    $query="select * from [dbo].[C_Metodo_Pago]";
    $exe=sqlsrv_query($conn,$query);
    $html="";
    
    while($row=sqlsrv_fetch_array($exe)){
        
        $id=$row['CVE_METODO_PAGO'];
        $desc= utf8_encode( $row['METODO_PAGO']);
        if($cve_pago==$id){$selecciona="selected='true'";}else{$selecciona='';}
        $html.="<option $selecciona value='$id'> $desc </option>";
    }
     return $html;
}

//*********************************** Desplegar Lista de Cuentas ************************************************
if(isset($_REQUEST['displayCuentas'])){
//    $id_usuario
    $query="select * from Metodo_Pago where ID_USUARIO='$id_usuario'";
    $execute=sqlsrv_query($conn,$query);
    
    $html.="<br><table class='table table-bordered table-hover table-responsive table-striped text-center' id='tablePagos'>
                            <thead>
                                <th>#</th>
                                <th>NO. CUENTA</th>
                                <th>TIPO DE PAGO</th>                                
                                <th>CUENTA ACTIVA</th>                                
                                <th>BANCO</th>
                                <th>ACTUALIZAR</th>                                
                            </thead>
                            <tbody>";
  $counter=0; 
    
      $counter=0;
    while($row=sqlsrv_fetch_array($execute)){
        $cuenta=$row['NO_CUENTA'];
        $pago=$row['CVE_METODO_PAGO'];
        $activa=$row['CVE_SITUACION'];        
        $banco=$row['ID_BANCO'];
        $cont=$counter+1;
        $activa_si="";
        $activa_no="";
        
        if($activa==1){
            $activa="ACTIVA";                
            $activa_si="selected='true'";
        }else{
            $activa="INACTIVA";   
            $activa_no="selected='true'";
        }
        
         $html.="
                                <tr>
                                    <td>". $cont ."</td>
                                    <td>$cuenta</td>
                                    <td>
                                        <select required='' id='ud_Mp$cont' name='tipo_pago' class='form form-control'>
                                            <option disabled='true' value=''> Selecciona </option>
                                            ".$metodoPago=MetodoPago($conn,$pago)."
                                        </select>
                                    </td>
                                    <td>
                                        <select required='' id='ud_Tp$cont' name='tipo_pago' class='form form-control'>
                                            <option disabled='true' value=''> Selecciona </option>
                                            <option value='0'> ACTIVA </option>
                                            <option value='1'> INACTIVA </option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required='' id='ud_tb$cont' name='tipo_banco' class='form form-control'>
                                            <option disabled='true'  value=''> Selecciona </option>
                                            ".$banco=banco($conn,$banco)."
                                        </select></td>                                    
                                    <td>
                                        <button onclick='updateDB($cont)' type='button' class='btn btn-success' >
                                            <i class='fa fa-refresh'></i> &nbsp;ACTUALIZAR
                                        </button>
                                    </td>    
                                </tr>                                                               
                           ";
        
      $counter++;  
    }
    $html .= " </tbody>
                        </table>";
}



//********************** Funciones sql ****************************
function banco($conn,$id_banco){
    $query="select * from [dbo].[C_Banco]";
    $exe=sqlsrv_query($conn,$query);
    $html="";
    
    while($row=sqlsrv_fetch_array($exe)){        
        $id=$row['ID_BANCO'];
        if($id==$id_banco){$selecciona="selected='true'";}else{$selecciona='';}
        $bank=$row['BANCO'];        
        $html.="<option $selecciona value='$id'> $bank </option>";
    }
    return $html;
}
echo $html;
