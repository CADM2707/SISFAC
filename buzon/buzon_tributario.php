<?php
include_once '../config.php';
include_once '../head.html';
include_once '../menuLat.php';
$cliente=$_SESSION['CLIENTE'];
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
    .select2-selection__choice{
        background-color: #28B463 !important;
        color: #EAECEE !important;        
    }
    .select2-selection__choice__remove{
        color: #D5D8DC !important;
    }
</style>
<link rel="stylesheet" href="../bower_components/select2/dist/css/select2.min.css">
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
                <a href="#" id="redactar" onclick="cambio()" class="btn btn-primary btn-block margin-bottom"> Redactar </a>                
                <a href="#" id="redactar2" onclick="cambio()" class="btn btn-primary btn-block margin-bottom" style=" display: none"> Inbox </a>                
                <div id="boxed" class="box" >
                    <div class="box-header with-border" style=" border-bottom-color: #3E5C81!important ">
                        <h3 class="box-title">NOTIFICACIONES</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class=" box-body  no-padding nav-tabs-custom">
                        <ul class="nav  nav flex-column ">
                            <li class="active" href="#tab1" data-toggle="tab" class="active" id="Serv"><a href="#"><label><i class="fa fa-inbox text-blue"></i> SERVICIOS</label>
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
            <div class="col-md-9" id="inbox">
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
            <div class="col-md-9" style=" display: none;" id="newMsg">
                
                    <div class="box box-primary">
                        <form method="POST" id="frmMsj">  
                        <input id="user" type="hidden" value="<?php echo $cliente; ?>">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nuevo mensaje</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group">
                              <!--<input class="form-control" placeholder="Para:">-->
                                <div class="form-group">
                                    <label>Destinatario:</label>
                                    <select  required="true" class="form form-control select2" name="dest" id="dest"  multiple="multiple" data-placeholder="Para:" style="width: 100%;">

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Asunto:</label>
                                <input name="Asunto" id="Asunto" required="true" class="form-control" placeholder="Asunto:">
                            </div>
                            <div class="form-group">
                                <label>Contenido del mensaje:</label>
                                <textarea name="mensaje" id="mensaje"  required class="form form-control" rows="14">                      
                                </textarea>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="pull-right">
                                <label onclick="cambio();$('#frmMsj')[0].reset(); " type="button" class="btn btn-default"><i class="fa fa-close"></i> Cancelar</label>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Enviar</button>
                            </div>
                            <!--<button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>-->
                        </div>

                        <!-- /.box-footer -->
                        </form>
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
    $('.select2').select2();
    $(".close").click(function () {
        $alerta.hide();
    });
    $( "#Serv" ).click();
    $('#mensaje').val('');
    loadDest();


function cambio(){
    $('#newMsg').toggle();
    $('#inbox').toggle();
    if($('#redactar').text()=='Inbox'){
        $('#redactar').text('Redactar');
        $('#boxed').removeClass('collapsed-box');        
    }else{ 
        $('#redactar').text('Inbox');
        $('#boxed').addClass('collapsed-box');
    }
    clearForm();
//    $('#redactar2').toggle();
}

function loadDest(){
        var cliente=$('#user').val();        
        var url = "<?php echo BASE_URL; ?>includes/Buzon/buzon_Options.php";        
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'html',
            data: {
                CLIENTE:cliente,
                DESTINATARIO:1
            },           
            success: function (data)
            {
//                console.log(data);         
                $('#dest').html(data);
            }
        });

        return false;
}

//frmMsj
 $('#frmMsj').submit(function () {
     
        var myTest = new Array();
        myTest = $("#dest").val();
           
        var Url = "<?php echo BASE_URL; ?>includes/Buzon/sendMail.php";        
        $.ajax({
            url:    Url,
            type: "POST",           
            data:{
                DESTINATARIO:myTest,
                ASUNTO:$('#Asunto').val(),
                CONTENIDO:$('#mensaje').val(),
            },
            success: function (data)
            {        
                console.log(data);
                if(data==1){                     
                   clearForm();
                }else if(data==2){
                     
                }else if(data==3 || data !=""){
                    
                }                                 
            }
        });
//           var myTest = new Array();
//           myTest = $("#dest").val();
//           console.log(myTest[0]);
        return false;
    });
    
    function clearForm(){
        $("#frmMsj")[0].reset();
        $('#dest').val(null).trigger('change');
        $('#mensaje').val('');
    }
    
//    select2


</script>