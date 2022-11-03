<?php

//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!!!!!!!!!!!IMPORTANTE!!!!!!!!!!!!!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// esta funcionalidade não foi testada
// falta adicionar a funcionalidade ao
// módulo dos utilizadores e definir como
// "Suporta vários itens".
include ('../_template.php');
$content=file_get_contents($layoutDirectory."/loading.tpl");

/**
 * acao vários itens
 */
if(isset($_POST['checkboxes'])) {
    
    $checkboxes=($_POST['checkboxes']);
    foreach ($checkboxes as $checkbox){
        $checkbox=$db->escape_string($checkbox);

        $sql="select * from utilizadores where id_utilizador<>1 and id_utilizador<>2 and id_utilizador='$checkbox'";
        $result=runQ($sql,$db,"1");
        if($result->num_rows!=0){
            while ($row = $result->fetch_assoc()) {
                $nome=$row['nome_utilizador'];
                $ativo=$row['ativo'];
            }

            $sql="select email,pass_inicial from utilizadores where id_utilizador='$checkbox'";
            $result=runQ($sql,$db,7);
            while ($row = $result->fetch_assoc()){
                $email=$row['email'];
                $passInicial=$row['pass_inicial'];
            }

            //novo token
            $token=md5(time().$email);
            $sql="update utilizadores set verification_token='$token' where id_utilizador='$checkbox'";
            $result=runQ($sql,$db,8);
            $emailTpl=file_get_contents("../assets/email/email.tpl");
            $emailTpl=str_replace("_conteudo_",file_get_contents("../assets/email/verificar.tpl"),$emailTpl);
            $emailTpl=str_replace("_nomeEmpresa_",$cfg_nomeEmpresa,$emailTpl);
            $emailTpl=str_replace("_email_",$email,$emailTpl);
            if($passInicial!=""){
                $emailTpl=str_replace("_pass_",$passInicial,$emailTpl);
            }else{
                $emailTpl=str_replace("_pass_","(desconhecido)",$emailTpl);
            }
            $emailTpl=str_replace("_moradaEmpresa_",$cfg_moradaEmpresa,$emailTpl);
            $emailTpl=str_replace("_siteEmpresa_",$cfg_siteEmpresa,$emailTpl);

            $emailTpl=str_replace("_copyAno_",date("Y"),$emailTpl);
            $emailTpl=str_replace("_copySite_",$cfg_copySite,$emailTpl);
            $emailTpl=str_replace("_nomePlataforma_",$cfg_nomePlataforma,$emailTpl);
            $emailTpl=str_replace("_copyPlataforma_",$cfg_copyPlataforma,$emailTpl);
            $actual_link=str_replace("utilizadores/enviar_email.php?id=$checkbox","login/verificar_conta.php?token=$token",$actual_link);
            $actual_link=str_replace("utilizadores/enviar_email.php?cod=1&id=$checkbox","login/verificar_conta.php?token=$token",$actual_link);
            $emailTpl=str_replace("_recoveryURL_",$actual_link,$emailTpl);
            $mensagem=$emailTpl;
            $anexos=0;
            $assunto="Ativação da conta";
            $destinatarios=[$email];
            $resultados=enviarEmail($anexos,$assunto,$mensagem,$destinatarios);
            foreach ($resultados as $resultado){
                foreach ($destinatarios as $destinatario){
                    if($resultado['destinatario']==$destinatario){
                        $estadoEnvio=$resultado['output'];
                        if($estadoEnvio==0){
                            //sucesso
                        }else{
                            if(isset($_GET['cod'])){
                                if($_GET['cod']==1) {
                                     //sucesso
                                }
                            }
                        }
                    }
                }
            }

            $textoLog="Enviou email boas vindas e de verificação $nome.<br>
                            ID: $checkbox<br>
                            EMAIL: $email<br>
                       Endereço ip: ".$_SERVER['REMOTE_ADDR']."<br>";
            $textoLog=$db->escape_string($textoLog);

            $sql ="INSERT INTO utilizadores_logs (data_log,texto,id_utilizador) VALUES ('".current_timestamp."','$textoLog','".$_SESSION['id_utilizador']."')";
            $result=runQ($sql,$db,4);
        }else{
            exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Lamentamos mas não pode aceder a esta página sem fornecer todos os dados necessários.",""));
        }

    }
    include('../_autoData.php');
    print "<script>window.history.back();</script>";
    
    die();
}else{
    include('../_autoData.php');
    print "<script>window.history.back();</script>";
}


