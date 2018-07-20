<?php
session_start();
isset($_SESSION['USUARIO']) ? header("Location: inicio.php") : NULL;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SISFAC</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">-->
        <!-- Ionicons -->
        <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="bower_components/morris.js/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

        <!-- Google Font -->
        <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">-->       
    </head>

    <body class="login" style=" background-color: #204367;">
        <div>
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content" style=" background-color: #F7F7F7; margin-top: 8%; margin-left: 25%;margin-right: 25%; border-radius: 3px;">
                        <br>
                        <div class="text-center">
                            <img src="dist/img/pa2.png">
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">                                
                            </div>
                            <div class="col-md-4 text-center">                                
                                 <h2 style=" color: #73879C; display: inline"><i class="fas fa-lock"></i> Acceso</h2>
                            </div>                            
                        </div>
                        <hr style="border-color: #E5E5E5;">
                        <form method="POST" id="formTb1">                      
                            <div>
                                <input type="text" class="form-control" id="usrcompstat" name="usrcompstat" placeholder="Usuario" required="" />
                            </div>
                            <div>
                                <input id="passwordcompstat" type="password" class="form-control" name="passwordcompstat" placeholder="Password" required="" />
                            </div>                            
                            <a id="changepwd" href="change_pwd.php" style=" font-weight: 400;"><span class="fa fa-lock"></span> Cambiar contrase&ntilde;a</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="https://paux.cdmx.gob.mx/" style=" font-weight: 400; text-decoration: none;"><span class="fa fa-exclamation-circle"></span> Problemas de acceso</a>                            
                            <div class="separator"></div>
                            <div class="row" > 
                                <div class="col-md-3"></div>
                                <div class="col-md-2">
                                    <input class="btn btn-success submit" type="submit" value="ACCESAR">                                         
                                </div>
                            </div>
                            <div class="clearfix"></div>                            
                                           
                                <div class="clearfix"></div>
                                <br />
                                <div>
                                    <h1><i class=""></i> COMPSTAT</h1>
                                    <div class="pull-center">
                                        <a href="sectores.pa.cdmx.gob.mx:3128/intranet/intranet.php">Policía Auxiliar de la Ciudad de México.</a>
                                    </div>
                                </div>                            
                        </form>
                    </section> 
                    <div class="text-center">
                        <img id="load" src="images/load.gif" />
                    </div>
                    <div class="" id="alert">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>Mensaje: </strong>
                        <div id="msg"></div>
                    </div>                    
                </div>
            </div>       
        </div>
    </div>
</body>    
</html>
<script src="vendors/jquery/dist/jquery.min.js"></script>
<script>
    var $loader = $('#load');
    $loader.hide();
    var $alerta = $("#alert");
    var $msg = $('#msg');
    $alerta.hide();
    $(".close").click(function () {
        $alerta.hide();
    });

    $('#formTb1').submit(function () {
        var url = "includes/Log/log.php";
        $loader.show();
        $.ajax({
            type: "POST",
            url: url,
            data: $("#formTb1").serialize(), // Adjuntar los campos del formulario enviado.
            success: function (data)
            {
                console.log(data);

                if (data == 1) {
                    $alerta.removeClass();
                    $alerta
                            .addClass('alert')
                            .addClass('alert-success')
                            .addClass('alert-dismissible');
                    $msg.text('Acceso correcto!.');
                    $alerta.show();
                    setTimeout(function () {
                        $alerta.hide();
                        location.href = 'inicio.php';
                    }, 1500);
                } else {
                    document.getElementById('passwordcompstat').value = '';
                    $alerta.removeClass();
                    $alerta.addClass('alert alert-warning alert-dismissible');
                    $msg.html('<b>Error de acceso:</b><br/> Usuario o contrase&ntilde;a incorrecto!.');
                    $alerta.show();
                    setTimeout(function () {
                        $alerta.hide()
                    }, 4000);
                }
            }
        });
        $loader.hide();
        return false;
    });
</script>
