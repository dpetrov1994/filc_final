<?php
$token='5502886775:AAHqCgGBD2jCYzfs9dKzFLiRevAPiaLaHzY';
define("telegram_url","https://api.telegram.org/bot$token");

/*
{   "update_id":337062582,
    "message":{
        "message_id":7,
        "from":{
        "id":558475499,
        "is_bot":false,
        "first_name":"Denis",
        "username":"dpetrov053",
        "language_code":"en"
    },
    "chat":{
        "id":558475499,
        "first_name":"Denis",
        "username":"dpetrov053",
        "type":"private"
    },
    "date":1660515069,
    "text":"boas"
    }
}
 */

$comands=[
    'command'=>'ajuda',
    'description'=>'pedir ajuda'
];
print json_encode($comands);

$input= file_get_contents('php://input');
$update=json_decode($input);

//$message= $update->message;
//$chat_id = $message->chat->id;
//$text=$update->text;
//$date=$update->date;
//https://api.telegram.org/bot5502886775:AAHqCgGBD2jCYzfs9dKzFLiRevAPiaLaHzY/setMyCommands?commands=[{%22command%22:%22ajuda%22,%22description%22:%22pedir%20ajuda%22}]
//$response=file_get_contents(telegram_url."/sendMessage?chat_id=$chat_id&text=$text");
//print telegram_url."/sendMessage?chat_id=558475499&text=Olá";

$myfile = fopen("telegram.txt", "w") or die("Unable to open file!");
fwrite($myfile, $input."\r\n");
fclose($myfile);


//chamar esta funcao apra mudar o webhook
$webhook_url='https://suporte.petrovnetwork.com/conf/aurora/telegram.php';
function setWebhook($url) {
    $url=urlencode($url);
    $result=file_get_contents(telegram_url."/setWebhook?url=$url");
    print_r($result);
}