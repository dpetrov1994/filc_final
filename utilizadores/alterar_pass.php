<?php
include ('../_template.php');
$content=file_get_contents("../utilizadores/alterar_pass.tpl");

if(isset($_GET['primeiro_login'])){
    $content=str_replace("_msg_","
        <div class=\"alert alert-info alert-dismissable\">
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            <h4><strong><i class=\"fa fa-lock\"></i> Alerta de segurança.</strong></h4>
            <p>Sugerimos que altere a sua palavra-passe.</p>
        </div>",$content);
    $content=str_replace("_primeiro_login_","1",$content);
}
$content=str_replace("_msg_","",$content);
$content=str_replace("_primeiro_login_","0",$content);

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
        }

        if (isset($_POST['submit'])) {

            $erros = 0;
            $erro = "";

            $pass="";
            if(isset($_POST['login-password']) && $_POST['login-password']!=""){
                $pass=encriptarPW($_POST['login-password']);
            }else{
                $erros++;
                $erro.="Falta dados";
            }

            if ($erros == 0) {
                $sql="update utilizadores set pass='$pass',pass_inicial='', updated_at='".current_timestamp."',id_editou='".$_SESSION['id_utilizador']."' where id_utilizador=$id";
                $result=runQ($sql,$db,4);

                criarLog($db,"utilizadores","id_utilizador",$id,"Alterar palavra-passe.",null);
                $location = "alterar_pass.php?cod=1&id=$id";

                if($_POST['primeiro_login']==1){
                    $location="../index.php?cod=1";
                    $_SESSION['pass_inicial']="";
                    $_SESSION['url_inicial']="";
                    unset($_SESSION['url_inicial']);
                }

            } else {
                $erro .= " Falta de dados para processar pedido.";
                $location = "alterar_pass.php?cod=2&erro=$erro&id=$id";
            }



            header("location: $location");
        }
        if (isset($_GET['cod'])) {
            if ($_GET['cod'] == 1) {
                $id = "";
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                }
                $msg="As alterações foram guardadas.<br>";
                $msgSucesso = str_replace("_id_", $id, $msgSucesso);
                $msgSucesso = str_replace("_msg_", $msg, $msgSucesso);
                $status = $msgSucesso;
            } elseif ($_GET['cod'] == 2) {
                $erro = "";
                if (isset($_GET['erro'])) {
                    $erro = $_GET['erro'];
                }
                $msgErro = str_replace("_erro_", $erro, $msgErro);
                $status = $msgErro;
            }
        }

        $pageScript='<!-- Load and execute javascript code used only in this page -->
<script src="../utilizadores/readyRecovery.js"></script>
<script>$(function(){ ReadyRecovery.init(); });</script>';
        $layout=str_replace("_pageScript_",$pageScript,$layout);
    }else{
        exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Lamentamos mas não pode aceder a esta página sem fornecer todos os dados necessários.",""));
    }
    
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Lamentamos mas não pode aceder a esta página sem fornecer todos os dados necessários.",""));
}
include ('../_autoData.php');