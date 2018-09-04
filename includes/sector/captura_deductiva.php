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
 @$qna=$_REQUEST['Qna'];
 $format="d/m/Y"; 
 $html = "";	
 
 
				$sql_dec_cant ="select  TN-T1.DEDUCTIVAS as TOTAL  from Turnos_Facturacion TF
								INNER JOIN 
								(select SUM(CANTIDAD) DEDUCTIVAS,ID_USUARIO,AYO,QNA ,ID_SERVICIO from Deductivas where ID_USUARIO='$usuario' and AYO=$ayo and QNA=$qna and ID_SERVICIO=$servicio GROUP BY AYO,QNA ,ID_SERVICIO,ID_USUARIO ) T1 ON TF.ID_USUARIO=T1.ID_USUARIO AND TF.ID_SERVICIO=T1.ID_SERVICIO AND TF.AYO=T1.AYO AND  TF.QNA=T1.QNA
								where TF.ID_USUARIO='$usuario' and TF.AYO=$ayo and TF.QNA=$qna and TF.ID_SERVICIO=$servicio";
				$res_dec_cant = sqlsrv_query($conn,$sql_dec_cant);
				$row_dec_cant = sqlsrv_fetch_array($res_dec_cant);
				$dec_cant=$row_dec_cant['TOTAL']; 		
				$validacion=@$dec_cant-@$cantidad;
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