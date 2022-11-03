<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("criar.tpl");
$content=str_replace("_descricao_","",$content);

/**Preenchimento dos itens do formulário **/

include ("_criar_editar_detalhes.php");

/**FIM Preenchimento dos itens do formulário **/



/**  FILTROS ADICIONAIS */


$tabelas_ignorar=[
    '_conf_assists',
    '_conf_cliente',
    '_conf_imap',
    '_conf_plataforma',
    'utilizadores_conf',
    '_conf_assists_datas_bloqueadas',
    '_conf_estado_plataforma',
    '_conf_ip_whitelist',
    '_emails_enviados',
    'backups',
    'calendario',
    'form_encomenda',
    'grupos',
    'grupos_mensagens',
    'grupos_modulos_funcionalidades',
    'grupos_utilizadores',
    'imap',
    'imap_spam',
    'mod_perfis',
    'modulos',
    'modulos_funcionalidades',
    'notificacoes',
    'pastas',
    'pastas_documentos',
    'pastas_documentos_grupos',
    'pastas_ficheiros',
    'pecas',
    'pecas_linhas',
    'relatorios',
    'srv_clientes_notas_old',
    'utilizadores_logs',
    'utilizadores_mensagens',
    'utilizadores_notificacoes',
    'utilizadores_recuperacao',
];

$tabelas_visiveis=[];
$sql="show tables";
$result=runQ($sql,$db,"tabelas");
while($row = $result->fetch_assoc()) {
    foreach ($row as $key => $table) {
        if(in_array($table,$tabelas_ignorar)){
            continue;
        }

        $colunas=[];

        $sql2="SHOW COLUMNS FROM $table";
        $result2=runQ($sql2,$db,"colunas");
        while($row2 = $result2->fetch_assoc()) {
            $coluna=$row2['Field'];
            //se for uma colua id_
            if(substr($coluna, 0, 3)=="id_" && $coluna!="id_assistencia"){

                $sql_outras="show tables";
                $result_outras=runQ($sql_outras,$db,"outras");
                while($row_outras = $result_outras->fetch_assoc()) {
                    foreach ($row_outras as $key_outra => $outra_tabela) {
                        if($outra_tabela!=$table){

                            $sql_cols="SHOW INDEX FROM $outra_tabela";
                            $result_cols=runQ($sql_cols,$db,"cols das outaras");
                            while($row_cols = $result_cols->fetch_assoc()) {

                                if($row_cols['Column_name']=="id_srv_cliente"){
                                    $row_cols['Column_name']="id_cliente";
                                }
                                if($coluna=="id_tecnico") {
                                    if ($row_cols['Key_name'] == 'PRIMARY' && $row_cols['Column_name'] == 'id_utilizador') {
                                        $colunas['id_tecnico'] = ['tabela' => $outra_tabela, 'coluna' => $row_cols['Column_name']];
                                    }
                                }else{
                                    if ($row_cols['Key_name'] == 'PRIMARY' && $row_cols['Column_name'] == $coluna) {
                                        $colunas[$coluna] = ['tabela' => $outra_tabela, 'coluna' => $row_cols['Column_name']];
                                    }
                                }
                            }

                        }
                    }
                }

            }
        }

        $tabelas_visiveis[$table]=$colunas;
    }
}


