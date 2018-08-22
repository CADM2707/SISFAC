<script>
$(document).ready(function() {
    goheadfixed('table.fixed');


	function goheadfixed(classtable) {
	
		if($(classtable).length) {
	
			$(classtable).wrap('<div class="fix-inner"></div>'); 
			$('.fix-inner').wrap('<div class="fix-outer" style="position:relative; margin:auto;"></div>');
			$('.fix-outer').append('<div class="fix-head"></div>');
			$('.fix-head').prepend($('.fix-inner').html());
			$('.fix-head table').find('caption').remove();
			$('.fix-head table').css('width','100%');
	
			$('.fix-outer').css('width', $('.fix-inner table').outerWidth(true)+'px');
			$('.fix-head').css('width', $('.fix-inner table').outerWidth(true)+'px');
			$('.fix-head').css('height', $('.fix-inner table thead').height()+'px');
	
			// If exists caption, calculte his height for then remove of total
			var hcaption = 0;
			if($('.fix-inner table caption').length != 0)
				hcaption = parseInt($('.fix-inner table').find('caption').height()+'px');

			// Table's Top
			var hinner = parseInt( $('.fix-inner').offset().top );

			// Let's remember that <caption> is the beginning of a <table>, it mean that his top of the caption is the top of the table
			$('.fix-head').css({'position':'absolute', 'overflow':'hidden', 'top': hcaption+'px', 'left':0, 'z-index':100 });
		
			$(window).scroll(function () {
				var vscroll = $(window).scrollTop();

				if(vscroll >= hinner + hcaption)
					$('.fix-head').css('top',(vscroll-hinner)+'px');
				else
					$('.fix-head').css('top', hcaption+'px');
			});
	
			/*	If the windows resize	*/
			$(window).resize(goresize);
	
		}
	}

	function goresize() {
		$('.fix-head').css('width', $('.fix-inner table').outerWidth(true)+'px');
		$('.fix-head').css('height', $('.fix-inner table thead').outerHeight(true)+'px');
	}
    
});
</script>


