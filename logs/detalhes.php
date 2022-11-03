<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("detalhes.tpl");
$content=str_replace("_idItem_",$id,$content);


$tabela='<div class="table-responsive">
                            <table class="table table-striped table-borderless table-vcenter table-hover">
                                <thead>
                                <tr>
                                    <th>Coluna</th>
                                    <th>Antes</th>
                                    <th>Depois</th>
                                </tr>
                                </thead>
                                <tbody>
                                _linhas_
                                </tbody>
                            </table>
                        </div>';
$linha='<tr class="_alterada_">
                                    <td><strong>_coluna_</strong></td>
                                    <td>_antes_</td>
                                    <td>_depois_</td>
                                </tr>';

$sql="select * from $nomeTabela where id_$nomeColuna='$id'";
$result=runQ($sql,$db,"VERIFICAR EXISTENTE");
if($result->num_rows!=0){
    while ($row = $result->fetch_assoc()) {

        /**Preenchimento dos itens do formulário*/

        $value=strftime("%H:%M:%S", strtotime($row['data_log']));
        $content=str_replace("_horaInicio_",$value,$content);

        $texto=explode(" ",$row['texto']);

        if($texto[0]=="Editar"){
            $linhas="";

            $original=[];
            $sql2="select array from $nomeTabela where id_utilizador_log<'".$row['id_utilizador_log']."' and nome_tabela='".$row['nome_tabela']."' and id_item='".$row['id_item']."' and (texto like 'Criar%' or texto like'Editar%') order by data_log desc limit 0,1";
            $result2=runQ($sql2,$db,"COMPRACAO EDITAR/CRIAR");
            while ($row2 = $result2->fetch_assoc()) {
                $original=json_decode($row2['array']);
            }

            $editado=json_decode($row['array']);

            foreach ($original as $key_original=>$value_original){
                if($key_original!="pass" && $key_original!="pass_inicial"){
                    foreach ($editado as $key_editado=>$value_editado){
                        if($key_editado==$key_original){
                            $linhas.=$linha;
                            $linhas=str_replace("_coluna_",$key_original,$linhas);
                            $linhas=str_replace("_antes_",$value_original,$linhas);
                            $linhas=str_replace("_depois_",$value_editado,$linhas);

                            $cor="";
                            if($value_editado!=$value_original){
                                $cor="success";
                            }
                            $linhas=str_replace("_alterada_",$cor,$linhas);
                        }
                    }
                }
            }
            $tabela=str_replace("_linhas_",$linhas,$tabela);
            $content=str_replace("_tabela_",$tabela,$content);
        }else{
            $linhas="";
            $array=@json_decode($row['array'],true);
            if(is_array($array)){
                foreach ($array as $key=>$value){
                    if($key!="pass" && $key!="pass_inicial"){
                        $linhas.=$linha;
                        $linhas=str_replace("_coluna_",$key,$linhas);
                        $linhas=str_replace("_antes_","-",$linhas);
                        $linhas=str_replace("_depois_",$value,$linhas);
                        $linhas=str_replace("_alterada_","",$linhas);
                    }
                }
                $tabela=str_replace("_linhas_",$linhas,$tabela);
                $content=str_replace("_tabela_",$tabela,$content);
            }
        }

        $sql2="select * from utilizadores where id_utilizador='".$row['id_utilizador']."'";
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