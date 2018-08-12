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
        <br>
        <div class="row pull-center">
            <form id="formTb1" method="post" >
                <div class="row">
                    <div class="col-lg-3 col-xs-3 text-center"></div>
                    <div class="col-lg-2 col-xs-2 text-center">
                        <label>AÑO: </label>
                        <select id="ayo" name="ayo" class="form form-control">
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
                        <select id="TipoPago" name="TipoPago" class="form form-control" >
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
                </div><hr>
            </form>
            <div class="row" style=" margin: 5px;">
                <div class="col-lg-12 col-xs-12 text-center">
                    <div id="tb1"></div>
                </div>
            </div>
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
                                <div class="row pull-center" style="margin: 5px;">
                                    <div class="col-lg-1 col-xs-1 text-center"></div>
                                    <div class="col-lg-2 col-xs-2 text-center">
                                        <label style="font-weight: 600; color: #2471A3;">ID PAGO</label>
                                        <input style=" background-color: #FFF3C3;" type="text" disabled="true" id="idPagoAsigna" class="form form-control text-center">
                                    </div>
                                    <div class="col-lg-2 col-xs-2 text-center">
                                        <label style="font-weight: 600; color: #2471A3;">AÑO DE PAGO</label>
                                        <input style=" background-color: #FFF3C3;" type="text" disabled="true" id="idAyoAsigna" class="form form-control text-center">
                                    </div>
                                    <div class="col-lg-2 col-xs-2 text-center">
                                        <label style="font-weight: 600; color: #2471A3;">MONTO</label>
                                        <input type="text" disabled="true" style=" background-color: #FFF3C3;"  id="montoAsigna" class="form form-control text-center">
                                    </div>                                
                                    <div class="col-lg-2 col-xs-2 text-center">
                                        <label style="font-weight: 600; color: #2471A3;">MONTO APLICADO</label>
                                        <input type="text" disabled="true" style=" background-color: #FFF3C3;"  id="montoAplicado" class="form form-control text-center">
                                    </div>                                
                                    <div class="col-lg-2 col-xs-2 text-center">
                                        <label style="font-weight: 600; color: #2471A3;">MONTO POR APLICAR</label>
                                        <input type="text" disabled="true" id="montoPorAplicar" class="form form-control text-center">
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
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!--                <button type="button" class="close" data-dismiss="modal" style=" background-color: black;">&nbsp&nbsp;&times;&nbsp&nbsp;</button>-->
                        </div>
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
 $(".close").click(function () {
    $alerta.hide();
 });
    
    
    
function updateMPA(id,importe,pago,saldo){
           
    var mPAplicar=$("#montoPorAplicar").val();
    var mAplicado=$("#montoAplicado").val();
    var monto=$("#montoAsigna").val();
    var mAsignado=$('#'+id).val();
    
//    console.log(mPAplicar);
//    console.log(mAplicado);
//    console.log(monto);
//    console.log(mAsignado);
    
        var url = "<?php echo BASE_URL; ?>includes/pagos_acreditados/preAsignaPago.php";
        $.ajax({
            type: "POST",
            url: url,
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
                console.log(data);
                if(data==2){
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
                }
            }
        });
    
    return false;
}
    function AsignaPagoPago(id_pago, cont, ayo_pago,color) {  
        if(color==1){
            $("#montoPorAplicar").removeClass('bg-color-Beige')
                                 .removeClass('bg-color-red')
                                 .addClass('bg-color-green');
        }else if(color>0){
            $("#montoPorAplicar").removeClass('bg-color-green')
                                 .removeClass('bg-color-red')
                                 .addClass('bg-color-Beige');            
        }else if(color<0){            
            $("#montoPorAplicar").removeClass('bg-color-green')
                                 .removeClass('bg-color-Beige')
                                 .addClass('bg-color-red');                        
        }
        monto = $('#'+cont).val();
        montoA = $('#MA'+cont).val();
        montoPA = $('#MPA'+cont).val();
        $('#myModalCharts').modal('show');
        $("#idPagoAsigna").val(id_pago);
        $("#idAyoAsigna").val(ayo_pago);        
        $("#montoAsigna").val(monto);
        $("#montoAplicado").val(montoA);
        $("#montoPorAplicar").val(montoPA);
        loadPagos();
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
    
    function loadPagos(){        

        var url = "<?php echo BASE_URL; ?>includes/pagos_acreditados/load_pagos.php";
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
    
    function ValidarPago (){
        console.log("Exito");
        return false;
    }
    
    
</script>
