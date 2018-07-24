<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
?>                        
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1 style="color: #1C4773">
                        <i class=" fa fa-credit-card"></i>
                        FACTURAS INICIALES Y PAGOS ACREDITADOS |
                        <small>CONSULTA DE FACTURAS</small>
                    </h1>                    
                    <br>
                </section>
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row pull-center">
                    <div class="col-lg-4 col-xs-4 text-center"></div>
                    <div class="col-lg-2 col-xs-2 text-center">                           
                        <label>AÑO: </label>
                        <select class="form form-control">
                            <option disabled="true" selected="true"> Selecciona </option>
                            <option> 2018 </option>
                            <option> 2017 </option>
                            <option> 2016 </option>
                            <option> 2015 </option>
                            <option> 2014 </option>                            
                        </select>
                    </div>                                    
                    <div class="col-lg-2 col-xs-2 text-center">                           
                        <label>SITUACIÓN: </label>
                        <select class="form form-control">
                            <option disabled="true" selected="true"> Selecciona </option>
                            <option> PAGADO </option>
                            <option> PENDIENTE DE PAGO </option>
                        </select>
                    </div>                                    
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-1 col-xs-1 text-center"></div>
                    <div class="col-lg-10 col-xs-10 text-center">
                        <table class="table table-bordered table-hover table-responsive table-striped">
                            <thead>
                            <th>ID USUARIO</th>
                            <th>R. SOCIAL</th>
                            <th>AÑO.</th>
                            <th>QNA.</th>
                            <th>IMP.</th>
                            <th>SITUACION</th>
                            <th>FACTURA</th>
                            <th>REP</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><button type="button" class="btn btn-primary" ><i class="fa  fa-file-pdf-o"></i> PDF &nbsp;| &nbsp;<i class="fa fa-file-excel-o"></i> XML</button></td>
                                    <td><button type="button" class="btn btn-warning" ><i class="fa  fa-list-ul"></i>&nbsp; DETALLES</button></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            </div>
            
            <?php include_once '../footer.html'; ?>
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



