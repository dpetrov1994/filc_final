<?php


require_once "../_funcoes.php";
require_once "../assets/simple_imap/Imap.php";

foreach ($_GET as $key=>$value){
    $_GET[$key]=trim($value);
}

$mailbox = $_GET['servidor'];
$username =  $_GET['utilizador'];
$password =  $_GET['password'];
$encryption =  $_GET['encryption']; // or ssl or ''

// open connection
$imap = new Imap($mailbox, $username, $password, $encryption);

// stop on error
if($imap->isConnected()===false)
    die($imap->getError());

// get all folders as array of strings
$folders = $imap->getFolders();
print "<b>Pastas</b><br>";
foreach($folders as $folder)
    echo $folder."<br>";