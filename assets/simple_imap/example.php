<?PHP

require_once "Imap.php";

$mailbox = 'localhost';
$username = 'suporte@srv01.pt';
$password = '(73czCcNq)fn';
$encryption = 'ssl'; // or ssl or ''

// open connection
$imap = new Imap($mailbox, $username, $password, $encryption);

// stop on error
if($imap->isConnected()===false)
    die($imap->getError());

// get all folders as array of strings
$folders = $imap->getFolders();
foreach($folders as $folder)
    echo $folder;

// select folder Inbox
$imap->selectFolder('INBOX');

// count messages in current folder
$overallMessages = $imap->countMessages();
print "$overallMessages overallMessages<br>";
$unreadMessages = $imap->countUnreadMessages();
print "$unreadMessages unreadMessages<br> ";
// fetch all messages in the current folder
$emails = $imap->getMessages();
foreach ($emails as $email){
    //print $email['message_id']."<br>";
}

// add new folder for archive
//$imap->addFolder('archive');

// move the first email to archive
//$imap->moveMessage($emails[0]['uid'], 'archive');

// delete second message
//$imap->deleteMessage($emails[1]['uid']);


/** como responder a emails */

/*

https://stackoverflow.com/questions/32370791/replying-to-an-email-with-phpmailer

It's quite reasonable to have every message in a thread using a different subject line, so threading is only dependent on the subject line as a last-resort fallback if you're doing everything else wrong. It's actually quite annoying when clients do this as you end up with unrelated messages that happen to have the same subject grouped together.

Threading and replies are implemented using the References and In-Reply-To headers as defined in RFC2822. Read this guide for a thorough description of how to do threading reliably.

The short version is this, for the first reply to a message:

$mail->addCustomHeader('In-Reply-To', $message_id);
$mail->addCustomHeader('References', $message_id);

It gets more complex if the original message is just the latest in a long thread, but it uses the same headers - read the spec and the guide for more info.

Make sure your message ID is correctly formatted - it should be surrounded by <>, like <d7751ea969c01cda464ebf2de2fe64e6@example.org>.

You don't need to do anything to the subject line - though it's common to prepend Re: , it's not necessary for the linkage to work, and it also varies across languages, so it's not something you can rely on.

Exemplos:

References: <CAC=ce=VW8yphUzO1BXm-UUnTeJSzPT=bUs2aeaG4LS7F6K2-GA@mail.gmail.com> <2b5afea1e9d5849399b627e48401b60a@support.srv01.pt>
In-Reply-To: <2b5afea1e9d5849399b627e48401b60a@support.srv01.pt>


/*

/** como responder a emails */


if(isset($_GET['teste'])){
    require '../phpmailer/PHPMailerAutoload.php';
    include '../../conf/smtp.php';//Create a new PHPMailer instance
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
    $mail->addCustomHeader('In-Reply-To', '<CAC=ce=VW8yphUzO1BXm-UUnTeJSzPT=bUs2aeaG4LS7F6K2-GA@mail.gmail.com>');
    $mail->addCustomHeader('References', '<CAC=ce=VW8yphUzO1BXm-UUnTeJSzPT=bUs2aeaG4LS7F6K2-GA@mail.gmail.com>');
    $mail->setFrom($smtp_user, utf8_decode($smtp_userNome));
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->addReplyTo($smtp_reply, utf8_decode($smtp_replyNome));//Set an alternative reply-to address//Set who the message is to be sent to
    $mail->addAddress("denis@petrovnetwork.com");//Set the subject line
    $mail->Subject = 'teste';//Read an HTML message body from an external file, convert referenced images to embedded,//convert HTML into a basic plain-text alternative body
    $mail->msgHTML("<h1>resposta teste.</h1>", dirname(__FILE__));//Replace the plain text body with one created manually
    $mail->AltBody = 'This is a plain-text message body';//send the message, check for errors

    $result = $mail->Send();
    if ($result) {
        echo "Message sent!";
    }else{
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}