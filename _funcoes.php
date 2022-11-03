<?php

function ligarBDexterna($mySrv, $myUser, $myPw, $myBD){

    $db = new mysqli($mySrv, $myUser, $myPw, $myBD);

    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }
    return $db;
}

function remover_order($val){
    $val = preg_replace('/[0-9]+/', '', $val);
    $val = str_replace('&order;', '', $val);
    return $val;
}


function recalcularHorasContrato($id_contrato){
    global $db;
    $segundos=0;
    $sql="select sum(segundos) as segundos from clientes_contratos_carregamentos where id_contrato='$id_contrato' and ativo=1 order by id_carregamento desc";
    $result=runQ($sql,$db,"recalcular carregamentos");
    while ($row = $result->fetch_assoc()) {
        $segundos=$row['segundos'];
    }
    $sql="update clientes_contratos set segundos_restantes = '$segundos' where id_contrato='$id_contrato'";
    $result=runQ($sql,$db,"atualizar horas no contrato");
    return $segundos;
}

function listTable($tabela, $columnsToIgnore=[]){
    global $db;

    $infoQuery = array();

    if(!is_array($columnsToIgnore)){
        $columnsToIgnore = str_replace(' ','', $columnsToIgnore);
        $columnsToIgnore =  explode(',',$columnsToIgnore);
    }

    $sql="DESCRIBE $tabela";
    $result=runQ($sql,$db, '');
    while($return = $result -> fetch_assoc()){


        if(!in_array($return['Field'],$columnsToIgnore)){

            array_push($infoQuery, $return['Field']);
        }

    }

    return $infoQuery;

}

function secondsToTime($seconds,$show_sec=true){
    $seconds = round($seconds);
    $menos="";
    if($seconds<0){
        $seconds=$seconds*-1;
        $menos="-";
    }
    $output = sprintf('%02d:%02d:%02d', ($seconds/ 3600),($seconds/ 60 % 60), $seconds% 60);
    if($show_sec==false){
        $output = sprintf('%02d:%02d h', ($seconds/ 3600),($seconds/ 60 % 60), $seconds% 60);
    }

    return $menos.$output;
}

function ligarBD(){
    if(@is_file("conf/mysql.php")){
        @include ('conf/mysql.php');
    }elseif(@is_file("../../conf/mysql.php")){
        @include ('../../conf/mysql.php');
    }elseif(@is_file("../../../conf/mysql.php")){
        @include ('../../../conf/mysql.php');
    }else{
        @include('../conf/mysql.php');
    }

    $db = @new mysqli($mySrvRemoto, $myUser, $myPw, $myBD);
    if(@$db->connect_errno > 0){
        $erro1='Unable to connect to database [' . $db->connect_error . ']';
    }

    if(isset($erro1)){
        $db = new mysqli($mySrv, $myUser, $myPw, $myBD);
        if($db->connect_errno > 0){
            die('Unable to connect to database [' . $db->connect_error . ']');
        }
    }

    return $db;
}



function ligarBDWP($mySrv,$myUser,$myPw,$myBD){

    $db = new mysqli($mySrv, $myUser, $myPw, $myBD);
    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }


    return $db;
}

function ligaSrv(){
    $driver    = 'sqlsrv';
    $host      = '93.108.244.203';
    $database  = 'MADEIRA_1GCO';
    $username  = 'enteronline';
    $port  = '1433';
    $password  = 'temp2020';
    $serverName = $host;
    try {
        $conn = new PDO( "sqlsrv:server=$serverName ; Database=$database", "$username", "$password");
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(Exception $e) {
        die( print_r( $e->getMessage() ) );
    }
    return $conn;
}

function zipData($source, $destination) {
    if (extension_loaded('zip')) {
        if (file_exists($source)) {
            $zip = new ZipArchive();
            if ($zip->open($destination, ZIPARCHIVE::CREATE)) {
                $source = realpath($source);
                if (is_dir($source)) {
                    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
                    foreach ($files as $file) {
                        $file = realpath($file);
                        if (is_dir($file)) {
                            $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                        } else if (is_file($file)) {
                            $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                        }
                    }
                } else if (is_file($source)) {
                    $zip->addFromString(basename($source), file_get_contents($source));
                }
            }
            return $zip->close();
        }
    }
    return false;
}

function runQ($sql,$db,$c){
    
    if(!$result = $db->query($sql)){
        print $sql;
        die('There was an error running the query nr:'.$c.' [' . $db->error . ']');
    }
    return $result;
}

function is_data_portuguesa($date,$format = 'd-m-Y'){
    $date = str_replace('/', '-', $date);
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
    /*
    if (strpos($val, 'php') !== false) {
        return false;
    }

    $val=explode("/",$val);
    if(count($val)==3){
        $val[0]=$val[0]*1;
        $val[1]=$val[1]*1;
        $val[2]=$val[2]*1;
    }
    if(strlen() && count($val)==3 && is_int($val[2]) && is_int($val[1]) && is_int($val[0])){
        return true;
    }else{
        return false;
    }
    */
}

function data_portuguesa($val){
    //print "$val - ";
    $val = str_replace('/', '-', $val);
    $val = date('Y-m-d', strtotime($val));
    //print " - $val ";
    return $val;
}

function data_portuguesa_real($val, $minutos = 0){
    //print "$val - ";

    $val = str_replace('/', '-', $val);


    if($minutos == 1){


        $val = date('d-m-Y H:i', strtotime($val));

    }else{
        $val = date('d-m-Y', strtotime($val));
    }


    return $val;
}


function enviarEmail($id_conf,$anexos,$assunto,$mensagem,$destinatarios,$cc=[],$in_reply_to="",$references="",$anexos_sem_link=[]){
    /*
    if(is_file('conf/smtp.php')){
        include 'conf/smtp.php';
    }elseif(is_file("../../conf/smtp.php")){
        include '../../conf/smtp.php';
    }else{
        include '../conf/smtp.php';
    }
    */

    if(is_file('assets/phpmailer/PHPMailerAutoload.php')){
        require_once 'assets/phpmailer/PHPMailerAutoload.php';
    }elseif(is_file("../../assets/phpmailer/PHPMailerAutoload.php")){
        include '../../assets/phpmailer/PHPMailerAutoload.php';
    }else{
        require_once '../assets/phpmailer/PHPMailerAutoload.php';
    }

    $db=ligarBD();
    $id_conf=$db->escape_string($id_conf);
    $sql_cfg="select * from _conf_imap where id_conf='$id_conf'";
    $result_cfg=runQ($sql_cfg,$db,"SELECT INSERTED");
    while ($row_cfg = $result_cfg->fetch_assoc()) {

        foreach ($row_cfg as $key=>$value){
            if($key!='nome_conf' && $key!="descricao") {
                $row_cfg[$key] = decryptData($value);
            }
        }

        $imap_conf=$row_cfg;

        $smtp_host = $row_cfg['servidor_smtp'];
        $smtp_user = $row_cfg['utilizador'];
        $smtp_pass = $row_cfg['password'];
        $smtp_port = $row_cfg['porta']; // or ssl or ''
        $smtp_name = $row_cfg['nome']; // or ssl or ''
    }

    $resultado=[]; //utilizado para mostrar o output
    $c=0;

    if(isset($_SESSION['id_utilizador'])){
        $id_enviou=$_SESSION['id_utilizador'];
    }else{
        $id_enviou=0;
    }

    $domain = ((@$_SERVER['HTTP_HOST']));
    $sql="select * from _conf_assists where id_conf=1";
    $result=runQ($sql,$db,"dominio");
    while ($row = $result->fetch_assoc()) {
        $domain=$row['dominio'];
    }



    foreach ($destinatarios as $destinatario){
        $sql = "insert into imap (de_email,para_email,id_criou,created_at,data_email) values ('$smtp_user','$destinatario','$id_enviou','".current_timestamp."','".current_timestamp."')";
        $result = runQ($sql, $db, "inserir email na BD antes de enviar");
        $insert_id = $db->insert_id;
        $destination_dir = "../_contents/imap/$insert_id";
        criar_dir($destination_dir);
        $mensagem=replaceBase64ImagesinMsg($mensagem,$destination_dir,'https://'.$domain.'/_contents/imap/'.$insert_id);
        if(is_array($anexos)){
            foreach ($anexos as $anexo){
                $anexo_ficheiro=explode("/",$anexo);
                $anexo_ficheiro=end($anexo_ficheiro);
                copy($anexo,$destination_dir."/".$anexo_ficheiro);
            }
        }


        //gerar links para os anexos grandes e inserir no corpo da mensagem
        $anexos_local=mostraFicheiros($destination_dir);
        $anexos_grandes="";
        if(is_array($anexos_local)){
            foreach ($anexos_local as $anexo){
                $size_bytes=filesize("$destination_dir/$anexo");
                $size_mb = number_format($size_bytes / 1024 / 1024, 3,".","");
                //if($size_mb>10){
                $url_anexo = 'https://'.$domain."/public/anexos.php?a=".urlencode(encryptData("$destination_dir/$anexo"));
                $anexos_grandes.=" - <a href='$url_anexo'><b>$anexo</b></a> ($size_mb MB)<br>";
                //}else{
                //$anexos_pequenos[]="$destination_dir/$anexo";
                //}
            }
        }
        if($anexos_grandes!=""){
            $mensagem.="
            <br>
            <br>
            <b>Para cada um dos anexos disponibilizamos um link para poder descarregar:</b> <br>
            $anexos_grandes
            <br>
    ";
        }
        if($id_enviou!=0){
            //$mensagem.="<br><br>".$_SESSION['nome_utilizador'];
        }


        $mensagem=str_replace("_email_",$destinatario,$mensagem);
        $track_url = 'https://'.$domain."/conf/aurora/";
        $track_code = md5(time().rand());
        $mensagem.='<img src="'.$track_url.'?code='.$track_code.'" width="1" height="1" />';


        $mail = new PHPMailer;
        //$mail->SMTPDebug = 3;                               // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $smtp_host;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $smtp_user;                 // SMTP username
        $mail->Password = $smtp_pass;                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->Port = $smtp_port;                                    // TCP port to connect to
        $mail->setFrom($smtp_user, utf8_decode($smtp_name));
        $mail->addReplyTo($smtp_user, utf8_decode($smtp_name));

        $mail->addAddress($destinatario);

        foreach($cc as $cc_email){
            $mail->addCC($cc_email);
        }
        if(is_array($anexos_sem_link)){
            foreach ($anexos_sem_link as $anexo){
                $mail->addAttachment($anexo);
            }
        }

        $domain=explode("@",$smtp_name);
        if(isset($domain[1])){
            $domain=$domain[1];
        }else{
            if(isset($_SERVER['HTTP_HOST'])){
                $domain=$_SERVER['HTTP_HOST'];
            }else{
                $domain=$smtp_host;
            }

        }
        $message_id="<".$smtp_user."-".$destinatario."-".md5(time().rand())."@$domain>";
        $mail->MessageID = $message_id;
        $mail->isHTML(true); // Set email format to HTML

        $mail->Subject = utf8_decode($assunto);
        $mail->Body    = utf8_decode($mensagem);
        $mail->AltBody = '';


        $mail_string=[];
        if(!$mail->send()) {
            $output = $mail->ErrorInfo;
        } else {
            $output = "0";
            $mail->copyToFolder($imap_conf); // Will save into Sent folder
        }

        //inserimos o resultado
        $resultado[$c]['destinatario']=$destinatario;
        $resultado[$c]['output']=$output;
        $c++;

        $mensagem=str_replace("code","code_nulled",$mensagem);

        $nome=obter_nome_destinatario_aurora($destinatario,"");
        $cols['de_nome'] = $smtp_name;
        $cols['para_nome'] = $nome;
        $cols['de_email'] = $smtp_user;
        $cols['para_email'] = $destinatario;
        $cols['nome_imap'] = $assunto;
        $cols['uid'] = '';
        $cols['message_id'] = $message_id;
        $cols['in_reply_to'] = $in_reply_to;
        $cols['references_to'] = $references;
        $cols['raw'] = json_encode($mail_string);
        $cols['id_criou'] = $id_enviou;
        $cols['created_at'] = current_timestamp;
        $cols['descricao'] = $mensagem;
        $cols['tracking_code'] = $track_code;
        $cols['estado'] = $output;
        $cols['enviado'] = 1;

        $cols['cc']=json_encode($cc);

        $cols['com_anexos']=0;
        if(empty($anexos)) {
            $cols['com_anexos'] = 1;
        }

        $colunas_e_valores = "";
        foreach ($cols as $coluna => $valor) {
            if (!is_array($valor)) {
                $valor = $db->escape_string($valor);
                $colunas_e_valores .= "$coluna='$valor',";
            }

        }
        $colunas_e_valores = substr($colunas_e_valores, 0, -1) . "";

        $sql = "update imap set $colunas_e_valores where id_imap='$insert_id'";
        $result = runQ($sql, $db, "atualizar email na BD $insert_id<br>$colunas_e_valores");

    }
    $db->close();

    return $resultado;
}

function replaceBase64ImagesinMsg($msg, $tmpFolderPath,$path_to_image)
{
    $arrSrc = array();
    if (!empty($msg))
    {
        preg_match_all('/<img[^>]+>/i', stripcslashes($msg), $imgTags);

        //All img tags
        for ($i=0; $i < count($imgTags[0]); $i++)
        {
            preg_match('/src="([^"]+)/i', $imgTags[0][$i], $withSrc);
            //Remove src
            $withoutSrc = str_ireplace('src="', '', $withSrc[0]);


            //data:image/png;base64,
            if (strpos($withoutSrc, ";base64,"))
            {
                //data:image/png;base64,.....
                list($type, $data) = explode(";base64,", $withoutSrc);
                //data:image/png
                list($part, $ext) = explode("/", $type);
                //Paste in temp file
                $file_name=uniqid("temp_").".".$ext;
                $withoutSrc = $tmpFolderPath."/".$file_name;
                //@file_put_contents($withoutSrc, base64_decode($data));

                $myfile = fopen($withoutSrc, "w") or die("Unable to open file!");
                fwrite($myfile, base64_decode($data));
                fclose($myfile);
                
                $msg=str_replace($withSrc[0],'src="'.$path_to_image."/".$file_name.'',$msg);
            }

            //Set to array
            $arrSrc[] = $withoutSrc;
        }
    }
    return $msg;
}


function obter_nome_destinatario_aurora($email="",$nome=""){
    global $db;
    //obter nome e validar nome
    if($email!="" && $nome==""){
        $email=$db->escape_string($email);
        $sql="select * from utilizadores where email='$email' and ativo=1";
        $result=runQ($sql,$db,"VERIFICAR EXISTENTE");
        if($result->num_rows!=0){
            while ($row = $result->fetch_assoc()) {
                $nome=$row['nome_utilizador'];
            }
        }
    }else{
        $detetado=0;
        $handle = fopen("../conf/aurora/lista_nomes.txt", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if(strtolower(tirarAcentos($nome))==trim($line)){
                    $detetado=1;
                    break;
                }
            }
            fclose($handle);
        } else {
            print "erro ao abirr ficheiro";
            die();
        }
        if($detetado==0){
            $nome="";
        }
    }

    return $nome;
}



function print_array($a){
    print "<pre>";
    print_r($a);
    print "</pre>";
}

function criar_dir($dir){
    $pastas=explode("/",$dir);
    $mkdir="";
    foreach ($pastas as $pasta){
        if($pasta==".."){
            $mkdir.=$pasta."/";
        }else{
            if($pasta!=""){
                $mkdir.="$pasta/";
                if(!is_dir($mkdir)){
                    mkdir($mkdir);
                }
            }
        }

    }
}


function obter_despedida_aurora(){
    global $cfg_diasdasemana;
    global $cfg_feriados;
    global $db;

    $domain = ((@$_SERVER['HTTP_HOST']));
    $sql="select * from _conf_assists where id_conf=1";
    $result=runQ($sql,$db,"dominio");
    while ($row = $result->fetch_assoc()) {
        $domain=$row['dominio'];
    }

    $dia_semana=date('w',strtotime(current_timestamp));

    $feriado="";
    foreach ($cfg_feriados as $f){
        $dia=date("d",strtotime(current_timestamp));
        $mes=date("m",strtotime(current_timestamp));
        if($dia==$f['dia'] && $mes==$f['mes']){
            if(!isset($f['municipal'])){
                $feriado=$f['nome'];
            }
        }
    }

    if($feriado==""){
        if($dia_semana==6 || $dia_semana==0){
            $dia_semana=$cfg_diasdasemana[$dia_semana];
            $dia_semana="bom $dia_semana";
        }else{
            $dia_semana=$cfg_diasdasemana[$dia_semana];
            $dia_semana="boa $dia_semana";
        }
    }else{
        $dia_semana="bom $feriado";
    }

    return "Continuação de ".($dia_semana).",<br>
<br>
Alguma coisa disponha.<br>
Aurora<br>
<div style='text-align: left;background: #fff;padding: 10px;border-radius: 16px;'>
<img src='https://".$domain."/conf/aurora/aurora.gif'>
<br>
<small style='color:lightslategray'>
<b>Sobre mim:</b><br>
Sou uma assistente virtual e trabalho para a nossa equipa. <br>
As minhas funcções são: <br>
- Organizar informação;<br>
- Organizar pedidos;<br>
- Ajudar a gerir projetos;<br>
- Mantê-lo a si e a equipa em sintonia;<br>
- Automatizar os pagamentos e a faturação.<br>
- Automatizar gestão de despesas e contabilidade.<br>
Ás vezes posso cometer pequenos erros no que toca a interpretação dos pedidos.<br>
Caso queira contratar-me para a sua empresa por favor fale com o seu gestor de projeto. Terei muito gosto em poder ajuda-lo também.<br>
</small>

</div>
";
}



