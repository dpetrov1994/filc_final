<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("abrir.tpl");
$menuSecundarioIndividual="";
$content=str_replace("_idItem_",$id,$content);

if(isset($_GET['u'])){
    $id_utilizador=$db->escape_string($_GET['u']); // id do utilizador com quem é feita a conversa
}else{
    $id_utilizador=$_SESSION['id_utilizador']; // id do utilizador com quem é feita a conversa
}


/**
 * MENSAGENS ATUAL
 */

$sql="select * from $nomeTabela where mensagens.id_$nomeColuna='$id'";
$result=runQ($sql,$db,"VERIFICAR EXISTENTE");
if($result->num_rows!=0){
    while ($row = $result->fetch_assoc()) {
        $id_criou=$row['id_criou'];
    }

    if($id_criou==$_SESSION['id_utilizador']){
        $id_para=$id_utilizador; // id do utilizador com quem é feita a conversa
    }
    if($id_utilizador==$_SESSION['id_utilizador']){
        $id_para=$id_criou; // id do utilizador com quem é feita a conversa
    }

    $sql="update utilizadores_mensagens set visto_em='".current_timestamp."' where visto_em is null and id_mensagem='$id' and id_utilizador='".$_SESSION['id_utilizador']."'";
    $result=runQ($sql,$db,"METE A MENSAGEM VISTA");

}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod 2","Não foi encontrado nenhum registo com o ID:".$id,""));
}

/**
 * FIM MENSAGEM ATUAL
 */




/**
 * CADEIA DE MENSAGENS
 */
$respostas=recursiveGetMensagensRespostas($db,$id,$id_para);
$objTmp = (object) array('aFlat' => array());
array_walk_recursive($respostas, create_function('&$v, $k, &$t', '$t->aFlat[] = $v;'), $objTmp);
$respostas=$objTmp->aFlat;
$anteriores=recursiveGetMensagensAnteriores($db,$id,$id_para);
$objTmp = (object) array('aFlat' => array());
array_walk_recursive($anteriores, create_function('&$v, $k, &$t', '$t->aFlat[] = $v;'), $objTmp);
$anteriores=$objTmp->aFlat;
$cadeia=array();
foreach (array_reverse($respostas) as $resposta){
    if($resposta!="" && $resposta!=$id){
        array_push($cadeia,$resposta);
    }
}

foreach (($anteriores) as $anterior){
    if($anterior!=""){
        array_push($cadeia,$anterior);
    }
}


$tplMensagem='
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="fa fa-angle-right"></i> 
                <a class="accordion-toggle _collapsed_" onclick="marcarVista(_id_mensagem_)" data-toggle="collapse" data-parent="#faq1" href="#_id_mensagem_">
                  _nova_ _estrela2_ <strong class="text-primary">_de_:</strong> _nome_mensagem_ - <small class="text-muted"><em>_dataCriado_ (_created_at_ atrás)</em></small> _temanexo_
                </a>
            </div>
        </div>
        <div id="_id_mensagem_" class="panel-collapse collapse _in_">
            <div class="panel-body">
                <h3> 
                    _estrela_ <strong>_nome_mensagem_ </strong> <small><em>_dataCriado_ (_created_at_ atrás)</em></small>
                </h3>
                
                <p><a href="javascript:void(0)"><strong>_de_</strong></a> <strong>&lt;#_idde_&gt;</strong> para <a href="javascript:void(0)"><strong>_para_</strong></a> <strong>&lt;#_idpara_&gt;</strong> _vistoem_</p>
                <hr>
                <p>_descricaoBR_</p>
                <hr>
                <div class="row block-section">
                    _anexos_
                </div>
            </div>
        </div>
    </div>
';

$linhas="";

