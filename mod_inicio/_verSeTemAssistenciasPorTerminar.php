<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");
$id_cliente=0;

//mostrar as assistencias por terminar no modal de assintaura
$id_pai=0;
if(isset($_GET['id_assistencia_cliente'])){
    $id_assistencia_cliente=$db->escape_string($_GET['id_assistencia_cliente']);
    // GET ID DO CLIENTE
    $id_cliente = getInfoTabela('assistencias_clientes', " and id_assistencia_cliente = '$id_assistencia_cliente'");
    $id_pai=$id_cliente[0]['id_pai'];
    $id_cliente=$id_cliente[0]['id_cliente'];

}

if(isset($_GET['id_cliente'])){
    $id_cliente=$db->escape_string($_GET['id_cliente']);
}

if($id_cliente!=0){
    //ver se o ciente tem algum serviço por terminar

    $add_sql=" and id_pai=0";
    if(isset($_GET['id_assistencia_cliente'])){
        if($id_pai==0){
            $add_sql=" and id_assistencia_cliente='$id_pai'  ";
        }else{
            $add_sql=" and (id_pai='$id_pai' or id_assistencia_cliente='$id_pai') ";
        }

    }

    $por_terminar_filtrado=[];
    $por_terminar = getInfoTabela('assistencias_clientes', ' and id_cliente = "'.$id_cliente.'" and por_terminar=1 '.$add_sql.' and ativo=1 order by id_assistencia_cliente asc');
    foreach ($por_terminar as $pt){
        $por_terminar_filtrado[$pt['id_assistencia_cliente']]=$pt;
    }

    //para cada maquina do serviço
    if(isset($_GET['id_assistencia_cliente'])){
        $maquinas_deste_servico=getInfoTabela("assistencias_clientes_maquinas"," and ativo=1 and concluido=1 and id_assistencia_cliente=".$id_assistencia_cliente);
        foreach ($maquinas_deste_servico as $ma){
            $id_maquina=$ma['id_maquina'];
            $outros_servicos=getInfoTabela("assistencias_clientes_maquinas"," and ativo=1 and id_maquina='$id_maquina' and concluido=0 and id_assistencia_cliente!=".$id_assistencia_cliente);
            foreach ($outros_servicos as $os){
                $maquinas_no_servico=getInfoTabela("assistencias_clientes_maquinas"," and ativo=1 and id_assistencia_cliente='".$os['id_assistencia_cliente']."' and concluido=0 and id_maquina!='$id_maquina' group by id_assistencia_cliente");
                if(count($maquinas_no_servico)==0){
                    $servico=getInfoTabela("assistencias_clientes"," and ativo=1 and id_assistencia_cliente='".$os['id_assistencia_cliente']."' and por_terminar=1");

                    if(count($servico)>0) {
                        $servico = $servico[0];
                        $por_terminar_filtrado[$servico['id_assistencia_cliente']]=$servico;
                    }
                }
            }
        }
    }
    //fim outros serviços com as maquinas deeste

    $por_terminar_html="";
    if(count($por_terminar_filtrado)>0){
        $por_terminar_html="";
        foreach ($por_terminar_filtrado as $pt){

            $maquinas_por_terminar_filtrado=[];
            $maquinas_por_terminar_arr=getInfoTabela('assistencias_clientes_maquinas', ' and ativo=1 and concluido=0 and id_assistencia_cliente = "'.$pt['id_assistencia_cliente'].'"');
            foreach ($maquinas_por_terminar_arr as $ma_arr){
                $maquinas_por_terminar_filtrado[$ma_arr['id_maquina']]=$ma_arr;
            }


            $user=getInfoTabela('utilizadores', ' and id_utilizador = "'.$pt['id_criou'].'"');
            $nome_utilizador="";
            if(isset($user[0])){
                $nome_utilizador=$user[0]['nome_utilizador'];
            }


            //mostar os serviços que vai continuar ao iniciar assistencia
            if(!isset($_GET['id_assistencia_cliente'])){
                $outros_por_terminar=0;
                $maquinas="";

                $por_terminar2 = getInfoTabela('assistencias_clientes', ' and ativo=1 and (id_pai='.$pt['id_assistencia_cliente'].')');

                foreach ($por_terminar2 as $pt2){
                    $maquinas_por_terminar_arr=getInfoTabela('assistencias_clientes_maquinas', ' and ativo=1 and concluido=0 and id_assistencia_cliente = "'.$pt2['id_assistencia_cliente'].'"');
                    foreach ($maquinas_por_terminar_arr as $ma_arr){
                        $maquinas_por_terminar_filtrado[$ma_arr['id_maquina']]=$ma_arr;
                    }
                }

                $outros_por_terminar=count($por_terminar2);
                if($outros_por_terminar!=0){
                    if($outros_por_terminar==1){
                        $outros_por_terminar=" + 1 serviço";
                    }else{
                        $outros_por_terminar=" + ".$outros_por_terminar." serviços";
                    }
                }else{
                    $outros_por_terminar="";
                }


                foreach ($maquinas_por_terminar_filtrado as $ma){
                    $maquina=getInfoTabela('maquinas', ' and id_maquina= "'.$ma['id_maquina'].'"');
                    $maquina=$maquina[0];

                    $maquinas.="<b>".$maquina['nome_maquina']."</b> (".$maquina['ref'].")<br>";
                }



                $str_time_final = strtotime($pt['data_inicio']);
                //$str_time_inicial = strtotime($data_inicio);
                $str_time_atual = strtotime(current_timestamp);

                //$tempo_que_passou = $str_time_final - $str_time_inicial;
                $tempo_que_passou = $str_time_atual - $str_time_final;

                $dias_passados = round($tempo_que_passou / (60 * 60 * 24));

                if($dias_passados < 1){
                    $dias_passados=date("d/m/Y",$str_time_final)." (Hoje)";
                }elseif($dias_passados == 1 ){
                    $dias_passados=date("d/m/Y",$str_time_final)." (Ontem)";
                }else{
                    $dias_passados=date("d/m/Y",$str_time_final)." ($dias_passados dias atrás)";
                }

                if($maquinas!=""){
                    $maquinas="<b class='text-danger'>Máquinas não concluídas:</b><br>$maquinas";
                }

                $categoria = getInfoTabela('assistencias_categorias', ' and id_categoria = "'.$pt['id_categoria'].'"');
                $nome_categoria="<small class='label' style='background: black'>Sem categoria</small>";
                if(isset($categoria[0])){
                    $nome_categoria="<small class='label' style='background: ".$categoria[0]['cor_cat']."'>".$categoria[0]['nome_categoria']."</small>";
                }

                $por_terminar_html.="<tr>
            <td>$nome_categoria<br><b>".$pt['nome_assistencia_cliente']."</b> com <b>$nome_utilizador</b> <small><small class='text-info'>$outros_por_terminar</small></small>
            <br><small class='text-muted'>$dias_passados</small><br>
                $maquinas
            </td>
            <td style='width: 10px;'>
            
            <label class='csscheckbox csscheckbox-primary'><input class='ids-assistencias-por-terminar' name='id_pai' value='".$pt['id_assistencia_cliente']."' type='radio'><span></span></label>
            
</td>
</tr>";
            }else{//mostrar as assistencias por terminar no modal de assintaura

                $tipo_assistencia = "<small class='label label-default'><i class='fa fa-truck'></i> Externa</small>";
                if($pt['externa'] == "0"){
                    $tipo_assistencia = "<small class='label label-danger'><i class='fa fa-home'></i> Interna</small>";
                }

                $data_inicio="";
                if($pt['data_inicio']!="0000-00-00 00:00:00"){
                    if(date("d/m/Y", strtotime($pt['data_inicio']))==date("d/m/Y", strtotime(current_timestamp))){
                        $data_inicio = "Hoje às ".date("H:i", strtotime($pt['data_inicio']));
                    }elseif(date("d/m/Y", strtotime($pt['data_inicio']))==date("d/m/Y", strtotime(current_timestamp. ' -1 days'))){
                        $data_inicio = "Ontem às ".date("H:i", strtotime($pt['data_inicio']));
                    }else{
                        $data_inicio = $cfg_diasdasemana[date("w", strtotime($pt['data_inicio']))]."/".date("d, H:i", strtotime($pt['data_inicio']));
                    }

                    $data_inicio="$data_inicio";
                }

                $categoria = getInfoTabela('assistencias_categorias', ' and id_categoria = "'.$pt['id_categoria'].'"');
                $nome_categoria="<small class='label' style='background: black'>Sem categoria</small>";
                if(isset($categoria[0])){
                    $nome_categoria="<small class='label' style='background: ".$categoria[0]['cor_cat']."'>".$categoria[0]['nome_categoria']."</small>";
                }

                $tecnico = getInfoTabela('utilizadores', ' and id_utilizador="'.$pt['id_utilizador'].'"');
                $nome_tecnico = $tecnico[0]['nome_utilizador'];

                $descricao=nl2br($pt['descricao']);
                if($descricao!=""){
                    $descricao="<br><code><small>$descricao</small></code>";
                }

                $por_terminar_html .= "
                <tr>
                    <td>
                        $tipo_assistencia $nome_categoria<br>
                        <b>" . $pt['nome_assistencia_cliente'] . "</b> com <b><i class='fa fa-user'></i>$nome_tecnico</b><br>
                        <small class='text-muted'>$data_inicio</small>
                        $descricao
                    </td>
                </tr>
            ";

            }

        }
    }
}


