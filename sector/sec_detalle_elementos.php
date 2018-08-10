<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
	
	
	 @$ayo=$_REQUEST['ayo'];
	 @$usuario=$_REQUEST['usuario'];
	 @$qna=$_REQUEST['qna'];
	 $format="d/m/Y";
	
		
?>      

  
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        AJUSTE DE TURNOS SIN ELEMENTOS <a href="sec_solicitud.php" class='btn btn-warning pull-right'><i class="fa fa-undo" aria-hidden="true"></i> Regresar</a>
                        <small></small>
                    </h1>                    
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center">   
					<?php 
						$html = "";
$html.="
<div  class='col-md-12 col-sm-12 col-xs-12'><br><center><a href='reportes/ajuste_sin_elementos.php?ayo=$ayo&qna=$qna&usuario=$usuario' class='btn btn-warning btn-sm' >Reporte</a><br></div><br><br><br><br>
<table    class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:10px;'>
<thead>   
  <tr>
    <td align='center' class='bg-primary'><b>ID ELEMENTO</td>
    <td align='center' class='bg-primary'><b>NOMBRE</td>
    <td align='center' class='bg-primary'><b>MARCA</td>
    <td align='center' class='bg-primary'><b>TIPO TURNO</td>
    <td align='center' class='bg-primary'><b>FECHA</td>
  </tr>
 </thead>
  <tbody>";
  $SQL="exec sp_Consulta_Detalle_Turnos '$usuario',$qna,$ayo";
  $res = sqlsrv_query( $conn,$SQL);
 
	while($row = sqlsrv_fetch_array($res)){		
		$fecha=date_format($row['FECHA'], $format); 
		$marca=$row['MARCA'];
		$elemento=$row['ID_ELEMENTO'];
		$nombre=$row['NOMBRE'];
		$turno=$row['TIPO_TURNO'];		
  $html.="<tr>
   <td> $elemento </td>
   <td>".utf8_encode($nombre)." </td>
   <td> $marca </td>
   <td> $turno </td>
   <td> $fecha </td>";
	  
	$html.="</tr>";
	}
     
	 $html.="
  </tbody>
</table>";
					  
		echo $html;	
					?>
				
					</div>                
            </section>
            </div>
            
            <?php include_once '../footer.html'; ?>
 
          






