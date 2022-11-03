<?php
include ('../_template.php');
$content=file_get_contents("../utilizadores/alterar_email.tpl");
if(isset($_GET['id'])) {
    
    $id=$db->escape_string($_GET['id']);

    $add_sql=" and (select count(*) from grupos_utilizadores where (id_grupo=1 or id_grupo=2) and id_utilizador=utilizadores.id_utilizador )=0 ";
    foreach ($_SESSION['grupos'] as $grupo){
        if($grupo==1){
            $add_sql="";
        }
        if($grupo==2){
            $add_sql=" and (select count(*) from grupos_utilizadores where id_grupo=1 and id_utilizador=utilizadores.id_utilizador )=0 ";
        }
    }

    $sql="select * from utilizadores where id_utilizador='$id' $add_sql";
    $result=runQ($sql,$db,"1");
    if($result->num_rows!=0){
        while ($row = $result->fetch_assoc()) {
            $nomeUtilizador=$row['nome_utilizador'];
            $email=$row['email'];
            $passInicial=$row['pass_inicial'];
            $content=str_replace("_idParent_",removerHTML($row['id_utilizador']),$content);
            $content=str_replace("_nomeParent_",removerHTML($row['nome_utilizador']),$content);
        }

        $msgSucesso = '
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><strong>Sucesso.</strong></h4>
            <p>_msg_</p>
        </div>
        ';
        $msgErro = '
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><strong>Erro.</strong></h4>
            <p>Ocorreu um erro ao inserir o registo. Tente novamente mais tarde.</p>
            <p>Se isto continuar a acontecer entre em contracto com o administrador.</p>
            <p><code>_erro_</code></p>
        </div>
        ';

        if (isset($_POST['submit'])) {

            $erros = 0;
            $erro = "";

            $email="";
            if(isset($_POST['email']) && $_POST['email']!=""){
                $email=$db->escape_string($_POST['email']);
                //novo token
                $token=md5(time().$email);
            }else{
                $erros++;
                $erro = "";
            }

            if ($erros == 0) {
                $sql="update utilizadores set email='$email',verificado=0,verification_token='$token', updated_at='".current_timestamp."',id_editou='".$_SESSION['id_utilizador']."' where id_utilizador=$id";
                $result=runQ($sql,$db,4);

                $sql="update utilizadores set verification_token='$token' where id_utilizador='$id'";
                $result=runQ($sql,$db,8);
                $emailTpl=file_get_contents("../assets/email/email.tpl");
                $emailTpl=str_replace("_conteudo_",file_get_contents("../assets/email/alterarEmail.tpl"),$emailTpl);
                $emailTpl=str_replace("_nomeEmpresa_",$cfg_nomeEmpresa,$emailTpl);
                $emailTpl=str_replace("_email_",$email,$emailTpl);
                if($passInicial!=""){
                    $emailTpl=str_replace("_pass_",$passInicial,$emailTpl);
                }else{
                    $emailTpl=str_replace("_pass_","(a que definiu)",$emailTpl);
                }
                $emailTpl=str_replace("_moradaEmpresa_",$cfg_moradaEmpresa,$emailTpl);
                $emailTpl=str_replace("_siteEmpresa_",$cfg_siteEmpresa,$emailTpl);

                $emailTpl=str_replace("_copyAno_",date("Y"),$emailTpl);
                $emailTpl=str_replace("_copySite_",$cfg_copySite,$emailTpl);
                $emailTpl=str_replace("_nomePlataforma_",$cfg_nomePlataforma,$emailTpl);
                $emailTpl=str_replace("_copyPlataforma_",$cfg_copyPlataforma,$emailTpl);
                $actual_link=str_replace("utilizadores/alterar_email.php?id=$id","login/verificar_conta.php?token=$token",$actual_link);
                $actual_link=str_replace("utilizadores/alterar_email.php?cod=1&id=$id","login/verificar_conta.php?token=$token",$actual_link);
                $actual_link=str_replace("mod_perfil/alterar_email.php?&id=$id","login/verificar_conta.php?token=$token",$actual_link);
                $actual_link=str_replace("mod_perfil/alterar_email.php?cod=1&id=$id","login/verificar_conta.php?token=$token",$actual_link);
                $emailTpl=str_replace("_recoveryURL_",$actual_link,$emailTpl);
                $mensagem=$emailTpl;
                $anexos=[];
                $assunto="Alteração de Email";
                $destinatarios=[$email];
                $resultados=enviarEmail($anexos,$assunto,$mensagem,$destinatarios);
                foreach ($resultados as $resultado){
                    foreach ($destinatarios as $destinatario){
                        if($resultado['destinatario']==$destinatario){
                            $estadoEnvio=$resultado['output'];
                            if($estadoEnvio==0){
                                $location="alterar_email.php?cod=1&id=$id"; //sucesso
                            }else{
                                $location="alterar_email.php?cod=2&id=$id";
                                if(isset($_GET['cod'])){
                                    if($_GET['cod']==1) {
                                        $location="alterar_email.php?cod=1&id=$id"; //sucesso
                                    }
                                }
                            }
                        }
                    }
                }

            } else {
                $erro .= " Falta de dados para processar pedido.";
                $location = "alterar_email.php?cod=2&erro=$erro&id=$id";
            }

            $textoLog="Alterou email.<br>
                            ID: $id<br>
                            NOME: $nomeUtilizador<br>
                       Endereço ip: ".$_SERVER['REMOTE_ADDR']."<br>";
            $textoLog=$db->escape_string($textoLog);

            $sql = "INSERT INTO utilizadores_logs (data_log,texto,id_utilizador) VALUES ('".current_timestamp."','$textoLog','" .$_SESSION['id_utilizador']."')";
            $result=runQ($sql,$db,6);
            header("location: $location");
        }

        $pageScript='<!-- Load and execute javascript code used only in this page -->
<script src="../utilizadores/alterarEmail.js"></script>
<script>$(function(){ ReadyRecovery.init(); });</script>';
        $layout=str_replace("_pageScript_",$pageScript,$layout);
    }else{
        exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Lamentamos mas não pode aceder a esta página sem fornecer todos os dados necessários.",""));
    }
    
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Lamentamos mas não pode aceder a esta página sem fornecer todos os dados necessários.",""));
}
include ('../_autoData.php');