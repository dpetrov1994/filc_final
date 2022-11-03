<?php
$email=$_POST['reminder-email'];
$erros=0;
if($email==""){
    $erros++;
}

if($erros==0){
    $db=ligarBD(1);

    $email=$db->escape_string($email);
    $sql ="SELECT id_utilizador,verificado,ativo,verification_token,email,pass_inicial FROM utilizadores WHERE email='$email'";
    $result=runQ($sql,$db,1);

    if($result->num_rows==1){
        while($row = $result->fetch_assoc()){
            $id_utilzador=$row['id_utilizador'];
            $verificado=$row['verificado'];
            $ativo=$row['ativo'];
            $token=$row['verification_token'];
            $email=$row['email'];
            $passInicial=$row['pass_inicial'];
        }

        if($ativo==1){
            criarLog($db,"utilizadores","id_utilizador",$id_utilzador,"Pedido de reenvio do email de verificação.",null);

            $emailTpl=file_get_contents("../assets/email/email.tpl");
            $emailTpl=str_replace("_conteudo_",file_get_contents("../assets/email/verificar.tpl"),$emailTpl);
            $emailTpl=str_replace("_nomeEmpresa_",$cfg_nomeEmpresa,$emailTpl);
            $emailTpl=str_replace("_mora_",$cfg_mora,$emailTpl);
            $emailTpl=str_replace("_siteEmpresa_",$cfg_siteEmpresa,$emailTpl);
            $emailTpl=str_replace("_email_",$email,$emailTpl);
            if($passInicial!=""){
                $emailTpl=str_replace("_pass_",$passInicial,$emailTpl);
            }else{
                $emailTpl=str_replace("_pass_","(a que definiu)",$emailTpl);
            }
            $emailTpl=str_replace("_copyAno_",date("Y"),$emailTpl);
            $emailTpl=str_replace("_copySite_",$cfg_copySite,$emailTpl);
            $emailTpl=str_replace("_copyPlataforma_",$cfg_copyPlataforma,$emailTpl);

            $actual_link=str_replace("verificar.php","verificar_conta.php?token=$token",$actual_link);
            $emailTpl=str_replace("_recoveryURL_",$actual_link,$emailTpl);

            $mensagem=$emailTpl;
            $anexos=0;
            $assunto="Ativação da conta";
            $destinatarios=[$email];
            $estadoEmail=enviarEmail($anexos,$assunto,$mensagem,$destinatarios);
            if($estadoEmail[0]['estado']!=0){
                $location="verificar.php?cod=6";
            }else{
                $location="verificar.php?cod=5&email=$email"; //sucesso
            }
        }else{
            //utilizador desativo
            $location="verificar.php?cod=2";
        }
    }else{
        //email ou senha incorertos ou utilizador não existente
        $location="verificar.php?cod=3";
    }

    $db->close();
}else{
    //não forneceu email ou senha
    $location="verificar.php?cod=4";
}

header("Location: $location");
exit;