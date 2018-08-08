<?php
set_time_limit(0);
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 @$ayo=$_REQUEST['Ayo'];
 @$qna=$_REQUEST['Qna'];
 @$usuario=$_REQUEST['Usuario'];
 @$del=$_REQUEST['Del'];
 @$al=$_REQUEST['Al'];

 if($ayo!=""){ 				$var_ayo=" AND td.AYO=$ayo ";  									}else {  $var_ayo=""; }
 if($qna!=""){ 				$var_qna=" AND td.qna =$qna ";  								}else {  $var_qna=""; }
 if($usuario!=""){ 			$var_usu=" AND TD.ID_USUARIO='$usuario' ";  					}else {  $var_usu=""; }
 if($del!="" and $al!=""){ 	$var_fet=" AND T3.FECHA_INI='$del'   AND FECHA_FIN='$al'   ";  	}else {  $var_fet=""; }
 $html = "";
		
		$html.="
			<table    class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:10px;'>
			<thead> 
			  <tr>
				<td  colspan='5' align='center' class='bg-primary'><b>GENERALES</td>
				<td  colspan='5' align='center' valign='middle' class='bg-secondary'><b>CONTRATADOS</td>
				<td  colspan='8' align='center'  valign='middle'  class='bg-primary'><b>FATIGA</td>
				<td  rowspan='2' align='center'  valign='middle'  class='bg-secondary'><b>PREVIO FACT.</td>
				<td  rowspan='2' align='center'  valign='middle'  class='bg-secondary'><b>ACCION</td>
			  </tr> 	
			  <tr>
				<td  align='center' class='bg-primary'><b>PRINCIPAL</td>
				<td  align='center' class='bg-primary'><b>ID USUARIO</td>
				<td  align='center' class='bg-primary'><b>ID SERVICIO</td>
				<td  width='15' align='center' class='bg-primary'><b>MARCA</td>
				<td  width='15' align='center' class='bg-primary'><b>LEYENDA</td>
				<td  align='center' valign='middle' class='bg-secondary'><b>TARIFA</td>
				<td  align='center'  valign='middle'  class='bg-secondary'><b>TN</td>
				<td  align='center'  valign='middle'  class='bg-secondary'><b>TD</td>
				<td  align='center'  valign='middle'  class='bg-secondary'><b>TF</td>
				<td  align='center'  valign='middle'  class='bg-secondary'><b>JERARQUIA</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>F_TN</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>F_TD</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>F_TF</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>TA_MAS</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>TA_MENOS</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>TA_EXT_MAS</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>TA_EXT_MENOS</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>DEDUCTIVAS</td>
			  </tr>
			 </thead>
			<tbody>";
			
		 	 $SQL=" 
			   SELECT  PRINCIPAL,TD.ID_USUARIO,TD.ID_SERVICIO,MARCA,TARIFA,TN,TD,TF,JERARQUIA ,F_TN,F_TD,F_TF,TA_MAS,TA_MENOS ,
			   ISNULL(T1.TA_EXT_MAS,0)TA_EXT_MAS ,ISNULL(T2.TA_EXT_MENOS,0)TA_EXT_MENOS, ISNULL(CANTIDAD,0) DEDUCTIVAS 
			  FROM  Facturacion.dbo.Turnos_Facturacion TD
					INNER JOIN SECTOR.DBO.[Usuario_V_Serv_Desarrollo] US ON TD.ID_USUARIO=US.ID_USUARIO AND TD.ID_SERVICIO=US.ID_SERVICIO
					LEFT OUTER JOIN  sector.dbo.USUARIO_PRINCIPAL UP ON TD.ID_USUARIO=UP.ID_USUARIO
					LEFT OUTER JOIN  Facturacion.dbo.Deductivas D ON TD.ID_USUARIO=D.ID_USUARIO AND TD.ID_SERVICIO=D.ID_SERVICIO
					LEFT OUTER JOIN ( SELECT  ID_USUARIO, ID_SERVICIO,QNA,AYO , COUNT (ID_USUARIO) TA_EXT_MAS FROM SECTOR.DBO.Turno_Ajuste_Extemporaneo  
						WHERE  CVE_TIPO_AJUSTE=2 GROUP BY ID_USUARIO, ID_SERVICIO,QNA,AYO ) T1 ON TD.ID_USUARIO=T1.ID_USUARIO AND TD.AYO=T1.AYO AND TD.QNA=T1.QNA
					LEFT OUTER JOIN ( SELECT  ID_USUARIO, ID_SERVICIO,QNA,AYO , COUNT (ID_USUARIO) TA_EXT_MENOS FROM SECTOR.DBO.Turno_Ajuste_Extemporaneo 
						WHERE  CVE_TIPO_AJUSTE=1  GROUP BY ID_USUARIO, ID_SERVICIO,QNA,AYO ) T2 ON TD.ID_USUARIO=T2.ID_USUARIO AND TD.AYO=T2.AYO AND TD.QNA=T2.QNA
					LEFT JOIN SECTOR.DBO.C_PERIODOS_FACTURACION  T3 ON T1.AYO=T3.AYO AND T1.QNA=T3.QNA
				      WHERE TD.ID_SOLICITUD IS NOT NULL  $var_ayo $var_usu  $var_fet $var_qna
					  order by PRINCIPAL,ID_USUARIO,ID_SERVICIO,MARCA		";
			$res = sqlsrv_query( $conn,$SQL);
			$prin2=0;	
			$usu2=0;	
			$a1=0;
			$a2=0;
			while($row = sqlsrv_fetch_array($res)){
				$principal=trim($row['PRINCIPAL']);
				$usuario=$row['ID_USUARIO'];
				$servicio=$row['ID_SERVICIO'];
				$marca=$row['MARCA'];
				$tarifa2=$row['TARIFA'];					$tarifa=number_format($tarifa2, 2, '.', ',');
				$t_tarifa2=@$t_tarifa2+$tarifa2; 			$t_tarifa=number_format(@$t_tarifa2, 2, '.', ',');
				$tn=$row['TN']; 							$t_tn=@$t_tn+$tn;
				$td=$row['TD']; 							$t_td=@$t_td+$td;
				$tf=$row['TF']; 							$t_tf=@$t_tf+$tf;
				//$jerarquia2=$row['JERARQUIA']; 				$jerarquia=number_format(@$jerarquia2, 2, '.', ',');
				$jerarquia=0.00; 				
				$t_jerarquia2=@$t_jerarquia2+$jerarquia; 	$t_jerarquia=number_format(@$t_jerarquia2, 2, '.', ',');
				$ftn=$row['F_TN']; 							$t_ftn=@$t_ftn+$ftn;
				$ftd=$row['F_TD']; 							$t_ftd=@$t_ftd+$ftd;
				$ftf=$row['F_TF']; 							$t_ftf=@$t_ftf+$ftf;
				$tamas=$row['TA_MAS']; 						$t_tamas=@$t_tamas+$tamas;
				$tame=$row['TA_MENOS']; 					$t_tame=@$t_tame+$tame;
				$taextmas=$row['TA_EXT_MAS']; 				$t_taextmas=@$t_taextmas+$taextmas;
				$taextme=$row['TA_EXT_MENOS']; 				$t_taextme=@$t_taextme+$taextme;
				$deductiva=$row['DEDUCTIVAS']; 				$t_deductiva=@$t_deductiva+$deductiva;				
				$a1++;				
				$a2++;				
			if($prin2<>$principal){
			$a2=1;	
			$prin2=$principal;
			$varprin="diferente";
								 
			$sql_count2="
					SELECT  COUNT(ISNULL(PRINCIPAL,0)) SUMA,PRINCIPAL
					FROM  Facturacion.dbo.Turnos_Facturacion TD
						INNER JOIN SECTOR.DBO.[Usuario_V_Serv_Desarrollo] US ON TD.ID_USUARIO=US.ID_USUARIO AND TD.ID_SERVICIO=US.ID_SERVICIO
						LEFT OUTER JOIN  sector.dbo.USUARIO_PRINCIPAL UP ON TD.ID_USUARIO=UP.ID_USUARIO
						LEFT OUTER JOIN  Facturacion.dbo.Deductivas D ON TD.ID_USUARIO=D.ID_USUARIO AND TD.ID_SERVICIO=D.ID_SERVICIO
						LEFT OUTER JOIN ( SELECT  ID_USUARIO, ID_SERVICIO,QNA,AYO , COUNT (ID_USUARIO) TA_EXT_MAS FROM SECTOR.DBO.Turno_Ajuste_Extemporaneo  
							WHERE CVE_TIPO_AJUSTE=2 GROUP BY ID_USUARIO, ID_SERVICIO,QNA,AYO ) T1 ON TD.ID_USUARIO=T1.ID_USUARIO AND TD.AYO=T1.AYO AND TD.QNA=T1.QNA
						LEFT OUTER JOIN ( SELECT  ID_USUARIO, ID_SERVICIO,QNA,AYO , COUNT (ID_USUARIO) TA_EXT_MENOS FROM SECTOR.DBO.Turno_Ajuste_Extemporaneo 
							WHERE CVE_TIPO_AJUSTE=1  GROUP BY ID_USUARIO, ID_SERVICIO,QNA,AYO ) T2 ON TD.ID_USUARIO=T2.ID_USUARIO AND TD.AYO=T2.AYO AND TD.QNA=T2.QNA
						LEFT JOIN SECTOR.DBO.C_PERIODOS_FACTURACION  T3 ON T1.AYO=T3.AYO AND T1.QNA=T3.QNA
							WHERE TD.ID_SOLICITUD IS NOT NULL and PRINCIPAL='$principal'  $var_ayo $var_usu  $var_fet $var_qna
							group by PRINCIPAL
							   order by PRINCIPAL ";
							
					$res_count2 = sqlsrv_query( $conn,$sql_count2);
					$row_count2 = sqlsrv_fetch_array($res_count2);
					$suma=trim($row_count2['SUMA']);
					
					
			$sql_count3="
			   SELECT count(distinct(td.ID_USUARIO)) COUNT_PRINCIPAL 
			  FROM  Facturacion.dbo.Turnos_Facturacion TD
					INNER JOIN SECTOR.DBO.[Usuario_V_Serv_Desarrollo] US ON TD.ID_USUARIO=US.ID_USUARIO AND TD.ID_SERVICIO=US.ID_SERVICIO
					LEFT OUTER JOIN  sector.dbo.USUARIO_PRINCIPAL UP ON TD.ID_USUARIO=UP.ID_USUARIO
					LEFT OUTER JOIN  Facturacion.dbo.Deductivas D ON TD.ID_USUARIO=D.ID_USUARIO AND TD.ID_SERVICIO=D.ID_SERVICIO
					LEFT OUTER JOIN ( SELECT  ID_USUARIO, ID_SERVICIO,QNA,AYO , COUNT (ID_USUARIO) TA_EXT_MAS FROM SECTOR.DBO.Turno_Ajuste_Extemporaneo  
						WHERE   CVE_TIPO_AJUSTE=2 GROUP BY ID_USUARIO, ID_SERVICIO,QNA,AYO ) T1 ON TD.ID_USUARIO=T1.ID_USUARIO AND TD.AYO=T1.AYO AND TD.QNA=T1.QNA
					LEFT OUTER JOIN ( SELECT  ID_USUARIO, ID_SERVICIO,QNA,AYO , COUNT (ID_USUARIO) TA_EXT_MENOS FROM SECTOR.DBO.Turno_Ajuste_Extemporaneo 
						WHERE  CVE_TIPO_AJUSTE=1 GROUP BY ID_USUARIO, ID_SERVICIO,QNA,AYO ) T2 ON TD.ID_USUARIO=T2.ID_USUARIO AND TD.AYO=T2.AYO AND TD.QNA=T2.QNA
					LEFT JOIN SECTOR.DBO.C_PERIODOS_FACTURACION  T3 ON T1.AYO=T3.AYO AND T1.QNA=T3.QNA
				      WHERE TD.ID_SOLICITUD IS NOT NULL and PRINCIPAL='$principal' $var_ayo $var_usu  $var_fet $var_qna
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
				$sql_count="  SELECT count(TD.ID_USUARIO) COUNT,TD.ID_USUARIO
							  FROM  Facturacion.dbo.Turnos_Facturacion TD
								INNER JOIN SECTOR.DBO.[Usuario_V_Serv_Desarrollo] US ON TD.ID_USUARIO=US.ID_USUARIO AND TD.ID_SERVICIO=US.ID_SERVICIO
								LEFT OUTER JOIN  sector.dbo.USUARIO_PRINCIPAL UP ON TD.ID_USUARIO=UP.ID_USUARIO
								LEFT OUTER JOIN  Facturacion.dbo.Deductivas D ON TD.ID_USUARIO=D.ID_USUARIO AND TD.ID_SERVICIO=D.ID_SERVICIO
								LEFT OUTER JOIN ( SELECT  ID_USUARIO, ID_SERVICIO,QNA,AYO , COUNT (ID_USUARIO) TA_EXT_MAS FROM SECTOR.DBO.Turno_Ajuste_Extemporaneo  
									WHERE CVE_TIPO_AJUSTE=2 GROUP BY ID_USUARIO, ID_SERVICIO,QNA,AYO ) T1 ON TD.ID_USUARIO=T1.ID_USUARIO AND TD.AYO=T1.AYO AND TD.QNA=T1.QNA
								LEFT OUTER JOIN ( SELECT  ID_USUARIO, ID_SERVICIO,QNA,AYO , COUNT (ID_USUARIO) TA_EXT_MENOS FROM SECTOR.DBO.Turno_Ajuste_Extemporaneo 
									WHERE CVE_TIPO_AJUSTE=1 GROUP BY ID_USUARIO, ID_SERVICIO,QNA,AYO ) T2 ON TD.ID_USUARIO=T2.ID_USUARIO AND TD.AYO=T2.AYO AND TD.QNA=T2.QNA
								LEFT JOIN SECTOR.DBO.C_PERIODOS_FACTURACION  T3 ON T1.AYO=T3.AYO AND T1.QNA=T3.QNA
								 WHERE TD.ID_SOLICITUD IS NOT NULL and  TD.ID_USUARIO='$usuario'  		 $var_ayo $var_usu  $var_fet $var_qna
								 group by PRINCIPAL,TD.ID_USUARIO 
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
				<td  align='center' ><b>$marca</td>
				<td  align='center' ><b><a href='sec_leyenda.php?usuario=$usuario&servicio=$servicio'>LEYENDA</a></td>
				<td  align='center' valign='middle' ><b>$tarifa</td>
				<td  align='center'  valign='middle' ><b>$tn</td>
				<td  align='center'  valign='middle' ><b>$td</td>
				<td  align='center'  valign='middle' ><b>$tf</td>
				<td  align='center'  valign='middle' ><b>$jerarquia</td>
				<td  align='center'  valign='middle' ><b>$ftn</td>
				<td  align='center'  valign='middle' ><b>$ftd</td>
				<td  align='center'  valign='middle' ><b>$ftf</td>
				<td  align='center'  valign='middle' ><b>$tamas</td>
				<td  align='center'  valign='middle' ><b>$tame</td>
				<td  align='center'  valign='middle' ><b>$taextmas</td>
				<td  align='center'  valign='middle' ><b>$taextme</td>
				<td  align='center'  valign='middle' ><b>$deductiva</td>";
				if($varprin=='diferente'){
					$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><b><a style='color:#337ab7;' href='../descargables/sector/pdf_previo_fact.php' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><b> <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#myModalCharts'>SOLICITAR</button></td>";
				}if($principal=='' and $var2=='diferente'){
					$html.="<td $count align='center' style='vertical-align: middle;' ><b> <a style='color:#337ab7;' href='../descargables/sector/pdf_previo_fact.php' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					$html.="<td $count align='center' style='vertical-align: middle;' ><b> <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#myModalCharts'>SOLICITAR</button></td>";
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
						<td  align='center'  valign='middle' ><b>$t_ftn</td>
						<td  align='center'  valign='middle' ><b>$t_ftd</td>
						<td  align='center'  valign='middle' ><b>$t_ftf</td>
						<td  align='center'  valign='middle' ><b>$t_tamas</td>
						<td  align='center'  valign='middle' ><b>$t_tame</td>
						<td  align='center'  valign='middle' ><b>$t_taextmas</td>
						<td  align='center'  valign='middle' ><b>$t_taextme</td>
						<td  align='center'  valign='middle' ><b>$t_deductiva</td>	
					</tr>";					
				}  
			    	if(@$suma3==(@$a2+1) and $principal!=""){
					$html.="
					<tr class='bg-danger'>
						<td  colspan='4' align='center' ><b>TOTALES</td>
						<td  align='center' ><b></td>
						<td  align='center' ><b></td>
						<td  align='center' valign='middle' ><b></td>
						<td  align='center'  valign='middle' ><b></td>
						<td  align='center'  valign='middle' ><b></td>
						<td  align='center'  valign='middle' ><b></td>
						<td  align='center'  valign='middle' ><b></td>
						<td  align='center'  valign='middle' ><b></td>
						<td  align='center'  valign='middle' ><b></td>
						<td  align='center'  valign='middle' ><b></td>
						<td  align='center'  valign='middle' ><b></td>
						<td  align='center'  valign='middle' ><b></td>
						<td  align='center'  valign='middle' ><b></td>
					</tr>	
					";
					
				} 		
				if(($count2-1)==$a1){			
					$t_tarifa=0; $t_tn=0; $t_td=0; $t_tf=0; $t_jerarquia=0; $t_ftn=0; $t_ftd=0; $t_ftf=0; $t_tamas=0; $t_tame=0; 
					$t_taextmas=0; $t_taextme=0; $t_deductiva=0; $t_tarifa2=0; $t_jerarquia2=0;
				}
			} 

		echo $html;			  

?>
<div>
	<div class="modal fade" id="myModalCharts" role="dialog">
		<div class="modal-dialog mymodal modal-lg" style=" width: 55% !important">         
			<div class="modal-content">
				<div class="modal-header title_left" style=" background-color: #2C3E50;">
					<button type="button" class="close" data-dismiss="modal" style=" background-color: white;">&nbsp&nbsp;&times;&nbsp&nbsp;</button>
					<h4 class="modal-title" style=" color: white;"><img width="2%"  src="../dist/img/pa2.png"><center></center></h4>
				</div>
				<div style="text-align: center"><br>
					<h4 style=" color: #1B4C7C; font-weight: 600">SOLICITUD DE FACTURAS.</h4><hr>
				</div>  
				<div class="col-md-12">
					<p><?php echo ('¿Estas seguro de SOLICITAR esta factura?'); ?></p>
					<div class="col-md-4"></div>
					<div class="col-md-4">
					  <label>MOTIVO DE RECHAZO: </label>
					  <input name="obs" value="" class="form-control"  placeholder="LLENAR EN CASO DE RECHAZAR">
					 </div>
				</div>
				<div class="modal-footer">   
					<button name="btn"  value="cancelar" onclick="cancel(<?php echo $id; ?>, <?php echo $a;?>)" type="button" class="btn btn-danger" data-dismiss="modal">RECHAZAR</button>
					<button name="btn"  value="cancelar" onclick="cancel(<?php echo $id; ?>, <?php echo $a;?>)" type="button" class="btn btn-success" data-dismiss="modal">SOLICITAR</button>
				</div>
			</div>      
		</div>
	</div>
</div>     