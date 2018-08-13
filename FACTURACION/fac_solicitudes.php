<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
    
?>      
<script language="javascript" type="text/javascript">
  function es_vacio(){
  var ayo = document.getElementById("ayo").value;
	  if(ayo >0){
		document.getElementById("periodo").disabled=true		
	  }
	  else{
		document.getElementById("periodo").disabled=false		
	  }
	}
	function es_vacio2(){
  var qna = document.getElementById("qna").value;
	  if (qna>0){
		document.getElementById("periodo").disabled=true		
	  }
	  else{
		document.getElementById("periodo").disabled=false		
	  }
	}
	function es_vacio3(){
  var del = document.getElementById("periodo").value;
	  if (del !="" ){
		document.getElementById("qna").disabled=true
		document.getElementById("ayo").disabled=true
	  }
	  else{
		document.getElementById("qna").disabled=false
		document.getElementById("ayo").disabled=false
	  }
	}
	
  </script>
  <?php 
  //CONSULTAS	---		CONSULTAS	---		CONSULTAS	---		CONSULTAS	---
	$sql_ayo="select distinct(ayo) from sector.dbo.C_Periodos_Facturacion";       
	$res_ayo = sqlsrv_query($conn,$sql_ayo); 		  
	$sql_qna="select distinct(QNA) Qna from sector.dbo.C_Periodos_Facturacion";       
	$res_qna = sqlsrv_query($conn,$sql_qna);  	
	$sql_fecha="select	AYO,QNA,FECHA_INI,FECHA_FIN from sector.dbo.C_Periodos_Facturacion order by AYO asc,QNA asc";       
	$res_fecha= sqlsrv_query($conn,$sql_fecha);  			
  ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        SOLICITUD DE FACTURAS
                        <small></small>
                    </h1>                    
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center">   
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>AÑO:</label></center>
							<select name="usuario" class="form-control" style="text-align:center;"  onchange="es_vacio()"   id="ayo"  onBlur="es_vacio()" >
								<option value="" selected="selected">SELECC...</option>
								<?php	while($row_ayo = sqlsrv_fetch_array($res_ayo)){ 		?>
									<option value="<?php echo @$row_ayo['ayo']; ?>" ><?php echo @$row_ayo['ayo']; ?></option>
								<?php } ?>
							</select>
						</div>	
						<div  class="col-md-2 col-sm-2 col-xs-2">	
							<center><label>QNA.:</label></center>
							<select name="usuario" class="form-control" style="text-align:center;"  onchange="es_vacio2()" id="qna" >
								<option value="" selected="selected">SELECC...</option>
								<?php	while($row_qna = sqlsrv_fetch_array($res_qna)){  ?>
									<option value="<?php echo $row_qna['Qna']; ?>" ><?php echo $row_qna['Qna']; ?></option>
								<?php } ?>
							</select> 
						</div>
						<div  class="col-md-3 col-sm-3 col-xs-3">	
							<center><label>USUARIO:</label></center>				
							<input type="text" name="usuario"  value="<?php echo @$usuario;?>" id="usuario"  style="text-align:center;" class="form-control" >	
							</select>     
						</div>			
						<div  class="col-md-5 col-sm-5 col-xs-5">	
							<center><label>PERIODO:</label></center>
							<select class="form-control" name="periodo"   id='periodo' onchange="es_vacio3()">
								<option value="" selected="selected">SELECC...</option>
								<?php	while($row_fecha = sqlsrv_fetch_array($res_fecha)){  
								$format="d/m/Y";
								$inicio=date_format($row_fecha['FECHA_INI'], $format); 
								$fin=date_format($row_fecha['FECHA_FIN'], $format); ?>
								<option value="<?php echo $row_fecha['AYO'].'-'.$row_fecha['QNA'].'-'.$inicio.'-'.$fin; ?>" ><?php echo $inicio.'  -  '.$fin; ?></option>
								<?php } ?>
							</select>
						</div>
						
						<div  class="col-md-12 col-sm-12 col-xs-12"><br>
							<button  type="button" onclick="detalle()" class="btn btn-primary center-block">BUSCAR</button>
						</div>
					</div><br><br>	<br><br>	<br><br>	<br><br>	
					<div class="col-lg-12 col-xs-12 text-center">   
						<div id="tb3" style="display: none; "></div> 
						<div id="tb4" style="display: none;"></div>

                    </div>                                    
                </div>                
            </section>
            </div>
            <div>
	<div class="modal fade" id="myModalCharts" role="dialog">
		<div class="modal-dialog mymodal modal-lg" style=" width: 55% !important">         
			<div class="modal-content">
				<div class="modal-header title_left" style=" background-color: #2C3E50;">
					<button type="button" class="close" data-dismiss="modal" style=" background-color: white;">&nbsp&nbsp;&times;&nbsp&nbsp;</button>
					<h4 class="modal-title" style=" color: white;"><img width="2%"  src="../dist/img/pa2.png"><center></center></h4>
				</div>
				<div style="text-align: center"><br>
					<h4 style=" color: #1B4C7C; font-weight: 600">SOLICITUD DE FACTURAS.</h4><hr>
				</div>  
				<div class="col-md-12">
					<center><p><?php echo ('¿Estas seguro de VALIDAR esta factura?'); ?></p></center>
					<div class="col-md-3">
						
						<input type="hidden" id="usus" class="form-control" style="text-align:center;" readonly>
					</div><div class="col-md-3">
						
						<input type="hidden" id="qnas" class="form-control" style="text-align:center;" readonly>
					</div><div class="col-md-3">	
						
						<input type="hidden" id="anio" class="form-control" style="text-align:center;" readonly>
					</div><div class="col-md-3">
						
						<input type="hidden" id="soli" class="form-control" style="text-align:center;" readonly>
					</div>
				</div>
			
				<div class="modal-footer">   <br><br> <br><br> <br><br>
					<button name="btn"  value="cancelar" onclick="solicitar(1)" type="button" class="btn btn-danger" data-dismiss="modal">RECHAZAR</button>
					<button name="btn"  value="cancelar" onclick="solicitar(2)" type="button" class="btn btn-success" data-dismiss="modal">VALIDAR</button>
				</div>
			</div>      
		</div>
	</div>
</div> 
            <?php include_once '../footer.html'; ?>
<script>
		function detalle(){
        var url = "<?php echo BASE_URL; ?>includes/FACTURACION/sec_solicitudes.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Ayo: $('#ayo').val(),
				Qna: $('#qna').val(),
				Usuario: $('#usuario').val(),
				Periodo: $('#periodo').val()
            },
            success: function (data)
            {
                $("#tb3").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("tb3").style.display="block";                  
            }
        });
    }
	function solicitar(tipo){
		
        var url = "<?php echo BASE_URL; ?>includes/FACTURACION/sec_solicitudes_facturas.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Qnas: $('#qnas').val(),
				Anio: $('#anio').val(),
				Soli: $('#soli').val(),
				tipo: tipo
            },
            success: function (data)
            {
                $("#tb3").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("tb3").style.display="block";                  
            }
        });
    }
	
	function modal(anio,qnas,usus,soli){
          $('#myModalCharts').modal('show');
		  $("#anio").val(anio);
		  $("#qnas").val(qnas);
		  $("#usus").val(usus);
		  $("#soli").val(soli);
    }
</script>
