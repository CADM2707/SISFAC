<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
    
?>      
<script language="javascript" type="text/javascript">

  </script>
  <?php 
  //CONSULTAS	---		CONSULTAS	---		CONSULTAS	---		CONSULTAS	---
	$sql_ayo="SELECT DISTINCT(AYO) AYO FROM V_FACTURAS order by AYO DESC";       
	$res_ayo = sqlsrv_query($conn,$sql_ayo); 		  
	$sql_sit="SELECT DISTINCT(SITUACION) SITUACION FROM V_FACTURAS";       
	$res_sit = sqlsrv_query($conn,$sql_sit); 
	$sql_usuario="SELECT ID_USUARIO FROM SECTOR.DBO.Usuario_Padron WHERE CVE_TIPO_USUARIO IN(1,4)";       
	$res_usuario = sqlsrv_query( $conn,$sql_usuario); 			
  ?>
 
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                       CONSULTA DE FACTURAS
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
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>AÑO:</label></center>
							<select name="usuario" class="form-control" style="text-align:center;"   id="ayo"   >
								<option value="" selected="selected">SELECC...</option>
								<?php	while($row_ayo = sqlsrv_fetch_array($res_ayo)){ 		?>
									<option value="<?php echo @$row_ayo['AYO']; ?>" ><?php echo @$row_ayo['AYO']; ?></option>
								<?php } ?>
							</select>
						</div>	
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>SITUACION:</label></center>
							<select name="situacion" class="form-control" style="text-align:center;"  id="situacion" >
								<option value="" selected="selected">SELECC...</option>
								<?php	while($row_sit = sqlsrv_fetch_array($res_sit)){  ?>
									<option value="<?php echo $row_sit['SITUACION']; ?>" ><?php echo $row_sit['SITUACION']; ?></option>
								<?php } ?>
							</select> 
						</div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>USUARIO:</label></center>
							<input type="text" name="usuario"  value="<?php echo @$usuario;?>" id="usuario"  style="text-align:center;"  class="form-control" >
						</div>				
						<div  class="col-md-3 col-sm-3 col-xs-3">
							<center><label>INICIO:</label></center>
							<input type="date" name="inicio"  value="<?php echo $inicio;?>" id="inicio"  style="text-align:center;"  class="form-control" >
						</div>	
						<div  class="col-md-3 col-sm-3 col-xs-3">	
							<center><label>FIN:</label></center>
							<input type="date" name="fin"  value="<?php echo $fin;?>" id="fin" style="text-align:center;" class="form-control" >
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
           
            <?php include_once '../footer.html'; ?>
            <script>
function detalle(){
	
	 var inicio = document.getElementById("inicio").value;
	 var fin = document.getElementById("fin").value;
	 var ayo = document.getElementById("ayo").value;
	  if((ayo>0) || (inicio != '' &  fin != '' )){
			if((inicio != '' & fin == '') || (inicio == '' & fin != '')){ 
			document.getElementById("fin").required = true
			alert('SELECCIONA LA FECHA INICIO Y LA FECHA FIN');
			}else{	
			load();			
		 var url = "<?php echo BASE_URL; ?>includes/sector/consulta_facturas.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Ayo: $('#ayo').val(),
				Situacion: $('#situacion').val(),
				Usuario: $('#usuario').val(),
				Inicio: $('#inicio').val(),
				Fin: $('#fin').val()
            },
            success: function (data)
            {
                $("#tb3").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("tb3").style.display="block";    
				$("#ModalLoad").modal('hide'); 				
            }
        }); 
	  }}else{	
	   alert('SELECCIONA UN FILTRO AÑO O PERIODO');
	
       
        

//        $('#myModaldestto').modal('show');

    } }
            </script>



