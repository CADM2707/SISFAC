<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();
$idOp = $_SESSION['ID_OPERADOR'];

 @$id=$_REQUEST['usuario'];
 @$usu=$_REQUEST['usu'];
 @$fac=$_REQUEST['fac'];
 @$format=$_REQUEST['format'];
 @$per=$_REQUEST['per'];
 @$tur=$_REQUEST['tur'];
 @$jerar=$_REQUEST['jerar'];
 @$adi=$_REQUEST['adi'];
 @$correo=$_REQUEST['correo'];
 @$cuenta=$_REQUEST['cuenta'];
 @$banco=$_REQUEST['banco'];
@$html= "";
 $sql_reporte ="execute Facturacion.dbo.sp_guarda_Parametros '$id','$usu',$fac,$format,$per,$tur,$jerar,$adi,'$correo','$cuenta',$banco,$idOp";
 $res_reporte = sqlsrv_query($conn,$sql_reporte);



 $html .="<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
 <div class='row' >";
if(@$res_reporte != ""){
	$html.="

	<br>
					<div class='alert alert-success alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss=''alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<strong>SE ACTUALIZO CORRECTAMENTE</strong>  
					</div>
                    
                   ";
				 }else{ 
				 $html.="
				 <br>
					<div class='alert alert-danger alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<strong>ERROR NO SE ACTUALIZO EL REGISTRO</strong>  
					</div>
                   
					";
}
$html.="</div>";
echo $html;
?>