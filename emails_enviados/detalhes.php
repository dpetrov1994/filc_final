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

        $value=strftime("%H:%M:%S", strtotime($row['created_at']));
        $content=str_replace("_horaInicio_",$value,$content);
        $content=str_replace("_ficheiro_",$row['ficheiro'],$content);


        $sql2="select * from utilizadores where id_utilizador='".$row['id_criou']."'";
        $result2=runQ($sql2,$db,"SELECT UTILIZADOR");
        while ($row2 = $result2->fetch_assoc()) {
            $content=str_replace("_nome_utilizador_",$row2['nome_utilizador'],$content);
        }
        $content=str_replace("_nome_utilizador_","[AUTO]",$content);

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
    }


    /**Preenchimento dos itens do formulário*/

    $content=str_replace("_tabela_","",$content);

    /**FIM Preenchimento dos itens do formulário*/


    $pageScript="<script>desativarInputs()</script>";
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod 2","Não foi encontrado nenhum registo com o ID:".$id,""));
}
include ('../_autoData.php');