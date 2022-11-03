<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("perfil.tpl");
$content=str_replace("_idItem_",$id,$content);

if(isset($_GET['id']) && $_GET['id']!=""){
    $id=$db->escape_string($_GET['id']);
}else{
    $id=$_SESSION['id_utilizador'];
}

$sql="select * from $nomeTabela where id_$nomeColuna='$id'";
$result=runQ($sql,$db,"VERIFICAR EXISTENTE");
if($result->num_rows!=0){
    while ($row = $result->fetch_assoc()) {



 /**Preenchimento dos itens do formulário*/

    //

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

    //

    /**FIM Preenchimento dos itens do formulário*/

    $pageScript="<script>desativarInputs()</script>";
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod 2","Não foi encontrado nenhum registo com o ID:".$id,""));
}
include ('../_autoData.php');