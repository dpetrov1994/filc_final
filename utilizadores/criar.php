<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("criar.tpl");
$content=str_replace("_descricao_","",$content);

/**Preenchimento dos itens do formulário **/

$coluna_nome="";
$id_grupo="";

$sql_preencher="select * from grupos where ativo=1";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {
    $selected="";
    if($row_preencher['id_grupo']==$id_grupo){
        $selected="selected";
    }
    $ops.="<option $selected value='".$row_preencher["id_grupo"]."'>".$row_preencher["nome_grupo"]."</option>";
}
$content=str_replace("_grupos_",$ops,$content);


/**FIM Preenchimento dos itens do formulário **/


if(isset($_POST['submit'])){
    $erros="";
    $colunas="";
    $valores="";
    $scripts="";
    foreach($_POST as $coluna =>$valor){
        if(!is_array($valor)){
            if(!in_array($coluna, $itensIgnorar)) {
                if(in_array($coluna, $itensObrigatorios) && $valor=="") {
                    $erros.=" Falta $coluna,";
                }else{
                    if(is_data_portuguesa($valor)){
                        $valor=data_portuguesa($valor);
                    }
                    if($coluna=='pass'){
                        $pass_inicial=$valor;
                        $valor=encriptarPW($valor);
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

    /**Validação de itens adicionais**/

    //

    /**FIM validação de itens adicionais**/

    if($erros==""){
        $sql="insert into $nomeTabela ($colunas,pass_inicial,id_criou,created_at) values ($valores,'$pass_inicial','".$_SESSION['id_utilizador']."','".current_timestamp."')";
        $result=runQ($sql,$db,"INSERT");
        $insert_id=$db->insert_id;

        /**Operações adicionais que necessitem do $insert_id **/

        $sql="insert into utilizadores_conf (id_utilizador,tempo_lock) values ($insert_id,'300000')";
        $result=runQ($sql,$db,7);

        foreach ($_POST['grupos'] as $id_grupo){
            $sql="insert into grupos_utilizadores (id_grupo, id_utilizador) values ('$id_grupo','$insert_id')";
            $result=runQ($sql,$db,"INSERT GRUPOS UTILIZADORES");
        }

        /**FIM perações adicionais que necessitem do $insert_id **/

        $sql="select * from $nomeTabela where id_$nomeColuna = $insert_id";
        $result=runQ($sql,$db,"SELECT INSERTED");
        while ($row = $result->fetch_assoc()) {
            $array_log=json_encode($row);
            criarLog($db,$nomeTabela,"id_$nomeColuna",$insert_id,"Criar",$array_log);
        }

        if(isset($_POST['notificar'])){

            $sql="select email,pass_inicial from utilizadores where id_utilizador='$insert_id'";
            $result=runQ($sql,$db,7);
            while ($row = $result->fetch_assoc()){
                $email=$row['email'];
                $passInicial=$row['pass_inicial'];
            }

            //novo token
            $token=md5(time().$email);
            $sql="update utilizadores set verification_token='$token' where id_utilizador='$insert_id'";
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
            $actual_link=str_replace("utilizadores/criar.php?id=$insert_id","login/verificar_conta.php?token=$token",$actual_link);
            $actual_link=str_replace("utilizadores/criar.php?","login/verificar_conta.php?token=$token",$actual_link);
            $actual_link=str_replace("utilizadores/criar.php?cod=1","login/verificar_conta.php?token=$token",$actual_link);
            $actual_link=str_replace("utilizadores/enviar_email.php?id=$insert_id","login/verificar_conta.php?token=$token",$actual_link);
            $actual_link=str_replace("utilizadores/enviar_email.php?cod=1&id=$insert_id","login/verificar_conta.php?token=$token",$actual_link);
            $emailTpl=str_replace("_recoveryURL_",$actual_link,$emailTpl);
            $mensagem=$emailTpl;
            $anexos=0;
            $assunto="Ativação da conta";
            $destinatarios=[$email];
           // enviarEmail($anexos,$assunto,$mensagem,$destinatarios);
            //criarLog($db,"utilizadores","id_utilizador",$insert_id,"Enviar email de verificação.",null);
        }

        $location="editar.php?$addUrl&cod=3"; //sucesso
        if($subModulo==0){
            $location.="&id=$insert_id";
        }else{
            $location.="&subItemID=$insert_id";
        }


    }else{
        $erros.=" Falta de dados para processar pedido.";
        $location="criar.php$addUrl&cod=2&erro=$erros";
    }
    header("location: $location");
}
$pageScript='<script src="criar.js"></script>';
include ('../_autoData.php');