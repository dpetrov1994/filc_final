<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
set_time_limit(0);
$db=ligarBD();

if(!isset($_GET["testing"])){
    //die();
}

require_once "../assets/simple_imap/Imap.php";
require_once "../assets/minibots/minibots.class.php";

$mb = new Minibots();

$sql_cfg="select * from _conf_imap where ativo=1";
$result_cfg=runQ($sql_cfg,$db,"SELECT INSERTED");
while ($row_cfg = $result_cfg->fetch_assoc()) {

    foreach ($row_cfg as $key=>$value){
        if($key!='nome_conf' && $key!="descricao") {
            $row_cfg[$key] = decryptData($value);
        }
    }

    $mailbox = $row_cfg['servidor'];
    $username = $row_cfg['utilizador'];
    $password = $row_cfg['password'];
    $encryption = $row_cfg['encryption']; // or ssl or ''


// open connection
    $imap = new Imap($mailbox, $username, $password, $encryption);

// stop on error
    if ($imap->isConnected() === false)
        die($imap->getError());

    $pasta_dos_sincronizados = "INBOX.Sincronizados"; //leva sempre o INBOX atrás
    $folders = $imap->getFolders(); // returns array of strings
    $existe = 0;
    foreach ($folders as $folder) {
        if ($folder == $pasta_dos_sincronizados) {
            $existe = 1;
        }
    }
    if ($existe == 0) {
        $imap->addFolder($pasta_dos_sincronizados, true);
    }

    $pastas = [
        'INBOX',
        //'INBOX.Sent',
    ];

    foreach ($pastas as $pasta) {
        $imap->selectFolder($pasta);
        $overallMessages = $imap->countUnreadMessages();
        if ($overallMessages > 0) {
            $emails = $imap->getUnreadMessages();
            foreach ($emails as $email) {

                $cols = [];

                $cols['spam'] = 0;
                $sql0="select * from imap_spam where nome_spam='".$email['from_email_address']."' and ativo=1";
                $result0 = runQ($sql0, $db, "ver se o email do remetinente esta no spam");
                if($result0->num_rows==1){
                    $cols['spam'] = 1;
                }

                $email['subject']=trim($email['subject']);
                if($email['subject']==""){
                    $email['subject']="Sem assunto";
                }

                $cols['de_nome'] = $email['from_name'];
                $cols['para_nome'] = $email['to_name'];
                $cols['de_email'] = $email['from_email_address'];
                $cols['para_email'] = $email['to_email_address'];
                $cols['nome_imap'] = $email['subject'];
                $cols['uid'] = $email['uid'];
                $cols['message_id'] = $email['message_id'];
                $cols['in_reply_to'] = $email['in_reply_to'];
                $cols['references_to'] = $email['references'];
                $cols['raw'] = json_encode($email);
                $cols['id_criou'] = 0;
                $cols['data_email'] = date("Y-m-d H:i:s", strtotime($email['date']));
                $cols['created_at'] = current_timestamp;
                $cols['descricao'] = $email['body'];
                $cols['caixa_despesas'] = $row_cfg['caixa_despesas'];

                $cols['cc']=[];
                if(isset($email['cc']) && is_array($email['cc'])){
                    foreach ($email['cc'] as $cc){
                        $emails = $mb->findEmails($cc);
                        foreach ($emails as $e){
                            if(!in_array($e,$cols['cc'])){
                                $cols['cc'][]=$e;
                            }
                        }
                    }
                }
                $cols['cc']=json_encode($cols['cc']);

                $cols['com_anexos'] = 0;
                if (isset($email['attachments']) && is_array($email['attachments'])) {
                    foreach ($email['attachments'] as $att) {
                        if (isset($att['reference']) && $att['reference'] != "") {
                            $cols['com_anexos'] = 1;
                            break;
                        }
                    }
                }

                $colunas = "";
                $valores = "";
                foreach ($cols as $coluna => $valor) {
                    if (!is_array($valor)) {
                        $valor = $db->escape_string($valor);
                        $colunas .= "$coluna,";
                        $valores .= "'$valor',";
                    }

                }
                $colunas = substr($colunas, 0, -1) . "";
                $valores = substr($valores, 0, -1) . "";

                $sql = "insert into imap ($colunas) values ($valores)";
                $result = runQ($sql, $db, "inserir email na BD<br>$colunas");
                $insert_id = $db->insert_id;
                $destination_dir = "../_contents/imap/$insert_id";
                criar_dir($destination_dir);
                $imap->saveAttachments($email, $destination_dir);

                $imap->setUnseenMessage($email['uid'], true);

            }
        }
    }
}
$sql2="update _conf_assists set data_sync_imap='".current_timestamp."' where id_conf=1";
$result2=runQ($sql2,$db,"atualizar a data da última sincronizacao com IMAP");


$db->close();

