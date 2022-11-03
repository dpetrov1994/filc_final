<?php
include "../_funcoes.php";
include "../conf/dados_plataforma.php";

$db=ligarBD();

$layout=file_get_contents("../assets/layout/main.tpl");
$content=file_get_contents("../mod_inicio/tv.tpl");


$pageScript="

<style>
.navbar, .content-header, #sidebar, .pace, #modal-session .modal-dialog {
display: none; !important;
}

#page-content{
    padding-top: 0px !important; 
}

#main-container{
margin-left: 0px !important;
}

.linha-assistencia-clientes{
border:none;
}

</style>

<script src='../assets/layout/js/compCharts.js'></script>
<script src='../mod_inicio/tv.js'></script>
";
include ('../_autoData.php');

