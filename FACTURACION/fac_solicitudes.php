<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
	
	
?>                        
    <style>
#div1 {
     overflow-x:scroll;
   
     width:98%;
	
}
</style>
    
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        SOLICITUDES
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li style="font-size: ">
                            <a href=""><i class="fa fa-home"></i> Inicio</a>
                        </li>
                    </ol>
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center">   
                       <!-- <div id="cont">
                            Hola Soy un toggle
                        </div> -->
                        <form  method="POST" class="centrado" >
                        <div class="row" >
                       
               <div  class="col-md-2 col-sm-2 col-xs-2"><br>
				<center><label><?php echo htmlentities('AÑO:'); ?></label></center>
                
                <select name="ayof" class="form-control"  >
					<option value="" selected="selected">SELECCIONA</option>
                  <?php
                        $selec1="select DISTINCT(ayo)  from SECTOR.DBO.C_PERIODO_QNAS";
                        $resc1=sqlsrv_query($conn,$selec1);
                        while($rowsec= sqlsrv_fetch_array($resc1, SQLSRV_FETCH_ASSOC)){

						?>
                       <option value="<?php echo $rowsec['ayo'] ;?>"><?php echo utf8_encode ($rowsec['ayo']);?></option>
                         
						<?php
						}
						?>
				</select>
				
			</div>	
            
            <div  class="col-md-2 col-sm-2 col-xs-2"><br>
				<center><label><?php echo htmlentities('QUINCENA:'); ?></label></center>
				<select name="qnaf" class="form-control"  >
					<option value="" selected="selected">SELECCIONA</option>
					<?php
                        $selec2="select DISTINCT(Qna)  from seCTOR.DBO.C_PERIODO_QNAS";
                        $resc2=sqlsrv_query($conn,$selec2);
                        while($rowsec2= sqlsrv_fetch_array($resc2, SQLSRV_FETCH_ASSOC)){

						?>
                       <option value="<?php echo $rowsec2['Qna'] ;?>"><?php echo utf8_encode ($rowsec2['Qna']);?></option>
                         
						<?php
						}
						?>
				</select>
				
			</div>	
            
             <div  class="col-md-2 col-sm-2 col-xs-2"><br>
				<center><label><?php echo htmlentities('SECTOR:'); ?></label></center>
				<select name="secf" class="form-control"  >
					<option value="" selected="selected">SELECCIONA</option>
					<?php
                        $selec3="select SECTOR from sector.dbo.C_Sector where SECTOR > 50 GROUP BY SECTOR ORDER BY SECTOR";
                        $resc3=sqlsrv_query($conn,$selec3);
                        while($rowsec3= sqlsrv_fetch_array($resc3, SQLSRV_FETCH_ASSOC)){

						?>
                       <option value="<?php echo $rowsec3['SECTOR'] ;?>"><?php echo utf8_encode ($rowsec3['SECTOR']);?></option>
                         
						<?php
						}
						?>
				</select>
				
			</div>	
            
             <div  class="col-md-3 col-sm-3 col-xs-3"><br>
				<center><label><?php echo htmlentities('DESTACAMENTO:'); ?></label></center>
				<select name="ayof" class="form-control"  >
					<option value="" selected="selected">SELECCIONA</option>
					<?php
                        $selec4="select destacamento from sector.dbo.C_Destacamento where sector = 64 and DESTACAMENTO < 99 GROUP BY destacamento ORDER BY destacamento";
                        $resc4=sqlsrv_query($conn,$selec4);
                        while($rowsec4= sqlsrv_fetch_array($resc4, SQLSRV_FETCH_ASSOC)){

						?>
                       <option value="<?php echo $rowsec4['destacamento'] ;?>"><?php echo utf8_encode ($rowsec4['destacamento']);?></option>
                         
						<?php
						}
						?>
				</select>
				
			</div>	
           
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>
				<center><label><?php echo htmlentities('USUARIO:'); ?></label></center>
				<input type="text" name="usu" class="form-control" >
				
			</div>	
            <br><br><br><br><br><br>
            <center><label style="color:#337ab7; margin:0px;">PERIODO</label></center>
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>
			</div>
            
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>
				<center><label><?php echo htmlentities('DEL:'); ?></label></center>
				<input type="date" name="del" class="form-control" >
				
			</div>	
            
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>
				<center><label><?php echo htmlentities('AL:'); ?></label></center>
				<input type="date" name="al" class="form-control" >
			</div>	
            
            <div  class="col-md-3 col-sm-3 col-xs-3"><br>
			</div>	           
            
            <div  class="col-md-12 col-sm-12 col-xs-12"><br>
				<button name="boton"  value="reporte" class="btn btn-primary center-block">BUSCAR</button>
			</div>            
             
             
             
             <?php if(@$_REQUEST["boton"] == "reporte" ){?>
                  <br><br><br><br>    <br><br><br><br>  
            <div id="div1">
             <table    class="table table-responsive" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse:collapse;border-color:#ddd;font-size:10px;">
<thead> 
  <tr>
    <td colspan="6" align="center" class="bg-primary"><b>GENERALES&nbsp;</td>
    <td colspan="7" align="center" class="info"><b>CONTRATADOS</td>
    <td colspan="4" align="center" class="bg-primary"><b>FATIGA</td>
    <td colspan="7" align="center" class="info"><b>SECTOR</td>
    <td colspan="1" rowspan="2" width="15" align="center" class="warning"><b>TURNOS AJUSTE SIN ELEMENTO</td>
    <td colspan="1" rowspan="2" align="center" valign="middle" class="warning"><b>DEDUCTIVAS</td>
	<td colspan="1" align="center"  rowspan="2" valign="middle"  class="bg-primary"><b>PREVIO FACT.</td>
	<td colspan="1" align="center"  rowspan="2" valign="middle"  class="bg-primary"><b>ACCIONES</td>
  </tr>
  
  <tr>
    <td align="center" class="bg-primary"><b>PRINCIPAL</td>
    <td align="center" class="bg-primary"><b>ID USUARIO</td>
    <td align="center" class="bg-primary"><b>SERVICIO</td>
    <td align="center" class="bg-primary"><b>MARCA</td>
    <td align="center" class="bg-primary"><b>TIPO DE SERVICIO</td>
    <td align="center" class="bg-primary"><b>VER LEYENDA</td>
    <!--<td align="center" class="info"><b>ELEMENTOS</td>-->
    <td align="center" class="info"><b>TARIFA</td>
    <td align="center" class="info"><b>TN</td>
    <td align="center" class="info"><b>TA</td>
    <td align="center" class="info"><b>TD</td>
    <td align="center" class="info"><b>TF</td>
    <td align="center" class="info"><b>TU</td>
    <td align="center" class="info"><b>JERARQUIA</td>
    <!--<td align="center" class="bg-primary"><b>ELEMENTOS</td>-->
    <td align="center" class="bg-primary"><b>TN</td>
    <td align="center" class="bg-primary"><b>TA</td>
    <td align="center" class="bg-primary"><b>TD</td>
    <td align="center" class="bg-primary"><b>TF</td>
    <td align="center" class="info"><b>TU</td>
	<td align="center" class="info"><b>TE</td>
    <td align="center" class="info"><b>TA MAS</td>
	<td align="center" class="info"><b>TA MENOS</td>
    <td align="center" class="info"><b>TA EXT MAS</td>
    <td align="center" class="info"><b>TA EXT MENOS</td>
    <td align="center" class="info"><b>JERARQUIA</td>
    
    
    
  </tr>
 </thead>
  <tbody>
  <?php

  $SQL="SELECT PRINCIPAL,DT.ID_USUARIO,ID_SERVICIO,MARCA,TIPO_SERVICIO SERVICIO,ELEMENTOS,TARIFA,TN,TA,TD,TF,TU,JERARQUIA ,F_TN,	F_TA,	F_TD,	F_TF,	F_TU,	F_JERARQUIA,	F_TE,	TA_MAS,	TA_MENOS,	TA_EXT_MAS	,TA_EXT_MENOS
    FROM SECTOR.[dbo].[Detalle_cta] DT
      INNER JOIN SECTOR.DBO.USUARIO_C_SERVICIO US ON US.CVE_TIPO_SERVICIO=DT.CVE_TIPO_SERVICIO
	  LEFT JOIN  sector.dbo.USUARIO_PRINCIPAL UP ON DT.ID_USUARIO=UP.ID_USUARIO
         WHERE  AYO=2017 and QNA=5 AND Sector=64 and DESTACAMENTO=4
		  order by PRINCIPAL,ID_USUARIO,ID_SERVICIO,MARCA";
  $res = sqlsrv_query($conn, $SQL);
  $i=1;
  $f=2;
  $a=2;
  $z=1;
 $usu2="";
 $prin2="";
$t_ftn4=0; 		$t_fta4=0;		$t_ftd4=0;		$t_tarifa4=0;		$t_tn4=0;				$t_ta4=0;				$t_td4=0;				$t_tf4=0;		
$t_tu4=0;				$t_jerarquia4=0;			$t_ftf4=0;						$t_ftu4=0;					$t_fte4=0;					$t_tam4=0;			
$t_tame4=0;				$t_tae4=0;					$t_taem4=0;				$t_fjerarquia4=0;		
	while($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)){
		$usu=trim($row['ID_USUARIO']);
		$serv=$row['ID_SERVICIO'];
		$principal=$row['PRINCIPAL'];
		$marca=$row['MARCA'];
		$servicio=$row['SERVICIO'];	
		//$elementos=$row['ELEMENTOS'];		$t_elementos=$t_elementos+$elementos;	
		$ftn=$row['F_TN'];					@$t_ftn2=$t_ftn2+$ftn;								$t_ftn=number_format($t_ftn2, 2, '.', ',');
		$fta=$row['F_TA'];					@$t_fta2=$t_fta2+$fta;								$t_fta=number_format($t_fta2, 2, '.', ',');
		$ftd=$row['F_TD'];					@$t_ftd2=$t_ftd2+$ftd;								$t_ftd=number_format($t_ftd2, 2, '.', ',');
		$tarifa=$row['TARIFA'];				@$t_tarifa2=$t_tarifa2+$tarifa;						$t_tarifa=number_format($t_tarifa2, 2, '.', ',');
		$tn=$row['TN'];						@$t_tn2=$t_tn2+$tn;									$t_tn=number_format($t_tn2, 2, '.', ',');
		$ta=$row['TA'];						@$t_ta2=$t_ta2+$ta;									$t_ta=number_format($t_ta2, 2, '.', ',');
		$td=$row['TD'];						@$t_td2=$t_td2+$td;									$t_td=number_format($t_td2, 2, '.', ',');
		$tf=$row['TF'];						@$t_tf2=$t_tf2+$tf;									$t_tf=number_format($t_tf2, 2, '.', ',');
		$tu=$row['TU'];						@$t_tu2=$t_tu2+$tu;									$t_tu=number_format($t_tu2, 2, '.', ',');
		$jerarquia=$row['JERARQUIA'];		@$t_jerarquia2=$t_jerarquia2+$jerarquia;				$t_jerarquia=number_format($t_jerarquia2, 2, '.', ',');
		$ftf=$row['F_TF'];					@$t_ftf2=$t_ftf2+$ftf;								$t_ftf=number_format($t_ftf2, 2, '.', ',');
		$ftu=$row['F_TU'];					@$t_ftu2=$t_ftu2+$ftu;								$t_ftu=number_format($t_ftu2, 2, '.', ',');
		$fte=$row['F_TE'];					@$t_fte2=$t_fte2+$fte;								$t_fte=number_format($t_fte2, 2, '.', ',');
		$tam=$row['TA_MAS'];				@$t_tam2=$t_tam2+$tam;								$t_tam=number_format($t_tam2, 2, '.', ',');
		$tame=$row['TA_MENOS'];				@$t_tame2=$t_tame2+$tame;							$t_tame=number_format($t_tame2, 2, '.', ',');
		$tae=$row['TA_EXT_MAS'];			@$t_tae2=$t_tae2+$tae;								$t_tae=number_format($t_tae2, 2, '.', ',');
		$taem=$row['TA_EXT_MENOS'];			@$t_taem2=$t_taem2+$taem;							$t_taem=number_format($t_taem2, 2, '.', ',');
		$fjerarquia=$row['F_JERARQUIA'];	@$t_fjerarquia2=$t_fjerarquia2+$fjerarquia;			$t_fjerarquia=number_format($t_fjerarquia2, 2, '.', ',');
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
			$res_count2 = sqlsrv_query($conn,$sql_count2);
			$row_count2 = sqlsrv_fetch_array($res_count2, SQLSRV_FETCH_ASSOC);
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
			$res_count = sqlsrv_query($conn, $sql_count);
			$row_count = sqlsrv_fetch_array($res_count, SQLSRV_FETCH_ASSOC);
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
	

  ?>
  <tr> <!--<?php //if($i%2==0){?>  class="active"<?php // }else{?> class="#FFFFFF"<? //}?>--> 
    <?php if($varprin=='diferente'){ ?>
	<td <?php echo "rowspan='$suma'"; ?> style="vertical-align: middle;" align="center">&nbsp;<b><?php echo $principal; ?></td>
	<?php } if($var=='diferente' and $principal==null){ ?>
	<td <?php echo $count; ?> style="vertical-align: middle;" align="center" ><B><?php echo '-'; ?></td>	
	<?php }   ?>
    <?php if($var=='diferente'){ ?>
	<td <?php echo $count; ?> style="vertical-align: middle;" align="center" ><B><?php echo $usu; ?></td>	
	<?php } ?>
    <td>&nbsp;<?php echo $serv; ?></td>
    <td>&nbsp;<?php echo $marca; ?></td>
    <td>&nbsp;<?php echo $servicio; ?></td>
    <td><a href="fac_leyenda.php?usuario=<?php echo $usu; ?>&servicio=<?php echo $serv; ?>" style="color:#337ab7;" ><center>Ver leyenda</center></a></td>
    <!--<td>&nbsp;<?php echo $elementos; ?></td>-->
    <td>&nbsp;<?php echo $tarifa; ?></td>
    <td>&nbsp;<?php echo $tn; ?></td>
    <td>&nbsp;<?php echo $ta; ?></td>
    <td>&nbsp;<?php echo $td; ?></td>
    <td>&nbsp;<?php echo $tf; ?></td>
    <td>&nbsp;<?php echo $tu; ?></td>
    <td>&nbsp;<?php echo $jerarquia; ?></td>
    <!--<td>&nbsp;<?php echo $elementos; ?></td>-->
   <td><?php echo $ftn; ?></td>
   <td><?php echo $fta; ?></td>
   <td><?php echo $ftd; ?></td>
   <td><?php echo $ftf; ?></td>
   <td><?php echo $ftu; ?></td>
   <td><?php echo $fte; ?></td>
   <td>&nbsp;<a style="color:#337ab7;" href="fac_turnos.php?serv=<?php echo $serv; ?>&usu=<?php echo $usu; ?>& qna=<?php echo $qna; ?>&ayo=<?php echo $ayo; ?>&se= <?php echo $se; ?>&des= <?php echo $des; ?>&tipo=7"><?php echo $tam; ?></a></td>
   <td>&nbsp;<a style="color:#337ab7;" href="fac_turnos.php?serv=<?php echo $serv; ?>&usu=<?php echo $usu; ?>& qna=<?php echo $qna; ?>&ayo=<?php echo $ayo; ?>&se= <?php echo $se; ?>&des= <?php echo $des; ?>&tipo=8"><?php echo $tame; ?></a></td>
   <td>&nbsp;<a style="color:#337ab7;" href="fac_turnos.php?serv=<?php echo $serv; ?>&usu=<?php echo $usu; ?>& qna=<?php echo $qna; ?>&ayo=<?php echo $ayo; ?>&se= <?php echo $se; ?>&des= <?php echo $des; ?>&tipo=9"><?php echo $taem; ?></a></td>
   <td>&nbsp;<a style="color:#337ab7;" href="fac_turnos.php?serv=<?php echo $serv; ?>&usu=<?php echo $usu; ?>& qna=<?php echo $qna; ?>&ayo=<?php echo $ayo; ?>&se= <?php echo $se; ?>&des= <?php echo $des; ?>&tipo=10"><?php echo $taem; ?></a></td>
    <td>&nbsp;<?php echo $fjerarquia; ?></td>
    <td>&nbsp;<?php echo $fjerarquia; ?></td>
    <td><a style="color:#337ab7;" href="fac_deductivas.php" ><?php echo $fjerarquia; ?></a></td>
    <td><a style="color:#337ab7;" href="../descargables/pdf_previo_fact.php" target="_blank" data-toggle="modal" ><center><img src="../dist/img/pdf.png" width="25px"></center></a></td>
	<?php if($varprin=='diferente'){ ?>
	
	<td <?php echo "rowspan='$suma'"; ?> style="vertical-align: middle;" align="center"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">VALIDAR</button></td>
	<?php } if($var=='diferente' and $principal==null){?>
	
	<td <?php echo $count; ?> style="vertical-align: middle;" align="center"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">VALIDAR</button></td>
	<?php }   ?>
  </tr>
	<?php  if($count2==$a){
			@$j++;
			 $z++;
			?>
		<tr class="bg-success">
			<td colspan="3"  style="vertical-align: middle;" align="center"><b>TOTALES</td>
			<!--<td  style="vertical-align: middle;" align="center"><b><?php echo $t_elementos; ?></td>-->
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_tarifa; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_tn; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_ta; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_td; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_tf; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_tu; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_jerarquia; ?></td>
			<!--<td  style="vertical-align: middle;" align="center"><b><?php echo $t_elementos; ?></td>-->
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_ftn; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_fta; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_ftd; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_ftf; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_ftu; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_fte; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_tam; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_tame; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_tae; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_taem; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_fjerarquia; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_fjerarquia; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_fjerarquia; ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo $t_fjerarquia; ?></td>
		</tr>
	<?php  } ?>
	<?php if(@$suma==($z+1)  ){ 
		//$z++;	number_format($t_ftn2, 2, '.', ',')
	?>
	<tr class="bg-danger">
		<td colspan="4"  style="vertical-align: middle;" align="center"><b>TOTALES</td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_tarifa4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_tn4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_ta4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_td4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_tf4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_tu4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_jerarquia4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_ftn4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_fta4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_ftd4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_ftf4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_ftu4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_fte4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_tam4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_tame4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_tae4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_taem4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_fjerarquia4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_fjerarquia4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_fjerarquia4, 2, '.', ','); ?></td>
			<td  style="vertical-align: middle;" align="center"><b><?php echo number_format($t_fjerarquia4, 2, '.', ','); ?></td>
		</tr>
	
	<?php 	
	
		$t_ftn4=0;		$t_fta4=0;		$t_ftd4=0;		$t_tarifa4=0;		$t_tn4=0;				$t_ta4=0;				$t_td4=0;				$t_tf4=0;		
		$t_tu4=0;				$t_jerarquia4=0;			$t_ftf4=0;						$t_ftu4=0;					$t_fte4=0;					$t_tam4=0;			
		$t_tame4=0;				$t_tae4=0;					$t_taem4=0;				$t_fjerarquia4=0;			}
		
	
	if($count2==$a){ 
		$t_elementos=0;		$t_ftn=0; $t_ftn2=0;		$t_ftd=0; $t_ftd2=0;		$t_tarifa=0; $t_tarifa2=0;		$t_tn=0; $t_tn2=0;		$t_ta=0; $t_ta2=0;
		$t_td=0; $t_td2=0;		$t_tf=0; $t_tf2=0;		$t_tu=0; $t_tu2=0;		$t_jerarquia=0; $t_jerarquia2=0;		$t_fta=0; $t_fta2=0;		$t_ftf=0; $t_ftf2=0;
		$t_ftu=0; $t_ftu2=0;	$t_fte=0; $t_fte2=0;		$t_tam=0; $t_tam2=0;		$t_tame=0; $t_tame2=0;		$t_tae=0; $t_tae2=0;		$t_taem=0; $t_taem2=0;
		$t_fjerarquia=0; $t_fjerarquia2=0;
		
	}	?>
  <?php     $z++;  } ?>
  </tbody>
