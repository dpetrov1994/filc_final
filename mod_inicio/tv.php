<?php
include ('../_template.php');

if(in_array('5', $_SESSION['grupos'])){ // REDIRECIONAR OS TECNICOS PARA O DASHBOARD DELES
    header("location: dashboard.php");
    die;
}

$content=file_get_contents("tv.tpl");


$pageScript="

<style>
.pace {
display: none; !important;
}

</style>

<script src='../assets/layout/js/compCharts.js'></script>
<script src='../mod_inicio/tv.js'></script>
";
include ('../_autoData.php');