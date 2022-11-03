<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("detalhes.tpl");

$content=str_replace("_idItem_",$id,$content);

$addsql_filtro = "";

if(isset($_GET['filtrar_data']) && $_GET['filtrar_data'] != "" && isset($_GET['id']) && $_GET['id'] != ""){

    $dia = json_decode($_GET['filtrar_data']);
    $dia = $db->escape_string($dia);

    $id = $db->escape_string($id);

    if($dia == 1){
        $addsql_filtro=" ";
    }else{

        $dia=str_replace('/','-',$dia);

        $transferencia_primeiro_record = getInfoTabela('viaturas_tecnicos_historico',
            "and id_viatura='$id' and DATE_FORMAT(created_at, '%d-%m-%Y') <= '$dia' order by created_at desc limit 1",''
            ,'','','*, IFNULL(data_fim, 0) as data_fim');



        if(isset($transferencia_primeiro_record[0])){
            $dia = data_portuguesa_real($transferencia_primeiro_record[0]['created_at']);

        }


        $addsql_filtro = "and DATE_FORMAT(created_at, '%d-%m-%Y') = '$dia'";

    }

}


$transferencias = getInfoTabela('viaturas_tecnicos_historico',
    "and id_viatura='$id' $addsql_filtro order by created_at desc ",''
,'','','*, IFNULL(data_fim, 0) as data_fim');

// ADICIONAR ADDSQL PELO AJAX SE NECESSARIO

$linhas="";
if(isset($transferencias[0])){
    $content=str_replace('class="sem-dados-transferencias"','class="sem-dados-transferencias hidden"',$content);

    foreach($transferencias as $transferencia){

        $de = getInfoTabela('utilizadores', "and id_utilizador = '".$transferencia['de_tecnico']."'");
        $para = getInfoTabela('utilizadores', "and id_utilizador = '".$transferencia['para_tecnico']."'");


        $data_transferencia = data_portuguesa_real($transferencia['created_at'], 1);
        $data_inicio =  data_portuguesa_real($transferencia['created_at']);

        $data_transferencia_fim = " ---- ";
        $data_fim="";
        if($transferencia['data_fim'] != "0" ){
            $data_transferencia_fim = data_portuguesa_real($transferencia['data_fim'], 1);
            $data_fim =  data_portuguesa_real($transferencia['data_fim']);
        }



        $str_time_final = strtotime(date("Y-m-d h:i:sa"));
        $str_time_inicial = strtotime($transferencia['created_at']);

        $tempo_que_passou = $str_time_final - $str_time_inicial;

        $dias_passados = round($tempo_que_passou / (60 * 60 * 24));


        if($dias_passados < 1){
            $dias_passados="Hoje";
        }elseif($dias_passados >= 1 && $dias_passados < 2){
            $dias_passados = "Ontem";
        }else{
            $dias_passados=$dias_passados.' dias atrás';
        }


        if(!isset($para[0]['nome_utilizador'])){
            $para[0]['nome_utilizador']="Sem responsavel";
        }
        if(!isset($de[0]['nome_utilizador'])){
            $de[0]['nome_utilizador']="Sem responsavel";
        }

        $linhas.='<a class="linha" style="text-decoration:none; color:#000;"
         href="../mod_assistencias/index.php?id_viatura='.$id.'&data_assistencia_iniciada='.$data_inicio.'&data_assistencia_terminada='.$data_fim.'&id_utilizador='.$para[0]['id_utilizador'].'">
                <div class="timeline-time"><b>'.$dias_passados.' </b></div>
                <div class="timeline-content" >
                    <p class="push-bit"><strong>Data da Transferência:</strong> '.$data_transferencia.'</p>
                    <p class="push-bit"><strong>Data de Fim:</strong> '.$data_transferencia_fim.'</p>
                    <span class="push-bit"><b>DE: </b> '.$de[0]['nome_utilizador'].'</span> <br>
                    <span class="push-bit"><b>PARA: </b> '.$para[0]['nome_utilizador'].'</span> 
                </div>
     
            </a>';


    }

}

if($addsql_filtro != ""){
    echo $linhas;
    die;
}

$content=str_replace('_transferencias_', $linhas, $content);

$sql="select * from $nomeTabela $innerjoin where id_$nomeColuna='$id'";
$result=runQ($sql,$db,"VERIFICAR EXISTENTE");
if($result->num_rows!=0){
    while ($row = $result->fetch_assoc()) {/**Preenchimento dos itens do formulário*/

        include ("_criar_editar_detalhes.php");

        /**FIM Preenchimento dos itens do formulário*/





        $content=replaces_no_formulario($content,$row,$nomeTabela,$nomeColuna,$db);
    }

    /**Preenchimento dos itens do formulário*/

    //

    /**FIM Preenchimento dos itens do formulário*/


    $pageScript='<script src="detalhes.js"></script>';
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod 2","Não foi encontrado nenhum registo com o ID:".$id,""));
}
include ('../_autoData.php');