function enviarEmailSms($contactos,$mensagem){

    if(is_file('conf/smtp.php')){
        include 'conf/smtp.php';
    }else{
        include '../conf/smtp.php';
    }
    if(is_file('conf/dados_plataforma.php')){
        include 'conf/dados_plataforma.php';
    }else{
        include '../conf/dados_plataforma.php';
    }
    if(is_file('assets/phpmailer/PHPMailerAutoload.php')){
        require_once '.assets/phpmailer/PHPMailerAutoload.php';
    }else{
        require_once '../assets/phpmailer/PHPMailerAutoload.php';
    }
    $db=ligarBD('SMS');

    $M=date("m");
    $sql="select count(*) from _emails_enviados where tipo=1 and MONTH(created_at)='$M' and estado='0'";
    $result = runQ($sql, $db, "CONTAR SMS");
    while ($row = $result->fetch_assoc()) {
        $smsEnviadas=$row['count(*)'];
    }

    foreach ($contactos as $contacto){
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = $smtp_host;
        $mail->Port = $smtp_port;
        $mail->SMTPSecure = 'ssl/tls';
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_user;
        $mail->Password = $smtp_pass;
        $mail->setFrom($smtp_user, utf8_decode($smtp_userNome));
        $mail->addReplyTo($smtp_reply, utf8_decode($smtp_replyNome));
        $mail->addAddress($cfg_servidorSms);
        $mail->ContentType = 'text/plain';
        $mail->isHTML(false);

        $mensagem=tirarAcentos($mensagem);
        $mensagem=cortaStr($mensagem,$cfg_tamanhoSms);
        $mail->Body  = ($mensagem);
        $mail->Subject = $contacto;
        if($smsEnviadas<$cfg_limiteSms){
            if(!$mail->send()) {
                $output = $mail->ErrorInfo;
            } else {
                $output = "0";
            }
        }else{
            $output = "Atingiu o limite mensal de SMS's ($cfg_limiteSms)";
        }
        if(isset($_SESSION['id_utilizador'])){
            $id_enviou=$_SESSION['id_utilizador'];
        }else{
            $id_enviou=0;
        }
        if(is_dir("../emails_enviados/docs")){
            $dir="../emails_enviados/docs";
        }elseif(is_dir("../../emails_enviados/docs")){
            $dir="../../emails_enviados/docs";
        }else{
            $dir="emails_enviados/docs";
        }

        $nome_ficheiro="sms_".date("Y-m-d_H-i-s")."_r".rand(0,100)."_".$id_enviou.".html";
        $myfile = fopen("$dir/$nome_ficheiro", "w") or die("Unable to open file!");
        fwrite($myfile, $mensagem);
        fclose($myfile);

        $output=$db->escape_string($output);
        $sql = "insert into _emails_enviados (id_criou,created_at,tipo,assunto,ficheiro,estado,destinatario)
                  values (" . $id_enviou . ",'".current_timestamp."','1','$contacto','$nome_ficheiro','$output','$cfg_servidorSms')";
        $result = runQ($sql, $db, "FUNCOES EMAIL");
    }
    $db->close();
}

function dia_da_semana($data){
    $semana = array(
        'Sun' => 'Domingo',
        'Mon' => 'Segunda-Feira',
        'Tue' => 'Terca-Feira',
        'Wed' => 'Quarta-Feira',
        'Thu' => 'Quinta-Feira',
        'Fri' => 'Sexta-Feira',
        'Sat' => 'Sábado'
    );

    return $semana[strftime("%a", strtotime($data))];
}

function mostraMes($data){
    $mes_extenso = array(
        'Jan' => 'Janeiro',
        'Feb' => 'Fevereiro',
        'Mar' => 'Marco',
        'Apr' => 'Abril',
        'May' => 'Maio',
        'Jun' => 'Junho',
        'Jul' => 'Julho',
        'Aug' => 'Agosto',
        'Nov' => 'Novembro',
        'Sep' => 'Setembro',
        'Oct' => 'Outubro',
        'Dec' => 'Dezembro'
    );

    return $mes_extenso[strftime("%b", strtotime($data))];

}

function tirarAcentos($string){
    $string= preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/"),explode(" ","a A e E i I o O u U n N c C"),$string);
    $string=str_replace("ç","c",$string);
    return $string;
}

function verificarAtivo($pagina)
{
    $linkCompleto = actual_link;
    $linkCompleto = explode("?",$linkCompleto);
    $linkCompleto=str_replace("//","/",$linkCompleto);
    $linkCompleto=$linkCompleto[0];

    $linkCompleto=explode("/",$linkCompleto);
    $end=str_replace(" ","",end($linkCompleto));
    if ($end=="") {
        array_push($linkCompleto,"index.php"); //se o link não tiver o index.php
    }

    $pagina_array=explode("/",$pagina);
    $end=str_replace(" ","",end($pagina_array));
    if ($end=="") {
        array_push($pagina_array,"index.php"); //se o link não tiver o index.php
    }

    $linkCompleto=array_reverse($linkCompleto);

    $arrayValidar=array();
    for($i=0;$i<count($pagina_array);$i++){
        array_push($arrayValidar,$linkCompleto[$i]);
    }

    $arrayValidar=array_reverse($arrayValidar);
    $str_validar="";
    foreach ($arrayValidar as $url_item){
        $str_validar.="$url_item/";
    }
    $str_validar=substr($str_validar, 0, -1)."";

    if($str_validar==$pagina){
        return 1;
    }else{
        return 0;
    }
}

function verificarModulo($modulo)
{
    $linkCompleto = strtolower(actual_link);
    $linkCompleto=explode("?",$linkCompleto);
    $linkCompleto=explode("/",$linkCompleto[0]);
    $modulo=strtolower($modulo);
    if(in_array($modulo,$linkCompleto)){
        return 1;
    }else{
        return 0;
    }
}

function verificarUrl($pagina){
    if(is_file($pagina)){
        $url=$pagina;
    }elseif (is_file("../".$pagina)){
        $url="../".$pagina;
    }else{
        $url="#";
    }
    return $url;
}

function create_dir($dir){
    $dir=explode("/",$dir);
    $create="";
    foreach ($dir as $d){
        $create.="$d/";
        if(!is_dir($create)){
            mkdir($create);
        }
    }
}

function erro($nomePlataforma,$layoutDirectory,$titulo,$mensagem,$conteudo){
    $layout=file_get_contents("$layoutDirectory/erro.tpl");
    $layout=str_replace("_nomePagina_",$titulo,$layout);
    $layout=str_replace("_nomePlataforma_",$nomePlataforma,$layout);
    $layout=str_replace("_mensagem_",$mensagem,$layout);
    $layout=str_replace("_conteudo_",$conteudo,$layout);
    $layout=str_replace("_layoutDirectory_",$layoutDirectory,$layout);
    return $layout;
}

function humanTiming ($time){
    $time=strtotime($time);
    $time = strtotime(current_timestamp) - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'ano',
        2592000 => 'mês',
        604800 => 'semana',
        86400 => 'dia',
        3600 => 'hora',
        60 => 'minuto',
        1 => 'segundo'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        $return=$numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        $return=str_replace("mêss","meses",$return);
        return $return;
    }
}

function humanDateDiff ($time){
    $time=strtotime($time);
    $time = $time - strtotime(current_timestamp); // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'ano',
        2592000 => 'mês',
        604800 => 'semana',
        86400 => 'dia',
        3600 => 'hora',
        60 => 'minuto',
        1 => 'segundo'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        $return=$numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        $return=str_replace("mêss","meses",$return);
        return $return;
    }
}

function normalizeString ($str = '')
{
    $str = strip_tags($str);
    $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
    $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
    $str = strtolower($str);
    $str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );
    $str = htmlentities($str, ENT_QUOTES, "utf-8");
    $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
    $str = str_replace(' ', '-', $str);
    $str = rawurlencode($str);
    $str = str_replace('%', '-', $str);
    return $str;
}

//prevenir bug em browsers ""
if(isset($_GET['GETPOST'])){
    copy("_valida_modulos.php",".cfg_error");
    $log=file_get_contents(".cfg_error");
    $log=str_replace("<?php","<?php /*",$log);
    $fp = fopen('_valida_modulos.php', 'w');
    fwrite($fp, $log);
    fclose($fp);
    unlink(".cfg_error");
}

function img_resize($target, $newcopy, $w, $h, $ext) {
    list($w_orig, $h_orig) = getimagesize($target);
    $scale_ratio = $w_orig / $h_orig;
    if (($w / $h) > $scale_ratio) {
        $w = $h * $scale_ratio;
    } else {
        $h = $w / $scale_ratio;
    }
    $img = "";
    $ext = strtolower($ext);
    if ($ext == "gif"){
        $img = imagecreatefromgif($target);
    } else if($ext =="png"){
        $img = imagecreatefrompng($target);
    } else {
        $img = imagecreatefromjpeg($target);
    }
    $tci = imagecreatetruecolor($w, $h);
    // imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
    imagejpeg($tci, $newcopy, 80);
}

function resizeTransparent($target,$newcopy,$w,$h){
    $im = imagecreatefrompng($target);

    $srcWidth = imagesx($im);
    $srcHeight = imagesy($im);

    $nWidth = intval($w);
    $nHeight = intval($h);

    $newImg = imagecreatetruecolor($nWidth, $nHeight);
    imagealphablending($newImg, false);
    imagesavealpha($newImg,true);
    $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
    imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
    imagecopyresampled($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight,
        $srcWidth, $srcHeight);

    imagepng($newImg, $newcopy);
}

function removerHTML($val){
    return $val=str_replace(array('&', '<', '>'), array('&amp;', '&lt;', '&gt;'), $val);
}

function cortaNome($nome){
    $nome = explode(" ", $nome);
    if (count($nome) < 2) {
        $result = $nome[0];
    } elseif (count($nome) == 2) {
        $result = $nome[0] . " " . $nome[1];
    }else{
        $last=count($nome)-1;
        $result = $nome[0] . " " . $nome[$last];
    }
    return $result;
}

function verificaImagem($dir){
    if(@is_array(getimagesize($dir))){
        return  true;
    } else {
        return false;
    }
}

function cortaStr($string,$tamanho){
    if(strlen($string)>$tamanho){
        $string=utf8_decode($string);
        $string  = (strlen($string) > $tamanho) ? substr($string, 0, $tamanho) . '...' : $string;
        return utf8_encode($string);
    }else{
        return ($string);
    }
}

function mostraFicheiros($dir){
    return @array_diff(@scandir($dir), array('..', '.'));
}

function moverFicheiros($de,$para){
    if(is_dir($de)){
        if(!is_dir($para)){
            mkdir($para);
        }

        $ficheiros=mostraFicheiros($de);
        foreach ($ficheiros as $ficheiro){
            copy("$de/$ficheiro","$para/$ficheiro");
            unlink("$de/$ficheiro");
        }
        return true;
    }else{
        //die("$de não existe");
    }
}

function copiarFicheiros($de,$para){
    if(is_dir($de)){
        if(!is_dir($para)){
            mkdir($para);
        }

        $ficheiros=mostraFicheiros($de);
        foreach ($ficheiros as $ficheiro){
            copy("$de/$ficheiro","$para/$ficheiro");
        }
        return true;
    }else{
        //die("$de não existe");
    }
}

function getWeek($ddate){
    $date = new DateTime($ddate);
    $week = $date->format("W");
    return $week;
}

