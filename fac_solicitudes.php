<?php
    include_once 'config.php';
    include_once 'head.html';
    include_once 'menuLat.php';
	
	
?>                        
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        SOLICITUDES
                        <small>Panel de control</small>
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
                       
               <div  class="col-md-2 col-sm-2 col-xs-2"><br>
				<center><label><?php echo htmlentities('AÑO:'); ?></label></center>
                
                <select name="ayof" class="form-control"  >
					<option value="" selected="selected">SELECCIONA</option>
                  <?php
                        $selec1="select DISTINCT(ayo)  from SECTOR.DBO.C_PERIODO_QNAS";
                        $resc1=sqlsrv_query($conn,$selec1);
                        while($rowsec= sqlsrv_fetch_array($resc1, SQLSRV_FETCH_ASSOC)){

						?>
                       <option value="<?php echo $rowsec['ayo'] ;?>"><?php echo utf8_encode ($rowsec['ayo']);?></option>
                         
						<?php
						}
						?>
				</select>
				
			</div>	
            
            <div  class="col-md-2 col-sm-2 col-xs-2"><br>
				<center><label><?php echo htmlentities('QUINCENA:'); ?></label></center>
				<select name="ayof" class="form-control"  >
					<option value="" selected="selected">SELECCIONA</option>
					<option value="" >2016</option>
                    <option value="" >2017</option>
                    <option value="" >2018</option>
				</select>
				
			</div>	
            
             <div  class="col-md-2 col-sm-2 col-xs-2"><br>
				<center><label><?php echo htmlentities('SECTOR:'); ?></label></center>
				<select name="ayof" class="form-control"  >
					<option value="" selected="selected">SELECCIONA</option>
					<option value="" >2016</option>
                    <option value="" >2017</option>
                    <option value="" >2018</option>
				</select>
				
			</div>	
            
             <div  class="col-md-3 col-sm-3 col-xs-3"><br>
				<center><label><?php echo htmlentities('DESTACAMENTO:'); ?></label></center>
				<select name="ayof" class="form-control"  >
					<option value="" selected="selected">SELECCIONA</option>
					<option value="" >2016</option>
                    <option value="" >2017</option>
                    <option value="" >2018</option>
				</select>
				
			</div>	
           
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>
				<center><label><?php echo htmlentities('USUARIO:'); ?></label></center>
				<select name="ayof" class="form-control"  >
					<option value="" selected="selected">SELECCIONA</option>
					<option value="" >2016</option>
                    <option value="" >2017</option>
                    <option value="" >2018</option>
				</select>
				
			</div>	
            <br><br><br><br><br><br>
            <center><label style="color:#337ab7; margin:0px;">PERIODO</label></center>
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>
			</div>
            
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>
				<center><label><?php echo htmlentities('DEL:'); ?></label></center>
				<select name="ayof" class="form-control"  >
					<option value="" selected="selected">SELECCIONA</option>
					<option value="" >2016</option>
                    <option value="" >2017</option>
                    <option value="" >2018</option>
				</select>
				
			</div>	
            
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>
				<center><label><?php echo htmlentities('AL:'); ?></label></center>
				<select name="ayof" class="form-control"  >
					<option value="" selected="selected">SELECCIONA</option>
					<option value="" >2016</option>
                    <option value="" >2017</option>
                    <option value="" >2018</option>
				</select>
				
			</div>	
            
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>
			</div>	           
                        
                        
                        
                        
                        </div>
                       
                    </div>                                    
                </div>                
            </section>
            </div>
            
            <?php include_once 'footer.html'; ?>
            <script>
//                Funcion con ajax sinn formulario
//                function buttonGraf(sec) {
//                    
//                    var url = "<?php echo BASE_URL; ?>includes/facturacionEmitida/responseGrafFacEm.php";
//
//                    $.ajax({
//                        type: "POST",
//                        url: url,
//                        data: {
//                            UnoCal1: $('#UnoCal1').val(),                            
//                            Sector: sec
//                        },
//                        success: function (data)
//                        {
//                            $("#tb2").html(data); // Mostrar la respuestas del script PHP.
//                            document.getElementById("tb2").style.display="block";                               
//                        }
//                    });
//                    document.getElementById("Sec").value = sec;                              
//                    return false;
//                }
//*****************************************************************************************************************************

//        AJAX CON FORMULARIO
//    $('#formTb1').submit(function () {
//        var url = "<?php echo BASE_URL; ?>includes/facturacionEmitida/responseFactEm.php";
//        $.ajax({
//            type: "POST",
//            url: url,
//            data: $("#formTb1").serialize(), // Adjuntar los campos del formulario enviado.
//            success: function (data)
//            {
//                $("#tb1").html(data); // Mostrar la respuestas del script PHP.    
//                document.getElementById('tb2').style.display = "none";                                                             
//            }
//        });
//
//        return false;
//    });
            </script>



