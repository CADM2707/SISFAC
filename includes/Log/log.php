<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();      
$format="d/m/Y";
$formatTIme="H:i:s";
$html="";
session_start();

$usr=$_REQUEST['usrcompstat']? $_REQUEST['usrcompstat'] : NULL ;
$pwd=$_REQUEST['passwordcompstat']? $_REQUEST['passwordcompstat']:NULL ;

$searchlog="SELECT OP.ID_OPERADOR, LOGIN, CLAVE, APELLIDOP,APELLIDOM,NOMBRE, PA.SECTOR, PA.DEST, PP.CVE_PERFIL, PP.ID_PROGRAMA,PERFIL FROM [Bitacora].[dbo].[Operador_Padron] OP
    INNER JOIN [Bitacora].[dbo].[Programa_Perfil] PP ON OP.ID_OPERADOR=PP.ID_OPERADOR
    INNER JOIN  [Bitacora].[dbo].[Programa_C_Perfil] PCP ON PP.ID_PROGRAMA=PCP.ID_PROGRAMA AND PP.CVE_PERFIL=PCP.CVE_PERFIL
    INNER JOIN Sector.DBO.Persona_Padron PERP ON PP.ID_OPERADOR=PERP.ID_ELEMENTO AND OP.ID_OPERADOR=PERP.ID_ELEMENTO
    INNER JOIN Sector.DBO.Persona_Adscripcion PA ON PP.ID_OPERADOR=PA.ID_ELEMENTO AND OP.ID_OPERADOR=PA.ID_ELEMENTO AND PERP.ID_ELEMENTO=PA.ID_ELEMENTO
    WHERE PERP.CVE_SITUACION+CVE_SITUACION_NOMINA=0  AND PP.ID_PROGRAMA IN (41,72,89) AND LOGIN='$usr' AND CLAVE='$pwd'";
$execue=sqlsrv_query($conn,$searchlog);

$row=sqlsrv_fetch_array($execue);

if ($row['LOGIN']!=null) {
    $html=1;
    $_SESSION['NOMBRE']=$row['NOMBRE'];
    $_SESSION['APELLIDOP']=$row['APELLIDOP'];
    $_SESSION['APELLIDOM']=$row['APELLIDOM'];
    $_SESSION['CVE_PERFIL']=$row['CVE_PERFIL'];
//    $_SESSION['perfil']=$row['Acceso'];
}else{
    $html=0;
}
echo $html;

?>