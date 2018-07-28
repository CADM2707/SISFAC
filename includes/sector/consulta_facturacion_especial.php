<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 session_start();
 $idOp=$_SESSION['ID_OPERADOR'];
 
 
 @$usuario=$_REQUEST['Usuario']; 
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
			 	$sql_reporte =" select AYO,ID_RECIBO,FECHA_EMISION,SUBTOTAL,IVA,TOTAL,TOTAL_REDONDEADO,IMPORTE_LETRA,PERIODO_LETRA,PERIODO_INICIO,PERIODO_FIN,ID_OPERADOR,TIMBRADO,FOLIO_SAT,ID_SOLICITUD,CVE_SITUACION
				from Factura where ID_USUARIO ='$usuario' and CVE_TIPO_RECIBO=29";
				$res_reporte = sqlsrv_query( $conn,$sql_reporte);
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
				$stmt = sqlsrv_query( $conn, $sql_reporte , $params, $options );

				$row_count = sqlsrv_num_rows( $stmt );
				if($row_count>0){
			
				$html .= "  
					<h3>HISTORIAL DE FACTURAS ESPECIALES</h3>				
				  <table class='table table-hover table-responsive' style='font-size:11px;'>
					<thead>
					  <tr style='background-color:#337ab7; color:white; '>
						<th><center>ID RECIBO</center></th>						
						<th><center>AÑO</center></th>
						<th><center>FECHA EMISION</center></th>						
						<th><center>SUBTOTAL</center></th>
						<th><center>IVA</center></th>
						<th><center>TOTAL</center></th>
						<th><center>TOTAL REDONDEADO</center></th>
						<th><center>IMPORTE LETRA</center></th>
						<th><center>LETRA PERIODO</center></th>
						<th><center>PERIODO INICIO</center></th>
						<th><center>PERIODO FIN</center></th>
						<th><center>OPERADOR</center></th>
						<th><center>TIMBRADO</center></th>
						<th><center>FOLIO SAT</center></th>
						<th><center>SITUACION</center></th>
					  </tr>
					</thead>
					<tbody>"; $a=1;
							while($row_reporte = sqlsrv_fetch_array(@$res_reporte)){									
								if($a%2==0){ $color="background-color:#E1EEF4";	}else{	$color="background-color:#FFFFFF";	}
								$emision=date_format($row_reporte['FECHA_EMISION'], $format); 
								$fin=date_format($row_reporte['PERIODO_FIN'], $format); 
								$inicio=date_format($row_reporte['PERIODO_INICIO'], $format); 
								$recibo=$row_reporte['ID_RECIBO'];								
								$ayo=$row_reporte['AYO'];								
								$solicitud=$row_reporte['ID_SOLICITUD'];
								$subtotal=$row_reporte['SUBTOTAL'];
								$iva=$row_reporte['IVA'];
								$total=$row_reporte['TOTAL'];
								$total_r=$row_reporte['TOTAL_REDONDEADO'];
								$importe_letra=$row_reporte['IMPORTE_LETRA'];
								$periodo_letra=$row_reporte['PERIODO_LETRA'];
								$operador=$row_reporte['ID_OPERADOR'];
								$timbrado=$row_reporte['TIMBRADO'];
								$folio_sat=$row_reporte['FOLIO_SAT'];
								$situacion=$row_reporte['CVE_SITUACION'];
						$html .="<tr style='$color'>
							<td><center> $recibo</td>
							<td><center> $ayo </td>
							<td><center> $emision</td>
							<td><center> $subtotal</td>
							<td><center> $iva</td>
							<td><center> $total</td>
							<td><center> $total_r</td>
							<td><center> $importe_letra</td>
							<td><center> $periodo_letra</td>
							<td><center> $inicio</td>
							<td><center> $fin</td>
							<td><center> $operador</td>
							<td><center> $timbrado</td>
							<td><center> $folio_sat</td>
							<td><center> $situacion</td>							
							
					  </tr>";
					     }	  
					$html.="</tbody>
				  </table>";
				  }
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