if($por_terminar_html==""){
    $response="<h3 class='text-center '><small class='text-success'><i class='fa fa-check'></i> Sem serviços por terminar.</small></h3>";
}else{

    $info="<div class='text-center'><b class='text-info'><i class='fa fa-info-circle'></i> Terminar também os serviços:</b></div>";
    if(!isset($_GET['id_assistencia_cliente'])){
        $por_terminar_html.='<tr>
                                            <td><b class="text-info">Iniciar novo serviço</b></td>
                                            <td style=\'width: 10px;\'>
                                            <label class="csscheckbox csscheckbox-primary"><input class="ids-assistencias-por-terminar" name="id_pai" value="0" type="radio"><span></span></label>  
                                            </td>
                                        </tr>';
        $info='<br>
                                    <label><i class="fa fa-warning text-danger"></i> Este cliente tem serviços por terminar.</label><br>
                                    <span class="text-info">Dos itens abaixo marque os que planeia terminar nesta visita.</span>';
    }else{
        if($por_terminar_html!=""){
            if($por_terminar_html!=""){
                $por_terminar_html="
        <label class='text-danger'>Fechar também estes serviços</label>
        <table class='table table-vcenter table-bordered'>$por_terminar_html</table>";
            }
        }
    }
    $response='<div class="col-lg-12 input-status">
                                    '.$info.'
                                    <div class="lista-assistencias-por-terminar">
                                        <br>
                                        <table class="table table-vcenter table-bordered">
                                        '.$por_terminar_html.'
                                        
</table>
                                    </div>
                                </div>';
}

