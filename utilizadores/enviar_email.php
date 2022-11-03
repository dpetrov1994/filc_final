<?php
include ('../_template.php');
$content=file_get_contents("enviar_email.tpl");
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
            $content=str_replace("_idParent_",removerHTML($row['id_utilizador']),$content);
            $content=str_replace("_nomeParent_",removerHTML($row['nome_utilizador']),$content);
            $content=str_replace("_emailParent_",removerHTML($row['email']),$content);

            if($row['verification_token']==""){
                $estado="<span class='label label-default'>Envio Pendente</span>";
            }elseif($row['verificado']==1){
                $estado="<span class='label label-success'>Verificado</span>";
            }else{
                $estado="<span class='label label-warning'>Verificação Pendente</span>";
            }
            $content=str_replace("_estadoVerificado_",$estado,$content);

        }
        $msgSucesso = '
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><strong></strong></h4>
            <p>_msg_</p>
            <!--<p><a href="editar.php?id=_id_" class="alert-link">Editar</a></p>-->
        </div>
        ';
        $status="";
        if(isset($_POST['submit'])){

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
                $emailTpl=str_replace("_pass_","(a que definiu)",$emailTpl);
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
                            $location="editar.php?cod=1&id=$id"; //sucesso
                        }else{
                            $location="enviar_email.php?cod=3&id=$id";
                            if(isset($_GET['cod'])){
                                if($_GET['cod']==1) {
                                    $location="editar.php?cod=1&id=$id"; //sucesso
                                }
                            }
                        }
                    }
                }
            }

            criarLog($db,"utilizadores","id_utilizador",$id,"Enviar email de verificação.",null);
            
            header("location: $location");
        }
        $getCod="";
        if(isset($_GET['cod'])){
            if($_GET['cod']==1){
                $id="";
                if(isset($_GET['id'])){
                    $id=$_GET['id'];
                }
                $msg="<p>Dados atualizados com sucesso!</p>
                      <p>Neste último passo será enviado uma mensagem para o endreço de email do utilizador com a chave de verificação.</p>
                      <p>Pode ignorar este formulário e concluir o registo: <a href=\"alterar_foto.php?id=$id&cod=1\" class=\"btn btn-default\">Avançar</a> </p>";
                $msgSucesso = str_replace("_id_", $id, $msgSucesso);
                $msgSucesso = str_replace("_msg_", $msg, $msgSucesso);
                $status=$msgSucesso;
            }elseif($_GET['cod']==2){
                $erro="";
                if(isset($_GET['erro'])){
                    $erro=$_GET['erro'];
                }
                $msgErro=str_replace("_erro_",$erro,$msgErro);
                $status=$msgErro;
            }elseif ($_GET['cod']==3){
                $id="";
                if(isset($_GET['id'])){
                    $id=$_GET['id'];
                }
                $msg="<p>Email enviado com sucesso!</p>";
                $msgSucesso = str_replace("_id_", $id, $msgSucesso);
                $msgSucesso = str_replace("_msg_", $msg, $msgSucesso);
                $status=$msgSucesso;
            }
            $getCod=$_GET['cod'];
        }
        $addUrl = "?id=$id&cod=".$getCod;
        $content=str_replace('_status_',$status,$content);
    }else{
        exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Lamentamos mas não pode aceder a esta página sem fornecer todos os dados necessários.",""));
    }
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Lamentamos mas não pode aceder a esta página sem fornecer todos os dados necessários.",""));
}
include ('../_autoData.php');