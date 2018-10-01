<?php
include '../../conexiones/sqlsrv.php';
error_reporting(0);
$conn = connection_object();
 session_start();
 $idOp=$_SESSION['ID_OPERADOR'];	
 @$id=$_REQUEST['Id'];
 @$ayo=$_REQUEST['Ayo'];
 @$des=$_REQUEST['Des'];
 
				$html='';	

			 
			
		echo		$sql_agrega ="delete FROM Factura_Desglose WHERE ID_DESGLOSE=$des and ID_FACTURA=$id and AYO=$ayo";
				$res_agrega = sqlsrv_query($conn,$sql_agrega);
				if($res_agrega!=""){ 
					$html.="				
						<div  class='col-md-12 col-sm-12 col-xs-12' >
						<div class='alert alert-success' role='alert'>
							<strong>EXITO!</strong> DESGLOSE BORRADO
						</div>";
				}else{	
					$html.="
						<div class='alert alert-danger' role='alert'>
							<strong>CUIDADO!</strong>NO SE BORRO EL DESGLOSE
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
		
