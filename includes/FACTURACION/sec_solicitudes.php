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
 @$sec=$_REQUEST['Sector'];
 @$periodo=$_REQUEST['Periodo'];
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
 if($usuario!=""){ 			$var_usu=" AND PRINCIPAL='$usuario' ";  					}else {  $var_usu=""; }
	//	$var_ayo=" AND TD.AYO=2017 ";
	//	$var_qna=" AND TD.QNA=16 and SECTOR=52 ";
	//	$var_fet=" ";
	$var_sec=" AND SECTOR=$sec";

$sql="SELECT  ID_SOLICITUD,AYO,QNA,ID_USUARIO,ID_SERVICIO,PRINCIPAL,SECTOR,CVE_SITUACION,TARIFA,TN,TD,TF,JERARQUIA,ELEMENTOS,F_TN,F_TD,F_TF,TA_MAS, TA_MENOS, TA_EXT_MAS,TA_EXT_MENOS, DEDUCTIVAS,
TUA,	TU,	F_TUA	,F_TU,	F_JERARQUIA,T_AJU,MARCA
FROM V_Solicitud_Fac
WHERE ID_USUARIO IS NOT NULL and CVE_SITUACION = 2  $var_ayo $var_usu  $var_fet $var_qna $var_sec
order by PRINCIPAL,ID_USUARIO,ID_SERVICIO";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn, $sql , $params, $options );
$row_count = sqlsrv_num_rows( $stmt );
if($row_count>0){

 $html = "";

		$html.="
		<div  class='container' style='margin:0px 0px 0px 0px; padding:0px 0px 0px 0px;'>
			<table  class='table table-responsive fixed ' style='font-size:10px;   '  border=1  BORDERCOLOR=#e7e7e7 >

			<thead>
			  <tr>
				<td  colspan='5' align='center' class='bg-primary'><b>GENERALES</td>
				<td  colspan='8' align='center' valign='middle' class='bg-green'><b>CONTRATADOS</td>
				<td  colspan='14' align='center'  valign='middle'  class='bg-primary'><b>FATIGA</td>
				<td  rowspan='2' align='center'  valign='middle'  class='bg-green'><b>PREVIO FACT.</td>
				<td  rowspan='2' align='center'  valign='middle'  class='bg-green'><b>ACCION</td>
			  </tr>
			  <tr>
				<td  align='center' class='bg-primary'><b>PRINCIPAL</td>
				<td  align='center' class='bg-primary'><b>USUARIO</td>
				<td  align='center' class='bg-primary'><b>SERVICIO</td>
				<td  align='center' class='bg-primary'><b>MARCA</td>
				<td  width='15' align='center' class='bg-primary'><b>SEC</td>
				<td  align='center' valign='middle' class='bg-green'><b>TARIFA</td>
				<td  align='center'  valign='middle'  class='bg-green'><b>TN</td>
				<td  align='center'  valign='middle'  class='bg-green'><b>TD</td>
				<td  align='center'  valign='middle'  class='bg-green'><b>TF</td>
				<td  align='center'  valign='middle'  class='bg-green'><b>JERARQUIA</td>
     			<td  align='center'  valign='middle'  class='bg-green'><b>TUA</td>
				<td  align='center'  valign='middle'  class='bg-green'><b>TU</td>
				<td  align='center'  valign='middle'  class='bg-green'><b>TOT</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>F_TN</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>F_TD</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>F_TF</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>TA_MAS</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>TA_MENOS</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>TA_EXT_MAS</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>TA_EXT_MENOS</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>DEDUCTIVAS</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>F TUA</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>F TU</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>F JER</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>T AJU</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>TOT</td>
				<td  align='center'  valign='middle'  class='bg-primary'><b>DIF</td>
			  </tr>
			 </thead>

			<tbody>

			";


			//$res = sqlsrv_query( $conn,$SQL);
			$prin2=0;
			$usu2=0;
			$a1=0;
			$a2=0;

			while($row = sqlsrv_fetch_array($stmt)){
				$principal=trim($row['PRINCIPAL']);
				$usuario=$row['ID_USUARIO'];
				$servicio=$row['ID_SERVICIO'];
				$marca=$row['MARCA'];
				$sector=$row['SECTOR'];
				$tarifa2=$row['TARIFA'];					$tarifa=number_format($tarifa2, 2, '.', ',');
				$anio=$row['AYO'];
				$qnas=$row['QNA'];
				$soli=$row['ID_SOLICITUD'];
				$t_tarifa2=@$t_tarifa2+$tarifa2; 			$t_tarifa=number_format(@$t_tarifa2, 2, '.', ',');  $tt_tarifa=@$tt_tarifa+$tarifa2;
				$tn=$row['TN']; 							$t_tn=@$t_tn+$tn;  									$tt_tn=@$tt_tn+$tn;
				$taju=$row['T_AJU']; 						$t_taju=@$t_taju+@$taju;  							$tt_taju=@$tt_taju+@$taju;
				@$tua=$row['TUA']; 							@$t_tua=@$t_tua+@$tua;  								@$tt_tua=@$tt_tua+@$tua;
				@$tu=$row['TU']; 							@$t_tu=@$t_tu+@$tu;  								@$tt_tu=@$tt_tu+@$tu;
				@$f_tua=$row['F_TUA']; 						@$t_ftua=@$t_ftua+@$f_tua;  							@$tt_ftua=@$tt_ftua+@$f_tua;
				@$f_tu=$row['F_TU']; 						@$t_ftu=@$t_ftu+@$f_tu;  							@$tt_ftu=@$tt_ftu+@$f_tu;
				@$f_jerarquia=$row['F_JERARQUIA']; 			if(@$f_jerarquia>0) {  }else{ @$f_jerarquia=0; }
				@$t_fjerarquia=@$t_fjerarquia+@$f_jerarquia;  @$tt_fjerarquia=@$tt_fjerarquia+@$f_jerarquia;
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
				$s_contratados=$tn+$td+$tf+$jerarquia+$tua+$tu;
				$s_fatiga=$ftn+$ftd+$ftf+$tamas+$tame+$taextmas+$taextme+$deductiva+$f_tua+$f_tu+$f_jerarquia+$taju;
				$s_diferencia=$s_contratados-$s_fatiga;
				@$t_v=@$t_v+@$s_contratados;
				@$t_v2=@$t_v2+@$s_fatiga;
				@$tt_v=@$tt_v+@$tn+@$td+@$tf+@$jerarquia+$tua+$tu;
				@$tt_v2=@$tt_v2+@$ftn+@$ftd+@$ftf+@$tamas+@$tame+@$taextmas+@$taextme+@$deductiva+$f_tua+$f_tu+$f_jerarquia+$taju;
				@$tsv2=@$tsv2+@$s_diferencia;
				@$tsv=@$tsv+(@$tn+@$td+@$tf+@$jerarquia+$tua+$tu)-(@$ftn+@$ftd+@$ftf+@$tamas+@$tame+@$taextmas+@$taextme+@$deductiva+$f_tua+$f_tu+$f_jerarquia+$taju);

				$a1++;
				$a2++;
			if($prin2<>$principal){
			$a2=1;
			$prin2=$principal;
			$varprin="diferente";

				$sql_previo="EXEC sp_Consulta_Previo '$principal',$ayo,$qna";
				$res_previo = sqlsrv_query( $conn,$sql_previo);
				$row_previo = sqlsrv_fetch_array($res_previo);
				$c_fact=$row_previo['CVE_TIPO_FACTURA'];
				$c_form=$row_previo['CVE_FORMATO'];

			$sql_count2="SELECT  COUNT(ISNULL(PRINCIPAL,0)) SUMA,PRINCIPAL
					FROM  V_Facturas_Solicitadas
WHERE PRINCIPAL='$principal'  $var_ayo $var_usu  $var_fet $var_qna $var_sec
group by PRINCIPAL
order by PRINCIPAL";

					$res_count2 = sqlsrv_query( $conn,$sql_count2);
					$row_count2 = sqlsrv_fetch_array($res_count2);
					$suma=trim($row_count2['SUMA']);


			$sql_count3="SELECT count(distinct(ID_USUARIO)) COUNT_PRINCIPAL
			  FROM  V_Facturas_Solicitadas
				WHERE ID_USUARIO IS NOT NULL and PRINCIPAL='$principal' $var_ayo $var_usu  $var_fet $var_qna $var_sec
				group by PRINCIPAL
				order by PRINCIPAL";
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
				$sql_count="SELECT count(ID_USUARIO) COUNT,ID_USUARIO
							  FROM  V_Facturas_Solicitadas
							WHERE ID_USUARIO IS NOT NULL and ID_USUARIO='$usuario'  $var_ayo $var_usu  $var_fet $var_qna $var_sec
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
				<td  align='center' ><b>$marca </td>
				<td  align='center' ><b>$sector</td>

				<td  align='center' valign='middle' ><b>$tarifa</td>
				<td  align='center'  valign='middle' ><b>$tn</td>
				<td  align='center'  valign='middle' ><b>$td</td>
				<td  align='center'  valign='middle' ><b>$tf</td>
				<td  align='center'  valign='middle' ><b>$jerarquia</td>
				<td  align='center'  valign='middle' >$tua</td>
				<td  align='center'  valign='middle' >$tu</td>
				<td  align='center'  valign='middle' >$s_contratados</td>";

if(@$ftn>0){
					$html.="<td  align='center'  valign='middle' >
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 1 , $servicio)'  class='btn bg-primary button2' style='font-size: 10px; '>$ftn</button></td>";
				}else{
					$html.="<td  align='center'  valign='middle' >$ftn</td>";
				}/*if(@$ftd>0){
					$html.="<td  align='center'  valign='middle' >
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 2 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$ftd</button></td>";
				}else{*/
					$html.="<td  align='center'  valign='middle' >$ftd</td>";
				//}
				if(@$ftf>0){
					$html.="<td  align='center'  valign='middle' >
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 3 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$ftf</button></td>";
				}else{
					$html.="<td  align='center'  valign='middle' >$ftf</td>";
				}if(@$tamas>0){
					$html.="<td  align='center'  valign='middle' >
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 4 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$tamas</button></td>";
				}else{
					$html.="<td  align='center'  valign='middle' >$tamas</td>";
				}if(@$tame>0){
					$html.="<td  align='center'  valign='middle' >
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 5 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$tame</button></td>";
				}else{
					$html.="<td  align='center'  valign='middle' >$tame</td>";
				}if(@$taextmas>0){
					$html.="<td  align='center'  valign='middle' >
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 6 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$taextmas</button></td>";
				}else{
					$html.="<td  align='center'  valign='middle' >$taextmas</td>";
				}if(@$taextme>0){
					$html.="<td  align='center'  valign='middle' >
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 7 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$taextme</button></td>";
				}else{
					$html.="<td  align='center'  valign='middle' >$taextme</td>";
				}if(@$deductiva>0){
					$html.="<td  align='center'  valign='middle' >
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 8 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$deductiva</button></td>";
				}else{
					$html.="<td  align='center'  valign='middle' >$deductiva</td>";
				}if(@$f_tua>0){
					$html.="<td  align='center'  valign='middle' >
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 9 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$f_tua</button></td>";
				}else{
					$html.="<td  align='center'  valign='middle' >$f_tua</td>";
				}if(@$f_tu>0){
					$html.="<td  align='center'  valign='middle' >
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 10 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$f_tu</button></td>";
				}else{
					$html.="<td  align='center'  valign='middle' >$f_tu</td>";
				}if(@$f_jerarquia>0){
					$html.="<td  align='center'  valign='middle' >
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 11 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$f_jerarquia</button></td>";
				}else{
					$html.="<td  align='center'  valign='middle' >$f_jerarquia</td>";
				}
				if(@$taju>0){
					$html.="<td  align='center'  valign='middle' >
							<button onclick='modal2 ($anio, $qnas, \"$usuario\", 12 , $servicio)' type='button' class='btn bg-primary button2'  style='font-size: 10px; '>$taju</button></td>";
				}else{
					$html.="<td  align='center'  valign='middle' >$taju</td>";
				}
				$html.="	<td  align='center'  valign='middle' >$s_fatiga</td>
							<td  align='center'  valign='middle' >$s_diferencia</td>";
				if($varprin=='diferente'){
					if(@$c_fact<11){
						$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><a style='color:#337ab7;' href='../descargables/sector/pdf_previo_fact.php?Ayo=$ayo&Qna=$qna&usuario=$principal' target='_blank' data-toggle='modal' ><center><img src='../dist/img/fact.png' width='25px'></center></a></td>";
					}

					else if(@$c_form==1 and @$c_fact>10){
						$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_1.php?ayo=$ayo&qna=$qna&usuario=$principal' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					}

					else if(@$c_form==2 and @$c_fact>10){
						$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_2.php?ayo=$ayo&qna=$qna&usuario=$principal' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					}

					else if(@$c_form==3 and @$c_fact>10){
						$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_3.php?ayo=$ayo&qna=$qna&usuario=$principal' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					}

					else if(@$c_form==4 and @$c_fact>10){
						$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_4.php?ayo=$ayo&qna=$qna&usuario=$principal' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					}

					else if(@$c_form==5 and @$c_fact>10){
						$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_5.php?ayo=$ayo&qna=$qna&usuario=$principal' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					}

					else if(@$c_form==6 and @$c_fact>10){
						$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_6.php?ayo=$ayo&qna=$qna&usuario=$principal' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					}

					else if(@$c_form==7 and @$c_fact>10){
						$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_7.php?ayo=$ayo&qna=$qna&usuario=$principal' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					}

					else if(@$c_form==8 and @$c_fact>10){
						$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_8.php?ayo=$ayo&qna=$qna&usuario=$principal' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					}

					else if(@$c_form==9 and @$c_fact>10){
						$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_9.php?ayo=$ayo&qna=$qna&usuario=$principal' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					}

					else if(@$c_form==10 and @$c_fact>10){
						$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_10.php?ayo=$ayo&qna=$qna&usuario=$principal' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					}

					else if(@$c_form==11 and @$c_fact>10){
						$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_11.php?ayo=$ayo&qna=$qna&usuario=$principal' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					}

					else if(@$c_form==12 and @$c_fact>10){
						$html.="<td $count_principal  align='center' style='vertical-align: middle;' ><a style='color:#337ab7;' href='../includes/facturacion/pdf_informe_presupuestal_12.php?ayo=$ayo&qna=$qna&usuario=$principal' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>";
					}
					else{
						$html.="<td $count_principal  align='center' style='vertical-align: middle;' >-</a></td>";
					}
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
						<td  colspan='3' align='center' ><b>TOTALES </td>
						<td  align='center' >$t_tarifa</td>
						<td  align='center' >$t_tn</td>
						<td  align='center' valign='middle' >$t_td</td>
						<td  align='center'  valign='middle' >$t_tf</td>
						<td  align='center'  valign='middle' >$t_jerarquia</td>
						<td  align='center'  valign='middle' >$t_tua</td>
						<td  align='center'  valign='middle' >$t_tu</td>
						<td  align='center'  valign='middle' >$t_v</td>
						<td  align='center'  valign='middle' >$t_ftn</td>
						<td  align='center'  valign='middle' >$t_ftd</td>
						<td  align='center'  valign='middle' >$t_ftf</td>
						<td  align='center'  valign='middle' >$t_tamas</td>
						<td  align='center'  valign='middle' >$t_tame</td>
						<td  align='center'  valign='middle' >$t_taextmas</td>
						<td  align='center'  valign='middle' >$t_taextme</td>
						<td  align='center'  valign='middle' >$t_deductiva</td>
						<td  align='center'  valign='middle' >$t_ftua</td>
						<td  align='center'  valign='middle' >$t_ftu</td>
						<td  align='center'  valign='middle' >$t_fjerarquia</td>
						<td  align='center'  valign='middle' >$t_taju</td>
						<td  align='center'  valign='middle' >$t_v2</td>
						<td  align='center'  valign='middle' >$tsv2</td>
					</tr>";
				}
			    	if(@$suma3==(@$a2+1) and $principal!=""){
					$html.="
					<tr class='bg-danger'>
						<td  colspan='4' align='center' ><b>TOTALES</td>
						<td  align='center' ></td>
						<td  align='center' >$tt_tn</td>
						<td  align='center' valign='middle' >$tt_td</td>
						<td  align='center'  valign='middle' >$tt_tf</td>
						<td  align='center'  valign='middle' >$tt_jerarquia</td>
						<td  align='center'  valign='middle' >$tt_tua</td>
						<td  align='center'  valign='middle' >$tt_tu</td>
						<td  align='center'  valign='middle' >$tt_v</td>
						<td  align='center'  valign='middle' >$tt_ftn</td>
						<td  align='center'  valign='middle' >$tt_ftd</td>
						<td  align='center'  valign='middle' >$tt_ftf</td>
						<td  align='center'  valign='middle' >$tt_tamas</td>
						<td  align='center'  valign='middle' >$tt_tame</td>
						<td  align='center'  valign='middle' >$tt_taextmas</td>
						<td  align='center'  valign='middle' >$tt_taextme</td>
						<td  align='center'  valign='middle' >$tt_deductiva</td>
						<td  align='center'  valign='middle' >$tt_ftua</td>
						<td  align='center'  valign='middle' >$tt_ftu</td>
						<td  align='center'  valign='middle' >$tt_jerarquia</td>
						<td  align='center'  valign='middle' >$tt_taju</td>
						<td  align='center'  valign='middle' >$tt_v2</td>
						<td  align='center'  valign='middle' >$tsv</td>
					</tr>

					";

				}
				if(($count2-1)==$a1){
					$t_tarifa=0; $t_tn=0; $t_td=0; $t_tf=0; $t_jerarquia=0; $t_ftn=0; $t_ftd=0; $t_ftf=0; $t_tamas=0; $t_tame=0;
					$t_taextmas=0; $t_taextme=0; $t_deductiva=0; $t_tarifa2=0; $t_jerarquia2=0; $t_v=0; $t_v2=0; $tsv2=0;
					@$t_tua=0; 		@$t_tu=0;	@$t_ftua=0;	@$t_ftu=0; 	 	@$t_fjerarquia=0; @$t_taju=0;

				}if(@$suma3==(@$a2+1) and $principal!=""){
					$tt_tarifa=0; $tt_tn=0; $tt_td=0; $tt_tf=0; $tt_jerarquia=0; $tt_ftn=0; $tt_ftd=0; $tt_ftf=0; $tt_tamas=0; $tt_tame=0;
					$tt_taextmas=0; $tt_taextme=0; $tt_deductiva=0; $tt_tarifa2=0; $tt_jerarquia2=0; $tt_v=0; $tt_v2=0; $tsv=0;
					@$tt_fjerarquia=0;   	@$tt_ftu=0;   	@$tt_ftua=0;   @$tt_tu=0;   	@$tt_tua=0;  @$tt_taju=0;
				}
			}

            $html.="

			</table>

			</div>
			";


		echo $html;

}else{

echo	@$html.="<div class='alert alert-danger' role='alert'>
				<strong>NO EXISTEN RESULTADOS CON LOS FILTROS SELECCIONADOS O NO ESTA APERTURADA LA QUINCENA ACTUAL</strong>
			</div>";

}
?>
