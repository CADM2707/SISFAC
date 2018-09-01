<?php 
$pagos = $_REQUEST['pagos'];
$ayo = $_REQUEST['ayo'];
$ayo_fac = $_REQUEST['ayo_fac'];
$id_fac = $_REQUEST['id_fac'];
$monto = $_REQUEST['monto'];
$reg = $_REQUEST['reg'];
$usu = $_REQUEST['usu'];
$html = "";
$html ="
<div class='col-md-12'>
<br>
<center><button name='btn'  value='cancelar' onclick='aplica($pagos,$ayo,$ayo_fac,$id_fac,$monto,$reg,\"$usu\")' type='button' class='btn btn-success' >SI, APLICAR</button>
<button type='button' class='btn btn-danger' data-dismiss='modal'>CERRAR</button></center>
</div>

";			
echo $html;
?>