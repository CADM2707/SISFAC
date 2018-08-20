<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();


 @$usu=$_REQUEST['usu'];


$sql_reporte ="select R_SOCIAL,RFC,SECTOR,DESTACAMENTO,convert(date,FECHA_ALTA) FECHA_ALTA, SITUACION from sector.dbo.v_usuario_padron where ID_USUARIO='$usuario'";
$res_reporte = sqlsrv_query($conn,$sql_reporte);

?>
<br><br><br><br><br><br>
	<center>
		<div class="panel-body" style="width:100%">
				<?php $row_reporte = sqlsrv_fetch_array($res_reporte, SQLSRV_FETCH_ASSOC);

				$fecha= date_format($row_reporte['FECHA_ALTA'], $format);

?>

                
               <!--//////////////////////////////////////// Consulta segunda-->
                <?php $sql_usu ="select R_SOCIAL,RFC,SECTOR,DESTACAMENTO,convert(date,FECHA_ALTA) FECHA_ALTA, SITUACION from sector.dbo.v_usuario_padron where ID_USUARIO='$id_fac'";
				$res_usu = sqlsrv_query($conn,$sql_usu); 
				
				$row_usu = sqlsrv_fetch_array($res_usu, SQLSRV_FETCH_ASSOC);
				
				?>
                
                <div  class="col-md-5 col-sm-5 col-xs-5"></div>
                <div  class="col-md-2 col-sm-2 col-xs-2"><br>
							<center><label>ID USUARIO FACTURA:</label></center>
							<input type="text" name="usu" class="form-control" id="usu" value="<?php echo @$id_fac;?>" onFocus="rellenar">
						</div>
                        
              <div  class="col-md-12 col-sm-12 col-xs-12"><br>
				<button name="boton"  value="reporte" class="btn btn-primary center-block">BUSCAR</button>
			</div>	
                        
                        <br><br>
                <br><br><br>
                <h2><?php echo $id_fac.' '.$row_usu['R_SOCIAL'].' '; ?></h2>
                <div  class="col-md-2 col-sm-2 col-xs-2"></div>
                <div  class="col-md-2 col-sm-2 col-xs-2">
					<center><label>	RFC:</label></center>
					<input type="text" name=""  value="<?php echo $row_usu['RFC'];?>" style="text-align:center;"  class="form-control" disabled >
				</div>
				
				<div  class="col-md-2 col-sm-2 col-xs-2">
					<center><label>	SITUACION:</label></center>
					<input type="text" name=""  value="<?php echo $row_usu['SITUACION'];?>" style="text-align:center;"  class="form-control"  disabled>
				</div>
				<div  class="col-md-2 col-sm-2 col-xs-2">
					<center><label>	SECTOR:</label></center>
					<input type="text" name=""  value="<?php echo $row_usu['SECTOR'];?>" style="text-align:center;"  class="form-control"  disabled>
				</div>
				<div  class="col-md-2 col-sm-2 col-xs-2">
					<center><label>	DESTACAMENTO:</label></center>
					<input type="text" name=""  value="<?php echo $row_usu['DESTACAMENTO'];?>" style="text-align:center;"  class="form-control"  disabled>
				</div><BR><BR><BR><BR>
                
                
                <!-- ///////////////////////////////////////////////// -->


                        </div>

                    </div>
                </div>
            </section>
            </div>
            
            
			