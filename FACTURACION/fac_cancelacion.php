<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
	
	?>  
   
  
  <?php
  
  //CONSULTAS	---		CONSULTAS	---		CONSULTAS	---		CONSULTAS	---
	$sql_ayo="select DISTINCT(ayo)  from seCTOR.DBO.C_PERIODO_QNAS";       
	$res_ayo = sqlsrv_query($conn,$sql_ayo); 
	
	?>
                     
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        CANCELACION
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
                        <form  method="POST" class="centrado" >
                        <div class="row" >
                
                <div  class="col-md-3 col-sm-3 col-xs-3"><br></div>
                       
               <div  class="col-md-3 col-sm-3 col-xs-3"><br>
							<center><label>AÑO:</label></center>
							<select name="usuario" class="form-control" style="text-align:center;"  onchange="es_vacio()"   id="ayo"  onBlur="es_vacio()" >
								<option value="" selected="selected">SELECC...</option>
								<?php	while($row_ayo = sqlsrv_fetch_array($res_ayo)){ 		?>
									<option value="<?php echo @$row_ayo['ayo']; ?>" ><?php echo @$row_ayo['ayo']; ?></option>
								<?php } ?>
							</select>
						</div>		
            
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>
				<center><label>NO FACTURA</label></center>
				<input type="text" name="fac" class="form-control" onchange="es_vacio2()"   id="fac"  onBlur="es_vacio2()">
			</div>	      
            
            
            <div  class="col-md-3 col-sm-3 col-xs-3"><br></div>
            
            
            <div  class="col-md-12 col-sm-12 col-xs-12"><br>
				<button  type="button" onclick="detalle()" value="reporte" class="btn btn-primary center-block">BUSCAR</button>
                <br><br>
			</div>            
            
            <div id="tb3" style="display: none;"></div>

             
             
            
                     
                    </div>   
            
                </div>                
            </section>
            </div>
            
            <?php include_once '../footer.html'; ?>
           
<script>
function detalle(){
        var url = "<?php echo BASE_URL; ?>includes/FACTURACION/sec_cancelacion.php";
	
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

    }
            </script>