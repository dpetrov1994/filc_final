<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("detalhes.tpl");

$content=str_replace("_idItem_",$id,$content);

$sql="select * from $nomeTabela where id_$nomeColuna='$id'";
$result=runQ($sql,$db,"VERIFICAR EXISTENTE");
if($result->num_rows!=0){
    while ($row = $result->fetch_assoc()) {


        /**Preenchimento dos itens do formulário*/

        include "_criar_editar_detalhes.php";

        /**FIM Preenchimento dos itens do formulário*/

        foreach ($row as $key=>$value){
            if(is_date($value)){
                $value=strftime("%d/%m/%Y", strtotime($value));
            }

            if($value==1){ // para itens com cheked [ATENCAO: O NOME tem de vir antes do ID]
                $content=str_replace('name="'.$key.'" id="'.$key.'"','name="'.$key.'" id="'.$key.'" checked=""',$content);
            }

            // PREENCHER OS CAMPOS NORMAILS [ATENCAO: O ID tem de vir antes do NOME]
            $content=str_replace('id="'.$key.'" name="'.$key.'"','id="'.$key.'" name="'.$key.'" value="'.$value.'"',$content);

            // PREENCHER OS SELECTS AUTOMATICOS
            $content=str_replace("class='".$key."' value='".$value."'","class='".$key."' value='".$value."' selected",$content);
        }
        $content=str_replace("_descricao_",$row['descricao'],$content);


        $ativo="<span class='label label-success'>Ativo</span>";
        if($row['ativo']==0){
            $ativo="<span class='label label-warning'>Desativo</span>";
        }
        $content=str_replace("_ativo_",$ativo,$content);

        $criated_at = strftime("%d/%m/%Y %H:%M:%S", strtotime($row['created_at']))." - ".humanTiming($row['created_at']);
        $content=str_replace("_dataCriado_",$criated_at,$content);
        if($row['updated_at'] !=null){
            $criated_at = strftime("%d/%m/%Y %H:%M:%S", strtotime($row['updated_at']))." - ".humanTiming($row['updated_at']);
            $content=str_replace("_dataAtualizado_",$criated_at,$content);
        }else{
            $content=str_replace("_dataAtualizado_","-",$content);
        }

        $id_editou=$row['id_editou'];
        $content=str_replace("_idAtualizou_",$id_editou,$content);
        $id_criou=$row['id_criou'];
        $content=str_replace("_idCriou_",$id_criou,$content);
    }

    /**Preenchimento dos itens do formulário*/

    $sql="select * from grupos_modulos_funcionalidades WHERE id_grupo='$id'";
    $result=runQ($sql,$db,"FILL ACESSOS");
    while ($row = $result->fetch_assoc()) {
        $content=str_replace('value="'.$row['id_modulo'].'|'.$row['id_funcionalidade'].'"','value="'.$row['id_modulo'].'|'.$row['id_funcionalidade'].'" checked',$content);
    }

    $sql="select * from grupos_mensagens WHERE id_grupo='$id'";
    $result=runQ($sql,$db,"FILL grupos");
    while ($row = $result->fetch_assoc()) {
        $content=str_replace("class='grupos' value='".$row['comunica_com']."'","class='grupos' value='".$row['comunica_com']."' selected",$content);
    }

    /**FIM Preenchimento dos itens do formulário*/


    $pageScript='<script src="detalhes.js"></script>';
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod 2","Não foi encontrado nenhum registo com o ID:".$id,""));
}
include ('../_autoData.php');