<?php
set_time_limit(0);
include '../../conexiones/sqlsrv.php';
$conn = connection_object();
 @$ayo=$_REQUEST['Ayo'];
 @$qna=$_REQUEST['Qna'];
 @$usuario=$_REQUEST['Usuario'];
 @$periodo=$_REQUEST['Periodo'];
 /*if($periodo!=""){
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
	$var_ayo=" AND TD.AYO=$ayo ";
	$var_qna=" AND TD.QNA=$qna ";
	$var_fet=" AND FECHA_INI='$ini'   AND FECHA_FIN='$fin'   ";

 } */
 if($usuario!=""){ 			$var_usu=" AND ID_USUARIO='$usuario' ";  					}else {  $var_usu=""; }
		$var_ayo=" AND TD.AYO=2017 ";
		$var_qna=" AND TD.QNA=16 and SECTOR=52 ";
		$var_fet=" ";
 $html = "";

		$html.="
		<div  class='container' style='margin:0px 0px 0px 0px; padding:0px 0px 0px 0px;'>
			<table  class='table table-responsive fixed ' style='font-size:10px;   '  border=1  BORDERCOLOR=#e7e7e7 >
			
			<thead>
			  <tr>
				<td  colspan='4' align='center' class='bg-primary'><b>GENERALES</td>
				<td  colspan='5' align='center' valign='middle' class='bg-green'><b>CONTRATADOS</td>
				<td  colspan='8' align='center'  valign='middle'  class='bg-primary'><b>FATIGA</td>
				<td  rowspan='2' align='center'  valign='middle'  class='bg-green'><b>PREVIO FACT.</td>
				<td  rowspan='2' align='center'  valign='middle'  class='bg-green'><b>ACCION</td>
			  </tr>
			  <tr>
				<td  align='center' class='bg-primary'><b>PRINCIPAL</td>
				<td  align='center' class='bg-primary'><b>ID USUARIO</td>
				<td  align='center' class='bg-primary'><b>ID SERVICIO</td>
				<td  width='15' align='center' class='bg-primary'><b>SECTOR</td>
				<td  align='center' valign='middle' class='bg-green'><b>TARIFA</td>
				<td  align='center'  valign='middle'  class='bg-green'><b>TN</td>
				<td  align='center'  valign='middle'  class='bg-green'><b>TD</td>
				<td  align='center'  valign='middle'  class='bg-green'><b>TF</td>
				<td  align='center'  valign='middle'  class='bg-green'><b>JERARQUIA</td>
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
			 
			<tbody>
			
			";

			 $SQL="SELECT TD.AYO,TD.QNA,TD.ID_USUARIO,TD.ID_SERVICIO,ID_USUARIO_FACTURA PRINCIPAL,SECTOR,CVE_SITUACION,TD.TARIFA,TD.TN,TD.TD,TD.TF, TD.JERARQUIA,ELEMENTOS,F_TN,F_TD,F_TF,TA_MAS, TA_MENOS,   ISNULL(TA_EXT_MAS,0)TA_EXT_MAS,ISNULL(TA_EXT_MENOS,0)TA_EXT_MENOS, ISNULL( T6.CANTIDAD,0) DEDUCTIVAS,
				CAST(FECHA_INI AS DATE) ,FECHA_INI ,FECHA_FIN,TD.ID_SOLICITUD
				FROM Facturacion.DBO.Turnos_Facturacion TD
				INNER JOIN  [15.30.30.151].SECTOR.DBO.USUARIO_SERVICIO_DESARROLLO  US ON TD.AYO = US.AYO AND TD.QNA = US.QNA AND TD.ID_USUARIO = US.ID_USUARIO AND TD.ID_SERVICIO = US.ID_SERVICIO
				LEFT OUTER JOIN
				(SELECT  AYO, QNA, ID_USUARIO, ID_SERVICIO, SUM(CASE WHEN rol IN (1, 2, 12, 13, 14) THEN Turno_Ajuste * 2 ELSE Turno_Ajuste END) AS TA_EXT_MAS FROM [15.30.30.151].SECTOR.DBO.Turno_Ajuste  WHERE (CVE_TIPO_AJUSTE = 2)
				GROUP BY AYO, QNA, ID_USUARIO, ID_SERVICIO)  T4 ON TD.AYO = T4.AYO AND TD.QNA = T4.QNA AND TD.ID_USUARIO = T4.ID_USUARIO AND TD.ID_SERVICIO = T4.ID_SERVICIO
				LEFT OUTER JOIN
				(SELECT AYO, QNA, ID_USUARIO, ID_SERVICIO, SUM(CASE WHEN rol IN (1, 2, 12, 13, 14) THEN Turno_Ajuste * 2 ELSE Turno_Ajuste END) AS TA_EXT_MENOS FROM [15.30.30.151].SECTOR.DBO.Turno_Ajuste WHERE (CVE_TIPO_AJUSTE <> 2)
				GROUP BY AYO, QNA, ID_USUARIO, ID_SERVICIO)  T5 ON TD.AYO = T5.AYO AND TD.QNA = T5.QNA AND TD.ID_USUARIO = T5.ID_USUARIO AND TD.ID_SERVICIO = T5.ID_SERVICIO
				LEFT OUTER JOIN
				(SELECT  ID_USUARIO, ID_SERVICIO, CANTIDAD  FROM dbo.Deductivas)  T6 ON TD.ID_USUARIO = T6.ID_USUARIO AND TD.ID_SERVICIO = T6.ID_SERVICIO
				INNER JOIN
				(SELECT  AYO, QNA, FECHA_INI, FECHA_FIN  FROM  Sector.dbo.C_Periodos_Facturacion)  T7 ON TD.AYO = T7.AYO AND TD.QNA = T7.QNA WHERE TD.CVE_SITUACION IN (2)
				 AND TD.ID_USUARIO IS NOT NULL  $var_ayo $var_usu  $var_fet $var_qna
                order by PRINCIPAL,TD.ID_USUARIO,ID_SERVICIO";
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
				$tarifa2=$row['TARIFA'];					$tarifa=number_format($tarifa2, 2, '.', ',');
				$anio=$row['AYO'];
				$qnas=$row['QNA'];
				$soli=$row['ID_SOLICITUD'];
				$t_tarifa2=@$t_tarifa2+$tarifa2; 			$t_tarifa=number_format(@$t_tarifa2, 2, '.', ',');  $tt_tarifa=@$tt_tarifa+$tarifa2;
				$tn=$row['TN']; 							$t_tn=@$t_tn+$tn;  									$tt_tn=@$tt_tn+$tn;
				$td=$row['TD']; 							$t_td=@$t_td+$td; 									$tt_td=@$tt_td+$td;
				$tf=$row['TF']; 							$t_tf=@$t_tf+$tf;									$tt_tf=@$tt_tf+$tf;
				$jerarquia=$row['JERARQUIA']; 				$t_jerarquia=@$t_jerarquia2+$jerarquia; 			$tt_jerarquia=@$tt_jerarquia+$jerarquia;
				$ftn=$row['F_TN']; 							$t_ftn=@$t_ftn+$ftn; 								$tt_ftn=@$tt_ftn+$ftn;
				$ftd=$row['F_TD']; 							$t_ftd=@$t_ftd+$ftd;								$tt_ftd=@$tt_ftd+$ftd;
				$ftf=$row['F_TF']; 							$t_ftf=@$t_ftf+$ftf;								$tt_ftf=@$tt_ftf+$ftf;
				$tamas=$row['TA_MAS']; 						$t_tamas=@$t_tamas+$tamas;							$tt_tamas=@$tt_tamas+$tamas;
				$tame=$row['TA_MENOS']; 					$t_tame=@$t_tame+$tame;								$tt_tame=@$tt_tame+$tame;
				$taextmas=$row['TA_EXT_MAS']; 				$t_taextmas=@$t_taextmas+$taextmas;					$tt_taextmas=@$tt_taextmas+$taextmas;
				$taextme=$row['TA_EXT_MENOS']; 				$t_taextme=@$t_taextme+$taextme;					$tt_taextme=@$tt_taextme+$taextme;
				$deductiva=$row['DEDUCTIVAS']; 				$t_deductiva=@$t_deductiva+$deductiva;				$tt_deductiva=@$tt_deductiva+$deductiva;
				$a1++;
				$a2++;
			if($prin2<>$principal){
			$a2=1;
			$prin2=$principal;
			$varprin="diferente";

			$sql_count2="
					SELECT  COUNT(ISNULL(ID_USUARIO_FACTURA,0)) SUMA,ID_USUARIO_FACTURA
FROM Facturacion.DBO.Turnos_Facturacion TD
INNER JOIN  [15.30.30.151].SECTOR.DBO.USUARIO_SERVICIO_DESARROLLO  US ON TD.AYO = US.AYO AND TD.QNA = US.QNA AND TD.ID_USUARIO = US.ID_USUARIO AND TD.ID_SERVICIO = US.ID_SERVICIO
LEFT OUTER JOIN
(SELECT  AYO, QNA, ID_USUARIO, ID_SERVICIO, SUM(CASE WHEN rol IN (1, 2, 12, 13, 14) THEN Turno_Ajuste * 2 ELSE Turno_Ajuste END) AS TA_EXT_MAS FROM [15.30.30.151].SECTOR.DBO.Turno_Ajuste  WHERE (CVE_TIPO_AJUSTE = 2)
GROUP BY AYO, QNA, ID_USUARIO, ID_SERVICIO)  T4 ON TD.AYO = T4.AYO AND TD.QNA = T4.QNA AND TD.ID_USUARIO = T4.ID_USUARIO AND TD.ID_SERVICIO = T4.ID_SERVICIO
LEFT OUTER JOIN
(SELECT AYO, QNA, ID_USUARIO, ID_SERVICIO, SUM(CASE WHEN rol IN (1, 2, 12, 13, 14) THEN Turno_Ajuste * 2 ELSE Turno_Ajuste END) AS TA_EXT_MENOS FROM [15.30.30.151].SECTOR.DBO.Turno_Ajuste WHERE (CVE_TIPO_AJUSTE <> 2)
GROUP BY AYO, QNA, ID_USUARIO, ID_SERVICIO)  T5 ON TD.AYO = T5.AYO AND TD.QNA = T5.QNA AND TD.ID_USUARIO = T5.ID_USUARIO AND TD.ID_SERVICIO = T5.ID_SERVICIO
LEFT OUTER JOIN
(SELECT  ID_USUARIO, ID_SERVICIO, CANTIDAD  FROM dbo.Deductivas)  T6 ON TD.ID_USUARIO = T6.ID_USUARIO AND TD.ID_SERVICIO = T6.ID_SERVICIO
INNER JOIN
(SELECT  AYO, QNA, FECHA_INI, FECHA_FIN  FROM  Sector.dbo.C_Periodos_Facturacion)  T7 ON TD.AYO = T7.AYO AND TD.QNA = T7.QNA WHERE TD.CVE_SITUACION IN (2)
and TD.ID_USUARIO_FACTURA='$principal'  $var_ayo $var_usu  $var_fet $var_qna
group by TD.ID_USUARIO_FACTURA
order by ID_USUARIO_FACTURA";

					$res_count2 = sqlsrv_query( $conn,$sql_count2);
					$row_count2 = sqlsrv_fetch_array($res_count2);
					$suma=trim($row_count2['SUMA']);


			$sql_count3="
			   SELECT count(distinct(TD.ID_USUARIO)) COUNT_PRINCIPAL
				FROM Facturacion.DBO.Turnos_Facturacion TD
				INNER JOIN  [15.30.30.151].SECTOR.DBO.USUARIO_SERVICIO_DESARROLLO  US ON TD.AYO = US.AYO AND TD.QNA = US.QNA AND TD.ID_USUARIO = US.ID_USUARIO AND TD.ID_SERVICIO = US.ID_SERVICIO
				LEFT OUTER JOIN
				(SELECT  AYO, QNA, ID_USUARIO, ID_SERVICIO, SUM(CASE WHEN rol IN (1, 2, 12, 13, 14) THEN Turno_Ajuste * 2 ELSE Turno_Ajuste END) AS TA_EXT_MAS FROM [15.30.30.151].SECTOR.DBO.Turno_Ajuste  WHERE (CVE_TIPO_AJUSTE = 2)
				GROUP BY AYO, QNA, ID_USUARIO, ID_SERVICIO)  T4 ON TD.AYO = T4.AYO AND TD.QNA = T4.QNA AND TD.ID_USUARIO = T4.ID_USUARIO AND TD.ID_SERVICIO = T4.ID_SERVICIO
				LEFT OUTER JOIN
				(SELECT AYO, QNA, ID_USUARIO, ID_SERVICIO, SUM(CASE WHEN rol IN (1, 2, 12, 13, 14) THEN Turno_Ajuste * 2 ELSE Turno_Ajuste END) AS TA_EXT_MENOS FROM [15.30.30.151].SECTOR.DBO.Turno_Ajuste WHERE (CVE_TIPO_AJUSTE <> 2)
				GROUP BY AYO, QNA, ID_USUARIO, ID_SERVICIO)  T5 ON TD.AYO = T5.AYO AND TD.QNA = T5.QNA AND TD.ID_USUARIO = T5.ID_USUARIO AND TD.ID_SERVICIO = T5.ID_SERVICIO
				LEFT OUTER JOIN
				(SELECT  ID_USUARIO, ID_SERVICIO, CANTIDAD  FROM dbo.Deductivas)  T6 ON TD.ID_USUARIO = T6.ID_USUARIO AND TD.ID_SERVICIO = T6.ID_SERVICIO
				INNER JOIN
				(SELECT  AYO, QNA, FECHA_INI, FECHA_FIN  FROM  Sector.dbo.C_Periodos_Facturacion)  T7 ON TD.AYO = T7.AYO AND TD.QNA = T7.QNA WHERE TD.CVE_SITUACION IN (2)
				AND TD.ID_USUARIO IS NOT NULL and ID_USUARIO_FACTURA='$principal' $var_ayo $var_usu  $var_fet $var_qna
				group by ID_USUARIO_FACTURA
				order by ID_USUARIO_FACTURA ";
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
				$sql_count="SELECT count(TD.ID_USUARIO) COUNT,TD.ID_USUARIO
							FROM Facturacion.DBO.Turnos_Facturacion TD
							INNER JOIN  [15.30.30.151].SECTOR.DBO.USUARIO_SERVICIO_DESARROLLO  US ON TD.AYO = US.AYO AND TD.QNA = US.QNA AND TD.ID_USUARIO = US.ID_USUARIO AND TD.ID_SERVICIO = US.ID_SERVICIO
							LEFT OUTER JOIN
							(SELECT  AYO, QNA, ID_USUARIO, ID_SERVICIO, SUM(CASE WHEN rol IN (1, 2, 12, 13, 14) THEN Turno_Ajuste * 2 ELSE Turno_Ajuste END) AS TA_EXT_MAS FROM [15.30.30.151].SECTOR.DBO.Turno_Ajuste  WHERE (CVE_TIPO_AJUSTE = 2)
							GROUP BY AYO, QNA, ID_USUARIO, ID_SERVICIO)  T4 ON TD.AYO = T4.AYO AND TD.QNA = T4.QNA AND TD.ID_USUARIO = T4.ID_USUARIO AND TD.ID_SERVICIO = T4.ID_SERVICIO
							LEFT OUTER JOIN
							(SELECT AYO, QNA, ID_USUARIO, ID_SERVICIO, SUM(CASE WHEN rol IN (1, 2, 12, 13, 14) THEN Turno_Ajuste * 2 ELSE Turno_Ajuste END) AS TA_EXT_MENOS FROM [15.30.30.151].SECTOR.DBO.Turno_Ajuste WHERE (CVE_TIPO_AJUSTE <> 2)
							GROUP BY AYO, QNA, ID_USUARIO, ID_SERVICIO)  T5 ON TD.AYO = T5.AYO AND TD.QNA = T5.QNA AND TD.ID_USUARIO = T5.ID_USUARIO AND TD.ID_SERVICIO = T5.ID_SERVICIO
							LEFT OUTER JOIN
							(SELECT  ID_USUARIO, ID_SERVICIO, CANTIDAD  FROM dbo.Deductivas)  T6 ON TD.ID_USUARIO = T6.ID_USUARIO AND TD.ID_SERVICIO = T6.ID_SERVICIO
							INNER JOIN
							(SELECT  AYO, QNA, FECHA_INI, FECHA_FIN  FROM  Sector.dbo.C_Periodos_Facturacion)  T7 ON TD.AYO = T7.AYO AND TD.QNA = T7.QNA WHERE TD.CVE_SITUACION IN (2)
							AND TD.ID_USUARIO IS NOT NULL and  TD.ID_USUARIO='$usuario'  		 $var_ayo $var_usu  $var_fet $var_qna
							group by ID_USUARIO_FACTURA,TD.ID_USUARIO
							order by ID_USUARIO_FACTURA,TD.ID_USUARIO";
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
				<td  align='center'  valign='middle' ><b><a href='../sector/sec_detalle_elementos.php?ayo=$ayo&qna=$qna&usuario=$usuario'>$deductiva</a></td>";
				if($varprin=='diferente'){
					$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><b><a style='color:#337ab7;' href='../descargables/sector/pdf_previo_fact.php' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					$html.="
					<td $count_principal  align='center' style='vertical-align: middle;' ><b>
						<button onclick='modal ($anio, $qnas, \"$principal\", $soli)' type='button' class='btn bg-primary' >
							&nbsp;ACCION
						</button>
					</td>
					";
				}if($principal=='' and $var2=='diferente'){
					$html.="<td $count align='center' style='vertical-align: middle;' ><b> <a style='color:#337ab7;' href='../descargables/sector/pdf_previo_fact.php' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					$html.="<td $count align='center' style='vertical-align: middle;' ><b>
								<button onclick='modal ($anio, $qnas, \"$principal\" , $soli)' type='button' class='btn bg-primary' >
									 &nbsp;ACCION
								</button>
							</td>
					";
				}
					$html.="</tr>";
				if(($count2-1)==$a1){
					$a2++;
					$html.="
					<tr class='bg-success'>
						<td  colspan='2' align='center' ><b>TOTALES </td>
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
						<td  colspan='3' align='center' ><b>TOTALES</td>
						<td  align='center' ><b>$tt_tarifa</td>
						<td  align='center' ><b>$tt_tn</td>
						<td  align='center' valign='middle' ><b>$tt_td</td>
						<td  align='center'  valign='middle' ><b>$tt_tf</td>
						<td  align='center'  valign='middle' ><b>$tt_jerarquia</td>
						<td  align='center'  valign='middle' ><b>$tt_ftn</td>
						<td  align='center'  valign='middle' ><b>$tt_ftd</td>
						<td  align='center'  valign='middle' ><b>$tt_ftf</td>
						<td  align='center'  valign='middle' ><b>$tt_tamas</td>
						<td  align='center'  valign='middle' ><b>$tt_tame</td>
						<td  align='center'  valign='middle' ><b>$tt_taextmas</td>
						<td  align='center'  valign='middle' ><b>$tt_taextme</td>
						<td  align='center'  valign='middle' ><b>$tt_deductiva</td>
					</tr>
					
					";

				}
				if(($count2-1)==$a1){
					$t_tarifa=0; $t_tn=0; $t_td=0; $t_tf=0; $t_jerarquia=0; $t_ftn=0; $t_ftd=0; $t_ftf=0; $t_tamas=0; $t_tame=0;
					$t_taextmas=0; $t_taextme=0; $t_deductiva=0; $t_tarifa2=0; $t_jerarquia2=0;
				}if(@$suma3==(@$a2+1) and $principal!=""){
					$tt_tarifa=0; $tt_tn=0; $tt_td=0; $tt_tf=0; $tt_jerarquia=0; $tt_ftn=0; $tt_ftd=0; $tt_ftf=0; $tt_tamas=0; $tt_tame=0;
					$tt_taextmas=0; $tt_taextme=0; $tt_deductiva=0; $tt_tarifa2=0; $tt_jerarquia2=0;
				}
			}

            $html.="
			
			</table>
					
			</div>
			";


		echo $html;

?>
