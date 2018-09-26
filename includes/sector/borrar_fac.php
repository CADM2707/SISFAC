<?php
include '../../conexiones/sqlsrv.php';
error_reporting(0);
$conn = connection_object();
 session_start();
 $idOp=$_SESSION['ID_OPERADOR'];	
 @$id=$_REQUEST['Id'];
 @$ayo=$_REQUEST['Ayo'];
 @$qna=$_REQUEST['Qna'];
 
				$html='';	

			 
			
				/*$sql_agrega ="exec facturacion.[dbo].[sp_Guarda_Factura_Especial] $var_folio ";
				$res_agrega = sqlsrv_query($conn,$sql_agrega);
				$row_agrega = sqlsrv_fetch_array($res_agrega);
				$valor=trim($row_agrega['VALOR']); 
				$mensaje=trim($row_agrega['mensaje']); 
				*/
				$valor=1;
				if($valor==1){ 
					$html.="				
						<div  class='col-md-12 col-sm-12 col-xs-12' >
						<div class='alert alert-success' role='alert'>
							<strong>EXITO!</strong> $mensaje
						</div>";
				}else{	
					$html.="
						<div class='alert alert-danger' role='alert'>
							<strong>CUIDADO!</strong>NO SE GUARDO
						</div>
						";
				}

				
 
		echo $html;			  
		
?>
<script src="../dist/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() { setTimeout(function() { $(".alert-success").fadeOut(3000);	},4000);	});
			$(document).ready(function() { setTimeout(function() { $(".alert-danger").fadeOut(3000);	},4000);    });
		</script>
		
