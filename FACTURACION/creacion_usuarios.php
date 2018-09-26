<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
	
	?>  
   
                     <form  method="POST" class="centrado" >
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        Creacion de Usuarios
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li style="font-size: ">
                            <a href=""><i class="fa fa-home"></i> Inicio</a>
                        </li>
                    </ol>
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center">   
                       <!-- <div id="cont">
                            Hola Soy un toggle
                        </div> -->
                        
                        <div class="row" >
                
                <div  class="col-md-5 col-sm-5 col-xs-5"></div>
				
				<div  class="col-md-2 col-sm-2 col-xs-2">
					<center><label>ID USUARIO:</label></center>
					<input type="text" class="form-control" value="" style="text-align:center;" id="usur">
				</div>	
            
             <div  class="col-md-5 col-sm-5 col-xs-5"></div>
             
             <br>
             
            <br><br><br><div  class="col-md-12 col-sm-12 col-xs-12">
				<!--<button  type="button" onclick="detalle()" value="reporte" class="btn btn-primary center-block" data-target='#myModalCharts'></button>-->
                <button type='button' class='btn btn-primary btn-sm' onclick="detalle()">Aceptar</button>
			</div>            
            
            
            
            <div id="tb3" style="display: none;"></div>

                    </div>   
            
                </div>                
            </section>
            </div>
            </form>
            <?php include_once '../footer.html'; ?>
           
<script>

function detalle(){
        var url = "<?php echo BASE_URL; ?>includes/facturacion/clave.php";

        $.ajax({
            type: "POST",
            url: url,
            data: {
				usur: $('#usur').val()
            },
            success: function (data)
            {
                $("#tb3").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("tb3").style.display="block";
            }
        });


//        $('#myModaldestto').modal('show');

    }

   
	</script>