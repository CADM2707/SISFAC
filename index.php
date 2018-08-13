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
                        SISTEMA FACTURACIÓN
                        <small>Panel de control</small>
                    </h1>                    
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center">                           
                         
						 
						 
						 <div class="col-md-9"  id="newMsg">
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
                                    <label>Usuario a buscar:</label>
                                    <select  required="true" class="form form-control select2" name="dest" id="dest" onclick="loadDest()"  multiple="multiple" data-placeholder="Para:" style="width: 100%;">

                                    </select>
                                </div>
                            </div>
                           

                        </div>
                           
                        <!-- /.box-body -->
                       

                        <!-- /.box-footer -->
                    </form>
                </div>
                <!-- /. box -->
            </div>
						 
						 
						 
						 
						 
						 
						
						
						
						
						
						
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



