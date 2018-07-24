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
                        TIMBRADO
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
            
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>
				<center><label><?php echo htmlentities('DEL:'); ?></label></center>
				<input type="date" name="del" class="form-control" >
				
			</div>	
            
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>
				<center><label><?php echo htmlentities('AL:'); ?></label></center>
				<input type="date" name="al" class="form-control" >
			</div>	      
            
            <div  class="col-md-12 col-sm-12 col-xs-12"><br>
				<button name="boton"  value="reporte" class="btn btn-primary center-block">BUSCAR</button>
			</div>            
             
             
             
             <?php if(@$_REQUEST["boton"] == "reporte" ){?>
                 <br><br>  
         <?php
          $sql_reporte ="SELECT AYO,QNA,ID_USUARIO,R_SOCIAL,IMPORTE_FACTURA,SECTOR,SITUACION
								FROM [Facturacion_Demo].[dbo].[Temporal_Timbrado] order by SECTOR";
				$res_reporte = sqlsrv_query($conn,$sql_reporte);
				$count_reporte= sqlsrv_fetch_array($res_reporte, SQLSRV_FETCH_ASSOC);	
				if($count_reporte>0){ ?>
				<br><br><br><br><br><br>
	<center>
		<div class="panel-body" style="width:70%">
				
			  <div class="table-responsive">          
				  <table class="table table-hover table-responsive" style="font-size:11px;">
					<thead>
					  <tr style="background-color:#337ab7; color:white; ">
						<th><center>ID</center></th>
						<th><center>SECTOR</center></th>
						<th><center><?php echo htmlentities('AÑO'); ?></center></th>
						<th><center>QNA.</center></th>
						<th><center>ID USUARIO</center></th>
						<th><center>R. SOCIAL</center></th>
						<th><center>IMPORTE</center></th>			
						<th><center>GENERAR TXT</center></th>			
						<th><center>DESCARGAR </center></th>			
					  </tr>
					</thead>
					<tbody>
						<?php 	$a=1;
						$b=0;
								while($row_reporte = sqlsrv_fetch_array($res_reporte, SQLSRV_FETCH_ASSOC)){	
									if($a%2==0){ $color="background-color:#E1EEF4";	}else{	$color="background-color:#FFFFFF";	}				
						?>																	
					   <tr style="<?php echo $color; ?>">
							<td><center><?php echo  $a; ?> </td>
							<td><center><?php if(@$sectors!=""){ echo $sectors; }else{ echo $row_reporte['SECTOR']; } ?> </td>
							<td><center><?php if(@$ayo!=""){ echo $ayo; }else{ echo $row_reporte['AYO']; }  ?> </td>
							<td><center><?php if(@$qna!=""){ echo $qna; }else{ echo $row_reporte['QNA']; } ?> </td>
							<td><center><?php echo  $row_reporte['ID_USUARIO'];  ?> </td>
							<td><center><?php echo  $row_reporte['R_SOCIAL']; ?> </td>
							<td><center><?php echo  $row_reporte['IMPORTE_FACTURA']; ?> </td>
							<td><center><?php if($row_reporte['SITUACION']==1){ ?>
							<center><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" onclick="variable(<?php echo $row_reporte['AYO'] ?>,<?php echo $row_reporte['ID_USUARIO'] ?>)" data-target="#myModal">GENERAR TXT</button></center><?php }else{ ?><img src="dist/img/verde.png" height="20">
							<?php } ?></center></td>
							<td><center><?php if($row_reporte['SITUACION']==2){ ?>
							<a href="excel_facturacion.php" class="btn btn-success btn-xs center-block">DESCARGAR</a>
							<?php }else{?>	<img src="dist/img/rojo.png" height="20">	<?php } ?></center></td>
					  </tr>
					  <?php   if($row_reporte['SITUACION']==2){ $b++; }
					  $a++;		}	  ?>	
					  <tr>
							<td colspan="7"><center> </td>
							
							<td><center><button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal">MASIVO GENERAR TXT</button></center> </td>
							<td><center><?php if($b>1){ ?>
							<a href="excel_facturacion.php"  class="btn btn-info btn-xs center-block">MASIVO DESCARGAR</a>
							<?php }else{?>	<img src="rojo.png" height="20">	<?php } ?></center></td>
					</tr>		
					</tbody>
				  </table>
				<?php }else{ ?>
					<br><br><br><br><br><br><CENTER><h2 STYLE="color:RED">NO EXISTEN REGISTROS</h2></CENTER>
				<?php }	?>
				
		
			</div>
		</div>
	</center>
	<?php  } ?>
			<?php	@$usu2=$_REQUEST['usu2']; @$qna2=$_REQUEST['qna2'];
						if($usu2!="" and $qna2!="" ){
							$sql_reporte ="update  [Facturacion_Demo].[dbo].[Temporal_Timbrado] set SITUACION=2 WHERE QNA=$qna2 AND ID_USUARIO='$usu2'";
							$res_reporte = sqlsrv_query($conn,$sql_reporte);
						 if($res_reporte>0){?> 
						<script type ="text/javascript">  window.location="fac_txt.php?prueba";         </script>
				<?php }} ?>	
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
          <h4 class="modal-title"> GENERAR TXT TIMBRADO</h4>
        </div>
        <div class="modal-body">
          <p><?php echo htmlentities('¿Estas seguro de GENERAR txt de Timbrado?'); ?></p>
        </div>
        <div class="modal-footer">
		  
          <button type="button" class="btn btn-success" data-dismiss="modal">GENERAR</button>
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



