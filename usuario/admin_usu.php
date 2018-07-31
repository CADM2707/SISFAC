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
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style=" background-color: white;">
    <!--Titulos de encabezado de la pagina-->
    <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
        <h1 style="color: #1C4773">
            <i class=" fa fa-credit-card"></i>
            ADMINISTRAR CUENTA DE USUARIO |
            <small>Editar usuario</small>
        </h1>                                     
        <br>
    </section>
    <!-- FIN DE Titulos de encabezado de la pagina-->                
    <section class="content" >
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12 col-xs-12 text-center">                           
                <form id="formTb1" method="post">
                    <div class="col-lg-4 col-xs-4 text-center"></div>
                    <div class="col-lg-2 col-xs-2 text-center">
                        <label>ID USUARIO</label>
                        <input placeholder="ID DE USUARIO" id="id_usuario" type="text" class="form form-control">
                    </div>                                                                                                                          
                    <div class="col-lg-1 col-xs-1 text-center">
                        <br>
                        <!--<button class="btn btn-success"><i class="fa  fa-search"></i> Buscar</button>-->
                        <input onclick="clear()" class="btn btn-success" type="submit" value="Buscar">
                    </div>
                </form>                
                
            </div>
            <div class="col-lg-12 col-xs-12 text-center">
                <hr style=" border-color: #B0B3B6">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-1 col-xs-1 text-center"></div>
            <div class="col-lg-10 col-xs-10 text-center">                  
                <div id="tb2" ></div>
                <br>                
                <div id="tb1">
                    <div class="row">
                    <div class="col-md-12">
                        <!--<hr style="border-color: #B0B3B6 !important;">-->
                        <!-- Custom Tabs -->
                        <div class="nav-tabs-custom" style=" border: solid 1px #B0B3B6 !important;">
                            <ul class="nav nav-tabs">
                                <li class="active" onclick="resetForm('#pwdchange')"><a class="text1" href="#tab_1" data-toggle="tab"><i class="fa fa-key"></i> &nbsp;CAMBIAR CONTRASEÑA</a></li>
                                <li onclick="resetForm('#encargadoChange')"><a class="text1" href="#tab_2" data-toggle="tab"><i class="fa fa-user"></i> &nbsp;DATOS DE CONTACTO</a></li>
                                <li onclick="resetForm('#bancoChange')"><a class="text1" href="#tab_3" data-toggle="tab"><i class="fa fa-bank"></i> &nbsp;DATOS BANCARIOS</a></li>              
                                <!--<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>-->
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active text-left" id="tab_1">                                    
                                    <br>                                    
                                    <form method="POST" id="pwdchange">
                                        <input type="hidden" id="id_usu1" name="id_usu1">
                                        <div class="row">
                                        <div class="col-lg-1 col-xs-1 text-center"></div>
                                        <div class="col-lg-3 col-xs-3 text-center">
                                            <label><i class="fa fa-lock"></i> &nbsp;CONTRASEÑA ACTUAL</label>
                                            <input id="actual" required="" name="actual" type="password" class="form form-control">
                                        </div>                                        
                                        <div class="col-lg-3 col-xs-3 text-center">
                                            <label><i class="fa fa-lock"></i> &nbsp;NUEVA CONTRASEÑA</label>
                                            <input id="nueva" required="" name="nueva" type="password" class="form form-control">
                                        </div>                                        
                                        <div class="col-lg-3 col-xs-3 text-center">
                                            <label><i class="fa fa-lock"></i> &nbsp;REPETIR NUEVA CONTRASEÑA</label>
                                            <input id="" required="" name="confirma" type="password" class="form form-control">
                                        </div>
                                        <div class="col-lg-2 col-xs-2 text-center">
                                            <br>
                                            <button class="btn btn-primary" name="paswd" value="1" type="submit"><i class="fa fa-key"></i> CAMBIAR</button>
                                            <!--<input class="btn btn-primary" name="paswd" id="paswd"  type="submit" value="CAMBIAR">-->
                                        </div>
                                    </div>  
                                    </form>  
                                    <br>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane text-left" id="tab_2">
                                    <br>                                    
                                    <form method='POST' id='encargadoChange'>
                                        <input type='hidden' id='id_usu2' name='id_usu2'>
                                        <div class='row'>
                                            <div class='col-lg-1 col-xs-1 text-center'></div>  
                                            <div id="tab_22"></div>
                                            <div class='col-lg-2 col-xs-2 text-center'>
                                                <br>
                                                <button class='btn btn-primary' type='submit'><i class='fa fa-save'></i> &nbsp;ACTUALIZAR</button>
                                            </div>
                                        </div> 
                                    </form>   
                                    <br>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane text-left" id="tab_3">
                                    <br>                                    
                                    <form method="POST" id="bancoChange">
                                        <input type="hidden" id="id_usu3" name="id_usu3">
                                        <div class="row" id="banco_usuario">
                                        </div>
                                    </form>    
                                    <br>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- nav-tabs-custom -->
                    </div>         
                </div>
                </div>                
            </div>
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
    </section>
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

    $('#formTb1').submit(function () {
        usuario();        
        return false;
    });
    
    $('#pwdchange').submit(function () {
//        alert('CAMBIOS CUENTA');
        var url = "<?php echo BASE_URL; ?>includes/admin_Cuenta/admin_cuenta.php";
        $.ajax({
            type: "POST",
            url: url,
            data: $(this).serialize(), // Adjuntar los campos del formulario enviado.
            success: function (data)
            {
                console.log(data);
                               if (data == 1) {
                        var Msg = 'Contrase&ntilde;a actualizada correctamente.';
                        alertAccess(Msg,'alert-success');
                        setTimeout(function () {                            
                        }, 3000);
                    }
                 if (data == 2) {
                        var Msg = 'La nueva contraseña no coincide con la de confirmacion.';
                        alertAccess(Msg,'alert-warning');
                        setTimeout(function () {                            
                        }, 3000);
                    }
                 if (data == 3) {
                        var Msg = 'La nueva contraseña es igual a la contraseña actual.';
                        alertAccess(Msg,'alert-warning');
                        setTimeout(function () {                            
                        }, 3000);
                    }                                                                   
            }
        });        
        return false;
    });
    
    $('#encargadoChange').submit(function () {
        
                var url = "<?php echo BASE_URL; ?>includes/admin_Cuenta/admin_cuenta.php";
        $.ajax({
            type: "POST",
            url: url,
            data: $(this).serialize(), // Adjuntar los campos del formulario enviado.
            success: function (data)
            {
                console.log(data);
                               if (data == 1) {
                        var Msg = 'Datos actualizados correctamente.';
                        alertAccess(Msg,'alert-success');
                        setTimeout(function () {                            
                        }, 3000);
                    }
                 if (data == 2) {
                        var Msg = 'Los datos no se guardaron.';
                        alertAccess(Msg,'alert-warning');
                        setTimeout(function () {                            
                        }, 3000);
                    }                                                                 
            }
        });                
        return false;
        
    });
    $('#bancoChange').submit(function () {
         var url = "<?php echo BASE_URL; ?>includes/admin_Cuenta/admin_cuenta.php";
        $.ajax({
            type: "POST",
            url: url,
            data: $('#bancoChange').serialize(), // Adjuntar los campos del formulario enviado.
            success: function (data)
            {
                console.log(data);
                               if (data == 1) {
                        var Msg = 'Datos actualizados correctamente.';
                        alertAccess(Msg,'alert-success');
                        setTimeout(function () {                            
                        }, 3000);
                    }
                 if (data == 2) {
                        var Msg = 'Los datos no se guardaron.';
                        alertAccess(Msg,'alert-warning');
                        setTimeout(function () {                            
                        }, 3000);
                    }                                                                 
            }
        });               
        return false;
    });


