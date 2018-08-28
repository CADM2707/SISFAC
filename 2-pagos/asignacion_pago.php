<?php
include_once '../config.php';
include_once '../head.html';
include_once '../menuLat.php';
?>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style>
    .bg-color-Beige{
        background-color: #FFF3C3 !important;
    }
    .bg-color-green{
        background-color: #C3FFCB !important;
    }
   
</style>
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
        <div class="row pull-center">
            <div id="tb2" ></div><hr>
            <form id="formTb1" method="post" >
                <div class="row">
                    <div class="col-lg-3 col-xs-3 text-center"></div>
                    <div class="col-lg-2 col-xs-2 text-center">
                        <label>AÑO: </label>
                        <select id="ayo" name="ayo" class="form form-control">
                            <option  selected="true" value=""> Selecciona </option>
                            <?php
                            for ($i = date('Y'); $i >= 2000; $i--) {
                                echo "<option value='$i'> $i </option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-2 col-xs-2 text-center">
                        <label>Tipo pago: </label>
                        <select id="TipoPago" name="TipoPago" class="form form-control" >
                            <option name="" selected="true" value=""> Selecciona </option>
                            <option name="opt1"  value="1"> Todos </option>
                            <option name="opt2"  value="2"> Parcialmente aplicado </option>
                            <option name="opt3"  value="3"> Sin aplicar </option>
                            <option name="opt4"  value="4"> Cancelado </option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-xs-2 text-center">
                        <br>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> &nbsp;Buscar</button>
                    </div>
                </div><hr>
            </form>
            <div class="row" style=" margin: 5px;">
                <div class="col-lg-12 col-xs-12 text-center">
                    <div id="tb1"></div>
                </div>
            </div>
            
            <div class='modal fade' id='respuesta' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header' style=' background-color: #2C3E50;'>
                            <h5 class='modal-title' id='exampleModalLabel' style='display:inline'>Pagos</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <center> <h4><label> <span id="responsePago"></span></label></h4></center>
                        </div>
                        <div class='modal-footer'>
                            <center>
                                <button type='button' onclick="$('#formTb1').submit()" class='btn btn-primary' data-dismiss='modal'>Aceptar</button>                                
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>                        
    </section>
</div>
<input  placeholder="ID DE USUARIO" id="id_usuario" type="hidden" value="<?php echo $nombre ?>" class="form form-control">
<?php include_once '../footer.html'; ?>
<script>
    var $alerta = $("#alert");
    var $msg = $('#msg');
    $alerta.hide();
    $(".close").click(function () {
        $alerta.hide();
    });
    usuario();

    function updateMPA(id, importe, pago, saldo) {

        var mPAplicar = $("#montoPorAplicar").val();
        var mAplicado = $("#montoAplicado").val();
        var monto = $("#montoAsigna").val();
        var mAsignado = $('#F' + id).val();
//    console.log(mPAplicar);
//    console.log(mAsignado);
//    console.log(monto);
//    console.log(mAsignado);

        var url = "<?php echo BASE_URL; ?>includes/pagos_acreditados/preAsignaPago.php";
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: {
                MPA: mPAplicar,
                MA: mAplicado,
                MONTO: monto,
                MASIGNADO: mAsignado,
                IMPORTE: importe,
                PAGO: pago,
                SALDO: saldo,
            },
            success: function (data)
            {

                if (data[0] == 2) {
                    $('#F' + id).val('');
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
                } else if (data[0] == 1) {
                    $("#montoAplicado").val(data[1]);
                    $("#montoPorAplicar").val(data[2]);
                    if (data[2] == 0) {
                        $("#montoPorAplicar").removeClass('bg-color-green')
                                .removeClass('bg-color-red')
                                .addClass('bg-color-Beige');
                    }
                }
            }
        });

        return false;
    }



    $('#formTb1').submit(function () {

        var url = "<?php echo BASE_URL; ?>includes/pagos_acreditados/load_pagos.php";
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'html',
            data: {
                PAGOS: 1,
                AYO: $("#ayo").val(),
                TIPO_PAGO: $("#TipoPago").val(),
            },
            success: function (data) {
                $('#tb1').html(data);
                $('#tableRes').DataTable({
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
    });



//   $('#validaPagos').submit(
    function guardaPago() {
        var url = "<?php echo BASE_URL; ?>includes/pagos_acreditados/savePagoAsignado.php";
        $.ajax({
            type: "POST",
            url: url,
            data: $("#validaPagos").serialize(),
            success: function (data) {
//            console.log('existo');
                if (data == 1) {
                    $("#responsePago").text("Se a guardado correctamente el pago!");
                } else {
                    $("#responsePago").text("Ha ocurrido un problema al guardar el pago, intentelo nuevamente!");
                }
                $("#respuesta").modal('show');
            }
        });

        return false;
    }
//            );

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
                if (data != 2) {
                    $("#tb2").html(data); // Mostrar la respuestas del script PHP.               
                } else {
                    var Msg = 'No se encontraron resultados.';
                    alertAccess(Msg, 'alert-warning');
                    setTimeout(function () {
                    }, 3000);
                }
            }
        });
        return false;
    }
    
    function loadReport() {
        
        var url = "<?php echo BASE_URL; ?>includes/pagos_acreditados/Report.php";
        $.ajax({
            type: "POST",
            url: url,
            data: $("#validaPagos").serialize(), // Adjuntar los campos del formulario enviado.
            success: function (data)
            {
                $("#reporteSave").html(data);
                    $('#exampleModal').modal('show');
            }
        });
        return false;
    }
//        reporteSave -> contenedor
//    $('#exampleModal').modal('show');
    
</script>
