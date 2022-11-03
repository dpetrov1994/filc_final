<?php
$email=$_POST['reminder-email'];
$erros=0;
if($email==""){
    $erros++;
}
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if($erros==0){
    $db=ligarBD("Recuperar email");

    $email=$db->escape_string($email);
    $sql ="SELECT * FROM utilizadores WHERE email='$email'";
    $result=runQ($sql,$db,1);

    if($result->num_rows==1){
        while($row = $result->fetch_assoc()){
            $id_utilzador=$row['id_utilizador'];
            $verificado=$row['verificado'];
            $ativo=$row['ativo'];
        }

        if($ativo==1){
            criarLog($db,"utilizadores","id_utilizador",$id_utilzador,"Pedido de recuperação de palavra-passe.",null);

            if($verificado==0){
                //utilizador não verificado
                $location="recuperar.php?cod=1&email=$email";
            }else{
                $sql="update utilizadores_recuperacao set ativo=0 where id_utilizador=$id_utilzador";
                $result=runQ($sql,$db,3);

                $dataExpira=$new_time = date("Y-m-d H:i:s", strtotime('+24 hours'));
                $token=md5(date("Y-m-d H:i:s"));
                $sql="INSERT INTO utilizadores_recuperacao (token,data_expira,id_utilizador) values ('$token','$dataExpira','$id_utilzador')";
                $result=runQ($sql,$db,3);
                $emailTpl=file_get_contents("../assets/email/email.tpl");
                $emailTpl=str_replace("_conteudo_",file_get_contents("../assets/email/recuperar_pass.tpl"),$emailTpl);
                $emailTpl=str_replace("_nomeEmpresa_",$cfg_nomeEmpresa,$emailTpl);
                $emailTpl=str_replace("_mora_",$cfg_mora,$emailTpl);
                $emailTpl=str_replace("_siteEmpresa_",$cfg_siteEmpresa,$emailTpl);
                $emailTpl=str_replace("_copyPlataforma_",$cfg_copyPlataforma,$emailTpl);
                $emailTpl=str_replace("_copyAno_",date("Y"),$emailTpl);
                $emailTpl=str_replace("_copySite_",$cfg_copySite,$emailTpl);
                $emailTpl=str_replace("_nomePlataforma_",$cfg_nomePlataforma,$emailTpl);

                $actual_link=str_replace("recuperar.php","recuperar_pass.php?utilizador=$id_utilzador&token=$token",$actual_link);
                $emailTpl=str_replace("_recoveryURL_",$actual_link,$emailTpl);
                $mensagem=$emailTpl;
                $anexos=0;
                $assunto="Recuperação de palavra-passe.";
                $destinatarios=[$email];
                $estadoEmail=enviarEmail($anexos,$assunto,$mensagem,$destinatarios);
                if($estadoEmail[0]['email']!=0){
                    $location="recuperar.php?cod=6";
                }else{
                    $location="recuperar.php?cod=5&email=$email"; //sucesso
                }
            }
        }else{
            //utilizador desativo
            $location="recuperar.php?cod=2";
        }
    }else{
        //email ou senha incorertos ou utilizador não existente
        $location="recuperar.php?cod=3";
    }

    $db->close();
}else{
    //não forneceu email ou senha
    $location="recuperar.php?cod=4";
}

header("Location: $location");
exit;