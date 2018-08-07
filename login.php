<?php
session_start();
isset($_SESSION['USUARIO']) ? header("Location: index.php") : NULL;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SISFAC</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" href="dist/img/pa2.png" type="image/ico" />
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

    <body class="login" style=" background-color: #F7F7F7;">
        <div>
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content" style=" background-color: #F7F7F7; margin-top: 8%; margin-left: 30%;margin-right: 30%; border-radius: 4px;">
                        <br>
                        <div class="text-center">
                            <img src="dist/img/pa2.png">
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">                                
                            </div>
                            <div class="col-md-4 text-center">                                
                                 <h2 style=" color: #73879C; display: inline"><i class="fa fa-lock"></i> Acceso</h2>
                            </div>                            
                        </div>
                        <hr style="border-color: #E5E5E5;">
                        <form method="POST" id="formTb1">                      
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <div>
                                        <input type="text" class="form-control" id="usrcompstat" name="usrcompstat" placeholder="Usuario" required="" />
                                        <br>
                                        <input id="passwordcompstat" type="password" class="form-control" name="passwordcompstat" placeholder="Password" required="" />
                                    </div>   
                                    <br>
                                    <div class="text-center">
<!--                                        <a id="changepwd" href="change_pwd.php" style=" font-weight: 400;"><span class="fa fa-lock"></span> Cambiar contrase&ntilde;a</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="https://paux.cdmx.gob.mx/" style=" font-weight: 400; text-decoration: none;"><span class="fa fa-exclamation-circle"></span> Problemas de acceso</a>-->
                                    </div>                            
                                    <br>                                    
                                    <div class="row text-center" >                                        
                                            <input class="btn btn-primary submit" type="submit" value="ACCESAR">                                                                                 
                                    </div>                                   
                                    <br>
                                    <div class="text-center">
                                        <h3 style=" color: #73879C; display: inline"><i class=""></i> SISFAC</h3>
                                        
                                        <div class="pull-center">
                                            <a style="text-decoration: none;" href="sectores.pa.cdmx.gob.mx:3128/intranet/intranet.php">Policía Auxiliar de la Ciudad de México.</a>
                                        </div>
                                        <br>
                                    </div> 
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                        </form>
                    </section>                     
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
        </div>
    </div>
        <!-- jQuery 3 -->
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.7 -->
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- Morris.js charts -->
        <script src="bower_components/raphael/raphael.min.js"></script>
        <script src="bower_components/morris.js/morris.min.js"></script>
        <!-- Sparkline -->
        <script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
        <!-- jvectormap -->
        <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
        <!-- daterangepicker -->
        <script src="bower_components/moment/min/moment.min.js"></script>
        <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!-- datepicker -->
        <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <!-- Slimscroll -->
        <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="dist/js/pages/dashboard.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js"></script>
    </body>
</html>
<script>   
    var $alerta = $("#alert");
    var $msg = $('#msg');
    $alerta.hide();
    $(".close").click(function () {
        $alerta.hide();
    });

    $('#formTb1').submit(function () {
        var url = "includes/Log/log.php";                
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
                        location.href = 'index.php';
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
        return false;
    });
</script>