</table>     
</div>     
           <?php  } ?>           
                        </div>
                       
                    </div>                                    
                </div>                
            </section>
            </div>
            </form>
            <?php include_once '../footer.html'; ?>
            <script>
//                Funcion con ajax sinn formulario
//                function buttonGraf(sec) {
//                    
//                    var url = "<?php echo BASE_URL; ?>includes/facturacionEmitida/responseGrafFacEm.php";
//
//                    $.ajax({
//                        type: "POST",
//                        url: url,
//                        data: {
//                            UnoCal1: $('#UnoCal1').val(),                            
//                            Sector: sec
//                        },
//                        success: function (data)
//                        {
//                            $("#tb2").html(data); // Mostrar la respuestas del script PHP.
//                            document.getElementById("tb2").style.display="block";                               
//                        }
//                    });
//                    document.getElementById("Sec").value = sec;                              
//                    return false;
//                }
//*****************************************************************************************************************************

//        AJAX CON FORMULARIO
//    $('#formTb1').submit(function () {
//        var url = "<?php echo BASE_URL; ?>includes/facturacionEmitida/responseFactEm.php";
//        $.ajax({
//            type: "POST",
//            url: url,
//            data: $("#formTb1").serialize(), // Adjuntar los campos del formulario enviado.
//            success: function (data)
//            {
//                $("#tb1").html(data); // Mostrar la respuestas del script PHP.    
//                document.getElementById('tb2').style.display = "none";                                                             
//            }
//        });
//
//        return false;
//    });
            </script>



