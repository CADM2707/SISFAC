<style>
.button2 {
    background-color: white; 
    color: black; 
    border: 2px solid #008CBA;
}
</style>
<?php
set_time_limit(0);
session_start();
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 @$ayo=$_REQUEST['Ayo'];
 @$qna=$_REQUEST['Qna'];
 @$usuario=$_REQUEST['Usuario'];
 @$periodo=$_REQUEST['Periodo'];
 @$sec=$_SESSION['SECTOR'];
 
 if($periodo!=""){
	 $porciones = explode("-", $periodo);
	 $ayo=$porciones[0]; 
	 $qna=$porciones[1];  
	 $ini=$porciones[2];  
	 $fin=$porciones[3];  
	 $var_ayo=" AND AYO=$ayo ";  								
	 $var_qna=" AND QNA =$qna ";  								
	 $var_fet=" AND FECHA_INI='$ini'   AND FECHA_FIN='$fin'   ";  	
 }if($ayo!="" and $qna!=""){ 
	$c_sql="select	FECHA_INI,FECHA_FIN from sector.dbo.C_Periodos_Facturacion where AYO=$ayo and QNA=$qna";
	$c_res = sqlsrv_query( $conn,$c_sql);
	$c_row = sqlsrv_fetch_array($c_res);
	$format="Y/m/d";
	$ini=date_format($c_row['FECHA_INI'], $format); 
	$fin=date_format($c_row['FECHA_FIN'], $format);
	$var_ayo=" AND AYO=$ayo ";  								
	$var_qna=" AND QNA=$qna ";  								
	$var_fet=" AND FECHA_INI='$ini'   AND FECHA_FIN='$fin'   ";  	

 } 
 if($usuario!=""){ 			$var_usu=" AND ID_USUARIO='$usuario' ";		}else{  $var_usu=""; }			
 if($sec!=""){ 				$var_sec=" AND SECTOR=$sec";           		}else{  $var_sec=""; }	
	
 $html = "";
		
		$html.="	
		<div  class='col-md-12 col-sm-12 col-xs-12'><center><a href='reportes/solicitudes.php?ayo=$ayo&qna=$qna&usuario=$usuario&periodo=$periodo'  class='btn btn-warning btn-sm' >Reporte</a><br></div><br><br><br>
		<div >
			<table    class='table table-responsive '   border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:10px;'>
			<thead> 
			  <tr>
				<td  colspan='5' align='center' class='bg-primary'><b>GENERALES</td>
				<td  colspan='8' align='center' valign='middle' class='bg-secondary'><b>CONTRATADOS</td>
				<td  colspan='13' align='center'  valign='middle'  class='bg-primary'><b>FATIGA</td>
				<td  rowspan='2' align='center'  valign='middle'  class='bg-secondary'><b>PREVIO FACT.</td>
				<td  rowspan='2' align='center'  valign='middle'  class='bg-secondary'><b>ACCION</td>
			  </tr> 	
			  <tr>
				<td  align='center' class='bg-primary'><b>PRINCIPAL</td>
				<td  align='center' class='bg-primary'><b>ID USUARIO</td>
				<td  align='center' class='bg-primary'><b>ID SERVICIO</td>
				<td  width='15' align='center' class='bg-primary'><b>SECTOR</td>
				<td  width='15' align='center' class='bg-primary'><b>LEYENDA</td>
				<td  align='center' valign='middle' class='bg-secondary'><b>TARIFA</td>
				<td  align='center'  valign='middle'  class='bg-secondary'><b>TN</td>
				<td  align='center'  valign='middle'  class='bg-secondary'><b>TD</td>
				<td  align='center'  valign='middle'  class='bg-secondary'><b>TF</td>
				<td  align='center'  valign='middle'  class='bg-secondary'><b>JERARQUIA</td>
				<td  align='center'  valign='middle'  class='bg-secondary'><b>TUA</td>
				<td  align='center'  valign='middle'  class='bg-secondary'><b>TU</td>
				<td  align='center'  valign='middle'  class='bg-secondary'><b>TOTAL</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>F_TN</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>F_TD</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>F_TF</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>TA_MAS</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>TA_MENOS</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>TA_EXT_MAS</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>TA_EXT_MENOS</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>DEDUCTIVAS</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>F_TUA</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>F_TU</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>F_JERARQUIA</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>TOTAL</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>DIFERENCIA</td>
			  </tr>
			 </thead>
			<tbody>";
			
			$SQL="SELECT  ID_SOLICITUD,AYO,QNA,ID_USUARIO,ID_SERVICIO,PRINCIPAL,SECTOR,CVE_SITUACION,TARIFA,TN,TD,TF,JERARQUIA,ELEMENTOS,F_TN,F_TD,F_TF,TA_MAS, TA_MENOS,   TA_EXT_MAS,TA_EXT_MENOS, DEDUCTIVAS,TUA,	TU,	F_TUA	,F_TU,	F_JERARQUIA
			  FROM  V_Solicitud_Fac
				      WHERE ID_USUARIO IS NOT NULL  $var_ayo $var_usu  $var_fet $var_qna  $var_sec
					  order by PRINCIPAL,ID_USUARIO,ID_SERVICIO";
			$res = sqlsrv_query( $conn,$SQL);
			$prin2=0;	
			$usu2=0;	
			$a1=0;
			$a2=0;
			while($row = sqlsrv_fetch_array($res)){
				$principal=trim($row['PRINCIPAL']);
				$usuario=$row['ID_USUARIO'];
				$servicio=$row['ID_SERVICIO'];
				$sector=$row['SECTOR'];
				$tarifa=$row['TARIFA'];					
				$anio=$row['AYO'];					
				$qnas=$row['QNA'];					
				$soli=$row['ID_SOLICITUD'];					
				$t_tarifa2=@$t_tarifa2+$tarifa; 			$t_tarifa=number_format(@$t_tarifa2, 2, '.', ',');  $tt_tarifa=@$tt_tarifa+$tarifa;
				$tn=$row['TN']; 							$t_tn=@$t_tn+$tn;  									$tt_tn=@$tt_tn+$tn;	
				@$tua=$row['TUA']; 							@$t_tua=@$t_tua+@$tua;  								@$tt_tua=@$tt_tua+@$tua;
				@$tu=$row['TU']; 							@$t_tu=@$t_tu+@$tu;  								@$tt_tu=@$tt_tu+@$tu;
				@$f_tua=$row['F_TUA']; 						@$t_ftua=@$t_ftua+@$f_tua;  							@$tt_ftua=@$tt_ftua+@$f_tua;
				@$f_tu=$row['F_TU']; 						@$t_ftu=@$t_ftu+@$f_tu;  							@$tt_ftu=@$tt_ftu+@$f_tu;
				$f_jerarquia=$row['F_JERARQUIA']; 			if($f_jerarquia>0) {  }else{ $f_jerarquia=0; }
				@$t_fjerarquia=@$t_fjerarquia+@$f_jerarquia;  @$tt_fjerarquia=@$tt_fjerarquia+@$f_jerarquia;				
				$td=$row['TD']; 							$t_td=@$t_td+$td; 									$tt_td=@$tt_td+$td;
				$tf=$row['TF']; 							$t_tf=@$t_tf+$tf;									$tt_tf=@$tt_tf+$tf;
				$jerarquia=$row['JERARQUIA']; 			if($jerarquia>0) {  }else{ $jerarquia=0; }
				$t_jerarquia=@$t_jerarquia2+$jerarquia; 	$tt_jerarquia=@$tt_jerarquia+$jerarquia; 	
				$ftn=$row['F_TN']; 							$t_ftn=@$t_ftn+$ftn; 								$tt_ftn=@$tt_ftn+$ftn;
				$ftd=$row['F_TD']; 							$t_ftd=@$t_ftd+$ftd;								$tt_ftd=@$tt_ftd+$ftd;
				$ftf=$row['F_TF']; 							$t_ftf=@$t_ftf+$ftf;								$tt_ftf=@$tt_ftf+$ftf;
				$tamas=$row['TA_MAS']; 						$t_tamas=@$t_tamas+$tamas;							$tt_tamas=@$tt_tamas+$tamas;
				$tame=$row['TA_MENOS']; 					$t_tame=@$t_tame+$tame;								$tt_tame=@$tt_tame+$tame;
				$taextmas=$row['TA_EXT_MAS']; 			if($taextmas>0) {  }else{ $taextmas=0; }
				$t_taextmas=@$t_taextmas+$taextmas;			$tt_taextmas=@$tt_taextmas+$taextmas;
				$taextme=$row['TA_EXT_MENOS']; 			if($taextme>0) {  }else{ $taextme=0; }	
				$t_taextme=@$t_taextme+$taextme;			$tt_taextme=@$tt_taextme+$taextme;
				$deductiva=$row['DEDUCTIVAS']; 				$t_deductiva=@$t_deductiva+$deductiva;				$tt_deductiva=@$tt_deductiva+$deductiva;

				$s_contratados=$tn+$td+$tf+$jerarquia+$tua+$tu;	
				$s_fatiga=$ftn+$ftd+$ftf+$tamas+$tame+$taextmas+$taextme+$deductiva+$f_tua+$f_tu+$f_jerarquia;
				$s_diferencia=$s_contratados-$s_fatiga;
				@$t_v=@$t_v+@$s_contratados;
				@$t_v2=@$t_v2+@$s_fatiga;
				@$tt_v=@$tt_v+@$tn+@$td+@$tf+@$jerarquia+$tua+$tu;
				@$tt_v2=@$tt_v2+@$ftn+@$ftd+@$ftf+@$tamas+@$tame+@$taextmas+@$taextme+@$deductiva+$f_tua+$f_tu+$f_jerarquia;
				@$tsv2=@$tsv2+@$s_diferencia;
				@$tsv=@$tsv+(@$tn+@$td+@$tf+@$jerarquia+$tua+$tu)-(@$ftn+@$ftd+@$ftf+@$tamas+@$tame+@$taextmas+@$taextme+@$deductiva+$f_tua+$f_tu+$f_jerarquia);
				$a1++;				
				$a2++;				
			if($prin2<>$principal){
			$a2=1;	
			$prin2=$principal;
			$varprin="diferente";
								 
			$sql_count2="
					SELECT  COUNT(ISNULL(PRINCIPAL,0)) SUMA,PRINCIPAL
					FROM  V_Solicitud_Fac
							WHERE ID_USUARIO IS NOT NULL and PRINCIPAL='$principal'  $var_ayo $var_usu  $var_fet $var_qna $var_sec
							group by PRINCIPAL
							   order by PRINCIPAL ";
							
					$res_count2 = sqlsrv_query( $conn,$sql_count2);
					$row_count2 = sqlsrv_fetch_array($res_count2);
					$suma=trim($row_count2['SUMA']);
					
					
			$sql_count3="
			   SELECT count(distinct(ID_USUARIO)) COUNT_PRINCIPAL 
			  FROM  V_Solicitud_Fac
				      WHERE ID_USUARIO IS NOT NULL and PRINCIPAL='$principal' $var_ayo $var_usu  $var_fet $var_qna $var_sec
					  group by PRINCIPAL
					  order by PRINCIPAL ";	
					$res_count3 = sqlsrv_query( $conn,$sql_count3);
					$row_count3 = sqlsrv_fetch_array($res_count3);
					$suma2=trim($row_count3['COUNT_PRINCIPAL']);
					$suma3=$suma+$suma2+1;
					@$count_principal="rowspan='$suma3'";
					
					
		}else{
			$varprin="";
			
		}	
			if(trim($usu2)<>trim($usuario)){			
				$usu2=$usuario;
				$var2="diferente";
				$sql_count="  SELECT count(ID_USUARIO) COUNT,ID_USUARIO
							  FROM  V_Solicitud_Fac
								 WHERE ID_USUARIO IS NOT NULL and  ID_USUARIO='$usuario'  		 $var_ayo $var_usu  $var_fet $var_qna $var_sec
								 group by PRINCIPAL,ID_USUARIO 
								   order by PRINCIPAL,ID_USUARIO"; 
					$res_count = sqlsrv_query( $conn,$sql_count);
					$row_count = sqlsrv_fetch_array($res_count);
					$id_count=trim($row_count['ID_USUARIO']);
					$count=$row_count['COUNT'];				
					$count22=$row_count['COUNT'];				
					$count2=$count+1;
					
				if(@$usuario==@$id_count){	 $count="rowspan='$count2'";	}else{	$count="";	}	
					$a1=1;
					
				}else{
					$var2='';
				}																
				$html.="<tr>";
				if($varprin=='diferente'){
					$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><b> $principal </td>";
				}if($principal=='' and $var2=='diferente'){
					$html.="<td  $count align='center' style='vertical-align: middle;' ><b> - </td>";
				}if($var2=='diferente'){
					$html.="<td  $count align='center' style='vertical-align: middle;' ><b>$usuario </td>";
				}				
			$html.="				
				<td  align='center' ><b>$servicio </td>
				<td  align='center' ><b>$sector</td>
				<td  align='center' ><b><button onclick='modal3 (\"$usuario\",$servicio,$anio,$qnas)' type='button' class='btn bg-primary button2' style='font-size: 10px; '>LEYENDA</button></td>
				<td  align='center' valign='middle' ><b>$tarifa</td>
				<td  align='center'  valign='middle' ><b>$tn</td>
				<td  align='center'  valign='middle' ><b>$td</td>
				<td  align='center'  valign='middle' ><b>$tf</td>
				<td  align='center'  valign='middle' ><b>$jerarquia</td>
				<td  align='center'  valign='middle' ><b>$tua</td>
				<td  align='center'  valign='middle' ><b>$tu</td>
				<td  align='center'  valign='middle' ><b>$s_contratados</td>
				<td  align='center'  valign='middle' ><b>
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 1 , $servicio)' type='button' class='btn bg-primary button2' style='font-size: 10px; '>$ftn</button></td>
				<td  align='center'  valign='middle' ><b>
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 2 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$ftd</button></td>
				<td  align='center'  valign='middle' ><b>
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 3 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$ftf</button></td>
				<td  align='center'  valign='middle' ><b>
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 4 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$tamas</button></td>
				<td  align='center'  valign='middle' ><b>
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 5 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$tame</button></td>
				<td  align='center'  valign='middle' ><b>
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 6 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$taextmas</button></td>
				<td  align='center'  valign='middle' ><b>
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 7 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$taextme</button></td>
				<td  align='center'  valign='middle' ><b>
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 8 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$deductiva</button></td>
				<td  align='center'  valign='middle' ><b>
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 9 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$f_tua</button></td>
				<td  align='center'  valign='middle' ><b>
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 10 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$f_tu</button></td>
				<td  align='center'  valign='middle' ><b>
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 11 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$f_jerarquia</button></td>			
							<td  align='center'  valign='middle' ><b>$s_fatiga</td>
							<td  align='center'  valign='middle' ><b>$s_diferencia</td>";
				if($varprin=='diferente'){
					$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><b><a style='color:#337ab7;' href='../descargables/sector/pdf_previo_fact.php' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					$html.="
					<td $count_principal  align='center' style='vertical-align: middle;' ><b>
						<button onclick='modal ($anio, $qnas, \"$principal\", $soli)' type='button' class='btn bg-primary' >
							&nbsp;SOLICITAR
						</button>
					</td> 
					";
				}if($principal=='' and $var2=='diferente'){
					$html.="<td $count align='center' style='vertical-align: middle;' ><b> <a style='color:#337ab7;' href='../descargables/sector/pdf_previo_fact.php' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					$html.="<td $count align='center' style='vertical-align: middle;' ><b>
								<button onclick='modal ($anio, $qnas, \"$principal\" , $soli)' type='button' class='btn bg-primary' >
									 &nbsp;SOLICITAR
								</button>
							</td>
					";
				}
					$html.="</tr>";
				if(($count2-1)==$a1){
					$a2++;
					$html.="
					<tr class='bg-success'>
						<td  colspan='3' align='center' ><b>TOTALES </td>
						<td  align='center' ><b>$t_tarifa</td>
						<td  align='center' ><b>$t_tn</td>
						<td  align='center' valign='middle' ><b>$t_td</td>
						<td  align='center'  valign='middle' ><b>$t_tf</td>
						<td  align='center'  valign='middle' ><b>$t_jerarquia</td>
						<td  align='center'  valign='middle' ><b>$t_tua</td>
						<td  align='center'  valign='middle' ><b>$t_tu</td>
						<td  align='center'  valign='middle' ><b>$t_v</td>
						<td  align='center'  valign='middle' ><b>$t_ftn</td>
						<td  align='center'  valign='middle' ><b>$t_ftd</td>
						<td  align='center'  valign='middle' ><b>$t_ftf</td>
						<td  align='center'  valign='middle' ><b>$t_tamas</td>
						<td  align='center'  valign='middle' ><b>$t_tame</td>
						<td  align='center'  valign='middle' ><b>$t_taextmas</td>
						<td  align='center'  valign='middle' ><b>$t_taextme</td>
						<td  align='center'  valign='middle' ><b>$t_deductiva</td>	
						<td  align='center'  valign='middle' ><b>$t_ftua</td>	
						<td  align='center'  valign='middle' ><b>$t_ftu</td>	
						<td  align='center'  valign='middle' ><b>$t_fjerarquia</td>	
						<td  align='center'  valign='middle' ><b>$t_v2</td>	
						<td  align='center'  valign='middle' ><b>$tsv2</td>	
					</tr>";					
				}  
			    	if(@$suma3==(@$a2+1) and $principal!=""){
					$html.="
					<tr class='bg-danger'>
						<td  colspan='4' align='center' ><b>TOTALES</td>
						<td  align='center' ><b></td>
						<td  align='center' ><b>$tt_tn</td>
						<td  align='center' valign='middle' ><b>$tt_td</td>
						<td  align='center'  valign='middle' ><b>$tt_tf</td>
						<td  align='center'  valign='middle' ><b>$tt_jerarquia</td>
						<td  align='center'  valign='middle' ><b>$tt_tua</td>
						<td  align='center'  valign='middle' ><b>$tt_tu</td>
						<td  align='center'  valign='middle' ><b>$tt_v</td>
						<td  align='center'  valign='middle' ><b>$tt_ftn</td>
						<td  align='center'  valign='middle' ><b>$tt_ftd</td>
						<td  align='center'  valign='middle' ><b>$tt_ftf</td>
						<td  align='center'  valign='middle' ><b>$tt_tamas</td>
						<td  align='center'  valign='middle' ><b>$tt_tame</td>
						<td  align='center'  valign='middle' ><b>$tt_taextmas</td>
						<td  align='center'  valign='middle' ><b>$tt_taextme</td>
						<td  align='center'  valign='middle' ><b>$tt_deductiva</td>	
						<td  align='center'  valign='middle' ><b>$tt_ftua</td>	
						<td  align='center'  valign='middle' ><b>$tt_ftu</td>	
						<td  align='center'  valign='middle' ><b>$tt_jerarquia</td>		
						<td  align='center'  valign='middle' ><b>$tt_v2</td>	
						<td  align='center'  valign='middle' ><b>$tsv</td>	
					</tr>
				</div>			
					";
					
										
				
					
				} 		
				if(($count2-1)==$a1){			
					$t_tarifa=0; $t_tn=0; $t_td=0; $t_tf=0; $t_jerarquia=0; $t_ftn=0; $t_ftd=0; $t_ftf=0; $t_tamas=0; $t_tame=0; 
					$t_taextmas=0; $t_taextme=0; $t_deductiva=0; $t_tarifa2=0; $t_jerarquia2=0; $t_v=0; $t_v2=0; $tsv2=0;
					@$t_tua=0; 		@$t_tu=0;	@$t_ftua=0;	@$t_ftu=0; 	 	@$t_fjerarquia=0;

				}if(@$suma3==(@$a2+1) and $principal!=""){
					$tt_tarifa=0; $tt_tn=0; $tt_td=0; $tt_tf=0; $tt_jerarquia=0; $tt_ftn=0; $tt_ftd=0; $tt_ftf=0; $tt_tamas=0; $tt_tame=0; 
					$tt_taextmas=0; $tt_taextme=0; $tt_deductiva=0; $tt_tarifa2=0; $tt_jerarquia2=0; $tt_v=0; $tt_v2=0; $tsv=0; 
					@$tt_fjerarquia=0;   	@$tt_ftu=0;   	@$tt_ftua=0;   @$tt_tu=0;   	@$tt_tua=0;
				}	
			} 

		echo $html;			  

?>
   