$columnsToIgnore=[
    'id_criou'=>'id_criou',
    'nome_viatura'=>'nome_viatura',
    'obras'=>'obras',
    'id_editou'=>'id_editou',
    'updated_at'=>'updated_at',
    'created_at'=>'created_at',
    //'ativo'=>'ativo',
    'id_cliente'=>'id_cliente',
    'id_assistencia'=>'id_assistencia',
    'id_cartao'=>'id_cartao',
    'FamilyID'=>'FamilyID',
    'SupplierID'=>'SupplierID',
    'id_projeto'=>'id_projeto',
    'id_ponto_obra'=>'id_ponto_obra',
    'id_operacoes'=>'id_operacoes',
    'WarehouseID'=>'WarehouseID',
    'id_elemento'=>'id_elemento',
    'id_elemento_fase'=>'id_elemento_fase',
    'id_fase'=>'id_fase',
    'id_equipa'=>'id_equipa',
    //'data_preenchido'=>'data_preenchido',
    //'data_preaprovado'=>'data_preaprovado',
    //'preaprovado'=>'preaprovado',
    //'data_aprovado'=>'data_aprovado',
    //'id_preaprovou'=>'id_preaprovou',
    'nome_tabela'=>'nome_tabela',
    'nome_coluna'=>'nome_coluna',
    'id_registo'=>'id_registo',
    'id_utilizador'=>'id_utilizador',
    'pass'=>'pass',
    'last_seen'=>'last_seen',
    'verificado'=>'verificado',
    'verification_token'=>'verification_token',
    'system'=>'system',
    'data_verificado'=>'data_verificado',
    'foto'=>'foto',
    'ip_acesso'=>'ip_acesso',
    'pass_inicial'=>'pass_inicial',
    'assinatura'=>'assinatura',
    'id_viatura'=>'id_viatura',
    'id_ficha_ponto'=>'id_ficha_ponto',
    'id_despesa'=>'id_despesa',
    'id_material'=>'id_material',
    'destacar'=>'destacar',
    'id_producao'=>'id_producao',
    'id_tipo_cabo'=>'id_tipo_cabo',
    'id_tipo_elemento'=>'id_tipo_elemento',
    'id_tipo_junta'=>'id_tipo_junta',
    'id_producao_material'=>'id_producao_material',
    'id_producao_tarefa'=>'id_producao_tarefa',
    'id_tarefa'=>'id_tarefa',
    'id_utilizador_viatura'=>'id_utilizador_viatura',
    'id_registo_original'=>'id_registo_original',
    'id_pagou'=>'id_pagou',
    'id_enviou'=>'id_enviou',
    'obs_preaprovado'=>'obs_preaprovado',
    //'aprovado'=>'aprovado',
    //'obs_aprovado'=>'obs_aprovado',
    //'id_aprovou'=>'id_aprovou',
    'id_modulo'=>'id_modulo',
    'id_operador'=>'id_operador'];


$arr_final=[]; // ARRAY FINAL COM TODAS AS LIGACOES

foreach ($tabelas_visiveis as $tabela => $colunas){

    if(!isset($arr_final[$tabela])){
        $arr_final[$tabela]=array();
    }


    foreach ($colunas as $coluna_pai => $ligacao){
        $ligacao['tabela'];
        $ligacao['coluna'];

        if(!isset($arr_final[$tabela][$coluna_pai])){
            $arr_final[$tabela][$coluna_pai]=array();
        }
        if(!empty($colunas)){
            array_push($arr_final[$tabela][$coluna_pai],$ligacao);
        }

        foreach ($tabelas_visiveis as $tabela_filho => $val){

            if($tabela_filho==$ligacao['tabela']){

                $push=[
                    'tabela'=>$tabela,
                    'coluna'=>$coluna_pai,
                ];

                if(!isset($arr_final[$tabela_filho][$ligacao['coluna']])){
                    $arr_final[$tabela_filho][$ligacao['coluna']]=[];
                }

                array_push($arr_final[$tabela_filho][$ligacao['coluna']],$push);

            }
        }
        //$innserjoin=' inner join '.$ligacao['tabela'].' on '.$ligacao['tabela'].".".$ligacao['coluna']."=".$tabela_pai.".".$coluna_pai;
    }

}

if(isset($_GET['double_check_relaccoes'])){
    $selecionadas = explode(',', $_GET['selecionadas']);
    foreach ($selecionadas as $selecionada){
        if($selecionada=="" || $selecionada==" "){
            continue;
        }

        $tabelas_ja_mostradas[]=$selecionada;
        foreach($arr_final[$selecionada] as $coluna => $ligacoes) {
            foreach ($ligacoes as $ligacao) {

                if (in_array($ligacao['tabela'], $tabelas_ja_mostradas)) {
                    continue;
                }
            }
        }
    }
}



