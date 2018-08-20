<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 
 @$usuario=$_REQUEST['Usuario'];
 @$ayo=$_REQUEST['Ayo'];
 @$qna=$_REQUEST['Qna'];
 @$ope=$_REQUEST['Ope'];
 @$fecha=$_REQUEST['Fecha']; 
 $format="d/m/Y"; 
 $html = "";
 	
				$sql_reporte =" select ID_SOLICITUD,ID_USUARIO,ID_SERVICIO,AYO,QNA,TURNOS,ID_OPERADOR,FECHA from Ajuste_Turnos_Contrato where ID_SOLICITUD IS NOT NULL ";
				if($usuario!=""){ $sql_reporte=$sql_reporte." and ID_USUARIO='$usuario' ";  }
				if($ayo!=""){ $sql_reporte=$sql_reporte." and AYO='$ayo' ";  }
				if($qna!=""){ $sql_reporte=$sql_reporte." and QNA='$qna' ";  }
				if($ope!=""){ $sql_reporte=$sql_reporte." and ID_OPERADOR='$ope' ";  }
				if($fecha!=""){ $sql_reporte=$sql_reporte." and FECHA='$fecha' ";  }
				$res_reporte = sqlsrv_query( $conn,$sql_reporte);
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
				$stmt = sqlsrv_query( $conn, $sql_reporte , $params, $options );

				$row_count = sqlsrv_num_rows( $stmt );
				if($row_count>0){
			
				$html = "  
				<div  class='col-md-12 col-sm-12 col-xs-12'><center><a href='reportes/rep_ajuste_datos.php?usuario=$usuario&ayo=$ayo&qna=$qna&ope=$ope&fecha=$fecha'  class='btn btn-warning btn-sm' >Reporte</a></div>				
				<br><br> 
				 <table class='table table-hover table-responsive' style='font-size:11px;'>
					<thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>ID</center></th>						
						<th><center>AÑO</center></th>
						<th><center>QNA.</center></th>						
						<th><center>ID USUARIO</center></th>
						<th><center>ID SERVICIO</center></th>
						<th><center>TURNOS</center></th>
						<th><center>ID OPERADOR</center></th>
						<th><center>FECHA</center></th>
					  </tr>
					</thead>
					<tbody>"; $a=1;
							while($row_reporte = sqlsrv_fetch_array(@$res_reporte)){									
								$fecha1=date_format($row_reporte['FECHA'], $format); 
								if($a%2==0){ $color="background-color:#E1EEF4";	}else{	$color="background-color:#FFFFFF";	}
								$ayo=$row_reporte['AYO'];
								$qna=$row_reporte['QNA'];
								$id=$row_reporte['ID_SOLICITUD'];
								$usu=$row_reporte['ID_USUARIO'];
								$turnos=$row_reporte['TURNOS'];
								$ope=$row_reporte['ID_OPERADOR'];
								$servicio=$row_reporte['ID_SERVICIO'];
						$html .="<tr style='$color'>
							<td><center> $id</td>
							<td><center> $ayo </td>
							<td><center> $qna</td>
							<td><center> $usu</td>
							<td><center> $servicio</td>
							<td><center> $turnos</td>							
							<td><center> $ope</td>
							<td><center> $fecha1 </td>
					  </tr>";
					     }	  
					$html.="</tbody>
				  </table>";
					}else{
					$html .="<H2 class='bg-danger text-white'>NO EXISTEN REGISTROS	</H2>";
					}
					  
		echo $html;			  

?>