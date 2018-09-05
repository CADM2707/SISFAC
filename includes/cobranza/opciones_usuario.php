<?php

include '../../conexiones/sqlsrv.php';
$conn = connection_object();
session_start();
$reg = $_REQUEST['reg'];
$pagos = $_REQUEST['pagos'];
$ayo = $_REQUEST['ayo'];
$usu = $_REQUEST['usu'];
$aplicado = $_REQUEST['aplicado'];
$por_aplicar = $_REQUEST['por_aplicar'];
$pagado = $_REQUEST['pagado'];



$html=""; 

$html.="<div style='text-align: center'><br>
            <h4 style=' color: #1B4C7C; font-weight: 600'>Facturas de usuario $usu.</h4><hr>
        </div> ";

@$sqlselect_fac = "
SELECT psd.ID_REGISTRO,	psd.AYO,psd.ID_FACTURA,	psd.MONTO FROM [Facturacion].[dbo].[Pago] PG
left outer join [Facturacion].[dbo].[Pago_Solicitud] PS on PS.MONTO = PG.MONTO AND PS.REFERENCIA = PG.REFERENCIA AND Cast(PS.FECHA_PAGO As Date) = Cast(PG.FECHA_PAGO As Date)
inner join facturacion.dbo.Pago_Solicitud_Detalle psd on ps.ID_REGISTRO=psd.ID_REGISTRO
--left outer join Pago_Factura pf on psd.ID_FACTURA=pf.ID_FACTURA and psd.AYO=pf.AYO
where psd.ID_REGISTRO=$reg --and pf.CVE_PAGO_SIT is null";

@$params = array();
@$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
@$ressqlselect_fac = sqlsrv_query( $conn, $sqlselect_fac , $params, $options );
@$row_count = sqlsrv_num_rows( $ressqlselect_fac );


if(@$row_count >0){

$html.="<div class='col-md-12'>
		<div class='col-md-12'>&nbsp;</div>
		<div class='col-md-4'>
			<label>Monto</label>
			<input type='text' name='monto' class='form-control' readonly value='$".number_format($pagado,2)."'>
		</div>
		<div class='col-md-4'>
			<label>Aplicado</label>
			<input type='text' name='aplicado' class='form-control' readonly value='$".number_format($aplicado,2)."'>
		</div>
		<div class='col-md-4'>
			<label>Por aplicar</label>
			<input type='text' name='por_aplicar' class='form-control' readonly value='$".number_format($por_aplicar,2)."'>
		</div>
		<div class='col-md-12'>&nbsp;</div><div class='col-md-12'>&nbsp;</div>
		<form id='form_facturas'>
			<table class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:12px;'>
				<thead>
					<tr>
						<td align='center' class='bg-primary'><b>#</b></td>
						<td align='center' class='bg-primary'><b>AYO</b></td>
						<td align='center' class='bg-primary'><b>ID FACTURA</b></td>
						<td align='center' class='bg-primary'><b>MONTO</b></td>
					</tr>
				</thead>
			    <tbody>	";
						$i=1;
						while($row_lista = sqlsrv_fetch_array($ressqlselect_fac)){
							$ayo_fac = $row_lista['AYO'];
							$id_fac = $row_lista['ID_FACTURA'];
							$monto = $row_lista['MONTO'];

							
$html.="	    	<tr >
						<td>".$i."</td>
						<td>".$ayo_fac."
							<input type='hidden' id='ay_fa$i' value='$ayo_fac'>
						</td>
						<td>".$id_fac."
							<input type='hidden' id='idfac$i' value='$id_fac'>
						</td>
						<td>".$monto."
							<input type='hidden' id='mont$i' value='$monto'>
						</td>
						<!-- <td>
							
							<center><button type='button' onclick='aplica_pago($pagos,$ayo,$reg,\"$usu\")' class='btn btn-warning btn-sm' data-toggle='modal' >Aplica pago</button></center>
						</td>-->
						
					</tr>";
					$i++;	}
$html.="
					
		    </tbody>
			</table>
		</form>
		</div>
		<div class='col-md-12'><br></div>
            <div class='modal-footer'>  <br>
				<div class='col-md-12'>
				<br>
				<center><button name='btn'  value='cancelar' onclick='aplica_pago($pagos,$ayo,$reg,\"$usu\")' type='button' class='btn btn-success' >Aplica pago</button>
				<button name='btn'  value='cancelar' onclick='cancela_pago($pagos,$ayo,$reg,\"$usu\")' type='button' class='btn btn-danger' >Cancelar pago</button>
				<button type='button' class='btn btn-warning' data-dismiss='modal'>CERRAR</button></center>
			    </div>
        </div>
		";
} else {
	$html .=" <br><br><br><br>
	<div class='alert alert-danger alert-dismissible' role='alert'>
		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		<strong>NO EXISTEN FACTURAS ASIGNADAS</strong>  
	</div><br><br><br><br>
	";
	
}
		echo $html;