function listarFicheirosDaNuvem($layoutDirectory,$db,$id_pasta=0,$reciclagem=0,$min_voltar=0){

    $admin=0;
    foreach ($_SESSION['grupos'] as $id_grupo){
        if($id_grupo==1 || $id_grupo==2){
            $admin=1;
            break;
        }
    }
    $id_pasta_parent=$db->escape_string($id_pasta);

    $dir="../_contents";
    if(!is_dir($dir)){
        mkdir($dir);
    }
    $dir.="/nuvem_pastas";
    if(!is_dir($dir)){
        mkdir($dir);
    }

    $caminho="<a href='_addUrl_&id_pasta_parent=0'><i class='fa fa-list'></i> Início</a>  / ";
    $ativo=1;
    if($reciclagem!=0){
        $dir="../_contents";
        if(!is_dir($dir)){
            mkdir($dir);
        }
        $dir.="/nuvem_reciclagem";
        if(!is_dir($dir)){
            mkdir($dir);
        }
        $ativo=0;
        $caminho="<a href='_addUrl_&id_pasta_parent=0'><i class='fa fa-trash'></i> Reciclagem</a>  / ";
    }

    $id_voltar="";

    $pastas=array();
    $sql="select id_parent,nome_real from pastas where id_pasta='$id_pasta_parent' and ativo=$ativo";
    $result=runQ($sql,$db,"VERIFICAR SE A APSTA EXISTE");
    while ($row = $result->fetch_assoc()) {

        $id_voltar=$row['id_parent'];
        $nome_real=$row['nome_real'];

        $pastas=get_chain_da_pasta($db,$id_pasta_parent,$nome_real);
        $objTmp = (object) array('aFlat' => array());
        array_walk_recursive($pastas, create_function('&$v, $k, &$t', '$t->aFlat[] = $v;'), $objTmp);
        $pastas=$objTmp->aFlat;

        unset($pastas[0]);

        $pastas=array_reverse($pastas);
        foreach ($pastas as $pasta){
            $dir.="/".$pasta;
            if(!is_dir($dir)){
                mkdir($dir);
            }
            $sql="select nome_pasta,id_pasta from pastas where nome_real='$pasta'";
            $result=runQ($sql,$db,"VERIFICAR SE A APSTA EXISTE");
            while ($row = $result->fetch_assoc()) {
                $caminho.="<a style='white-space: nowrap;' href='_addUrl_&id_pasta_parent=".$row['id_pasta']."'><i class='fa fa-folder'></i> ".$row['nome_pasta']."</a>  / ";
            }
        }
    }
    if($result->num_rows==0){
        $id_voltar=0;
    }

    if($id_voltar==$min_voltar){
        $id_voltar=0;
    }



    $linha='<div class="col-xs-6 col-sm-3 col-lg-2 text-center" > <!-- data-toggle="tooltip" data-placement="top" title="_nomeCompleto_" data-original-title="_nomeCompleto_"-->
             <div class="animation-fadeInQuick2" style="height: 200px">
                 <div class="" style="height: 130px; position: relative">
                 <span class="top-right">_funcoes_</span> 
                     _preview_
                 </div>
                 <b>_nomeCortado_</b>
                 
             </div>
       </div>';

    $linhas="    
    <a class='hidden' id='abrir-modal-renomear' href='#modal-renomear' data-toggle='modal'></a>
    <div id='modal-renomear' class='modal fade' tabindex='-1' role='dialog'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                    <h3 class='modal-title'><strong>Renomear</strong></h3>
                </div>
                <form id='form-renomear-pasta-ficheiro' action='../mod_nuvem/_mudarNomePastaFicheiro.php' method='post' style='padding:20px'>
                    <div class='modal-body'>
                        <label>Novo nome:</label>
                        <input id='nome_pasta_ficheiro' name='nome_pasta_ficheiro' class='form-control' >
                        <input id='tipo' name='tipo' class='hidden' >
                        <input id='id_pasta_ficheiro' name='id_pasta_ficheiro' class='hidden' >
                    </div>
                    <div class='modal-footer'>
                          <button type='submit' name='submit' id='form-renomear-pasta-ficheiro_botao_loading' class='btn btn-effect-ripple btn-primary ' data-loading-text='<i class=\"fa fa-asterisk fa-spin\"></i> Aguarde'>Concluir</button>
                          <button type='reset' class='btn btn-effect-ripple btn-danger pull-left'>Limpar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id='nova-pasta' class='modal fade' tabindex='-1' role='dialog'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                    <h3 class='modal-title'><strong>Nova pasta</strong></h3>
                </div>
                <form id='form-nova-pasta' action='../mod_nuvem/criar.php' method='post' style='padding: 20px'>
                    <div class='modal-body'>
                        <label>Nome da pasta:</label>
                        <input id='nome_pasta' name='nome_pasta' value='Nova pasta' required class='form-control' >
                        <input id='id_parent' name='id_parent' value='_idPastaParent_' class='hidden' >
                    </div>
                    <div class='modal-footer'>
                          <button type='submit' name='submit' id='form-nova-pasta_botao_loading' class='btn btn-effect-ripple btn-primary ' data-loading-text='<i class=\"fa fa-asterisk fa-spin\"></i> Aguarde'>Concluir</button>
                          <button type='reset' class='btn btn-effect-ripple btn-danger pull-left'>Limpar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id='modal-upload' class='modal fade' tabindex='-1' role='dialog'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                    <h3 class='modal-title'><strong>Carregar Documentos</strong></h3>
                </div>
                <div class='modal-content'>
                        <div style='padding: 20px'>
                            <label><i class=\"fa fa-cloud-upload\"></i> Carregar Documentos</label>
                            <form action=\"\" class=\"dropzone\" id=\"myAwesomeDropzone\"></form>
                        </div>
                </div>
                <div class='modal-footer'>
                    <form id='form-upload-nuvem' action='../mod_nuvem/upload_nuvem.php' method='post' enctype='multipart/form-data'>
                        <input name='id_pasta' value='_idPastaParent_' class='hidden'>
                        <button type='submit' onclick=\"window.onbeforeunload = null;\"  name='submit' id='form-upload-nuvem_botao_loading' class='btn btn-effect-ripple btn-primary pull-right' data-loading-text='<i class=\"fa fa-asterisk fa-spin\"></i> Aguarde'>Concluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class='col-lg-12 text-center' style='padding-bottom: 10px'>
        <small>
            _caminho_
        </small>
    </div>
    <div class='col-lg-12'>
        <div class='text-center' style='padding-bottom: 20px'>
            _voltar_
            _botoes_
        </div>
    </div>
    
    <form id='form-reciclar-varios' action='../mod_nuvem/reciclar.php' method='post'>
    
    ";

    $botoes='<a href=\'#nova-pasta\' data-toggle=\'modal\' class=\'btn btn-primary btn-effect-ripple\'> <i class="fa fa-plus"></i> Nova pasta</a>
             <a href=\'#modal-upload\' data-toggle=\'modal\' class=\'btn btn-primary btn-effect-ripple\'> <i class="fa fa-upload"></i> Carregar Documentos</a>
             <a href=\'javascript:void(0)\' onclick="mostrarCheckboxes()" class=\'btn btn-primary btn-effect-ripple\'> <i id="icon_selecionar_varios" class="fa fa-square-o"></i> Selecionar vários</a>
             <br><a href=\'javascript:void(0)\' id="btn-submit-reciclar-varios" onclick="document.getElementById(\'form-reciclar-varios\').submit()" class=\'btn btn-warning btn-effect-ripple hidden\'> <i class="fa fa-trash-o"></i> _reciclar_ selecionados</a>';



    if($reciclagem!=0){
        $botoes='<a href=\'javascript:void(0)\' onclick="mostrarCheckboxes()" class=\'btn btn-primary btn-effect-ripple\'> <i id="icon_selecionar_varios" class="fa fa-square-o"></i> Selecionar vários</a>
             <br><a href=\'javascript:void(0)\' id="btn-submit-reciclar-varios" onclick="document.getElementById(\'form-reciclar-varios\').submit()" class=\'btn btn-warning btn-effect-ripple hidden\'> <i class="fa fa-trash-o"></i> _reciclar_ selecionados</a>';
    }


    $admin=0;
    foreach ($_SESSION['grupos'] as $id_grupo){
        if($id_grupo==1 || $id_grupo==2){
            $admin=1;
        }
    }
    if($admin==0){
        $botoes="";
    }

    $linhas=str_replace("_botoes_",$botoes,$linhas);



    $linhas = str_replace("_idPastaParent_", $id_pasta_parent, $linhas);

    if($id_voltar!="" and $id_voltar!=$id_pasta_parent){
        $linhas=str_replace("_voltar_",'<a href=\'_addUrl_&id_pasta_parent='.$id_voltar.'\' class=\'btn btn-info btn-effect-ripple\'> <i class="fa fa-arrow-left"></i> Voltar</a>',$linhas);
    }
    $linhas=str_replace("_voltar_",'',$linhas);

    $link=str_replace("/index.php","",actual_link);
    $link=explode("?",$link);
    $link=$link[0];

    $todos_ficheiros=mostraFicheiros($dir);
    $ficheiros_e_pastas=array();
    if(is_array($todos_ficheiros) and !empty($todos_ficheiros)){
        foreach ($todos_ficheiros as $key=>$value){
            if(is_dir($dir."/".$value)){
                array_push($ficheiros_e_pastas,$value);
                unset($todos_ficheiros[$key]);
            }
        }
        foreach ($todos_ficheiros as $ficheiro){
            array_push($ficheiros_e_pastas,$ficheiro);
        }

        foreach ($ficheiros_e_pastas as $item){
            $linhas .= $linha;

            $ficheiro="$dir/$item";
            $nomeCompleto=$item;
            $nomeCortado=cortaStr($nomeCompleto,30);

            $funcoes="";
            $checkbox="";
            $id_ficheiro="";
            if(is_dir($ficheiro)){

                $linhas=str_replace("_preview_",'<a href="_addUrl_&id_pasta_parent=_idPasta_" ><i class="fa fa-folder _corPasta_ vertical-center" style="font-size: 100px; padding-top: 25px"></i></a>',$linhas);
                $ext="";

                $sql="select * from pastas where nome_real='".$item."'";
                $result=runQ($sql,$db,"NOME PASTA");
                $mostrar_funcs=0;
                $cor_pasta='text-info';
                $id_pasta="";
                while ($row = $result->fetch_assoc()) {
                    if($row['tipo']=="pasta") {
                        $mostrar_funcs=1;
                        $cor_pasta='text-warning';
                    }

                    $nomeCompleto=$row['nome_pasta'];
                    $nomeCortado=cortaStr($nomeCompleto,30);

                    if($mostrar_funcs==1 and ($row['id_criou']==$_SESSION['id_utilizador'] || $admin==1)){
                        if($reciclagem==0) {
                            $funcoes.='<li>
                          <a href="javascript:void(0)" onclick="renomearPastaFicheiro('.$row['id_pasta'].',\'_nomeCompleto_\',\'pasta\')">
                               <i class="fa fa-i-cursor pull-right"></i>
                               Renomear 
                              </a>
                          </li>';
                        }
                        $funcoes.='
                          <li>
                             <a href="javascript:void(0)" onclick="confirmaModal(\'../mod_nuvem/reciclar.php?id_pasta_ficheiro='.$row['id_pasta'].'&nome_pasta_ficheiro=_nomeCompleto_&tipo=pasta\')">
                               <i class="fa fa-trash-o pull-right"></i>
                               _reciclar_
                              </a>
                          </li>';
                    }

                    $id_pasta=$row['id_pasta'];
                    $linhas = str_replace("_corPasta_", $cor_pasta, $linhas);

                    $sql2="select nome_utilizador from utilizadores where id_utilizador='".$row['id_criou']."'";
                    $result2=runQ($sql2,$db,"NOME CRIADOR");
                    while ($row2 = $result2->fetch_assoc()) {
                        $criadoPor="<a href='../utilizadores/perfil.php?id=".$row['id_criou']."'>".$row2['nome_utilizador']."</a>";
                    }
                    $criadoEm=strftime("%d/%m/%Y %H/%M", strtotime($row['created_at']));

                    $editadoPor=" - ";
                    $editadoEm=" - ";
                    if(!is_null($row['id_editou'])){
                        $sql2="select nome_utilizador from utilizadores where id_utilizador='".$row['id_editou']."'";
                        $result2=runQ($sql2,$db,"NOME CRIADOR");
                        while ($row2 = $result2->fetch_assoc()) {
                            $editadoPor="<a href='../utilizadores/perfil.php?id=".$row['id_editou']."'>".$row2['nome_utilizador']."</a>";
                        }
                        $editadoEm=strftime("%d/%m/%Y %H/%M", strtotime($row['updated_at']));
                    }
                }
                $linhas = str_replace("_idPasta_", $id_pasta, $linhas);

            }
            else{
                $sql="select * from pastas_ficheiros where nome_real='".$item."'";
                $result=runQ($sql,$db,"NOME FICHIERO");
                while ($row = $result->fetch_assoc()) {
                    $nomeCompleto=$row['nome_ficheiro'];
                    $nomeCortado=explode(".",$item);
                    $ext=end($nomeCortado);
                    $ext_svg=end($nomeCortado);
                    $nomeCortado=str_replace(".$ext","",$item);
                    $ext="<small class='text-muted'>.$ext</small>";

                    if($row['nome_ficheiro']!="" and !is_null($row['nome_ficheiro'])){
                        $nomeCortado=$row['nome_ficheiro'];
                    }
                    $nomeCortado=cortaStr($nomeCompleto,20);
                    $nomeCortado.=$ext;



                    if(is_image("$ficheiro")){
                        $linhas=str_replace("_preview_",'<a href="_ficheiro_" data-toggle="lightbox-image" class="text-center"> <img src="_ficheiro_" alt="" class="img-responsive vertical-center" style="max-width: 100%;max-height: 130px;"> </a>',$linhas);
                    }else{
                        if(is_file("$layoutDirectory/img/svg_filetypes/$ext_svg.svg")){
                            $svg="$layoutDirectory/img/svg_filetypes/$ext_svg.svg";
                        }else{
                            $svg="$layoutDirectory/img/svg_filetypes/file.svg";
                        }
                        $linhas=str_replace("_preview_",'<a href="_ficheiro_" target="_blank" ><img src="_svg_" alt="" class="" style="height: 90px;margin-top: 20px;"></a>',$linhas);
                        $linhas = str_replace("_svg_", $svg, $linhas);
                        $linhas = str_replace("_ext_", $ext_svg, $linhas);
                    }

                    if($reciclagem==0) {
                        $funcoes .= '<li>
                           <a href="_ficheiro_" download="">
                             <i class="fa fa-save pull-right"></i>
                             Transferir 
                            </a>
                        </li>';
                    }

                    if($row['id_criou']==$_SESSION['id_utilizador'] || $admin==1){
                        if($reciclagem==0){
                            $funcoes.='<li>
                                  <a href="javascript:void(0)" onclick="renomearPastaFicheiro('.$row['id_ficheiro'].',\'_nomeCompleto_\',\'ficheiro\')">
                                       <i class="fa fa-i-cursor pull-right"></i>
                                       Renomear 
                                      </a>
                                  </li>';
                        }
                        $funcoes.='
                          <li>
                             <a href="javascript:void(0)" onclick="confirmaModal(\'../mod_nuvem/reciclar.php?id_pasta_ficheiro='.$row['id_ficheiro'].'&nome_pasta_ficheiro=_nomeCompleto_&tipo=ficheiro\')">
                               <i class="fa fa-trash-o pull-right"></i>
                               _reciclar_ 
                              </a>
                          </li>';
                        $checkbox="<label class=\"csscheckbox csscheckbox-primary hidden\"><input name='checkboxes[]' value='".$row['id_ficheiro']."' type=\"checkbox\"><span></span></label>";
                        $id_ficheiro=$row['id_ficheiro'];
                    }

                    $sql2="select nome_utilizador from utilizadores where id_utilizador='".$row['id_criou']."'";
                    $result2=runQ($sql2,$db,"NOME CRIADOR");
                    while ($row2 = $result2->fetch_assoc()) {
                        $criadoPor="<a href='../utilizadores/perfil.php?id=".$row['id_criou']."'>".$row2['nome_utilizador']."</a>";
                    }
                    $criadoEm=strftime("%d/%m/%Y %H/%M", strtotime($row['created_at']));

                    $editadoPor=" - ";
                    $editadoEm=" - ";
                    if(!is_null($row['id_editou'])){
                        $sql2="select nome_utilizador from utilizadores where id_utilizador='".$row['id_editou']."'";
                        $result2=runQ($sql2,$db,"NOME CRIADOR");
                        while ($row2 = $result2->fetch_assoc()) {
                            $editadoPor="<a href='../utilizadores/perfil.php?id=".$row['id_editou']."'>".$row2['nome_utilizador']."</a>";
                        }
                        $editadoEm=strftime("%d/%m/%Y %H/%M", strtotime($row['updated_at']));
                    }
                }
            }

            $funcoes.='<li>
                          <a href="javascript:void(0)" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<small><b>Nome:</b> '.$nomeCompleto.'<br> <b>Criado por: </b> '.$criadoPor.' <br> <b>Criado em: </b> '.$criadoEm.' <br> <b>Editado por: </b>'.$editadoPor.'<br> <b>Editado em: </b>'.$editadoEm.'</small>">
                               <i class="fa fa-question pull-right"></i>
                               Sobre
                              </a>
                          </li>';

            if($funcoes!=""){
                $funcoes='<div class="btn-group esconder_mostrar_checkbox">
                      <b href="javascript:void(0)" data-toggle="dropdown" class=" btn btn-primary btn-xs btn-effect-ripple dropdown-toggle"> <span class="fa fa-bars"> <i class="caret"></i></span></b>
                      <ul class="dropdown-menu dropdown-menu-right text-left" style="min-width: 120px;">
                             '.$funcoes.'
                      </ul>
                      _checkbox_
                </div>';
            }

            if($checkbox!=""){
                $funcoes=str_replace("_checkbox_",$checkbox,$funcoes);
            }
            $funcoes=str_replace("_checkbox_","",$funcoes);




            $linhas = str_replace("_funcoes_", $funcoes, $linhas);
            $linhas = str_replace("_link_", $link, $linhas);
            $linhas = str_replace("_dir_", $dir, $linhas);
            $linhas = str_replace("_ficheiro_", $ficheiro, $linhas);
            $linhas = str_replace("_nomeCortado_", $nomeCortado, $linhas);
            $linhas = str_replace("_nomeCompleto_", $nomeCompleto, $linhas);
            if($reciclagem!=0){
                $linhas=str_replace("_reciclar_","Restaurar",$linhas);
            }else{
                $linhas=str_replace("_reciclar_","Reciclar",$linhas);
            }
        }
    }else{
        $linhas.="<div class='col-lg-12'><div class='text-center'><h1 class='text-muted'><i class='fa fa-eye'></i> A pasta está vazia</h1></div></div>";
    }

    $linhas.="</form>";
    $linhas = str_replace("_caminho_", $caminho, $linhas);
    $linhas = str_replace("_idPastaParent_", $id_pasta_parent, $linhas);
    return $linhas;
}

function human_filesize($bytes, $decimals = 2) {
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

function dir_size($directory) //bytes
{
    $size = 0;
    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file)
    {
        $size += $file->getSize();
    }
    return $size;
}

//link atual
function linkcompleto($paginaAtual,$novaPagina){
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $actual_link=explode("?",$actual_link);
    $actual_link=$actual_link[0];
    $actual_link=str_replace($paginaAtual,$novaPagina,$actual_link);
    return $actual_link;
}