if(isset($_GET['get_relacoes_da_tabela'])){

    $json_com_colunas_selecionadas = $_GET['json_com_colunas_selecionadas'];
    $json_com_colunas_selecionadas=json_decode($json_com_colunas_selecionadas,true);

    $selecionadas = explode(',', $_GET['selecionadas']);

    $selecionadaAtual="";
    if(isset($_GET['selecionadaAtual'])){
        $selecionadaAtual = $_GET['selecionadaAtual'];
    }

    $selects="";

    $linha_relacoes='<div class="block">
            <div class="block-title"><h4>Tabelas Relacionadas com <b class="text-info">_NOMETABELA_</b></h4></div>
            <div class="block-section row">
                <div class="col-lg-12 " >
                    <div>
                        _TABELAS_
                    </div>
                </div>
            </div>

        </div>';
    $relacoes="";

    $tabelas_ja_mostradas=[];

    foreach ($selecionadas as $selecionada){

        $tabelas_para_relacoes="";
        if($selecionada=="" || $selecionada==" "){
            continue;
        }

        $tabelas_ja_mostradas[]=$selecionada;

        foreach($arr_final[$selecionada] as $coluna => $ligacoes){


            foreach($ligacoes as $ligacao){

                if(in_array($ligacao['tabela'],$tabelas_ja_mostradas)){
                    continue;
                }

                $tabelas_ja_mostradas[]=$ligacao['tabela'];

                $columnsToIgnore2 = $columnsToIgnore;

                if($ligacao['tabela'] == "producao"){
                    unset($columnsToIgnore2['obs_preaprovado']);
                    unset($columnsToIgnore2['aprovado']);
                    unset($columnsToIgnore2['obs_aprovado']);
                    unset($columnsToIgnore2['id_aprovou']);
                }

                $colunas2 = listTable($ligacao['tabela'], $columnsToIgnore2);

                $dataRelacoes = "";
                // SELECIONADA ATUAL
                foreach($arr_final[$ligacao['tabela']] as $coluna3 => $ligacoes3) {
                    // DATA RELACOES
                    foreach($ligacoes3 as $ligacao3) {
                        $dataRelacoes .= $ligacao3['tabela'] . ',';
                    }

                }
                $dataRelacoes = substr($dataRelacoes, 0, -1);

                $htmlTable = "";
                foreach($colunas2 as $coluna2){

                    $colunatxt = "";
                    $colunatxt = str_replace('_',' ',$coluna2);
                    $colunatxt = ucwords($colunatxt);

                    $checked_coluna="";
                    foreach ($json_com_colunas_selecionadas as $colunas_escolhidas){
                        if($colunas_escolhidas['tabela']==$ligacao['tabela']){
                            foreach ($colunas_escolhidas['colunas'] as $cl){
                                if($cl==$coluna2){
                                    $checked_coluna= "checked";
                                    break;
                                }
                            }
                        }
                    }

                    $htmlTable.="<div class='checkboxes_colunas' style='cursor: pointer;' onclick='selecionar_checkbox(this)'><input $checked_coluna class='colunas_da_tabela_secundaria' onclick='build_json_com_colunas_selecionadas()' type='checkbox'  value='$coluna2'> $colunatxt </div>";
                }

                $tabelatxt = "";
                $tabelatxt = str_replace('_',' ',$ligacao['tabela']);
                $tabelatxt = strtoupper($tabelatxt);

                $checked_tabela="";
                $mostrar_colunas="display: none";
                if(in_array($ligacao['tabela'],$selecionadas)){
                    $checked_tabela="checked";
                    $mostrar_colunas="display: block";
                }

                $tabelas_para_relacoes.="
                        <div style='margin-bottom: 10px'>
                            <label style='width: 100%;margin-bottom: 0px;' class='parent-of-tabela-secundaria'> <input $checked_tabela data-relacoes='$dataRelacoes' data-ligacoes ='inner join ".$ligacao['tabela']." on ".$selecionada.".".$coluna."=".$ligacao['tabela'].".".$ligacao['coluna']."' class='tabela-selecionada' type='checkbox' onclick='obter_tabelas_relacoes(this);expandir_tabela(this)' name='tabela_relacao[]' value='".$ligacao['tabela']."' > ".$tabelatxt."</label> 
                            <div class='colunas_escondidas' style='$mostrar_colunas'> $htmlTable</div>
                       
                       </div> ";

            }
        }

        if($tabelas_para_relacoes==""){
            continue;
        }

        $relacoes.=$linha_relacoes;
        $relacoes=str_replace("_TABELAS_",$tabelas_para_relacoes,$relacoes);
        $nome=strtoupper($selecionada);
        $nome=str_replace("_"," ",$nome);
        $relacoes=str_replace("_NOMETABELA_",$nome,$relacoes);

    }

    print $relacoes;



    die();
}


