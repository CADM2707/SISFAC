<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
	
	?>  
   
  
  <?php
  
  //CONSULTAS	---		CONSULTAS	---		CONSULTAS	---		CONSULTAS	---
	$sql_ayo="select DISTINCT(ayo)  from seCTOR.DBO.C_PERIODO_QNAS";       
	$res_ayo = sqlsrv_query($conn,$sql_ayo); 
	
	$sql_qna="select distinct(QNA) Qna from sector.dbo.C_Periodos_Facturacion";       
	$res_qna = sqlsrv_query($conn,$sql_qna);
	
	?>
                     <form  method="POST" class="centrado" >
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        APERTURA FACTURACION
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li style="font-size: ">
                            <a href=""><i class="fa fa-home"></i> Inicio</a>
                        </li>
                    </ol>
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center">   
                       <!-- <div id="cont">
                            Hola Soy un toggle
                        </div> -->
                        
                        <div class="row" >
                
                <div  class="col-md-3 col-sm-3 col-xs-3"><br></div>
                       
               <div  class="col-md-3 col-sm-3 col-xs-3"><br>
							<center><label>AÑO:</label></center>
							<select name="usuario" required class="form-control" style="text-align:center;"  onchange="es_vacio()"   id="ayo"  onBlur="es_vacio()" >
								<option value="" selected="selected">SELECC...</option>
								<?php	while($row_ayo = sqlsrv_fetch_array($res_ayo)){ 		?>
									<option value="<?php echo @$row_ayo['ayo']; ?>" ><?php echo @$row_ayo['ayo']; ?></option>
								<?php } ?>
							</select>
						</div>
                        
                        
                        <div  class="col-md-3 col-sm-3 col-xs-3"><br>
							<center><label>QUINCENA:</label></center>
							<select name="fac" required class="form-control" style="text-align:center;"  onchange="es_vacio2()"   id="fac"  onBlur="es_vacio2()" >
								<option value="" selected="selected">SELECC...</option>
								<?php	while($row_qna = sqlsrv_fetch_array($res_qna)){ 		?>
									<option value="<?php echo @$row_qna['Qna']; ?>" ><?php echo @$row_qna['Qna']; ?></option>
								<?php } ?>
							</select>
						</div>		
            
           
            <div  class="col-md-3 col-sm-3 col-xs-3"><br></div>
            
            
            <div  class="col-md-12 col-sm-12 col-xs-12"><br>
				<!--<button  type="button" onclick="detalle()" value="reporte" class="btn btn-primary center-block" data-target='#myModalCharts'></button>-->
                <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#myModalCharts'>APERTURAR</button>
                <br><br>
			</div>            
            
              <div class="modal fade" id="myModalCharts" role="dialog">
                        <div class="modal-dialog mymodal modal-lg" style=" width: 55% !important">         
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header title_left" style=" background-color: #2C3E50;">
                                    <button type="button" class="close" data-dismiss="modal" style=" background-color: white;">&nbsp&nbsp;&times;&nbsp&nbsp;</button>
                                    <h4 class="modal-title" style=" color: white;"><img width="2%"  src="../dist/img/pa2.png"><center></center></h4>
                                </div>
                                <div style="text-align: center"><br>
                                    <h4 style=" color: #1B4C7C; font-weight: 600">APERTURA DE FACTURACION.</h4><hr>
                                </div>  
                                <div class="col-md-12">
                                    <div class="text-center"><h4>¿Estas seguro de APERTURAR la facturacion?</h4></div>
                                </div>
                                <div class="modal-footer">   
                            <button name="btn"  value="cancelar" onclick="cancel(<?php echo $id; ?>, <?php echo $a;?>)" type="button" class="btn btn-success" data-dismiss="modal">APERTURAR</button>
		                       <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
                                </div>
                            </div>      
                        </div>
                    </div>
            
            <div id="tb3" style="display: none;"></div>
            
            <div id="tb4" style="display: none;"></div>

                    </div>   
            
                </div>                
            </section>
            </div>
            </form>
            <?php include_once '../footer.html'; ?>
           
<script>
function detalle(){
	var ayo = document.getElementById("ayo").value;
	var fac = document.getElementById("fac").value;
	if(ayo >0 & fac >0){
		
        var url = "<?php echo BASE_URL; ?>includes/FACTURACION/sec_fac.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Ayo: $('#ayo').val(),
				Fac: $('#fac').val()
				
            },
            success: function (data)
            {
                $("#tb3").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("tb3").style.display="block";                  
            }
        });
        

//        $('#myModaldestto').modal('show');
	}else {document.getElementById("ayo").required=true
	
	alert('INGRESA LOS DATOS SOLICITADOS');
	
	  }


    }
            </script>
            
            <script>
    function cancel(id,a){
        var url = "<?php echo BASE_URL; ?>includes/FACTURACION/up_fac.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				a: a,
				id: id
				
            },
            success: function (data)
            {
                $("#tb4").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("tb4").style.display="block";                  
            }
        });
        

//        $('#myModaldestto').modal('show');

    }
	</script>