//validar se já tem alguma marcação e perguntar se o user quer aproveitar essa marcação
//só em adicionar paragem
if(isset($_GET['id_cliente'])){

    $marcacoes = getInfoTabela('assistencias', ' and id_cliente = "'.$id_cliente.'" and em_curso = 0 and pendente=0 and terminada=0 and ativo=1 order by pendente asc, data_inicio asc');
    $marcacoes_html="";
    foreach ($marcacoes as $marcacao){

        $user=getInfoTabela('utilizadores', ' and id_utilizador = "'.$marcacao['id_utilizador'].'"');
        $nome_utilizador="";
        if(isset($user[0])){
            $nome_utilizador=$user[0]['nome_utilizador'];
        }

        $data_inicio="<small class='text-warning'>Sem data definida</small>";
        if($marcacao['data_inicio']!="0000-00-00 00:00:00"){
            if(date("d/m/Y", strtotime($marcacao['data_inicio']))==date("d/m/Y", strtotime(current_timestamp))){
                $data_inicio = "Hoje às ".date("H:i", strtotime($marcacao['data_inicio']));
            }elseif(date("d/m/Y", strtotime($marcacao['data_inicio']))==date("d/m/Y", strtotime(current_timestamp. ' + 1 days'))){
                $data_inicio = "Amanhã às ".date("H:i", strtotime($marcacao['data_inicio']));
            }else{
                $data_inicio = $cfg_diasdasemana[date("w", strtotime($marcacao['data_inicio']))]."/".date("d, H:i", strtotime($marcacao['data_inicio']));
            }

            $data_inicio="<small class='text-muted'>$data_inicio</small>";
        }

        $categoria = getInfoTabela('assistencias_categorias', ' and id_categoria = "'.$marcacao['id_categoria'].'"');
        $nome_categoria="<small class='label' style='background: black'>Sem categoria</small>";
        if(isset($categoria[0])){
            $nome_categoria="<small class='label' style='background: ".$categoria[0]['cor_cat']."'>".$categoria[0]['nome_categoria']."</small>";
        }

        $marcacoes_html.="<tr>
            <td>
                <i class='fa fa-hashtag'></i>".$marcacao['nome_assistencia']." $nome_categoria<br>
                <i class='fa fa-calendar'></i> $data_inicio <br>
                <i class='fa fa-user'></i> $nome_utilizador<br>
                <code class='bg-info' style='width: 100%'><small style='color:black'>Comentários:</small><br><small>".nl2br($marcacao['descricao'])."</small></code>
            </td>
            <td style='width: 10px;'>
                <label class='csscheckbox csscheckbox-primary'><input class='ids-marcacoes-aproveitar' name='marcacoes-aproveitar' onclick=\"mostrarSeChecked('.categorias_e_descricao',document.getElementById('nenhuma_das_acima').checked)\" value='".$marcacao['id_assistencia']."' type='radio'><span></span></label>       
            </td>
            </tr>";
    }

}

