<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 session_start();
 $idOp=$_SESSION['ID_OPERADOR'];
 
 
 @$usuario=$_REQUEST['Usuario']; 
 @$ayo=$_REQUEST['Ayo']; 
 @$qna=$_REQUEST['Qna']; 
 $format="d/m/Y"; 
 $html = "";
				$sql_agrega ="EXEC  [dbo].[sp_Consulta_Usuario] '$usuario'";
				$res_agrega = sqlsrv_query($conn,$sql_agrega);
				$row_agrega = sqlsrv_fetch_array($res_agrega);
				$id=$row_agrega['ID_USUARIO']; 
				$sector=$row_agrega['SECTOR']; 
				$destacamento=$row_agrega['DESTACAMENTO']; 
				$rfc=$row_agrega['RFC']; 
				$social=$row_agrega['R_SOCIAL']; 
				$domicilio=$row_agrega['DOMICILIO']; 
				$colonia=$row_agrega['COLONIA']; 
				$entidad=$row_agrega['ENTIDAD']; 
				$localidad=$row_agrega['LOCALIDAD']; 
				$cp=$row_agrega['CP']; 
				$html .="
				<div  class='col-md-12 col-sm-12 col-xs-12'><br></div>
				<h3>DATOS DEL USUARIO</h3>
				<table class='table table-hover table-responsive' style='font-size:11px;'>
					<thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>ID USUARIO</center></th>						
						<th><center>RAZON SOCIAL</center></th>
						<th><center>RFC</center></th>						
						<th><center>SECTOR</center></th>
						<th><center>DEST.</center></th>
					  </tr>
					  </thead>
						<tr>
						<td><center> $id</td>
						<td><center> $social </td>
						<td><center> $rfc</td>
						<td><center> $sector</td>
						<td><center> $destacamento</td>
					  </tr>
					  <thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>DOMICILIO</center></th>						
						<th><center>COLONIA</center></th>
						<th><center>ENTIDAD</center></th>						
						<th><center>LOCALIDAD</center></th>
						<th><center>C.P.</center></th>
					  </tr>
					  </thead>
						<tr>
						<td><center> ".utf8_encode($domicilio)."</td>
						<td><center> $colonia </td>
						<td><center> $entidad</td>
						<td><center> ".utf8_encode($localidad)."</td>
						<td><center> $cp</td>
					  </tr>
					</table>  ";
			 	$sql_reporte ="exec sp_Consulta_Factura_Especial '$usuario',$ayo,$qna";
				$res_reporte = sqlsrv_query( $conn,$sql_reporte);
				/*$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
				$stmt = sqlsrv_query( $conn, $sql_reporte , $params, $options );

				$row_count = sqlsrv_num_rows( $stmt );*/
				//if($row_count>0){
			
				$html .= "  
					<h3>DESGLOSE DE FACTURAS</h3>				
				  <table class='table table-hover table-responsive' style='font-size:11px;'>
					<thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>SUBTOTAL</center></th>						
						<th><center>IVA</center></th>
						<th><center>TOTAL</center></th>						
						<th><center>LEYENDA</center></th>
						
					  </tr>
					</thead>
					<tbody>"; $a=1;
							while($row_reporte = sqlsrv_fetch_array(@$res_reporte)){									
								if($a%2==0){ $color="background-color:#E1EEF4";	}else{	$color="background-color:#FFFFFF";	}
								$subtotal=$row_reporte['SUBTOTAL'];								
								$iva=$row_reporte['IVA'];								
								$total=@$row_reporte['TOTAL'];
								$leyenda=$row_reporte['LEYENDA'];								
						$html .="<tr style='$color'>
							<td><center> $subtotal</td>
							<td><center> $iva </td>
							<td><center> $total</td>
							<td><center> $leyenda</td>							
					  </tr>";
					     }	  
					$html.="</tbody>
				  </table>";
				  //}
				
				
			/*	 $html.="<div  class='col-md-2 col-sm-2 col-xs-2'>
							<center><label>TURNOS:</label></center>
							<input type='text' name='turnos' id='turnos' onchange='Operacion2()'  style='text-align:center;'  class='form-control'  >
						</div>
						<div  class='col-md-2 col-sm-2 col-xs-2'>
							<center><label>TARIFA:</label></center>
							<input type='text' name='tarifa' id='tarifa' onchange='Operacion()'  style='text-align:center;'  class='form-control'  >
						</div>
						<div  class='col-md-2 col-sm-2 col-xs-2'>
							<center><label>IMPORTE:</label></center>
							<input type='text' name='importe' id='importe'   style='text-align:center;'  class='form-control' readonly  >
						</div>
						<div  class='col-md-6 col-sm-6 col-xs-6'>	
							<center><label>LEYENDA:</label></center>
							<input type='text' name='leyenda' id='leyenda'  style='text-align:center;'  class='form-control' >
						</div>
						<div  class='col-md-12 col-sm-12 col-xs-12'><br>
							<button  type='button' onclick='Reporte()' class='btn btn-primary center-block'>GUARDAR FACTURA ESPECIAL</button>
						</div>";*/
						
						
					$html.="<div class='row'>
							<label><center>CAPTURA DE DESGLOSE</center> </label>
							
							</div>
							<div class='row'>
								
								<div class='col-md-2'><label>TURNOS:</label></div>
								<div class='col-md-2'><label>TARIFA</label></div>
								<div class='col-md-2'><label>IMPORTE</label></div>
								<div class='col-md-4'><label>LEYENDA</label></div>
								<div class='col-md-2'><input type='button' class='btn btn-success' id='add_cancion()' onClick='addCancion()' value='+' /></div>
							</div>
							
							<div class='row' id='canciones'>
							</div>
							<div  class='col-md-12 col-sm-12 col-xs-12' id='boton' style='display: none;'><br>
							<button  type='button' onclick='Reporte()' class='btn btn-primary center-block'>GUARDAR FACTURA ESPECIAL</button>
						</div>
							";
							
echo $html;
?>
<script src="../dist/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() { 
    setTimeout(function() {
        $(".alert-success").fadeOut(3000);
    },4000);
});
$(document).ready(function() {
    setTimeout(function() {
        $(".alert-danger").fadeOut(3000);
    },4000);
});
</script>