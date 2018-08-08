<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';    
?>  
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>DEDUCTIVAS<small></small></h1>                    
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center">   
					<div  class="col-md-4 col-sm-4 col-xs-4"></div>
					<div  class="col-md-2 col-sm-2 col-xs-2">
						<center><label>USUARIO :</label></center>
						<input type="text" name="usuario" onchange="Usuario()"  value="<?php echo @$usuario;?>" id="usuario" style="text-align:center;"  class="form-control"  >
					</div>
					<div id="formulario_deductivas"  style="display: none;">	</div> 	
					<div id="form2"  style="display: none;">	</div> 	
					<div id="mensaje_deductiva"  style="display: none;">	</div> 	
				
                    </div>                                    
                </div>                
            </section>
            </div>
            
            <?php include_once '../footer.html'; ?>
         
<script>
function Deductiva(){
        var url = "<?php echo BASE_URL; ?>includes/sector/captura_deductiva.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Usuario: $('#usuario').val(),
				Servicio: $('#servicio').val(),
				Deductiva: $('#deductiva').val(),
				Monto: $('#monto').val(),
				Cantidad: $('#cantidad').val()
            },
            success: function (data)
            {
                $("#mensaje_deductiva").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("mensaje_deductiva").style.display="block";                  
            }
        });
    }	

function Usuario(){
        var url = "<?php echo BASE_URL; ?>includes/sector/cap_deductiva_servicio.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Usuario: $('#usuario').val()				
            },
            success: function (data)
            {
                $("#formulario_deductivas").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("formulario_deductivas").style.display="block";                  
            }
        });
    }	
function Servicio(){
        var url = "<?php echo BASE_URL; ?>includes/sector/cap_deductiva.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Usuario: $('#usuario').val(),				
				Servicio: $('#servicio').val()				
            },
            success: function (data)
            {
                $("#form2").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("form2").style.display="block";                    
            }
        });
    }		
	
	
</script>


