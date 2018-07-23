<?php
$host = $_SERVER["HTTP_HOST"];
$server = $_SERVER['SERVER_NAME'];
$url = explode('?', str_replace('COMPSTAT/', '', substr($_SERVER["REQUEST_URI"], 1)));
$countSlash = "";
$access = "";

if (isset($_SESSION['Modulos']) && $url[0] != 'inicio.php') {

    $mod = $_SESSION['Modulos'];

    for ($x = 0; $x < count($mod); $x++) {

        $mod[$x] = strtolower(trim($mod[$x]));
        $url[0] = strtolower(trim($url[0]));

        if ($mod[$x] == $url[0]) {
            $access = 'Ok';
        }
    }

    $numSlash = substr_count($url[0], '/');
    while ($numSlash > 0) {
        $countSlash .= "../";
        $numSlash--;
    }

    $countSlash .= 'Error_Acceso.html';
    if ($access != 'Ok') {
        ?>
        <script type="text/javascript">
        //                             window.location.href = "<?php echo $countSlash; ?>"
        </script>  
        <?php
    }
}
?>
<!--por_destacamento.php-->