foreach ($cadeia as $id_cadeia){
    $sql="select * from $nomeTabela where id_$nomeColuna='$id_cadeia'";
    $result=runQ($sql,$db,"CADEIA");
    while ($row = $result->fetch_assoc()) {
        $linhas.=$tplMensagem;

        if($id_cadeia==$id){
            $linhas=str_replace("_collapsed_","collapsed",$linhas);
            $linhas=str_replace("_in_","in",$linhas);
        }
        $linhas=str_replace("_collapsed_","",$linhas);
        $linhas=str_replace("_in_","",$linhas);

        $linhas=str_replace('_dataCriado_',strftime("%d/%m/%Y %H:%M", strtotime($row['created_at'])),$linhas);
        $dir="../_contents/anexos_mensagens/".$row['id_mensagem'];

        $link=str_replace("/abrir.php","",actual_link);
        $link=explode("?",$link);
        $link=$link[0];

        $linhaImagem=
            '<div class="col-xs-6 col-sm-3 col-lg-2 text-center" style="height: 200px" data-toggle="tooltip" data-placement="top" title="_ficheiro_" data-original-title="_ficheiro_"> 
                <div style="height: 130px; position: relative"  > 
                 _preview_
                </div>
                
                <span class="text-muted">
                _NomeFicheiro_<br>
                <div class="btn-group">
                                  <a href="_dir_/_ficheiro_" download="" class="btn btn-sm btn-effect-ripple btn-primary"  ><i class="fa fa-save"></i></a>
                                  <a href="javascript:void(0)" class="btn btn-sm btn-effect-ripple btn-info btn_copiar" onclick="copiar(this)" data-clipboard-text="_link_/_dir_/_ficheiro_"><i class="fa fa-files-o"></i></a>
                </div>
                </span>
                
            </div>';
        $anexos="";
        $ficheiros=mostraFicheiros($dir);
        if(is_array($ficheiros) && count($ficheiros)>0){
            $linhas=str_replace("_temanexo_",'<i class="fa fa-paperclip text-muted pull-right"></i>',$linhas);
            foreach ($ficheiros as $ficheiro){
                $nomeFicheiro=explode(".",$ficheiro);
                $ext=end($nomeFicheiro);
                $nomeFicheiro=cortaStr($nomeFicheiro[0],15)." <b>.$ext</b>";

                $anexos .= $linhaImagem;

                if(is_image("$dir/$ficheiro")){
                    $anexos=str_replace("_preview_",'<a href="_dir_/_ficheiro_" data-toggle="lightbox-image" class="text-center"> <img src="_dir_/_ficheiro_" alt="" class="img-responsive vertical-center" style="max-width: 100%;max-height: 130px;"> </a>',$anexos);

                }else{
                    if(is_file("$layoutDirectory/img/svg_filetypes/$ext.svg")){
                        $svg="$layoutDirectory/img/svg_filetypes/$ext.svg";
                    }else{
                        $svg="$layoutDirectory/img/svg_filetypes/file.svg";
                    }
                    $anexos=str_replace("_preview_",'<img src="_svg_" alt="" class="" style="height: 90px;margin-top: 20px;">',$anexos);
                    $anexos = str_replace("_svg_", $svg, $anexos);
                    $anexos = str_replace("_ext_", $ext, $anexos);
                }
                $anexos = str_replace("_link_", $link, $anexos);
                $anexos = str_replace("_dir_", $dir, $anexos);
                $anexos = str_replace("_ficheiro_", $ficheiro, $anexos);
                $anexos = str_replace("_NomeFicheiro_", $nomeFicheiro, $anexos);
            }
        }
        $linhas=str_replace("_anexos_",$anexos,$linhas);
        $linhas=str_replace("_temanexo_","",$linhas);

        $sql_preencher="select nome_utilizador,id_utilizador from utilizadores where id_utilizador=".$row['id_criou'];
        $result_preencher=runQ($sql_preencher,$db,"DE");
        while ($row_preencher = $result_preencher->fetch_assoc()) {
            $linhas=str_replace("_de_",cortaNome($row_preencher['nome_utilizador']),$linhas);
            $linhas=str_replace("_idde_",cortaNome($row_preencher['id_utilizador']),$linhas);
        }

        $sql_preencher="select * from utilizadores_mensagens where id_mensagem=".$row['id_mensagem']." and (id_utilizador='$id_para' or id_utilizador='".$_SESSION['id_utilizador']."')";
        $result_preencher=runQ($sql_preencher,$db,"ID_UTILIZADORES_MENSAGENS");

        while ($row_preencher = $result_preencher->fetch_assoc()) {
            $id_utilizador_mensagem=$row_preencher['id_utilizador_mensagem'];
            $id_utilizador=$row_preencher['id_utilizador'];


            $visto_em="<small class='text-muted'><i class='fa fa-envelope'></i></small>";
            $nova="<span class='label label-info'>NOVA!</span>";
            if(is_date($row_preencher['visto_em'])){
                $visto_em="<small class='text-muted'><i class='fa fa-envelope-open-o'></i> - ".strftime("%d/%m/%Y %H:%M", strtotime($row_preencher['visto_em']))." (".humanTiming($row_preencher['visto_em']).")</small>";
                $nova="";
            }
            $linhas=str_replace("_vistoem_",$visto_em,$linhas);

            if($row_preencher['id_utilizador']==$_SESSION['id_utilizador']){
                if($row_preencher['estrela']==1){
                    $linhas=str_replace("_estrela_","<i class='fa fa-star text-warning' id='estrela".$row_preencher['id_utilizador_mensagem']."' onclick='marcarEstrela(".$row_preencher['id_utilizador_mensagem'].")'></i>",$linhas);
                    $linhas=str_replace("_estrela2_","<i class='fa fa-star text-warning'></i>",$linhas);
                }
                $linhas=str_replace("_estrela2_","<i class='fa fa-star-o text-warning'></i>",$linhas);
                $linhas=str_replace("_estrela_","<i class='fa fa-star-o text-warning' id='estrela".$row_preencher['id_utilizador_mensagem']."' onclick='marcarEstrela(".$row_preencher['id_utilizador_mensagem'].")'></i>",$linhas);
            }else{
                $nova="";
            }

            $linhas=str_replace("_estrela_","",$linhas);
            $linhas=str_replace("_estrela2_","",$linhas);

            $linhas=str_replace("_nova_",$nova,$linhas);
        }


        $sql_preencher="select nome_utilizador,utilizadores.id_utilizador as idUtilizador from utilizadores WHERE id_utilizador='$id_utilizador'";
        $result_preencher=runQ($sql_preencher,$db,"para");
        while ($row_preencher = $result_preencher->fetch_assoc()) {
            $linhas=str_replace("_para_",cortaNome($row_preencher['nome_utilizador']),$linhas);
            $linhas=str_replace("_idpara_",cortaNome($row_preencher['idUtilizador']),$linhas);
        }

        foreach ($row as $key=>$value){
            if(is_date($value)){
                $value=humanTiming($value);
            }
            $linhas=str_replace('_'.$key.'_',$value,$linhas);
        }
        $linhas=str_replace("_descricaoBR_",nl2br($row['descricao']),$linhas);
    }
}
$content=str_replace("_mensagens_",$linhas,$content);
/**
 * FIM CADEIA DE MENSAGENS
 */


