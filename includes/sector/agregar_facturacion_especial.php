<?php
include '../../conexiones/sqlsrv.php';
error_reporting(0);
$conn = connection_object();
 session_start();
 $idOp=$_SESSION['ID_OPERADOR'];	
 @$usuario=$_REQUEST['usuario'];
 @$ayo=$_REQUEST['ayo'];
 @$qna=$_REQUEST['qna'];
 @$inicio=$_REQUEST['inicio'];
 @$finr=$_REQUEST['fin'];
 @$count=$_REQUEST['count'];
 if(@$_REQUEST['iva']==1){ @$iva=@$_REQUEST['iva']; }else{ @$iva=0;	}
 if(@$_REQUEST['perio']==1){	@$inicio="'".$_REQUEST['inicio']."'"; @$fin="'".$_REQUEST['fin']."'"; } else{ @$inicio='NULL'; @$fin='NULL'; }
 $format="d/m/Y";
 $format1="Y/m/d"; 
 $html = "";
 $var_folio=$idOp.''.date('d').''.date('m').''.date('Y').''.date('h').''.date('i').''.date('s');
 
 //VALIDACIONES
 
 if(@$_REQUEST['ayo'] >0){$ayo = $ayo;} else {$ayo = 'NULL';}
 if(@$_REQUEST['qna'] >0){$qna = $qna;} else {$qna = 'NULL';}
 
 
 @$sql_sp = "select FECHA_INI, FECHA_FIN from  sector.dbo.C_Periodos_Facturacion where ayo=$ayo and qna=$qna";
 @$res_sp = sqlsrv_query($conn,$sql_sp);
 @$row_sp = sqlsrv_fetch_array($res_sp);

 @$inia=date_format(@$row_sp['FECHA_INI'], $format1);
 @$fina=date_format(@$row_sp['FECHA_FIN'], $format1);
 
 if(@$inicio != ""){ $ini = $inicio; }else{ $ini = date_format(@$row_sp['FECHA_INI'], $format1); }
 if(@$finr   != ""){ $fin = $finr;   }else{ $fin = date_format(@$row_sp['FECHA_FIN'], $format1); }
 
 if(@$fin   != ""){ $fin=$fin; } else { $fin=NULL; }
 if(@$inicio   != ""){$inicio=$inicio;} else { $inicio=NULL; }

  
 @$sql_val = "select count(*) CUANTOS from facturacion.[dbo].[Factura] where id_usuario='$usuario' and ayo=$ayo and PERIODO_INICIO = '$ini' and PERIODO_FIN ='$fin'";
 @$res_val = sqlsrv_query($conn,$sql_val);
 @$row_val = sqlsrv_fetch_array($res_val);
 @$cuantos = $row_val['CUANTOS'];
 // VALIDACIONES
 if(@$cuantos <= 0){
 
 
 
 if ($count > 0) {

    $cont2 = 1;
    while ($cont2 <= $count) {
        $turnos = "turnos" . $cont2;
        $importe = "importe" . $cont2;
        $tarifa = "tarifa" . $cont2;
        $leyenda = "leyenda" . $cont2;
        $montod = "montod" . $cont2;
        $leyendad = "leyendad" . $cont2;

        @$turnos2 = @$_REQUEST[@$turnos];
        @$importe2 = @$_REQUEST[@$importe];
        @$tarifa2 = @$_REQUEST[@$tarifa];
        @$leyenda2 = @$_REQUEST[@$leyenda];
        @$leyendad2 = @$_REQUEST[@$leyendad];
        @$montod2 = @$_REQUEST[@$montod];

        if(@$turnos2==''){ $turnos2=NULL; }
        if(@$importe2==''){ $importe2=NULL; }
        if(@$tarifa2==''){ $tarifa2=NULL; }
        if(@$montod2==''){ $montod2='NULL'; }
				
	 		$sql_gt = "execute facturacion.[dbo].[sp_Fac_Paso] '$usuario',$ayo,$qna,$turnos2,$tarifa2,$importe2,'$leyenda2',$idOp,$iva,$inicio,'$finr',$montod2,'$leyendad2',$var_folio,$cont2";
			$res_gt = sqlsrv_query($conn,$sql_gt);
			 
			if($cont2 == $count){
				$sql_agrega ="exec facturacion.[dbo].[sp_Guarda_Factura_Especial] $var_folio ";
				$res_agrega = sqlsrv_query($conn,$sql_agrega);
				$row_agrega = sqlsrv_fetch_array($res_agrega);
				$valor=trim($row_agrega['VALOR']); 
				$mensaje=trim($row_agrega['mensaje']);  
				
				if($valor==1){ 
					$html.="				
						<br><br><br><div  class='col-md-12 col-sm-12 col-xs-12'>&nbsp;<br></div>
						<div  class='col-md-12 col-sm-12 col-xs-12' >
						<div class='alert alert-success' role='alert'>
							<strong>EXITO!</strong> SE GUARDO CORRECTAMENTE
						</div>";
				}else{	
					$html.="
						<br><br><div class='alert alert-danger' role='alert'>
							<strong>CUIDADO!</strong>NO SE GUARDO
						</div>
						</div>";
					} 
			}
            
        
        $cont2++;
    }
}
				
 } else {
	 $html.="<br><br><br><div class='alert alert-danger' role='alert'>
						<strong>CUIDADO!</strong> NO PUEDE CAPTURAR LA FACTURA ESPECIAL EN ESTA QUINCENA, YA ESTA CAPTURADA
					</div>
				</div>";
	 
 }
 
		echo $html;			  
		
?>
		
		<script src="../dist/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() { setTimeout(function() { $(".alert-success").fadeOut(3000);	},4000);	});
			$(document).ready(function() { setTimeout(function() { $(".alert-danger").fadeOut(3000);	},4000);    });
		</script>