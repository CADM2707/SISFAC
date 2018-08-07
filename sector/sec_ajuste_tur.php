<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
		
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
  function Accion(){
  var accion = document.getElementById("accion").value;
	  if(accion == 1 ){
		document.getElementById("captura").style.display="block";
		document.getElementById("consulta").style.display="none";
		document.getElementById("consulta_datos").style.display="none";
	  }if(accion == 2 ){
		document.getElementById("consulta").style.display="block";
		document.getElementById("captura").style.display="none";
		document.getElementById("captura_datos").style.display="none";
		document.getElementById("mensaje_ajuste").style.display="none";
		
	  }
	}

  </script>
  
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        AJUSTE DE TURNOS SIN ELEMENTOS
                        <small></small>
                    </h1>                    
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center">   
					<div  class="col-md-5 col-sm-5 col-xs-5" ></div>
					<div  class="col-md-2 col-sm-2 col-xs-2">
						<center><label>ACCION:</label></center>
						<select class="form-control" name="accion"  id="accion" onchange="Accion()"  required="required">
							<option value=""  >SELECCIONA...</option>		
							<option value=1  >CAPTURA</option>		
							<option value=2  >REPORTE</option>		
						</select> 
					</div>
					<div id="captura"  style="display: none;">
						<div  class="col-md-12 col-sm-12 col-xs-12"></div>
						<div  class="col-md-5 col-sm-5 col-xs-5"></div>
						<div  class="col-md-2 col-sm-2 col-xs-2"><br>
							<center><label>ID USUARIO:</label></center>
							<input type="text" name="usuario"  value="<?php echo $usuario;?>" id="usuario" style="text-align:center;"  class="form-control"  onchange="Usuario()">
						</div>
					</div>	
					<div id="captura_datos"  style="display: none;">&nbsp;</div> 
					<div id="mensaje_ajuste"  style="display: none; margin-top: 380px;">&nbsp;</div> 
					<div id="consulta" style="display: none;">
						<br><br><br><br>
						
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>AÑO:</label></center>
							<input type="number" name="ayo"  id="ayo" value="<?php echo @$ayo;?>" style="text-align:center;"   class="form-control" >
						</div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>QNA.:</label></center>
							<input type="number" name="qna" id="qna"  value="<?php echo @$qna;?>" style="text-align:center;"  class="form-control" >
						</div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>ID USUARIO:</label></center>
							<input type="number" name="usuario2" id="usuario2"  value="<?php echo @$usuario2;?>" style="text-align:center;"  class="form-control"  >
						</div>
						<div  class="col-md-2 col-sm-2 col-xs-2">
							<center><label>OPERADOR:</label></center>
							<input type="number" name="operador"  id="ope" value="<?php echo @$ope;?>" style="text-align:center;"   class="form-control" >
						</div>
						<div  class="col-md-3 col-sm-3 col-xs-3">	
							<center><label>FECHA:</label></center>
							<input type="date" name="fecha" id="fecha" value="<?php echo @$al;?>" style="text-align:center;"  class="form-control" >
						</div>
						<div  class="col-md-12 col-sm-12 col-xs-12"><br>
							<button  type="button" onclick="Reporte()" class="btn btn-primary center-block">BUSCAR</button>
						</div><br><br><br><br><br><br><br><br>
						<div id="consulta_datos"  style="display: none;">	
						</div> 
			
                    </div>                                    
                </div>                
            </section>
            </div>
            
            <?php include_once '../footer.html'; ?>
 
          
<script>
	function Usuario(){
        var url = "<?php echo BASE_URL; ?>includes/sector/ajuste_datos.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {

				Usuario: $('#usuario').val()
				
            },
            success: function (data)
            {
                $("#captura_datos").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("captura_datos").style.display="block";                  
            }
        });
    }
	function Reporte(){
        var url = "<?php echo BASE_URL; ?>includes/sector/reporte_ajuste_datos.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {

				Usuario: $('#usuario2').val(),
				Ayo: $('#ayo').val(),
				Qna: $('#qna').val(),
				Ope: $('#ope').val(),
				Fecha: $('#fecha').val()
				
            },
            success: function (data)
            {
                $("#consulta_datos").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("consulta_datos").style.display="block";                  
            }
        });
    }
	function Agregar_ajuste(){
        var url = "<?php echo BASE_URL; ?>includes/sector/agregar_ajuste_sin.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {

				Usuario: $('#usuario').val(),
				Turnos: $('#turnos').val(),
				Ayo: $('#ayo').val(),
				Qna: $('#qna').val(),
				Servicio: $('#servicio').val()
				
            },
            success: function (data)
            {
                $("#mensaje_ajuste").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("mensaje_ajuste").style.display="block";                  
            }
        });
    }
	
</script>

