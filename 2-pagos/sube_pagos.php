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
                        <label>Fecha del depósito:</label>
                        <input required="true" id="fecha_pago" name="fecha_pago" type="date" class="form form-control">
                    </div>

                    <div class="col-lg-2 col-xs-2 text-center">                                                  
                        <label>Monto: </label>
                        <input required="true" type="number" step="0.01" class="form form-control" id="monto_pago" name="monto_pago">
                    </div>                                    
                    <div class="col-lg-2 col-xs-2 text-center">                                                  
                        <label>Cuenta pagadora: </label>
                        <select required="true" id="noCuenta" name="noCuenta" class="form form-control">                                                        
                        </select>
                    </div>                                    
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-3 col-xs-3 text-center"></div>
                    <div class="col-lg-2 col-xs-2 text-center">                           
                        <label>Referencia / Linea de captura: </label>
                        <input required="true" maxlength="10" placeholder="Maximo 10 caracteres" type="text" class="form form-control" id="referencia_pago" name="referencia_pago">
                    </div>           
                    <div class="col-lg-2 col-xs-2 text-center">
                        <label><h4 style="display: inline"><i class="fa fa-paperclip text-blue"></i></h4> &nbsp;Adjuntar baucher</label>
                        <input required="true" class="form form-control" name="baucher" type="file" id="baucher">
                    </div>
                    <div class="col-lg-2 col-xs-2 text-center">
                        <br>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> &nbsp;Subir pago</button>
                        <!--<input style=" display: none;" required="true" class="form form-control" id="hora_pago" name="hora_pago"  type="time">-->                        
                    </div>
                    <br>
                </div><br>
                <div class="row">
                    <div class="col-lg-4 co4-xs-4 text-center"></div>
                    <div class="col-lg-4 co4-xs-4 text-center">
                        
                    </div>
                </div>
                <div class="row">                    
                    <div class="col-lg-12 col-xs-12 text-center">                        
                        <div class="progress" style=" height: 35px;" id="progressBar">
                            <div class="progress-bar progress-bar-success" id="cont1" role="progressbar" style="width:0%;">
                            </div>
                        </div>                        
                    </div>
                </div>
                
            </form>
        </div>
        <hr>
        <div class="modal fade" id="myModalCharts" role="dialog" style="margin: 40px;">
                <div class="modal-dialog mymodal modal-lg" style=" width: 100% !important">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header title_left" style=" background-color: #2C3E50;">
                            <button type="button" class="close" data-dismiss="modal" style=" background-color: white;">&nbsp&nbsp;&times;&nbsp&nbsp;</button>
                            <span style="text-align: center">
                                <h4 style=" color: white; font-weight: 600"><i class='fa fa-plus-square'></i> &nbsp;ASIGNA PAGO.</h4>
                            </span>
                        </div>   
                        <div class="modal-body">                            
                            <div class="col-md-12">
                                <form id='validaPagos' name='validaPagos' method="POST">
                                    <div class="row pull-center" style="margin: 5px;">
                                        <div class="col-lg-1 col-xs-1 text-center"></div>
                                        <div class="col-lg-2 col-xs-2 text-center">
                                            <label style="font-weight: 600; color: #2471A3;">ID PAGO</label>
                                            <input style=" background-color: #FFF3C3;" type="text" readonly='true' id="idPagoAsigna" name="idPagoAsigna" class="form form-control text-center">
                                        </div>
                                        <div class="col-lg-2 col-xs-2 text-center">
                                            <label style="font-weight: 600; color: #2471A3;">FECHA DE PAGO</label>
                                            <input style=" background-color: #FFF3C3;" type="text" readonly='true' id="idAyoAsigna" name="idAyoAsigna" class="form form-control text-center">
                                        </div>
                                        <div class="col-lg-2 col-xs-2 text-center">
                                            <label style="font-weight: 600; color: #2471A3;">MONTO</label>
                                            <input type="text" readonly='true' style=" background-color: #FFF3C3;"  id="montoAsigna" name="montoAsigna" class="form form-control text-center">
                                        </div>                                
                                        <div class="col-lg-2 col-xs-2 text-center">
                                            <label style="font-weight: 600; color: #2471A3;">MONTO APLICADO</label>
                                            <input type="text" readonly='true' style=" background-color: #FFF3C3;"  id="montoAplicado" name="montoAplicado" class="form form-control text-center">
                                        </div>                                
                                        <div class="col-lg-2 col-xs-2 text-center">
                                            <label style="font-weight: 600; color: #2471A3;">MONTO POR APLICAR</label>
                                            <input type="text" style=" background-color: #FFF3C3;" readonly='true' id="montoPorAplicar" class="form form-control text-center">
                                        </div>                                
                                    </div><br>
                                    <div class="row" style=" z-index: 100 !important">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4 text-center">
                                            <div class="" id="alert">
                                                <button type="button" class="close" data-dismiss="alert">x</button>
                                                <strong>Notificación: </strong>
                                                <div id="msg"></div>
                                            </div>   
                                        </div>
                                        <div class="col-md-4"></div>
                                    </div>
                                    <div class="row pull-center" style="margin: 5px;">
                                        <div class="col-lg-12 col-xs-12 text-center">                                                  
                                            <div id="tbFacturas" class="text-center"></div>                                           
                                        </div>
                                    </div>                               
                                    <hr> 
                                </form>
                            </div>                            
                        </div>
                        <div class="modal-footer">
                            <!--                <button type="button" class="close" data-dismiss="modal" style=" background-color: black;">&nbsp&nbsp;&times;&nbsp&nbsp;</button>-->
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-lg-1 col-xs-1 text-center"></div>
            <div class="col-lg-10 col-xs-10 text-center">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                        <div id="alerta" >
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
        <div class='modal fade' id='respuesta' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header' style=' background-color: #2C3E50;'>
                            <h5 class='modal-title' id='exampleModalLabel' style='display:inline'></h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <h4><label> <span id="responsePago"></span></label></h4>
                        </div>
                        <div class='modal-footer'>
                            <center>
                                <button type='button' class='btn btn-primary' data-dismiss='modal'>Aceptar</button>                                
                            </center>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <input placeholder="ID DE USUARIO" id="id_usuario" type="hidden" value="<?php echo $nombre ?>" class="form form-control">        
