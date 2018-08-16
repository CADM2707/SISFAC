<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
	session_start();
	$idOp=$_SESSION['ID_OPERADOR'];	
		
		
		/*				
		@CVE_SITUACION AS TINYINT
		*/
		$sql_situacion="select CVE_SITUACION,SITUACION from facturacion.dbo.Factura_C_Situacion";       
		$res_situacion = sqlsrv_query($conn,$sql_situacion); 
	
	
		@$usuario=$_REQUEST['usuario'];
		@$servicio=$_REQUEST['servicio'];
		@$sql_reporte ="exec facturacion.dbo.sp_Inserta_Leyenda 3,'$usuario',$servicio,'',$ope";
		@$res_reporte = sqlsrv_query($conn,$sql_reporte );
		@$row =sqlsrv_fetch_array(@$res_reporte);
		@$leyenda_sql=trim($row['LEYENDA']);
		@$sql_reporte2 ="select R_SOCIAL from sector.dbo.v_usuario_padron where ID_USUARIO='$usuario'";
		@$res_reporte2 = sqlsrv_query( $conn,$sql_reporte2);
		@$row2 = sqlsrv_fetch_array($res_reporte2);
		@$social_sql=trim($row2['R_SOCIAL']);
		
?>   

<script language="javascript" type="text/javascript">
  function Id_usuario(){
  var accion = document.getElementById("accion").value;
	  if(accion !=""  ){
		document.getElementById("datos_usuario").style.display="block";
	  }
	}
	
  function Operacion(){
  var tarifa = document.getElementById("tarifa").value;
  var turnos = document.getElementById("turnos").value;
  var suma = parseInt(tarifa) * parseInt(turnos);
      $("#importe").val(suma);
	}
 function Operacion2(){
  var tarifa = document.getElementById("tarifa").value;
  var turnos = document.getElementById("turnos").value;
  var suma = parseInt(tarifa) * parseInt(turnos);
      $("#importe").val(suma);
	}	

  </script>   
  <script>
a = 0;
function addCancion(){
        a++;

        var div = document.createElement('div');
        div.setAttribute('class', 'form-inline');
            div.innerHTML = '	<div class="row"> <div class="cancion_'+a+' col-md-2"">																				<input class="form-control" id="turnos'+a+'" name="turnos[]" type="text"/></div>  <div class="cancion_'+a+' col-md-2"">									<input class="form-control" id="tarifa'+a+'" name="tarifa[]" type="text"/></div>	  <div class="cancion_'+a+' col-md-2"">								<input class="form-control" id="importe'+a+'" name="importe[]" type="text"/></div>   <div class="cancion_'+a+' col-md-4"">									<input class="form-control" id="leyenda'+a+'" name="leyenda[]" type="text"/></div></div>	';
            document.getElementById('canciones').appendChild(div);document.getElementById('canciones').appendChild(div);
			if(a>0){
				document.getElementById("boton").style.display="block";
			}
			$("#count").val(a);
}
</script>
  
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        FACTURACION ESPECIAL
                        <small></small>
                    </h1>                    
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center">   
						<div  class="col-md-3 col-sm-3 col-xs-3"></div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>ID USUARIO:</label></center>
							<input type="text" name="usuario"   value="<?php echo $usuario;?>" id="usuario" style="text-align:center;"  class="form-control"  >
						</div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>AÑO:</label></center>
							<input type="number" name="ayo"  id="ayo" value="<?php echo @$ayo;?>" style="text-align:center;"   class="form-control" >
						</div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>QNA:</label></center>
							<input type="text" name="qna" id="qna"  onchange="Id_usuario()" value="<?php echo @$qna;?>" style="text-align:center;"  class="form-control"  >
							<input type="hidden" name="count" id="count"   >
						</div>
						<br>
						<div id="consulta_datos"  style="display: none;">	</div> 
						<div id="datos_usuario"  style="display: none;">	</div>                                                       
                </div>                
            </section>
            </div>
            
            <?php include_once '../footer.html'; ?>
 
          
<script>	
	function Reporte(){
        var url = "<?php echo BASE_URL; ?>includes/sector/agregar_facturacion_especial.php";
		var count = document.getElementById("count").value;
		
        
		//for(indice = 0; indice < count; indice++){
					
			$.ajax({
				type: "POST",
				url: url,
				data: {
					Usuario: $('#usuario').val(),
					Ayo: $('#ayo').val(),
					Qna: $('#qna').val(),
					'username[]': users,
					
					Importe: $('#importe').val(),
					Tarifa: $('#tarifa').val(),
					Leyenda: $('#leyenda').val(),				
					
					Count: $('#count').val()				
				},
				success: function (data)
				{
					$("#consulta_datos").html(data); // Mostrar la respuestas del script PHP.
					document.getElementById("consulta_datos").style.display="block";   
					   
							
				}
			}); 		
		//}
		var url = "<?php echo BASE_URL; ?>includes/sector/consulta_facturacion_especial.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Usuario: $('#usuario').val()	,			
				Ayo: $('#ayo').val(),				
				Qna: $('#qna').val()				
            },
            success: function (data)
            {
               $("#datos_usuario").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("datos_usuario").style.display="block";					
            }
        });
    }	
	function Id_usuario(){
        var url = "<?php echo BASE_URL; ?>includes/sector/consulta_facturacion_especial.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Usuario: $('#usuario').val(),
				Ayo: $('#ayo').val(),				
				Qna: $('#qna').val()
            },
            success: function (data)
            {
                $("#consulta_datos").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("consulta_datos").style.display="block";                  
            }
        });
    }	
</script>
   
