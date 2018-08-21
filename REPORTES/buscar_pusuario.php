<?php
include_once '../config.php';
include_once '../head.html';
include_once '../menuLat.php';
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
				<!-- ------------------------ area de trabajo ------------------------ -->

               				
				<div> <font style='font-size:16px; color:#000000'> <b> SELECCIONA USUARIO </b> </font> </div>
								
				<form accept-charset="utf-8" method="POST">
				<table align="center" border="0" width="44%">
				  <tr><td>			
				    <input type="text" name="busqueda" id="busqueda" value="" placeholder="" maxlength="77" autocomplete="off" class="form-control" style="text-align:center;" onKeyUp="buscar();" />
				  </td></tr>
				</table>
				<div id="resultadoBusqueda"></div>
				</form>
				

				<!-- ------------------------ fin area de trabajo ------------------------ -->
			</div>
		</div>
	</section>
	</div>
		
	<?php include_once '../footer.html'; ?>
	
	<script src="js/jquery-1.11.0.min.js"></script> 
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
			$.post("buscar_usuarios.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
				$("#resultadoBusqueda").html(mensaje);
			 }); 
		 } else { 
			$("#resultadoBusqueda").html('<p></p>');
			};
	};
	</script>
	
	
	