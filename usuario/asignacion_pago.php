<?php
include_once '../config.php';
include_once '../head.html';
include_once '../menuLat.php';
?>           
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">  
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style=" background-color: white;">
    <!--Titulos de encabezado de la pagina-->
    <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
        <h1 style="color: #1C4773">
            <i class=" fa fa-credit-card"></i>
            PAGOS ACREDITADOS |
            <small>CONSULTA DE FACTURAS PAGADAS</small>
        </h1>                    
        <br>
    </section>

    <section class="content" >
        <!-- Small boxes (Stat box) -->
        <br>
        <div class="row pull-center">              
            <form id="formTb1" method="post" >
                <div class="row">
                    <div class="col-lg-3 col-xs-3 text-center"></div>
                    <div class="col-lg-2 col-xs-2 text-center">                                                  
                        <label>AÑO: </label>
                        <select id="ayo" name="ayo" class="form form-control" required="true">                                
                            <option disabled="true" selected="true" value=""> Selecciona </option>
                            <?php
                            for ($i = date('Y'); $i >= 2000; $i--) {
                                echo "<option value='$i'> $i </option>";
                            }
                            ?>                            
                        </select>
                    </div>  
                    <div class="col-lg-2 col-xs-2 text-center">                                                  
                        <label>Tipo pago: </label>
                        <select id="TipoPago" name="TipoPago" class="form form-control" required="true">                                
                            <option name="" disabled="true" selected="true" value=""> Selecciona </option>                                                          
                            <option name="opt1"  value="1"> Todos </option>                                                          
                            <option name="opt2"  value="2"> Parcialmente aplicado </option>                                                          
                            <option name="opt3"  value="3"> Sin aplicar </option>                                                          
                        </select>
                    </div>                                                                                        
                    <div class="col-lg-2 col-xs-2 text-center">                                                  
                        <br>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> &nbsp;Buscar</button>
                    </div>                                                                                        
                </div>
                <div class="row">
                     <div id="tb1"></div>  
                </div>
                <br>              
            </form>
        </div>
    </section>
</div>         

<?php include_once '../footer.html'; ?>
<script>
 $('#formTb1').submit(function () {
    
    var url = "<?php echo BASE_URL; ?>includes/pagos_acreditados/load_pagos.php";
    $.ajax({
        type: "POST",
        url: url,
        dataType: 'html',
        data: {
            PAGOS: 1,
            AYO:$("#ayo").val(),
            TIPO_PAGO:$("#TipoPago").val(),
        },
        success: function (data){
                $('#tb1').html(data);
        }
    });

    return false; 
});
</script>
    