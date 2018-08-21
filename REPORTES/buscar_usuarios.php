<?php
include_once '../config.php';

//Variable de búsqueda
$consultaBusqueda = $_POST['valorBusqueda'];

//Variable vacía (para evitar los E_NOTICE)
$mensaje = "";

//Comprueba si $consultaBusqueda está seteado
if(isset($consultaBusqueda)){
	//Selecciona todo de la tabla de BD 
	$consulta = "SELECT ID_USUARIO,R_SOCIAL, SECTOR, DESTACAMENTO, REGION, TIPO_USUARIO, TIPO_SECTOR 
	             FROM V_usuario_padron 
				 WHERE CVE_SITUACION = 1 AND (ID_USUARIO LIKE '$consultaBusqueda%' OR R_SOCIAL LIKE '%$consultaBusqueda%')
				 GROUP BY ID_USUARIO,R_SOCIAL, SECTOR, DESTACAMENTO, REGION, TIPO_USUARIO, TIPO_SECTOR ORDER BY ID_USUARIO";
    $res_usuario1 = sqlsrv_query($conn,$consulta);
	$filas = sqlsrv_has_rows($res_usuario1);
	
	//Si existen registros
	if ($filas === true){ 
	    //Si existe alguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
		//echo '<br>Resultados para <strong>'.$consultaBusqueda.'</strong><br><br>';

		//Output
		$mensaje .= "<br>";
		$mensaje .= "<table class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:12px;'>";
		$mensaje .= "<thead>";
		$mensaje .= "<tr>";
		$mensaje .= "<td align='center'><b>ID USUARIO</b></td>";
		$mensaje .= "<td align='center'><b>RAZON SOCIAL</b></td>";
		$mensaje .= "<td align='center'><b>SECTOR</b></td>";
		$mensaje .= "<td align='center'><b>DESTACAMENTO</b></td>";
		$mensaje .= "<td align='center'><b>REGIÓN</b></td>";
		$mensaje .= "<td align='center'><b>TIPO USUARIO</b></td>";
		$mensaje .= "<td align='center'><b>TIPO SECTOR</b></td>";
		$mensaje .= "</tr>";
		$mensaje .= "</thead>";
		$mensaje .= "<tbody>";
			
		//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle
		$i=1;
		while($resultados = sqlsrv_fetch_array($res_usuario1)){
			if($i%2==0){ $color="#E1EEF4"; } else{ $color="#FFFFFF"; }
			
			$idusuario = $resultados['ID_USUARIO'];
			$rsocial = $resultados['R_SOCIAL'];
			$sector = $resultados['SECTOR'];
			$destacamento = $resultados['DESTACAMENTO'];
			$region = $resultados['REGION'];
			$tusuario = $resultados['TIPO_USUARIO'];
			$tsector = $resultados['TIPO_SECTOR'];

			//Output
			$mensaje .= "<tr bgcolor='".$color."'>";
			$mensaje .= "<td>".$idusuario."</td>";
			$mensaje .= "<td>".utf8_encode($rsocial)."</td>";
			$mensaje .= "<td>".$sector."</td>";
			$mensaje .= "<td>".$destacamento."</td>";
			$mensaje .= "<td>".utf8_encode($region)."</td>";
			$mensaje .= "<td>".utf8_encode($tusuario)."</td>";
			$mensaje .= "<td>".utf8_encode($tsector)."</td>";
			$mensaje .= "</tr>";
						
		};//Fin while $resultados
		$mensaje .= "</tbody>";
		$mensaje .= "</table>";
		
	} else {
		$mensaje = "<br><div class='alert alert-danger'> <font style='font-size:16px;'> <b> NO EXISTE EL USUARIO </b> </font> </div>";
	}; //Fin else $filas
	
	echo $mensaje;
};
?>