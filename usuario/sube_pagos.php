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
        <div class="row pull-center">  
        <div id="tb4" ></div><hr>            
            <form enctype="multipart/form-data" id="formTb1" method="post" >
                <div class="row">
                    <div class="col-lg-3 col-xs-3 text-center"></div>
                    <div class="col-lg-2 col-xs-2 text-center">
                        <label>Fecha:</label>
                        <input required="true" id="fecha_pago" name="fecha_pago" type="date" class="form form-control">
                    </div>

                    <div class="col-lg-2 col-xs-2 text-center">                                                  
                        <label>Monto: </label>
                        <input required="true" type="number" step="0.01" class="form form-control" id="monto_pago" name="monto_pago">
                    </div>                                    
                    <div class="col-lg-2 col-xs-2 text-center">                                                  
                        <label>Cuenta: </label>
                        <select required="true" id="noCuenta" name="noCuenta" class="form form-control">                                                        
                        </select>
                    </div>                                    
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-3 col-xs-3 text-center"></div>
                    <div class="col-lg-2 col-xs-2 text-center">                           
                        <label>Referencia / Linea de captura: </label>
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
        <hr>
        
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
                <h4 style=" color: #1C4773; font-weight: 600">REPORTE DE SOLICITUDES DE PAGO.</h4> 
                <hr>
                <div id="tb2" ></div>
                <div id="tb1"></div>                         
            </div>
        </div>                     
    </section>
    <input placeholder="ID DE USUARIO" id="id_usuario" type="hidden" value="<?php echo $nombre ?>" class="form form-control">
</div>

<?php include_once '../footer.html'; ?>
<script>
    usuario();
    var $alerta = $("#alert");
    var $msg = $('#msg');
    $alerta.hide();
    $("#progressBar").hide();
    bancos();
    reportePagos();
    $(".close").click(function () {
        $alerta.hide();
    });

    function bancos() {
       var url = "<?php echo BASE_URL; ?>includes/admin_Cuenta/searchDatos.php";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                displayCuentas: 2,
                ID_USUARIO:$('#id_usuario').val()
            }, // Adjuntar los campos del formulario enviado.
            success: function (data)
            {                
                $("#noCuenta").html(data); // Mostrar la respuestas del script PHP.                
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
                    reportePagos();
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
    
        function usuario() {

        var url = "<?php echo BASE_URL; ?>includes/Facturas_Iniciales/search_usu.php";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                ID_USUARIO: $('#id_usuario').val()
            }, // Adjuntar los campos del formulario enviado.
            success: function (data)
            {                
                if(data!=2){
                $("#tb4").html(data); // Mostrar la respuestas del script PHP.               
                }else{                    
                        var Msg = 'No se encontraron resultados.';
                        alertAccess(Msg,'alert-warning');
                        setTimeout(function () {                            
                        }, 3000);
                }
            }
        });        
        return false;
    }
    
  function reportePagos(){
    var url = "<?php echo BASE_URL; ?>includes/sube_pagos/reporteSolicitudPago.php";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                ID_USUARIO: $('#id_usuario').val()
            }, // Adjuntar los campos del formulario enviado.
            success: function (data)
            {                
                if(data!=2){
                $("#tb2").html(data);
                     $('#tableFac').DataTable({
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla (Sin resultados de busqueda)",
                        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    }
                });
                }
            }
        });        
        return false;        
    }
</script>



