<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();


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
 
 

					

echo  $sql_reporte ="update Parametros_Facturacion set ID_USUARIO_FACTURA =$usu, CVE_TIPO_FACTURA =$fac, PERIODO_FACTURACION =$per, JERARQUIA =$jerar, ADICIONALES =$adi, CORREO =$correo, CUENTA =$cuenta, BANCO =$banco, CVE_FORMATO = $format WHERE ID_USUARIO = $id";
$res_reporte = sqlsrv_query($conn,$sql_reporte);
							  

if($sql_reporte!=""){ ?><br>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>SE HA CANCELADO CORRECTAMENTE</strong>  
					</div>
				<?php }else{ ?><br>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>NO SE HA PODIDO CANCELAR</strong>  
					</div>
				<?php } 

?>