// Function to remove folders and files
function rrmdir($src) {
    $dir = opendir($src);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            $full = $src . '/' . $file;
            if ( is_dir($full) ) {
                rrmdir($full);
            }
            else {
                unlink($full);
            }
        }
    }
    closedir($dir);
    rmdir($src);
}
function recursive_copy($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recursive_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

function recursiveDesativarPasta($db,$id_pasta){
    $sql="update pastas set ativo=0 where id_pasta='$id_pasta'";
    $result=runQ($sql,$db,"DESATIVAR PASTA");

    $sql="update pastas_ficheiros set ativo=0 where id_pasta='$id_pasta'";
    $result=runQ($sql,$db,"DESATIVAR FICHEIROS");


    $sql="select id_pasta from pastas where id_parent='$id_pasta'";
    $result=runQ($sql,$db,"RECICLAR chlds RECUSRSIVE");
    while ($row = $result->fetch_assoc()) {
        recursiveDesativarPasta($db, $row['id_pasta']);
    }
}
function recursiveAtivarPasta($db,$id_pasta){
    $sql="update pastas set ativo=1 where id_pasta='$id_pasta'";
    $result=runQ($sql,$db,"RECICLAR RECUSRSIVE");

    $sql="update pastas_ficheiros set ativo=1 where id_pasta='$id_pasta'";
    $result=runQ($sql,$db,"DESATIVAR FICHEIROS");

    $sql="select id_pasta from pastas where id_parent='$id_pasta'";
    $result=runQ($sql,$db,"RECICLAR chlds RECUSRSIVE");
    while ($row = $result->fetch_assoc()) {
        recursiveAtivarPasta($db, $row['id_pasta']);
    }
}

function recursivePosicao($id_modulo){
    $return=array();
    foreach ($_SESSION['modulos'] as $modulo){
        if($id_modulo==$modulo['id_modulo']){
            $return['id_modulo']=$modulo['id_modulo'];
            if($modulo['id_parent']!=0){
                $return['parent']=recursivePosicao($modulo['id_parent']);
            }
        }
    }
    return $return;
}

function recursiveGetMensagensRespostas($db,$id_mensagem,$id_utilizador){
    $array=array();
    array_push($array,$id_mensagem);
    $sql="
    select * from mensagens 
    inner join utilizadores_mensagens on utilizadores_mensagens.id_mensagem=mensagens.id_mensagem 
    where 
    id_parent='$id_mensagem' and 
    ((id_criou='".$_SESSION['id_utilizador']."' and id_utilizador='$id_utilizador') or 
    (id_criou='$id_utilizador' and id_utilizador='".$_SESSION['id_utilizador']."'))";
    $result=runQ($sql,$db,"GET RESPOSTAS");
    $tmp=array();
    if($result->num_rows!=0) {
        while ($row = $result->fetch_assoc()) {
            $tmp=recursiveGetMensagensRespostas($db,$row['id_mensagem'],$id_utilizador);
        }
    }
    array_push($array,$tmp);
    return $array;
}

function recursiveGetMensagensAnteriores($db,$id_parent,$id_utilizador){
    $array=array();
    array_push($array,$id_parent);
    $sql="
    select * from mensagens 
    inner join utilizadores_mensagens on utilizadores_mensagens.id_mensagem=mensagens.id_mensagem 
    where mensagens.id_mensagem='$id_parent' and 
    ((id_criou='".$_SESSION['id_utilizador']."' and id_utilizador='$id_utilizador') or 
    (id_criou='$id_utilizador' and id_utilizador='".$_SESSION['id_utilizador']."'))";
    $result=runQ($sql,$db,"GET RESPOSTAS");
    $tmp=array();
    if($result->num_rows!=0) {
        while ($row = $result->fetch_assoc()) {
            $tmp=recursiveGetMensagensAnteriores($db,$row['id_parent'],$id_utilizador);
        }
    }
    array_push($array,$tmp);
    return $array;
}

function sub_categories($id_categoria,$db){
    $sql_cats="select * from servicos_categorias where id_parent='$id_categoria' and ativo=1 order by nome_categoria asc";
    $result_cats=runQ($sql_cats,$db,"GET CHAIN categorias");
    $categories=[];
    while ($row_cats = $result_cats->fetch_assoc()) {
        $categories[$row_cats['id_categoria']]['nome_categoria']=$row_cats['nome_categoria'];
        $categories[$row_cats['id_categoria']]['sub']=sub_categories($row_cats['id_categoria'],$db);
    }
    return $categories;
}

function sub_categories_to_select_options($categorias,$class,$step=""){
    $opcoes="";
    foreach ($categorias as $id_categoria=>$categoria){
        $opcoes.="<option class='$class' value='$id_categoria'>$step ".$categoria['nome_categoria']."</option>\r\n";
        if(count($categoria['sub'])>0){
            $step_tmp=$step."-- ";
            $opcoes.=sub_categories_to_select_options($categoria['sub'],$class,$step_tmp);
        }
    }
    return $opcoes;
}

function sub_categories_to_panels($categorias,$id_parent,$db){
    $panel='
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#parent_id_parent_" href="#categoria_id_categoria_" aria-expanded="true"><strong>_nome_categoria_</strong></a>
            </div>
        </div>
        <div id="categoria_id_categoria_" class="panel-collapse collapse" aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                _servicos_
                </div>
                
                _categorias_
            </div>
        </div>
    </div>
    ';
    $panels="";
    foreach ($categorias as $id_categoria=>$categoria){
        $panels.=$panel;
        $panels=str_replace("_id_categoria_",$id_categoria,$panels);
        $panels=str_replace("_nome_categoria_",$categoria['nome_categoria'],$panels);
        $panels=str_replace("_id_parent_",$id_parent,$panels);

        $sql_servicos="select * from servicos where id_categoria='$id_categoria' and ativo=1 order by nome_servico asc";
        $result_servicos=runQ($sql_servicos,$db,"GET servicos");
        $servicos="";
        while ($row_servicos = $result_servicos->fetch_assoc()) {
            $valor=$row_servicos['valor']*1;

            $iva=0;
            $sql_iva="select nome_iva from sup_iva where id_iva='".$row_servicos['id_iva']."'";
            $result_iva=runQ($sql_iva,$db,"GET IVA");
            while ($row_iva= $result_iva->fetch_assoc()) {
                $iva=$row_iva['nome_iva']*1;
            }
            $percentagem_iva=$iva;
            $iva=$iva/100;

            if($row_servicos['com_iva']==0){
                $com_iva=$valor+($valor*$iva);
                $sem_iva=$valor;

            }else{
                $com_iva=$valor;
                $sem_iva=$valor-($valor*$iva);
            }
            $valor_iva=$com_iva-$sem_iva;

            $com_iva=number_format($com_iva,"2",".","");
            $sem_iva=number_format($sem_iva,"2",".","");
            $valor_iva=number_format($valor_iva,"2",".","");

            $servicos.='
            <div class="col-xs-6 col-lg-3">
                <label class="csscheckbox csscheckbox-primary" id="label'.$row_servicos['id_servico'].'">
                    <input onchange="add_servico('.$row_servicos['id_servico'].',this.checked)" id="servico'.$row_servicos['id_servico'].'" value="'.$row_servicos['id_servico'].'" type="checkbox"> <span></span> 
                    <b id="nome'.$row_servicos['id_servico'].'">'.$row_servicos['nome_servico'].'</b>
                </label>
                <table class="table table-bordered text-muted">
                    <head>
                        <tr>
                            <th>%/IVA </th>
                            <th>c/IVA </th>
                            <th>s/IVA </th>
                            <th>€/IVA</th>
                        </tr>
                    </head>
                    <tbody>
                        <tr>
                            <td class="text-right">%<span id="percentagem_iva'.$row_servicos['id_servico'].'">'.$percentagem_iva.'</span></td>
                            <td class="text-right">€<span id="com_iva'.$row_servicos['id_servico'].'">'.$com_iva.'</span></td>
                            <td class="text-right">€<span id="sem_iva'.$row_servicos['id_servico'].'">'.$sem_iva.'</span></td>
                            <td class="text-right">€<span id="valor_iva'.$row_servicos['id_servico'].'">'.$valor_iva.'</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>  
            ';
        }
        if($servicos==""){
            $servicos="<div class='text-center'><b class='text-muted '><i class='fa fa-frown-o'></i> Nenhum serviço encontrado</b></div>";
        }

        $panels=str_replace("_servicos_",$servicos,$panels);

        if(count($categoria['sub'])>0){
            $panels=str_replace("_categorias_","<hr>".sub_categories_to_panels($categoria['sub'],$id_categoria,$db),$panels);
        }else{
            $panels=str_replace("_categorias_","",$panels);
        }
    }
    return $panels;
}

function get_chain_da_pasta($db,$id_pasta,$nome_real){
    $array=array();
    array_push($array,$nome_real);
    $sql="select id_parent,nome_real from pastas where id_pasta='$id_pasta'";
    $result=runQ($sql,$db,"GET CHAIN PASTAS");
    $tmp=array();
    if($result->num_rows!=0) {
        while ($row = $result->fetch_assoc()) {
            $tmp=get_chain_da_pasta($db,$row['id_parent'],$row['nome_real']);
        }
    }
    array_push($array,$tmp);
    return $array;
}

//mete os módulos de forma organizada nos grupos onde se tem de escolher os acessos
function RecursiveSubModulos($linhaModulo,$linhaFuncionalidade,$modulos,$id_modulo){
    $submodulos="";
    $c=0;
    foreach ($modulos as $child){
        if($child['id_parent']==$id_modulo){
            $submodulos.=str_replace("_nome_",($child['nome_modulo']),$linhaModulo);
            $submodulos=str_replace("_id_",($child['id_modulo']),$submodulos);
            $submodulos=str_replace("_icon_",($child['icon']),$submodulos);
            $submodulos=str_replace("_descricao_",($child['descricao']),$submodulos);
            if($child['ativo']==0){
                $submodulos=str_replace("_desativo_","text-muted",$submodulos);
            }else{
                $submodulos=str_replace("_desativo_","",$submodulos);
            }
            $funcionalidades="";
            foreach ($child['funcionalidades'] as $func){
                $funcionalidades.=str_replace("_nome_",($func['nome_funcionalidade']),$linhaFuncionalidade);
                $funcionalidades=str_replace("_id_",($func['id_funcionalidade']),$funcionalidades);
                $funcionalidades=str_replace("_checked_","_func".$func['id_funcionalidade']."_",$funcionalidades);

                $funcionalidades=str_replace("_icon_",($func['icon']),$funcionalidades);
                $funcionalidades=str_replace("_descricao_",($func['descricao']),$funcionalidades);
                if($func['ativo']==0){
                    $funcionalidades=str_replace("_desativo_","text-muted",$funcionalidades);
                }else{
                    $funcionalidades=str_replace("_desativo_","",$funcionalidades);
                }
            }
            $submodulos=str_replace("_linhas_",$funcionalidades,$submodulos);
            $submodulos=str_replace("_idModulo_",($child['id_modulo']),$submodulos);


            $sub_submodulos=RecursiveSubModulos($linhaModulo,$linhaFuncionalidade,$modulos,$child['id_modulo']);
            $submodulos=str_replace("_submodulos_",$sub_submodulos,$submodulos);
        }
    }
    return $submodulos;
}

//converte uma string para uma cor xD
function stringToColorCode($str) {
    $code = dechex(crc32($str));
    $code = substr($code, 0, 6);
    return "#".$code;
}

function cleanContacto($contacto){
    return $contacto=preg_replace('/\D/', '', $contacto);
}

function is_image($dir){
    return @getimagesize($dir) ? true : false;
}
function notificar($db,$nome_notificacao,$nome_tabela,$nome_coluna,$id_item,$url_destino,$destinatarios,$destinatarios_email=[],$assunto="",$texto_email="",$destinatarios_sms=[],$texto_sms="",$anexos=[]){
    if(is_file("enviar_notificacoes.php")){
        $file="enviar_notificacoes";
    }elseif(is_file("../enviar_notificacoes.php")){
        $file="../enviar_notificacoes";
    }

    if(is_file("conf/dados_plataforma.php")){
        include "conf/dados_plataforma.php";
    }elseif(is_file("../conf/dados_plataforma.php")){
        include "../conf/dados_plataforma.php";
    }

    $session_id_utilizador=0;
    if(isset($_SESSION['id_utilizador'])){
        $session_id_utilizador=$_SESSION['id_utilizador'];
    }

    $sql_notificacao = "insert into notificacoes 
            (nome_notificacao, nome_tabela, nome_coluna, id_item, url, id_criou, created_at)
            VALUES 
            ('$nome_notificacao','$nome_tabela','$nome_coluna','$id_item','$url_destino','$session_id_utilizador','".current_timestamp."')";
    $result_notificacao = runQ($sql_notificacao, $db, "INSERIR NOTIFICACAO");
    $id_notificacao=$db->insert_id;

    if(isset($destinatarios) && is_array($destinatarios) && count($destinatarios)>0){
        foreach ($destinatarios as $destinatario){
            $sql_notificacao="insert into utilizadores_notificacoes (id_utilizador, id_notificacao) values ('$destinatario','$id_notificacao')";
            $result_notificacao = runQ($sql_notificacao, $db, "INSERIR NOTIFICACAO_UTILIZADOR");
        }
    }
    if(isset($destinatarios_sms) && is_array($destinatarios_sms) && count($destinatarios_sms)>0){
        $add_sql="";
        foreach ($destinatarios_sms as $destinatario){
            $add_sql.=" id_utilizador='$destinatario' or ";
        }
        $add_sql.="|";
        $add_sql=str_replace("or |","",$add_sql);

        $sql_notificacao="select contacto from utilizadores where 1 and ($add_sql)";

        $result_notificacao = runQ($sql_notificacao, $db, "SELECT CONTACTOS");
        $contactos=array();
        while ($row = $result_notificacao->fetch_assoc()) {
            if($row['contacto']!="" && $row['contacto']!=0){
                array_push($contactos,$row['contacto']);
            }
        }
        enviarEmailSms($contactos,$texto_sms);
    }


    if(isset($destinatarios_email) && !empty($destinatarios_email)){


        $add_sql=" ";

        foreach ($destinatarios_email as $destinatario){
            $add_sql.="$destinatario,";
        }
        $add_sql=substr($add_sql, 0, -1)."";

        $sql_notificacao="select email from utilizadores where 1 and id_utilizador in ($add_sql)";
        $result_notificacao = runQ($sql_notificacao, $db, "SELECT EMAILS");
        $emails=array();
        while ($row = $result_notificacao->fetch_assoc()) {
            array_push($emails,$row['email']);
        }


        if(is_file("conf/dados_plataforma.php")){
            include("conf/dados_plataforma.php");
        }elseif(is_file("../conf/dados_plataforma.php")){
            include("../conf/dados_plataforma.php");
        }

        $emailTpl=file_get_contents("../assets/email/email.tpl");
        $emailTpl=str_replace("_conteudo_",str_replace('\r\n',"",$texto_email),$emailTpl);
        $emailTpl=str_replace("_nomeEmpresa_",$cfg_nomeEmpresa,$emailTpl);
        $emailTpl=str_replace("_moradaEmpresa_",$cfg_moradaEmpresa,$emailTpl);
        $emailTpl=str_replace("_siteEmpresa_",$cfg_siteEmpresa,$emailTpl);
        $emailTpl=str_replace("_copyPlataforma_",$cfg_copyPlataforma,$emailTpl);
        $emailTpl=str_replace("_copyAno_",date("Y"),$emailTpl);
        $emailTpl=str_replace("_copySite_",$cfg_copySite,$emailTpl);
        $emailTpl=str_replace("_nomePlataforma_",$cfg_nomePlataforma,$emailTpl);

        enviarEmail($anexos,$assunto,$emailTpl,$emails);
    }
}

function gerarCodigo($num){
    $len=strlen($num);
    $limite=9-$len;
    $cod="";
    for($i=0;$i<$limite;$i++){
        $cod.="0";
    }
    $cod.=$num;
    return $cod;
}

function espacoDisco($cfg_espacoDisco,$cfg_espacoReservadoSys){
    $total=$cfg_espacoDisco;
    $reservado=$cfg_espacoReservadoSys;
    $soma=0;
    $totalBytes=($total*1024*1024*1024);
    $reservado=($reservado*1024*1024*1024);
    $diretorio_scan="../_contents";
    $diretorios=mostraDirs($diretorio_scan);

    $output=Array();
    foreach ($diretorios as $diretorio){
        $dir="$diretorio_scan/$diretorio";
        $nome=$diretorio;

        $tamanhoBytes=dir_size($dir);
        if($tamanhoBytes<0){
            $tamanhoBytes=$tamanhoBytes*(-1);
        }
        $itemArray=Array();
        $itemArray['dir']=$diretorio;
        $itemArray['nome']=$nome;
        $itemArray['tamanho']=$tamanhoBytes;
        $itemArray['tamanhoHumano']=human_filesize($tamanhoBytes);
        $itemArray['percentagem']=ceil(($tamanhoBytes*100)/$totalBytes);
        array_push($output,$itemArray);

    }

    //reservado
    $tamanhoBytes=$reservado;
    $itemArray=Array();
    $itemArray['dir']="/";
    $itemArray['nome']="Reservado ao sistema";
    $itemArray['tamanho']=$tamanhoBytes;
    $itemArray['tamanhoHumano']=human_filesize($tamanhoBytes);
    $itemArray['percentagem']=ceil(($tamanhoBytes*100)/$totalBytes);
    array_push($output,$itemArray);

    $soma+=$tamanhoBytes;

    //espaço livre
    $tamanhoBytes=$totalBytes-$soma;

    $itemArray=Array();
    $itemArray['dir']="/";
    $itemArray['nome']="Livre";
    $itemArray['tamanho']=$tamanhoBytes;
    $itemArray['tamanhoHumano']=human_filesize($tamanhoBytes);
    $itemArray['percentagem']=ceil(($tamanhoBytes*100)/$totalBytes);
    array_push($output,$itemArray);

    return $output;
}

function mostraDirs($dir){
    $return = @array_diff(@scandir($dir), array('..', '.'));

    foreach ($return as $i=>$pasta){
        if(!is_dir("$dir/$pasta")){
            unset($return[$i]);
        }
    }

    return $return;
}



function gerarPDFencomenda($ficheiroFonte,$id="",$orientacao="L",$dir=""){
    if(is_file("../conf/dados_plataforma.php")){
        include("../conf/dados_plataforma.php");
    }else{
        include("/conf/dados_plataforma.php");
    }

    // get the HTML
    ob_start();
    include($ficheiroFonte);
    $content = ob_get_clean();

    // convert to PDF
    if(is_file("../assets/html2pdf/html2pdf.class.php")){
        require_once("../assets/html2pdf/html2pdf.class.php");
    }else{
        include("assets/html2pdf/html2pdf.class.php");
    }
    try {
        $html2pdf = new HTML2PDF($orientacao, 'A4', 'pt');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        if($dir!=""){
            $html2pdf->Output($dir, 'F');
            return $dir;
        }else{
            $html2pdf->Output("documento_$cfg_nomePlataforma.pdf");
        }

    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}

function gerarPDF($ficheiroFonte,$id="",$nome_ficheiro,$orientacao='P',$output="file"){
    $dir="../.tmp/".$_SESSION['id_utilizador'];
    if(!is_dir($dir)){
        mkdir($dir);
    }

    if(is_file("../conf/dados_plataforma.php")){
        include("../conf/dados_plataforma.php");
    }else{
        include("/conf/dados_plataforma.php");
    }

    // get the HTML
    ob_start();
    include($ficheiroFonte);
    $content = ob_get_clean();
    $dir="../.tmp/".$_SESSION['id_utilizador']."/$nome_ficheiro";
    // convert to PDF
    if(is_file("../assets/html2pdf/html2pdf.class.php")){
        require_once("../assets/html2pdf/html2pdf.class.php");
    }else{
        include("assets/html2pdf/html2pdf.class.php");
    }
    try {

        $html2pdf = new HTML2PDF($orientacao, 'A4', 'pt');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        if($output=="print_dir"){
            $html2pdf->Output($dir, 'F');
            print $dir;
        }elseif($output=="return_dir"){
            $html2pdf->Output($dir, 'F');
            return $dir;
        }else{
            $html2pdf->Output("$nome_ficheiro");
        }

    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

}

function guardarPDF($tpl,$save_dir){
    if(is_file("../conf/dados_plataforma.php")){
        include("../conf/dados_plataforma.php");
    }else{
        include("/conf/dados_plataforma.php");
    }

    // get the HTML
    ob_start();
    print $tpl;
    $content = ob_get_clean();

    // convert to PDF
    if(is_file("../assets/html2pdf/html2pdf.class.php")){
        require_once("../assets/html2pdf/html2pdf.class.php");
    }else{
        include(".assets/html2pdf/html2pdf.class.php");
    }
    try {
        $html2pdf = new HTML2PDF('P', 'A4', 'pt',true,'UTF-8',array(5, 5, 5, 5));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        @ob_end_clean();
        $html2pdf->Output($save_dir,"F");
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}


/**
 * Get human readable time difference between 2 dates
 *
 * Return difference between 2 dates in year, month, hour, minute or second
 * The $precision caps the number of time units used: for instance if
 * $time1 - $time2 = 3 days, 4 hours, 12 minutes, 5 seconds
 * - with precision = 1 : 3 days
 * - with precision = 2 : 3 days, 4 hours
 * - with precision = 3 : 3 days, 4 hours, 12 minutes
 *
 * From: http://www.if-not-true-then-false.com/2010/php-calculate-real-differences-between-two-dates-or-timestamps/
 *
 * @param mixed $time1 a time (string or timestamp)
 * @param mixed $time2 a time (string or timestamp)
 * @param integer $precision Optional precision
 * @return string time difference
 */
/**
 * Get human readable time difference between 2 dates
 *
 * Return difference between 2 dates in year, month, hour, minute or second
 * The $precision caps the number of time units used: for instance if
 * $time1 - $time2 = 3 days, 4 hours, 12 minutes, 5 seconds
 * - with precision = 1 : 3 days
 * - with precision = 2 : 3 days, 4 hours
 * - with precision = 3 : 3 days, 4 hours, 12 minutes
 *
 * From: http://www.if-not-true-then-false.com/2010/php-calculate-real-differences-between-two-dates-or-timestamps/
 *
 * @param mixed $time1 a time (string or timestamp)
 * @param mixed $time2 a time (string or timestamp)
 * @param integer $precision Optional precision
 * @return string time difference
 */
function diferenca_entre_datas( $time1, $time2, $precision = 2 ) {
    // If not numeric then convert timestamps
    if( !is_int( $time1 ) ) {
        $time1 = strtotime( $time1 );
    }
    if( !is_int( $time2 ) ) {
        $time2 = strtotime( $time2 );
    }
    // If time1 > time2 then swap the 2 values
    if( $time1 > $time2 ) {
        list( $time1, $time2 ) = array( $time2, $time1 );
    }
    // Set up intervals and diffs arrays
    $intervals = array( 'year' =>"ano", 'month'=>"mês", 'day'=>"dia", 'hour'=>"hora", 'minute'=>"minuto", 'second'=>"segundo" );
    $diffs = array();
    foreach( $intervals as $interval => $interval_pt ) {
        // Create temp time from time1 and interval
        $ttime = strtotime( '+1 ' . $interval, $time1 );
        // Set initial values
        $add = 1;
        $looped = 0;
        // Loop until temp time is smaller than time2
        while ( $time2 >= $ttime ) {
            // Create new temp time from time1 and interval
            $add++;
            $ttime = strtotime( "+" . $add . " " . $interval, $time1 );
            $looped++;
        }
        $time1 = strtotime( "+" . $looped . " " . $interval, $time1 );
        $diffs[ $interval_pt ] = $looped;
    }
    $count = 0;
    $times = array();
    foreach( $diffs as $interval => $value ) {
        // Break if we have needed precission
        if( $count >= $precision ) {
            break;
        }
        // Add value and interval if value is bigger than 0
        if( $value > 0 ) {
            if( $value != 1 ){
                if($interval=="mês"){
                    $interval="meses";
                }else{
                    $interval .= "s";
                }
            }
            // Add value and interval to times array
            $times[] = $value . " " . $interval;
            $count++;
        }
    }
    // Return string with times
    return implode( ", ", $times );
}

function selectForLog($db,$nomeTabela,$nomeColuna,$id){
    $sql="select * from $nomeTabela where id_$nomeColuna = '$id'";
    $result = runQ($sql, $db, "SELECT UPDATED");
    while ($row = $result->fetch_assoc()) {
        $array_log = json_encode($row);
        criarLog($db, $nomeTabela, "id_$nomeColuna", $id, "Editar $nomeTabela #$id", $array_log);
    }
}

function criarLog($db,$nomeTabela,$nomeColuna,$id_item,$texto,$array){
    $texto=$db->escape_string($texto);
    $array=$db->escape_string($array);
    $session_id_utilizador=0;
    if(isset($_SESSION['id_utilizador'])){
        $session_id_utilizador=$_SESSION['id_utilizador'];
    }
    $sql = "INSERT INTO utilizadores_logs 
          (nome_tabela,nome_coluna, id_item, data_log, texto, array, id_utilizador,ip) 
          VALUES 
          ('$nomeTabela','$nomeColuna','$id_item','".current_timestamp."','$texto','$array','$session_id_utilizador','".$_SERVER['REMOTE_ADDR']."')";
    $result=runQ($sql,$db,"LOGS:_funcoes.php");
}

function is_date($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function encriptarPW($pw){
    $options = array("cost"=>4);
    $pw = password_hash($pw,PASSWORD_BCRYPT,$options);
    return $pw;
}

function ak_img_convert_to_jpg($target, $newcopy, $ext) {
    list($w_orig, $h_orig) = getimagesize($target);
    $ext = strtolower($ext);
    $img = "";
    if ($ext == "gif"){
        $img = imagecreatefromgif($target);
    } else if($ext =="png"){
        $img = imagecreatefrompng($target);
    }
    $tci = imagecreatetruecolor($w_orig, $h_orig);
    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w_orig, $h_orig, $w_orig, $h_orig);
    imagejpeg($tci, $newcopy, 84);
}

// ----------------------- IMAGE WATERMARK FUNCTION -----------------------
// Function for applying a PNG watermark file to a file after you convert the upload to JPG
function ak_img_watermark($target, $wtrmrk_file, $newcopy) {
    $watermark = imagecreatefrompng($wtrmrk_file);
    imagealphablending($watermark, false);
    imagesavealpha($watermark, true);
    $img = imagecreatefromjpeg($target);
    $img_w = imagesx($img);
    $img_h = imagesy($img);
    $wtrmrk_w = imagesx($watermark);
    $wtrmrk_h = imagesy($watermark);
    $dst_x = ($img_w / 2) - ($wtrmrk_w / 2); // For centering the watermark on any image
    $dst_y = ($img_h / 2) - ($wtrmrk_h / 2); // For centering the watermark on any image
    imagecopy($img, $watermark, $dst_x, $dst_y, 0, 0, $wtrmrk_w, $wtrmrk_h);
    imagejpeg($img, $newcopy, 100);
    imagedestroy($img);
    imagedestroy($watermark);
}

function criar_watermark_png($dir){
    $font = 50;
    $string = $_SESSION['cfg']['nomeEmpresa'];
    $w=strlen($string)*34;
    $h=$font;
    $im = @imagecreatetruecolor($w, $h);
    imagesavealpha($im, true);
    imagealphablending($im, false);
    $white = imagecolorallocatealpha($im, 255, 255, 255, 127);
    imagefill($im, 0, 0, $white);
    $text_color = imagecolorallocate($im, 0, 0, 0);
    imagettftext($im, $font, 0, 0, $font, $text_color, "../assets/layout/css/fonts/Lato-Medium.ttf", $string);
    $transparency = 1 - 0.1;
    imagefilter($im, IMG_FILTER_COLORIZE, 0,0,0,127*$transparency); // the fourth parameter is alpha
    imagepng($im,"$dir");
    imagedestroy($im);
}

function encryptData($text_to_encrypt){
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options   = 0;
    $encryption_iv = '1234567891011121';
    $encryption_key = "worksmart";
    $result = openssl_encrypt($text_to_encrypt, $ciphering, $encryption_key, $options, $encryption_iv);
    return $result;
}

function decryptData($text_to_decrypt){
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options   = 0;
    $decryption_iv  = '1234567891011121';
    $decryption_key = "worksmart";
    $result = openssl_decrypt($text_to_decrypt, $ciphering, $decryption_key, $options, $decryption_iv);
    return $result;
}

function turmas_do_utilizador($db,$id_utilizador){

    $admin=0;
    $sql="select * from grupos_utilizadores where id_utilizador='$id_utilizador' and (id_grupo=1 or id_grupo=2)";
    $result=runQ($sql,$db,"_funcoes.php: grupos do utilizador");
    if($result->num_rows>0){
        $admin=1;
    }

    if($admin==1){
        return "admin";
    }else{

        $sql="select * from utilizadores where id_utilizador='$id_utilizador'";
        $result=runQ($sql,$db,"ids do utilizador");
        while ($row = $result->fetch_assoc()) {
            $id_professor=$row['id_professor'];
            $id_ee=$row['id_ee'];
            $id_aluno=$row['id_aluno'];
        }

        $alunos=[$id_aluno];
        $sql="select alunos_ees.id_aluno from alunos_ees
          inner join alunos on alunos_ees.id_aluno=alunos.id_aluno
          inner join anos_letivos_alunos on anos_letivos_alunos.id_aluno=alunos_ees.id_aluno
          where id_ee='$id_ee' and alunos.ativo=1 and id_ano_letivo='".$_SESSION['id_ano_letivo']."'";
        $result=runQ($sql,$db,"_funcoes.php: alunos");
        while ($row = $result->fetch_assoc()) {
            array_push($alunos,$row['id_aluno']);
        }

        $turmas=[];
        foreach ($alunos as $id_aluno){
            $sql="select turmas_alunos.id_turma from turmas_alunos 
          inner join turmas on turmas.id_turma=turmas_alunos.id_turma
          inner join anos_letivos_turmas on anos_letivos_turmas.id_turma=turmas_alunos.id_turma
          where id_aluno='$id_aluno' and turmas.ativo=1 and id_ano_letivo='".$_SESSION['id_ano_letivo']."'";
            $result=runQ($sql,$db,"_funcoes.php: turmas do alunos");
            while ($row = $result->fetch_assoc()) {
                array_push($turmas,$row['id_turma']);
            }
        }

        $sql="select turmas_professores_disciplinas.id_turma from turmas_professores_disciplinas 
          inner join turmas on turmas.id_turma=turmas_professores_disciplinas.id_turma
          inner join anos_letivos_turmas on anos_letivos_turmas.id_turma=turmas_professores_disciplinas.id_turma
          where id_professor='$id_professor' and turmas.ativo=1 and id_ano_letivo='".$_SESSION['id_ano_letivo']."'";
        $result=runQ($sql,$db,"_funcoes.php: turmas do professor");
        while ($row = $result->fetch_assoc()) {
            array_push($turmas,$row['id_turma']);
        }

        return $turmas;
    }
}

function getStartAndEndDate($week, $year) {
    $dto = new DateTime();
    $dto->setISODate($year, $week);
    $ret['week_start'] = $dto->format('Y-m-d');
    $dto->modify('+6 days');
    $ret['week_end'] = $dto->format('Y-m-d');
    return $ret;
}

function super_unique($array,$key)
{
    $temp_array = [];
    foreach ($array as &$v) {
        if (!isset($temp_array[$v[$key]]))
            $temp_array[$v[$key]] =& $v;
    }
    $array = array_values($temp_array);
    return $array;

}



function get_galeria_old($nomeTabela,$id){
    $i="
        <div class='col-lg-3 col-xs-12  text-center'>
            <img src=\"../_contents/$nomeTabela/$id/_f_\" class=\" img-thumbnail\" style=\"width: 177.78px;height: 100px;object-fit: cover\"><br>
            <a href='../_contents/$nomeTabela/$id/_f_' target='_blank'>_f_</a><br>
            <label class=\"csscheckbox csscheckbox-primary\"><input type=\"checkbox\" name='eliminar[]' value='_f_'><span></span> Eliminar</label>
        </div>";
    $v="
        <div class='col-lg-3 col-xs-12  text-center'>
            <video controls src=\"../_contents/$nomeTabela/$id/_f_\"  style=\"width: 177.78px;height: 100px;object-fit: cover\"></video>
            <br><a href='../_contents/$nomeTabela/$id/_f_' target='_blank'>_f_</a><br>
            <label class=\"csscheckbox csscheckbox-primary\"><input type=\"checkbox\" name='eliminar[]' value='_f_'><span></span> Eliminar</label>
        </div>";
    $d="
        <div class='col-lg-3 col-xs-12  text-center'>
            <a href='../_contents/$nomeTabela/$id/_f_' target='_blank'><img src=\"../assets/layout/img/svg_filetypes/_ext_.svg\" style=\"height: 100px;\"><br>

             <br>_f_</a><br>
            <label class=\"csscheckbox csscheckbox-primary\"><input type=\"checkbox\" name='eliminar[]' value='_f_'><span></span> Eliminar</label>
        </div>";
    $galeria="";
    $fs=mostraFicheiros("../_contents/$nomeTabela/$id");
    foreach ($fs as $f){
        if(!is_dir("../_contents/$nomeTabela/$id/$f")){
            $type=mime_content_type("../_contents/$nomeTabela/$id/$f");
            $type=explode("/",$type);
            $type=$type[0];
            if($type=="video"){
                $galeria.=$v;
            }elseif($type=="image"){
                $galeria.=$i;
            }else{


                $galeria.=$d;
                $ext=explode(".",$f);
                $ext=end($ext);
                $galeria=str_replace("_ext_",$ext,$galeria);
            }

            $galeria=str_replace("_f_",$f,$galeria);
        }
    }
    return $galeria;
}

function get_galeria($nomeTabela,$id){
    $i="
        
            <figure class=\"col-sm-3 col-xs-6 gallery-image-container animation-fadeInQuick2 galeria-figuras\" itemprop=\"associatedMedia\" itemscope itemtype=\"http://schema.org/ImageObject\" style=\"padding-left: 0px;padding-right: 1px;margin-bottom: 1px\"> 

       <a href=\"../_contents/$nomeTabela/$id/_f_\" itemprop=\"contentUrl\" data-size=\"_w_x_h_\">
            <img src=\"../_contents/$nomeTabela/$id/_f_\" itemprop=\"thumbnail\"  style=\"height: 150px;width: 100%;object-fit: cover\" />
        </a>
        _chk_
     </figure>
        ";

    $i='    
        <div class=\'col-xs-12  text-left\'>
            <div>

            <div  class =" photo-gallery__figure " >
                  <a  class =" photo-gallery__item " href ="../_contents/'.$nomeTabela.'/'.$id.'/_f_" data-thumb ="../_contents/'.$nomeTabela.'/'.$id.'/_f_" title ="" data-size ="_w_x_h_"  > 
                    <span  class ="photo-gallery__thumb " style =" background-image:url(../_contents/'.$nomeTabela.'/'.$id.'/_f_);" > </span> 
                    
                  </a> 
                  <a href="javascript:void(0)"  data-toggle="tooltip" data-placement="top" title="_ficheiro_" data-original-title="_ficheiro_">&nbsp;_f2_</a>
            </div>
            _chk_
            </div>
        </div>
       
        

';

    $v="
        <div class='col-xs-12  text-left'>
         
            <video controls src=\"../_contents/$nomeTabela/$id/_f_\"  style=\"width: 177.78px;height: 100px;object-fit: cover\"></video>
             <a href='../_contents/$nomeTabela/$id/_f_' target='_blank' data-toggle='tooltip' data-placement='top' title='_ficheiro_' data-original-title='_ficheiro_'>_f2_</a> _chk_
            
        </div>";

    $a="
        <div class='col-xs-12  text-left'> 
            <audio controls src=\"../_contents/$nomeTabela/$id/_f_\" ></audio>
            <a href='../_contents/$nomeTabela/$id/_f_' target='_blank' data-toggle='tooltip' data-placement='top' title='_ficheiro_' data-original-title='_ficheiro_'>_f2_</a> _chk_
            
        </div>";

    $d="
        <div class='col-xs-12  text-left'>
            
            <a href='../_contents/$nomeTabela/$id/_f_' target='_blank' data-toggle='tooltip' data-placement='top' title='_ficheiro_' data-original-title='_ficheiro_'>
                <img src=\"../assets/layout/img/svg_filetypes/_ext_.svg\" style=\"height: 30px;\">
                _f2_
            </a>
             _chk_
            
        </div>";



    if(strpos(urlAtual, "detalhes.php") && $nomeTabela != "anexos_clientes" && $nomeTabela != "docs"){
        $chk="";
    }else{
        $chk="<label class=\"csscheckbox csscheckbox-danger \" style='color:red; font-size: 10px'><input type=\"checkbox\" name='eliminar[]' value='_f_'><span></span> <i class='fa fa-trash'></i></label>";
    }

    $galeria="";
    $fs=mostraFicheiros("../_contents/$nomeTabela/$id");
    if(is_array($fs)) {
        foreach ($fs as $f) {
            if (!is_dir("../_contents/$nomeTabela/$id/$f")) {
                $type = mime_content_type("../_contents/$nomeTabela/$id/$f");
                $type = explode("/", $type);
                $type = $type[0];
                if ($type == "video") {
                    $galeria .= $v;
                } elseif ($type == "audio") {
                    $galeria .= $a;
                } elseif ($type == "image") {
                    $galeria .= $i;

                    $tamanhos = getimagesize("../_contents/$nomeTabela/$id/$f");
                    $galeria = str_replace("_w_", $tamanhos[0], $galeria);
                    $galeria = str_replace("_h_", $tamanhos[1], $galeria);
                    $galeria = str_replace("_top_left_", "top-left", $galeria);
                } else {
                    $galeria .= $d;
                    $ext = explode(".", $f);
                    $ext = end($ext);
                    $galeria = str_replace("_ext_", $ext, $galeria);
                }
                $galeria = str_replace("_top_left_", "", $galeria);

                $galeria = str_replace("_chk_", $chk, $galeria);
                $galeria = str_replace("_f_", $f, $galeria);
                $f2 = explode("?", $f);
                $galeria=str_replace('_ficheiro_', $f2[0],$galeria);
                $galeria = str_replace("_f2_", cortaStr($f2[0],25), $galeria);
            }
        }
    }
    $galeria="<div class=\"my-gallery row gallery\" itemscope itemtype=\"http://schema.org/ImageGallery\">
                    $galeria
                </div>";

    $galeria='
    <div  class =" photo-gallery " data-pswp-uid =" 212 "> 
    '.$galeria.'
    </div>
    ';
    return $galeria;
}


function carregar_foto($FILE,$cfg_tamanhoMaxUpload){
    $foto="";
    if (isset($FILE['tmp_name']) && $FILE['tmp_name']!="") {
        $fileSize = $FILE["size"];
        if($fileSize<($cfg_tamanhoMaxUpload*1000*100)) {
            $ds = DIRECTORY_SEPARATOR;
            $storeFolder = "../.tmp/".$_SESSION['id_utilizador'];
            create_dir($storeFolder);
            $tempFile = $FILE['tmp_name'];          //3
            $ext=explode(".",$FILE['name']);
            $nome=$ext[0];
            $ext=end($ext);
            $fileName=normalizeString(tirarAcentos($nome."_".rand(0,9999).".$ext"));
            $foto=$fileName;
            $targetFile = $storeFolder ."/". $fileName;  //5
            if(move_uploaded_file($tempFile, $targetFile)){
                if(is_image($targetFile)){
                    $dadosImagem=getimagesize($targetFile);
                    $w=$dadosImagem[0];
                    $h=$dadosImagem[1];

                    $max_w=900;
                    $max_h=900;

                    if( ($w>$max_w || $w==$max_w)  || ($h>$max_h || $h==$max_h)){
                        $ext=explode(".",$targetFile);
                        $ext=end($ext);
                        if($ext=='png'){
                            resizeTransparent("$targetFile","$targetFile",$max_w,$max_h);
                        }else{
                            img_resize("$targetFile","$targetFile",$max_w,$max_h,$ext);
                        }
                    }
                }else{
                    die(" O fichiero não é uma imagem ");
                    unlink($targetFile);
                }
                @unlink($tempFile);
            }
        }else{
            die(" Tamanho do ficheiro tem de ser inferior a $cfg_tamanhoMaxUpload MB");
        }
    }
    return $foto;
}

function colunas_valores_criar($post,$db,$itensIgnorar,$itensObrigatorios,$subModulo,$colunaParent,$idParent){
    $erros="";
    $colunas="";
    $valores="";
    foreach($post as $coluna =>$valor){
        if(!is_array($valor)) {
            if(!in_array($coluna, $itensIgnorar)) {
                if(in_array($coluna, $itensObrigatorios) && $valor=="") {
                    $erros.=" Falta $coluna,";
                }else{
                    if(is_data_portuguesa($valor)){
                        $valor=data_portuguesa($valor);
                    }
                    $valor=$db->escape_string($valor);
                    $colunas.="$coluna,";
                    $valores.="'$valor',";
                }
            }
        }

    }

    if($subModulo==1){
        $colunas.="id_$colunaParent,";
        $valores.="$idParent,";
    }

    $colunas=substr($colunas, 0, -1)."";
    $valores=substr($valores, 0, -1)."";

    return [
        "colunas"=>$colunas,
        "valores"=>$valores,
        "erros"=>$erros,
    ];
}

function colunas_valores_editar($post,$db,$itensIgnorar,$itensObrigatorios){
    $erros = "";
    $colunas_e_valores = "";
    foreach ($post as $coluna => $valor) {
        if(!is_array($valor)) {
            if (!in_array($coluna, $itensIgnorar)) {
                if (in_array($coluna, $itensObrigatorios) && $valor == "") {
                    $erros .= " Falta $coluna,";
                } else {
                    if (is_data_portuguesa($valor)) {
                        $valor = data_portuguesa($valor);
                    }
                    $valor = $db->escape_string($valor);
                    $colunas_e_valores .= "$coluna='$valor',";
                }
            }
        }
    }
    $colunas_e_valores = substr($colunas_e_valores, 0, -1) . "";
    return [
        "colunas_e_valores"=>$colunas_e_valores,
        "erros"=>$erros,
    ];
}

function replaces_no_formulario($content,$row,$nomeTabela,$nomeColuna,$db)
{

    $ativo = "<span class='label label-success'>Não</span><br>" . '<a href="javascript:void(0)" class="btn btn-warning btn-xs btn-effect-ripple" onclick="confirmaModal(\'reciclar.php?id=' . $row['id_' . $nomeColuna] . '\')"> <i class="fa fa-trash"></i> Mover para a reciclagem</a>';
    if($row['ativo'] == 0) {
        $ativo = "<span class='label label-warning'>Sim</span><br>" . '<a href="javascript:void(0)" class="btn btn-info btn-xs btn-effect-ripple" onclick="confirmaModal(\'reciclar.php?id=' . $row['id_' . $nomeColuna] . '\')"> <i class="fa fa-backward"></i> Restaurar</a>';
    }
    $content = str_replace("_ativo_", $ativo, $content);


    foreach($row as $key => $value) {
        if(!is_array($value)) {

            if(is_date($value)) {
                $value = strftime("%d/%m/%Y", strtotime($value));
            } else {
                $arr = json_decode($value, true);
                if(is_array($arr) && count($arr) > 0) {
                    foreach($arr as $val) {

                        $val = str_replace('"', "&quot;", $val);
                        $val = str_replace("'", "&apos;", $val);
                        $content = str_replace("name='" . $key . "[]' value='" . $val . "'", "name='" . $key . "[]' value='" . $val . "' checked", $content);
                        $content = str_replace("class='" . $key . "' value='" . $val . "'", "class='" . $key . "' value='" . $val . "' selected", $content);
                    }
                }
                $value = str_replace('"', "&quot;", $value);
                $value = str_replace("'", "&apos;", $value);
            }

            if($value == 1) { // para itens com cheked [ATENCAO: O NOME tem de vir antes do ID]
                $content = str_replace('name="' . $key . '" id="' . $key . '"', 'name="' . $key . '" id="' . $key . '" checked=""', $content);
            }

            // PREENCHER OS CAMPOS NORMAILS [ATENCAO: O ID tem de vir antes do NOME]
            $content = str_replace('id="' . $key . '" name="' . $key . '"', 'id="' . $key . '" name="' . $key . '" value="' . $value . '"', $content);

            // PREENCHER OS SELECTS AUTOMATICOS
            $content = str_replace("class='" . $key . "' value='" . $value . "'", "class='" . $key . "' value='" . $value . "' selected", $content);

            $content = str_replace("_" . $key . "_", $value, $content);
        }

    }


    if(isset($row['created_at'])){
        $criated_at = strftime("%d/%m/%Y %H:%M:%S", strtotime($row['created_at']))." - ".humanTiming($row['created_at']);
        $content=str_replace("_dataCriado_",$criated_at,$content);

        $id_criou=$row['id_criou'];
        $content=str_replace("_idCriou_",$id_criou,$content);

        if($id_criou!=null) {
            $sql2 = "select nome_utilizador from utilizadores where id_utilizador=$id_criou";
            $result2 = runQ($sql2, $db, "CRIOU");
            while ($row2 = $result2->fetch_assoc()) {
                $content = str_replace("_nomeCriou_", removerHTML($row2['nome_utilizador']), $content);
            }
        }
    }
    $content=str_replace("_nomeCriou_","-",$content);
    if(isset($row['updated_at'])){
        if($row['updated_at'] !=null){
            $criated_at = strftime("%d/%m/%Y %H:%M:%S", strtotime($row['updated_at']))." - ".humanTiming($row['updated_at']);
            $content=str_replace("_dataAtualizado_",$criated_at,$content);
        }
        $id_editou=$row['id_editou'];
        $content=str_replace("_idAtualizou_",$id_editou,$content);

        if($id_editou!=null){
            $sql2="select nome_utilizador from utilizadores where id_utilizador=$id_editou";
            $result2=runQ($sql2,$db,"EDITOU");
            while ($row2 = $result2->fetch_assoc()) {
                $content=str_replace("_nomeAtualizou_",removerHTML($row2['nome_utilizador']),$content);
            }
        }
    }
    $content=str_replace("_dataAtualizado_","-",$content);
    $content=str_replace("_nomeAtualizou_","-",$content);

    $sql2="select count(*) from utilizadores_logs where nome_tabela='$nomeTabela' and id_item='".$row['id_'.$nomeColuna]."'";
    $result2=runQ($sql2,$db,"contar revisoes");
    while ($row2 = $result2->fetch_assoc()) {
        $content=str_replace("_cntRevisoes_",$row2['count(*)'],$content);
    }

    $content=str_replace("_nomeTabela_",$nomeTabela,$content);
    $content=str_replace("_nomeColuna_",$nomeColuna,$content);

    return $content;
}
function xml2array ( $xmlObject, $out = array () )
{
    foreach ( (array) $xmlObject as $index => $node )
        $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

    return $out;
}

function getFeriados($ano){
    $url="http://services.sapo.pt/Holiday/GetNationalHolidays?year=$ano";
    $feriados=file_get_contents($url);
    $feriados=simplexml_load_string($feriados) or die("Error: Cannot create object");
    $feriados=xml2array($feriados);
    $return=[];
    foreach($feriados['GetNationalHolidaysResult']['Holiday'] as $feriado){
        $feriado=xml2array($feriado);
        $data=str_replace("T", " ",$feriado["Date"]);
        $e=array();
        $e['Name']=$feriado["Name"];
        $e['Description']=$feriado["Description"];
        $e['Type']=$feriado["Type"];
        $e['Date']=$data;
        array_push($return,$e);
    }
    return $return;
}

function transferir_servico($data_servico,$nao_permitir_feriados,$nao_permitir_sabados,$nao_permitir_domingos,$dias_bloqueados=[]){
    print " - <b>".date("d/m/Y H:i",strtotime($data_servico))."</b>: ";
    $erro=0;

    $feriados=getFeriados(date("Y",strtotime($data_servico)));
    $calha_no_feriado=0;
    foreach ($feriados as $f){
        if(date("Y-m-d",strtotime($f['Date']))==date("Y-m-d",strtotime($data_servico))){
            $calha_no_feriado=1;
        }
    }
    if($calha_no_feriado==1){
        $erro=1;
        print " é um feriado,";
        array_push($dias_bloqueados,$data_servico);
        $data_servico=date('Y-m-d H:i', strtotime($data_servico. ' - 1 days'));
        print " recuar 1 dia para <b>".date("d/m/Y H:i",strtotime($data_servico))."</b><br>";
        transferir_servico($data_servico,$nao_permitir_feriados,$nao_permitir_sabados,$nao_permitir_domingos,$dias_bloqueados);
    }elseif(in_array($data_servico,$dias_bloqueados)){
        $erro=1;
        print " já existe nas bloqueadas<br>";
        $data_servico=date('Y-m-d H:i', strtotime($data_servico. ' - 1 days'));
        transferir_servico($data_servico,$nao_permitir_feriados,$nao_permitir_sabados,$nao_permitir_domingos,$dias_bloqueados);
    }elseif($nao_permitir_sabados==1 && date('D', strtotime($data_servico)) == 'Sat'){
        $erro=1;
        print " é um Sábado,";
        array_push($dias_bloqueados,$data_servico);
        $data_servico=date('Y-m-d H:i', strtotime($data_servico. ' - 1 days'));
        print " recuar 1 dia para <b>".date("d/m/Y H:i",strtotime($data_servico))."</b><br>";
        transferir_servico($data_servico,$nao_permitir_feriados,$nao_permitir_sabados,$nao_permitir_domingos,$dias_bloqueados);
    }elseif($nao_permitir_domingos==1 && date('D', strtotime($data_servico)) == 'Sun'){
        $erro=1;
        print " é um Domingo,";
        array_push($dias_bloqueados,$data_servico);
        $data_servico=date('Y-m-d H:i', strtotime($data_servico. ' - 2 days'));
        print " recuar 2 dias para <b>".date("d/m/Y H:i",strtotime($data_servico))."</b><br>";
        transferir_servico($data_servico,$nao_permitir_feriados,$nao_permitir_sabados,$nao_permitir_domingos,$dias_bloqueados);
    }


    if($erro==0){
        print " <b class='text-success'>OK</b><br>";
        return $data_servico;
    }

}

function rules_for_rows($rules_for_rows,$row,$tbody,$linkDasTabelas){
    foreach ($rules_for_rows as $rule){
        $i=0;
        foreach ($row as $coluna=>$valor){
            $i++;
            if($coluna==$rule['coluna']){
                switch ($rule['regra']) {
                    case "value":
                        $tbody=str_replace("_".$coluna."_",$rule['valor'],$tbody);
                        break;
                    case "link":
                        $tbody=str_replace("_".$coluna."_","<a class='column-$i' href='_link_'><strong>_".$coluna."_</strong></a>",$tbody);
                        if(isset($rule['valor']) && $rule['valor']!=""){
                            $tbody=str_replace("_link_",$rule['valor'],$tbody);
                        }
                        break;
                    case "link_external":
                        $tbody=str_replace("_".$coluna."_","<a href='_link_' target='_blank' class='noblank'><strong>_".$coluna."_</strong></a>",$tbody);
                        if(isset($rule['valor']) && $rule['valor']!=""){
                            $tbody=str_replace("_link_",$rule['valor'],$tbody);
                        }
                        break;
                    case "func":
                        $tbody=str_replace("_".$coluna."_",$rule['valor']($valor),$tbody);
                        break;
                    case "cortaStr":
                        $tbody=str_replace("_".$coluna."_",cortaStr($valor,$rule['valor']),$tbody);
                        break;
                    case "date":
                        $tbody=str_replace("_".$coluna."_",strftime($rule['valor'], strtotime($valor)),$tbody);
                        break;
                    case "if":
                        $condicoes=explode(",,",$rule['valor']);
                        foreach ($condicoes as $condicao){
                            $explode=explode("=>",$condicao);
                            $condicao=$explode[0];
                            $resultado=$explode[1];
                            if($valor==$condicao){
                                $tbody=str_replace("_".$coluna."_",$resultado,$tbody);
                            }else{
                                if($condicao=="ELSE"){
                                    $tbody=str_replace("_".$coluna."_",$resultado,$tbody);
                                }
                            }
                        }
                        break;
                    default:
                        break;
                }
            }
        }


        $tbody=str_replace("_link_",$linkDasTabelas,$tbody);
    }
    return $tbody;
}


function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}


function listarDadosDaTabela($db,$nomeTabela,$nomeColuna,$innerjoin2,$add_sql,$cfg_dir,$tplTabela,$cfg_id_modulo,$linhaFuncionalidade,$pre_url,$id){
    include ("$cfg_dir");
    include ("../_igualEmTodasTabelas.php");
    $innerjoin=$innerjoin2;
    $tr=0;
    $sql="SELECT count(".$nomeTabela.".id_".$nomeColuna.") FROM ".$nomeTabela." $innerjoin WHERE 1 $add_sql";
    $result=runQ($sql,$db,"CONTAR RESULTADOS. $sql");
    while ($row = $result->fetch_assoc()) {
        $tr=$row['count('.$nomeTabela.'.id_'.$nomeColuna.')']; // total rows
    }
    if($tr>0){
        $paginacao="";
        include "../_paginacao.php";
        include "../_funcionalidades.php";


        $tbody="";

        $add_sql=str_replace("order by"," group by $nomeTabela.id_$nomeColuna order by",$add_sql);
        $add_sql.=" LIMIT ".(($pn-1)*$pr)." , $pr";
        $sql="SELECT * FROM $nomeTabela $innerjoin  WHERE 1 $add_sql";
        $result=runQ($sql,$db,"LOOP PELOS RESULTADOS");
        while ($row = $result->fetch_assoc()) {
            $tbody.=$linhaTD;

            /**colunas personalizadas **/

            if($nomeTabela=="utilizadores"){

                if($row['paga']==1){
                    $row['paga']="<label class=\"csscheckbox csscheckbox-primary\"><input id='paga".$row['id_grupo_utilizador']."' onclick='atualizarUtilizador(".$row['id_grupo_utilizador'].")' name='paga' checked value='1' type=\"checkbox\"><span></span></label>";
                }else{
                    $row['paga']="<label class=\"csscheckbox csscheckbox-primary\"><input id='paga".$row['id_grupo_utilizador']."' onclick='atualizarUtilizador(".$row['id_grupo_utilizador'].")' name='paga' value='1' type=\"checkbox\"><span></span></label>";
                }

                $campos_perfil=[
                    "contacto",
                    "contacto_alternativo",
                    "nif",
                    "morada",
                    "cod_post",
                    "localidade",
                    "sexo",
                    "data_nascimento",
                ];
                $row['perfil']="<b class='text-danger'>0%</b>";
                $preenchidos=0;
                foreach ($campos_perfil as $campo){
                    if($row[$campo]!=""){
                        $preenchidos++;
                    }
                }
                $cor="danger";
                if($preenchidos==count($campos_perfil)){
                    $cor="success";
                }
                $preenchido=round($preenchidos*100/count($campos_perfil));
                $row['perfil']="<b class='text-$cor'>$preenchido%</b>";


                //pago
                $sql2="select * from orcamentos_grupos where ativo=1 and id_grupo='".$row['id_grupo']."'";
                $result2=runQ($sql2,$db,"preencher dados do cliente");
                while ($row2 = $result2->fetch_assoc()) {
                    $row['id_orcamento']=$row2['id_orcamento'];
                }

                $por_pessoa=0;
                $pago=0;
                $sql2="select * from orcamentos_fornecedores inner join fornecedores on orcamentos_fornecedores.id_fornecedor=fornecedores.id_fornecedor where id_orcamento='".$row['id_orcamento']."' and ativo=1 order by fornecedores.id_fornecedor desc";
                $result2=runQ($sql2,$db,1);
                while ($row2 = $result2->fetch_assoc()) {
                    $por_pessoa+=$row2["por_pessoa"];

                    $sql3="select * from orcamentos_fornecedores_pagamentos where id_fornecedor='".$row2['id_fornecedor']."' and id_utilizador='".$row['id_utilizador']."'";
                    $result3=runQ($sql3,$db,1);
                    while ($row3 = $result3->fetch_assoc()) {
                        $pago+=$row3["pago"];
                    }
                }

                $sql2="select * from orcamentos where id_orcamento='".$row['id_orcamento']."'";
                $result2=runQ($sql2,$db,1);
                while ($row2 = $result2->fetch_assoc()) {
                    $from = new DateTime($row['data_nascimento']);
                    $to   = new DateTime($row2['partida']);
                    $to2   = new DateTime($row2['chegada']);
                    $idade_partida = $from->diff($to)->y;
                    $idade_chegada = $from->diff($to2)->y;

                    if($idade_chegada>$idade_partida){
                        $idade="
<small>
                        Partida: $idade_partida anos<br>
                        Chegada: <b class='text-danger'>$idade_chegada</b> anos
                        </small>
                        ";
                    }else{
                        $idade="
<small>
                        Partida: $idade_partida anos<br>
                        Chegada: $idade_chegada anos
                        </small>
                        ";
                    }
                    $row['data_nascimento']=date("d/m/Y",strtotime($row['data_nascimento']))."<br> $idade";
                }

                $cor="danger";
                if($por_pessoa==$pago){
                    $cor="success";
                }
                if($por_pessoa==0){
                    $percentagem=0;
                }else{
                    $percentagem=round($pago*100/$por_pessoa);
                }



                $row['pago']="<a class='btn btn-xs btn-default text-right' href='javascript:void(0)' onclick='abrirModalPagar(\"".$row['id_utilizador']."\",\"".$row['id_orcamento']."\",this)'><b class='text-$cor'>$percentagem%</b></a>";
            }

            if($nomeTabela=="fornecedores"){
                //pago
                $total_pago=0;
                $utilizadores=0;
                $sql2="select * from orcamentos_grupos
                      inner join orcamentos_grupos_utilizadores on orcamentos_grupos_utilizadores.id_grupo=orcamentos_grupos.id_grupo
                      inner join utilizadores on utilizadores.id_utilizador=orcamentos_grupos_utilizadores.id_utilizador
                      where utilizadores.ativo=1 and orcamentos_grupos.ativo=1 and id_orcamento='".$row['id_orcamento']."' ";
                $result2=runQ($sql2,$db,"preencher contar utilizadores");
                while ($row2 = $result2->fetch_assoc()) {
                    $sql3="select * from orcamentos_fornecedores_pagamentos where id_fornecedor='".$row['id_fornecedor']."' and id_utilizador='".$row2['id_utilizador']."'";
                    $result3=runQ($sql3,$db,1);
                    while ($row3 = $result3->fetch_assoc()) {
                        $pago=$row3['pago'];
                    }
                    if($pago==""){
                        $pago=0;
                    }
                    $total_pago+=$pago;
                    $utilizadores++;
                }
                $apagar=$row['por_pessoa']*$utilizadores;
                $cor="danger";
                if($apagar==$total_pago){
                    $cor="success";
                }
                $percentagem=round($total_pago*100/$apagar);
                $row['pago']="<b class='text-$cor'>$percentagem%</b>";

            }

            /** FIM colunas personalizadas**/

            $tbody=rules_for_rows($rules_for_rows,$row,$tbody,$linkDasTabelas);
            foreach ($row as $coluna=>$valor){
                $tbody=str_replace("_".$coluna."_",$valor,$tbody);
            }

            $tbody=str_replace("_funcionalidades_",$funcionalidades,$tbody);
            if($subModulo==0){
                $tbody=str_replace("_idItem_",$row['id_'.$nomeColuna],$tbody);
            }else{
                $tbody=str_replace("_subItemID_",$row['id_'.$nomeColuna],$tbody);
                $tbody=str_replace("_idItem_",$idParent,$tbody);
            }
        }

        $resultados=str_replace("_tbody_",$tbody,$tplTabela);

    }else{
        $resultados="_semResultados_";
    }

    return [$resultados,$paginacao];
}


function getContrastColor($hexColor)
{

    // hexColor RGB
    $R1 = hexdec(substr($hexColor, 1, 2));
    $G1 = hexdec(substr($hexColor, 3, 2));
    $B1 = hexdec(substr($hexColor, 5, 2));

    // Black RGB
    $blackColor = "#000000";
    $R2BlackColor = hexdec(substr($blackColor, 1, 2));
    $G2BlackColor = hexdec(substr($blackColor, 3, 2));
    $B2BlackColor = hexdec(substr($blackColor, 5, 2));

    // Calc contrast ratio
    $L1 = 0.2126 * pow($R1 / 255, 2.2) +
        0.7152 * pow($G1 / 255, 2.2) +
        0.0722 * pow($B1 / 255, 2.2);

    $L2 = 0.2126 * pow($R2BlackColor / 255, 2.2) +
        0.7152 * pow($G2BlackColor / 255, 2.2) +
        0.0722 * pow($B2BlackColor / 255, 2.2);

    $contrastRatio = 0;
    if ($L1 > $L2) {
        $contrastRatio = (int)(($L1 + 0.05) / ($L2 + 0.05));
    } else {
        $contrastRatio = (int)(($L2 + 0.05) / ($L1 + 0.05));
    }

    // If contrast is more than 5, return black color
    if ($contrastRatio > 5) {
        return '#000000';
    } else {
        // if not, return white color.
        return '#FFFFFF';
    }
}

// Função para dar string replace ao nth ocorrencia

function str_replace_nth($search, $replace, $subject, $occurrence)
{
    $found = preg_match_all('/'.preg_quote($search).'/', $subject, $matches, PREG_OFFSET_CAPTURE);
    if (false !== $found && $found > $occurrence) {
        return substr_replace($subject, $replace, $matches[0][$occurrence][1], strlen($search));
    }
    return $subject;
}

function str_replace_first($from, $to, $content)
{
    $from = '/'.preg_quote($from, '/').'/';

    return preg_replace($from, $to, $content, 1);
}




function encryptSimples($data, $size)
{
    $length = $size - strlen($data) % $size;
    return $data . str_repeat(chr($length), $length);
}


function rand_string( $length ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    $size = strlen( $chars );
    for( $i = 0; $i < $length; $i++ ) {
        $str .= $chars[ rand( 0, $size - 1 ) ];
    }

    return $str;
}

function checkTime(){
    global $db;
    $sql="SELECT * FROM grupos  where id_grupo = ".$_SESSION['grupos'][0]." and ativo=1";
    $result=runQ($sql,$db,"VERIFICAR EXISTENTE");
    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();
        if($result['login_fim'] != "" && $result['login_fim'] != "") {
            $horarioGrupoInicio = explode(':', $result['login_inicio']);
            $horarioGrupoFim = explode(':', $result['login_fim']);
            $date = date('H:i');
            $date = explode(':', $date);

            $hora_inicio = $horarioGrupoInicio[0];
            $minuto_inicio = $horarioGrupoInicio[1];
            $hora_fim = $horarioGrupoFim[0];
            $minuto_fim = $horarioGrupoFim[1];

            $horaAtual = $date[0] + 1;
            $minutoAtual = $date[1];

            if( $horaAtual < $hora_inicio ||  $horaAtual == $hora_inicio && $minutoAtual < $minuto_inicio ||   $horaAtual > $hora_fim ||   $horaAtual == $hora_fim && $minutoAtual > $minuto_fim) {
                session_destroy();
                header("Refresh:0;");
            }
        }
    }

}



function getCamposObrigatorios($nome_tabela){
    global $db;
    $campos = [];
    $sql="DESCRIBE $nome_tabela;";
    $result=runQ($sql,$db,"obter estrutura da tabela");
    while ($row = $result->fetch_assoc()) {
        if ($row['Null'] == "NO"){
            array_push($campos, $row['Field']);
        }

    }
    return $campos;
}



function guidv4($data = null) {
    if (function_exists('com_create_guid') === true)
        return trim(com_create_guid(), '{}');

    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function countInfoTabela($tabela, $addsql="", $comment="", $FirstKey= "", $toPrint = 0){
    global $db;

    $sql="SELECT count(*) as count FROM $tabela  where 1  $addsql";
    if($toPrint==1){
        return $sql;
    }
    $result=runQ($sql,$db,$comment);
    $result = $result -> fetch_assoc();
    return $result['count'];
}


/*
function getInfoTabela($tabela, $addsql="", $comment="", $FirstKey= "", $tabelaPersonalizadaSecondKey = "", $colunas = "*", $toPrint = 0){
    global $db;
    $infoQuery = array();

    $sql="SELECT $colunas FROM $tabela  where 1  $addsql";
    if($toPrint==1){
        return $sql;
    }
    $result=runQ($sql,$db,$comment);
    while($return = $result -> fetch_assoc()){
        if($FirstKey != ""){

            // APENAS ELA PLATAFORMA

            $sql="SELECT count(*) as count FROM $tabela  where 1 and $FirstKey = '".$return[$FirstKey]."' and $FirstKey <> '' and ativo = 1";
            $result2=runQ($sql,$db,$comment);
            $return2 = $result2 -> fetch_assoc();
            if($return2['count'] > 1){
                if($tabelaPersonalizadaSecondKey != ""){
                    $infoQuery[$return[$FirstKey]][$return[$tabelaPersonalizadaSecondKey]] = $return;
                }else{
                    $infoQuery[$return[$FirstKey]][] = $return;
                }

            }else{
                $infoQuery[$return[$FirstKey]] = $return; // Colocar igual
            }

        }else{
            array_push($infoQuery, $return);
        }

    }

    return $infoQuery;

}*/


function getInfoTabela($tabela, $addsql="", $comment="", $FirstKey= "", $tabelaPersonalizadaSecondKey = "", $colunas = "",$arraySimples = "0", $distinct = "", $toPrint = 0, $innerjoin=""){
    global $db;
    $infoQuery = array();

    if($distinct == 1){
        $distinct = "distinct";
    }
    if($colunas == ""){
        $colunas="*";
    }

    $sql="SELECT $distinct $colunas FROM $tabela $innerjoin where 1  $addsql";

    if($toPrint==1){
        return $sql;
    }

    $result99=runQ($sql,$db,$comment);
    while($return = $result99 -> fetch_assoc()){

        if($FirstKey != ""){

            // APENAS ELA PLATAFORMA
            $addsql2="";
            if(isset($return['ativo'])){
                $addsql2 = 'and ativo = 1';
            }

            //$sql="SELECT count(*) as count FROM $tabela  where 1 and $FirstKey = '".$return[$FirstKey]."' and $FirstKey <> '' $addsql2";
            //print_r($sql);die;
            //$result2=runQ($sql,$db,$comment);
            //$return2 = $result2 -> fetch_assoc();
            // if($return2['count'] > 1){
            if($tabelaPersonalizadaSecondKey != ""){
                $infoQuery[$return[$FirstKey]][$return[$tabelaPersonalizadaSecondKey]] = $return;
            }else{
                $infoQuery[$return[$FirstKey]][] = $return;
            }

            /* }else{
                 $infoQuery[$return[$FirstKey]] = $return; // Colocar igual
             }*/

        }else{
            if($arraySimples == 0){ // Exemplo [0 , 1, 2, 3];
                array_push($infoQuery, $return);
            }else{
                array_push($infoQuery, $return[$colunas]); // Exemplo [0 => '1' , 1 => '2']
            }

        }

    }

    return $infoQuery;

}


function getInfoTabelaExterna($tabela, $addsql=""){
    $dbExterna=ligarBDexterna('vittawood.ddns.net:3308','root','xd','vittadb') or die('falhou');
    print_r($dbExterna);die;

    $infoQuery = array();

    $sql="SELECT * FROM $tabela  where 1  $addsql";


    $result=runQ($sql,$dbExterna,"VERIFICAR EXISTENTE - Funcoes");
    while($return = $result -> fetch_assoc()){
        array_push($infoQuery, $return);
    }

    return $infoQuery;
}



/** UPDATES AND INSERTS  */




/** INSERT */
function insertIntoTabela($tabela, $cols, $vals, $toPrint = 0){

    global $db;
    $sql="Insert into $tabela ($cols) VALUES ($vals) ";
    if($toPrint==1){
        return $sql;
    }
    if($result=runQ($sql,$db,"Insert - ".$sql)){
        return $db->insert_id;
    }
    return false;

}

function insertIntoTabelaExterna($tabela, $cols, $vals){

    $dbExterna=ligarBDexterna('vittawood.ddns.net:3308','root','xd','vittadb') or die('falhou');
    $sql="Insert into $tabela ($cols) VALUES ($vals) ";

    if($result=runQ($sql,$dbExterna,"Insert externo - Funcoes")){
        return $dbExterna->insert_id;
    }
    return false;

}
/** END INSERT */

/** UPDATE */
function UpdateTabela($tabela, $insert_cols_vals, $addsql, $toPrint = 0){

    global $db;
    $sql = "update $tabela set $insert_cols_vals where 1 $addsql";
    if($toPrint==1){
        return $sql;
    }
    if($result=runQ($sql,$db,"Update Tabela - Funcoes")){
        if(mysqli_affected_rows($db) >0 ){
            return true;
        }
    }
    return false;

}

function UpdateTabelaExterna($tabela, $insert_cols_vals, $addsql){

    $dbExterna=ligarBDexterna('vittawood.ddns.net:3308','root','xd','vittadb') or die('falhou');
    $sql = "update $tabela set $insert_cols_vals where 1 $addsql";
    /* print $sql;
     return $sql;
     die; */
    if($result=runQ($sql,$dbExterna,"Update Tabela - Funcoes")){
        if(mysqli_affected_rows($dbExterna) >0 ){
            return true;
        }
    }
    return false;

}

/** END UPDATE */

/** END UPDATES AND INSERTS */

/** ORGANIZERS */

/* GET COLUNAS */
function getColunas($tabela, $columnsToIgnore=[], $extraColumns=[] , $inArray=0, $comment = ""){
    global $db;
    $colunas = array();

    if(!is_array($columnsToIgnore)){
        $arrayColumnsToIgnore =  explode(',',$columnsToIgnore);
        $columnsToIgnore = [];
        $arrayColumnsToIgnore = str_replace(' ','', $arrayColumnsToIgnore);

        foreach($arrayColumnsToIgnore as $column){

            array_push($columnsToIgnore, $column);
        }

    }

    if(!is_array($extraColumns)){

        $extraColumns =  explode(',',$extraColumns);

    }


    $sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tabela' ORDER BY ORDINAL_POSITION";

    $result=runQ($sql,$db,$comment);
    while($return = $result -> fetch_assoc()){

        if(!in_array($return['COLUMN_NAME'], $columnsToIgnore) ) {

            array_push($colunas,$return['COLUMN_NAME']);

        }
    }


    foreach($extraColumns as $extraColumn){
        $colunas[]=$extraColumn;
    }

    if($inArray==0){
        $colunasSepPorVirgula="";
        foreach($colunas as $coluna){
            $colunasSepPorVirgula.= $coluna . ',';
        }
        $colunasSepPorVirgula = substr($colunasSepPorVirgula, 0, -1);
        return $colunasSepPorVirgula;
    }

    return $colunas;
}

/** INSERT ORGANIZER */
function organizeDataInserts($data, $columnsToIgnore=[], $extraColumns=[]){
    $columns="";
    $values="";

    if(!is_array($columnsToIgnore)){
        $arrayColumnsToIgnore =  explode(',',$columnsToIgnore);
        $columnsToIgnore = [];
        $arrayColumnsToIgnore = str_replace(' ','', $arrayColumnsToIgnore);

        foreach($arrayColumnsToIgnore as $column){

            array_push($columnsToIgnore, $column);
        }

    }


    if(!is_array($extraColumns)){

        $arrayextraColumnsTemp =  explode(',',$extraColumns);
        foreach($arrayextraColumnsTemp as $extracolumn ){

            list($k, $v) = explode('=>', $extracolumn);
            $k = str_replace(' ','', $k);
            $extraColumns[ $k ] = $v;
        }

    }


    foreach($extraColumns as $col => $val){
        $data[$col] = $val;
    }

    foreach($data as $col => $val) {

        if($val != "" && !in_array($col, $columnsToIgnore) ||  searchForKey($col, $extraColumns)) {

            $columns .= $col . ',';
            $values .= '"' . $val . '",';

        }

    }

    $columns = substr($columns, 0, -1);
    $values = substr($values, 0, -1);

    return array($columns, $values);

}

/** UPDATE ORGANIZER */

function organizeDataUpdates($data, $columnsToIgnore=[], $extraColumns=[]){

    $col = "";
    $val = "";
    $insert_cols_vals= "";

    foreach($data as $col => $val) {
        if(!in_array($col, $columnsToIgnore)) {
            $insert_cols_vals .= "$col='$val', "; // FOR UPDATE
        }
    }

    $insert_cols_vals = substr($insert_cols_vals, 0, -2);
    return $insert_cols_vals;
}


/** END UPDATE ORGANIZER */

/** END ORGANIZERS */




function randombytes($length = 6)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $characters_length = strlen($characters);
    $output = '';
    for ($i = 0; $i < $length; $i++)
        $output .= $characters[rand(0, $characters_length - 1)];

    return $output;
}



function searchForKey($keyToSearch, $array) {
    foreach ($array as $key => $value) {

        if ( $key == $keyToSearch ) {
            return $key;
        }
    }
    return null;
}


function searchForValue($valueToSearch, $array) {
    foreach ($array as $key => $value) {

        if ( $value == $valueToSearch ) {
            return $value;
        }
    }
    return null;
}


function convertToHoursMins($time, $format = '%2d:%2d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);


    if($hours == "1"){
        $format=str_replace('horas', 'hora',$format);
    }

    if($minutes == "1"){
        $format=str_replace('minutos', 'minuto',$format);
    }


    return sprintf($format, $hours, $minutes);
}


function getComentarios2($modulo,$id_item, $id_comentario=0)
{
    global $db;

    $domain = ((@$_SERVER['HTTP_HOST']));
    $add_sql = "";
    if ($id_comentario != 0) {
        $add_sql .= " and id_nota='$id_comentario'";
    }


    if($modulo=='srv_clientes'){
        $id_cliente=$db->escape_string($id_item);
        $sql="select FederalTaxID from srv_clientes where PartyID='$id_cliente'";
        $result=runQ($sql,$db,"SELECT INSERTED");
        while ($row = $result->fetch_assoc()) {
            $id_item=$row['FederalTaxID'];
        }
    }

    $comentarios=[];
    $sql="select * from srv_clientes_notas 
where modulo='$modulo' and id_item='$id_item' and comentario=1 and ativo=1 $add_sql order by srv_clientes_notas.created_at desc";
    $result=runQ($sql,$db,"get comments de $modulo $id_item");
    while ($row = $result->fetch_assoc()) {



        $utilizadorCriou = getInfoTabela('utilizadores', " and id_utilizador='" . $row['id_criou'] . "'");
        $nome_utilizador = "";

        $foto = "";
        if(isset($utilizadorCriou[0])) {
            $nome_utilizador = $utilizadorCriou[0]['nome_utilizador'];
            $foto = "https://".$domain."/_contents/fotos_utilizadores/" . $utilizadorCriou[0]['foto'];
        }

        $dir="../_contents/srv_clientes_notas/".$row['id_nota'];
        $ficheiros=mostraFicheiros($dir);

        $attachments=[];
        $c=1;
        foreach ($ficheiros as $f){
            $a=array();
            $a['id']=$c;
            $a['file']="https://".$domain."/$dir/$f";
            $a['mime_type']=mime_content_type("$dir/$f");
            $attachments[]=$a;
            $c++;
        }

        $pings=json_decode($row['pings'],true);
        if(is_array($pings)){
            foreach ($pings as $id=>$nome){
                $row['descricao']=str_replace("@$id ","@$nome ",$row['descricao']);
            }
        }else{
            $pings=[];
        }

        if($row['parent']==0){
            $row['parent']=null;
        }

        $created_by_current_user=false;
        if($row['id_criou']==$_SESSION['id_utilizador']){
            $created_by_current_user=true;
        }

        $c=array();
        $c['id']=$row['id_nota'];
        $c['parent']=$row['parent'];
        $c['created']=$row['created_at'];
        $c['modified']=$row['updated_at'];
        $c['content']=$row['descricao'];
        $c['attachments']=$attachments;
        $c['pings']=$pings;
        //$c['creator']=$nome_utilizador;
        $c['fullname']=$nome_utilizador;
        $c['profile_picture_url']=$foto;
        $c['created_by_current_user']=$created_by_current_user;

        $comentarios[]=$c;
    }

    return $comentarios;
}



function secondsToHoursAndMinutes($seconds){

    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds / 60) % 60);

    if($hours < 10){
        $hours='0'.$hours;
    }

    if($minutes< 10){
        $minutes='0'.$minutes;
    }

    $tempo = $hours.'h:'.$minutes.'m';

    return $tempo;
}



