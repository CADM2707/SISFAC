<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();      
$format="d/m/Y";
$formatTIme="H:i:s";
$html="";
session_start();

$usr=$_REQUEST['usrcompstat']? $_REQUEST['usrcompstat'] : NULL ;
$pwd=$_REQUEST['passwordcompstat']? $_REQUEST['passwordcompstat']:NULL ;

if(is_numeric(substr($usr, 1))){
    $query="[Bitacora].[dbo].[SP_Cliente] '$usr','$pwd'";
    $exec=sqlsrv_query($conn,$query);    
    if(count($row=sqlsrv_fetch_array($exec)) ){
        
        $_SESSION['NOMBRE']=$row['ID_USUARIO'];
        $_SESSION['USR']=$row['ID_OPERADOR'];
        $_SESSION['PLACA']='NA';
        $_SESSION['SECTOR']='NA';
        $_SESSION['DEST']='NA';
        $_SESSION['ID_OPERADOR']='007';
        $_SESSION['MENU']='select * from [Facturacion].[dbo].[PRGMODULO] where ID_PROGRAMA=72 and ID_PERFIL=2 order by CARPETA,MODULO asc';
        $html = 1;
    }else{
        $html = 0;
    }
}else{
 $searchlog="EXECUTE BITACORA.DBO.SP_Acceso '$usr','$pwd'";
$execue=sqlsrv_query($conn,$searchlog);

$row=sqlsrv_fetch_array($execue);

if (isset($row['PLACA'])) {
    $html=1;
    $_SESSION['NOMBRE']=$row['NOMBRE'];
    $_SESSION['PLACA']=$row['PLACA'];
    $_SESSION['SECTOR']=$row['SECTOR'];
    $_SESSION['DEST']=$row['DEST'];
    $_SESSION['ID_OPERADOR']=$row['ID_OPERADOR'];
    $_SESSION['MENU']="select T2.ID_PROGRAMA,CVE_PERFIL,CVE_GRUPO,MODULO,ARCHIVO,ICONO,CARPETA 
                                    FROM BITACORA.DBO.Operador_Padron  T1 
                                    INNER JOIN BITACORA.DBO.Programa_Perfil T2 ON T1.ID_OPERADOR=T2.ID_OPERADOR 
                                    INNER JOIN BITACORA.DBO.Operador_Grupo T3 ON T1.ID_OPERADOR=T3.ID_OPERADOR AND T2.ID_PROGRAMA=T3.ID_PROGRAMA
                                    INNER JOIN   [Facturacion].[dbo].[PRGMODULO] T4 ON T2.ID_PROGRAMA=T4.ID_PROGRAMA AND T2.CVE_PERFIL=T4.ID_PERFIL
                                     WHERE T1.ID_OPERADOR=".$_SESSION['ID_OPERADOR']." order by CARPETA";
}else{
    $html=0;
}
}
echo $html;

?>
