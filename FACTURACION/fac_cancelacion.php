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
                        CANCELACION
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
                       
              <div  class="col-md-3 col-sm-3 col-xs-3"><br>
				<center><label><?php echo htmlentities('AÑO:'); ?></label></center>
				<input type="text" name="ayof" class="form-control" >
				
			</div>	
            
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>
				<center><label><?php echo htmlentities('QUINCENA:'); ?></label></center>
				<input type="text" name="qnaf" class="form-control" >
			</div>	   
        
            
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>
				<center><label><?php echo htmlentities('USUARIO:'); ?></label></center>
				<input type="text" name="usu" class="form-control" >
				
			</div>	
            
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>
				<center><label><?php echo htmlentities('NO FACTURA:'); ?></label></center>
				<input type="text" name="fac" class="form-control" >
			</div>	      
            
            <div  class="col-md-12 col-sm-12 col-xs-12"><br>
				<button name="boton"  value="reporte" class="btn btn-primary center-block">BUSCAR</button>
			</div>            
             
             
             
             <?php if(@$_REQUEST["boton"] == "reporte" ){?>
                 <br><br>  
                 <?PHP
          $sql_reporte ="select AYO, QNA, ID_USUARIO, T2.SITUACION,SECTOR,DEST DESTACAMENTO,FECHA_SOLICITUD,FECHA_VALIDACION,OPERADOR ,CONVERT(VARCHAR(15),FOLIO) FOLIO,MONTO  
								from  temporal_timbrado T1
								INNER  JOIN Factura_C_Situacion T2 ON T1.SITUACION=T2.CVE_SITUACION";
				$res_reporte = sqlsrv_query($conn,$sql_reporte);
				$count_reporte= sqlsrv_fetch_array($res_reporte, SQLSRV_FETCH_ASSOC);	
				//$count_reporte=1;
				if($count_reporte>0){ ?>
				<br><br><br><br><br><br>
	<center>
		<div class="panel-body" style="width:70%">
				
			  <div class="table-responsive">          
				  <table class="table table-hover table-responsive" style="font-size:11px;">
					<thead>
					  <tr style="background-color:#337ab7; color:white; ">
						<th><center>ID</center></th>
						<th><center><?php echo utf8_decode('AÑO'); ?></center></th>
						<th><center>QNA.</center></th>
						<th><center>ID USUARIO</center></th>
						<th><center>SECTOR</center></th>			
						<th><center>DESTACAMENTO</center></th>			
						<th><center>SITUACION</center></th>			
						<th><center>FOLIO</center></th>			
						<th><center>FECHA SOLICITUD</center></th>			
						<th><center>FECHA VALIDACION</center></th>									
						<th><center>MONTO</center></th>			
						<th><center>OPERADOR</center></th>			
						<th><center>CANCELAR</center></th>			
					  </tr>
					</thead>
					<tbody>
						<?php 	$a=1;
								$b=0;
								$folio=5531;
								while($row_reporte = sqlsrv_fetch_array($res_reporte, SQLSRV_FETCH_ASSOC)){	
									if($a%2==0){ $color="background-color:#E1EEF4";	}else{	$color="background-color:#FFFFFF";	}				
						?>																	
					   <tr style="<?php echo $color; ?>">
							<td><center><?php echo  $a; ?> </td>
							<td><center><?php if($ayo!=""){ echo $ayo; }else{ echo $row_reporte['AYO']; }  ?> </td>
							<td><center><?php if($qna!=""){ echo $qna; }else{ echo $row_reporte['QNA']; } ?> </td>
							<td><center><?php if($usuario!=""){ echo $usuario; }else{ echo $row_reporte['ID_USUARIO']; }  ?> </td>
							<td><center><?php echo  $row_reporte['SECTOR']; ?> </td>
							<td><center><?php echo  $row_reporte['DESTACAMENTO']; ?> </td>
							<td><center><?php echo  $row_reporte['SITUACION']; ?> </td>
							<td><center><?php if($fact!=""){ echo $fact; }else{ echo $row_reporte['FOLIO']; } ?> </td>
							<td><center><?php echo  $row_reporte['FECHA_SOLICITUD']; ?> </td>
							<td><center><?php echo  $row_reporte['FECHA_VALIDACION']; ?> </td>
							<td><center><?php echo  $row_reporte['MONTO']; ?> </td>
							<td><center><?php echo  $row_reporte['OPERADOR']; ?> </td>
							<td><center><button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal">CANCELAR</button></center></td>
							<?php $a++;	$folio++;	}	  ?>	
					 	
					</tbody>
				  </table>
				<?php }else{ ?>
					<br><br><br><br><br><br><CENTER><h2 STYLE="color:RED">NO EXISTEN REGISTROS</h2></CENTER>
				<?php }	?>
				
		
			</div>
		</div>
	</center>
	<?php  } ?>
			
			</div>
	
		
	
	
	
	<br><br>
	</div>
	<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">CANCELACION DE FACTURA</h4>
        </div>
        <div class="modal-body">
          <p><?php echo htmlentities('¿Estas seguro de CANCELAR esta factura?'); ?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal">CANCELAR</button>
		  <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
        </div>
      </div>
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



