<?php

isset($_REQUEST['ID_REGISTRO']) ? $id_registro = $_REQUEST['ID_REGISTRO'] : $id_registro = "";


if($id_registro){
    $deletePago="delete ";
}