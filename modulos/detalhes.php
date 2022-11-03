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


        $sql_preencher="select * from modulos";
        $result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
        $ops="";
        while ($row_preencher = $result_preencher->fetch_assoc()) {
            $ops.="<option class='id_parent' value='".$row_preencher["id_modulo"]."'>".$row_preencher["nome_modulo"]."</option>";
        }
        $content=str_replace("_id_parent_",$ops,$content);

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

        $id_moulo=$row['id_modulo'];


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

        $id_modulo=$row['id_modulo'];
    }


    /**Preenchimento dos itens do formulário*/

    //

    /**FIM Preenchimento dos itens do formulário*/




    $pageScript="<script>desativarInputs()</script>";
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod 2","Não foi encontrado nenhum registo com o ID:".$id,""));
}
include ('../_autoData.php');