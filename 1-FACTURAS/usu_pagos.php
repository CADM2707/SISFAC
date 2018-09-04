<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
?>           
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">  
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
                </section><br>
                <div id="tb4" ></div><hr>
                <section class="content" >                    
                <!-- Small boxes (Stat box) -->
                <div class="row pull-center">              
                    <form id="formTb1" method="post"><br>
                        <div class="col-lg-2 col-xs-2 text-center"></div>
<!--                        <div class="col-lg-2 col-xs-2 text-center">
                            <label>ID USUARIO</label>
                            
                        </div>-->
                              <input required="true" placeholder="ID DE USUARIO" id="id_usuario" type="hidden" value="<?php echo $nombre ?>" class="form form-control">
                        <div class="col-lg-2 col-xs-2 text-center">                                                  
                            <label>AÑO: </label>
                            <select id="ayo" name="ayo" class="form form-control" onchange="">                                
                                <option disabled="true" selected="true" value=""> Selecciona </option>
                                <?php
                                for ($i = date('Y'); $i >= 2000; $i--) {
                                    echo "<option value='$i'> $i </option>";
                                }
                                ?>                            
                            </select>
                        </div>                                    
                        <div class="col-lg-3 col-xs-3 text-center">                                                  
                            <!--<label>PERIODO FACTURA: </label>-->
                            <select id="fechas" name="fechas" class="form form-control" style=" margin-bottom: 5px;">                                
                                <option selected="true" value=""> Selecciona </option>
                                <option value="1"> PERIODO FACTURA </option>
                                <option value="2"> FECHA DE EMISIÓN </option>                                                       
                            </select>
                            <div class="row">
                                
                                <div class="col-lg-6 col-xs-6 text-center"> 
                                    <input id="p1" type="date" class="form form-control">
                                </div>
                                <div class="col-lg-6 col-xs-6 text-center"> 
                                    <input id="p2" type="date" class="form form-control">
                                </div>
                                
                            </div>
                        </div>                                    
                        <div class="col-lg-2 col-xs-2 text-center">                           
                            <label>SITUACIÓN: </label>
                            <select id="situacion" name="situacion" class="form form-control">
                                <option selected="true" value=""> Selecciona </option>
                                <option value="PAGADA"> PAGADA </option>
                                <option value="NO PAGADA"> PENDIENTE DE PAGO </option>
                            </select>
                        </div>           
                        <div class="col-lg-1 col-xs-1 text-center">
                            <br>
                            <!--<button class="btn btn-success"><i class="fa  fa-search"></i> Buscar</button>-->
                            <input onclick="clear()" class="btn btn-success" type="submit" value="Buscar">
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
                    </div>
                </div>
                <div class="row">
                     <div id="tb2" ></div>
                        <div id="tb1" class="col-lg-12 col-xs-12 table-responsive"></div> 
                </div>
                <div>
                    <div class="modal fade" id="myModalCharts" role="dialog">
                        <div class="modal-dialog mymodal modal-lg" style=" width: 75% !important">         
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header title_left" style=" background-color: #2C3E50;">
                                    <button type="button" class="close" data-dismiss="modal" style=" background-color: white;">&nbsp&nbsp;&times;&nbsp&nbsp;</button>
                                    <h4 class="modal-title" style=" color: white;"><img width="2%"  src="<?php echo BASE_URL;?>dist/img/pa2.png"><center></center></h4>
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
                <input  placeholder="ID DE USUARIO" id="id_usuario" type="hidden" value="<?php echo $nombre ?>" class="form form-control">
            </div>            
            <?php include_once '../footer.html'; ?>
            <script>  
