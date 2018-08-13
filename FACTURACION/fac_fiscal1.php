<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
	extract($_POST);
	
?>                        
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        FOLIO FISCAL
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
                       
       <div  class="col-md-4 col-sm-4 col-xs-4"></div>
			<div  class="col-md-4 col-sm-4 col-xs-4">
			<input id="input-b1" name="input-b1" type="file" class="form-control" required>
			</div>	           
            
            <div  class="col-md-12 col-sm-12 col-xs-12"><br>
				<button name="boton"  value="reporte" class="btn btn-primary center-block">BUSCAR</button>
			</div>            
             
             
             
             <?php if(@$_REQUEST["boton"] == "reporte" ){?>
                  <br><br><br><br>    <br><br><br><br>  
          <?php
          $sql_reporte ="EXEC  sp_Consulta_Detalle_Factura '10053'";
				$res_reporte = sqlsrv_query($conn,$sql_reporte);
				@$row_reporte = sqlsrv_fetch_array($res_reporte, SQLSRV_FETCH_ASSOC);
				$turnos=$row_reporte['TURNOS'];
				$tarifa=$row_reporte['TARIFA'];
				$jerarquia=$row_reporte['JERARQUIA'];
				$deductivas=$row_reporte['DEDUCTIVAS'];
				$obs=$row_reporte['OBSERVACION'];
				@$count_reporte = sqlsrv_fetch_array($res_reporte, SQLSRV_FETCH_ASSOC );	
				//if($count_reporte>0){ ?>
				<br><br><br><br><br><br>
	<center>
		<div class="panel-body" style="width:70%">
				<!--<h3><center><b><?php echo utf8_decode($usuario.' QNA. '.$qna); ?></b></center></h3>
				<h4><center><b><?php echo utf8_decode('AÑO '.$ayo.' QNA. '.$qna); ?></b></center></h4>-->
				
			  <div class="table-responsive">          
				  <table class="table table-hover table-responsive" style="font-size:11px;">
					<thead>
					  <tr style="background-color:#337ab7; color:white; ">
						<th><center>FOLIO FISCAL</center></th>
						<th><center>FOLIO</center></th>
						<th><center><?php echo utf8_decode('AÑO'); ?></center></th>
						<th><center>ID_USUARIO</center></th>
					  </tr>
					</thead>
					<tbody>																
					   	<tr>
							<td>DGSG22SD1</td>
							<td>1315</td>
							<td>2018</td>
							<td>20</td>
						<tr/>
						<tr>
							<td>DFGG24</td>
							<td>1315</td>
							<td>2018</td>
							<td>10121</td>
						<tr/>
						<tr>
							<td>H4654645DSG</td>
							<td>86</td>
							<td>2018</td>
							<td>10279</td>
						<tr/>
						<tr>
							<td>BF4G68D446</td>
							<td>53</td>
							<td>2018</td>
							<td>1139</td>
						<tr/>
						<tr>
							<td>DD65B4DB8</td>
							<td>53</td>
							<td>2018</td>
							<td>11382</td>
						<tr/>
						<tr>
							<td>YK64TY643</td>
							<td>735</td>
							<td>2018</td>
							<td>10951</td>
						<tr/><tr>
							<td>YJ4E6H44</td>
							<td>735</td>
							<td>2018</td>
							<td>11947-02</td>
						<tr/>
						
					</tbody>
				  </table>
				  <div  class="col-md-12 col-sm-12 col-xs-12"><br>
				<button name="boton"  value="reporte" class="btn btn-primary center-block">APLICAR</button>
			</div>
				<?php //}else{ ?>
					<!--<br><br><br><br><br><br><CENTER><h2 STYLE="color:RED">NO EXISTEN REGISTROS</h2></CENTER>--->
				<?php //}	?>
				
		
			</div>
		</div>
	</center>
	<?php  } ?>
				<?php 	@$ayo2=$_REQUEST['ayo2'];	@$qna2=$_REQUEST['qna2'];	@$usu2=$_REQUEST['usu2'];	@$del2=$_REQUEST['del2'];	@$al2=$_REQUEST['al2'];
						if(@$_REQUEST['ayo2']!="" ){ ?><br><br><br><br><br><br>
						<div class="panel panel-primary" >
							<div class="row">
							<h4><center><b>DETALLE DE FACTURACION</b></center></h4>	
							<h5><center><b><?php echo utf8_decode('AÑO '.$ayo2.' QNA. '.$qna2); ?></b></center></h5>	
							<?php if($del2!="" and $al2!=""){  ?>
							<h5><center><b><?php echo utf8_decode('PERIODO DEL '.$del2.' AL '.$al2); ?></b></center></h5>	
							<?php } ?>
							<div  class="col-md-6 col-sm-6 col-xs-6">
								<button name="boton"  value="reporte" class="btn btn-danger center-block">RECHAZAR</button>
							</div>
							<div  class="col-md-6 col-sm-6 col-xs-6">
								<button name="boton"  value="reporte" class="btn btn-success center-block">VALIDAR</button>
							</div><br><br>
							</div>
						</div>	
          
           <?php  } ?>           
                        </div>
                       
                    </div>                                    
                </div>                
            </section>
            </div>
            </form>
            <?php include_once '../footer.html'; ?>
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



