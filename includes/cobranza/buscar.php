<?php 
include_once '../../config.php';
$usu_p = $_REQUEST['usu_p'];
$html = "";
  $sql_usup = "SELECT PF.ID_USUARIO,ID_USUARIO_FACTURA, ID_USUARIO_PAGA,R_SOCIAL,SITUACION,SECTOR,DESTACAMENTO FROM Parametros_Facturacion PF
  INNER JOIN V_usuario_padron VUP on pf.ID_USUARIO=VUP.ID_USUARIO
  WHERE pf.ID_USUARIO_FACTURA='$usu_p'
";
  $params = array();
  $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
  $stmt = sqlsrv_query( $conn, $sql_usup , $params, $options );
  $row_count = sqlsrv_num_rows( $stmt );
  if($row_count>0){
$html ="
<br><br>
<div class='col-md-12'>
	<div class='col-md-3'></div>
	<div class='col-md-6'>
		<table  class='table table-responsive fixed ' style='font-size:10px;   '  border=1  BORDERCOLOR=#e7e7e7 >
		<thead> 
			  <tr class='cheader'>
				<td  align='center' class='bg-primary'><b>SECTOR</td>
				<td  align='center' valign='middle' class='bg-primary'><b>DESTACAMENTO</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>ID USUARIO</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>R SOCIAL</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>SITUACION</td>
			  </tr> 
		</thead>
		<tbody>
		";
		while($row = sqlsrv_fetch_array($stmt)){
			
		$html.="
			<tr>
				<td  align='center' >".$row['SECTOR']."</td>	
				<td  align='center' >".$row['DESTACAMENTO']."</td>	
				<td  align='center' >".$row['ID_USUARIO']."</td>	
				<td  align='center' >".($row['R_SOCIAL'])."</td>	
				<td  align='center' >".$row['SITUACION']."</td>	
			</tr>
			";
		}
		$html.="
		</table>
		
	</div>
	<div class='col-md-3'></div>
</div>
";
} else {
$html.="
<div class='col-md-12'>
<br>
<center><button name='btn'  value='cancelar' onclick='cancela()' type='button' class='btn btn-success' >SI, CANCELAR</button>
<button type='button' class='btn btn-danger' data-dismiss='modal'>CERRAR</button></center>
<br>
</div>

";	
}		
echo $html;
?>