/**
 * acao iten único
 */

if(isset($_GET['id'])) {
    
    $id=$db->escape_string($_GET['id']);

    $sql="select * from utilizadores where id_utilizador<>1 and id_utilizador<>2 and id_utilizador='$id'";
    $result=runQ($sql,$db,"1");
    if($result->num_rows!=0){
        while ($row = $result->fetch_assoc()) {
            $nome=$row['nome_utilizador'];
            $ativo=$row['ativo'];
        }

        $sql="select email,pass_inicial from utilizadores where id_utilizador='$id'";
        $result=runQ($sql,$db,7);
        while ($row = $result->fetch_assoc()){
            $email=$row['email'];
            $passInicial=$row['pass_inicial'];
        }

        //novo token
        $token=md5(time().$email);
        $sql="update utilizadores set verification_token='$token' where id_utilizador='$id'";
        $result=runQ($sql,$db,8);
        $emailTpl=file_get_contents("../assets/email/email.tpl");
        $emailTpl=str_replace("_conteudo_",file_get_contents("../assets/email/verificar.tpl"),$emailTpl);
        $emailTpl=str_replace("_nomeEmpresa_",$cfg_nomeEmpresa,$emailTpl);
        $emailTpl=str_replace("_email_",$email,$emailTpl);
        if($passInicial!=""){
            $emailTpl=str_replace("_pass_",$passInicial,$emailTpl);
        }else{
            $emailTpl=str_replace("_pass_","(desconhecido)",$emailTpl);
        }
        $emailTpl=str_replace("_moradaEmpresa_",$cfg_moradaEmpresa,$emailTpl);
        $emailTpl=str_replace("_siteEmpresa_",$cfg_siteEmpresa,$emailTpl);

        $emailTpl=str_replace("_copyAno_",date("Y"),$emailTpl);
        $emailTpl=str_replace("_copySite_",$cfg_copySite,$emailTpl);
        $emailTpl=str_replace("_nomePlataforma_",$cfg_nomePlataforma,$emailTpl);
        $emailTpl=str_replace("_copyPlataforma_",$cfg_copyPlataforma,$emailTpl);
        $actual_link=str_replace("utilizadores/enviar_email.php?id=$id","login/verificar_conta.php?token=$token",$actual_link);
        $actual_link=str_replace("utilizadores/enviar_email.php?cod=1&id=$id","login/verificar_conta.php?token=$token",$actual_link);
        $emailTpl=str_replace("_recoveryURL_",$actual_link,$emailTpl);
        $mensagem=$emailTpl;
        $anexos=0;
        $assunto="Ativação da conta";
        $destinatarios=[$email];
        $resultados=enviarEmail($anexos,$assunto,$mensagem,$destinatarios);
        foreach ($resultados as $resultado){
            foreach ($destinatarios as $destinatario){
                if($resultado['destinatario']==$destinatario){
                    $estadoEnvio=$resultado['output'];
                    if($estadoEnvio==0){
                        //sucesso
                    }else{
                        if(isset($_GET['cod'])){
                            if($_GET['cod']==1) {
                                //sucesso
                            }
                        }
                    }
                }
            }
        }

        $textoLog="Enviou email boas vindas e de verificação $nome.<br>
                            ID: $id<br>
                            EMAIL: $email<br>
                       Endereço ip: ".$_SERVER['REMOTE_ADDR']."<br>";
        $textoLog=$db->escape_string($textoLog);

        $sql ="INSERT INTO utilizadores_logs (data_log,texto,id_utilizador) VALUES ('".current_timestamp."','$textoLog','".$_SESSION['id_utilizador']."')";
        $result=runQ($sql,$db,4);
    }else{
        exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Lamentamos mas não pode aceder a esta página sem fornecer todos os dados necessários.",""));
    }
    
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Lamentamos mas não pode aceder a esta página sem fornecer todos os dados necessários.",""));
}

include ('../_autoData.php');