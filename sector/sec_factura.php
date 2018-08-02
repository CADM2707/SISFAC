<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
    
?>      
<script language="javascript" type="text/javascript">

  </script>
  <?php 
  //CONSULTAS	---		CONSULTAS	---		CONSULTAS	---		CONSULTAS	---
  extract($_POST);
  
	$sql_sector=" select * from sector.dbo.C_Sector";       
	$res_sector = sqlsrv_query($conn,$sql_sector); 		  
	$sql_desta="select * from sector.dbo.C_Destacamento WHERE sector=$sector";       
	$res_dest = sqlsrv_query($conn,$sql_desta);
	
  ?>
			<form method="POST" >
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                       REPORTE DE SOLICITUDES
                        <small></small>
                    </h1>                    
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center">   
					<form  method="POST"  >
						<div  class="col-md-3 col-sm-3 col-xs-3"></div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>AÑO:</label></center>							
								<input type="text" name="ayo"   value="<?php echo @$ayo;?>" id="ayo" style="text-align:center;"  class="form-control"  >
						</div>	
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>SECTOR:</label></center>
							<select name="sector" class="form-control" style="text-align:center;" onChange="this.form.submit()"  id="sector" >
								<option value="" selected="selected">SELECC...</option>
								<?php	while($row_sector = sqlsrv_fetch_array($res_sector)){  
										if($row_sector['SECTOR']==$sector){ ?>
								<option value="<?php echo $row_sector['SECTOR']; ?>" selected ><?php echo $row_sector['SECTOR']; ?></option>
								<?php }else{ ?>
								<option value="<?php echo $row_sector['SECTOR']; ?>" ><?php echo $row_sector['SECTOR']; ?></option>	
								<?php } } ?>
							</select> 
						</div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>DESTACAMENTO:</label></center>
							<select name="desta" class="form-control" style="text-align:center;"  id="desta" >
								<option value="" selected="selected">SELECC...</option>
								<?php	while($row_dest = sqlsrv_fetch_array($res_dest)){ 
										if($row_dest['DESTACAMENTO']==$desta){ ?>
								<option value="<?php echo $row_dest['DESTACAMENTO']; ?>" selected ><?php echo $row_dest['DESTACAMENTO']; ?></option>
								<?php }else{ ?>
								<option value="<?php echo $row_dest['DESTACAMENTO']; ?>" ><?php echo $row_dest['DESTACAMENTO']; ?></option>	
								<?php } } ?>
							</select> 
						</div>
						<div  class="col-md-12 col-sm-12 col-xs-12"><br>
							<button  type="button" onclick="detalle()" class="btn btn-primary center-block">BUSCAR</button>
						</div>
						<div  class="col-md-12 col-sm-12 col-xs-12"><br></div>
						<div id="tb3" style="display: none;"></div> 
					</form> 
                    </div>                                    
                </div>                
            </section>
            </div>
           </form>
            <?php include_once '../footer.html'; ?>
            <script>
function detalle(){   
	
        var url = "<?php echo BASE_URL; ?>includes/sector/reporte_solicitudes.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Ayo: $('#ayo').val(),
				Sector: $('#sector').val(),
				Destacamento: $('#desta').val()
				
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