var $alerta = $("#alert");
    var $msg = $('#msg');
    $alerta.hide();
    $(".close").click(function () {
        $alerta.hide();
    });
    usuario();
    $('#formTb1').submit(function () {
        load();
        usuario();
        var url = "<?php echo BASE_URL; ?>includes/Facturas_Iniciales/Consulta_Facturas.php";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                AYO: $("#ayo").val(),
                SITUACION: $("#situacion").val(),
                PERIODO1:$('#p1').val(),
                PERIODO2:$('#p2').val(),
                USUARIO:$('#id_usuario').val(),
                FECHAS:$('#fechas').val(),
            }, // Adjuntar los campos del formulario enviado.
            success: function (data)
            {                
                      if (data == 1) {
                    $alerta.removeClass();
                    $alerta
                            .addClass('alert')
                            .addClass('alert-warning')
                            .addClass('alert-dismissible');
                    $msg.text('No se encontraron resultados!.');
                    $alerta.show();
                    setTimeout(function () {
                        $alerta.hide();                        
                    }, 2500);                
                }else{
                    $("#tb1").html(data); // Mostrar la respuestas del script PHP.  
                    $('#tableRes').DataTable({
                                "language":{
                                    "sProcessing":     "Procesando...",
                                    "sLengthMenu":     "Mostrar _MENU_ registros",
                                    "sZeroRecords":    "No se encontraron resultados",
                                    "sEmptyTable":     "Ningún dato disponible en esta tabla (Sin resultados de busqueda)",
                                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                                    "sInfoPostFix":    "",
                                    "sSearch":         "Buscar:",
                                    "sUrl":            "",
                                    "sInfoThousands":  ",",
                                    "sLoadingRecords": "Cargando...",
                                    "oPaginate": {
                                            "sFirst":    "Primero",
                                            "sLast":     "Último",
                                            "sNext":     "Siguiente",
                                            "sPrevious": "Anterior"
                                    },
                                    "oAria": {
                                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                                    }
                                }                                 
                    });        
                }
                    $("#ModalLoad").modal('hide');                                                    
            }
        });

        return false;
    });
    
//    ***********************DATOS USUARIO******************************************
    function usuario(){
        
        var url = "<?php echo BASE_URL; ?>includes/Facturas_Iniciales/search_usu.php";
             $.ajax({
            type: "POST",
            url: url,
            data: {
                ID_USUARIO: $('#id_usuario').val()                
            }, // Adjuntar los campos del formulario enviado.
            success: function (data)
            {
                $("#tb2").html(data); // Mostrar la respuestas del script PHP.                
                $("#tb1").html(''); // Mostrar la respuestas del script PHP.                                                         
            }
        });

        return false;
    }
    
//    **************************** VER RECIBO **********************************************
    function verPago (idRecibo,ayo){
        
        $('#myModalCharts').modal('show');
        
         var url = "<?php echo BASE_URL; ?>includes/Facturas_Iniciales/displayRecibos.php";
             $.ajax({
            type: "POST",
            url: url,
            data: {
                ID_RECIBO: idRecibo,
                AYO_RECIBO:ayo
            }, // Adjuntar los campos del formulario enviado.
            success: function (data)
            {
                $("#tbPagos").html(data); // Mostrar la respuestas del script PHP.                                
                
                  $('#tablePagos').DataTable({  
                      "language":{
                                    "sProcessing":     "Procesando...",
                                    "sLengthMenu":     "Mostrar _MENU_ registros",
                                    "sZeroRecords":    "No se encontraron resultados",
                                    "sEmptyTable":     "Ningún dato disponible en esta tabla (Sin resultados de busqueda)",
                                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                                    "sInfoPostFix":    "",
                                    "sSearch":         "Buscar:",
                                    "sUrl":            "",
                                    "sInfoThousands":  ",",
                                    "sLoadingRecords": "Cargando...",
                                    "oPaginate": {
                                            "sFirst":    "Primero",
                                            "sLast":     "Último",
                                            "sNext":     "Siguiente",
                                            "sPrevious": "Anterior"
                                    },
                                    "oAria": {
                                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                                    }
                                }       
                    });
            }
        });

        return false;
    }
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
    
    

            </script>



