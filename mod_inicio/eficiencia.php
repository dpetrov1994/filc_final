<?php
include ('../_template.php');

if(in_array('5', $_SESSION['grupos']) || $_SESSION['comercial']==1){ // REDIRECIONAR OS TECNICOS PARA O DASHBOARD DELES
    header("location: dashboard.php");
    die;
}

$content=file_get_contents("eficiencia.tpl");



$pageScript="<script src='eficiencia.js'></script>";
include ('../_autoData.php');