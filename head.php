<!DOCTYPE html>
 <?php include_once ('config.php');?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SISFAC</title>
        <link rel="icon" href="<?php echo BASE_URL;?>dist/img/pa2.png" type="image/ico" />
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo BASE_URL;?>bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo BASE_URL;?>bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo BASE_URL;?>bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo BASE_URL;?>dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo BASE_URL;?>dist/css/skins/_all-skins.min.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="<?php echo BASE_URL;?>bower_components/morris.js/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="<?php echo BASE_URL;?>bower_components/jvectormap/jquery-jvectormap.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="<?php echo BASE_URL;?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?php echo BASE_URL;?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?php echo BASE_URL;?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition skin-blue sidebar-mini" style="background-color: #323C48">
        <div class="text-center">
            <img src="<?php echo BASE_URL;?>dist/img/angel.jpg" width="40%;">
        </div>
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo BASE_URL;?>index.php" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>Sis</b>FAC</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>FACTURACIÓN</b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">                         
                            <!-- User Account: style can be found in dropdown.less -->  
                            <li class="dropdown messages-menu">
                                <a href=""><i class="fa fa-home"></i> Inicio</a>   
<!--                                <ol class="breadcrumb">
                                    <li style="font-size: ">
                                        <a href=""><i class="fa fa-home"></i> Inicio</a>
                                    </li>
                                </ol>-->
                            </li>
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style=" text-decoration: none !important; height: 100%;">
                                    <?php echo $nombre ?>
                                    <img src="<?php echo BASE_URL;?>dist/img/avatar5.jpg" class="user-image" alt="User Image">
                                    <span class="hidden-xs"></span>
                                    <br>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?php echo BASE_URL;?>dist/img/avatar5.jpg" class="img-circle" alt="User Image">

                                        <p>
                                            <?php echo $nombre ?> - Web Developer
                                            <small>Member since Nov. 2012</small>
                                        </p>
                                    </li>                                    
                                    <!-- Menu Footer-->
                                    <li class="user-footer">                                     
                                        <div class="text-center">
                                            <a href="<?php echo BASE_URL ?>" class="btn btn-success btn-flat">Cerrar sesión</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>                                                       
                        </ul>
                    </div>
                </nav>
            </header>
			<?php include_once ('menuLat.php');?>