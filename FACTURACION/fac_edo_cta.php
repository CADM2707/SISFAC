<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
	
	
?>                        
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        REPORTES
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
                        <form  method="POST" class="centrado" >
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
				<select name="qnaf" class="form-control"  >
					<option value="" selected="selected">SELECCIONA</option>
					<?php
                        $selec2="select DISTINCT(Qna)  from seCTOR.DBO.C_PERIODO_QNAS";
                        $resc2=sqlsrv_query($conn,$selec2);
                        while($rowsec2= sqlsrv_fetch_array($resc2, SQLSRV_FETCH_ASSOC)){

						?>
                       <option value="<?php echo $rowsec2['Qna'] ;?>"><?php echo utf8_encode ($rowsec2['Qna']);?></option>
                         
						<?php
						}
						?>
				</select>
				
			</div>	
            
             <div  class="col-md-2 col-sm-2 col-xs-2"><br>
				<center><label><?php echo htmlentities('SECTOR:'); ?></label></center>
				<select name="secf" class="form-control"  >
					<option value="" selected="selected">SELECCIONA</option>
					<?php
                        $selec3="select SECTOR from sector.dbo.C_Sector GROUP BY SECTOR ORDER BY SECTOR";
                        $resc3=sqlsrv_query($conn,$selec3);
                        while($rowsec3= sqlsrv_fetch_array($resc3, SQLSRV_FETCH_ASSOC)){

						?>
                       <option value="<?php echo $rowsec3['SECTOR'] ;?>"><?php echo utf8_encode ($rowsec3['SECTOR']);?></option>
                         
						<?php
						}
						?>
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
            
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>
				<center><label><?php echo htmlentities('SITUACION:'); ?></label></center>
				<select name="sitf" class="form-control"  >
					<option value="" selected="selected">SELECCIONA</option>
					<option value="" >PAGADA</option>
                    <option value="" >PAGADA POR DEPOSITO</option>
                    <option value="" >PAGADA EN CAJA</option>
                    <option value="" >PAGADA PARCIALMENTE</option>
				</select>
				
			</div>	         
            
            <div  class="col-md-12 col-sm-12 col-xs-12"><br>
				<button name="boton"  value="reporte" class="btn btn-primary center-block">BUSCAR</button>
			</div>            
             
             
             
             <?php if(@$_REQUEST["boton"] == "reporte" ){?>
                  <br><br><br><br>    <br><br><br><br>  
             <?php
             $sql_reporte ="sp_Consulta_Reportes ";
				$res_reporte = sqlsrv_query($conn,$sql_reporte);
				$count_reporte = sqlsrv_fetch_array($res_reporte, SQLSRV_FETCH_ASSOC);	
				if($count_reporte>0){ ?>
				<br><br><br><br><br><br>
	<center>
		<div class="panel-body" style="width:80%">
			  <div class="table-responsive">          
				  <table class="table table-hover table-responsive" style="font-size:11px;">
					<thead>
					  <tr style="background-color:#337ab7; color:white; ">
						<th><center>ID</center></th>
						<th><center><?php ECHO utf8_decode('AÑO'); ?></center></th>
						<th><center>QNA.</center></th>
						<th><center>ID USUARIO</center></th>
						<th><center>SECTOR</center></th>
						<th><center>DESTACAMENTO</center></th>
						<th><center>FOLIO</center></th>
						<th><center>SITUACION</center></th>
						<th><center>SUBTOTAL</center></th>
						<th><center>IVA</center></th>
						<th><center>TOTAL</center></th>
						<th><center>OPERADOR</center></th>
						<th><center>FECHA SOLICITUD</center></th>
						<th><center>FECHA VALIDACION</center></th>
					  </tr>
					</thead>
					<tbody>
						<?php 					
							$a=1;
							while($row_reporte = sqlsrv_fetch_array($res_reporte, SQLSRV_FETCH_ASSOC)){	
								if($a%2==0){ $color="background-color:#E1EEF4";	}else{	$color="background-color:#FFFFFF";	}				
								if($del!=""){ $fecha=date_create($del);	$fechasss = date_format($fecha,"d-m-Y" );		}
								$sum_iva=$sum_iva+$row_reporte['IVA']	;
								$sum_total=$sum_total+$row_reporte['SUBTOTAL'];
								$sum_sub=$sum_sub+$row_reporte['SUBTOTAL'];
						?>																	
					   <tr style="<?php echo $color; ?>">
							<td><center><?php echo  $a; ?> </td>
							<td><center><?php if($ayo!=""){ echo $ayo; }else{ echo $row_reporte['AYO']; } ?> </td>
							<td><center><?php echo  $row_reporte['QNA']; ?> </td>
							<td><center><?php if($usuario!=""){ echo $usuario; }else {  echo  $row_reporte['ID_USUARIO']; } ?> </td>
							<td><center><?php if($sectors!=""){ echo $sectors; }else {  echo  $row_reporte['SECTOR']; } ?> </td>
							
							<td><center><?php echo  $row_reporte['DESTACAMENTO']; ?> </td>
							<td><center><?php echo  $row_reporte['FOLIO']; ?> </td>
							<td><center><?php if($situacion!=""){ echo $situacion2; }else {  echo  $row_reporte['SITUACION']; } ?> </td>
							<td><center><?php echo  $row_reporte['SUBTOTAL']; ?> </td>
							<td><center><?php echo  $row_reporte['IVA']; ?> </td>
							<td><center><?php echo  $row_reporte['TOTAL']; ?> </td>
							<td><center><?php echo  $row_reporte['OPERADOR']; ?> </td>
							<td><center><?php echo  $row_reporte['FECHA_EMISION']; ?> </td>
							<td><center><?php echo  $row_reporte['FECHA_SOLICITUD']; ?> </td>
					  </tr>
					  <?php   $a++;		}	  ?>	
					   <tr class="success">
							<td colspan="4"><center></td>
							<td><center><?php echo  $sum_sub; ?> </td>
							<td><center><?php echo  $sum_iva; ?> </td>
							<td><center><?php echo  $sum_total; ?> </td>
					  </tr>
					</tbody>
				  </table>
				  <CENTER><h3 STYLE="color:RED">Esta informe no tiene validez Fiscal solo es informacion de un reporte por fecha</h3></CENTER>
				<?php }else{ ?>
					<br><br><br><br><br><br><CENTER><h2 STYLE="color:RED">NO EXISTEN REGISTROS</h2></CENTER>
				<?php }	?>
		
			</div>
		</div>
	</center>
             
             
           <?php  } ?>           
                        </div>
                       
                    </div>                                    
                </div>                
            </section>
            </div>
            </form>
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