$arrayTabelasEmQuery = [];






$opcoesTabelas = "";
foreach($arr_final as $tabela => $colunas){

    $columnsToIgnore2 = $columnsToIgnore;

    if($tabela == "producao"){

        unset($columnsToIgnore2['obs_preaprovado']);
        unset($columnsToIgnore2['aprovado']);
        unset($columnsToIgnore2['obs_aprovado']);
        unset($columnsToIgnore2['id_aprovou']);

    }

    $colunas = listTable($tabela, $columnsToIgnore2);


    $tabelatxt = "";
    $tabelatxt = str_replace('_',' ',$tabela);
    $tabelatxt = strtoupper($tabelatxt);

    $tabelas.= "<option value='$tabela'>$tabelatxt</option>";

    $htmlTable = "";
    foreach($colunas as $coluna){
        $colunatxt = "";
        $colunatxt = str_replace('_',' ',$coluna);
        $colunatxt = ucwords($colunatxt);
        $htmlTable.="<div class='parent-of-tabela-relacoes' class='checkboxes_colunas' style='cursor: pointer;' onclick='selecionar_checkbox(this)'><input class='coluna_da_tabela_pai' onclick='build_json_com_colunas_selecionadas()' type='checkbox'  value='$coluna'> $colunatxt</div>";
    }



    $htmlTable="<div  class='tabela-relacoes'>$htmlTable</div>";

    //tabelas pai
    $opcoesTabelas.="<div class='col-lg-12'><div class='parent-of-tabela-principal'><label style='width: 100%'><input type='radio'  class='tabela-selecionada-principal' id='tabela_pricipal' name='tabela_principal' value='$tabela' onclick='obter_tabelas_relacoes(this,true)'> $tabelatxt</label></div>
       $htmlTable
        </div>";
}

$jsonArrayFinal = json_encode($arr_final);

$content=str_replace('_primeirastabelas_', $opcoesTabelas,$content);
$content=str_replace('_configurador_', '',$content);




$condicoes = "
<option value='='>igual a</option>
<option value='>'>maior do que</option>
<option value='<'>menor do que</option>
<option value='>='>maior ou igual a</option>
<option value='<='>menor ou igual a</option>
";



if(isset($_GET['getCampos'])){

    $columnsToIgnore2 = [];

    if($ligacao['tabela'] == "elementos_fases"){
        $columnsToIgnore2 = [
            'obs_preaprovado'=>'obs_preaprovado',
            'aprovado'=>'aprovado',
            'obs_aprovado'=>'obs_aprovado',
            'id_aprovou'=>'id_aprovou'
        ];

    }


    $colunas = listTable($_GET['getCampos'], $columnsToIgnore2);
    $linhasColunas = "";
    foreach($colunas as $coluna){
        $colunatxt = "";
        $colunatxt = str_replace('_',' ',$coluna);
        $colunatxt = ucwords($colunatxt);
        $linhasColunas.= "<option value='$coluna'>$colunatxt</option>";
    }

    echo $linhasColunas;
    die;
}



$linha="
 <div class='grupo-condicao-pai col-lg-12 block'>
    <div style='display: flex'>
        <select class='group-and-or select select-select2' style='width: 100%; margin-right: 32px;'>
               <option value='and'>And</option>
               <option value='or'>Or</option>
        </select>
        <div class='text-center remove-grupo' style='align-self:center; float: right; margin-left:auto;'><a href='javascript:void(0)' onclick='removerGrupo(this);' class='btn btn-xs btn-danger add-or-remove'><i class='fa fa-times'></i></a></div>
    </div>
 
  <div class='grupo-condicao col-lg-12'>
 

        <div class='subgrupo col-lg-4'>
            <div class='valores_condicoes'>
                <div class='text-center remove-linha'><a href='javascript:void(0)' onclick='removerLinha(this);' class='btn btn-xs btn-danger add-or-remove'><i class='fa fa-times'></i></a></div>
                <div>
                <label>Tabela</label>
                <select class='select select-select2 tabela-grupo-condicao' style='width: 100%' onchange='getCamposTabela(this)'></select></div>
                <div>
                <label>Coluna</label>
                <select class='select select-select2 coluna-grupo-condicao' style='width: 100%'>$colunas</select></div>
                <div>
                    <label>Condicao</label>
                    <select class='select select-select2 grupo-condicao-condicao'>
                        <option value='='>igual a</option>
                        <option value='like'>contém</option>
                        <option value='>'>maior do que</option>
                        <option value='<'>menor do que</option>
                        <option value='>='>maior ou igual a</option>
                        <option value='<='>menor ou igual a</option>
                        
                    </select>
                </div>
                <div>
                    <label>Valor</label>
                    <input value='0' class='form-control valor-condicao'>
                </div>
            </div>
            
        </div>
         <a href='javascript:void(0)' class='add-condicao-subgrupo btn btn-success' onclick='addSubgrupo(this)'>Adicionar condicão</a>
    </div>
