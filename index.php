<?php
    include_once 'config.php';
    include_once 'head.html';
    include_once 'menuLat.php';
?>                        
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        SISTEMA FACTURACIÓN
                        <small>Panel de control</small>
                    </h1>                    
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center">   
                        <div id="cont">
                            Hola Soy un toggle
                        </div>
                        <input type="button" value="BUTTON" id="btn">
                        <!--area de trabajo-->
<!--                    ***
                        ***
                        ***
                        ***
                        ***
                        ***
                        ***
                        ***
                        ***-->
                        <!--fin area de trabajo-->
                    </div>                                    
                </div>                
            </section>
            </div>
            
            <?php include_once 'footer.html'; ?>
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



