<?php
    include_once '../config.php';
    include_once '../head.html';
    include_once '../menuLat.php';
    
?>      

  <?php 
  //CONSULTAS	---		CONSULTAS	---		CONSULTAS	---		CONSULTAS	---
	$sql_ayo="select DISTINCT(ayo)  from seCTOR.DBO.C_PERIODO_QNAS";       
	$res_ayo = sqlsrv_query($conn,$sql_ayo); 		  
	$sql_qna="select DISTINCT(Qna)  from seCTOR.DBO.C_PERIODO_QNAS";       
	$res_qna = sqlsrv_query($conn,$sql_qna); 
	$sql_usuario="select SECTOR from sector.dbo.C_Sector GROUP BY SECTOR ORDER BY SECTOR";       
	$res_usuario = sqlsrv_query( $conn,$sql_usuario); 			
  ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style=" background-color: white;">
                <!--Titulos de encabezado de la pagina-->
                <section class="content-header" style=" background-color: white; border-bottom: 1px solid #85929E;">
                    <h1>
                        SISTEMA FACTURACIÓN - SECTOR
                        <small>DEDUCTIVAS</small>
                    </h1>                    
                    <br>
                </section>
                <!-- FIN DE Titulos de encabezado de la pagina-->
                
                <section class="content" >
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-center">   
						<h2>USUARIO</h2>
			<h3>SERVICO</h3>	
			<h4>DETALLE DE DEDUCTIVAS</h4>
			
			
			<center>
<table    class="table table-responsive" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000"  style="border-collapse:collapse;border-color:#ddd;font-size:10px; width:400px;">
<thead> 
  <tr>
    <td align="center" class="bg-primary"><b>DEDUCTIVAS</td>
    <td align="center" class="info"><b>NUMERO</td>  
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
  $res = sqlsrv_query( $conn,$SQL);
		
	while($row =sqlsrv_fetch_array($res)){
		$usu=trim($row['ID_USUARIO']);
		$serv=$row['ID_SERVICIO'];
		$principal=$row['PRINCIPAL'];
		$marca=$row['MARCA'];
		$servicio=$row['SERVICIO'];	
		

	

  ?>
  <tr> 
   
    <td>&nbsp;<?php echo $serv; ?></td>
    <td>&nbsp;<?php echo $marca; ?></td>
    
    

  </tr>

	
  <?php     } ?>
  </tbody>
</table>

                    </div>                                    
                </div>                
            </section>
            </div>
            
            <?php include_once '../footer.html'; ?>
         



