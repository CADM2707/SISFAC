<?php
include_once '../config.php';
include_once '../head.html';
include_once '../menuLat.php';


?>
<style>
tbody>tr:hover {
     background-color: transparent !important;
}
</style>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper" style=" background-color: white;">
		<!--Titulos de encabezado de la pagina-->
		<section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
			<h1>
				USUARIO PAGA
			</h1>
			<br>
		</section>
		<!-- FIN DE Titulos de encabezado de la pagina-->

		<section class="content" >
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-lg-12 col-xs-12 text-center">
				<!-- ------------------------ area de trabajo ------------------------ -->

			 
				<form   name="subir" id="subir">
				<table align="center" border="0">
					<tr>
					  <td colspan = "3">
					  <b>USUARIO PAGA</b>
					  <br><br>
					  </td>
					</tr>
					<tr>
					  <td align="center">
						  <input name="usu_p" id="usu_p" type="text" class="form-control" value="" required="true" />
					  </td>
					  <td>
					  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  </td>
					  <td>
						 <button id="boton1" type='submit' class='btn btn-primary btn-sm' data-toggle='modal' >BUSCAR</button>
							<button id="boton1" type='button' onclick="mas()" class='btn btn-success btn-sm' data-toggle='modal' title="AGREGAR USUARIO"><i class="fa fa-plus"></i></button>			
					  </td>
					</tr>
				 </table>
				  <div id="tb1" ></div> 
				</form>
			
				<!-- ------------------------ fin area de trabajo ------------------------ -->
			</div>
		</div>
	</section>
	</div>

	<?php include_once '../footer.html'; ?>
		<script src="js/jquery-1.11.0.min.js"></script> 
	<script language="JavaScript">
 $('#subir').submit(funcion(){
	 
		var url = "<?php echo BASE_URL; ?>includes/cobranza/buscar.php";
		
        $.ajax({
            type: "POST",
            url: url,
            data: {
				usu_p: $('#usu_p').val()				
            },
            success: function (data)
            {
				
                $("#tb1").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("tb1").style.display="block"; 
			

            }
        });
		
		return false;
            
	 
 }
 );
 
		
    
</script> 