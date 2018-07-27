<?php
include_once '../../conexiones/sqlsrv.php';
$conn = connection_object();
$html="";

session_start();

//******************************* CAMBIO CONTRASEÑA ********************************************
if(isset($_REQUEST['actual']) and isset($_REQUEST['nueva']) and isset($_REQUEST['confirma'])){        
    
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
if(isset($_REQUEST['encargado']) and isset($_REQUEST['telefono']) and isset($_REQUEST['email']) ){
    
    $usr=$_REQUEST['id_usu2']? $_REQUEST['id_usu2'] : NULL ;
    
    $nombre=$_REQUEST['encargado'];
    $tel=$_REQUEST['telefono'];
    $email=$_REQUEST['email'];;
    
    $query="UPDATE  [Bitacora].[dbo].[Cliente_Padron] set NOMBRE='JUAN PEREZ', TELEFONO='55548654', EMAIL='juan_perez@gmail.com' where LOGIN='$usr'";
    
    if(execute($query,$conn)){
        echo 1;
    }else{
        echo 2;
    }
}

//******************************* DATOS BANCARIOS ********************************************

function execute($query,$conn){
    return $execue=sqlsrv_query($conn,$query);    
}