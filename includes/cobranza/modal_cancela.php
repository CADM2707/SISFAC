<?php 
$pagos = $_REQUEST['pagos'];
$ayo = $_REQUEST['ayo'];
$reg = $_REQUEST['reg'];
$usu = $_REQUEST['usu'];
$html = "";
$html ="
<div class='col-md-12'>
	<div class='col-md-2'></div>
	<div class='col-md-8'><textarea id='obs_cancela' style = 'text-transform: uppercase'class='form-control' placeholder='MOTIVO DE LA CANCELACIÓN'></textarea></div>
	<div class='col-md-2'></div>
</div>

<div class='col-md-12'>
<br>
<center><button name='btn'  value='cancelar' onclick='cancela($pagos,$ayo,$reg,\"$usu\")' type='button' class='btn btn-success' >SI, CANCELAR</button>
<button type='button' class='btn btn-danger' data-dismiss='modal'>CERRAR</button></center>
<br>
</div>

";			
echo $html;
?>