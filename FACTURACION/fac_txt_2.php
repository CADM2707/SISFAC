//funcion ajax para evitar se refresque la pagina 

<script type="text/javascript">

	function objetoAjax(){
		var xmlhttp = false;
		try {
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {

			try {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (E) {
				xmlhttp = false; }
		}

		if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		  xmlhttp = new XMLHttpRequest();
		}
		return xmlhttp;
	}
	
	
	
	

</script>





<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
	extract($_POST);
	$format="d/m/Y";
	
?>                        
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        TIMBRADO
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
                        
                        // agregar funcion onSubmit al form 
                        <form  method="POST" class="centrado" onSubmit="enviar0Datos(); return false;">
                        <div class="row" >
               // cada elemento del form debe tener un id con el mismo nombre que name 
               <div  class="col-md-2 col-sm-2 col-xs-2"><br>
				<center><label><?php echo htmlentities('SECTOR:'); ?></label></center>
				<select name="secf" id="secf" class="form-control"  >
					<option value="" selected="selected">SELECCIONA</option>
					<?php
                        $selec3="select SECTOR from sector.dbo.C_Sector where SECTOR>50 GROUP BY SECTOR ORDER BY SECTOR";
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
                
                <select name="ayof" id="ayof" class="form-control"  >
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
				<select name="qnaf" id="qnaf" class="form-control"  >
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
            
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>uti
					  $a++;		}	  ?>	
					  <tr>
							<td colspan="8"><center> </td>
							
                            <td><center><?php if($b>1){ ?>
							<a href="excel_facturacion.php"  class="btn btn-info btn-xs center-block">MASIVO GENERAR TXT</a>
							<?php }else{?>	<img src="../dist/img/rojo.png" height="20">	<?php } ?></center></td>
                            
							<td><center><button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal">MASIVO DESCARGAR</button></center> </td>
                          
					</tr>		
					</tbody>
				  </table>
				<?php }//else{ ?>
					<!--<br><br><br><br><br><br><CENTER><h2 STYLE="color:RED">NO EXISTEN REGISTROS</h2></CENTER>-->
				<?php //}	?>
				
		
			</div>
		</div>
	</center>
	<?php  //} ?>
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



