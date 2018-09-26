<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 session_start();
 $idOp=$_SESSION['ID_OPERADOR'];
 @$usuario=$_REQUEST['Usuario'];
 @$servicio=$_REQUEST['Servicio'];
 @$deductiva=$_REQUEST['Deductiva'];
 @$monto=$_REQUEST['Monto'];
 @$cantidad=$_REQUEST['Cantidad'];
 @$ayo=$_REQUEST['Ayo'];
 @$tipo=$_REQUEST['Tipo'];
 @$qna=$_REQUEST['Qna'];
 $format="d/m/Y"; 
 $html = "";	
 
				if($tipo==1){
				$sql_dec_cant ="declare 
				@usuario as varchar(10)='$usuario',
				@ayo as int=$ayo,
				@qna as int=$qna,
				@servicio as int=$servicio  ,
				@dec as int ,
				@fac as int,
				@suma as int 
				select @dec=isnull(SUM(CANTIDAD),0)  from Deductivas where ID_USUARIO=@usuario and AYO=@ayo and QNA=@qna and ID_SERVICIO=@servicio
				select @fac=TN from Turnos_Facturacion where ID_USUARIO=@usuario and AYO=@ayo and QNA=@qna and ID_SERVICIO=@servicio
				select @suma=@fac-@dec
				select @suma TOTAL";
				$res_dec_cant = sqlsrv_query($conn,$sql_dec_cant);
				$row_dec_cant = sqlsrv_fetch_array($res_dec_cant);
				$dec_cant=$row_dec_cant['TOTAL']; 		
				$validacion=@$dec_cant-@$cantidad;
				$validacion;
				}
				if(@$validacion>0){				
				$sql_reporte ="exec sp_Captura_Deductiva '$usuario',$servicio,$deductiva,$cantidad,$ayo,$qna";
				$res_reporte = sqlsrv_query($conn,$sql_reporte );
				$row_reporte = sqlsrv_fetch_array($res_reporte);
				$mensaje=trim($row_reporte['MENSAJE']);
				if($mensaje="DEDUCTIVA REGISTRADA CORRECTAMENTE"){
					$html.="				
					<div  class='col-md-12 col-sm-12 col-xs-12'>&nbsp;<br></div>
					<div  class='col-md-12 col-sm-12 col-xs-12' >
						<div class='alert alert-success'>
						  <strong>$mensaje</strong> 
						</div>";
				}else{	
					$html.="
						<div class='alert alert-danger'>
							<strong>CUIDADO! NO SE GUARDO EL REGISTRO</strong>
						</div>
					</div>";
				}}else{
					$html.="<br><br><br><br><br><br><div class='alert alert-danger'>
						<strong>CUIDADO! NO PUEDES INGRESAR MAS DEDUCTIVAS</strong>
					</div>";
			 } 
					  
		echo $html;			  
		
?>		<!--<script>
			function r() { location.href="sec_deductivas.php" } 
			setTimeout ("r()", 4000);
		</script>-->