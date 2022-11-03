<?php
include ('../_template.php');


if(isset($_GET['gerar_pdf'])){
    $id = $db->escape_string($_GET['gerar_pdf']);

    print_r(GerarPdfAssistencia($id));


}


/** meter já os clientes no select */
$sql_preencher="select * from srv_clientes where ativo=1 
                             and OrganizationName <> ''
                             and id_cliente";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {
    $ops.="<option class='id_cliente' value='".$row_preencher["id_cliente"]."'>".($row_preencher["OrganizationName"])."</option>";
}
$layout=str_replace("_clientes_",$ops,$layout);

if(isset($_GET['adicionar_maquina']) && isset($_GET['id_assistencia_cliente']) && $_GET['id_assistencia_cliente'] != ""){

    $id_assistencia_cliente = $db->escape_string($_GET['id_assistencia_cliente']);
    $id_cliente = getInfoTabela('assistencias_clientes', ' and id_assistencia_cliente = "'.$id_assistencia_cliente.'" and ativo=1');
    $id_cliente = $id_cliente[0]['id_cliente'];

    $ops="";
    $maquinas = getInfoTabela('maquinas'," and id_cliente ='$id_cliente' and ativo=1 and id_maquina not in 
    (select id_maquina from assistencias_clientes_maquinas where id_assistencia_cliente = '$id_assistencia_cliente' and ativo=1)");

    foreach($maquinas as $maquina){

        $concluido_html="";
        $nao_concluidos=getInfoTabela('assistencias_clientes_maquinas'," and ativo=1 and concluido=0 and id_maquina='".$maquina["id_maquina"]."'");
        if(count($nao_concluidos)>0){
            $concluido_html="[NÃO CONCLUÍDO]";
        }

        $ops.="<option class='id_maquina' value='".$maquina["id_maquina"]."'>".$maquina["nome_maquina"]." (".$maquina["ref"].") $concluido_html</option>";
    }

    echo $ops;
    $db->close();
    die;
}


if(isset($_POST['nome_maquina']) || isset($_POST['id_cliente'])){

   $nome_maquina = $db->escape_string($_POST['nome_maquina']);
   $id_cliente = $db->escape_string($_POST['id_cliente']);
   $ref = $db->escape_string($_POST['ref']);
   $descricao = $db->escape_string($_POST['descricao']);

   $inserted_id = insertIntoTabela('maquinas','nome_maquina, id_cliente, ref, descricao', "'$nome_maquina','$id_cliente', '$ref', '$descricao'");


   $op = "";
   if($inserted_id){
       $op='<option class="id_maquina" value="'.$inserted_id.'">'.$nome_maquina.'</option>';
   }

   echo $op;

   return;


}

if(isset($_GET['mostrar_detalhes_cliente']) && $_GET['mostrar_detalhes_cliente'] != ""){

    $content=file_get_contents("detalhes_cliente.tpl");

    $id_cliente = $db->escape_string($_GET['mostrar_detalhes_cliente']);
    $cliente = getInfoTabela('srv_clientes' ,' and PartyID="'.$id_cliente.'"');

    $info="";
    if(isset($cliente[0])) {
        $row = $cliente[0];

        if($row['Telephone2'] == "" || $row['Telephone2'] == "XXX"){
            $row['Telephone2'] = "Não definido";
        }

        if($row['EmailAddress'] == "" || $row['EmailAddress'] == "XXX"){
            $row['EmailAddress'] = "Não definido";
        }

        if($row['morada'] == "" || $row['morada'] == "XXX"){
            $row['morada'] = "Não definido";
        }
        if($row['local'] == "" || $row['local'] == "XXX"){
            $row['local'] = "Não local";
        }
        if($row['cdpostal'] == "" || $row['cdpostal'] == "XXX"){
            $row['cdpostal'] = "Não definido";
        }

        if($row['morada2'] != ""){
            $row['morada2']='<div>Morada2: <small class="text-muted">'.$row['morada2'].'</small></div>';
        }

        $info = '  <div class="col-lg-12" style="display: block;">
         
            <div class="row ">
             <br>
                   <div class="col-lg-12" > 
                    <ul class="nav nav-tabs" data-toggle="tabs">
                        <li class="active"><a href="#_empresa_c"><i class="fa fa-phone-square"></i> Contactos</a></li>
                        <li><a href="#_empresa_m"><i class="fa fa-map-signs"></i> Moradas</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="_empresa_c">
                        
                            <div>Telefone: <small class="text-muted">'.$row['Telephone2'].'</small></div>
                            <div>Email: <small class="text-muted">'.$row['Telephone2'].'</small></div>
                        
                        </div>
                        <div class="tab-pane" id="_empresa_m">
                        
                          <div>País: <small class="text-muted">'.$row['pais'].'</small></div>
                          <div>Localidade: <small class="text-muted">'.$row['local'].'</small></div>
                          <div>Morada: <small class="text-muted">'.$row['morada'].'</small></div>
                          '. $row['morada2'].' 
                          <div>Codigo Postal: <small class="text-muted">'.$row['cdpostal'].'</small></div>
                          
                            
                        
                        </div>
                        
                    </div>
                    <br>
                </div>
              
            </div>
        
        </div>';

    }

    $content = str_replace("_nomecliente_", ($cliente[0]['OrganizationName']) , $content);
    $content = str_replace("_info_", $info , $content);


    // GET MAQUINAS DO CLIENTE
    $ops="";


    $maquinas = getInfoTabela('maquinas'," and id_cliente ='$id_cliente'");

    $linhas_maquinas=' <div class="sem-dados-maquinas">
                <div class="well well-sm text-center"><i class="text-muted"> Sem máquinas atribuídas</i>  </div>
            </div>';

    if(isset($maquinas[0])){
        $linhas_maquinas="";


        foreach($maquinas as $maquina){

                $maquina['descricao_maquina'] = (strlen($maquina['descricao_maquina']) > 60) ? substr($maquina['descricao_maquina'],0,57).'...' : $maquina['descricao_maquina'];
                $maquina['defeitos'] = (strlen($maquina['defeitos']) > 60) ? substr($maquina['defeitos'],0,57).'...' : $maquina['defeitos'];

                $garantia="<small class='text-muted'>Sem garantia</small>";
                if($maquina['garantia']==1){
                    $garantia="<span class='label label-danger'><i class='fa fa-warning'></i> Garantia</span>";
                }

                $linhas_maquinas.=" 
                <div class='linha' onclick='OpenModalHistoricoMaquina(".$maquina['id_maquina'].")' id_maquina='".$maquina['id_maquina']."'>
                   <span>
                   <strong>".$maquina['nome_maquina']."</strong> (".$maquina['ref'].") <br> 
                   <small class='text-muted'>Obs:</small><i class='text-info'> ".$maquina['descricao_maquina']."</i> <br>
                   </span> 
                   
                   <a  href='#'>  <i class='fa fa-play'></i> </a> 
                </div>
      
         ";

        }

    }


    $content=str_replace('_maquinas_', $linhas_maquinas,$content);


    /* ASSISTENCIAS INICIADAS */

    $assistencias_clientes = getInfoTabela('assistencias_clientes',
        "  and id_cliente='$id_cliente' and assinado=1 and ativo=1 order by data_inicio desc ");


    $linha_assistencia_clientes = "";

    $linhas=' <div class="sem-dados-assistencias-clientes">
                <div class="well well-sm text-center"><i class="text-muted"> Sem assistências </i>  </div>
            </div>';

    if(isset($assistencias_clientes[0])){
        $linhas="";

    foreach($assistencias_clientes as $assistencias_cliente){

        $id_assistencia_cliente = $assistencias_cliente['id_assistencia_cliente'];

        $tipo_assistencia = "<small class='label label-default'><i class='fa fa-truck'></i> Externa</small>";
        if($assistencias_cliente['externa'] == "0"){
            $tipo_assistencia = "<small class='label label-danger'><i class='fa fa-home'></i> Interna</small>";
        }

        $data_inicio="";
        if($assistencias_cliente['data_inicio']!="0000-00-00 00:00:00"){
            if(date("d/m/Y", strtotime($assistencias_cliente['data_inicio']))==date("d/m/Y", strtotime(current_timestamp))){
                $data_inicio = "Hoje às ".date("H:i", strtotime($assistencias_cliente['data_inicio']));
            }elseif(date("d/m/Y", strtotime($assistencias_cliente['data_inicio']))==date("d/m/Y", strtotime(current_timestamp. ' -1 days'))){
                $data_inicio = "Ontem às ".date("H:i", strtotime($assistencias_cliente['data_inicio']));
            }else{
                $data_inicio = $cfg_diasdasemana[date("w", strtotime($assistencias_cliente['data_inicio']))]."/".date("d, H:i", strtotime($assistencias_cliente['data_inicio']));
            }

            $data_inicio="$data_inicio";
        }

        $categoria = getInfoTabela('assistencias_categorias', ' and id_categoria = "'.$assistencias_cliente['id_categoria'].'"');
        $nome_categoria="<small class='label' style='background: black'>Sem categoria</small>";
        if(isset($categoria[0])){
            $nome_categoria="<small class='label' style='background: ".$categoria[0]['cor_cat']."'>".$categoria[0]['nome_categoria']."</small>";
        }

        $tecnico = getInfoTabela('utilizadores', ' and id_utilizador="'.$assistencias_cliente['id_utilizador'].'"');
        $nome_tecnico = $tecnico[0]['nome_utilizador'];

        $descricao=nl2br($assistencias_cliente['descricao']);
        if($descricao!=""){
            $descricao="<br><code><small>$descricao</small></code>";
        }

        $maquinas="";
        $maquinas_assistencia=getInfoTabela('assistencias_clientes_maquinas', ' and ativo=1 and id_assistencia_cliente = "'.$id_assistencia_cliente.'"');
        foreach ($maquinas_assistencia as $ma){
            $maquina=getInfoTabela('maquinas', ' and id_maquina= "'.$ma['id_maquina'].'"');
            $maquina=$maquina[0];

            $garantia="";
            if($ma['garantia']==1){
                $garantia="<small class='text-warning garantia-info'><i class='fa fa-warning'></i> Garantia</small>";
            }

            $concluido="";
            if($ma['concluido']==0){
                $concluido="<small class='text-danger garantia-info'><i class='fa fa-warning'></i> Não Concluído</small>";
            }

            $revisao="";
            if($ma['revisao_periodica']==1){
                $revisao="<small class='text-info garantia-info'>Revisão: ".number_format($ma['horas_revisao'],0,"",".")."h </small>";
            }

            $maquinas.="<br><small>".$maquina['nome_maquina']." (".$maquina['ref'].") $concluido $garantia $revisao</small>";
        }

        $por_terminar="";
        if($assistencias_cliente['por_terminar']==1){
            $por_terminar="<small class='text-danger '>Por terminar </small>";
        }

        if($maquinas!=""){
            $maquinas="<br><small class='text-muted'>Máquinas:</small>$maquinas";
        }

        $linhas.="
        <div class='well well-sm' style='cursor: pointer;margin-bottom: 5px' onclick='addAssistClienteMaquina(this, 1)' id_assistencia_cliente='$id_assistencia_cliente'>
           <b>$data_inicio</b> $por_terminar<br>
           $tipo_assistencia $nome_categoria<br>
                        <b>" . $assistencias_cliente['nome_assistencia_cliente'] . "</b> com <b><i class='fa fa-user'></i>$nome_tecnico</b>
                         $descricao
                         $maquinas
        </div>";

        }
    }

    $content=str_replace('_assistencias_',$linhas,$content);


    $pacotes = getInfoTabela('clientes_contratos', ' and ativo=1 and id_cliente='.$id_cliente);
    $pacotes_html="";

    foreach ($pacotes as $pacote){
        $tempo=secondsToTime($pacote['segundos_restantes']);
        $cor="text-info";
        if($pacote['segundos_restantes']<0){
            $cor="text-danger";
        }
        $pacotes_html.="<tr><td><b>".$pacote['nome_contrato']."</b></td><td style='width: 20%;' class='text-right'><b class='$cor'>$tempo</b></td></tr>";

    }
    if($pacotes_html!=""){
        $pacotes_html="
        <p class='text-center'>Contratos de horas</p>
        <table class='table table-bordered table-vcenter'>
            $pacotes_html
</table>
        ";
    }else{
        $pacotes_html="<p class='text-center text-danger'>Cliente sem contrato de horas.</p>";
    }
    $content=str_replace("_pacotes_",$pacotes_html,$content);

    echo $content;
    $db->close();
    die;

}

if(isset($_GET['ver_detalhes_assistencia']) && $_GET['ver_detalhes_assistencia'] != ""){

    $content=file_get_contents("../mod_assistencias/detalhes.tpl");
    include "../mod_assistencias/_criar_editar_detalhes.php";

    $id_assistencia = $db->escape_string($_GET['ver_detalhes_assistencia']);
    $assistencia = getInfoTabela('assistencias', ' and id_assistencia="'.$id_assistencia.'"');

    foreach($assistencia[0] as $key => $value){
        if(!is_array($value)) {

            if ($key == "data_inicio") {
                //$value = data_portuguesa($value);

                // $value=str_replace('-','/',$value);

                $content=str_replace('id="data_inicio" name="data_inicio"', 'id="data_inicio" 1 name="data_inicio" value="'.date('Y-m-d\TH:i', strtotime($value)).'"', $content);


            }


            if ($key == "data_fim") {

                $content=str_replace('id="data_fim" name="data_fim"', 'id="data_fim" 1 name="data_fim" value="'.date('Y-m-d\TH:i', strtotime($value)).'"', $content);

            }


            $arr = json_decode($value, true);
            if(is_array($arr) && count($arr) > 0) {
                foreach($arr as $val) {

                    $val = str_replace('"', "&quot;", $val);
                    $val = str_replace("'", "&apos;", $val);
                    $content = str_replace("name='" . $key . "[]' value='" . $val . "'", "name='" . $key . "[]' value='" . $val . "' checked", $content);
                    $content = str_replace("class='" . $key . "' value='" . $val . "'", "class='" . $key . "' value='" . $val . "' selected", $content);
                }
            }
            $value = str_replace('"', "&quot;", $value);
            $value = str_replace("'", "&apos;", $value);


            if($value == 1) { // para itens com cheked [ATENCAO: O NOME tem de vir antes do ID]
                $content = str_replace('name="' . $key . '" id="' . $key . '"', 'name="' . $key . '" id="' . $key . '" checked=""', $content);
            }

            // PREENCHER OS CAMPOS NORMAILS [ATENCAO: O ID tem de vir antes do NOME]
            $content = str_replace('id="' . $key . '" name="' . $key . '"', 'id="' . $key . '" name="' . $key . '" value="' . $value . '"', $content);

            // PREENCHER OS SELECTS AUTOMATICOS
            $content = str_replace("class='" . $key . "' value='" . $value . "'", "class='" . $key . "' value='" . $value . "' selected", $content);

            $content = str_replace("_" . $key . "_", $value, $content);
        }
    }

    $content=str_replace('_descricao_', "",$content);

    echo $content;

    $db->close();
    die;

}

if(isset($_GET['like'])) {

    // DESCREVER O SRV_CLIENTES
    $columns = [];
    $sql = "describe srv_clientes";
    $result = runQ($sql, $db, "");
    while($return = $result->fetch_assoc()) {
        $columns[] = "srv_clientes.".$return['Field'];
    }
    /*$sql = "describe srv_clientes_informacao";
    $result = runQ($sql, $db, "");
    while($return = $result->fetch_assoc()) {
        $columns[] = "srv_clientes_informacao.".$return['Field'];
    }*/

    $value = $db->escape_string($_GET['like']);
    $search_terms=[$value];

    $search_query="";
    if(is_array($search_terms) && count($search_terms)>0){
        foreach ($search_terms as $s){
            foreach($columns as $column) {
                $search_query.=" $column like '%$s%' or";
            }
        }
        $search_query=substr($search_query, 0, -2);
        $search_query=" and ($search_query)";
    }
    $addSql=$search_query;

    $tplCliente = '
    
     <div class="linha-pesquisa" onclick="OpenModalDetalhesCliente(\'_PartyID_\')">
         <a  href="javascript:void(0)" ><h5 ><i class="fa fa-info-user"></i> _OrganizationName_</h5></a>
    </div>
     
    
 ';



    $registos_encontrados=0;
    $sql="select count(DISTINCT(srv_clientes.FederalTaxID)) as cnt from srv_clientes  where 1 $addSql and ativo=1 and srv_clientes.PartyID != ''";
    $result = runQ($sql, $db, "");
    while($row = $result->fetch_assoc()) {
        $registos_encontrados=$row['cnt'];
    }
    $infoClientes = "<div><b>Clientes</b> ($registos_encontrados registos encontrados)</div>";


    $sql="select * from srv_clientes  where 1 $addSql and ativo=1 and srv_clientes.PartyID != '' group by srv_clientes.FederalTaxID limit 0,10";
    $result = runQ($sql, $db, "");
    while($cliente = $result->fetch_assoc()) {
        $infoClientes .= $tplCliente;

        foreach($cliente as $coluna => $valor) {

            if($coluna == "empresa"){
                if($valor == "ELAData.dbo."){
                    $valor = "BD";
                }else{
                    $valor="BD2";
                }
            }

            if($coluna == "pais"){
                $valor=str_replace('["','',$valor);
                $valor=str_replace('"]','',$valor);
            }

            if($valor == "" || $valor==" "){
                $valor="Sem atribuição";
            }


            $infoClientes = str_replace('_' . $coluna . '_', "$valor", $infoClientes);
        }




    }


    $tplMaquinas = '
    
        
      <div class="linha-pesquisa" onclick="OpenModalHistoricoMaquina(_id_maquina_)">
         <a href="javascript:void(0)" ><h5 ><i class="fa fa-info-user"></i> _nome_maquina_</h5></a>
      </div>
    
 ';


    // DESCREVER maquinas
    $columns = [];
    $sql = "describe maquinas";
    $result = runQ($sql, $db, "");
    while($return = $result->fetch_assoc()) {
        $columns[] = "maquinas.".$return['Field'];
    }

    $value = $db->escape_string($_GET['like']);
    $search_terms=[$value];

    $search_query="";
    if(is_array($search_terms) && count($search_terms)>0){
        foreach ($search_terms as $s){
            foreach($columns as $column) {
                $search_query.=" $column like '%$s%' or";
            }
        }
        $search_query=substr($search_query, 0, -2);
        $search_query=" and ($search_query)";
    }
    $addSql=$search_query;


    $registos_encontrados=0;
    $sql="select count(DISTINCT(maquinas.id_maquina)) as cnt from maquinas  where 1 $addSql and ativo=1 and maquinas.id_maquina != ''";
    $result = runQ($sql, $db, "");
    while($row = $result->fetch_assoc()) {
        $registos_encontrados=$row['cnt'];
    }
    $infoMaquinas = "<div><b>Máquinas</b> ($registos_encontrados registos encontrados)</div>";


    $sql="select * from maquinas where 1 $addSql and ativo=1 and maquinas.id_maquina != '' limit 0,10";
    $result = runQ($sql, $db, "");
    while($cliente = $result->fetch_assoc()) {
        $infoMaquinas .= $tplMaquinas;

        foreach($cliente as $coluna => $valor) {

            if($valor == "" || $valor==" "){
                $valor="Sem atribuição";
            }

            $infoMaquinas = str_replace('_' . $coluna . '_', "$valor", $infoMaquinas);
        }

    }

    $tpl = '
<div class="pesquisa-resultados">
    '.$infoClientes.'
</div>
<div class="pesquisa-resultados">
    '.$infoMaquinas.'
</div>
    ';


    print $tpl;
    $db->close();
    die;
}

// INSERIR HTML NO BODY DO MODAL DE CRIAR ASSISTENCIA
if(isset($_GET['getCriar']) && $_GET['getCriar'] != ""){

    $content=file_get_contents("../".$_GET['getCriar']."/criar.tpl");
    include "../".$_GET['getCriar']."/_criar_editar_detalhes.php";

    $content=str_replace('criar.php_addUrl_','../'.$_GET['getCriar'].'/criar.php?dashboard=1',$content);

    if(isset($_GET['viaAjax']) && $_GET['viaAjax'] == 1){ // TENTAR REMOVER O REDIRECT E INSERIR DENTRO DO SELECT2
        $content=str_replace('<button type="submit" name="submit" id="botao_loading" class="btn btn-effect-ripple btn-success pull-right btn-submit"','
        <button type="submit" name="submit" id="botao_loading" class="btn btn-effect-ripple btn-success pull-right btn-submit hidden"',$content);
        $content=str_replace('<a onclick="insertMaquinaSelect2()" class="btn btn-effect-ripple btn-success pull-right btn-submit hidden"','
        <a onclick="insertMaquinaSelect2()" class="btn btn-effect-ripple btn-success pull-right btn-submit"',$content);
    }

    $anoAtual = $data_atual->format('Y'); // APENAS O ANO

    // OBTER INFO DOS ORCAMENTOS
    $ArrayAssistencias = getInfoTabela('assistencias', 'and DATE_FORMAT(created_at, "%Y") = "'.$anoAtual.'" and ativo=1 order by id_assistencia*1 desc limit 1 ');


    $servico_n = $anoAtual.'/1';

// SE EXISTIR ORCAMENTO
    if($ArrayAssistencias[0]){  // EXEMPLO - 2021/01

        $dataDocumento = explode('/', $ArrayAssistencias[0]['nome_assistencia']); // $dataDocumento[0] é o ano


        // SE O ANO ATUAL FOR IGUAL AO ANO DO DOCUMENTO

        if($anoAtual == $dataDocumento[0]){
            $servico_n = $anoAtual.'/'.($dataDocumento[1]+1);
        }


    }

    $content=str_replace('_ordServico_',$servico_n, $content);


    $content=str_replace('_descricao_', "",$content);

    echo $content;

    $db->close();
    die;
}



if(isset($_GET['processo_troca_viatura']) && $_GET['processo_troca_viatura'] != ""){

    $resposta = 0;

    $id_viatura = $db->escape_string($_GET['processo_troca_viatura']);

    $em_processo = getInfoTabela('viaturas', "and id_viatura='$id_viatura'");

    if(isset($em_processo[0]) && $em_processo[0]['em_processo_de_troca'] == "1"){
        $resposta = 1;

        UpdateTabela('viaturas','em_processo_de_troca=0',
            " and id_viatura='$id_viatura'");

    }

    echo $resposta;

    $db->close();
    die;
}


if(isset($_GET['emprestar_viatura']) && $_GET['emprestar_viatura'] != ""
    && isset($_GET['id_tecnico']) && $_GET['id_tecnico'] != "" && $_GET['id_tecnico'] == $_SESSION['id_utilizador']){


    $id_viatura = $db->escape_string($_GET['emprestar_viatura']);
    $para_tecnico = $_SESSION['id_utilizador'];
    $viatura_anterior=getInfoTabela('viaturas'," and id_tecnico='$para_tecnico'");
    if(isset($viatura_anterior[0])){
        $viatura_anterior=$viatura_anterior[0]['id_viatura'];
    }else{
        $viatura_anterior=0;
    }

    $tecnico_atual = getInfoTabela('viaturas'," and id_viatura='$id_viatura'");
    $de_tecnico=$tecnico_atual[0]['id_tecnico'];

    //passar para o tecnico que leu a viatura
    UpdateTabela('viaturas',' id_tecnico = "'.$_SESSION['id_utilizador'].'", em_processo_de_troca=1',
        ' and id_viatura="'.$id_viatura.'"');

    UpdateTabela('viaturas_tecnicos_historico','data_fim="'.current_timestamp.'"'," and id_viatura='$id_viatura' ORDER BY id_historico DESC LIMIT 1");

    UpdateTabela('viaturas_tecnicos_historico','data_fim="'.current_timestamp.'"'," and id_viatura='$viatura_anterior' ORDER BY id_historico DESC LIMIT 1");


    //ir buscar a viatura do tecnico que leu o QR e passar para o outro
    //passar para o tecnico que leu a viatura
    UpdateTabela('viaturas',' id_tecnico = "'.$de_tecnico.'", em_processo_de_troca=1',
        ' and id_viatura="'.$viatura_anterior.'"');

    //inserir novos regisots no historico
    insertIntoTabela('viaturas_tecnicos_historico','id_viatura, de_tecnico, para_tecnico, created_at',"'$id_viatura', '$de_tecnico', '$para_tecnico', '".current_timestamp."'");

    insertIntoTabela('viaturas_tecnicos_historico','id_viatura, de_tecnico, para_tecnico, created_at',"'$viatura_anterior', '".$_SESSION['id_utilizador']."', '$de_tecnico', '".current_timestamp."'");



    echo '1';

    $db->close();
    die;
}


if(isset($_GET['data']) && $_GET['data'] != "" && isset($_GET['coluna']) && $_GET['coluna'] != ""){

    $data = $db->escape_string($_GET['data']);
    $coluna = $db->escape_string($_GET['coluna']);

    if($coluna == "data_lavagem"){
        $get_config = getInfoTabela('_conf_assists');

        $intervalo_tempo_lavagem = 15;

     //   $dias_aviso_lavagem=2;

        if(isset($get_config[0])){
            $intervalo_tempo_lavagem=$get_config[0]['intervalo_tempo_lavagem']; // 15 dias
          //  $dias_aviso_lavagem = $get_config[0]['dias_para_aviso_lavagem']; // 2 dias
        }

     //   $dia_aviso_lavagem = date('Y-m-d', strtotime('+'.$dias_aviso_lavagem.' days'));  // dia 09

        $data = date('Y-m-d', strtotime('+'.$intervalo_tempo_lavagem.' days')); // dia 22

     /*   if(strtotime($dia_aviso_lavagem) > strtotime($data)){

        }*/
            //    if(strtotime($dias_para_aviso_lavagem) > strtotime($viatura[0]['data_lavagem'])){



    }


    $msg=cortaNome($_SESSION['nome_utilizador']);
    $add_col="";
    if($coluna=="data_lavagem"){
        $msg.=" Lavou a viatura.";
        $data = data_portuguesa($data);
    }elseif($coluna=="data_seguro"){
        $msg.=" data seguro atualizada";
        $data = data_portuguesa($data);
    }elseif($coluna=="data_inspecao"){
        $msg.=" data inspeção atualizada.";
        $data = data_portuguesa($data);
    }elseif($coluna=="kms_inicio"){
        $add_col=",data_kms_atualizados='".current_timestamp."'";
        $msg.=" atualizou KM para $data.";
    }elseif($coluna=="kms_revisao"){
        $msg.=" - KM revisão atualizados.";
    }elseif($coluna=="kms_pneus"){
        $msg.=" - KM pneus atualizados.";
    }

    $viatura=getInfoTabela('viaturas',' and id_tecnico="'.$_SESSION['id_utilizador'].'"');
    $viatura=$viatura[0];
    notificar($db,$msg,"viaturas","viatura",$viatura['id_viatura'],"/mod_viaturas/detalhes.php?id=".$viatura['id_viatura'],[$_SESSION['cfg']['id_utilizador_notificar']]);

    $sql = "update viaturas set $coluna='$data' $add_col where id_viatura='".$viatura['id_viatura']."'";
    $result = runQ($sql, $db, "update");

    echo data_portuguesa_real($db->escape_string($_GET['data']));
    $db->close();
    die;

}


//FECHAR SAIDA, descontar do contrato, inserir a hora de chegada e os KM's da viatura
if(isset($_GET['terminar_assistencia']) && $_GET['terminar_assistencia'] != ""  && isset($_GET['kilometros']) && isset($_GET['data_fim'])){ //

    $id_assistencia = $db->escape_string($_GET['terminar_assistencia']);

    $assistencias_cliente = getInfoTabela('assistencias_clientes', "and id_assistencia = '$id_assistencia' and ativo=1");

    // VERIFICAR SE assinou todas
    $assistencia = getInfoTabela('assistencias', " and id_assistencia = '$id_assistencia'");
    foreach($assistencias_cliente as $assistencia_cliente){
        if($assistencia_cliente['assinado'] == '0') {
            echo '0';
            $db->close();
            die;
        }
    }

    $kms_paragens=0;
    foreach($assistencias_cliente as $assistencia_cliente){
        $kms_paragens+=$assistencia_cliente['kilometros'];
        //$segundos_a_descontar = intval((strtotime($assistencia_cliente[0]['data_assistencia_terminada'])-strtotime($assistencia_cliente[0]['data_assistencia_iniciada'])));
        $segundos_a_descontar = $assistencia_cliente['tempo_assistencia'] +  $assistencia_cliente['tempo_viagem'];

        $contrato = getInfoTabela('clientes_contratos', " and id_contrato='".$assistencia_cliente['id_contrato']."'");
        if(isset($contrato[0])){
            $segundos_atuais = $contrato[0]['segundos_restantes'] - $segundos_a_descontar;

            $balanco_anterior = $contrato[0]['segundos_restantes'];

            $id_assistencia_cliente = $assistencia_cliente['id_assistencia_cliente'];
            insertIntoTabela('clientes_contratos_carregamentos', "nome_carregamento, id_cliente, segundos, id_criou, balanco_anterior, id_assistencia_cliente, id_contrato",
                "'Referente à assistência: $id_assistencia_cliente','".$assistencia_cliente['id_cliente']."', '-$segundos_a_descontar',
                 '".$_SESSION['id_utilizador']."','$balanco_anterior', '$id_assistencia_cliente', '".$contrato[0]['id_contrato']."'");

            UpdateTabela('clientes_contratos', "segundos_restantes='$segundos_atuais'", ' and id_contrato = "'.$contrato[0]['id_contrato'].'"');

        }


    }


    $kilometros = 0;
    if($_GET['kilometros'] != ""){
        $kilometros=$db->escape_string($_GET['kilometros']);
    }

    $data_fim = current_timestamp;
    if($_GET['data_fim'] != ""){
        $data_fim_horas=explode(':',$db->escape_string($_GET['data_fim']));
        $horas = $data_fim_horas[0];
        $minutos = $data_fim_horas[1];

        $data_fim = new DateTime();
        $data_fim->format('Y-m-d');
        $data_fim->setTime(0, 0);


        $timeB = new DateInterval('PT'.$horas.'H'.$minutos.'M');
        $data_fim = $data_fim->add($timeB);
        $data_fim=$data_fim->format('Y-m-d H:i:s');
    }

    $id_viatura=0;
    $viatura = getInfoTabela('viaturas', ' and id_tecnico = "'.$_SESSION['id_utilizador'].'"');

    $kms_feitos=0;
    if(isset($viatura[0])){
        $id_viatura = $viatura[0]['id_viatura'];
        $kms_feitos=$kilometros-$viatura[0]['kms_atuais'];
        $kms_diff=$kms_paragens-$kms_feitos;
        $sql = "update viaturas set kms_atuais='$kilometros' where id_viatura='$id_viatura'";
        $result = runQ($sql, $db, "update");
    }

    $sql = "update assistencias set terminada=1, id_utilizador='".$_SESSION['id_utilizador']."', data_assistencia_terminada = '".$data_fim."', kilometros = '$kms_feitos',kms_diff='$kms_diff',kms_paragens='$kms_paragens', id_viatura = '".$id_viatura."' where id_assistencia='$id_assistencia'";
    $result = runQ($sql, $db, "update");



    /* DESCONTAR NO CONTRATO DE HORAS */


    $horas_eficiencia = getInfoTabela('_conf_assists');
    $horas_eficiencia = $horas_eficiencia[0]['horas_grafico_eficiencia'];

    $today=$data_atual->format('Y-m-d'); // DATA COMPLETA DE HJ
    $horas_assistencia_dia = getInfoTabela('assistencias', ' and ativo=1 and terminada = 1 and DATE_FORMAT(created_at, "%Y-%m-%d") = "'.$today.'" and id_utilizador = '.$_SESSION['id_utilizador']);

    $horas = 0;
    foreach($horas_assistencia_dia as $assistencia_terminada){

        //$seconds = strtotime($assistencia_terminada['data_assistencia_terminada']) - strtotime($assistencia_terminada['data_assistencia_iniciada']);
        $assistencias_clientes_terminadas = getInfoTabela('assistencias_clientes', " and ativo=1 and id_assistencia = '".$assistencia_terminada['id_assistencia']."'",''
            ,'','','sum(tempo_assistencia) as tempo_assistencia, sum(tempo_viagem) as tempo_viagem');

        $seconds = 0;
        if(isset($assistencias_clientes_terminadas[0])){
            $seconds = $assistencias_clientes_terminadas[0]['tempo_assistencia'] +  $assistencias_clientes_terminadas[0]['tempo_viagem'];
        }
        $horas += ($seconds / 60 / 60);

    }

    $valorPerc = round(($horas * 100) / $horas_eficiencia); // PERCENTAGEM DO VALOR

    echo $valorPerc;





    $db->close();
    die;
}


/**
 * TERMINAR E ASSINAR ASSISTENCIA DO CLIENTE
 */
if(isset($_POST['id_assistencia_cliente']) && $_POST['id_assistencia_cliente'] != "" && isset($_POST['terminar_assistencia'])){

    $id_assistencia_cliente=$db->escape_string($_POST['id_assistencia_cliente']);

    $assinatura = "assinatura.jpg";
    if($_POST['assinatura']=="data:,"){
        $_POST['assinatura']="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAMCAgICAgMCAgIDAwMDBAYEBAQEBAgGBgUGCQgKCgkICQkKDA8MCgsOCwkJDRENDg8QEBEQCgwSExIQEw8QEBD/2wBDAQMDAwQDBAgEBAgQCwkLEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBD/wAARCAHZAv0DAREAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD9U6ACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoA//Z";
    }
    if(isset($_POST['assinatura'])){
        $assinatura = $db->escape_string($_POST['assinatura']);

        $storeFolder = "../.tmp/assistencias_clientes";
        if(!is_dir($storeFolder)) {
            mkdir($storeFolder);
        }
        $storeFolder = "../.tmp/assistencias_clientes/" . $id_assistencia_cliente;
        if(!is_dir($storeFolder)) {
            mkdir($storeFolder);
        }
        $data_uri = $assinatura;
        $encoded_image = explode(",", $data_uri)[1];
        $decoded_image = base64_decode($encoded_image);
        //file_put_contents("$storeFolder/assinatura.jpg", $decoded_image);

        $myfile = fopen("$storeFolder/assinatura.jpg", "w") or die("Unable to open file!");
        fwrite($myfile, $decoded_image);
        fclose($myfile);


        $assinatura = "assinatura.jpg";

        if(!is_dir("../_contents/assistencias_clientes")) {
            mkdir("../_contents/assistencias_clientes");
        }

        if(!is_dir("../_contents/assistencias_clientes/assinatura_$id_assistencia_cliente")) {
            mkdir("../_contents/assistencias_clientes/assinatura_$id_assistencia_cliente");
        }

        $dir_assinatura = "../_contents/assistencias_clientes/assinatura_$id_assistencia_cliente/$assinatura";
        moverFicheiros($storeFolder, "../_contents/assistencias_clientes/assinatura_$id_assistencia_cliente");
    }


    $kilometros=0;
    $segundos_viagem=0;
    if(isset($_POST['kilometros']) && $_POST['kilometros'] != "0" && isset($_POST['tempo_viagem']) && $_POST['tempo_viagem'] != "00:00"){

        $kilometros = $db->escape_string($_POST['kilometros']);
        $tempo_viagem = $db->escape_string($_POST['tempo_viagem']);

        $tempo_viagem = explode(':',$tempo_viagem);

        $segundos_viagem = ($tempo_viagem[0] * 60) * 60; // HORAS EM SEGUNDOS
        $segundos_viagem += ($tempo_viagem[1] * 60); // MINUTOS EM SEGUNDOS

        // GET ID DO CLIENTE
        $id_cliente = getInfoTabela('assistencias_clientes', " and id_assistencia_cliente = '$id_assistencia_cliente'");

        UpdateTabela('srv_clientes', " kilometros='$kilometros', tempo_viagem='$segundos_viagem'", " and id_cliente = '".$id_cliente[0]['id_cliente']."'");
    }

    $segundos_pausa=0;
    if(isset($_POST['tempo_pausa']) && $_POST['tempo_pausa'] != "00:00"){
        $tempo_pausa = $db->escape_string($_POST['tempo_pausa']);
        $tempo_pausa = explode(':',$tempo_pausa);
        $segundos_pausa = ($tempo_pausa[0] * 60) * 60; // HORAS EM SEGUNDOS
        $segundos_pausa += ($tempo_pausa[1] * 60); // MINUTOS EM SEGUNDOS
    }

    $asssitencia_atual = getInfoTabela('assistencias_clientes', " and id_assistencia_cliente = '$id_assistencia_cliente'");

    $segundos=0;
    if(isset($_POST['hora_fim']) && $_POST['hora_fim'] != ""){
        $hora_fim=$db->escape_string($_POST['hora_fim']);
    }else{
        $hora_fim=date("H.i",strtotime(current_timestamp));
    }
    $data_fim=date("Y-m-d",strtotime(current_timestamp))." $hora_fim";

    $tempo_assistencia=strtotime($data_fim)-strtotime($asssitencia_atual[0]['data_inicio']);

    $emails="";
    if(isset($_POST['emails']) && $_POST['emails'] != "" && $_POST['emails'] != "null") {
        $emails = json_encode($_POST['emails']);
    }


    $por_terminar=0;
    if(isset($_POST['por_terminar']) && $_POST['por_terminar']==1){
        $por_terminar=1;


        /** CRIAR UMA NOVA MARCAÇAO SE FICOU PENDENTE  */
        $data_proxima_visita="0000-00-00 00:00:00"; // se não souber a data
        $data_fim_nova="0000-00-00 00:00:00"; // se não souber a data
        if(isset($_POST['data_proxima_visita']) && $_POST['data_proxima_visita']!=""){
            $data_proxima_visita=str_replace("T"," ",$_POST['data_proxima_visita']);
            $data_proxima_visita=$db->escape_string($data_proxima_visita);
            $numero_nova="#Marcação";
            insertIntoTabela("assistencias",'nome_assistencia,id_cliente,id_utilizador,data_inicio,data_fim,pendente,created_at,id_criou',"'$numero_nova','".$asssitencia_atual[0]['id_cliente']."','".$_SESSION['id_utilizador']."','$data_proxima_visita','$data_fim_nova','1','".current_timestamp."','".$_SESSION['id_utilizador']."'");
        }


    }

    $id_contrato=$db->escape_string($_POST['id_contrato']);
    $nome_assinatura=$db->escape_string($_POST['nome_assinatura']);

    //calcular o o valor dos KM's
    $viatura = getInfoTabela('viaturas', " and id_tecnico = '".$_SESSION['id_utilizador']."'");
    $id_viatura=0;
    $preco_km=0;
    if(isset($viatura[0])){
        $viatura=$viatura[0];
        $id_viatura=$viatura['id_viatura'];
        $preco_km=$viatura['preco_km'];
    }
    if(!is_numeric($preco_km)){
        $asssitencia_atual[0]['preco_km']=0;
    }
    if(!is_numeric($asssitencia_atual[0]['kilometros']*1)){
        $asssitencia_atual[0]['kilometros']=0;
    }
    //$valor_kms=$preco_km*$asssitencia_atual[0]['kilometros'];

    $tempo_contabilizar=incrementarTempo($tempo_assistencia*1+$segundos_viagem*1-$segundos_pausa*1);

    $latitude=$db->escape_string($_POST['latitude']);
    $longitude=$db->escape_string($_POST['longitude']);

    UpdateTabela('assistencias_clientes', "emails = '$emails',latitude='$latitude',longitude='$longitude',nome_assinatura='$nome_assinatura', assinado='1', assinatura='$assinatura', data_fim='".$data_fim."',tempo_viagem='$segundos_viagem',segundos_pausa='$segundos_pausa', tempo_assistencia='$tempo_assistencia',tempo_contabilizar='$tempo_contabilizar', kilometros='$kilometros', por_terminar='$por_terminar', id_contrato='$id_contrato', id_viatura='$id_viatura',preco_km='$preco_km'"," and id_assistencia_cliente = '$id_assistencia_cliente'");

    $asssitencia_atual = getInfoTabela('assistencias_clientes', " and id_assistencia_cliente = '$id_assistencia_cliente'");



    //terminar toda a cadeia de assistencias pendentes
    if($por_terminar==0){

        //terminar toda a cadeia de maquinas nao concluidas se nesta assistencia tiver uma maquina concluida
        $maquinas_terminadas=getInfoTabela('assistencias_clientes_maquinas', " and ativo=1 and id_assistencia_cliente = '$id_assistencia_cliente'");
        foreach ($maquinas_terminadas as $ma){
            if($ma['concluido']==1){
                UpdateTabela('assistencias_clientes_maquinas', "concluido=1"," and id_maquina='".$ma['id_maquina']."'");

                //outros servicos com esta maquina
                $outros_servicos=getInfoTabela("assistencias_clientes_maquinas"," and ativo=1 and id_maquina='".$ma['id_maquina']."' and id_assistencia_cliente!=".$id_assistencia_cliente);
                foreach ($outros_servicos as $os) {
                    $maquinas_no_servico = getInfoTabela("assistencias_clientes_maquinas", " and ativo=1 and id_assistencia_cliente='" . $os['id_assistencia_cliente'] . "' and concluido=0 group by id_assistencia_cliente");

                    if (count($maquinas_no_servico) == 0) {
                        $servico = getInfoTabela("assistencias_clientes", " and ativo=1 and id_assistencia_cliente='" . $os['id_assistencia_cliente'] . "' and por_terminar=1");

                        if (count($servico) > 0) {
                            $assistencias_por_terminar=UpdateTabela('assistencias_clientes',"por_terminar='0'", " and por_terminar=1 and id_assistencia_cliente = '" . $os['id_assistencia_cliente'] . "' ");
                        }
                    }
                }
            }
        }
        //terminar as assistencia que continham as maquinas que terminamos nesta assistencia

        $id_pai_desta = getInfoTabela('assistencias_clientes', " and id_assistencia_cliente = '$id_assistencia_cliente'");
        $id_pai_desta=$id_pai_desta[0]['id_pai'];

        if($id_pai_desta!=0){
            $assistencias_por_terminar=UpdateTabela('assistencias_clientes',"por_terminar='$por_terminar'", " and por_terminar=1 and id_pai = '$id_pai_desta' ");
            $assistencias_por_terminar=UpdateTabela('assistencias_clientes',"por_terminar='$por_terminar'", " and por_terminar=1 and id_assistencia_cliente = '$id_pai_desta' ");
        }
    }

    //retirar do contrato

    $segundos_a_descontar = $tempo_contabilizar;
    $contrato = getInfoTabela('clientes_contratos', " and id_contrato='".$id_contrato."'");
    if(isset($contrato[0])){
        $segundos_atuais = $contrato[0]['segundos_restantes'] - $segundos_a_descontar;

        $balanco_anterior = $contrato[0]['segundos_restantes'];

        $id_assistencia_cliente = $asssitencia_atual[0]['id_assistencia_cliente'];
        insertIntoTabela('clientes_contratos_carregamentos', "nome_carregamento, id_cliente, segundos, id_criou, balanco_anterior, id_assistencia_cliente, id_contrato",
            "'Referente à assistência: ".$asssitencia_atual[0]['nome_id_assistencia']."','".$asssitencia_atual[0]['id_cliente']."', '-$segundos_a_descontar',
                 '".$_SESSION['id_utilizador']."','$balanco_anterior', '$id_assistencia_cliente', '".$contrato[0]['id_contrato']."'");

        UpdateTabela('clientes_contratos', "segundos_restantes='$segundos_atuais'", ' and id_contrato = "'.$contrato[0]['id_contrato'].'"');
    }




    // GUARDAR PDF
    $return = GerarPdfAssistencia($id_assistencia_cliente);

    $cc_array = getInfoTabela('_conf_assists', " and id_conf=1");

    $cc = [];
    if($cc_array[0]['emails_cc'] != "") {
        $cc = explode(',' ,$cc_array[0]['emails_cc']);
    }

    // ENVIAR EMAIL COM PDF SE NECESSARIO




    $email_enviado=0;
    if(isset($_POST['emails']) && is_array($_POST['emails']) && !empty($_POST['emails'])){
        if(isset($_POST['enviar_email']) && $_POST['enviar_email'] == 1){
            $linhas="";
            $emails_array=[];

            foreach($_POST['emails'] as $email){
                if($email!=""){
                    array_push($emails_array,$email);
                }
            }

            if(!empty($emails_array)){

                //url plataforma:
                $url_plataforma = getInfoTabela('_conf_assists');
                $url_plataforma = $url_plataforma[0]['dominio'];

                $message = "
                    Ex.mos Senhores/as,<br><br> 
                    Enviamos em anexo o relatório de serviço ".$asssitencia_atual[0]['nome_assistencia_cliente'].".<br><br>
                    Agora é mais cómodo fazer marcações! Utilize este link para marcar um servico connosco:  <a href='https://$url_plataforma/public/marcacao.php?hash=".encryptData($asssitencia_atual[0]['id_cliente'])."'>Efetuar Marcação.</a><br><br>
                    A sua opinião ajuda-nos a melhorar, por favor, avalie o nosso trabalho de 1 a 5 aqui: <a href='https://$url_plataforma/public/feedback.php?hash=".encryptData($id_assistencia_cliente)."'>Avaliar.</a> <br><br>
                    Com os melhores cumprimentos,<br>".$_SESSION['nome_utilizador'];

                // SEND EMAIL
                $header= "FILC - Relatório de Serviço ".$asssitencia_atual[0]['nome_assistencia_cliente']."";

                enviarEmail(3,[$return], $header, $message, $emails_array, $cc, '','',[$return]);
                $email_enviado=1;
            }
        }
    }
    UpdateTabela('assistencias_clientes', "email_enviado = '$email_enviado'"," and id_assistencia_cliente = '$id_assistencia_cliente'");



    //ober a percentagem de eficiencia
    $horas_eficiencia = getInfoTabela('_conf_assists');
    $horas_eficiencia = $horas_eficiencia[0]['horas_grafico_eficiencia'];

    $today=$data_atual->format('Y-m-d'); // DATA COMPLETA DE HJ
    $assistencias_clientes_terminadas = getInfoTabela('assistencias_clientes', ' and ativo=1 and assinado = 1 and DATE_FORMAT(data_inicio, "%Y-%m-%d") = "'.$today.'" and id_utilizador = '.$_SESSION['id_utilizador'],''
        ,'','','sum(tempo_assistencia) as tempo_assistencia, sum(tempo_viagem) as tempo_viagem, sum(segundos_pausa) as segundos_pausa');

    $horas = 0;
    $seconds = 0;
    if(isset($assistencias_clientes_terminadas[0])){
        $seconds = $assistencias_clientes_terminadas[0]['tempo_assistencia'] +  $assistencias_clientes_terminadas[0]['tempo_viagem'] -  $assistencias_clientes_terminadas[0]['segundos_pausa'];
    }

    $horas += ($seconds / 60 / 60);
    $valorPerc = round(($horas * 100) / $horas_eficiencia); // PERCENTAGEM DO VALOR

    echo $valorPerc;

    //echo $assinatura;
    $db->close();
    die;
}


if(isset($_GET['eliminar_assistencia_cliente_maquina']) && $_GET['eliminar_assistencia_cliente_maquina'] != ""){

    $id_assistencia_cliente_maquina = $db->escape_string($_GET['eliminar_assistencia_cliente_maquina']);

    $sql = "update assistencias_clientes_maquinas set ativo=0 where id_assistencia_cliente_maquina='$id_assistencia_cliente_maquina'";
    $result = runQ($sql, $db, "update");

    $db->close();
    die;
}

if(isset($_GET['eliminar_assistencia_cliente']) && $_GET['eliminar_assistencia_cliente'] != ""){

    $id_assistencia_cliente = $db->escape_string($_GET['eliminar_assistencia_cliente']);

    $sql = "update assistencias_clientes set ativo=0 where id_assistencia_cliente='$id_assistencia_cliente'";
    $result = runQ($sql, $db, "update");

    $sql = "update assistencias_clientes_maquinas set ativo=0 where id_assistencia_cliente='$id_assistencia_cliente'";
    $result = runQ($sql, $db, "update maquinas");


    $db->close();
    die;
}

if(isset($_GET['mostrar_historico_detalhes_maquina']) && $_GET['mostrar_historico_detalhes_maquina'] != ""){

    $content=file_get_contents("historico_detalhes_maquina.tpl");
    $id_assistencia_cliente_maquina = $db->escape_string($_GET['mostrar_historico_detalhes_maquina']);
    $content=str_replace('_id_assistencia_cliente_maquina_',$id_assistencia_cliente_maquina,$content);


    // GET ID DO CLIENTE BASEADO DO ID_ASSISTENCIA_CLIENTE
    $assistencia_cliente_maquina_array = getInfoTabela('assistencias_clientes_maquinas 
    inner join maquinas using(id_maquina)
    inner join srv_clientes on assistencias_clientes_maquinas.id_cliente = srv_clientes.id_cliente
    inner join assistencias_clientes using (id_assistencia_cliente)',
        " and id_assistencia_cliente_maquina = '$id_assistencia_cliente_maquina'",'','',''
        ,'assistencias_clientes_maquinas.*, maquinas.nome_maquina,maquinas.ref, maquinas.descricao as descricao_maquina, srv_clientes.OrganizationName,
         assistencias_clientes.data_inicio as data_inicio, assistencias_clientes.data_fim as data_fim, assistencias_clientes.assinado ');

    $id_cliente=$assistencia_cliente_maquina_array[0]['id_cliente'];
    $id_maquina = $assistencia_cliente_maquina_array[0]['id_maquina'];



    $pdf="";
    if(is_dir('../_contents/assistencias_clientes_pdfs/'.$assistencia_cliente_maquina_array[0]['id_assistencia_cliente'])){
        $pdf = array_diff(scandir('../_contents/assistencias_clientes_pdfs/'.$assistencia_cliente_maquina_array[0]['id_assistencia_cliente'], 1), array('..', '.'));
    }

    if(file_exists('../_contents/assistencias_clientes_pdfs/'.$assistencia_cliente_maquina_array[0]['id_assistencia_cliente'].'/'.$pdf[0])){
        $content=str_replace('_nomepdf_',$pdf[0],$content);
        $content=str_replace('_id_assistencia_cliente_',$assistencia_cliente_maquina_array[0]['id_assistencia_cliente'],$content);
    }else{
        $content=str_replace('class="btn btn-success" href="../_contents/assistencias_clientes_pdfs/_id_assistencia_cliente_/_nomepdf_" download> PDF', 'class="btn btn-danger" style="cursor:not-allowed"> PDF não gerado', $content);
    }



    $data_inicio = data_portuguesa_real($assistencia_cliente_maquina_array[0]['data_inicio'], 1);
    $data_fim = data_portuguesa_real(current_timestamp, 1);

    if($assistencia_cliente_maquina_array[0]['assinado'] == '1'){
        $data_fim =  data_portuguesa_real($assistencia_cliente_maquina_array[0]['data_fim'], 1);
    }

    $garantia="";
    if($assistencia_cliente_maquina_array[0]['garantia']==1){
        $garantia="<span class='label label-warning garantia-info'><i class='fa fa-warning'></i> Garantia</span>";
    }

    $concluido="";
    if($assistencia_cliente_maquina_array[0]['concluido']==0){
        $concluido="<span class='label label-danger garantia-info'><i class='fa fa-warning'></i> Não Concluído</span>";
    }

    $revisao="";
    if($assistencia_cliente_maquina_array[0]['revisao_periodica']==1){
        $revisao="<span class='label label-info garantia-info'>Revisão: ".number_format($assistencia_cliente_maquina_array[0]['horas_revisao'],0,"",".")."h </span>";
    }

    $str_time_final = strtotime($assistencia_cliente_maquina_array[0]['data_inicio']);
    //$str_time_inicial = strtotime($data_inicio);
    $str_time_atual = strtotime(current_timestamp);

    //$tempo_que_passou = $str_time_final - $str_time_inicial;
    $tempo_que_passou = $str_time_atual - $str_time_final;

    $dias_passados = round($tempo_que_passou / (60 * 60 * 24));

    if($dias_passados < 1){
        $dias_passados=date("d/m/Y",$str_time_final)."<br><small class='text-muted'>Hoje</small>";
    }elseif($dias_passados == 1 ){
        $dias_passados=date("d/m/Y",$str_time_final)."<br><small class='text-muted'>Ontem</small>";
    }else{
        $dias_passados=date("d/m/Y",$str_time_final)."<br><small class='text-muted'>$dias_passados dias atrás</small>";
    }

    //$data = data_portuguesa_real($assistencia_cliente_maquina['created_at'], 1);
    $tecnico = getInfoTabela('utilizadores', ' and id_utilizador="'.$assistencia_cliente_maquina_array[0]['id_criou'].'"');
    $nome_tecnico = $tecnico[0]['nome_utilizador'];

    $content=str_replace('_tecnico_',$nome_tecnico,$content);
    $content=str_replace('_garantia_',$garantia,$content);
    $content=str_replace('_concluido_',$concluido,$content);
    $content=str_replace('_revisao_',$revisao,$content);
    $content=str_replace('_ref_',$assistencia_cliente_maquina_array[0]['ref'],$content);

    $content=str_replace('[ID-ASSISTENCIA-CLIENTE]',$assistencia_cliente_maquina_array[0]['id_assistencia_cliente'],$content);

    $content=str_replace('_data_',$dias_passados ,$content);

    $content=str_replace('_id_maquina_',$id_maquina,$content);

    $content=str_replace('_nomecliente_',($assistencia_cliente_maquina_array[0]['OrganizationName']),$content);
    $content=str_replace('_nomemaquina_',$assistencia_cliente_maquina_array[0]['nome_maquina'],$content);


    $content=str_replace('_descricaoassistenciaclientemaquina_',
        nl2br($assistencia_cliente_maquina_array[0]['descricao']),$content);

    $content=str_replace('_atividade_',
        nl2br($assistencia_cliente_maquina_array[0]['atividade']),$content);

    $content=str_replace('_defeitos_',
        nl2br($assistencia_cliente_maquina_array[0]['defeitos']),$content);

    $content=str_replace('_descricaopecas_',
        nl2br($assistencia_cliente_maquina_array[0]['descricao_pecas']),$content);

    $linha = '
        <tr class="linha">
             <td style="width: 50%;"><select disabled name="id_peca[]" style="width: 100%;" class="id_peca select-select2" >_pecas_</select></td>
            <td style="width: 40%;"><input disabled name="qnt[]" value="1" type="number" min="0" class="form-control qnt" ></td>
        </tr>';



    $pecas = getInfoTabela('pecas', ' and ativo=1 ');

    $ops="";
    foreach($pecas as $peca){
        $selected="";
        $ops.='<option value="'.$peca['id_peca'].'" class="peca"> '.$peca['nome_peca'].'</option>';
    }
    $linha=str_replace("_pecas_",$ops,$linha);




    $pecas_linhas = getInfoTabela('pecas_linhas', " and id_assistencia_cliente_maquina='$id_assistencia_cliente_maquina' and ativo=1 order by id_peca_linha asc");
    $linhas = "";
    foreach($pecas_linhas as $peca_linha){

        $linhatmp = $linha;

        $linhatmp = str_replace('value="'.$peca_linha['id_peca'].'" class="peca"', 'value="'.$peca_linha['id_peca'].'" selected class="peca"', $linhatmp);
        $linhatmp = str_replace('input name="qnt[]" value="1"', 'input name="qnt[]" value="'.$peca_linha['qnt'].'"', $linhatmp);


        $linhas.=$linhatmp;


    }


    $content=str_replace('_linha_',$linha,$content);

    $content=str_replace('_linhaspecas_',$linhas,$content);


    echo $content;
    $db->close();
    die;

}



if(isset($_GET['mostrar_historico_maquina']) && $_GET['mostrar_historico_maquina'] != ""){

    $content=file_get_contents("historico_maquina.tpl");
    $id_maquina = $db->escape_string($_GET['mostrar_historico_maquina']);
    $content=str_replace('_id_maquina_',$id_maquina,$content);


    $maquina = getInfoTabela('maquinas inner join srv_clientes using(id_cliente)', ' and id_maquina="'.$id_maquina.'"','',
    '','','maquinas.*, srv_clientes.OrganizationName');

    $content=str_replace('_ref_','Ref: '.$maquina[0]['ref'],$content);

    $content=str_replace('_nomecliente_',($maquina[0]['OrganizationName']),$content);
    $content=str_replace('_nomemaquina_',$maquina[0]['nome_maquina'],$content);

    $content=str_replace('_numero_serie_','Nº Serie: '.$maquina[0]['numero_serie'],$content);



    $assistencias_clientes_maquinas = getInfoTabela('assistencias_clientes_maquinas inner join assistencias_clientes using(id_assistencia_cliente)',
        " and id_maquina='$id_maquina' and assinado = 1 and assistencias_clientes.ativo=1 and assistencias_clientes_maquinas.ativo=1 order by created_at desc",'','','',
        'assistencias_clientes_maquinas.*, assistencias_clientes.data_inicio, assistencias_clientes.data_fim'); //




    $linha_tpl = '<li class="linha" id_assistencia_cliente_maquina="_id_assistencia_cliente_maquina_" onclick="OpenModalMostrarDetalhesMaquinaHistorico(this)">
                <div class="timeline-time"><b>_tempo_ </b></div>
                <div class="timeline-content">
                    <p class="push-bit"><i class="fa fa-user"></i> _tecnico_</p>
                    <p class="push-bit"> _garantia_ _concluido_ _revisao_</p>
                    <p class="push-bit">
                        <small class=\'text-muted\'>Defeitos:</small><i class=\'text-info defeitos-info\'> _defeitos_</i>
                    </p>
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

        //$data = data_portuguesa_real($assistencia_cliente_maquina['created_at'], 1);
        $tecnico = getInfoTabela('utilizadores', ' and id_utilizador="'.$assistencia_cliente_maquina['id_criou'].'"');
        $nome_tecnico = $tecnico[0]['nome_utilizador'];


        $defeitos = (strlen($assistencia_cliente_maquina['defeitos']) > 60) ? substr($assistencia_cliente_maquina['defeitos'],0,57).'...' : $assistencia_cliente_maquina['defeitos'];

        $garantia="";
        if($assistencia_cliente_maquina['garantia']==1){
            $garantia="<span class='label label-warning garantia-info'><i class='fa fa-warning'></i> Garantia</span>";
        }

        $concluido="";
        if($assistencia_cliente_maquina['concluido']==0){
            $concluido="<span class='label label-danger garantia-info'><i class='fa fa-warning'></i> Não Concluído</span>";
        }

        $revisao="";
        if($assistencia_cliente_maquina['revisao_periodica']==1){
            $revisao="<span class='label label-info garantia-info'>Revisão: ".number_format($assistencia_cliente_maquina['horas_revisao'],0,"",".")."h </span>";
        }

        $str_time_final = strtotime($assistencia_cliente_maquina['data_inicio']);
        //$str_time_inicial = strtotime($data_inicio);
        $str_time_atual = strtotime(current_timestamp);

        //$tempo_que_passou = $str_time_final - $str_time_inicial;
        $tempo_que_passou = $str_time_atual - $str_time_final;

        $dias_passados = round($tempo_que_passou / (60 * 60 * 24));

        if($dias_passados < 1){
            $dias_passados=date("d/m/Y",$str_time_final)."<br><small class='text-muted'>Hoje</small>";
        }elseif($dias_passados == 1 ){
            $dias_passados=date("d/m/Y",$str_time_final)."<br><small class='text-muted'>Ontem</small>";
        }else{
            $dias_passados=date("d/m/Y",$str_time_final)."<br><small class='text-muted'>$dias_passados dias atrás</small>";
        }

        //$date = strtotime(date("Y-m-d", strtotime("-".$dias_passados." day")));

        $tempo_atras="1 Semana";
        $linha_tmp=str_replace('_tempo_',$dias_passados, $linha_tmp);
        $linha_tmp=str_replace('_data_',$data, $linha_tmp);
        $linha_tmp=str_replace('_tecnico_',$nome_tecnico, $linha_tmp);
        $linha_tmp=str_replace('_garantia_',$garantia, $linha_tmp);
        $linha_tmp=str_replace('_concluido_',$concluido, $linha_tmp);
        $linha_tmp=str_replace('_revisao_',$revisao, $linha_tmp);
        $linha_tmp=str_replace('_defeitos_',$defeitos, $linha_tmp);

        $linha_tmp=str_replace('_id_assistencia_cliente_maquina_',$assistencia_cliente_maquina['id_assistencia_cliente_maquina'], $linha_tmp);


        $linhas.=$linha_tmp;
        // CONTINUAR
    }

    $content=str_replace('_linhas_',$linhas,$content);

    echo $content;
    $db->close();
    die;

}


if(isset($_POST['atualizar_pecas']) != ""){


    $id_assistencia_cliente_maquina = $db->escape_string($_POST['id_assistencia_cliente_maquina']);

     $sql = "delete from pecas_linhas where id_assistencia_cliente_maquina='$id_assistencia_cliente_maquina'";
     $result = runQ($sql, $db, "UPDATE");

    $data=[];
    $data_full=[];
    foreach($_POST['atualizar_pecas'] as $linha){
        foreach($linha as $key => $value){


            if($key == "0"){
                $id_peca = $db->escape_string($value);
            }

            if($key == "1"){
                $qnt = $db->escape_string($value);
            }

        }

        $existe = getInfoTabela('pecas',' and id_peca="'.$id_peca.'"');
        if($existe[0]){

            insertIntoTabela('pecas_linhas', 'id_peca, qnt, id_assistencia_cliente_maquina', "'$id_peca', '$qnt', '$id_assistencia_cliente_maquina'");

        }else{

            $inserted_id = insertIntoTabela('pecas', 'nome_peca, id_criou', "'$id_peca', '".$_SESSION['id_utilizador']."'");

            insertIntoTabela('pecas_linhas', 'id_peca, qnt, id_assistencia_cliente_maquina', "'$inserted_id', '$qnt', '$id_assistencia_cliente_maquina'");

            /*$data['id'] = $inserted_id;
            $data['nome'] =$id_peca;

            array_push($data_full, $data);*/

        }



    }

   // echo json_encode($data_full);
    echo '1';

    $db->close();
    die;


}

if(isset($_GET['mostrar_detalhes_maquina']) && $_GET['mostrar_detalhes_maquina'] != ""){

    $content=file_get_contents("detalhes_maquina.tpl");
    $id_assistencia_cliente_maquina = $db->escape_string($_GET['mostrar_detalhes_maquina']);
    $content=str_replace('_id_assistencia_cliente_maquina_',$id_assistencia_cliente_maquina,$content);

    if(isset($_GET['pesquisa']) && $_GET['pesquisa']==1){
        $content=str_replace('updateInput', "nullUpdateInput", $content);
    }

    // GET ID DO CLIENTE BASEADO DO ID_ASSISTENCIA_CLIENTE
    $assistencia_cliente_maquina_array = getInfoTabela('assistencias_clientes_maquinas 
    inner join maquinas using(id_maquina)
    inner join srv_clientes on assistencias_clientes_maquinas.id_cliente = srv_clientes.id_cliente
    inner join assistencias_clientes using (id_assistencia_cliente)',
        " and id_assistencia_cliente_maquina = '$id_assistencia_cliente_maquina'",'','',''
        ,'assistencias_clientes_maquinas.*, maquinas.nome_maquina, maquinas.descricao as descricao_maquina, maquinas.ref, maquinas.numero_serie, srv_clientes.OrganizationName,
         assistencias_clientes.data_inicio, assistencias_clientes.data_fim, assistencias_clientes.assinado, assistencias_clientes.emails');

    $id_cliente=$assistencia_cliente_maquina_array[0]['id_cliente'];
    $id_maquina = $assistencia_cliente_maquina_array[0]['id_maquina'];


    if($assistencia_cliente_maquina_array[0]['garantia'] == '1'){
        $content=str_replace('name="garantia" id="garantia"','name="garantia" checked id="garantia"',$content);
    }
    if($assistencia_cliente_maquina_array[0]['concluido'] == '0'){
        $content=str_replace('name="concluido" checked id="concluido"','name="concluido" id="concluido"',$content);
        $content=str_replace('id="outros-servicos-com-esta-maquina" style="display: block"','id="outros-servicos-com-esta-maquina" style="display: none"',$content);
    }

    $content=str_replace('[ID-ASSISTENCIA-CLIENTE]',$assistencia_cliente_maquina_array[0]['id_assistencia_cliente'],$content);


    if($assistencia_cliente_maquina_array[0]['revisao_periodica'] == '1'){
        $content=str_replace('name="revisao_periodica" id="revisao_periodica"','name="revisao_periodica" checked id="revisao_periodica"',$content);
        $content=str_replace('id="div-horas-revisao" style="display: none;"','id="div-horas-revisao" style="display: block;"',$content);
    }
    //obter revisão anterior
    $anteriores=getInfoTabela('assistencias_clientes_maquinas'," and ativo=1 and revisao_periodica=1 and id_maquina='".$id_maquina."' and id_assistencia_cliente_maquina!='$id_assistencia_cliente_maquina' order by horas_revisao desc");
    $revisoes_anteriores="";
    $revisao_anterior=0;
    foreach ($anteriores as $ant){
        if($revisao_anterior==0){
            $revisao_anterior=$ant["horas_revisao"];
        }
        $revisoes_anteriores.="<i class='text-info'>".date("d/m/Y",strtotime($ant['created_at']))." <small class='text-muted'>(".humanTiming($ant['created_at'])." atrás)</small>: <b>".number_format($ant["horas_revisao"],0,"",".")."</b> h</i><br>";
    }
    if($revisoes_anteriores!=""){
        $revisoes_anteriores="<b class='text-muted'>Revisões anteriores:</b><br>$revisoes_anteriores";
    }
    $content=str_replace('[REVISOES-ANTERIORES]',$revisoes_anteriores,$content);
    $content=str_replace('[REVISAO-ANTERIOR]',$revisao_anterior,$content);
    $content=str_replace('[HORAS-REVISAO]',$assistencia_cliente_maquina_array[0]['horas_revisao'],$content);

    //informar o user que vai fechar também estes serviços se terminar esta máquina
    $outros_servicos_com_esta_maquina="";
    $outros_servicos=getInfoTabela("assistencias_clientes_maquinas"," and ativo=1 and id_maquina='$id_maquina' and concluido=0 and id_assistencia_cliente!=".$assistencia_cliente_maquina_array[0]['id_assistencia_cliente']);
    foreach ($outros_servicos as $os){
        $maquinas_no_servico=getInfoTabela("assistencias_clientes_maquinas"," and ativo=1 and id_assistencia_cliente='".$os['id_assistencia_cliente']."' and concluido=0 and id_maquina!='$id_maquina' group by id_assistencia_cliente");

        if(count($maquinas_no_servico)==0){
            $servico=getInfoTabela("assistencias_clientes"," and ativo=1 and id_assistencia_cliente='".$os['id_assistencia_cliente']."' and por_terminar=1");

            if(count($servico)>0) {
                $servico = $servico[0];
                //validar se tem mais máquinas por terminar

                $tipo_assistencia = "<small class='label label-default'><i class='fa fa-truck'></i> Externa</small>";
                if($servico['externa'] == "0"){
                    $tipo_assistencia = "<small class='label label-danger'><i class='fa fa-home'></i> Interna</small>";
                }
                
                $data_inicio="";
                if($servico['data_inicio']!="0000-00-00 00:00:00"){
                    if(date("d/m/Y", strtotime($servico['data_inicio']))==date("d/m/Y", strtotime(current_timestamp))){
                        $data_inicio = "Hoje às ".date("H:i", strtotime($servico['data_inicio']));
                    }elseif(date("d/m/Y", strtotime($servico['data_inicio']))==date("d/m/Y", strtotime(current_timestamp. ' -1 days'))){
                        $data_inicio = "Ontem às ".date("H:i", strtotime($servico['data_inicio']));
                    }else{
                        $data_inicio = $cfg_diasdasemana[date("w", strtotime($servico['data_inicio']))]."/".date("d, H:i", strtotime($servico['data_inicio']));
                    }

                    $data_inicio="$data_inicio";
                }

                $categoria = getInfoTabela('assistencias_categorias', ' and id_categoria = "'.$servico['id_categoria'].'"');
                $nome_categoria="<small class='label' style='background: black'>Sem categoria</small>";
                if(isset($categoria[0])){
                    $nome_categoria="<small class='label' style='background: ".$categoria[0]['cor_cat']."'>".$categoria[0]['nome_categoria']."</small>";
                }

                $tecnico = getInfoTabela('utilizadores', ' and id_utilizador="'.$servico['id_utilizador'].'"');
                $nome_tecnico = $tecnico[0]['nome_utilizador'];

                $descricao=nl2br($servico['descricao']);
                if($descricao!=""){
                    $descricao="<br><code><small>$descricao</small></code>";
                }

                $outros_servicos_com_esta_maquina .= "
                <tr>
                    <td>
                        $tipo_assistencia $nome_categoria<br>
                        <b>" . $servico['nome_assistencia_cliente'] . "</b> com <b><i class='fa fa-user'></i>$nome_tecnico</b><br>
                        <small class='text-muted'>$data_inicio</small>
                        $descricao
                    </td>
                </tr>
            ";
            }
        }

    }
    if($outros_servicos_com_esta_maquina!=""){
        $outros_servicos_com_esta_maquina="
        <label class='text-danger'>Concluir também outros serviços com esta máquina:</label>
        <table class='table table-vcenter table-bordered'>$outros_servicos_com_esta_maquina</table>";
    }
    $content=str_replace('[outros-servicos-com-esta-maquina]',$outros_servicos_com_esta_maquina,$content);
    //fim outros serviços com esta maquina

    $content=str_replace('_data_',"<i class='fa fa-calendar pr-5'></i>$data_inicio - $data_fim" ,$content);

    $content=str_replace('_id_maquina_',$id_maquina,$content);

    $content=str_replace('_nomecliente_',($assistencia_cliente_maquina_array[0]['OrganizationName']),$content);
    $content=str_replace('_nomemaquina_',$assistencia_cliente_maquina_array[0]['nome_maquina'],$content);

    $content=str_replace('_ref_','Ref: '.$assistencia_cliente_maquina_array[0]['ref'],$content);
    $content=str_replace('_numero_serie_','Nº Serie: '.$assistencia_cliente_maquina_array[0]['numero_serie'],$content);

    $content=str_replace('_descricaoassistenciaclientemaquina_',
        $assistencia_cliente_maquina_array[0]['descricao'],$content);

    $content=str_replace('_atividade_',
        $assistencia_cliente_maquina_array[0]['atividade'],$content);

    $content=str_replace('_defeitos_',
        $assistencia_cliente_maquina_array[0]['defeitos'],$content);

    $content=str_replace('_descricaopecas_',
        $assistencia_cliente_maquina_array[0]['descricao_pecas'],$content);


    if(in_array('5', $_SESSION['grupos'])){ // REDIRECIONAR OS TECNICOS PARA O DASHBOARD DELES
        $content=str_replace('bloco-pecas','bloco-pecas hidden', $content);
    }

    $linha = '
        <tr class="linha">
            <td class="text-center remove-linha" style="width: 10%"><a onclick="removerLinha(this);" href="javascript:void(0)" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a></td>
            <td style="width: 50%;"><select name="id_peca[]" style="width: 100%;" class="id_peca select-select2" >_pecas_</select></td>
            <td style="width: 40%;"><input name="qnt[]" value="1" type="number" min="0" class="form-control qnt" ></td>
        </tr>';



    $pecas = getInfoTabela('pecas', ' and ativo=1 ');

    $ops="";
    foreach($pecas as $peca){
        $selected="";
        $ops.='<option value="'.$peca['id_peca'].'" class="peca"> '.$peca['nome_peca'].'</option>';
    }
    $linha=str_replace("_pecas_",$ops,$linha);




    $pecas_linhas = getInfoTabela('pecas_linhas', " and id_assistencia_cliente_maquina='$id_assistencia_cliente_maquina' and ativo=1 order by id_peca_linha asc");
    $linhas = "";
    foreach($pecas_linhas as $peca_linha){

        $linhatmp = $linha;

        $linhatmp = str_replace('value="'.$peca_linha['id_peca'].'" class="peca"', 'value="'.$peca_linha['id_peca'].'" selected class="peca"', $linhatmp);
        $linhatmp = str_replace('input name="qnt[]" value="1"', 'input name="qnt[]" value="'.$peca_linha['qnt'].'"', $linhatmp);


        $linhas.=$linhatmp;


    }


    $content=str_replace('_linha_',$linha,$content);

   $content=str_replace('_linhaspecas_',$linhas,$content);





    /*// GET MAQUINAS DO CLIENTE
    $ops="";
    $maquinas = getInfoTabela('maquinas'," and id_cliente ='$id_cliente'");
    foreach($maquinas as $maquina){
        $ops.="<option class='id_maquina' value='".$maquina["id_maquina"]."'>".$maquina["nome_maquina"]."</option>";
    }

    $content=str_replace("_maquinas_",$ops,$content);


    $maquinas_cliente_linhas = getInfoTabela('assistencias_clientes_maquinas inner join maquinas using(id_maquina)',
        " and id_assistencia_cliente ='$id_assistencia_cliente' and assistencias_clientes_maquinas.ativo=1 ",'','',''
        ,'assistencias_clientes_maquinas.*, maquinas.nome_maquina, maquinas.descricao as descricao_maquina');

    $linhas_maquinas = "";
    foreach($maquinas_cliente_linhas as $maquina_cliente_linha){

        $linhas_maquinas.=" 
     
        <div class='linha' id_assistencia_cliente_maquina='".$maquina_cliente_linha['id_assistencia_cliente_maquina']."'>
           <span><strong>".$maquina_cliente_linha['nome_maquina']."</strong> <br> ".$maquina_cliente_linha['descricao_maquina']." </span> 
          
           <a onclick='OpenModalAddMaquina(this)' href='#'>  <i class='fa fa-play'></i> </a> 
        </div>
  
     ";

    }

    $content=str_replace('_maquinasassistencia_', $linhas_maquinas,$content);*/


    echo $content;
    $db->close();
    die;

}




if(isset($_GET['value'])
     && isset($_GET['coluna']) && $_GET['coluna'] != ""
     && isset($_GET['tabela']) && ($_GET['tabela'] == "assistencias_clientes"
        || $_GET['tabela'] == "assistencias_clientes_maquinas"
        || $_GET['tabela'] == "estados_viaturas_linhas"
        || $_GET['tabela'] == "viaturas"
        || $_GET['tabela'] == "orcamentos")
     && isset($_GET['id']) && $_GET['id'] != ""){

    $value = $db->escape_string($_GET['value']);
    $coluna = $db->escape_string($_GET['coluna']);
    $tabela = $db->escape_string($_GET['tabela']);
    $id = $db->escape_string($_GET['id']);

    $coluna_id = "id_assistencia_cliente_maquina";
    if($tabela == "assistencias_clientes"){
        $coluna_id = "id_assistencia_cliente";
    }

    if($tabela == "estados_viaturas_linhas"){
        $coluna_id = "id_estado_viatura";
    }

    if($tabela == "viaturas"){
        $coluna_id = "id_viatura";
    }

    if($tabela == "orcamentos"){
        $coluna_id = "id_orcamento";
    }

    if (strpos($coluna, 'data_') !== false) {
        $value = data_portuguesa($value);
    }


    $updatedId = UpdateTabela($tabela, "$coluna='$value'"," and $coluna_id = '$id'");

    $db->close();
    die;

}

if(isset($_GET['adicionar_maquina']) && $_GET['adicionar_maquina'] != "" && isset($_GET['id_maquina']) && $_GET['id_maquina'] != ""){



    $assistencia_cliente = getInfoTabela('assistencias_clientes', ' and id_assistencia_cliente = "'.$db->escape_string($_GET['adicionar_maquina']).'"');
    $assistencia_cliente=$assistencia_cliente[0];
    $id_cliente = $assistencia_cliente['id_cliente'];



    $maquina = getInfoTabela('maquinas', ' and id_maquina="'.$db->escape_string($_GET['id_maquina']).'"');
    $maquina=$maquina[0];

    //ir ao serviço anterior se for por terminar e buscar os defeitos + garantia
    $defeitos="";
    $garantia=0;
    $concluido=1;
    $maquinas_servico_pai=[];
    if($assistencia_cliente['id_pai']!=0){
        $servico_pai=getInfoTabela('assistencias_clientes_maquinas', ' and ativo=1 and id_maquina="'.$db->escape_string($_GET['id_maquina']).'" and id_assistencia_cliente="'.$assistencia_cliente['id_pai'].'"');
        $servico_pai=$servico_pai[0];

        $defeitos=$db->escape_string($servico_pai['defeitos']);
        $garantia=$servico_pai['garantia'];
        $concluido=$servico_pai['concluido'];
    }
    if($garantia==""){
        $garantia=0;
    }
    if($concluido==""){
        $concluido=1;
    }
    //mesmo se não escolhemos o serviço pai, validar se a máquina esta por terminar
    $estado_maquina=getInfoTabela('assistencias_clientes_maquinas', ' and ativo=1 and id_maquina="'.$db->escape_string($_GET['id_maquina']).'" and concluido=0');
    if(count($estado_maquina)>0){
        $defeitos=$estado_maquina[0]['defeitos'];
        $concluido=0;
    }

    $inserted_id = insertIntoTabela('assistencias_clientes_maquinas','id_maquina, id_assistencia_cliente, id_criou, id_cliente,garantia,defeitos,concluido',
        "'".$db->escape_string($_GET['id_maquina'])."', '".$assistencia_cliente['id_assistencia_cliente']."', '".$_SESSION['id_utilizador']."', '$id_cliente','$garantia','$defeitos','$concluido'");

    print 0;
    $db->close();
    die;

}


if(isset($_GET['mostrar_maquinas']) && $_GET['mostrar_maquinas'] != ""){
    $content=file_get_contents("mostrar_maquinas.tpl");
    $id_assistencia_cliente = $db->escape_string($_GET['mostrar_maquinas']);
    $content=str_replace('_id_assistencia_cliente_',$id_assistencia_cliente,$content);

    if(isset($_GET['pesquisa']) && $_GET['pesquisa']==1){
        $content=str_replace('_data_', "<input type='hidden' id='veio-da-pesquisa' value='1'>", $content);
    }

    // GET ID DO CLIENTE BASEADO DO ID_ASSISTENCIA_CLIENTE
    $assistencia_cliente_array = getInfoTabela('assistencias_clientes', " and id_assistencia_cliente = '$id_assistencia_cliente'");
    $id_cliente=$assistencia_cliente_array[0]['id_cliente'];
    $cliente_arr=getInfoTabela("srv_clientes", " and id_cliente='$id_cliente'");
    $cliente_arr=$cliente_arr[0];


    /* TEMPO DE ASSISTENCIA */
    $tempo_assistencia = "00:00";
    if($assistencia_cliente_array[0]['tempo_assistencia'] > 0){

        $hours = floor($assistencia_cliente_array[0]['tempo_assistencia'] / 3600);
        $minutes = floor(($assistencia_cliente_array[0]['tempo_assistencia'] / 60) % 60);

        if($hours < 10){
            $hours='0'.$hours;
        }

        if($minutes < 10){
            $minutes='0'.$minutes;
        }

        $tempo_assistencia = $hours.':'.$minutes;

    }
    $content=str_replace('id="horas_assistencia" name="horas_assistencia" value="00:30"','id="horas_assistencia" name="horas_assistencia" value="'.$tempo_assistencia.'"', $content);

    /* TEMPO DE ASSISTENCIA */


    /* TEMPO DE VIAGEM -> VERIFICAR SE ESTÁ ASSINADO - SE ESTIVER COLCOAR O TEMPO DE VIAGEM QUE EXISTE NA ASSISTENCIA, ELSE COLOCAR O DO CLIENTE (SE EXISTIR) */

    $tempo_viagem = "00:00";

    if($assistencia_cliente_array[0]['assinado']==0){
        $assistencia_cliente_array[0]['tempo_viagem']=$cliente_arr['tempo_viagem'];
    }

    if($assistencia_cliente_array[0]['tempo_viagem'] > 0){
        $hours = floor($assistencia_cliente_array[0]['tempo_viagem'] / 3600);
        $minutes = floor(($assistencia_cliente_array[0]['tempo_viagem'] / 60) % 60);

        if($hours < 10){
            $hours='0'.$hours;
        }

        if($minutes < 10){
            $minutes='0'.$minutes;
        }

        $tempo_viagem = $hours.':'.$minutes;
    }

    $tempo_pausa="00:00";
    if($assistencia_cliente_array[0]['segundos_pausa'] > 0){
        $hours = floor($assistencia_cliente_array[0]['segundos_pausa'] / 3600);
        $minutes = floor(($assistencia_cliente_array[0]['segundos_pausa'] / 60) % 60);

        if($hours < 10){
            $hours='0'.$hours;
        }

        if($minutes < 10){
            $minutes='0'.$minutes;
        }

        $tempo_pausa = $hours.':'.$minutes;
    }
    $content=str_replace('id="tempo_pausa" name="tempo_pausa" value="00:00"','id="tempo_pausa" name="tempo_pausa" value="'.$tempo_pausa.'"', $content);


    if($assistencia_cliente_array[0]['externa'] == "1"){
        $content=str_replace('id="tempo_viagem" name="tempo_viagem" value="00:30"','id="tempo_viagem" name="tempo_viagem" value="'.$tempo_viagem.'"', $content);
    }
    /* TEMPO DE VIAGEM */


    /* KILOMETROS */

    $kilometros = $assistencia_cliente_array[0]['kilometros'];

    if($assistencia_cliente_array[0]['assinado'] == "0"){
        $kilometros = $cliente_arr['kilometros'];
    }
    if($assistencia_cliente_array[0]['externa'] == "1"){
        $content=str_replace('_nomeAssinatura_','',$content);
        $content=str_replace('id="kilometros" name="kilometros" value="0"','id="kilometros" name="kilometros" value="'.$kilometros.'"', $content);
    }else{
        $content=str_replace('_nomeAssinatura_',$_SESSION['nome_utilizador'],$content);
    }
    /* END KILOMETROS */

    if($cliente_arr['kilometros']!=0 && $cliente_arr['tempo_viagem']!=0){
        $content=str_replace('[ESCONDER-PARA-INTERNAS]','hidden', $content);
    }

    $content=str_replace('[TIPO-ASSISTENCIA]',$assistencia_cliente_array[0]['externa'], $content);
    if($assistencia_cliente_array[0]['externa'] == "1"){
        $content=str_replace('[ESCONDER-PARA-EXTERNAS]','hidden', $content);
        $content=str_replace('[ESCONDER-PARA-INTERNAS]','', $content);
    }else{
        $content=str_replace('[ESCONDER-PARA-EXTERNAS]','', $content);
        $content=str_replace('[ESCONDER-PARA-INTERNAS]','hidden', $content);
    }





    $content=str_replace('_id_cliente_',$id_cliente,$content);



    if($assistencia_cliente_array[0]['assinado'] == 1){
        $content=str_replace('_nova_','Nova',$content);
    }else{
        $content=str_replace('assinatura-atual"','assinatura-atual hidden"',$content);
    }

    $content=str_replace('_nova_','',$content);

    $random = rand(0, 9999);

    $content=str_replace("_dirAssinatura_","/_contents/assistencias_clientes/assinatura_$id_assistencia_cliente/".$assistencia_cliente_array[0]['assinatura'].'?rand='.$random,$content);

    $data_inicio = data_portuguesa_real($assistencia_cliente_array[0]['data_inicio'], 1);
    $data_fim = data_portuguesa_real(current_timestamp, 1);


    $pacotes = getInfoTabela('clientes_contratos', ' and ativo=1 and id_cliente='.$assistencia_cliente_array[0]['id_cliente']);
    $pacotes_html="";

    $checked="checked";
    if($assistencia_cliente_array[0]['id_contrato']!=0){
        $checked="";
    }

    if($_SESSION['comercial']==1){
        $pacotes=[];
        $content=str_replace("[ESCONDER-COMERCIAL]","hidden",$content);
        $content=str_replace('class="enviar-email" checked','class="enviar-email"',$content);
        $content=str_replace('<i class="fa fa-check"></i> Assinar','<i class="fa fa-check"></i> Terminar',$content);
    }
    $content=str_replace("[COMERCIAL]",$_SESSION['comercial'],$content);

    foreach ($pacotes as $pacote){

        if($assistencia_cliente_array[0]['id_contrato']==$pacote['id_contrato']){
            $checked="checked";
        }

        $tempo=secondsToTime($pacote['segundos_restantes']);

        $cor="text-info";
        if($pacote['segundos_restantes']<0){
            $cor="text-danger";
        }

        $pacotes_html.="<tr><td><b>".$pacote['nome_contrato']."</b><br><i class='fa fa-clock-o text-muted'></i> <small class='$cor'>$tempo</small></td><td style='width: 31px;'><label class='csscheckbox csscheckbox-primary'>
                                    <input class='ids_pacotes_horas' type='radio' $checked value='".$pacote['id_contrato']."' name='id_contrato' id=''>
                                    <span></span>
                                </label></td></tr>";

        $checked="";
    }
    if($pacotes_html!=""){
        $pacotes_html.="<tr><td><b class='text-danger'>Não descontar horas</b></td><td style='width: 31px;'><label class='csscheckbox csscheckbox-primary'>
                                    <input class='ids_pacotes_horas' type='radio' value='0' name='id_contrato' id=''>
                                    <span></span>
                                </label></td></tr>";
        $pacotes_html="
        <table class='table table-bordered table-vcenter'>
            $pacotes_html
</table>
        ";
    }else{
        $pacotes_html="<h3 class='text-center text-danger'>Cliente sem contrato de horas.</h3>";
    }
    $content=str_replace("_pacotes_",$pacotes_html,$content);


    $linhas="";

    $linha = "
        <tr class='linha'>
             <td class='text-center remove-linha'><a onclick='removerLinha(this);' href='javascript:void(0)' class='btn btn-xs btn-danger'><i class='fa fa-times'></i></a></td>
             <td ><input type='email' name='email[]' class='form-control email'></td>
        </tr>
   ";

    $content=str_replace('_linhaassinatura_',$linha,$content);

    $emails = $assistencia_cliente_array[0]['emails'];

    if($emails != ""){

        $emails = json_decode($emails,true);

        if($emails != ""){
            if(count($emails) > 0){
                foreach($emails as $email){
                    $linhas.=$linha;
                    $linhas = str_replace("type='email' name='email[]'","type='email' value='".$email."' name='email[]'",$linhas);
                }
            }
        }

    }else{
        $linhas.=$linha;
        $linhas = str_replace("type='email' name='email[]'","type='email' value='".$cliente_arr['EmailAddress']."' name='email[]'",$linhas);
    }

   // print_r($linhas);$db->close();die();

    $content=str_replace('_linhasemails_',$linhas,$content);

    if($assistencia_cliente_array[0]['assinado'] == '1'){
        $data_fim =  data_portuguesa_real($assistencia_cliente_array[0]['data_fim'], 1);
    }

    $data_inicio = "Hoje às ".date("H:i", strtotime($assistencia_cliente_array[0]['data_inicio']));
    $segundos_decorrer=strtotime(current_timestamp)-strtotime($assistencia_cliente_array[0]['data_inicio']);



    $segundos_pausa_anterior=$assistencia_cliente_array[0]['segundos_pausa'];
    //se nao esta em pausa
    $segundos_pausa_atual=0;
    if($assistencia_cliente_array[0]['inicio_pausa']=="0000-00-00 00:00:00"){
        $content=str_replace("[ESCONDER-SE-EM-PAUSA]","style='display:block'",$content);
        $content=str_replace("[ESCONDER-SE-NAO-EM-PAUSA]","style='display:none'",$content);
        $tempoLigado="tempoLigado";
        $iconPausa="<i class='icon_pausa".$assistencia_cliente_array[0]['id_assistencia_cliente']." fa fa-play text-success'></i>";
    }else{//se esta em pausa
        $segundos_pausa_atual=strtotime(current_timestamp)-strtotime($assistencia_cliente_array[0]['inicio_pausa']);
        $content=str_replace("[ESCONDER-SE-EM-PAUSA]","style='display:none'",$content);
        $content=str_replace("[ESCONDER-SE-NAO-EM-PAUSA]","style='display:block'",$content);
        $tempoLigado="";
        $iconPausa="<i class='icon_pausa".$assistencia_cliente_array[0]['id_assistencia_cliente']." fa fa-pause text-warning'></i>";
    }
    $total_pausas=$segundos_pausa_anterior+$segundos_pausa_atual;
    $segundos_decorrer=$segundos_decorrer-$total_pausas;

    $content=str_replace('_data_',"$iconPausa <strong  class='$tempoLigado assistencia".$assistencia_cliente_array[0]['id_assistencia_cliente']."' data-segundos='$segundos_decorrer'>".secondsToTime($segundos_decorrer)."</strong>" ,$content);

    $nome_cliente = ($cliente_arr['OrganizationName']);

    $content=str_replace('_descricaoassistenciacliente_', $assistencia_cliente_array[0]['descricao'],$content);
    $content=str_replace('_nomecliente_', $nome_cliente,$content);


    // GET MAQUINAS DO CLIENTE




    $linhas_maquinas=getListaMaquinasAssistencia($id_assistencia_cliente);

    $content=str_replace('_maquinasassistencia_', $linhas_maquinas,$content);

    $alertas_cliente = getInfoTabela('clientes_contratos',
        " and ativo=1 and id_cliente = '$id_cliente'");


    $alerta = "";

    $horas_aviso_config = getInfoTabela('_conf_assists', '','','','','horas_aviso_contrato_horas');

    if(isset($alertas_cliente[0])){

        $segundos = ($horas_aviso_config[0]['horas_aviso_contrato_horas'] * 60)*60;


            if($alertas_cliente[0]['segundos_restantes'] <= $segundos){

                $horas_disponiveis = gmdate("H:i:s", ($alertas_cliente[0]['segundos_restantes']*1));

                $alerta='
            <div class="linha-alerta-cliente"> 
                <div class="linha">
                   <span> <i class="fa fa-warning text-danger"></i> <b>Atenção</b> <br> <small>Tempo disponível no contrato de horas: <b>'.$horas_disponiveis.'</b></small></span> 
                </div>
            </div>';

            }else{
                $content=str_replace('bloco-alerta-clientes','bloco-alerta-clientes hidden', $content);
            }


    }else{
        $content=str_replace('bloco-alerta-clientes','bloco-alerta-clientes hidden', $content);
    }

    $content=str_replace('_alertacliente_', $alerta, $content);

    echo $content;
    $db->close();
    die;

}

/** INICIAR ASSISTENCIA */
if(isset($_GET['id_assistencia']) && $_GET['id_assistencia'] != "" && isset($_GET['data_inicio'])){

    UpdateTabela('assistencias', 'em_curso = 1 and terminada = 0', ' and id_assistencia="'.$db->escape_string($_GET['id_assistencia']).'"');

    $assistencia = getInfoTabela('assistencias inner join srv_clientes using (id_cliente)', ' and id_assistencia = "'.$db->escape_string($_GET['id_assistencia']).'"');

    $assistencia=$assistencia[0];

    $data_inicio = current_timestamp;

    if($_GET['data_inicio'] != ""){
        $data_inicio_horas=explode(':',$db->escape_string($_GET['data_inicio']));
        $horas = $data_inicio_horas[0];
        $minutos = $data_inicio_horas[1];

        $data_inicio = new DateTime();
        $data_inicio->format('Y-m-d');
        $data_inicio->setTime(0, 0);


        $timeB = new DateInterval('PT'.$horas.'H'.$minutos.'M');
        $data_inicio = $data_inicio->add($timeB);
        $data_inicio=$data_inicio->format('Y-m-d H:i:s');
        //strtotime(" + $horas hours + $minutos minutes")
    }
    $data_inicio_contador=$data_inicio;

    $id_pai=0;
    if(isset($_GET['id_pai'])){
        $id_pai=$db->escape_string($_GET['id_pai']);
    }

    UpdateTabela('assistencias', ' data_assistencia_iniciada="'.$data_inicio.'"', " and id_assistencia='".$assistencia['id_assistencia']."'");

    $inserted_id = insertIntoTabela('assistencias_clientes','id_cliente, id_assistencia, id_criou, data_inicio, id_pai, id_categoria',
        "'".$assistencia['id_cliente']."', '".$assistencia['id_assistencia']."', '".$_SESSION['id_utilizador']."', '$data_inicio', '$id_pai','".$assistencia['id_categoria']."'");

    $data_inicio="";
    $data_inicio = data_portuguesa_real($assistencia['data_inicio'], 1);

    $data_fim="";

    if($assistencia['data_fim'] != "" && $assistencia['data_fim'] != "0000-00-00 00:00:00"){
        $data_fim = data_portuguesa_real($assistencia['data_fim'], 1);
        $data_fim = ' - '.$data_fim;
    }


    $btn_s ="  <div class='text-center adicionar-paragem'>
          <a class='btn btn-main btn-xs add-linha'  href='javascript:void(0)' onclick='addParagemClienteModal(this)' ><i class='fa fa-plus'></i> Adicionar Cliente </a>
          <a class='btn btn-success btn-xs add-linha'  href='javascript:void(0)' onclick='terminarAssistenciaModal(this)' ><i class='fa fa-save'></i> Terminar Assistência</a>
          <a class='btn btn-danger btn-xs'  href='javascript:void(0)' onclick='confirmaModal(\"../mod_assistencias/reciclar.php?id=".$assistencia['id_assistencia']."&from_dashboard\")' ><i class='fa fa-trash'></i> Cancelar e eliminar</a>

       </div>";

    $tipo_assistencia = "<small class='label label-default'><i class='fa fa-truck'></i> Externa</small>";
    if($assistencia['externa'] == "0"){
        $tipo_assistencia = "<small class='label label-danger'><i class='fa fa-home'></i> Interna</small>";
    }

    $data_inicio = "Hoje às ".date("H:i", strtotime($data_inicio_contador));
    $segundos_decorrer=strtotime(current_timestamp)-strtotime($data_inicio_contador);




    $categoria = getInfoTabela('assistencias_categorias', ' and id_categoria = "'.$assistencia['id_categoria'].'"');
    $nome_categoria="<small class='label' style='background: black'>Sem categoria</small>";
    if(isset($categoria[0])){
        $nome_categoria="<small class='label' style='background: ".$categoria[0]['cor_cat']."'>".$categoria[0]['nome_categoria']."</small>";
    }

    $descricao=nl2br($assistencia['descricao']);
    if($descricao!=""){
        $descricao="<br><code><small>$descricao</small></code>";
    }


    $segundos_pausa_anterior=$assistencia['segundos_pausa'];
    $segundos_pausa_atual=0;
    //se nao esta em pausa
    if($assistencia['inicio_pausa']=="0000-00-00 00:00:00"){
        $tempoLigado="tempoLigado";
        $iconPausa="<i class='icon_pausa".$assistencia['id_assistencia_cliente']." fa fa-play text-success'></i>";
    }else{//se esta em pausa
        $segundos_pausa_atual=strtotime(current_timestamp)-strtotime($assistencia['inicio_pausa']);
        $tempoLigado="";
        $iconPausa="<i class='icon_pausa".$assistencia['id_assistencia_cliente']." fa fa-pause text-warning'></i>";
    }
    $total_pausas=$segundos_pausa_anterior+$segundos_pausa_atual;
    $segundos_decorrer=$segundos_decorrer-$total_pausas;


    $linha = "
    <div class='linha-assistencia-clientes' id_assistencia='".$assistencia['id_assistencia']."' > 
 
          <table class='table table-borderless table-vcenter' style='margin: 0px'>
            <tr>
            <td>
            $tipo_assistencia<br>
            <b><i class='fa fa-hashtag'></i>".$assistencia['nome_assistencia']."</b>
                            
                </td>
                            <td>
                            <small class='text-muted'>Iniciada</small><br>
                            <strong>$data_inicio</strong>
                            
                </td>
                <td><small class='text-muted'>Duração</small><br>
                    
                    $iconPausa <strong  class='$tempoLigado assistencia".$assistencia['id_assistencia_cliente']."' data-segundos='$segundos_decorrer'>".secondsToTime($segundos_decorrer)."</strong>
                </td>
                </tr>
                            
                </table>
            
        <div class='linha' onclick='addAssistClienteMaquina(this)' id_assistencia_cliente='$inserted_id'>
           <span><i class='fa fa-user'></i> <small>".$assistencia['OrganizationName']." $nome_categoria</small>$descricao</span> 
           <div class='assinado'><bold>Assinado: </bold><span class='text-danger'>Não</span></div>
           <a  href='#'>  <i class='fa fa-play'></i> </a> 
           
        </div>
     
        $btn_s
       
    </div>
    ";

    echo $linha ;
    
    die;

}



/** ADIICIONAR PAGAGEM */
if(isset($_GET['adicionar_paragem']) && $_GET['adicionar_paragem'] == "1" && isset($_GET['id_cliente']) && $_GET['id_cliente'] != ""){

    $cliente = getInfoTabela('srv_clientes' ,' and id_cliente="'.$db->escape_string($_GET['id_cliente']).'"');
    $cliente=$cliente[0];

    $id_pai=0;
    if(isset($_GET['id_pai'])){
        $id_pai=$db->escape_string($_GET['id_pai']);
    }

    $hora_inicio=$db->escape_string($_GET['hora_inicio']);
    $externa=$db->escape_string($_GET['externa']);

    //atualizar a categoria aqui
    $id_categoria=$db->escape_string($_GET['id_categoria']);
    $id_assistencia_aproveitar=0;
    if(isset($_GET['id_assistencia_aproveitar']) && $_GET['id_assistencia_aproveitar']!=0){
        $id_assistencia_aproveitar=$db->escape_string($_GET['id_assistencia_aproveitar']);

        $assistencia_aproveitar = getInfoTabela('assistencias', ' and id_assistencia = "'.$id_assistencia_aproveitar.'"');
        $assistencia_aproveitar=$assistencia_aproveitar[0];

        $id_categoria=$assistencia_aproveitar['id_categoria'];

        UpdateTabela("assistencias", "ativo='0'"," and id_assistencia = '$id_assistencia_aproveitar'");
    }

    $id_viatura=0;
    $viatura = getInfoTabela('viaturas', ' and id_tecnico = "'.$_SESSION['id_utilizador'].'"');
    $viatura=$viatura[0];
    if(isset($viatura['id_viatura'])){
        $id_viatura=$viatura['id_viatura'];
    }

    $id_utilizador=$_SESSION['id_utilizador'];

    $numero_servico=gerar_numero_assistencia();

    $data_inicio=date("Y-m-d",strtotime(current_timestamp));
    $data_inicio.=" ".$hora_inicio;
    $inserted_id = insertIntoTabela('assistencias_clientes','id_cliente, id_assistencia, id_criou, paragem, data_inicio,id_pai,id_categoria,id_utilizador,id_viatura, externa, nome_assistencia_cliente',
        "'".$db->escape_string($_GET['id_cliente'])."', '".$id_assistencia_aproveitar."', '".$_SESSION['id_utilizador']."', 1,'".$data_inicio."','$id_pai','$id_categoria','$id_utilizador','$id_viatura','$externa', '$numero_servico'");


    //ir buscar as máquinas por terminar do serviço pai
    if($id_pai!=0){

        $maquinas_por_terminar_filtrado=[];
        $maquinas_por_terminar_arr=getInfoTabela("assistencias_clientes_maquinas", "and ativo=1 and concluido=0 and id_assistencia_cliente='$id_pai'");
        foreach ($maquinas_por_terminar_arr as $ma_arr){
            $maquinas_por_terminar_filtrado[$ma_arr['id_maquina']]=$ma_arr;
        }

        $por_terminar_filhos = getInfoTabela('assistencias_clientes', ' and ativo=1 and (id_pai='.$id_pai.')');
        foreach ($por_terminar_filhos as $pt2){
            $maquinas_por_terminar_arr=getInfoTabela('assistencias_clientes_maquinas', ' and ativo=1 and concluido=0  and id_assistencia_cliente = "'.$pt2['id_assistencia_cliente'].'"');
            foreach ($maquinas_por_terminar_arr as $ma_arr){
                $maquinas_por_terminar_filtrado[$ma_arr['id_maquina']]=$ma_arr;
            }
        }

        foreach ($maquinas_por_terminar_filtrado as $mp){
            insertIntoTabela("assistencias_clientes_maquinas","id_assistencia_cliente,id_cliente,id_maquina,defeitos,garantia,concluido,id_criou,created_at",
                "'$inserted_id','".$db->escape_string($_GET['id_cliente'])."','".$mp['id_maquina']."','".$mp['defeitos']."','".$mp['garantia']."','".$mp['concluido']."','".$_SESSION['id_utilizador']."','".current_timestamp."'");
        }



    }

    $categoria = getInfoTabela('assistencias_categorias', ' and id_categoria = "'.$id_categoria.'"');
    $nome_categoria="<small class='label' style='background: black'>Sem categoria</small>";
    if(isset($categoria[0])){
        $nome_categoria="<small class='label' style='background: ".$categoria[0]['cor_cat']."'>".$categoria[0]['nome_categoria']."</small>";
    }

    //obter dados da assist para responder por ajax
    $assistencias_cliente = getInfoTabela('assistencias_clientes',
        " and id_assistencia_cliente='$inserted_id'");
    $assistencias_cliente=$assistencias_cliente[0];

    $tipo_assistencia = "<small class='label label-default'><i class='fa fa-truck'></i> Externa</small>";
    if($assistencias_cliente['externa'] == "0"){
        $tipo_assistencia = "<small class='label label-danger'><i class='fa fa-home'></i> Interna</small>";
    }

    $cliente = getInfoTabela('srv_clientes', ' and id_cliente = "'.$assistencias_cliente['id_cliente'].'"');
    $nome_cliente = "";
    if(isset($cliente[0])){
        $nome_cliente= ($cliente[0]['OrganizationName']);
    }

    $data_inicio="";
    if($assistencias_cliente['data_inicio']!="0000-00-00 00:00:00"){
        if(date("d/m/Y", strtotime($assistencias_cliente['data_inicio']))==date("d/m/Y", strtotime(current_timestamp))){
            $data_inicio = "Hoje às ".date("H:i", strtotime($assistencias_cliente['data_inicio']));
        }elseif(date("d/m/Y", strtotime($assistencias_cliente['data_inicio']))==date("d/m/Y", strtotime(current_timestamp. ' -1 days'))){
            $data_inicio = "Ontem às ".date("H:i", strtotime($assistencias_cliente['data_inicio']));
        }else{
            $data_inicio = $cfg_diasdasemana[date("w", strtotime($assistencias_cliente['data_inicio']))]."/".date("d, H:i", strtotime($assistencias_cliente['data_inicio']));
        }

        $data_inicio="$data_inicio";
    }

    $segundos_decorrer=strtotime(current_timestamp)-strtotime($assistencias_cliente['data_inicio']);


    $categoria = getInfoTabela('assistencias_categorias', ' and id_categoria = "'.$assistencias_cliente['id_categoria'].'"');
    $nome_categoria="<small class='label' style='background: black'>Sem categoria</small>";
    if(isset($categoria[0])){
        $nome_categoria="<small class='label' style='background: ".$categoria[0]['cor_cat']."'>".$categoria[0]['nome_categoria']."</small>";
    }

    $descricao=nl2br($assistencias_cliente['descricao']);
    if($descricao!=""){
        $descricao="<code><small>$descricao</small></code>";
    }

    $segundos_pausa_anterior=$assistencias_cliente['segundos_pausa'];
    $segundos_pausa_atual=0;
    //se nao esta em pausa
    if($assistencias_cliente['inicio_pausa']=="0000-00-00 00:00:00"){
        $tempoLigado="tempoLigado";
        $iconPausa="<i class='icon_pausa".$assistencias_cliente['id_assistencia_cliente']." fa fa-play text-success'></i>";
    }else{//se esta em pausa
        $segundos_pausa_atual=strtotime(current_timestamp)-strtotime($assistencias_cliente['inicio_pausa']);
        $tempoLigado="";
        $iconPausa="<i class='icon_pausa".$assistencias_cliente['id_assistencia_cliente']." fa fa-pause text-warning'></i>";
    }
    $total_pausas=$segundos_pausa_anterior+$segundos_pausa_atual;
    $segundos_decorrer=$segundos_decorrer-$total_pausas;

    $linha="
        <a class='widget' href='javascript:void(0)' style='padding:10px' onclick='addAssistClienteMaquina(this)' id_assistencia_cliente='".$assistencias_cliente['id_assistencia_cliente']."'>
            <table class='table table-borderless table-vcenter' style='margin-bottom: 0px'>
                    <tr >
                        <td style='width: 70%'>
                            $tipo_assistencia $nome_categoria<br>
                            <b><i class='fa fa-hashtag'></i>".$assistencias_cliente['nome_assistencia_cliente']."</b>
                            <br>
                        $nome_cliente
                                        
                        </td>
                           <td>
                                        <small class='text-muted'>Iniciada</small><br>
                                        <strong>$data_inicio</strong>
                                        <br>
                                        $iconPausa <strong  class='$tempoLigado assistencia".$assistencias_cliente['id_assistencia_cliente']." text-muted' data-segundos='$segundos_decorrer'>".secondsToTime($segundos_decorrer)."</strong>
                                        
                            </td>
                    </tr> 
                    <tr>
                        <td colspan='3'>$descricao</td>
                    </tr>
                </table>
        </a>";

    echo $linha ;
    $db->close();
    die;

}


$content=file_get_contents("tecnico.tpl");





/* ASSISTENCIAS INICIADAS */

$assistencias_clientes = getInfoTabela('assistencias_clientes',
    " and ativo=1 and assinado=0 and id_utilizador='".$_SESSION['id_utilizador']."' order by id_assistencia_cliente*1 asc");
$linhas_assist_iniciadas="";
foreach($assistencias_clientes as $assistencias_cliente){

    $tipo_assistencia = "<small class='label label-default'><i class='fa fa-truck'></i> Externa</small>";
    if($assistencias_cliente['externa'] == "0"){
        $tipo_assistencia = "<small class='label label-danger'><i class='fa fa-home'></i> Interna</small>";
    }

    $cliente = getInfoTabela('srv_clientes', ' and id_cliente = "'.$assistencias_cliente['id_cliente'].'"');
    $nome_cliente = "";
    if(isset($cliente[0])){
        $nome_cliente= ($cliente[0]['OrganizationName']);
    }

    $data_inicio="";
    if($assistencias_cliente['data_inicio']!="0000-00-00 00:00:00"){
        if(date("d/m/Y", strtotime($assistencias_cliente['data_inicio']))==date("d/m/Y", strtotime(current_timestamp))){
            $data_inicio = "Hoje às ".date("H:i", strtotime($assistencias_cliente['data_inicio']));
        }elseif(date("d/m/Y", strtotime($assistencias_cliente['data_inicio']))==date("d/m/Y", strtotime(current_timestamp. ' -1 days'))){
            $data_inicio = "Ontem às ".date("H:i", strtotime($assistencias_cliente['data_inicio']));
        }else{
            $data_inicio = $cfg_diasdasemana[date("w", strtotime($assistencias_cliente['data_inicio']))]."/".date("d, H:i", strtotime($assistencias_cliente['data_inicio']));
        }

        $data_inicio="$data_inicio";
    }

    $segundos_decorrer=strtotime(current_timestamp)-strtotime($assistencias_cliente['data_inicio']);


    $categoria = getInfoTabela('assistencias_categorias', ' and id_categoria = "'.$assistencias_cliente['id_categoria'].'"');
    $nome_categoria="<small class='label' style='background: black'>Sem categoria</small>";
    if(isset($categoria[0])){
        $nome_categoria="<small class='label' style='background: ".$categoria[0]['cor_cat']."'>".$categoria[0]['nome_categoria']."</small>";
    }

    $descricao=nl2br($assistencias_cliente['descricao']);
    if($descricao!=""){
        $descricao="<code><small>$descricao</small></code>";
    }


    $segundos_pausa_anterior=$assistencias_cliente['segundos_pausa'];
    $segundos_pausa_atual=0;
    //se nao esta em pausa
    if($assistencias_cliente['inicio_pausa']=="0000-00-00 00:00:00"){
        $tempoLigado="tempoLigado";
        $iconPausa="<i class='icon_pausa".$assistencias_cliente['id_assistencia_cliente']." fa fa-play text-success'></i>";
    }else{//se esta em pausa
        $segundos_pausa_atual=strtotime(current_timestamp)-strtotime($assistencias_cliente['inicio_pausa']);
        $tempoLigado="";
        $iconPausa="<i class='icon_pausa".$assistencias_cliente['id_assistencia_cliente']." fa fa-pause text-warning'></i>";
    }
    $total_pausas=$segundos_pausa_anterior+$segundos_pausa_atual;
    $segundos_decorrer=$segundos_decorrer-$total_pausas;

    $linhas_assist_iniciadas.="
        <a class='widget' href='javascript:void(0)' style='padding:10px' onclick='addAssistClienteMaquina(this)' id_assistencia_cliente='".$assistencias_cliente['id_assistencia_cliente']."'>
            <table class='table table-borderless table-vcenter' style='margin-bottom: 0px'>
                    <tr>
                        <td style='width: 70%;'>
                            $tipo_assistencia $nome_categoria<br>
                            <b><i class='fa fa-hashtag'></i>".$assistencias_cliente['nome_assistencia_cliente']."</b>
                            <br>
                        $nome_cliente
                                        
                        </td>
                           <td>
                                        <small class='text-muted'>Iniciada</small><br>
                                        <strong>$data_inicio</strong>
                                        <br>
                                        $iconPausa <strong  class='$tempoLigado text-muted assistencia".$assistencias_cliente['id_assistencia_cliente']."' data-segundos='$segundos_decorrer'>".secondsToTime($segundos_decorrer)."</strong>
                                        
                            </td>
                    </tr> 
                    <tr>
                        <td colspan='3'>$descricao</td>
                    </tr>
                </table>
        </a>";

}
if($linhas_assist_iniciadas != ""){
    $content=str_replace('class="sem-dados-assistencias_iniciadas"','class="sem-dados-assistencias_iniciadas" style="display:none"', $content);
}
$content=str_replace('_assistencias_iniciadas_',$linhas_assist_iniciadas,$content);

/* END ASSISTENCIAS INICIADAS */


/* AGENDA */

$assistencias = getInfoTabela('assistencias', " and ativo=1 and (id_utilizador='".$_SESSION['id_utilizador']."') order by data_inicio asc");

$linha_assistencia = "
<div class='assistencias'>
    _linhas_
</div>";

$linhas="";
foreach($assistencias as $assistencia){

    $data_inicio="";

    if($assistencia['data_inicio']!="0000-00-00 00:00:00"){
        if(date("d/m/Y", strtotime($assistencia['data_inicio']))==date("d/m/Y", strtotime(current_timestamp))){
            $data_inicio = "Hoje às ".date("H:i", strtotime($assistencia['data_inicio']));
        }elseif(date("d/m/Y", strtotime($assistencia['data_inicio']))==date("d/m/Y", strtotime(current_timestamp. ' + 1 days'))){
            $data_inicio = "Amanhã às ".date("H:i", strtotime($assistencia['data_inicio']));
        }else{
            $data_inicio = $cfg_diasdasemana[date("w", strtotime($assistencia['data_inicio']))]."/".date("d, H:i", strtotime($assistencia['data_inicio']));
        }

    }

    $datas="";



    if($data_inicio!=""){
        $cor="text-info";
        if(strtotime($assistencia['data_inicio'])<strtotime(current_timestamp)){
            $cor="text-danger";
        }
        $datas="<small class='".$cor."'>".$data_inicio."</small>";
    }else{
        $datas="<small class='text-warning'>Sem data definida</small>";
    }

    $cliente = getInfoTabela('srv_clientes', ' and id_cliente = "'.$assistencia['id_cliente'].'"');
    $nome_cliente = "";
    if(isset($cliente[0])){
        $nome_cliente= ($cliente[0]['OrganizationName']);
    }


    $categoria = getInfoTabela('assistencias_categorias', ' and id_categoria = "'.$assistencia['id_categoria'].'"');
    $nome_categoria="<small class='label' style='background: black'>Sem categoria</small>";
    if(isset($categoria[0])){
        $nome_categoria="<small class='label' style='background: ".$categoria[0]['cor_cat']."'>".$categoria[0]['nome_categoria']."</small>";
    }

    $descricao=nl2br($assistencia['descricao']);
    if($descricao!=""){
        $descricao="<br><code><small>$descricao</small></code>";
    }

    //ver se o ciente tem algum serviço por terminar
    $por_terminar = getInfoTabela('assistencias_clientes', ' and id_cliente = "'.$assistencia['id_cliente'].'" and por_terminar=1 and ativo=1');
    if(count($por_terminar)>0){
        $por_terminar="<br><small class='text-muted'><i class='fa fa-warning text-danger'></i> Tem serviço por terminar. </small>";
    }else{
        $por_terminar="";
    }

    $tipo="<small class='label label-default'><i class='fa fa-truck'></i> Externa</small>";
    if($assistencia['externa']==0){
        $tipo="<small class='label label-primary'><i class='fa fa-home'></i> Interna</small>";
    }

        $linhas.="<div class='linha-assistencia' id_assistencia='".$assistencia['id_assistencia']."' onclick='editarMarcacao(".$assistencia['id_assistencia'].")'>  
    <div style='width: 100%;'>
        $datas <br>$nome_cliente<br>$tipo $nome_categoria $por_terminar $descricao</span>
    </div>
    <small class='text-muted'><i class='fa fa-pencil fa-2x text-info'></i></small></div>";

}


if($linhas != ""){
    $content=str_replace('class="sem-dados-agenda"','class="sem-dados-agenda" style="display:none"', $content);
}

$linha_assistencia=str_replace('_linhas_',$linhas,$linha_assistencia);

$content=str_replace('_agenda_',$linha_assistencia,$content);


/* END AGENDA */






$viatura = getInfoTabela('viaturas left join estados_viaturas_linhas using(id_viatura)', ' and id_tecnico = "'.$_SESSION['id_utilizador'].'" and viaturas.ativo=1',
    '','','','viaturas.*, estados_viaturas_linhas.id_estado, estados_viaturas_linhas.id_estado_viatura');
$linhas="";
$esconder = "hidden";
// SE A DATA ATUAL + 1 MES FOR MAIOR QUE A DATA DO SEGURO, VAI AVISAR QUE FALTA 1 MES

$get_config = getInfoTabela('_conf_assists');
$dias_para_aviso_seguro = 30;
$dias_para_aviso_lavagem = 15;
$dias_para_aviso_inspecao = 30;
if(isset($get_config[0])){
    $dias_para_aviso_seguro=$get_config[0]['dias_para_aviso_seguro'];
    $dias_para_aviso_lavagem=$get_config[0]['dias_para_aviso_lavagem'];
    $dias_para_aviso_inspecao=$get_config[0]['dias_para_aviso_inspecao'];
}


$dias_para_aviso_seguro = date('Y-m-d', strtotime('+'.$dias_para_aviso_seguro.' days')); // PARA O SEGURO (x dias)
$dias_para_aviso_inspecao = date('Y-m-d', strtotime('+'.$dias_para_aviso_inspecao.' days')); // PARA A INSPECAO (x dias)
$dias_para_aviso_lavagem = date('Y-m-d', strtotime('+'.$dias_para_aviso_lavagem.' days')); // PARA A Lavagem (x dias)

$data_seguro = date('Y-m-d', strtotime($viatura[0]['data_seguro'])); // PARA A Lavagem (x dias)
$data_inspecao = date('Y-m-d', strtotime($viatura[0]['data_inspecao'])); // PARA A Lavagem (x dias)
$data_lavagem = date('Y-m-d', strtotime($viatura[0]['data_lavagem'])); // PARA A Lavagem (x dias)

if(isset($viatura[0])){

    $layout=str_replace("_kmAtuais_",$viatura[0]['kms_inicio'],$layout);
    $layout=str_replace("_kmRevisao_",$viatura[0]['kms_revisao'],$layout);
    $layout=str_replace("_kmPneus_",$viatura[0]['kms_pneus'],$layout);


    //inserir kms da viatura
    if(date("w",current_timestamp) == $_SESSION['cfg']['dia_semana_viaturas'] && date("Y-m-d",strtotime($viatura[0]['data_kms_atualizados']))!=date("Y-m-d",strtotime(current_timestamp))){
        $linhas.='
            <div class="linha-viatura kms_inicio"> 
             
                <div class="linha" onclick="openModal(\'#modal-km-viatura\');">
                   <span> <i class="fa fa-warning text-danger"></i> <b>KM da viatura</b><br><small>Insira os KM atuais da viatura.</small></span> 
                   <a href="#">  <i class="fa fa-play"></i> </a> 
                </div>
             
                </div>
                <script>setTimeout(function() {
                  openModal(\'#modal-km-viatura\');
                },2000)</script>
                                
          ';
    }

    // SEGURO
    // PASSADOS DE UM MES RESTANTE PARA A FRENTE
    if(strtotime($dias_para_aviso_seguro) >= strtotime($data_seguro)){


        // $dias_seguro_passados = (strtotime($data_atual_menos_1_mes) - strtotime($viatura['data_seguro'])) / (60 * 60 * 24);
        $esconder="";

        $linhas.='
    <div class="linha-viatura data_seguro"> 
     
        <div class="linha" onclick="openModal(\'#modal-seguro-viatura\');">
           <span> <i class="fa fa-warning text-danger"></i> <b>Seguro da Viatura</b> <br> <small><span class="data_seguro"><i class="fa fa-calendar pr-5"></i>'.data_portuguesa_real($viatura[0]['data_seguro']).'</span></small></span> 
           <a href="#">  <i class="fa fa-play"></i> </a> 
        </div>
     
        </div>
                        
  ';

    }


    // INSPECAO
    if(strtotime($dias_para_aviso_inspecao) >= strtotime($data_inspecao)){


        // $dias_seguro_passados = (strtotime($data_atual_menos_1_mes) - strtotime($viatura['data_seguro'])) / (60 * 60 * 24);
        $esconder="";

        $linhas.='
    <div class="linha-viatura data_inspecao"> 
     
        <div class="linha" onclick="openModal(\'#modal-inspecao-viatura\');">
           <span> <i class="fa fa-warning text-danger"></i> <b>Inspeção da Viatura</b> <br> <small><span class="data_inspecao"><i class="fa fa-calendar pr-5"></i>'.data_portuguesa_real($viatura[0]['data_inspecao']).'</span></small></span> 
           <a href="#">  <i class="fa fa-play"></i> </a> 
        </div>
     
        </div>
                        
  ';

    }

    // INSPECAO
    if(strtotime($dias_para_aviso_lavagem) >= strtotime($data_lavagem)){


        // $dias_seguro_passados = (strtotime($data_atual_menos_1_mes) - strtotime($viatura['data_seguro'])) / (60 * 60 * 24);
        $esconder="";

        $linhas.='
    <div class="linha-viatura data_lavagem"> 
     
        <div class="linha" onclick="openModal(\'#modal-lavagem-viatura\');">
           <span> <i class="fa fa-warning text-danger"></i> <b>Lavagem Viatura</b> <br> <small><span class="data_lavagem"><i class="fa fa-calendar pr-5"></i>'.data_portuguesa_real($viatura[0]['data_lavagem']).'</span></small></span> 
           <a href="#">  <i class="fa fa-play"></i> </a> 
        </div>
     
        </div>
                        
  ';

    }




    //inserir kms revisao
    if(($viatura[0]['kms_revisao']-100)<=$viatura[0]['kms_inicio']){
        $linhas.='
            <div class="linha-viatura kms_revisao"> 
                <div class="linha" onclick="openModal(\'#modal-kmrevisao-viatura\');">
                   <span> <i class="fa fa-warning text-danger"></i> <b>Revisão da viatura</b><br><small>Deve ser efetuada aos '.$viatura[0]['kms_revisao'].' km</small></span> 
                   <a href="#">  <i class="fa fa-play"></i> </a> 
                </div>
            </div>             
          ';
    }
    //inserir kms pneus
    if(($viatura[0]['kms_pneus']-100)<=$viatura[0]['kms_inicio']){
        $linhas.='
            <div class="linha-viatura kms_pneus"> 
                <div class="linha" onclick="openModal(\'#modal-kmpneus-viatura\');">
                   <span> <i class="fa fa-warning text-danger"></i> <b>Troca de pneus</b><br><small>Deve ser efetuada aos '.$viatura[0]['kms_pneus'].' km</small></span> 
                   <a href="#">  <i class="fa fa-play"></i> </a> 
                </div>
            </div>             
          ';
    }



}

$content=str_replace('bloco-viaturas"','bloco-viaturas '.$esconder.'"', $content);
$content=str_replace('_alertaviaturas_', $linhas,$content);



if(isset($_GET['ver_viatura'])){


    /* VIATURAS */

    $content_get=file_get_contents("mostrar_viatura.tpl");


    $id_estado_viatura_linha=0;
    $estado_viatura = "Sem estado definido";
    $class_btn="btn-info";

    if(isset($viatura[0])){
        $viatura = $viatura[0];

        $estado_viatura_nome = getInfoTabela('estados_viatura',' and id_estado_viatura="'.$viatura['id_estado'].'"');
        if(isset($estado_viatura_nome[0])){
            $estado_viatura = $estado_viatura_nome[0]['nome_estado_viatura'];

        }

        $id_estado_viatura_linha = $viatura['id_estado_viatura'];

        $id_estado_viatura=$viatura['id_estado'];


        if($id_estado_viatura == "1"){ // Em funcionamento
            $class_btn="btn-success";
        }
        else if($id_estado_viatura == "2"){ // AVARIADA
            $class_btn="btn-danger";
        }else if($id_estado_viatura == "3"){ // Reparação
            $class_btn="btn-info";
        }



        $content_get=str_replace('_estadoviatura_', $estado_viatura, $content_get);


        /* GET KMS ATUAIS */

        $kms_assistencias = getInfoTabela('assistencias',
            ' and id_viatura="'.$viatura['id_viatura'].'" and terminada = "1" and externa="1" order by id_assistencia desc limit 1',''
            ,'','','assistencias.kilometros');


        $kms_atuais = $viatura['kms_inicio'];
        if(isset($kms_assistencias[0])){
            $kms_atuais=$kms_assistencias[0]['kilometros'];
        }

        $viatura['kms'] = number_format($kms_atuais, 0,'',' ').' KM';

        /*  */

        foreach($viatura as $key => $value){

            if (strpos($key, 'data_') !== false) {
                $value = data_portuguesa($value);

               // $value=str_replace('-','/',$value);

            }

            $content_get=str_replace('id="'.$key.'" name="'.$key.'"', 'id="'.$key.'" value="'.$value.'" name="'.$key.'"', $content_get);
            $content_get=str_replace('_'.$key.'_', $value, $content_get);

        }


        // QR CODE VIATURA (PARA EMPRESTAR)
        $imageUrl='http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=https://filc.srv01.pt/mod_inicio/dashboard.php?emprestar_viatura='.$viatura['id_viatura'];
        $content_get=str_replace('_srcqrcode_',$imageUrl,$content_get);


    }else{
        $content_get=str_replace('class="com-viatura','class="com-viatura hidden',$content_get);
        $content_get=str_replace('class="sem-viatura hidden','class="sem-viatura ',$content_get);
    }

    $content_get=str_replace('_idestadoviaturalinha_', $id_estado_viatura_linha, $content_get);
    $content_get=str_replace('_estadoclassbtn_', $class_btn, $content_get);

    /* END VIATURAS */


    /* GET TECNICOS */
    $ops="";
    $utilizadores = getInfoTabela('utilizadores ',
        ' and ativo = 1 and id_utilizador <> "'.$_SESSION['id_utilizador'].'" ');
    foreach($utilizadores as $utilizador){

        $ops.="<option value='".$utilizador['id_utilizador']."'>".$utilizador['nome_utilizador']."</option>";

    }


    $content_get=str_replace('_tecnicos_', $ops, $content_get);


    /* GET ESTADOS VIATURAS */
    $ops="";
    $estados_viaturas = getInfoTabela('estados_viatura',' and ativo = 1');
    foreach($estados_viaturas as $estado_viatura){

        $selected="";
        if(isset($viatura['id_estado']) && $viatura['id_estado'] == $estado_viatura['id_estado_viatura']){
            $selected="selected";
        }

        $ops.="<option $selected value='".$estado_viatura['id_estado_viatura']."' name_value='".$estado_viatura['nome_estado_viatura']."'>".$estado_viatura['nome_estado_viatura']."</option>";

    }


    $content_get=str_replace('_estadosviaturas_', $ops, $content_get);

    echo $content_get;
    $db->close();
    die;
}


// PROGRESS BAR
$progressBar = "";

$horas_eficiencia = getInfoTabela('_conf_assists');
$horas_eficiencia = $horas_eficiencia[0]['horas_grafico_eficiencia'];

$today=$data_atual->format('Y-m-d'); // DATA COMPLETA DE HJ
$assistencias_clientes_terminadas = getInfoTabela('assistencias_clientes', ' and ativo=1 and assinado = 1 and DATE_FORMAT(data_inicio, "%Y-%m-%d") = "'.$today.'" and id_utilizador = '.$_SESSION['id_utilizador'],''
    ,'','','sum(tempo_assistencia) as tempo_assistencia, sum(tempo_viagem) as tempo_viagem, sum(segundos_pausa) as segundos_pausa');

$horas = 0;
$seconds = 0;
if(isset($assistencias_clientes_terminadas[0])){
    $seconds = $assistencias_clientes_terminadas[0]['tempo_assistencia'] +  $assistencias_clientes_terminadas[0]['tempo_viagem'] -  $assistencias_clientes_terminadas[0]['segundos_pausa'];
}

$horas += ($seconds / 60 / 60);
$valorPerc = round(($horas * 100) / $horas_eficiencia); // PERCENTAGEM DO VALOR


$class = "";
if($valorPerc < 80) {
    $class = "progress-bar-danger";
} elseif($valorPerc >= 80) {
    $class = "progress-bar-success";
}

$valorPercTemp = $valorPerc;
if($valorPerc > 100) {
    $valorPerc = 100;
}

if($valorPerc <= 0 || $valorPerc == "nan" || is_nan($valorPerc)){
    $valorPerc = 0;
}

if($horas <= 0 || $horas == "nan" || is_nan($horas)){
    $horas = 0;
}

// FAZER CONTA PARA PERCENTAGEM
$progressBar = ' <div class="bars-container" style="margin-left: 5px;margin-right:5px ">
                        <div class="progress" >
                            <div class="progress-bar ' . $class . '" role="progressbar" 
                            aria-valuenow="' . $valorPerc . '%" aria-valuemin="0" aria-valuemax="100" 
                            style="width:' . $valorPerc . '%">&nbsp;' . $valorPercTemp . '% </div>
                        </div>
                  </div>';

$content = str_replace('_progressbar_', $progressBar, $content);

// END PROGRESS BAR

$pageScript="
<script src='inicio.js'></script>
<script src='../assets/layout/js/plugins/signature_pad.min.js'></script>
<script src='qrcode.js'></script>
<script src='calendario.js'></script>
";

include ('../_autoData.php');