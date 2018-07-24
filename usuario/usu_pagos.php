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
                    <div class="col-lg-3 col-xs-3 text-center"></div>
                    <div class="col-lg-2 col-xs-2 text-center">                                                  
                        <label>AÑO: </label>
                        <select id="ayo" name="ayo" class="form form-control">
                            <option disabled="true" selected="true" value=""> Selecciona </option>
                            <?php                                                        
                            for($i=date('Y');$i>=2000;$i--){
                                echo "<option value='$i'> $i </option>";                            
                            }
                            ?>                            
                        </select>
                    </div>                                    
                    <div class="col-lg-2 col-xs-2 text-center">                           
                        <label>SITUACIÓN: </label>
                        <select id="situacion" name="situacion" class="form form-control">
                            <option disabled="true" selected="true" value=""> Selecciona </option>
                            <option value="PAGADO"> PAGADO </option>
                            <option value="PENDIENTE DE PAGO"> PENDIENTE DE PAGO </option>
                        </select>
                    </div>           
                    <div class="col-lg-1 col-xs-1 text-center">
                        <br>
                        <button class="btn btn-success" onclick="loadTb1()"><i class="fa  fa-search"></i> Buscar</button>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-1 col-xs-1 text-center"></div>
                    <div class="col-lg-10 col-xs-10 text-center">
                        <div id="tb1"></div>
                    </div>
                </div>
            </section>
            </div>
            
            <?php include_once '../footer.html'; ?>
            <script>          
//                Funcion con ajax sinn formulario
                function loadTb1() {                    
                    var url = "<?php echo BASE_URL; ?>includes/Facturas_Iniciales/Consulta_Facturas.php";

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            AYO: $("#ayo option:selected").val(),                            
                            SITUACION: $("#situacion option:selected").val()
                        },
                        success: function (data)
                        {
                            
                            $("#tb1").html(data); // Mostrar la respuestas del script PHP.
//                            document.getElementById("tb2").style.display="block";                               
                        }
                    });
//                    document.getElementById("Sec").value = sec;                              
                    return false;
                }
            </script>



