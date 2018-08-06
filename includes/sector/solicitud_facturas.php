<?php
set_time_limit(0);
include '../../conexiones/sqlsrv.php';
$conn = connection_object();



 @$ayo=$_REQUEST['Ayo'];
 @$qna=$_REQUEST['Qna'];
 @$usuario=$_REQUEST['Usuario'];
 @$del=$_REQUEST['Del'];
 @$al=$_REQUEST['Al'];
 $html = "";
 /*
$html.="<table    class='table table-responsive' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='border-collapse:collapse;border-color:#ddd;font-size:10px;'>
<thead> 
  <tr>
    <td colspan='6' align='center' class='bg-primary'><b>GENERALES&nbsp;</td>
    <td colspan='7' align='center' class='bg-secondary'><b>CONTRATADOS</td>
    <td colspan='11' align='center' class='bg-primary'><b>FATIGA</td>
    <td colspan='1' rowspan='2' width='15' align='center' class='bg-secondary'><b>TURNOS AJUSTE SIN ELEMENTO</td>
    <td colspan='1' rowspan='2' align='center' valign='middle' class='bg-secondary'><b>DEDUCTIVAS</td>
	<td colspan='1' align='center'  rowspan='2' valign='middle'  class='bg-primary'><b>PREVIO FACT.</td>
	<td colspan='1' align='center'  rowspan='2' valign='middle'  class='bg-primary'><b>ACCIONES</td>
  </tr>
  
  <tr>
    <td align='center' class='bg-primary'><b>PRINCIPAL</td>
    <td align='center' class='bg-primary'><b>ID USUARIO</td>
    <td align='center' class='bg-primary'><b>SERVICIO</td>
    <td align='center' class='bg-primary'><b>MARCA</td>
    <td align='center' class='bg-primary'><b>TIPO DE SERVICIO</td>
    <td align='center' class='bg-primary'><b>VER LEYENDA</td>
    <!--<td align='center' class='bg-secondary'><b>ELEMENTOS</td>-->
    <td align='center' class='bg-secondary'><b>TARIFA</td>
    <td align='center' class='bg-secondary'><b>TN</td>
    <td align='center' class='bg-secondary'><b>TA</td>
    <td align='center' class='bg-secondary'><b>TD</td>
    <td align='center' class='bg-secondary'><b>TF</td>
    <td align='center' class='bg-secondary'><b>TU</td>
    <td align='center' class='bg-secondary'><b>JERARQUIA</td>
    <!--<td align='center' class='bg-primary'><b>ELEMENTOS</td>-->
    <td align='center' class='bg-primary'><b>TN</td>
    <td align='center' class='bg-primary'><b>TA</td>
    <td align='center' class='bg-primary'><b>TD</td>
    <td align='center' class='bg-primary'><b>TF</td>
    <td align='center' class='bg-primary'><b>TU</td>
	<td align='center' class='bg-primary'><b>TE</td>
    <td align='center' class='bg-primary'><b>TA MAS</td>
	<td align='center' class='bg-primary'><b>TA MENOS</td>
    <td align='center' class='bg-primary'><b>TA EXT MAS</td>
    <td align='center' class='bg-primary'><b>TA EXT MENOS</td>
    <td align='center' class='bg-primary'><b>JERARQUIA</td>
    
    
    
  </tr>
 </thead>
  <tbody>";


  $SQL="SELECT PRINCIPAL,AYO,QNA,DT.ID_USUARIO,ID_SERVICIO,MARCA,TIPO_SERVICIO SERVICIO,ELEMENTOS,TARIFA,TN,TA,TD,TF,TU,JERARQUIA ,F_TN,	F_TA,	F_TD,	F_TF,	F_TU,	F_JERARQUIA,	F_TE,	TA_MAS,	TA_MENOS,	TA_EXT_MAS	,TA_EXT_MENOS
    FROM SECTOR.[dbo].[Detalle_cta] DT
      INNER JOIN SECTOR.DBO.USUARIO_C_SERVICIO US ON US.CVE_TIPO_SERVICIO=DT.CVE_TIPO_SERVICIO
	  LEFT JOIN  sector.dbo.USUARIO_PRINCIPAL UP ON DT.ID_USUARIO=UP.ID_USUARIO
         WHERE  AYO=2017 and QNA=5 AND Sector=64 and DESTACAMENTO=4
		  order by PRINCIPAL,ID_USUARIO,ID_SERVICIO,MARCA";
  $res = sqlsrv_query( $conn,$SQL);
  $i=1;
  $f=2;
  $a=2;
  $z=1;
 $usu2="";
 $prin2="";
$t_ftn4=0; 		$t_fta4=0;		$t_ftd4=0;		$t_tarifa4=0;		$t_tn4=0;				$t_ta4=0;				$t_td4=0;				$t_tf4=0;		
$t_tu4=0;				$t_jerarquia4=0;			$t_ftf4=0;						$t_ftu4=0;					$t_fte4=0;					$t_tam4=0;			
$t_tame4=0;				$t_tae4=0;					$t_taem4=0;				$t_fjerarquia4=0;		
	while($row = sqlsrv_fetch_array($res)){
		$usu=trim($row['ID_USUARIO']);
		$serv=$row['ID_SERVICIO'];
		$ayo=$row['AYO'];
		$qna=$row['QNA'];
		$principal=$row['PRINCIPAL'];
		$marca=$row['MARCA'];
		$servicio=$row['SERVICIO'];	
		//$elementos=$row['ELEMENTOS'];		$t_elementos=$t_elementos+$elementos;	
		$ftn=$row['F_TN'];					$t_ftn2=@$t_ftn2+$ftn;								$t_ftn=number_format($t_ftn2, 2, '.', ',');
		$fta=$row['F_TA'];					$t_fta2=@$t_fta2+$fta;								$t_fta=number_format($t_fta2, 2, '.', ',');
		$ftd=$row['F_TD'];					$t_ftd2=@$t_ftd2+$ftd;								$t_ftd=number_format($t_ftd2, 2, '.', ',');
		$tarifa=$row['TARIFA'];				$t_tarifa2=@$t_tarifa2+$tarifa;						$t_tarifa=number_format($t_tarifa2, 2, '.', ',');
		$tn=$row['TN'];						$t_tn2=@$t_tn2+$tn;									$t_tn=number_format($t_tn2, 2, '.', ',');
		$ta=$row['TA'];						$t_ta2=@$t_ta2+$ta;									$t_ta=number_format($t_ta2, 2, '.', ',');
		$td=$row['TD'];						$t_td2=@$t_td2+$td;									$t_td=number_format($t_td2, 2, '.', ',');
		$tf=$row['TF'];						$t_tf2=@$t_tf2+$tf;									$t_tf=number_format($t_tf2, 2, '.', ',');
		$tu=$row['TU'];						$t_tu2=@$t_tu2+$tu;									$t_tu=number_format($t_tu2, 2, '.', ',');
		$jerarquia=$row['JERARQUIA'];		$t_jerarquia2=@$t_jerarquia2+$jerarquia;				$t_jerarquia=number_format($t_jerarquia2, 2, '.', ',');
		$ftf=$row['F_TF'];					$t_ftf2=@$t_ftf2+$ftf;								$t_ftf=number_format($t_ftf2, 2, '.', ',');
		$ftu=$row['F_TU'];					$t_ftu2=@$t_ftu2+$ftu;								$t_ftu=number_format($t_ftu2, 2, '.', ',');
		$fte=$row['F_TE'];					$t_fte2=@$t_fte2+$fte;								$t_fte=number_format($t_fte2, 2, '.', ',');
		$tam=$row['TA_MAS'];				$t_tam2=@$t_tam2+$tam;								$t_tam=number_format($t_tam2, 2, '.', ',');
		$tame=$row['TA_MENOS'];				$t_tame2=@$t_tame2+$tame;							$t_tame=number_format($t_tame2, 2, '.', ',');
		$tae=$row['TA_EXT_MAS'];			$t_tae2=@$t_tae2+$tae;								$t_tae=number_format($t_tae2, 2, '.', ',');
		$taem=$row['TA_EXT_MENOS'];			$t_taem2=@$t_taem2+$taem;							$t_taem=number_format($t_taem2, 2, '.', ',');
		$fjerarquia=$row['F_JERARQUIA'];	$t_fjerarquia2=@$t_fjerarquia2+$fjerarquia;			$t_fjerarquia=number_format($t_fjerarquia2, 2, '.', ',');
		if($principal!=""){
		$t_ftn4=$t_ftn4+$ftn;
		$t_fta4=$t_fta4+$fta;
		$t_ftd4=$t_ftd4+$ftd;
		$t_tarifa4=$t_tarifa4+$tarifa;
		$t_tn4=$t_tn4+$tn;		
		$t_ta4=$t_ta4+$ta;		
		$t_td4=$t_td4+$td;		
		$t_tf4=$t_tf4+$tf;		
		$t_tu4=$t_tu4+$tu;		
		$t_jerarquia4=$t_jerarquia4+$jerarquia;	
		$t_ftf4=$t_ftf4+$ftf;				
		$t_ftu4=$t_ftu4+$ftu;			
		$t_fte4=$t_fte4+$fte;			
		$t_tam4=$t_tam4+$tam;			
		$t_tame4=$t_tame4+$tame;		
		$t_tae4=$t_tae4+$tae;			
		$t_taem4=$t_taem4+$taem;		
		$t_fjerarquia4=$t_fjerarquia4+$fjerarquia;		
		}
if($prin2<>$principal){
	
	$prin2=$principal;
	$f=2;
	$j=0;
	$z=1;
	$varprin="diferente";
	$sql_count2="declare  @registros as int ,@usuarios as int ,@suma as int
				  SELECT @registros= count(DT.ID_USUARIO) 
				  FROM SECTOR.[dbo].[Detalle_cta] DT 
				  INNER JOIN SECTOR.DBO.USUARIO_C_SERVICIO US ON US.CVE_TIPO_SERVICIO=DT.CVE_TIPO_SERVICIO 
				  LEFT JOIN sector.dbo.USUARIO_PRINCIPAL UP ON DT.ID_USUARIO=UP.ID_USUARIO 
				  WHERE QNA=5 AND AYO=2017 AND  Sector=64 and DESTACAMENTO=4 and PRINCIPAL='$principal' 
				  
				  SELECT @usuarios=count(distinct(DT.ID_USUARIO)) 
				  FROM SECTOR.[dbo].[Detalle_cta] DT 
				  INNER JOIN SECTOR.DBO.USUARIO_C_SERVICIO US ON US.CVE_TIPO_SERVICIO=DT.CVE_TIPO_SERVICIO 
				  LEFT JOIN sector.dbo.USUARIO_PRINCIPAL UP ON DT.ID_USUARIO=UP.ID_USUARIO 
				  WHERE QNA=5 AND AYO=$2017 and  PRINCIPAL='$principal'  AND  Sector=64 and DESTACAMENTO=4
				  select  @suma=@registros+@usuarios
				  select @registros,@usuarios USUARIOS,@suma SUMA";
			$res_count2 = sqlsrv_query( $conn,$sql_count2);
			$row_count2 = sqlsrv_fetch_array($res_count2);
			$suma=trim($row_count2['SUMA']);
			$susu=trim($row_count2['USUARIOS']);
			$suma22=$suma;
			$suma=$suma+1;
			
		
}else{
	$varprin="";
}
		
if(trim($usu2)<>$usu){
			

	$usu2=$usu;
	$var="diferente";
	
	$sql_count="SELECT ID_USUARIO,COUNT(ID_USUARIO) COUNT    FROM SECTOR.[dbo].[Detalle_cta] DT
			INNER JOIN SECTOR.DBO.USUARIO_C_SERVICIO US ON US.CVE_TIPO_SERVICIO=DT.CVE_TIPO_SERVICIO
			WHERE QNA=5 AND AYO=2017 AND ID_USUARIO='$usu' AND  Sector=64 and DESTACAMENTO=4 group by ID_USUARIO order by ID_USUARIO";
			$res_count = sqlsrv_query( $conn,$sql_count);
			$row_count = sqlsrv_fetch_array($res_count);
			$id_count=trim($row_count['ID_USUARIO']);
			$count=$row_count['COUNT'];				
			$count22=$row_count['COUNT'];				
			$count2=$count+1;
		if($usu==$id_count){	 $count="rowspan='$count2'";	}else{	$count="";	}	
	$i++;	
	$a=2;
	$f++;
	
}else{
	$var='';
	$a++;
	$f++;
}
	

  $html.="
  <tr>";
    if($varprin=='diferente'){ 
	$html.="<td rowspan=$suma style='vertical-align: middle; align='center'>&nbsp;<b>$principal</td>.";
	} if($var=='diferente' and $principal==null){ 
	$html.="<td $count style='vertical-align: middle;' align='center' ><B>-</td>";
	 } 
    if($var=='diferente'){ 
	$html.=" <td $count style='vertical-align: middle;' align='center' ><B>$usu</td>	";
	 } 
	 $html.="
    <td>&nbsp;".$serv." </td>
    <td>&nbsp; ".$marca." </td>
    <td>&nbsp; ".$servicio." </td>
    <td><a href='sec_leyenda.php?usuario=".$usu."&servicio=$serv' style='color:#337ab7;' ><center>Ver leyenda</center></a></td>
    <td>&nbsp; $tarifa </td>
    <td>&nbsp; $tn </td>
    <td>&nbsp; $ta </td>
    <td>&nbsp; $td </td>
    <td>&nbsp; $tf </td>
    <td>&nbsp; $tu </td>
    <td>&nbsp; $jerarquia </td>
   <td> $ftn </td>
   <td> $fta </td>
   <td> $ftd </td>
   <td> $ftf </td>
   <td> $ftu </td>
   <td> $fte </td>
  
	";
	$html.="
	<td>&nbsp; $tam</td>
   <td>&nbsp;$tame</td>
   <td>&nbsp;$taem </td>
   <td>&nbsp;$taem</td>
    <td>&nbsp;$fjerarquia</td>
    <td>&nbsp;$fjerarquia </td>
    <td><a href='sec_detalle_elementos.php?usuario=$usu&qna=$qna&ayo=$ayo' style='color:#337ab7;' ><center>$fjerarquia</center></a></td>
    ";
	if($varprin=='diferente'){ 
	$html.="
	<td rowspan=$suma style='vertical-align: middle;' ><a style='color:#337ab7' href='../descargables/sector/pdf_previo_fact.php' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>
	<td rowspan=$suma style='vertical-align: middle;' align='center'><button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#myModal'>VALIDAR</button></td>";
	 } if($var=='diferente' and $principal==null){
	$html.="
	<td  $count style='vertical-align: middle;' ><a style='color:#337ab7; ' href='../descargables/sector/pdf_previo_fact.php' target='_blank' data-toggle='modal' ><center><img src='../dist/img/pdf.png' width='25px'></center></a></td>
	<td $count style='vertical-align: middle;' align='center'><button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#myModal'>VALIDAR</button></td>";
	 }   
	$html.="</tr>";
	  if(@$count2==@$a){
			@$j++;
			 @$z++;
	$html.="
		<tr class='bg-success'>
			<td colspan='3'  style='vertical-align: middle;' align='center'><b>TOTALES</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_tarifa</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_tn</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_ta</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_td</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_tf</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_tu</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_jerarquia</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_ftn</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_fta</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_ftd</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_ftf</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_ftu</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_fte</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_tam</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_tame</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_tae</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_taem</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_fjerarquia</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_fjerarquia</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_fjerarquia</td>
			<td  style='vertical-align: middle;' align='center'><b> $t_fjerarquia</td>
		</tr>";
	  }
	 if(@$suma==(@$z+1)){ 
	$html.="
	
	<tr class='bg-danger'>
		<td colspan='4'  style='vertical-align: middle;' align='center'><b>TOTALES</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_tarifa4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_tn4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_tn4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_ta4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_td4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_tf4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_tu4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_jerarquia4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_ftn4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_fta4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_ftd4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_ftf4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_ftu4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_fte4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_tam4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_tame4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_tae4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_taem4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_fjerarquia4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_fjerarquia4, 2, '.', ',')."</td>
			<td  style='vertical-align: middle;' align='center'><b>".number_format($t_fjerarquia4, 2, '.', ',')."</td>
			
		</tr>";
	
	 	
	
		$t_ftn4=0;		$t_fta4=0;		$t_ftd4=0;		$t_tarifa4=0;		$t_tn4=0;				$t_ta4=0;				$t_td4=0;				$t_tf4=0;		
		$t_tu4=0;				$t_jerarquia4=0;			$t_ftf4=0;						$t_ftu4=0;					$t_fte4=0;					$t_tam4=0;			
		$t_tame4=0;				$t_tae4=0;					$t_taem4=0;				$t_fjerarquia4=0;			}
		
	
	if($count2==$a){ 
		$t_elementos=0;		$t_ftn=0; $t_ftn2=0;		$t_ftd=0; $t_ftd2=0;		$t_tarifa=0; $t_tarifa2=0;		$t_tn=0; $t_tn2=0;		$t_ta=0; $t_ta2=0;
		$t_td=0; $t_td2=0;		$t_tf=0; $t_tf2=0;		$t_tu=0; $t_tu2=0;		$t_jerarquia=0; $t_jerarquia2=0;		$t_fta=0; $t_fta2=0;		$t_ftf=0; $t_ftf2=0;
		$t_ftu=0; $t_ftu2=0;	$t_fte=0; $t_fte2=0;		$t_tam=0; $t_tam2=0;		$t_tame=0; $t_tame2=0;		$t_tae=0; $t_tae2=0;		$t_taem=0; $t_taem2=0;
		$t_fjerarquia=0; $t_fjerarquia2=0;
		
	}	    $z++; 
	
	} 
     
	 $html.="
  </tbody>
</table>";*/

		$html.="<div id='captura_datos'  style='display: none;'>&nbsp;</div> 
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
			
			 $SQL="  declare
			  @AYO as int=2015,
			  @QNA AS INT=16,
			  @ID_USUARIO AS VARCHAR(20)='27441',
			  @FECHA_INI AS DATE='',
			  @FECHA_FIN AS DATE=''
			   SELECT top 25  PRINCIPAL,TD.ID_USUARIO,TD.ID_SERVICIO,MARCA,TARIFA,TN,TD,TF,JERARQUIA ,F_TN,F_TD,F_TF,TA_MAS,TA_MENOS ,
			   ISNULL(T1.TA_EXT_MAS,0)TA_EXT_MAS ,ISNULL(T2.TA_EXT_MENOS,0)TA_EXT_MENOS, ISNULL(CANTIDAD,0) DEDUCTIVAS 
			  FROM  Facturacion.dbo.Turnos_Facturacion TD
					INNER JOIN [15.30.30.151].SECTOR.DBO.[Usuario_V_Serv_Desarrollo] US ON TD.ID_USUARIO=US.ID_USUARIO AND TD.ID_SERVICIO=US.ID_SERVICIO
					LEFT OUTER JOIN  sector.dbo.USUARIO_PRINCIPAL UP ON TD.ID_USUARIO=UP.ID_USUARIO
					LEFT OUTER JOIN  Facturacion.dbo.Deductivas D ON TD.ID_USUARIO=D.ID_USUARIO AND TD.ID_SERVICIO=D.ID_SERVICIO
					LEFT OUTER JOIN ( SELECT  ID_USUARIO, ID_SERVICIO,QNA,AYO , COUNT (ID_USUARIO) TA_EXT_MAS FROM [15.30.30.151].SECTOR.DBO.Turno_Ajuste_Extemporaneo  
						WHERE AYO=@AYO  AND QNA=@QNA AND CVE_TIPO_AJUSTE=2 GROUP BY ID_USUARIO, ID_SERVICIO,QNA,AYO ) T1 ON TD.ID_USUARIO=T1.ID_USUARIO AND TD.AYO=T1.AYO AND TD.QNA=T1.QNA
					LEFT OUTER JOIN ( SELECT  ID_USUARIO, ID_SERVICIO,QNA,AYO , COUNT (ID_USUARIO) TA_EXT_MENOS FROM [15.30.30.151].SECTOR.DBO.Turno_Ajuste_Extemporaneo 
						WHERE AYO=@AYO  AND QNA=@QNA AND CVE_TIPO_AJUSTE=1  AND  ID_USUARIO=@ID_USUARIO   GROUP BY ID_USUARIO, ID_SERVICIO,QNA,AYO ) T2 ON TD.ID_USUARIO=T2.ID_USUARIO AND TD.AYO=T2.AYO AND TD.QNA=T2.QNA
					LEFT JOIN [15.30.30.151].SECTOR.DBO.C_PERIODOS_FACTURACION  T3 ON T1.AYO=T3.AYO AND T1.QNA=T3.QNA
				      WHERE td.AYO=@AYO and td.qna =@qna
					  order by PRINCIPAL,ID_USUARIO,ID_SERVICIO,MARCA		";
			$res = sqlsrv_query( $conn,$SQL);
			$prin2=0;	
			$usu2=0;	
			while($row = sqlsrv_fetch_array($res)){
				$principal=trim($row['PRINCIPAL']);
				$usuario=$row['ID_USUARIO'];
				$servicio=$row['ID_SERVICIO'];
				$marca=$row['MARCA'];
				$tarifa2=$row['TARIFA'];
				$tn=$row['TN'];
				$td=$row['TD'];
				$tf=$row['TF'];
				$jerarquia2=$row['JERARQUIA'];
				$ftn=$row['F_TN'];
				$ftd=$row['F_TD'];
				$ftf=$row['F_TF'];
				$tamas=$row['TA_MAS'];
				$tame=$row['TA_MENOS'];
				$taextmas=$row['TA_EXT_MAS'];
				$taextme=$row['TA_EXT_MENOS'];
				$deductiva=$row['DEDUCTIVAS'];
				$tarifa=number_format($tarifa2, 2, '.', ',');
				$jerarquia=number_format($jerarquia2, 2, '.', ',');
				
				
			if($prin2<>$principal){
			$prin2=$principal;
			$varprin="diferente";
								 
			$sql_count2="declare
					@AYO as int=2015,
					@QNA AS INT=16,
					@ID_USUARIO AS VARCHAR(20)='27441',
					@FECHA_INI AS DATE='',
					@FECHA_FIN AS DATE=''
					SELECT  COUNT(ISNULL(PRINCIPAL,0)) SUMA,PRINCIPAL
					FROM  Facturacion.dbo.Turnos_Facturacion TD
						INNER JOIN [15.30.30.151].SECTOR.DBO.[Usuario_V_Serv_Desarrollo] US ON TD.ID_USUARIO=US.ID_USUARIO AND TD.ID_SERVICIO=US.ID_SERVICIO
						LEFT OUTER JOIN  sector.dbo.USUARIO_PRINCIPAL UP ON TD.ID_USUARIO=UP.ID_USUARIO
						LEFT OUTER JOIN  Facturacion.dbo.Deductivas D ON TD.ID_USUARIO=D.ID_USUARIO AND TD.ID_SERVICIO=D.ID_SERVICIO
						LEFT OUTER JOIN ( SELECT  ID_USUARIO, ID_SERVICIO,QNA,AYO , COUNT (ID_USUARIO) TA_EXT_MAS FROM [15.30.30.151].SECTOR.DBO.Turno_Ajuste_Extemporaneo  
							WHERE AYO=@AYO  AND QNA=@QNA AND CVE_TIPO_AJUSTE=2 GROUP BY ID_USUARIO, ID_SERVICIO,QNA,AYO ) T1 ON TD.ID_USUARIO=T1.ID_USUARIO AND TD.AYO=T1.AYO AND TD.QNA=T1.QNA
						LEFT OUTER JOIN ( SELECT  ID_USUARIO, ID_SERVICIO,QNA,AYO , COUNT (ID_USUARIO) TA_EXT_MENOS FROM [15.30.30.151].SECTOR.DBO.Turno_Ajuste_Extemporaneo 
							WHERE AYO=@AYO  AND QNA=@QNA AND CVE_TIPO_AJUSTE=1  AND  ID_USUARIO=@ID_USUARIO   GROUP BY ID_USUARIO, ID_SERVICIO,QNA,AYO ) T2 ON TD.ID_USUARIO=T2.ID_USUARIO AND TD.AYO=T2.AYO AND TD.QNA=T2.QNA
						LEFT JOIN [15.30.30.151].SECTOR.DBO.C_PERIODOS_FACTURACION  T3 ON T1.AYO=T3.AYO AND T1.QNA=T3.QNA
							WHERE td.AYO=@AYO and td.qna =@qna and PRINCIPAL='$principal' group by PRINCIPAL
							   order by PRINCIPAL ";
							
					$res_count2 = sqlsrv_query( $conn,$sql_count2);
					$row_count2 = sqlsrv_fetch_array($res_count2);
					$suma=trim($row_count2['SUMA']);
					$count_principal="rowspan='$suma'";
		}else{
			$varprin="";
			
		}	
		if(trim($usu2)<>trim($usuario)){
					

			$usu2=$usuario;
			$var2="diferente";

			$sql_count="  declare
						  @AYO as int=2015,
						  @QNA AS INT=16,
						  @ID_USUARIO AS VARCHAR(20)='$usuario',
						  @FECHA_INI AS DATE='',
						  @FECHA_FIN AS DATE=''
						   SELECT count(TD.ID_USUARIO) COUNT,TD.ID_USUARIO
						  FROM  Facturacion.dbo.Turnos_Facturacion TD
								INNER JOIN [15.30.30.151].SECTOR.DBO.[Usuario_V_Serv_Desarrollo] US ON TD.ID_USUARIO=US.ID_USUARIO AND TD.ID_SERVICIO=US.ID_SERVICIO
								LEFT OUTER JOIN  sector.dbo.USUARIO_PRINCIPAL UP ON TD.ID_USUARIO=UP.ID_USUARIO
								LEFT OUTER JOIN  Facturacion.dbo.Deductivas D ON TD.ID_USUARIO=D.ID_USUARIO AND TD.ID_SERVICIO=D.ID_SERVICIO
								LEFT OUTER JOIN ( SELECT  ID_USUARIO, ID_SERVICIO,QNA,AYO , COUNT (ID_USUARIO) TA_EXT_MAS FROM [15.30.30.151].SECTOR.DBO.Turno_Ajuste_Extemporaneo  
									WHERE AYO=@AYO  AND QNA=@QNA AND CVE_TIPO_AJUSTE=2 GROUP BY ID_USUARIO, ID_SERVICIO,QNA,AYO ) T1 ON TD.ID_USUARIO=T1.ID_USUARIO AND TD.AYO=T1.AYO AND TD.QNA=T1.QNA
								LEFT OUTER JOIN ( SELECT  ID_USUARIO, ID_SERVICIO,QNA,AYO , COUNT (ID_USUARIO) TA_EXT_MENOS FROM [15.30.30.151].SECTOR.DBO.Turno_Ajuste_Extemporaneo 
									WHERE AYO=@AYO  AND QNA=@QNA AND CVE_TIPO_AJUSTE=1  AND  ID_USUARIO=@ID_USUARIO   GROUP BY ID_USUARIO, ID_SERVICIO,QNA,AYO ) T2 ON TD.ID_USUARIO=T2.ID_USUARIO AND TD.AYO=T2.AYO AND TD.QNA=T2.QNA
								LEFT JOIN [15.30.30.151].SECTOR.DBO.C_PERIODOS_FACTURACION  T3 ON T1.AYO=T3.AYO AND T1.QNA=T3.QNA
							 WHERE td.AYO=@AYO and td.qna =@qna  and  TD.ID_USUARIO=@ID_USUARIO  
							  
							 group by PRINCIPAL,TD.ID_USUARIO 
							   order by PRINCIPAL,ID_USUARIO"; 
					$res_count = sqlsrv_query( $conn,$sql_count);
					$row_count = sqlsrv_fetch_array($res_count);
					$id_count=trim($row_count['ID_USUARIO']);
					$count=$row_count['COUNT'];				
					$count22=$row_count['COUNT'];				
					$count2=$count+1;
				if(@$usuario==@$id_count){	 $count="rowspan='$count'";	}else{	$count="";	}	
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
				
				<td  align='center' ><b>$servicio</td>
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
				<td  align='center'  valign='middle' ><b>$deductiva</td>
			  </tr>
			";
				
				
				
			}

		echo $html;			  

?>