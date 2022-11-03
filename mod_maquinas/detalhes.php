<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("detalhes.tpl");

$content=str_replace("_idItem_",$id,$content);

$sql="select $nomeTabela.* from $nomeTabela where id_$nomeColuna='$id'";
$result=runQ($sql,$db,"VERIFICAR EXISTENTE");
if($result->num_rows!=0){
    while ($row = $result->fetch_assoc()) {/**Preenchimento dos itens do formulário*/

        include ("_criar_editar_detalhes.php");



        $assistencias_clientes_maquinas = getInfoTabela('assistencias_clientes_maquinas inner join assistencias_clientes using(id_assistencia_cliente)',
            " and id_maquina='$id' and assinado = 1 order by created_at desc",'','','',
            'assistencias_clientes_maquinas.*, assistencias_clientes.data_inicio, assistencias_clientes.data_fim'); //

        $linha_tpl = '<li class="linha" id_assistencia_cliente_maquina="_id_assistencia_cliente_maquina_" onclick="OpenModalMostrarDetalhesMaquinaHistorico(this)">
                <div class="timeline-time"><b>_tempo_ </b></div>
                <div class="timeline-content">
                    <p class="push-bit"><strong>_data_</strong></p>
                    <p class="push-bit">_tecnico_</p>
                </div>
                
                <a  href="#">  <i class="fa fa-play"></i> </a> 
                
            </li>';

        /* $ok = "<div class='linha' id_assistencia_cliente_maquina='$inserted_id'>
           <span><strong>".$maquina['nome_maquina']."</strong> <br> ".$maquina['descricao_maquina']." </span>

           <a onclick='OpenModalAddMaquina(this)' href='#'>  <i class='fa fa-play'></i> </a>
        </div>";*/

        $linhas = "";
        foreach($assistencias_clientes_maquinas as $assistencia_cliente_maquina){

            $linha_tmp = $linha_tpl;

            $data_inicio = data_portuguesa_real($assistencia_cliente_maquina['data_inicio'], 1);
            $data_fim = data_portuguesa_real($assistencia_cliente_maquina['data_fim'], 1);
            $data = $data_inicio.' - '.$data_fim;
            //$data = data_portuguesa_real($assistencia_cliente_maquina['created_at'], 1);
            $tecnico = getInfoTabela('utilizadores', ' and id_utilizador="'.$assistencia_cliente_maquina['id_criou'].'"');
            $nome_tecnico = $tecnico[0]['nome_utilizador'];


            /*$str_time_atual = strtotime(current_timestamp);
            $str_time_assistencia = strtotime($assistencia_cliente_maquina['created_at']);

            $tempo_que_passou = $str_time_atual - $str_time_assistencia;*/

            $str_time_final = strtotime($data_fim);
            $str_time_inicial = strtotime($data_inicio);

            $tempo_que_passou = $str_time_final - $str_time_inicial;

            $dias_passados = round($tempo_que_passou / (60 * 60 * 24));


            if($dias_passados < 1){
                $dias_passados="Hoje";
            }elseif($dias_passados >= 1 && $dias_passados < 2){
                $dias_passados = "Ontem";
            }else{
                $dias_passados=$dias_passados.' dias atrás';
            }

            //$date = strtotime(date("Y-m-d", strtotime("-".$dias_passados." day")));

            $tempo_atras="1 Semana";
            $linha_tmp=str_replace('_tempo_',$dias_passados, $linha_tmp);
            $linha_tmp=str_replace('_data_',$data, $linha_tmp);
            $linha_tmp=str_replace('_tecnico_',$nome_tecnico, $linha_tmp);

            $linha_tmp=str_replace('_id_assistencia_cliente_maquina_',$assistencia_cliente_maquina['id_assistencia_cliente_maquina'], $linha_tmp);


            $linhas.=$linha_tmp;
            // CONTINUAR
        }

        $content=str_replace('_linhas_',$linhas,$content);



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