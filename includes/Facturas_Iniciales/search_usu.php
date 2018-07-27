<?php
include_once '../../conexiones/sqlsrv.php';
$conn = connection_object();

$id_usuario =$_REQUEST['ID_USUARIO'];


$query="select * from [Facturacion].dbo.v_usuario_padron where id_usuario='$id_usuario'";
$execute=sqlsrv_query($conn,$query);

while($row=sqlsrv_fetch_array($execute)){
    $r_social=$row['R_SOCIAL'];
    echo "<div class='col-lg-12 col-xs-12  text-center'>
            <label>RAZÓN SOCIAL:  <h4 style='color: #1B4C7C; font-weight: 600;'>$r_social</h4></label>
          </div>";
}