//    ***********************DATOS USUARIO******************************************
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
                $("#tb2").html(data); // Mostrar la respuestas del script PHP.
                $("#id_usu1").val($('#id_usuario').val());
                $("#id_usu2").val($('#id_usuario').val());
                $("#id_usu3").val($('#id_usuario').val());
                datosContacto();
//                displayTipoP();
                displayBank();
                $("#tb1").show();                
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
//    ************************************ LIMPIA FORMULARIOS ***********************************************
function resetForm(form1){
    $(form1)[0].reset();    
}

    function alertAccess(Msg,tipo) {
        $alerta.removeClass();
        $alerta
                .addClass('alert')
                .addClass(tipo)
                .addClass('alert-dismissible');
        $msg.text(Msg);
        $alerta.show();
        setTimeout(function () {
            $alerta.hide();
        }, 3000);
    }
//    ************************************** Buscar datos contacto    *****************************************
function datosContacto(){
    
        var url = "<?php echo BASE_URL; ?>includes/admin_Cuenta/searchDatos.php";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                ID_USUARIO: $('#id_usuario').val(),                
            }, // Adjuntar los campos del formulario enviado.
            success: function (data)
            {                
                $("#tab_22").html(data); // Mostrar la respuestas del script PHP.
                $("#id_usu2").val($('#id_usuario').val());
            }
        });
        
        return false;
}

function displayBank(){    
            var url = "<?php echo BASE_URL; ?>includes/admin_Cuenta/searchDatos.php";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                BANK: 1,
                ID_USUARIO:$('#id_usuario').val()
            }, // Adjuntar los campos del formulario enviado.
            success: function (data)
            {                
                $("#banco_usuario").html(data); // Mostrar la respuestas del script PHP.                
            }
        });
        
        return false;
}
//function displayTipoP(){    
//            var url = "<?php echo BASE_URL; ?>includes/admin_Cuenta/searchDatos.php";
//        $.ajax({
//            type: "POST",
//            url: url,
//            data: {
//                PAGO: 1,
//            }, // Adjuntar los campos del formulario enviado.
//            success: function (data)
//            {                
//                $("#tipo_pago").html(data); // Mostrar la respuestas del script PHP.                
//            }
//        });
//        
//        return false;
//}
</script>