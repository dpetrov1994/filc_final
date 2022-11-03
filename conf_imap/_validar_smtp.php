<?php


foreach ($_GET as $key=>$value){
    $_GET[$key]=trim($value);
}

$smtp_host = $_GET['servidor'];
$smtp_user =  $_GET['utilizador'];
$smtp_pass =  $_GET['password'];
$smtp_port =  $_GET['porta']; // or ssl or ''
$name =  $_GET['nome']; // or ssl or ''
$destino_teste =  $_GET['destino_teste']; // or ssl or ''

require '../assets/phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;//Tell PHPMailer to use SMTP
$mail->isSMTP();//Enable SMTP debugging// 0 = off (for production use)// 1 = client messages// 2 = client and server messages
$mail->SMTPDebug = 2;//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';//Set the hostname of the mail server
$mail->Host = $smtp_host;// use// $mail->Host = gethostbyname('smtp.gmail.com');// if your network does not support SMTP over IPv6//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = $smtp_port;//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'ssl';//Whether to use SMTP authentication
$mail->SMTPAuth = true;//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = $smtp_user;//Password to use for SMTP authentication
$mail->Password = $smtp_pass;//Set who the message is to be sent from
$mail->setFrom($smtp_user, utf8_decode($name));
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->addReplyTo($smtp_user, utf8_decode($name));//Set an alternative reply-to address//Set who the message is to be sent to
$mail->addAddress($destino_teste);//Set the subject line
$mail->Subject = 'Email de Teste da Plataforma ';//Read an HTML message body from an external file, convert referenced images to embedded,//convert HTML into a basic plain-text alternative body
$mail->msgHTML("<h1>Funciona!</h1>", dirname(__FILE__));//Replace the plain text body with one created manually
$mail->AltBody = 'Funciona';//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}