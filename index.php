<?php
    include_once 'config.php';
    include_once 'head.html';
    include_once 'menuLat.php';
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
    .unread {
 font-weight:800;
}
.textFont{
    font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif ;
}
</style>   
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/bower_components/select2/dist/css/select2.min.css">   
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">               
            <!-- Content Wrapper. Contains page content -->
            
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        SISTEMA FACTURACIÓN Y COBRANZA
                        <small>Panel de control</small>
                    </h1>                    
                    <br>
                </section>
<!--                <a data-fancybox data-type="iframe" data-src="https://mozilla.github.io/pdf.js/web/viewer.html">
                            Example #3 - Sample PDF file
                        </a>-->
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center">                                                   
                        <img style=" border-radius: 5px; " width="100%" src="dist/img/sisfac.jpg">
                            <!-- /. box -->                        
                    </div>                                    
                </div>                
            </section>
            </div>            
            <?php include_once 'footer.html'; ?>
            <script>
		 $('.select2').select2();

		function loadDest() {
				 
        var url = "<?php echo BASE_URL; ?>includes/Buzon/buzon_Options_op.php";
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'html',
            data: {
                
            },
            success: function (data)
            {
                $('#dest').html(data);
            }
        });

        return false;
    }
            </script>



