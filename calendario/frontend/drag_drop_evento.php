<?php
date_default_timezone_set("America/Bogota");
setlocale(LC_ALL, "es_ES");

require_once $_SERVER['DOCUMENT_ROOT'] . '/gestionadministrativa/config.php';
$idEvento     = $_POST['idEvento'];
$start        = $_REQUEST['start'];
$fecha_inicio = date('Y-m-d', strtotime($start));
$end          = $_REQUEST['end'];
$fecha_fin    = date('Y-m-d', strtotime($end));


$UpdateProd = ("UPDATE eventoscalendar
    SET
        fecha_inicio ='$fecha_inicio',
        fecha_fin ='$fecha_fin'

    WHERE id='" . $idEvento . "' ");
$result     = mysqli_query($con, $UpdateProd);