/**
 * BLOCO DE RESPOSTA
 */


$sql="select nome_mensagem from mensagens where id_mensagem='".$cadeia[0]."'";
$result=runQ($sql,$db,"NOME MENSAGEM");
while ($row = $result->fetch_assoc()) {
    $nomeMensagem=$row['nome_mensagem'];
}
$content=str_replace("_resposta_",'
                <div class="col-md-6">
                    <form action="criar.php?u='.$id_para.'" method="post">
                        <select id="utilizadores" required multiple name="utilizadores[]" style="display: none">
                            <option selected required value="'.$id_para.'">'.$id_para.'</option>
                        </select>
                        <input id="nome_mensagem" required value="'.$nomeMensagem.'" name="nome_mensagem" style="display: none">
                        <input id="id_parent" required value="'.$cadeia[0].'" name="id_parent" style="display: none">
                        <label><i class="fa fa-pencil"></i> Resposta rápida</label>
                        <textarea id="descricao" required name="descricao" rows="11" class="form-control push-bit" placeholder="Escreva aqui a sua mensagem.."></textarea>
                        <button type="submit" name="submit" id="botao_loading"  class="btn btn-effect-ripple btn-primary" data-loading-text="<i class=\'fa fa-asterisk fa-spin\'></i> Aguarde"><i class="fa fa-share"></i> Responder</button>
                    <br><br>
                    </form>
                </div>
                <div class="col-md-6">
                    <label><i class="fa fa-paperclip"></i> Anexos</label>
                    <form action="" class="dropzone" id="myAwesomeDropzone"></form>
                </div>
                ',$content);

/**
 * FIM BLOCO RESPOSTA
 */
$pageScript='<script src="abrir.js"></script>';
include ('../_autoData.php');