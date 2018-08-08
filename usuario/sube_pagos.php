<?php
include_once '../config.php';
include_once '../head.html';
include_once '../menuLat.php';
?>     
<style>
    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
    .barra{
        background-color: #f3f3f3;
        border-radius: 4px;
        box-shadow: inset 0px 0px 5px rgba(0,0,0.2);
        height: 25px;
    }

    .barra_azul{
        background-color: #247CC0 !important;
        border-radius: 10px;
        display: block;
        height: 25%;
        line-height: 25px;
        text-align: center;
        width: 0%;
    }

    .barra_verde{
        background-color: #2EA265 !important;
    }

    .barra_roja{
        background-color: #DE3152 !important;
    }

</style>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">  
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style=" background-color: white;">
    <!--Titulos de encabezado de la pagina-->
    <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
        <h1 style="color: #1C4773">
            <i class=" fa fa-credit-card"></i>
            PAGOS ACREDITADOS |
            <small>SUBIR PAGOS &nbsp;<i class="fa fa-upload "></i></small>
        </h1>                    
        <br>
    </section>

    <section class="content" >
        <!-- Small boxes (Stat box) -->
        <br>
        <div class="row pull-center">              
            <form enctype="multipart/form-data" id="formTb1" method="post" >
                <div class="row">
                    <div class="col-lg-3 col-xs-3 text-center"></div>
                    <div class="col-lg-2 col-xs-2 text-center">
                        <label>FECHA</label>
                        <input required="true" id="fecha_pago" name="fecha_pago" type="date" class="form form-control">
                    </div>

                    <div class="col-lg-2 col-xs-2 text-center">                                                  
                        <label>Monto: </label>
                        <input required="true" type="number" class="form form-control" id="monto_pago" name="monto_pago">
                    </div>                                    
                    <div class="col-lg-2 col-xs-2 text-center">                                                  
                        <label>Banco: </label>
                        <select required="true" id="banco_pago" name="banco_pago" class="form form-control">                                                        
                        </select>
                    </div>                                    
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-3 col-xs-3 text-center"></div>
                    <div class="col-lg-2 col-xs-2 text-center">                           
                        <label>Referencia / Linea pago: </label>
                        <input required="true" type="text" class="form form-control" id="referencia_pago" name="referencia_pago">
                    </div>           
                    <div class="col-lg-2 col-xs-2 text-center">
                        <label><h4 style="display: inline"><i class="fa fa-paperclip text-blue"></i></h4> &nbsp;Adjuntar baucher</label>
                        <input required="true" class="form form-control" name="baucher" type="file" id="baucher">
                    </div>
                    <div class="col-lg-2 col-xs-2 text-center">
                        <br>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> &nbsp;Subir pago</button>
                    </div>
                    <br>
                </div><br>
                <div class="row">
                    <div class="col-lg-3 col-xs-3 text-center"></div>
                    <div class="col-lg-6 col-xs-6 text-center">                        
                        <div class="progress" style=" height: 35px;" id="progressBar">
                            <div class="progress-bar progress-bar-success" id="cont1" role="progressbar" style="width:0%;">
                            </div>
                        </div>                        
                    </div>
                </div>
            </form>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-1 col-xs-1 text-center"></div>
            <div class="col-lg-10 col-xs-10 text-center">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                        <div class="" id="alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>Mensaje: </strong>
                            <div id="msg"></div>
                        </div>   
                    </div>
                    <div class="col-md-4"></div>
                </div>  
                <div id="tb2" ></div>
                <div id="tb1"></div>                         
            </div>
        </div>
        <div>
            <div class="modal fade" id="myModalCharts" role="dialog">
                <div class="modal-dialog mymodal modal-lg" style=" width: 75% !important">         
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header title_left" style=" background-color: #2C3E50;">
                            <button type="button" class="close" data-dismiss="modal" style=" background-color: white;">&nbsp&nbsp;&times;&nbsp&nbsp;</button>
                            <h4 class="modal-title" style=" color: white;"><img width="2%"  src="<?php echo BASE_URL; ?>dist/img/pa2.png"><center></center></h4>
                        </div>
                        <div style="text-align: center"><br>
                            <h4 style=" color: #1B4C7C; font-weight: 600">LISTADO DE PAGOS.</h4><hr>
                        </div>  
                        <div class="col-md-12">
                            <div id="tbPagos" class="text-center"></div>
                        </div>
                        <div class="modal-footer">   
                            <!--                <button type="button" class="close" data-dismiss="modal" style=" background-color: black;">&nbsp&nbsp;&times;&nbsp&nbsp;</button>-->
                        </div>
                    </div>      
                </div>
            </div>
        </div>                
    </section>

</div>

<?php include_once '../footer.html'; ?>
<script>
    var $alerta = $("#alert");
    var $msg = $('#msg');
    $alerta.hide();
    $("#progressBar").hide();
    bancos();

    $(".close").click(function () {
        $alerta.hide();
    });

    function bancos() {
        var url = "<?php echo BASE_URL; ?>includes/admin_Cuenta/searchDatos.php";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                banco_selec: 1,
            },
            success: function (data)
            {
                $("#banco_pago").html(data);
            }
        });

        return false;
    }

    $('#formTb1').submit(function () {
        var url = "<?php echo BASE_URL; ?>includes/sube_pagos/uploadFile.php";
        var formData = new FormData(document.getElementById('formTb1'));
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'html',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data)
            {
                $("#progressBar").show();
                if(data==1){
                    $("#cont1").removeClass().addClass('progress-bar-success progress-bar')    
                    $("#cont1").html('<h4>El archivo se subío con éxito!</h4>');
                    $("#cont1").css('width', '100%');   
                    $("#formTb1")[0].reset();
                }else if(data==2){
                    $("#cont1").removeClass().addClass('progress-bar-warning progress-bar')
                    $("#cont1").html('<h4>Formato del archivo incorrecto!</h4>');
                    $("#cont1").css('width', '100%'); 
                }else if(data==3 || data !=""){
                    $("#cont1").removeClass().addClass('progress-bar-danger progress-bar')
                    $("#cont1").html('<h4>Error al subir el archivo!</h4>');
                    $("#cont1").css('width', '100%'); 
                }                 
                    setTimeout(function () {
                    $("#progressBar").slideToggle("slow");
                }, 3000);
            }
        });

        return false;
    });
</script>



