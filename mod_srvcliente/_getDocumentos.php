<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");


$galeria=get_galeria('docs',$_GET['nif']);

print $galeria;