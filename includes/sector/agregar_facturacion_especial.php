<?php
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 session_start();
 $idOp=$_SESSION['ID_OPERADOR'];	
 @$usuario=$_REQUEST['usuario'];
 @$ayo=$_REQUEST['ayo'];
 @$qna=$_REQUEST['qna'];
 @$count=$_REQUEST['count'];
 if(@$_REQUEST['iva']==1){ @$iva=@$_REQUEST['iva']; }else{ @$iva=0;	}
 if(@$_REQUEST['perio']==1){	@$inicio="'".$_REQUEST['inicio']."'"; @$fin="'".$_REQUEST['fin']."'"; } else{ @$inicio='NULL'; @$fin='NULL'; }
 $format="d/m/Y"; 
 $html = "";
 $var_folio=$idOp.''.date('d').''.date('m').''.date('Y').''.date('h').''.date('i');
 
 if ($count > 0) {

    $cont2 = 1;
    while ($cont2 <= $count) {
        $turnos = "turnos" . $cont2;
        $importe = "importe" . $cont2;
        $tarifa = "tarifa" . $cont2;
        $leyenda = "leyenda" . $cont2;
        $montod = "montod" . $cont2;
        $leyendad = "leyendad" . $cont2;

        $turnos2 = $_REQUEST[$turnos];
        $importe2 = $_REQUEST[$importe];
        $tarifa2 = $_REQUEST[$tarifa];
        $leyenda2 = $_REQUEST[$leyenda];
        $leyendad2 = $_REQUEST[$leyendad];
        $montod2 = $_REQUEST[$montod];

        
         echo   $sql_agrega ="exec [sp_Captura_Facturacion_Especial] 
				'$usuario',$ayo,$qna,$turnos2,$tarifa2,$importe2,'$leyenda2',$idOp,$iva,$inicio,$fin,$montod2,'$leyendad2',$var_folio";
				$res_agrega = sqlsrv_query($conn,$sql_agrega);
				$row_agrega = sqlsrv_fetch_array($res_agrega);
				$mensaje=$row_agrega['MENSAJE']; 
				if($mensaje=="CAPTURA DE FACTURA ESPECIAL CORRECTAMENTE"){ 
				$html.="				
				<br><br><br><div  class='col-md-12 col-sm-12 col-xs-12'>&nbsp;<br></div>
				<div  class='col-md-12 col-sm-12 col-xs-12' >
					<div class='alert alert-success' role='alert'>
					  <strong>EXITO!</strong> $mensaje
					</div>";
					}else if($mensaje=="NO PUEDE CAPTURAR LA FACTURA ESPECIAL, YA SE ENCUENTRA VALIDADA"){	
				$html.="
					<br><br><div class='alert alert-danger' role='alert'>
						<strong>CUIDADO!</strong> $mensaje
					</div>
				</div>";
			 } 
            
        
        $cont2++;
    }
}
 
 
				
					  
		echo $html;			  

?>
		<!--<script>
			function r() { location.href="sec_facturacion_especial.php" } 
			setTimeout ("r()", 5000);
		</script>-->
		<script src="../dist/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() { setTimeout(function() { $(".alert-success").fadeOut(3000);	},4000);	});
			$(document).ready(function() { setTimeout(function() { $(".alert-danger").fadeOut(3000);	},4000);    });
		</script>