<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
$format="Y/m/d";


 @$ayo=$_REQUEST['Ayo'];
 @$fac=$_REQUEST['Fac'];
 @$usuario=$_REQUEST['usuario'];
 
 if(@$_REQUEST['Ayo'] != ""){ $sql_ayo = " AND ayo = $ayo ";} else {$sql_ayo = "";}
 if(@$_REQUEST['Fac'] != ""){ $sql_fac = " AND ID_FACTURA = $fac ";} else {$sql_fac = "";}
 if(@$_REQUEST['usuario'] != ""){ $sql_usu = "and ID_USUARIO='$usuario'";} else {$sql_usu = "";}
 
 
 $html = "";
 @$idOp=$_REQUEST['ID_OPERADOR'];
 // Consulta de la tabla
 
 // codigo html
$html.="<br>
<table class='table table-hover table-responsive' style='font-size:15px;'>
					
					<thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>FACTURA</center></th>
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
						<th><center>MOTIVO CANCELACION</center></th>			
						<th><center>FECHA CANCELACION</center></th>			
						<th><center>CANCELAR</center></th>			
					  </tr>
					</thead>
					
					<tbody>"; 
					
					$sql_reporte ="select AYO,ID_FACTURA,SITUACION,PERIODO_INICIO,PERIODO_FIN,ID_USUARIO,R_SOCIAL,IMPORTE,PAGO,OBSERVACION,SALDO, MOTIVO, FECHA_SISTEMA from V_FACTURAS 
								   where ID_USUARIO IS NOT NULL $sql_ayo $sql_fac $sql_usu order by  ID_USUARIO asc";
				$res_reporte = sqlsrv_query($conn,$sql_reporte);
				$x=1;
				while($row_reporte = sqlsrv_fetch_array($res_reporte, SQLSRV_FETCH_ASSOC)){	
								
								$id = $row_reporte['ID_FACTURA'];
								$a = $row_reporte['AYO'];
								$usu = $row_reporte['ID_USUARIO'];
								$rsoc = $row_reporte['R_SOCIAL'];
								$sit = $row_reporte['SITUACION'];
								$imp = $row_reporte['IMPORTE'];
								$pago = $row_reporte['PAGO'];
								$obs = $row_reporte['OBSERVACION'];
								$saldo = $row_reporte['SALDO'];
								$motivo = $row_reporte['MOTIVO'];
								if(@$row_reporte['FECHA_SISTEMA'] != ""){$fech_cancel = date_format($row_reporte['FECHA_SISTEMA'], $format);} else {$fech_cancel="";} 
								if(@$row_reporte['PERIODO_INICIO'] != ""){$per1 = date_format($row_reporte['PERIODO_INICIO'], $format);} else {$per1="";} 
								if(@$row_reporte['PERIODO_FIN'] != ""){$per2 = date_format($row_reporte['PERIODO_FIN'], $format);} else {$per2="";} 
								
								
								
					//if($x%2==0){ $color="background-color:#E1EEF4";	}else{	$color="background-color:#FFFFFF";	}
					if($sit=="CANCELADA"){ $color = "background-color:#ffeeba"; }else if($x%2==0){ $color="background-color:#E1EEF4";	}else{	$color="background-color:#FFFFFF";	}
					$html.="<tr style='$color' >
							
                            <td><center> $id </td>
							<td><center> $a </td>
                            <td><center> $usu </td>
                            <td><center>  ".utf8_encode($rsoc)." </td>
							<td><center> $sit </td>
							<td><center> $per1 </td>
							<td><center> $per2 </td>
							<td><center> $imp </td>
							<td><center> $pago </td>
							<td><center> $obs </td>
                            <td><center> $saldo </td>
                            <td><center> $motivo </td>
                            <td><center> $fech_cancel </td>";
							if($sit=="CANCELADA"){
							$html.="	
							<td><center><img src='../dist/img/cancel.png' height='20'></center></td>";
							} else {
								
								$html.="
								<td><center><button type='button' onclick='cancela_facturacion($id,$a)' class='btn btn-danger btn-sm' data-toggle='modal' >CANCELAR</button></center></td>";
								//<td><center><button type='button' onclick='cancela_factura()' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#myModalCharts'>CANCELAR</button></center></td>";
							
							}
							$x++;
							}	  	
					 	
					$html.="</tbody>
				  </table>";	
				
					  
		echo $html;			  

?>

 <div>
                    <div class='modal' id='myModalCharts' role='ialog'>
                        <div class='modal-dialog mymodal modal-lg' style=' width: 55% !important'>         
                            <!-- Modal content-->
                            <div class='modal-content'>
                                <div class='modal-header title_left' style=' background-color: #2C3E50;'>
                                    <button type='button' class='close' data-dismiss='modal' style=' background-color: white;'>&nbsp&nbsp;&times;&nbsp&nbsp;</button>
                                    <h4 class='modal-title' style=' color: white;'><img width='2%'  src='../dist/img/pa2.png'><center></center></h4>
                                </div>
                                <div style='text-align: center'><br>
                                    <h4 style=' color: #1B4C7C; font-weight: 600'>CANCELACION DE FACTURA.</h4><hr>
                                </div>  
                                <div class='col-md-12'>
                                    <div class='text-center'><h4>¿Estas seguro de CANCELAR esta factura <span id='span_id'></span>?</h4></div>
                                </div>
								<div class='col-md-12'>
									<div class="col-md-2"></div>
									<div class="col-md-4">
										<label>Factura</label>
										<input type='text' class="form-control" id='id_facf' readonly>
									</div>
									<div class="col-md-4">
										<label>Ayo</label>
										<input type='text' class="form-control" id='ayo_fac' readonly>
									</div>
									<div class='col-md-2'>&nbsp;</div>
								</div>
								<div class='col-md-12'><br></div>
								<div class='col-md-12'>
									<div class='col-md-2'>&nbsp;</div>
									
									<div class='col-md-8'>
										<label>Motivo de la cancelaci&oacute;n</label>
										<textarea name='observacion' id='observacion' class='form-control' required></textarea>
									</div>
									
									<div class='col-md-2'>&nbsp;</div>
									<br><br><br><br>
								</div>
                                <div class='modal-footer'>  <br>
								<div class='col-md-12'>
								<br>
								<center><button name='btn'  value='cancelar' onclick='cancel()' type='button' class='btn btn-success' >CANCELAR</button>
		                        <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button></center>
							   </div>
                                </div>
								
                            </div>      
                        </div>
                    </div>
					
                </div>          
    
    