</div>
 ";


$subgrupo = " <div class='subgrupo col-lg-4'>

            <div>
                <select class='subgroup-and-or select select-select2 '>
                    <option value='and'>And</option>
                    <option value='or'>Or</option>
                </select>
            </div>

            <div class='valores_condicoes'>
                <div class='text-center remove-linha'><a href='javascript:void(0)' onclick='removerLinhaSubgrupo(this);' class='btn btn-xs btn-danger add-or-remove'><i class='fa fa-times'></i></a></div>
                <div><label>Tabela</label><select class='select select-select2 tabela-grupo-condicao' style='width: 100%' onchange='getCamposTabela(this)'></select></div>
                <div><label>Coluna</label><select class='select select-select2 coluna-grupo-condicao' style='width: 100%'></select></div>
                <div>
                <label>Condicao</label>
                    <select class='select select-select2 grupo-condicao-condicao'>
                        <option value='='>igual a</option>
                        <option value='like'>contém</option>
                        <option value='>'>maior do que</option>
                        <option value='<'>menor do que</option>
                        <option value='>='>maior ou igual a</option>
                        <option value='<='>menor ou igual a</option>
                    </select>
                </div>
                <div>
                    <label>Valor</label><input value='0' class='form-control valor-condicao'>
                </div>
            </div>
        </div>";

include "gerar_relatorio.php";


/*
$linhaExtra = "
<div class='linha col-lg-4'>
    <div class='text-center remove-linha'><a href='javascript:void(0)' onclick='removerLinhaExtra(this);' class='btn btn-xs btn-danger add-or-remove'><i class='fa fa-times'></i></a></div>
    <div><select class='select select-select2 tabela-grupo-condicao' name='tabela_condicoes[]' onchange='getCamposTabela(this)'>_tabelascondicoes_</select></div>
    <div><select class='select select-select2 coluna-grupo-condicao' name='campo_tabela_condicoes[]'>_campostabela_</select></div>
    <div><select class='select select-select2' name='condicao[]'>'.$condicoes.'</select></div>
    <div><input name='valor_condicao[]' value='0' class='form-control valor-condicao'></div>

    <div> <a onclick='addLinhaExtra(this)' href='javascript:void(0)'>Adicionar condicao extra</a></div>
        <!-- <a onclick='addLinhaExtra(this)' href='javascript:void(0)' name='condicao_extra[]'>And</a>
         <a onclick='addLinhaExtra(this)' href='javascript:void(0)' name='condicao_extra[]'>Or</a>
        -->

</div>"; */




$content=str_replace("_linhacondicao_",$linha,$content);

$content=str_replace("_subgrupo_",$subgrupo,$content);


$content=str_replace("_condicoes_",$condicoes,$content);

$content=str_replace("_tabelascondicoes_",$tabelas,$content);

//$content=str_replace("_linha_",$linha,$content);

$cats="";
$sql="select distinct(categoria) as cat from relatorios where ativo=1";
$result = runQ($sql, $db, "SELCET categorias");
while ($row = $result->fetch_assoc()) {
    $cats.='"'.$row['cat'].'",';
}
$cats=substr($cats, 0, -1)."";

$pageScript='

<script src="index.js"></script>
<script>

var cats = ['.$cats.'];
autocomplete(document.getElementById("categoria"), cats);

</script>

';
include ('../_autoData.php');