</div>

<?php include_once '../footer.html'; ?>
<script>
    var $alerta = $("#alerta");
    var $alerta2 = $("#alert");
    var $msg = $('#msg');
    $alerta.hide();    
    $alerta2.hide();    
    $("#progressBar").hide();
    usuario();
    bancos();        
    $(".close").click(function () {
        $alerta.hide();
        $alerta2.hide();
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
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data)
            {                
                var id_registro = data[1];
                $("#progressBar").show();                              
                switch(data[0]){
                    case 1:
                        $("#cont1").removeClass().addClass('progress-bar-success progress-bar')    
                        $("#cont1").html('<h4>El archivo se subío con éxito!</h4>');
                        $("#cont1").css('width', '100%');   
                        $("#formTb1")[0].reset();
                        reportePagos( id_registro );
                    break;
                    
                case 2:
                    $("#cont1").removeClass().addClass('progress-bar-warning progress-bar')
                    $("#cont1").html('<h4>Formato del archivo incorrecto!</h4>');
                    $("#cont1").css('width', '100%');
                break;
                
                case 3:
                    $("#cont1").removeClass().addClass('progress-bar-danger progress-bar')
                    $("#cont1").html('<h4>Error al subir el archivo!</h4>');
                    $("#cont1").css('width', '100%'); 
                break;
                
                case 4:
                    $("#cont1").removeClass().addClass('progress-bar-warning progress-bar')
                    $("#cont1").html('<h4>Error: Está intentando ingresar un pago con los datos repetidos de uno ya existente!</h4>');
                    $("#cont1").css('width', '100%');
                break;
                      
                default:
                    $("#cont1").removeClass().addClass('progress-bar-danger progress-bar')
                    $("#cont1").html('<h4>Error: no se registro el pago!</h4>');
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
    
  function reportePagos(id_registro){
      var id=id_registro;
    var url = "<?php echo BASE_URL; ?>includes/sube_pagos/reporteSolicitudPago.php";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                ID_USUARIO: $('#id_usuario').val(),
                ID_REGISTRO: id,
            }, // Adjuntar los campos del formulario enviado.
            success: function (data)
            {                
                if(data!=2){
                $("#tb2").html(data);           
                }
            }
        });        
        return false;        
    }
    
    
    function deletePago(id_registro){
        console.log(id_registro);
    }
    
    
    function AsignaPagoPago(cont,id_registro,monto,fecha_pago) {
        var color=1;
        if (color == 1) {
            $("#montoPorAplicar").removeClass('bg-color-Beige')
                    .removeClass('bg-color-red')
                    .addClass('bg-color-green');
        } else if (color > 0) {
            $("#montoPorAplicar").removeClass('bg-color-green')
                    .removeClass('bg-color-red')
                    .addClass('bg-color-Beige');
        } else if (color < 0) {
            $("#montoPorAplicar").removeClass('bg-color-green')
                    .removeClass('bg-color-Beige')
                    .addClass('bg-color-red');
        }

//        monto = $('#' + cont).val();
//        montoA = $('#MA' + cont).val();
//        montoPA = $('#MPA' + cont).val();
//        
        $("#idPagoAsigna").val(id_registro);
        $("#idAyoAsigna").val(fecha_pago);
        $("#montoAsigna").val(monto);
        $("#montoAplicado").val(0);
        $("#montoPorAplicar").val(monto);
        loadPagos();
        $('#myModalCharts').modal('show');
    }
    
        function loadPagos() {
        var url = "<?php echo BASE_URL; ?>includes/pagos_solicitados/load_pagos.php";
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'html',
            data: {
                FACTURASDPT: 1,               
            },
            success: function (data) {
                $('#tbFacturas').html(data);
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
        });

        return false;
    }
    
    function updateMPA(id,importe,pago,saldo){
    
    $("#soliPago").removeAttr('disabled');
    
    var mPAplicar=$("#montoPorAplicar").val();
    var mAplicado=$("#montoAplicado").val();
    var monto=$("#montoAsigna").val();
    var mAsignado=$('#F'+id).val();    
//    console.log(mPAplicar);
//    console.log(mAsignado);
//    console.log(monto);
//    console.log(mAsignado);
    
        var url = "<?php echo BASE_URL; ?>includes/pagos_solicitados/preAsignaPago.php";
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: {
               MPA:mPAplicar,
               MA:mAplicado,
               MONTO:monto,
               MASIGNADO:mAsignado,
               IMPORTE:importe,
               PAGO:pago,
               SALDO:saldo,
            },
            success: function (data)
            {                                
                
                if(data[0]==2){                    
                    $('#F'+id).val('');
                    $alerta.removeClass();
                    $alerta
                            .addClass('alert')
                            .addClass('alert-warning')
                            .addClass('alert-dismissible');
                    $msg.html('El monto que intenta asignar es superior al <b>MONTO POR APLICAR</b>!.');
                    $alerta.show();
                    setTimeout(function () {
                        $alerta.hide();                        
                    }, 5000);                    
                }else if(data[0]==1){                    
                    $("#montoAplicado").val(data[1]);
                    $("#montoPorAplicar").val(data[2]);
                    if(data[2]==0){
                        $("#montoPorAplicar").removeClass('bg-color-green')
                                 .removeClass('bg-color-red')
                                 .addClass('bg-color-Beige');
                    }
                }
            }
        });
    
    return false;
}

    function guardaPago() {               
        var url = "<?php echo BASE_URL; ?>includes/pagos_solicitados/savePagoAsignado.php";
        $.ajax({
            type: "POST",
            url: url,            
            data: $("#validaPagos").serialize(),
            success: function (data) {
                if(data==1){
                    $("#responsePago").text("Se a guardado correctamente el pago!");
                    $("#tb2").html("");
                }else{
                    $("#responsePago").text("Ha ocurrido un problema al guardar el pago, intentelo nuevamente!");
                }
                $("#respuesta").modal('show');
            }
        });       
        
        return false;            
    }
</script>



