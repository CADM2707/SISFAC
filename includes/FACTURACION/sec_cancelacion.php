<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
$format="d/m/Y";


 @$ayo=$_REQUEST['Ayo'];
 @$fac=$_REQUEST['Fac'];
 
 $html = "";
 
 // Consulta de la tabla
 
 // codigo html
$html.="<br>
<table class='table table-hover table-responsive' style='font-size:15px;'>
					<thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>ID RECIBO</center></th>
						<th><center>AÑO</center></th>
						<th><center>ID USUARIO</center></th>
						<th><center>RAZON SOCIAL</center></th>			
						<th><center>SITUACION</center></th>			
						<th><center>PERIODO INICIO</center></th>			
						<th><center>PERIODO FIN</center></th>			
						<th><center>IMPORTE</center></th>			
						<th><center>PAGO</center></th>									
						<th><center>OBSERVACION</center></th>			
						<th><center>SALDO</center></th>			
						<th><center>CANCELAR</center></th>			
					  </tr>
					</thead>
					<tbody>"; 
					
					$sql_reporte ="select AYO,ID_RECIBO,SITUACION,PERIODO_INICIO,PERIODO_FIN,ID_USUARIO,R_SOCIAL,IMPORTE,PAGO,OBSERVACION,SALDO from V_FACTURAS where ayo= $ayo and ID_RECIBO = $fac";
				$res_reporte = sqlsrv_query($conn,$sql_reporte);
				
				while($row_reporte = sqlsrv_fetch_array($res_reporte, SQLSRV_FETCH_ASSOC)){	
								
								$id = $row_reporte['ID_RECIBO'];
								$a = $row_reporte['AYO'];
								$usu = $row_reporte['ID_USUARIO'];
								$rsoc = $row_reporte['R_SOCIAL'];
								$sit = $row_reporte['SITUACION'];
								$imp = $row_reporte['IMPORTE'];
								$pago = $row_reporte['PAGO'];
								$obs = $row_reporte['OBSERVACION'];
								$saldo = $row_reporte['SALDO'];
								$per1 = date_format($row_reporte['PERIODO_INICIO'], $format);
								$per2 = date_format($row_reporte['PERIODO_FIN'], $format);
								
								
					if($a%2==0){ $color="background-color:#E1EEF4";	}else{	$color="background-color:#FFFFFF";	}
					
					$html.="<tr style='$color'>
							
                            <td><center> $id </td>
							<td><center> $a </td>
                            <td><center> $usu </td>
                            <td><center>  $rsoc </td>
							<td><center> $sit </td>
							<td><center> $per1 </td>
							<td><center> $per2 </td>
							<td><center> $imp </td>
							<td><center> $pago </td>
							<td><center> $obs </td>
                            <td><center> $saldo </td>
							<td><center><button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal'>CANCELAR</button></center></td>";
								}	  	
					 	
					$html.="</tbody>
				  </table>";	
				
					  
		echo $html;			  

?>