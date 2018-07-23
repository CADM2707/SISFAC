<?php
  include_once ('../head.php');
?>                        
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        SISTEMA COBRANZA
                        <small>Panel de control</small>
                    </h1>                    
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
				<form name="importar" method="post" action="banca.php" enctype="multipart/form-data" >
				
                    <div class="col-lg-12 col-xs-12 text-center">   
						
						<div class="col-lg-3 col-xs-3 text-center"></div>
						<div class="col-lg-3 col-xs-3 text-center">
							<input type="button" value="Subir archivo banca" id="btn" class="btn btn-primary">
						</div>
						<div class="col-lg-3 col-xs-3 text-center">
							<input type="button" value="Subir archivo linea de captura" id="btn" class="btn btn-primary">
						</div>
						<div class="col-lg-3 col-xs-3 text-center"></div>
                        <!--<div id="cont">
                           <input type="file" class="form-control" name="banca">
                        </div>-->
                        
                    </div>
				
				</form>
                                    
                </div>                
            </section>
            </div>
            
            <?php include_once ('../footer.html'); ?>
            <script>
//                Funcion con ajax sinn formulario
//                function buttonGraf(sec) {
//                    
//                    var url = "<?php echo BASE_URL; ?>includes/facturacionEmitida/responseGrafFacEm.php";
//
//                    $.ajax({
//                        type: "POST",
//                        url: url,
//                        data: {
//                            UnoCal1: $('#UnoCal1').val(),                            
//                            Sector: sec
//                        },
//                        success: function (data)
//                        {
//                            $("#tb2").html(data); // Mostrar la respuestas del script PHP.
//                            document.getElementById("tb2").style.display="block";                               
//                        }
//                    });
//                    document.getElementById("Sec").value = sec;                              
//                    return false;
//                }
//*****************************************************************************************************************************

//        AJAX CON FORMULARIO
//    $('#formTb1').submit(function () {
//        var url = "<?php echo BASE_URL; ?>includes/facturacionEmitida/responseFactEm.php";
//        $.ajax({
//            type: "POST",
//            url: url,
//            data: $("#formTb1").serialize(), // Adjuntar los campos del formulario enviado.
//            success: function (data)
//            {
//                $("#tb1").html(data); // Mostrar la respuestas del script PHP.    
//                document.getElementById('tb2').style.display = "none";                                                             
//            }
//        });
//
//        return false;
//    });
            </script>



