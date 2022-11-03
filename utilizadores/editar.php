<?php
include ('../_template.php');
$content=file_get_contents("editar.tpl");
if(isset($_GET['id'])) {
    
    $id=$db->escape_string($_GET['id']);

    $add_sql=" and (select count(*) from grupos_utilizadores where (id_grupo=1 or id_grupo=2) and id_utilizador=utilizadores.id_utilizador )=0 ";
    $sqlGrupos=" and id_grupo<>1 and  id_grupo<>2";
    foreach ($_SESSION['grupos'] as $grupo){
        if($grupo==1){
            $add_sql="";
            $sqlGrupos="";
        }
        if($grupo==2){
            $add_sql=" and (select count(*) from grupos_utilizadores where id_grupo=1 and id_utilizador=utilizadores.id_utilizador )=0 ";
            $sqlGrupos="and id_grupo<>1";
        }
    }




    $admin=0;
    if(in_array(1,$_SESSION['grupos']) || in_array(2,$_SESSION['grupos'])){
        $admin=1;
    }

    $permissoes="";
    if($admin==1){
        $permissoes='<div class="form-group">
                    <div class="col-md-12">
                        <h2>Permissões</h2>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Membro de</label>
                    <div class="col-md-6">
                        <select id="grupos" name="grupos[]" class="select-select2" style="width: 100%;">
                            _grupos_
                        </select>
                    </div>
                </div>';
    }
    $content=str_replace("_permissoes_",$permissoes,$content);

    $sql="select * from utilizadores where id_utilizador='$id'";
    $result=runQ($sql,$db,"1");
    if($result->num_rows!=0){
        while ($row = $result->fetch_assoc()) {

           // $content=str_replace('_grupos_',$grupos,$content);

            if($row['mostrar_no_dashboard']==1){
                $content=str_replace('name="mostrar_no_dashboard" id="mostrar_no_dashboard"','name="mostrar_no_dashboard" checked id="mostrar_no_dashboard"',$content);
            }
            if($row['comercial']==1){
                $content=str_replace('name="comercial" id="comercial"','name="comercial" checked id="comercial"',$content);
            }

            $content=str_replace("_nomeParent_",$row['nome_utilizador'],$content);
            $content=str_replace("_obsParent_",$row['obs'],$content);

            $content=str_replace("_emailParent_",$row['email'],$content);

            $content=str_replace("_data_nascimento_",date("Y-m-d",strtotime($row['data_nascimento'])),$content);
            $content=str_replace("_contacto_",$row['contacto'],$content);
            $content=str_replace("_contactoAlternativo_",$row['contacto_alternativo'],$content);
            $content=str_replace("_nif_",$row['nif'],$content);
            $content=str_replace("_morada_",$row['morada'],$content);
            $content=str_replace("_cod_post_",$row['cod_post'],$content);
            $content=str_replace("_localidade_",$row['localidade'],$content);
            $content=str_replace("_cor_",$row['cor'],$content);

            $content=str_replace('value="'.$row['sexo'].'"','value="'.$row['sexo'].'" selected',$content);

            $content=str_replace("_foto_",$row['foto'],$content);

            $content=str_replace("_idParent_",$row['id_utilizador'],$content);
            if($row['verificado']==1){
                $content=str_replace("_op1Estado_","selected",$content);
                $content=str_replace("_op2Estado_","",$content);
            }elseif ($row['verificado']==0){
                $content=str_replace("_op1Estado_","",$content);
                $content=str_replace("_op2Estado_","selected",$content);
            }

            if($row['ativo']==1){
                $content=str_replace("_op1Ativo_","selected",$content);
                $content=str_replace("_op0Ativo_","",$content);
            }else{
                $content=str_replace("_op1Ativo_","",$content);
                $content=str_replace("_op0Ativo_","selected",$content);
            }
        }

        $sql="select * from grupos where ativo=1 $sqlGrupos order by nome_grupo asc";
        $result=runQ($sql,$db,"1");
        $grupos="";
        while ($row = $result->fetch_assoc()) {
            $selected="";
            $sql2="select * from grupos_utilizadores where id_grupo='".$row['id_grupo']."' and id_utilizador='".$id."'";
            $result2=runQ($sql2,$db,"1.1");
            if($result2->num_rows>0){
                $selected="selected";
            }
            $grupos.="<option $selected value='".$row['id_grupo']."'>".removerHTML($row['nome_grupo'])."</option>";
        }
        $content=str_replace('_grupos_',$grupos,$content);
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
            $erros=0;
            $erro="";
            if(isset($_POST['nome']) && $_POST['nome']!=""){
                $nome=$db->escape_string($_POST['nome']);
            }else{
                $erro.=" NOME -";
                $erros++;
            }

            if(isset($_POST['cor']) && $_POST['cor']!=""){
                $cor=$db->escape_string($_POST['cor']);
            }else{
                $erro.=" COR -";
                $erros++;
            }

            $mostrar=0;
            if(isset($_POST['mostrar_no_dashboard'])){
                $mostrar=1;
            }
            $comercial=0;
            if(isset($_POST['comercial'])){
                $comercial=1;
            }

            /*
            if(isset($_POST['data_nascimento']) && $_POST['data_nascimento']!=""){
                $data_nascimento=data_portuguesa($_POST['data_nascimento']);
            }else{
                $erro.=" data_nascimento -";
                $erros++;
            }

            if(isset($_POST['contacto']) && $_POST['contacto']!=""){
                $contacto=$db->escape_string($_POST['contacto']);
            }else{
                $erro.=" contacto -";
                $erros++;
            }

            if(isset($_POST['contacto_alternativo']) && $_POST['contacto_alternativo']!=""){
                $contacto_alternativo=$db->escape_string($_POST['contacto_alternativo']);
            }else{
                $erro.=" contacto_alternativo -";
                $erros++;
            }

            if(isset($_POST['nif']) && $_POST['nif']!=""){
                $nif=$db->escape_string($_POST['nif']);
            }else{
                $erro.=" nif -";
                $erros++;
            }

            if(isset($_POST['morada']) && $_POST['morada']!=""){
                $morada=$db->escape_string($_POST['morada']);
            }else{
                $erro.=" morada -";
                $erros++;
            }

            if(isset($_POST['cod_post']) && $_POST['cod_post']!=""){
                $cod_post=$db->escape_string($_POST['cod_post']);
            }else{
                $erro.=" cod_post -";
                $erros++;
            }

            if(isset($_POST['localidade']) && $_POST['localidade']!=""){
                $localidade=$db->escape_string($_POST['localidade']);
            }else{
                $erro.=" localidade -";
                $erros++;
            }

            if(isset($_POST['sexo']) && $_POST['sexo']!=""){
                $sexo=$db->escape_string($_POST['sexo']);
            }else{
                $erro.=" sexo -";
                $erros++;
            }
            */

            $grupos=[];
            if(isset($_POST['grupos'])){
                $grupos=$_POST['grupos'];
            }else{
                $erro.=" GRUPOS -";
                $erros++;
            }

            $verificado=null;
            if(isset($_POST['verificado']) && $_POST['verificado']!=""){
                $verificado=$db->escape_string($_POST['verificado']);
            }
            $ativo=0;
            if(isset($_POST['ativo']) && $_POST['ativo']!=""){
                $ativo=$db->escape_string($_POST['ativo']);
            }

            $obs="";
            if(isset($_POST['obs']) && $_POST['obs']!=""){
                $obs=$db->escape_string($_POST['obs']);
            }


            if ($erros == 0) {
                $sql="update utilizadores set 
                nome_utilizador='$nome', 
                updated_at='".current_timestamp."',
                id_editou='".$_SESSION['id_utilizador']."',
                obs='$obs' ,
                cor='$cor' ,
                mostrar_no_dashboard='$mostrar' ,
                comercial='$comercial',
                verificado='$verificado',
                ativo='$ativo'
                where id_utilizador=$id";

                $result=runQ($sql,$db,4);


                $sql="delete from grupos_utilizadores where id_utilizador=$id";
                $result=runQ($sql,$db,7);

                foreach ($grupos as $grupo){
                    $sql="insert into grupos_utilizadores (id_grupo,id_utilizador) values ($grupo,$id)";
                    $result=runQ($sql,$db,7);
                }


                $sql="select * from utilizadores where id_utilizador = $id";
                $result=runQ($sql,$db,"SELECT UPDATED");
                while ($row = $result->fetch_assoc()) {
                    $array_log=json_encode($row);
                    criarLog($db,"utilizadores","id_utilizador",$id,"Editar",$array_log);
                }

                $location = "editar.php?cod=1&id=$id";

            } else {
                $erro .= " Falta de dados para processar pedido.";
                $location = "editar.php?cod=2&erro=$erro&id=$id";
            }

            header("location: $location");
        }

        $pageScript='';
        $addUrl = "?id=$id";
    }else{
        exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Lamentamos mas não pode aceder a esta página sem fornecer todos os dados necessários.",""));
    }
    
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Lamentamos mas não pode aceder a esta página sem fornecer todos os dados necessários.",""));
}
include ('../_autoData.php');