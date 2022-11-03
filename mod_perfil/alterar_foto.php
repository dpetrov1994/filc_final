<?php
session_start();
$_GET['id']=$_SESSION['id_utilizador'];
include ("../utilizadores/alterar_foto.php");