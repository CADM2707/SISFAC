<?php
include_once '../config.php';
include_once '../head.html';
include_once '../menuLat.php';
@$usu = $_REQUEST['usu'];
@$usu_dep = $_REQUEST['usu_dep'];
if(@$_REQUEST['usu'] != "" and @$_REQUEST['usu_dep'] != ""){
	$sql_conex = "select ID_USUARIO_PAGA from Parametros_Facturacion WHERE ID_USUARIO = '$usu_dep'";
	$params_conex = array();
  $options_conex =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
  $stmt_conex = sqlsrv_query( $conn, $sql_conex , $params_conex, $options_conex );
  $row_countex = sqlsrv_num_rows( $stmt_conex );
  if($row_countex>0){
	  $sql_usupaga = "UPDATE Parametros_Facturacion SET ID_USUARIO_PAGA='$usu' WHERE ID_USUARIO = '$usu_dep'";
  } else if ($row_countex==0){
	  $sql_usupaga = "insert into Parametros_Facturacion (ID_USUARIO_PAGA, ID_USUARIO,ID_USUARIO_FACTURA) values ('$usu','$usu_dep','$usu')";
  }
 // echo $sql_usupaga;
  $res_usupaga = sqlsrv_query($conn,$sql_usupaga);
  
}
?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper" style=" background-color: white;">
		<!--Titulos de encabezado de la pagina-->
		<section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
			<h1>
				BÚSQUEDA DE USUARIOS
			</h1>
			<br>
		</section>
		<!-- FIN DE Titulos de encabezado de la pagina-->

		<section class="content" >
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-lg-12 col-xs-12 text-center">
			<?php
			if(@$_REQUEST['usu'] != "" and @$_REQUEST['usu_dep'] != "" and $res_usupaga != ""){?>
			<div class="alert alert-success"> <font style='font-size:16px;'> <b> LA INFORMACIÓN SE GUARDÓ CON ÉXITO </b> </font> </div>
			<?php }
			?>
				<!-- ------------------------ area de trabajo ------------------------ -->
				<form accept-charset="utf-8" method="POST">
                <?php if(@$_REQUEST['usu'] == ""){?>	
				<div> <font style='font-size:16px; color:#000000'> <b> SELECCIONA USUARIO </b> </font> </div>
								
				
				<table align="center" border="0" width="44%">
				  <tr><td>			
				    <input type="text" name="busqueda" id="busqueda" value="" placeholder="" maxlength="77" autocomplete="off" class="form-control"  style="text-align:center;" onKeyUp="buscar();" />
				  </td></tr>
				</table>
				<div id="resultadoBusqueda"></div>
				<?php } else {
				
 $html = "";
  $sql_usup = "SELECT PF.ID_USUARIO,ID_USUARIO_FACTURA, ID_USUARIO_PAGA,R_SOCIAL,SITUACION,SECTOR,DESTACAMENTO FROM Parametros_Facturacion PF
  INNER JOIN V_usuario_padron VUP on pf.ID_USUARIO=VUP.ID_USUARIO
  WHERE pf.ID_USUARIO_FACTURA='$usu' or ID_USUARIO_PAGA='$usu'
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
NO EXISTEN RESULTADOS
<br>

</div>

";	
}
$html.="
<div class='col-md-12'>
	<div class='col-md-3'></div>
	<div class='col-md-6'>
		  <br><br>
		  <input type='text' name='busqueda2' id='busqueda2' value='' placeholder='' maxlength='77' autocomplete='off' class='form-control'  style='text-align:center;' onKeyUp='buscar2($usu);' />
		  <br>
		  <div id='resultadoBusqueda2'></div>
		  <a href='buscar_pusuario.php'><input type='button'  value='Nueva busqueda' class='btn btn-primary btn-sm center-block' /></a></td>
		  <div id='resultadoBusqueda2'></div>
		  
	</div>
<div class='col-md-3'></div>
</div>
";
echo $html;
?>
<?php } ?>

				</form>
				

				<!-- ------------------------ fin area de trabajo ------------------------ -->
			</div>
		</div>
	</section>
	</div>
		
	<?php include_once '../footer.html'; ?>
	
	<script src="js/jquery-1.11.0.min.js"></script> 
	<script type="text/javascript">
	
	</script>
	<script type="text/javascript">
	$(document).ready(function() {
		setTimeout(function() {
			$(".alert-success").fadeOut(1500);
		},3000);
	});
	$(document).ready(function() {
		setTimeout(function() {
			$(".alert-danger").fadeOut(1500);
		},3000);
	});
	</script>
	
	<script>
	$(document).ready(function() {
		$("#resultadoBusqueda").html('<p></p>');
	});

	function buscar() {
		var textoBusqueda = $("input#busqueda").val();
	    
		 if (textoBusqueda != "") {
			$.post("usuario_paga.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
				$("#resultadoBusqueda").html(mensaje);
			 }); 
		 } else { 
			$("#resultadoBusqueda").html('<p></p>');
			};
	};
	
	
	$(document).ready(function() {
		$("#resultadoBusqueda2").html('<p></p>');
	});

	function buscar2(usu) {
		var textoBusqueda = $("input#busqueda2").val();
	    var usu = usu;
		 if (textoBusqueda != "") {
			$.post("usuario_asigna.php?usu="+usu, {valorBusqueda: textoBusqueda}, function(mensaje) {
				$("#resultadoBusqueda2").html(mensaje);
			 }); 
		 } else { 
			$("#resultadoBusqueda2").html('<p></p>');
			};
	};
	</script>
	
	
	