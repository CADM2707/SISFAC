<?php
include_once '../../conexiones/sqlsrv.php';
$conn = connection_object();
$html="";

//******************************* CAMBIO CONTRASEÑA ********************************************
if(isset($_REQUEST['actual']) and isset($_REQUEST['nueva']) and isset($_REQUEST['confirma'])){
    
    session_start();
    $usr=$_REQUEST['usrcompstat']? $_REQUEST['usrcompstat'] : NULL ;
    
    $actual=$_REQUEST['actual'];
    $nueva=$_REQUEST['nueva'];
    $confirma=$_REQUEST['confirma'];
    $id_usu=$_REQUEST['id_usu1'];
    
    if($actual==$nueva and $actual==$confirma){
        $html="3";
    }else 
        if($nueva!=$confirma){
        $html="2";
    }else if($nueva==$confirma){
        
        $log="EXECUTE BITACORA.DBO.SP_Acceso '$usr','$actual'";
        
        if(execute($log)){
        echo $query="execute [sp_Cliente_CambiaClave] '$id_usu','$nueva' ";
        }else{
            
        }
    }
echo $html;    
}

//******************************* DATOS CONTACTO ********************************************


//******************************* DATOS BANCARIOS ********************************************

function execute($query){
    return $execue=sqlsrv_query($conn,$query);
    
}