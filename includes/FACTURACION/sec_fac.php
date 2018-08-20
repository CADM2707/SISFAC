<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();
$idOp=$_SESSION['ID_OPERADOR'];

 @$Ayo=$_REQUEST['Ayo'];
 @$qna=$_REQUEST['qna'];

  //rechazar
	 $sql_up = "execute facturacion.[dbo].[sp_Inserta_Turnos_Facturacion] $Ayo, $qna";
	 $res_up = sqlsrv_query($conn,$sql_up);
	 $row_up = sqlsrv_fetch_array($res_up);
	 @$mensaje = $row_up['MENSAJE'];?><br><br><br><br><br><br><br><br><br><br>
	 <div class="row" >
	 <?php if(@$mensaje != ""){ ?>
	 
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong><?php echo $mensaje;?></strong>  
					</div>
				<?php }else{ ?><br>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>SE APERTURO LA FACTURA</strong>  
					</div>
                   
				<?php } ?>
				</div>
 

