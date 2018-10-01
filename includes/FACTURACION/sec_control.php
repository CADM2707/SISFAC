<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();
$idOp = $_SESSION['ID_OPERADOR'];

 @$id=$_REQUEST['usuario'];
 @$usu=$_REQUEST['usu'];
  @$_REQUEST['fac'];
 if(@$_REQUEST['fac'] != ""){ @$fac=$_REQUEST['fac']; }else {@$fac=NULL;}
 if(@$_REQUEST['format'] != ""){ @$format=$_REQUEST['format']; }else {@$format='NULL';}
 if(@$_REQUEST['fac'] == 1  or @$_REQUEST['fac'] == 2){$format='NULL';}
 
 if(@$_REQUEST['per'] != ""){ @$per=$_REQUEST['per']; }else {@$per='NULL';}
 if(@$_REQUEST['tur'] != ""){ @$tur=$_REQUEST['tur']; }else {@$tur='NULL';}
 if(@$_REQUEST['jerar'] != ""){ @$jerar=$_REQUEST['jerar']; }else {@$jerar='NULL';}
 if(@$_REQUEST['adi'] != ""){ @$adi=$_REQUEST['adi']; }else {@$adi='NULL';}
 if(@$_REQUEST['banco'] != ""){ @$banco=$_REQUEST['banco']; }else {@$banco='NULL';}
 /*@$fac=$_REQUEST['fac'];
 @$format=$_REQUEST['format'];
 @$per=$_REQUEST['per'];
 @$tur=$_REQUEST['tur'];
 @$jerar=$_REQUEST['jerar'];
 @$adi=$_REQUEST['adi'];*/
 @$correo=$_REQUEST['correo'];
 @$cuenta=$_REQUEST['cuenta'];
 //@$banco=$_REQUEST['banco'];
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