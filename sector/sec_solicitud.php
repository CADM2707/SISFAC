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
  <style>
  #div1 {
     scroll-direction: vertical;
	   overflow-x: auto;
        overflow-y: hidden;
	}
	    .text1{
        color: #094F93 !important;
        font-weight: 600 !important;
        font-size: 15px;
    }
    label{
        color: #525558 !important;
        font-weight: 600 !important;
    }
   
    .select2-selection__choice{
        background-color: #28B463 !important;
        color: #EAECEE !important;
    }
    .select2-selection__choice__remove{
        color: #D5D8DC !important;
    }
  
  </style>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/bower_components/select2/dist/css/select2.min.css">
   <!--<style>


.scrolls { 
        overflow-x: auto;
        overflow-y: hidden;
        height: 600px;
    white-space:nowrap
    } 
  </style>--->
  <?php 
  //CONSULTAS	---		CONSULTAS	---		CONSULTAS	---		CONSULTAS	---
	$sql_ayo="select distinct(ayo) from sector.dbo.C_Periodos_Facturacion order by ayo desc";       
	$res_ayo = sqlsrv_query($conn,$sql_ayo); 		  
	$sql_qna="select distinct(QNA) Qna from sector.dbo.C_Periodos_Facturacion";       
	$res_qna = sqlsrv_query($conn,$sql_qna);  	
	$sql_fecha="select	AYO,QNA,FECHA_INI,FECHA_FIN from sector.dbo.C_Periodos_Facturacion order by AYO asc,QNA asc";       
	$res_fecha= sqlsrv_query($conn,$sql_fecha);  			
  ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;  ">
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
                    <div class="col-lg-12 col-xs-12 text-center" >   
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
							<select  required="true" class="form form-control select2" name="usuario" id="usuario" style="width: 100%;">
							</select>     
						</div>	
						<div  class="col-md-2 col-sm-2 col-xs-2">	
							<center><label>SECTOR:</label></center>				
							<input type="text" name="sec_l"  value="<?php echo @$sec;?>" id="sec_l"  style="text-align:center;" class="form-control"  readonly>	
							</select>     
						</div>							
						<div  class="col-md-3 col-sm-3 col-xs-3">	
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
						<!--div id="tb3" style="display: none; width:auto; height: 800px; overflow-x: scroll; overflow-y: hidden; white-space:nowrap" ></div--> 
						<div id="tb3" style="display: none;"></div> 
						<div id="tb4" style="display: none;"></div>
						<div id="tb5" style="display: none;"></div>
						<div id="tb6" style="display: none;"></div>
						<div id="loadImg"></div>
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
					<center><p><?php echo ('¿Estas seguro de SOLICITAR esta factura?'); ?></p></center>
					<div class="col-md-2"></div>
					<div class="col-md-3">
						<center><label>Usuario:</label></center>
						<input type="text" id="usus" class="form-control" style="text-align:center;" readonly>
					</div><div class="col-md-3">
						<center><label>QNA.:</label></center>
						<input type="text" id="qnas" class="form-control" style="text-align:center;" readonly>
					</div><div class="col-md-2">	
						<center><label>AÑO:</label></center>
						<input type="text" id="anio" class="form-control" style="text-align:center;" readonly>
					</div><div class="col-md-2">
						<!--<center><label>ID SOLICITUD:</label></center>-->
						<input type="hidden" id="soli" class="form-control" style="text-align:center;" readonly >
					</div>
				</div>
			
				<div class="modal-footer">   <br><br> <br><br> <br><br>
					<button name="btn"  value="cancelar" onclick="solicitar()" type="button" class="btn btn-success" data-dismiss="modal">SOLICITAR</button>
				</div>
			</div>      
		</div>
	</div>
				
	
	
				
				
				
					  
		
	
</div> 
			
            <?php include_once '../footer.html'; ?>
<script>
		$('.select2').select2();
		
		function detalle(){
			
		 var ayo = document.getElementById("ayo").value;
		 var qna = document.getElementById("qna").value;
		 var periodo = document.getElementById("periodo").value;
		 
	  if((ayo >0 & qna>0) || (periodo!='')){	
			load();	
	      var url = "<?php echo BASE_URL; ?>includes/sector/solicitud_facturas.php";
	
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
				$("#ModalLoad").modal('hide'); 				
            }
        });
		  }else{
			  alert('INGRESA ALGUN FILTRO');
       
    }     }
	function solicitar(){
        var url = "<?php echo BASE_URL; ?>includes/sector/solicitud_de_facturas.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Qnas: $('#qnas').val(),
				Anio: $('#anio').val(),
				Soli: $('#soli').val()
            },
            success: function (data)
            {
                $("#tb3").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("tb3").style.display="block"; 
				detalle(); 				
				$("#myModalCharts").modal("hide");
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
	function modal2(anio2,qnas2,usus2,soli2,servi2){		
		 var url = "<?php echo BASE_URL; ?>sector/sec_detalle_elementos.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Anio2: anio2,
				Qnas2: qnas2,
				Usu2: usus2, 
				Soli2: soli2 ,
				Servi2: servi2 
            },
            success: function (data)
            {
                $("#tb5").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("tb5").style.display="block";                  
				$('#myModalCharts2').modal('show');
            }
        });
		
		
    }
	function modal3(usu3,servi3,anio3,qnas3){		
		 var url = "<?php echo BASE_URL; ?>sector/sec_leyenda.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Usu: usu3,
				Ser: servi3,
				Anio: anio3,
				Qnas: qnas3
            },
            success: function (data)
            {
                $("#tb6").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("tb6").style.display="block";                  
				$('#myModalCharts3').modal('show');
            }
        });
		
		
    }
	function Leyenda(){
        var url = "<?php echo BASE_URL; ?>includes/sector/captura_leyenda.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Usuario: $('#usu').val(),
				Servicio: $('#servi').val(),
				Accion: $('#accion').val(),
				Leyenda: $('#leyenda').val()
            },
            success: function (data)
            {
                $("#consulta_datos").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("consulta_datos").style.display="block";                  
            }
        });
    }		
	usu_sel();
	function usu_sel() {
        
        var url = "<?php echo BASE_URL; ?>includes/sector/opciones_usuario.php";
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'html',
            data: {
			Sec: $('#sec_l').val()
            },
            success: function (data)
            {
                $('#usuario').html(data);
            }
        });

        return false;
    }
</script>



