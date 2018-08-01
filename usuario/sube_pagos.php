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
</style>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">  
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style=" background-color: white;">
    <!--Titulos de encabezado de la pagina-->
    <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
        <h1 style="color: #1C4773">
            <i class=" fa fa-credit-card"></i>
            FACTURAS INICIALES Y PAGOS ACREDITADOS |
            <small>SUBIR PAGOS &nbsp;<i class="fa fa-upload "></i></small>
        </h1>                    
        <br>
    </section>

    <section class="content" >
        <!-- Small boxes (Stat box) -->
        <br>
        <div class="row pull-center">              
            <form id="formTb1" method="post">
                <div class="row">
                    <div class="col-lg-3 col-xs-3 text-center"></div>
                    <div class="col-lg-2 col-xs-2 text-center">
                        <label>FECHA</label>
                        <input id="fecha_pago" type="date" class="form form-control">
                    </div>

                    <div class="col-lg-2 col-xs-2 text-center">                                                  
                        <label>Monto: </label>
                        <input type="number" class="form form-control" id="monto_pago" name="monto_pago">
                    </div>                                    
                    <div class="col-lg-2 col-xs-2 text-center">                                                  
                        <label>Banco: </label>
                        <select id="banco_pago" name="banco_pago" class="form form-control">
                            
                            
                        </select>
                    </div>                                    
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-3 col-xs-3 text-center"></div>
                    <div class="col-lg-2 col-xs-2 text-center">                           
                        <label>Referencia: </label>
                        <input type="text" class="form form-control" id="referencia_pago" name="referencia_pago">
                    </div>           
                    <div class="col-lg-2 col-xs-2 text-center">
                        <label><h4 style="display: inline"><i class="fa fa-paperclip text-blue"></i></h4> &nbsp;Adjuntar baucher</label>
                        <input class="form form-control" type="file" id="baucher" name="baucher">
                    </div>
                    <div class="col-lg-2 col-xs-2 text-center">
                        <br>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> &nbsp;Subir pago</button>
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
</script>



