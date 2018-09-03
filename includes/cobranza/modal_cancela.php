<?php 
$pagos = $_REQUEST['pagos'];
$ayo = $_REQUEST['ayo'];
$reg = $_REQUEST['reg'];
$usu = $_REQUEST['usu'];
$html = "";
$html ="
<div class='col-md-12'>
<br>
<center><button name='btn'  value='cancelar' onclick='cancela($pagos,$ayo,$reg,\"$usu\")' type='button' class='btn btn-success' >SI, CANCELAR</button>
<button type='button' class='btn btn-danger' data-dismiss='modal'>CERRAR</button></center>
</div>

";			
echo $html;
?>