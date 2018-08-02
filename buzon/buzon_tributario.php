<?php
include_once '../config.php';
include_once '../head.html';
include_once '../menuLat.php';
?>                        
<style>
    .text1{
        color: #094F93 !important; 
        font-weight: 600 !important;
        font-size: 15px;
    }
    label{
        color: #525558 !important; 
        font-weight: 600 !important;
    }
    a{
        text-decoration: none;
    }

</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style=" background-color: white;">
    <!--Titulos de encabezado de la pagina-->
    <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
        <h1 style="color: #1C4773">
            <i class=" fa fa-credit-card"></i>
            BUZÓN TRIBUTARIO |
            <small>INBOX</small>
        </h1>                                     
        <br>
    </section>
    <!-- FIN DE Titulos de encabezado de la pagina-->                    
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <a href="compose.php" class="btn btn-primary btn-block margin-bottom">Redactar</a>                
                <div class="box" >
                    <div class="box-header with-border" style=" border-bottom-color: #3E5C81!important ">
                        <h3 class="box-title">NOTIFICACIONES</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class=" box-body  no-padding nav-tabs-custom">
                        <ul class="nav  nav flex-column ">
                            <li class="active" href="#tab1" data-toggle="tab" class="active"><a href="#"><label><i class="fa fa-inbox text-blue"></i> SERVICIOS</label>
                                    <span class="label label-primary pull-right">1</span></a>
                            </li>
                            <li href="#tab2" data-toggle="tab"><a href="#"> <label><i class="fa fa-envelope-o text-blue"></i> CANCELACIÓN DE PAGO</label>
                                <span class="label label-primary pull-right">1</span></a>
                            </li>
                            <li href="#tab3" data-toggle="tab"><a href="#"><label><i class="fa fa-file-text-o text-blue"></i> REPOSICIÓN DE FACTURA</label>
                                <span class="label label-primary pull-right">1</span></a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Inbox</h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="tab-content">
                        <div class="box-body no-padding tab-pane" id="tab1">
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                        <tr>
                                            <!--<td><input type="checkbox"></td>-->
                                            <td class="mailbox-star"><a href="#"><i class="fa fa-envelope-o text-blue"></i></a></td>
                                            <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                            <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                            </td>
                                            <td class="mailbox-attachment"></td>
                                            <td class="mailbox-date">5 mins ago</td>
                                        </tr>                                    
                                    </tbody>
                                </table>
                                <!-- /.table -->
                            </div>
                            <!-- /.mail-box-messages -->
                        </div>
                        <div class="box-body no-padding tab-pane" id="tab2">
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                        <tr>
<!--                                            <td><input type="checkbox"></td>-->
                                            <td class="mailbox-star"><a href="#"><i class="fa fa-envelope-o text-blue"></i></a></td>
                                            <td class="mailbox-name"><a href="read-mail.html">Carlos Pierce</a></td>
                                            <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                            </td>
                                            <td class="mailbox-attachment"></td>
                                            <td class="mailbox-date">5 mins ago</td>
                                        </tr>                                    
                                    </tbody>
                                </table>
                                <!-- /.table -->
                            </div>
                            <!-- /.mail-box-messages -->
                        </div>
                        <div class="box-body no-padding tab-pane" id="tab3">
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                        <tr>
                                            <!--<td><input type="checkbox"></td>-->
                                            <td class="mailbox-star"><a href="#"><i class="fa fa-envelope-o text-blue"></i></a></td>
                                            <td class="mailbox-name"><a href="read-mail.html">JUan Pierce</a></td>
                                            <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                            </td>
                                            <td class="mailbox-attachment"></td>
                                            <td class="mailbox-date">5 mins ago</td>
                                        </tr>                                    
                                    </tbody>
                                </table>
                                <!-- /.table -->
                            </div>
                            <!-- /.mail-box-messages -->
                        </div>
                    </div>
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
    <!--</div>-->    
    <div class="control-sidebar-bg"></div>
</div>                           
<div id="tb3"></div>
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

<?php include_once '../footer.html'; ?>

<script>

    var $alerta = $("#alert");
    var $msg = $('#msg');
    $alerta.hide();
    $("#tbpwd").hide();
    $("#tb1").hide();

    $(".close").click(function () {
        $alerta.hide();
    });

</script>