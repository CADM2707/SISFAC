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
    $usuarios=$_REQUEST['id_usu1'];
    
    if($actual==$nueva and $actual==$confirma){
        $html="3";
    }else 
        if($nueva!=$confirma){
        $html="2";
    }else if($nueva==$confirma){
        $id_usu=$_SESSION['USR'];
        $log="EXECUTE [Bitacora].[dbo].[SP_Cliente] '$usuarios','$actual'";
        $execute=sqlsrv_query($conn,$log);
        $row= sqlsrv_fetch_array($execute);        
        if($row['ID_OPERADOR']!=''){
            $query="execute [Bitacora].[dbo].[sp_Cliente_CambiaClave] '$id_usu','$nueva' ";
            if(sqlsrv_query($conn,$query)){
                echo 1;
            }else{
                echo 2;
            }            
        }else{
            echo 4;
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
    
    $query="UPDATE  [Bitacora].[dbo].[Cliente_Padron] set NOMBRE='$nombre', TELEFONO='$tel', EMAIL='$email' where LOGIN='$usr'";
    
    if(execute($query,$conn)){
        echo 1;
    }else{
        echo 2;
    }
}

//******************************* DATOS BANCARIOS ********************************************
//insert into [dbo].[Metodo_Pago] values ((select MAX(ID_REGISTRO)+1 from [dbo].[Metodo_Pago] where ID_USUARIO='29471-01'),'29471-01','233/6135138',3,1,9)
// 
if(isset($_REQUEST['tipo_banco']) and isset($_REQUEST['no_cuenta']) and isset($_REQUEST['tipo_pago'])){
    $id_banco=$_REQUEST['tipo_banco'];
    $no_cuenta=$_REQUEST['no_cuenta'];
    $tipo_pago=$_REQUEST['tipo_pago'];
    $usr=$_REQUEST['id_usu3']? $_REQUEST['id_usu3'] : NULL ;
    
    $queryVerifica="select ";
    
    $query="insert into [dbo].[Metodo_Pago] values ((select isNull (MAX(ID_REGISTRO)+1,1) from [dbo].[Metodo_Pago] where ID_USUARIO='$usr'),'$usr','$no_cuenta',$tipo_pago,1,$id_banco)";
     
    if(execute($query,$conn)){
        echo 1;
    }else{
        echo 2;
    }
}

function execute($query,$conn){
    return $execue=sqlsrv_query($conn,$query);    
}