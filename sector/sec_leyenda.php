<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
		$ope=0;
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

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        SISTEMA FACTURACIÓN - SECTOR
                        <small>LEYENDA</small>
                    </h1>                    
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center">   
					<h2><?php echo $usuario.' - '.$social_sql; ?></h2>
						<h3><?php echo 'SERVICIO '.$servicio; ?></h3>
						
			<div  class="col-md-3 col-sm-3 col-xs-3">	</div>
			<div  class="col-md-6 col-sm-6 col-xs-6">	
				<center><label>LEYENDA:</label></center>
				<textarea class="form-control" rows="5" id="comment" name="leyenda"><?php echo $leyenda_sql; ?></textarea>
			</div>	
			<div  class="col-md-6 col-sm-6 col-xs-6"><br>
			<?php if($leyenda_sql==""){ ?>
				<button name="boton"  value="guardar" class="btn btn-primary center-block">GUARDAR</button>
			<?php } ?>
			</div>			
			<div  class="col-md-6 col-sm-6 col-xs-6"><br>
			<?php if($leyenda_sql!=""){ ?>
				<button name="boton"  value="actualizar" class="btn btn-success center-block">ACTUALIZAR</button>
			<?php } ?>
			</div>			
			<?php if(@$_REQUEST["boton"] == "guardar" ){ 
			    $sql_reporte ="exec facturacion.dbo.sp_Inserta_Leyenda 1,'$usuario',$servicio,'$leyenda',$ope";
				$res_reporte = sqlsrv_query($conn,$sql_reporte );
				if($res_reporte>0){ ?>
					<script type ="text/javascript">  window.location="sec_leyenda.php?usuario=<?php echo $usuario; ?>&servicio=<?php echo$servicio; ?>";</script>
					<?php	}else{ ?>
					<script type ="text/javascript">  window.location="sec_leyenda.php?usuario=<?php echo $usuario; ?>&servicio=<?php echo$servicio; ?>&a=1";</script>
					<?php }	}  ?>
				
			<?php   ?>
			<?php if(@$_REQUEST["boton"] == "actualizar" ){ 
			    $sql_reporte ="exec facturacion.dbo.sp_Inserta_Leyenda 2,'$usuario',$servicio,'$leyenda',$ope";
				$res_reporte = sqlsrv_query( $conn,$sql_reporte);
				if($res_reporte>0){ ?>
					<script type ="text/javascript">  window.location="sec_leyenda.php?usuario=<?php echo $usuario; ?>&servicio=<?php echo $servicio; ?>";</script>
					<?php 	}else{ ?>
					<script type ="text/javascript">  window.location="sec_leyenda.php?usuario=<?php echo $usuario; ?>&servicio=<?php echo$servicio; ?>&a=1";</script>
					<?php }		}		 ?>
				
			<?php   ?>
                    </div>                                    
                </div>                
            </section>
            </div>
            
            <?php include_once '../footer.html'; ?>
          



