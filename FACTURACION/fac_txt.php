<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
	
?>     

<script language="javascript" type="text/javascript">
  function es_vacio(){
  var ayo = document.getElementById("ayo").value;
	  if(ayo >0){
		document.getElementById("del").disabled=true
		document.getElementById("al").disabled=true
	  }
	  else{
		document.getElementById("del").disabled=false
		document.getElementById("al").disabled=false
	  }
	}
	function es_vacio2(){
  var qna = document.getElementById("qna").value;
	  if (qna>0){
		document.getElementById("del").disabled=true
		document.getElementById("al").disabled=true
	  }
	  else{
		document.getElementById("del").disabled=false
		document.getElementById("al").disabled=false
	  }
	}
	function es_vacio3(){
  var del = document.getElementById("del").value;
	  if (del !="" ){
		document.getElementById("qna").disabled=true
		document.getElementById("ayo").disabled=true
	  }
	  else{
		document.getElementById("qna").disabled=false
		document.getElementById("ayo").disabled=false
	  }
	}
	function es_vacio4(){
  var al = document.getElementById("al").value;
	  if (al !=""){
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
	$sql_ayo="select DISTINCT(ayo)  from seCTOR.DBO.C_PERIODO_QNAS";       
	$res_ayo = sqlsrv_query($conn,$sql_ayo); 
			  
	$sql_qna="select DISTINCT(Qna)  from seCTOR.DBO.C_PERIODO_QNAS";       
	$res_qna = sqlsrv_query($conn,$sql_qna); 
	
	$sql_sector="select SECTOR from sector.dbo.C_Sector where SECTOR>50 GROUP BY SECTOR ORDER BY SECTOR";       
	$res_sector = sqlsrv_query($conn,$sql_sector); 			
  ?>
                   
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        TIMBRADO
                        <small></small>
                    </h1>                    
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center">   
						<div  class="col-md-3 col-sm-3 col-xs-3">	<br>
							<center><label>SECTOR:</label></center>				
							<select name="sector" class="form-control" id="sector">
								<option value="" selected="selected">SELECC...</option>
								<?php	while($row_sector = sqlsrv_fetch_array($res_sector)){ ?>						
									<option value="<?php echo $row_sector['SECTOR']; ?>" ><?php echo $row_sector['SECTOR']; ?></option>
								<?php } ?>
							</select>     
						</div>		
                        
                        <div  class="col-md-2 col-sm-2 col-xs-2"><br>
							<center><label>AÑO:</label></center>
                                                        <select name="usuario" class="form-control" style="text-align:center;"  onchange="es_vacio()"   id="ayo"  onBlur="es_vacio()" >
								<option value="" selected="selected">SELECC...</option>
								<?php	while($row_ayo = sqlsrv_fetch_array($res_ayo)){ 		?>
									<option value="<?php echo @$row_ayo['ayo']; ?>" ><?php echo @$row_ayo['ayo']; ?></option>
								<?php } ?>
							</select>
						</div>	
						<div  class="col-md-2 col-sm-2 col-xs-2"><br>	
						</div>
							
						<div  class="col-md-5 col-sm-5 col-xs-5">
							<center><label style="color:#337ab7; margin:0px;">PERIODO</label></center>
							<div  class="col-md-6 col-sm-6 col-xs-6">
								<center><label>DEL:</label></center>
								<input type="date" name="del"  value="<?php echo $del;?>" id="del"  style="text-align:center;" onchange="es_vacio3()" class="form-control" >
							</div>	
							<div  class="col-md-6 col-sm-6 col-xs-6">	
								<center><label>AL:</label></center>
								<input type="date" name="al"  value="<?php echo $al;?>" id="al" style="text-align:center;" onchange="es_vacio4()"  class="form-control" >
							</div>
						</div>
						<div  class="col-md-12 col-sm-12 col-xs-12"><br>
							<button  type="button" onclick="detalle()" class="btn btn-primary center-block">BUSCAR</button>
                            <br><br>
						</div>
						<div id="tb3" style="display: none;"></div> 

                    </div>                                    
                </div>                
            </section>
            </div>
            
            <?php include_once '../footer.html'; ?>
            <script>
    function detalle(){
        var url = "<?php echo BASE_URL; ?>includes/FACTURACION/sec_txt.php";
	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				Ayo: $('#ayo').val(),
				Sector: $('#sector').val(),
				Del: $('#del').val(),
				Al: $('#al').val()
            },
            success: function (data)
            {
                $("#tb3").html(data); // Mostrar la respuestas del script PHP.
                document.getElementById("tb3").style.display="block";                  
            }
        });
        
    return false;
//        $('#myModaldestto').modal('show');

    }
    
    function timbrado(ayo,id){
        
        if(id==0){id=''}       
        if(ayo==0){ayo=''}
        
        var url = "<?php echo BASE_URL; ?>FACTURACION/archivotimbrado.php";	
        $.ajax({
            type: "POST",
            url: url,
            data: {
				recibo: id,
				ayo: ayo,				
            },
            success: function (data)
            {
             detalle();
            }
        });
        return false;
    }
    function masivo(ayo,Sector,Del,Al){
                       
        if(ayo==0){ayo=''}
        if(Sector==0){Sector=''}
        if(Del==0){Del=''}
        if(Al==0){Al=''}
        
        var url = "<?php echo BASE_URL; ?>FACTURACION/archivomasivo.php";	
        $.ajax({
            type: "POST",
            url: url,
            data: {				
				ayo: ayo,				
				Sector: Sector,				
				Del: Del,				
				Al: Al,				
            },
            success: function (data)
            {
             detalle();
            }
        });
        return false;
    }
            </script>