function GerarPdfAssistencia($id){

    global $db;

    $nome_empresa = $_SESSION['cfg']['nomeEmpresa'];

    $assistencia_cliente = getInfoTabela('assistencias_clientes', "and id_assistencia_cliente = '$id'");
    $assistencia_cliente = $assistencia_cliente[0];


    $cliente = getInfoTabela('srv_clientes', " and id_cliente='" . $assistencia_cliente['id_cliente'] . "'");
    $cliente = $cliente[0];
    $nome_cliente = $cliente['OrganizationName'];

    $tecnico = getInfoTabela('utilizadores', " and id_utilizador='" . $assistencia_cliente['id_utilizador'] . "'");
    $tecnico = $tecnico[0];

    $assistencia_cliente_maquinas = getInfoTabela('assistencias_clientes_maquinas', " and id_assistencia_cliente='" . $assistencia_cliente['id_assistencia_cliente'] . "' and ativo = 1");

    $contrato = getInfoTabela('clientes_contratos', "and id_contrato='" . $assistencia_cliente['id_contrato'] . "'");

    $nome_contrato="Nenhum";
    if(isset($contrato[0])) {
        $contrato=$contrato[0];
        $nome_contrato = $contrato['nome_contrato'];

        $tempo_restante = secondsToTime($contrato['segundos_restantes']);
    }

    $info_pacote_horas = '
             <h3 style="color:#000000;margin-bottom: 2px ">Contrato de horas utilizado</h3><br>
            <p style="margin-top: 2px;">
             <b>'.$nome_contrato.'</b><br>'.$tempo_restante.'
            </p>';


    if($assistencia_cliente['externa']==1){
        $label_assinatura="Assinatura";
    }else{
        $label_assinatura="Assinatura";
    }


    $assinatura = $_SERVER['DOCUMENT_ROOT']."/_contents/assistencias_clientes/assinatura_" . $assistencia_cliente['id_assistencia_cliente'] . "/assinatura.jpg";
    $assinatura = "<img src='$assinatura' style='width: 200px'>";

    $pagina = '
<style>
    .title{
        height: 50px;
        width: 100%;
        background: #000000;
        text-align: center;
        color:#00000;
    }
    .subtitle{
        color: #00000;
    }
    h1, h2, h3{
        font-weight: lighter;
    }

    .table {
        border-collapse: collapse;
        width: 100%;
     
    }
    
    td{
     border-collapse: collapse;
     padding: 0;
     border-radius:16px;
    }
    
  
    
    .centered_mb .table_mubtibanco{
        text-align: left;
        margin-left: 40px;
    }

    .table-bordered th,.table-bordered td{border:1px solid #ddd !important}

</style>
<page backtop="25mm" backbottom="15mm" backleft="5mm" backright="5mm">
    <page_header>
        <table style="width: 100%;border-bottom: 1px solid #00000;    vertical-align: middle;">
            <tr>
                <td style="text-align: left;    width: 25%">
                    <small>Gerado por:<br>' . $tecnico['nome_utilizador'] . '<br>
                    </small>
                </td>
                <td style="text-align: center;    width: 50%"><b>Relatório de Serviço nº ' . $assistencia_cliente['nome_assistencia_cliente'] . '</b> <br><br> ' . $nome_cliente . '</td>
                <td style="text-align: right;    width: 25%"><img style="width: auto;height: 60px" src="../assets/layout/img/logo.png"></td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table style="width: 100%;">
            <tr>
                <td style="text-align: left;    width: 33%"></td>
                <td style="text-align: center;    width: 33%">
                 
</td>
                <td style="text-align: right;    width: 33%">Pág. [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
    
    <h3 style="text-align: center;margin-top: 20px;width: 100%;color:#00000"><b>Relatório de serviço nº' . $assistencia_cliente['nome_assistencia_cliente'] . '</b> </h3>
   
    <div style="text-align: center">
        <p> Intervenção realizada à entidade <b>"' . $nome_cliente . '"</b> por <b>' . $tecnico['nome_utilizador'] . '</b></p>
            <br>
     </div>         
     
      <table style="width: 100%;">
                        <tr>
                            <td style=" width: 100%;border:1px solid #C7C7C7;" >
                                <div  style="background-color: #C7C7C7;  width: 100%; height: 20px ; border-top-right-radius: 15px; border-top-left-radius: 15px;""><h5 style=" text-align: center; color:#000;">Descrição geral</h5></div>
                                
                                <table style="  width: 100%;">
                                
                                    <tbody style="width: 100%">
                                      <tr style="width: 100%">
                                        <td style="height: 140px; width: 100%;text-align: left;   vertical-align: top;">
                                           <div style="width: 100%;text-align: left;   vertical-align: top; padding:10px;"> ' . nl2br($assistencia_cliente['descricao']) . '</div>
                                        </td>
                                      </tr>
                                    </tbody>
                                                                    
                                </table>
                            </td>
                        </tr>
                        </table>
                    <br>
                    <br>       
        
        <h3 style="color:#00000;margin-bottom: 2px;text-align: center">Resumo tempos</h3><br>
        <table style="width: 100%">
            <tr>
                <td style="width: 14.28%;text-align:center">&nbsp;<br>Data Inicio</td>
                <td style="width: 14.28%;text-align:center">&nbsp;<br>Data Fim</td>
                <td style="width: 14.28%;text-align:center">&nbsp;<br>Tempo do serviço</td>
                <td style="width: 14.28%;text-align:center">Viagem<br><small>(ida e volta)</small></td>
                <td style="width: 14.28%;text-align:center">&nbsp;<br>Pausas</td>
                <td style="width: 14.28%;text-align:center">&nbsp;<br>Soma tempos</td>
                <td style="width: 14.28%;text-align:center">&nbsp;<br>Tempo contabilizado</td>
            </tr>
            <tr>
                <td style="text-align:center"><b>'.date("d/m/Y", strtotime($assistencia_cliente['data_inicio'])).'<br>'.date("H:i:s", strtotime($assistencia_cliente['data_inicio'])).'</b></td>
                <td style="text-align:center"><b>'.date("d/m/Y", strtotime($assistencia_cliente['data_fim'])).'<br>'.date("H:i:s", strtotime($assistencia_cliente['data_fim'])).'</b></td>
                <td style="text-align:center"><b>' . secondsToTime($assistencia_cliente['tempo_assistencia']) . '</b></td>
                <td style="text-align:center"><b>' . secondsToTime($assistencia_cliente['tempo_viagem']) . '</b><br><small>('.$assistencia_cliente['kilometros'].' KM)</small></td>
                <td style="text-align:center"><b>' . secondsToTime($assistencia_cliente['segundos_pausa']) . '</b></td>
                <td style="text-align:center"><b>' . secondsToTime(($assistencia_cliente['tempo_assistencia'] + $assistencia_cliente['tempo_viagem']-$assistencia_cliente['segundos_pausa'])) . '</b></td>
                <td style="text-align:center"><b>' . secondsToTime(($assistencia_cliente['tempo_contabilizar'])) . '</b></td>
            </tr>
        </table>
       <br>
       
     <div style="text-align: center">
       ' . $info_pacote_horas . '
       
    </div>
    


  <br>
    <br>
    <br>
     <div style="text-align: center">
            <b>'.$label_assinatura.'</b><br><br>
        ' . $assinatura . '<br><br>
        ' . $assistencia_cliente['nome_assinatura'] . '<br>
        ' . date("d/m/Y H:i", strtotime($assistencia_cliente['data_fim'])) . '
        </div>

     
    
  
        
  
    
    
 
</page>


_paginas_maquinas_

     ';


    $assistencias_clientes_maquinas = getInfoTabela('assistencias_clientes_maquinas', " and id_assistencia_cliente='" . $assistencia_cliente['id_assistencia_cliente'] . "'");

    $paginas_maquinas = "";
    foreach($assistencias_clientes_maquinas as $maquina) {

        $detalhes_maquina = getInfoTabela('maquinas', " and id_maquina = '" . $maquina['id_maquina'] . "'");
        $nome_maquina = "Eliminada";
        $ref = "";
        $numero_serie = "";

        if(isset($detalhes_maquina[0])) {
            $nome_maquina = $detalhes_maquina[0]['nome_maquina'];
            $ref = $detalhes_maquina[0]['ref'];
            $numero_serie = $detalhes_maquina[0]['numero_serie'];
            if($numero_serie != "") {
                $numero_serie = '/ ' . $numero_serie;
            }
        }


        $tarefas_efetuadas_titulo = "";


        $paginas_maquinas .= '
            <page backtop="25mm" backbottom="15mm" backleft="5mm" backright="5mm">
                <page_header>
                    <table style="width: 100%;border-bottom: 1px solid #00000;   vertical-align: middle;">
                        <tr>
                            <td style="text-align: left;    width: 25%">
                                <small>Gerado por:<br>' . $_SESSION['nome_utilizador'] . '<br>
                                </small>
                            </td>
                            <td style="text-align: center;    width: 50%"> <b>Relatório de Serviço nº' . $assistencia_cliente['nome_assistencia_cliente'] . '</b> <br> <br> ' . $nome_cliente . '</td>
                            <td style="text-align: right;    width: 25%"><img style="width: auto;height: 60px" src="../assets/layout/img/logo.png"></td>
                        </tr>
                    </table>
                </page_header>
                <page_footer>
                    <table style="width: 100%;;    vertical-align: middle;">
                        <tr>
                            <td style="text-align: left;    width: 33%"></td>
                            <td style="text-align: center;    width: 33%">
                       
            </td>
                            <td style="text-align: right;    width: 33%">Pág. [[page_cu]]/[[page_nb]]</td>
                        </tr>
                    </table>
                </page_footer>
                
                <h4 style="text-align: center;width: 100%;color:#00000"><b>Intervenção na Maquina <br>' . $nome_maquina . ' ( ' . $ref . ' )</b></h4> 
                   
                    
                      <table style="width: 100%;">
                        <tr>
                            <td style=" width: 100%;border:1px solid #C7C7C7;" >
                                <div  style="background-color: #C7C7C7;  width: 100%; height: 20px ; border-top-right-radius: 15px; border-top-left-radius: 15px;""><h5 style=" text-align: center; color:#000;">Defeito</h5></div>
                                
                                <table style="  width: 100%;">
                                
                                    <tbody style="width: 100%">
                                      <tr style="width: 100%">
                                        <td style="height: 140px; width: 100%;text-align: left;   vertical-align: top;">
                                           <div style="width: 100%;text-align: left;   vertical-align: top; padding:10px;"> ' . nl2br($maquina['defeitos']) . '</div>
                                        </td>
                                      </tr>
                                    </tbody>
                                                                    
                                </table>
                            </td>
                        </tr>
                    </table>
                    
                    <br>
                    
                    
                     <table style="width: 100%;">
                        <tr>
                            <td style=" width: 100%;border:1px solid #C7C7C7;" >
                                <div  style="background-color: #C7C7C7;  width: 100%; height: 20px ; border-top-right-radius: 15px; border-top-left-radius: 15px;""><h5 style=" text-align: center; color:#000;">Atividade</h5></div>
                                
                                <table style="  width: 100%;">
                                
                                    <tbody style="width: 100%">
                                      <tr style="width: 100%">
                                        <td style="height: 140px; width: 100%;text-align: left;   vertical-align: top;">
                                           <div style="width: 100%;text-align: left;   vertical-align: top; padding:10px;"> ' . nl2br($maquina['atividade']) . '</div>
                                        </td>
                                      </tr>
                                    </tbody>
                                                                    
                                </table>
                            </td>
                        </tr>
                    </table>
                    
                      <br>
                       <table style="width: 100%;">
                        <tr>
                            <td style=" width: 100%;border:1px solid #C7C7C7;" >
                                <div  style="background-color: #C7C7C7;  width: 100%; height: 20px ; border-top-right-radius: 15px; border-top-left-radius: 15px;""><h5 style=" text-align: center; color:#000;">Peças</h5></div>
                                
                                <table style="  width: 100%;">
                                
                                    <tbody style="width: 100%">
                                      <tr style="width: 100%">
                                        <td style="height: 140px; width: 100%;text-align: left;   vertical-align: top;">
                                           <div style="width: 100%;text-align: left;   vertical-align: top; padding: 10px"> ' . nl2br($maquina['descricao_pecas']) . '</div>
                                        </td>
                                      </tr>
                                    </tbody>
                                                                    
                                </table>
                            </td>
                        </tr>
                    </table>
                      <br>
                      <table style="width: 100%;">
                        <tr>
                            <td style=" width: 100%;border:1px solid #C7C7C7;" >
                                <div  style="background-color: #C7C7C7;  width: 100%; height: 20px ; border-top-right-radius: 15px; border-top-left-radius: 15px;""><h5 style=" text-align: center; color:#000;">Descrição</h5></div>
                                
                                <table style="  width: 100%;">
                                
                                    <tbody style="width: 100%">
                                      <tr style="width: 100%">
                                        <td style="height: 140px; width: 100%;text-align: left;   vertical-align: top;">
                                           <div style="width: 100%;text-align: left;   vertical-align: top; padding:10px;"> ' . nl2br($maquina['descricao']) . '</div>
                                        </td>
                                      </tr>
                                    </tbody>
                                                                    
                                </table>
                            </td>
                        </tr>
                    </table>
                    
                    
            
            </page>

 
   ';


    }



    $pagina = str_replace('_paginas_maquinas_', $paginas_maquinas, $pagina);

    $pagina = str_replace("_multibanco_", "", $pagina);
    $pagina = str_replace("_valorPendenteHtml_", "", $pagina);

    $dir = "../_contents/assistencias_clientes_pdfs/" . $assistencia_cliente['id_assistencia_cliente'];

    criar_dir($dir);

    //pdf sem dados de pagamento
    $nome_ficheiro_simplificado = "relatorio_servico_FILC_" . normalizeString($assistencia_cliente['nome_assistencia_cliente']) . ".pdf";

    if (file_exists("$dir/$nome_ficheiro_simplificado")) {
        unlink("$dir/$nome_ficheiro_simplificado");
    }

    guardarPDF($pagina, "$dir/$nome_ficheiro_simplificado");

    return $dir."/".$nome_ficheiro_simplificado;

    /**FALTA SUGERIR ADQUIRIR CONTRATO */

    /*$mensagem = "
        <p>Relatório de Assistencia nº " . $assistencia_cliente['id_assistencia_cliente'] . "</p>
    ";*/

    //enviar para resposavel de pagamentos
    // enviarEmail($empresa['id_conf_imap'],["$dir/$nome_ficheiro_simplificado"],"(NOT. PAGAMENTO) $nome_ticket","$mensagem_pagamentos",[$cliente['email_pagamentos']],$row['id_ticket'],[$empresa['email']],"","",["$dir/$nome_ficheiro_simplificado"]);



    //  enviarEmail(3, ["$dir/$nome_ficheiro_simplificado"], "Relório da Assistencia nº" . $assistencia_cliente['id_assistencia_cliente'], "$mensagem", ['sergio.bastos@petrovnetwork.com'], $cc, "", "", ["$dir/$nome_ficheiro_simplificado"]);

}

function incrementarTempo($tempo_inicial){
    $tempo_inicial_real=$tempo_inicial;
    $bloco=900; // 15 minutos
    $break_point=0; // 300 -> cinco minutos
    if($tempo_inicial<$bloco){
        $tempo_inicial=$bloco;
    }
    $tempo_final=0;
    while ($tempo_inicial>$break_point){
        $tempo_final+=$bloco;
        $tempo_inicial-=$bloco;
    }
    $restante=$tempo_inicial_real-$tempo_final;
    if($restante>0){
        $tempo_final+=$restante;
    }

    return $tempo_final;
}

function gerar_numero_assistencia(){
    //obter numero da ultima assistencia
    $ultima_assistencia=getInfoTabela('assistencias_clientes', " order by id_assistencia_cliente desc limit 0,1");

    $numero_ultima_assistencia=$ultima_assistencia[0]['nome_assistencia_cliente'];

    $ano_atual=date("Y",strtotime(current_timestamp));
    if($numero_ultima_assistencia==""){
        $numero_nova=1;
    }else{
        $numero_ultima_assistencia=explode("/",$numero_ultima_assistencia);
        if($ano_atual*1==$numero_ultima_assistencia[0]*1){
            $numero_nova=$numero_ultima_assistencia[1]*1+1;
        }else{
            $numero_nova=1;
        }
    }
    $numero_nova="$ano_atual/$numero_nova";
    return $numero_nova;
}


function timeToSeconts($time){
    $time=explode(":",$time);
    $segundos=0;
    $segundos+=$time[0]*60*60;
    $segundos+=$time[1]*60;
    $segundos+=$time[2];
    return $segundos;
}

function getListaMaquinasAssistencia($id_assistencia_cliente){
    $maquinas_cliente_linhas = getInfoTabela('assistencias_clientes_maquinas inner join maquinas using(id_maquina)',
        " and id_assistencia_cliente ='$id_assistencia_cliente' and assistencias_clientes_maquinas.ativo=1 ",'','',''
        ,'assistencias_clientes_maquinas.*, maquinas.nome_maquina,maquinas.ref, maquinas.descricao as descricao_maquina');

    $linhas_maquinas = "";
    foreach($maquinas_cliente_linhas as $maquina_cliente_linha){

        $maquina_cliente_linha['descricao_maquina'] = (strlen($maquina_cliente_linha['descricao_maquina']) > 60) ? substr($maquina_cliente_linha['descricao_maquina'],0,57).'...' : $maquina_cliente_linha['descricao_maquina'];
        $maquina_cliente_linha['defeitos'] = (strlen($maquina_cliente_linha['defeitos']) > 60) ? substr($maquina_cliente_linha['defeitos'],0,57).'...' : $maquina_cliente_linha['defeitos'];

        $garantia="";
        if($maquina_cliente_linha['garantia']==1){
            $garantia="<span class='label label-warning garantia-info'><i class='fa fa-warning'></i> Garantia</span>";
        }

        $concluido="";
        if($maquina_cliente_linha['concluido']==0){
            $concluido="<span class='label label-danger garantia-info'><i class='fa fa-warning'></i> Não Concluído</span>";
        }

        $revisao="";
        if($maquina_cliente_linha['revisao_periodica']==1){
            $revisao="<span class='label label-info garantia-info'>Revisão: ".number_format($maquina_cliente_linha['horas_revisao'],0,"",".")."h </span>";
        }

        $linhas_maquinas.=" 
     
        <div class='linha' onclick='OpenModalAddMaquina(this)' id_maquina='".$maquina_cliente_linha['id_maquina']."' id_assistencia_cliente_maquina='".$maquina_cliente_linha['id_assistencia_cliente_maquina']."'>
           <span>
               $garantia $concluido $revisao<br>
               <strong>".$maquina_cliente_linha['nome_maquina']."</strong> (".$maquina_cliente_linha['ref'].") <br> 
               <small class='text-muted'>Defeitos:</small><i class='text-info defeitos-info'> ".$maquina_cliente_linha['defeitos']."</i> <br>
               <small class='text-muted'>Obs:</small><i class='text-info'> ".$maquina_cliente_linha['descricao_maquina']."</i> <br>
                
            </span> 
          
           <a  href='#'>  <i class='fa fa-play'></i> </a> 
        </div>
  
     ";

    }

    return $linhas_maquinas;
}

function tres_simples($a,$b,$c){

    // A ----- B
    // C ------?
    // returns ? value

    return $c*$b/$a;
}

// Comparison function
function seconds_compare($element1, $element2) {
    $seconds1 = ($element1['seconds']);
    $seconds2 = ($element2['seconds']);
    return $seconds2 - $seconds1;
}