$class="";
if($marcacoes_html!=""){
    $class="categorias_e_descricao";
    $marcacoes_html.='<tr>
                                            <td><span class="text-info">Nenhuma das acima</span></td>
                                            <td style=\'width: 10px;\'>
                                            <label class="csscheckbox csscheckbox-primary"><input id="nenhuma_das_acima" checked class="ids-marcacoes-aproveitar" onclick="mostrarSeChecked(\'.categorias_e_descricao\',this.checked)"  name="marcacoes-aproveitar" value="0" type="radio"><span></span></label>  
                                            </td>
                                        </tr>';
    $response.='<div class="col-lg-12 input-status">
                                   <br>
                                    <label><i class="fa fa-info-circle text-info"></i> Este cliente tem marcações.</label><br>
                                    <small class="text-muted">Gostaria de aproveitar alguma?</small>
                                    <div>
                                        <br>
                                        <table class="table table-vcenter table-bordered">
                                        '.$marcacoes_html.'
                                        
</table>
                                    </div>
                                </div>
                                ';
}

if(!isset($_GET['para_assinar'])) {
//ir buscar o seletor da categoria e campo para obs se for para adicionar uma paragem
    $sql_preencher = "select * from assistencias_categorias where ativo=1 and comercial='".$_SESSION['comercial']."'";
    $result_preencher = runQ($sql_preencher, $db, "preenchimento de formulario");
    $ops = "";
    while ($row_preencher = $result_preencher->fetch_assoc()) {
        $ops .= '<label class="csscheckbox csscheckbox-primary"><input type="radio" class="categorias_paragem" name="id_categoria" value="' . $row_preencher["id_categoria"] . '"><span></span> <div class="label" style="background: ' . $row_preencher["cor_cat"] . '">' . $row_preencher["nome_categoria"] . '</div></label><br>';
    }

    $response .= "
<div class='$class row' >
    <div class='form-group form-group-sm '>
                    <div class='col-xs-12' style='padding-top: 0px'>
                        <label class='col-lg-12' >Categoria</label>
                        <div class='col-lg-12 input-status'>
                            <label class='csscheckbox csscheckbox-primary'><input id='nehuma_cat' class='categorias_paragem' checked type='radio' name='id_categoria'  value='0'><span></span> Sem categoria</label><br>
                            $ops
                        </div>
                    </div>
                </div>
</div>
";
}



print $response;

$db->close();