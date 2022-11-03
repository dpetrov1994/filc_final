<?php
@session_start();

$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".@$_SERVER['HTTP_HOST'].@$_SERVER['REQUEST_URI'];
$domain = ((@$_SERVER['HTTP_HOST']));
$urlAtual = explode("?",$actual_link);
$urlAtual = $urlAtual[0];
@define('actual_link',$actual_link);
@define('domain',$domain);
@define('urlAtual',$urlAtual);
date_default_timezone_set('Etc/UTC');
$data_atual = new DateTime('now', new DateTimeZone('Europe/Lisbon'));
$current_time_stamp=$data_atual->format('Y-m-d H:i:s');
@define('current_timestamp',$current_time_stamp);

$cfg_dirSugestao="../public/sugestoes.php";

//usado em categorias fornecedores
$tipos_campos=[
    'text' => "Texto livre",
    'textarea' => "Texto grande",
    'date' => "Data normal",
    'data_in' => "Data IN (para calculo de noites)",
    'data_out' => "Data OUT (para calculo de noites)",
    'noites' => "Nº noites (Necessita de Data IN e Data OUT)",
];

//tipos de entradas no historico
$tipos=[
    'Contacto telefónico',
    'Reunião',
    'Observação',
];
$icons=[
    'fa-phone',
    'fa-users',
    'fa-comment',
];
$cores=[
    'info',
    'amethyst',
    'success',
];
$cores_cod=[
    '#3EA4FC',
    '#7c62ad',
    '#3eb43b',
];
//tipos de entradas no historico

//estados das reparacoes
$estados_reparacoes=[
    '<span class="label label-default">Pendente</span>',
    '<span class="label label-success">Reparado</span>',
    '<span class="label label-info">Em progresso..</span>',
    '<span class="label label-warning">Sem solução</span>',
    '<span class="label label-danger">Cancelado</span>',
];
//estados das reparacoes

//estados das tarefas
$estados_tarefas=[
    '<span class="label label-default">Pendente</span>',
    '<span class="label label-success">Terminada</span>'
];
//estados das tarefas

//estados das marcacoes
$estados_marcacoes=[
    '<span class="label label-default">Pendente</span>',
    '<span class="label label-success">Confirmada</span>',
    '<span class="label label-danger">Cancelada</span>'
];

$tipos_cliente=[
  0=>"Comprador",
  1=>"Vendedor",
  2=>"Ambos",
];

//estados das tarefas
$cfg_meses = array (1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
$cfg_sessoes = array (0 => "Única",1 => "Primeira", 2 => "Segunda", 3 => "Terceira", 4 => "Quarta", 5 => "Quinta", 6 => "Sexta", 7 => "Sétima", 8 => "Oitava", 9 => "Nona", 10 => "Décima", 11 => "Décima Primeira", 12 => "Décima Segunda", 13 => "Décima Terceira", 14 => "Décima Quarta");
$cfg_unidades = array (
    "Unidade",
    "Caixa",
    "Pacote",
    "Litros",
    "Centilitros",
    "Mililitros",
    "Metros",
    "Centimetros",
    "Milimetros",
);
$cfg_diasdasemana = array (1 => "Seg",2 => "Ter",3 => "Qua",4 => "Qui",5 => "Sex",6 => "Sáb",0 => "Dom");
$cfg_meses_abr = array (1 => "Jan", 2 => "Fev", 3 => "Mar", 4 => "Abr", 5 => "Mai", 6 => "Jun", 7 => "Jul", 8 => "Ago", 9 => "Set", 10 => "Out", 11 => "Nov", 12 => "Dez");

if(!isset($_SESSION['cfg'])){
    $db2=ligarBD();
    $sql ="SELECT * FROM _conf_estado_plataforma";
    $result=runQ($sql,$db2,0);
    while($row = $result->fetch_assoc()){
        $_SESSION['cfg']['manutencao']=($row['manutencao']);
        $_SESSION['cfg']['ativo']=($row['ativo']);
    }

    $sql ="SELECT * FROM _conf_plataforma WHERE ativo=1";
    $result=runQ($sql,$db2,1);
    while($row = $result->fetch_assoc()){
        $_SESSION['cfg']['copyPlataforma']=removerHTML($row['nome_plataforma']);
        $_SESSION['cfg']['layout']=removerHTML($row['layout']);
        $_SESSION['cfg']['metaDescricao']=removerHTML($row['meta_descricao']);
        $_SESSION['cfg']['metaAutor']=removerHTML($row['meta_autor']);
        $_SESSION['cfg']['metaKeywords']=removerHTML($row['meta_keywords']);
        $_SESSION['cfg']['metaRobots']=removerHTML($row['meta_robots']);
        $_SESSION['cfg']['copySite']=removerHTML($row['url']);
        $_SESSION['cfg']['idioma']=removerHTML($row['idioma']);
        $_SESSION['cfg']['espacoDisco']=removerHTML($row['espaco_disco']); // em GB
        $_SESSION['cfg']['espacoReservadoSys']=removerHTML($row['espaco_reservado_sys']); // em GB
        $_SESSION['cfg']['tamanhoMaxUpload']=removerHTML($row['tamanho_max_upload']); // em MB
        $_SESSION['cfg']['servidorSms']=removerHTML($row['servidor_sms']);
        $_SESSION['cfg']['limiteSms']=removerHTML($row['limite_sms']);
        $_SESSION['cfg']['tamanhoSms']=removerHTML($row['tamanho_sms']);
        $_SESSION['cfg']['servidorSugestoes']=removerHTML($row['servidor_sugestoes']);
        $_SESSION['cfg']['lchk']=removerHTML($row['lchk']);
        @define('chave_encriptacao',$row['chave']);
    }

    $sql ="SELECT * FROM _conf_cliente";
    $result=runQ($sql,$db2,2);
    while($row = $result->fetch_assoc()){
        $_SESSION['cfg']['nomePlataforma']=removerHTML($row['nome_plataforma']);
        $_SESSION['cfg']['temaPlataforma']=removerHTML($row['tema']);
        $_SESSION['cfg']['nomeEmpresa']=removerHTML($row['nome_empresa']);
        $_SESSION['cfg']['moradaEmpresa']=removerHTML($row['morada']);
        $_SESSION['cfg']['siteEmpresa']=removerHTML($row['site_empresa']);
        $_SESSION['cfg']['contactoEmpresa']=removerHTML($row['telefone']);
    }

    $sql ="SELECT * FROM _conf_assists";
    $result=runQ($sql,$db2,2);
    while($row = $result->fetch_assoc()){
        foreach ($row as $key =>$value){
            $_SESSION['cfg'][$key]=$value;
        }

    }


    $_SESSION['cfg']['dias_bloqueados']=[];
    $db2->close();
}

$cfg_manutencao=$_SESSION['cfg']['manutencao'];
$cfg_ativo=$_SESSION['cfg']['ativo'];
$cfg_copyPlataforma=$_SESSION['cfg']['copyPlataforma'];
$cfg_layout=$_SESSION['cfg']['layout'];
$cfg_metaDescricao=$_SESSION['cfg']['metaDescricao'];
$cfg_metaAutor=$_SESSION['cfg']['metaAutor'];
$cfg_metaKeywords=$_SESSION['cfg']['metaKeywords'];
$cfg_metaRobots=$_SESSION['cfg']['metaRobots'];
$cfg_copySite=$_SESSION['cfg']['copySite'];
$cfg_idioma=$_SESSION['cfg']['idioma'];
$cfg_espacoDisco=$_SESSION['cfg']['espacoDisco'];
$cfg_espacoReservadoSys=$_SESSION['cfg']['espacoReservadoSys'];
$cfg_tamanhoMaxUpload=$_SESSION['cfg']['tamanhoMaxUpload'];
$cfg_servidorSms=$_SESSION['cfg']['servidorSms'];
$cfg_limiteSms=$_SESSION['cfg']['limiteSms'];
$cfg_tamanhoSms=$_SESSION['cfg']['tamanhoSms'];
$cfg_servidorSugestoes=$_SESSION['cfg']['servidorSugestoes'];
$cfg_nomePlataforma=$_SESSION['cfg']['nomePlataforma'];
$cfg_temaPlataforma=$_SESSION['cfg']['temaPlataforma'];
$cfg_nomeEmpresa=$_SESSION['cfg']['nomeEmpresa'];
$cfg_mora=$_SESSION['cfg']['moradaEmpresa'];
$cfg_siteEmpresa=$_SESSION['cfg']['siteEmpresa'];
$cfg_dirSugestoes=$_SESSION['cfg']['servidorSugestoes'];

if(!isset($_SESSION['grupos'])){
    $grupos=[];
}else{
    $grupos=$_SESSION['grupos'];
}

//index url
if(is_file("mod_perfil/index.php")){
    $indexUrl="mod_perfil/index.php";
}else{
    $indexUrl="../mod_perfil/index.php";
}

$_SESSION['cfg']['hostFilesystem']="windows";
$layoutDirectory="assets/layout";
if(!is_file("$layoutDirectory/main.tpl")){
    $layoutDirectory="../assets/layout";
}


$tpl_nota='<div class="nota" id="nota_id_nota_" style="background: _cor_" data-cor="_cor_" >
                <div class="cores-nota">
                    <a href="javascript:void(0)" onclick="mudarCorNota(_id_nota_,\'#FEFF9C\');editarNota(_id_nota_)" style=""><i class="fa fa-circle" style="font-size: 25px;color: #FEFF9C"></i></a>
                    <a href="javascript:void(0)" onclick="mudarCorNota(_id_nota_,\'#FFF740\');editarNota(_id_nota_)" style=""><i class="fa fa-circle" style="font-size: 25px;color: #FFF740"></i></a>
                    <a href="javascript:void(0)" onclick="mudarCorNota(_id_nota_,\'#7AFCFF\');editarNota(_id_nota_)" style=""><i class="fa fa-circle" style="font-size: 25px;color: #7AFCFF"></i></a>
                    <a href="javascript:void(0)" onclick="mudarCorNota(_id_nota_,\'#FF7EB9\');editarNota(_id_nota_)" style=""><i class="fa fa-circle" style="font-size: 25px;color: #FF7EB9"></i></a>
                    <a href="javascript:void(0)" onclick="mudarCorNota(_id_nota_,\'#FF65A3\');editarNota(_id_nota_)" style=""><i class="fa fa-circle" style="font-size: 25px;color: #FF65A3"></i></a>
                    <a href="javascript:void(0)" onclick="confirmaModal(\'../mod_notas/reciclar.php?id=_id_nota_\');" class="pull-right"><i class="fa fa-times" style="font-size: 15px;color: white;margin-top: 4px;margin-right: 4px;"></i></a>
                </div>

                <textarea onkeyup="editarNota(_id_nota_)" onchange="editarNota(_id_nota_)" class="form-control" id="descricaonota_id_nota_" style="background: transparent;font-size: 12px;color:black" rows="5">_nota_</textarea>

                    <div style="width: 100%;" class="_esconderParaFuncionarios_">
                    <table class="table table-borderless table-vcenter" style="margin-bottom: 0px">
                    <tr>
                    <td style="width: 50%">
                    <div class="input-group _esconderParaFuncionarios_">
                            <span class="input-group-btn">
                            <button type="button" class="btn " style="font-size: 14px;background: transparent;color:black"><i style="color:black" class="fa fa-bell text-dark"></i></button>
                            </span>
                            <input onkeyup="editarNota(_id_nota_)" onchange="editarNota(_id_nota_)" style="font-size: 12px;background: transparent;color:black;border: none" id="datalembretenota_id_nota_" class="form-control" value="_lembrar_" type="date">
                        </div>
</td>
 <td style="width: 50%">
    <label style="color: black" data-toggle="tooltip" title="Nofificar todos os administradores"><input onclick="editarNota(_id_nota_)" type="checkbox" id="notificaradminsnota_id_nota_"> <i class="fa fa-users"></i></label> 
    <label style="color: black" data-toggle="tooltip" title="Esconder para funcionários"><input onclick="editarNota(_id_nota_)" type="checkbox" id="mostrarfuncionariosnota_id_nota_"> <i class="fa fa-eye-slash"></i></label> 
 </td>
</tr>
</table>
                        
                    </div>
                    <div style="width: 100%;text-align: center;padding-bottom: 3px;color:black">
                        <small><i class="fa fa-edit"></i> _nomeCriou_, _dataCriado_</small>
                    </div>

            </div>';


$meses = array(
    1 => 'Janeiro',
    2 => 'Fevereiro',
    3 => 'Março',
    4 => 'Abril',
    5 => 'Maio',
    6 => 'Junho',
    7 => 'Julho',
    8 => 'Agosto',
    9 => 'Setembro',
    10 => 'Outubro',
    11 => 'Novembro',
    12 => 'Dezembro'
);
$meses_abr = array(
    1 => 'Jan',
    2 => 'Fev',
    3 => 'Mar',
    4 => 'Abr',
    5 => 'Mai',
    6 => 'Jun',
    7 => 'Jul',
    8 => 'Ago',
    9 => 'Set',
    10 => 'Out',
    11 => 'Nov',
    12 => 'Dez'
);
$meses_array = array(
    1 => 'Janeiro',
    2 => 'Fevereiro',
    3 => 'Março',
    4 => 'Abril',
    5 => 'Maio',
    6 => 'Junho',
    7 => 'Julho',
    8 => 'Agosto',
    9 => 'Setembro',
    10 => 'Outubro',
    11 => 'Novembro',
    12 => 'Dezembro'
);
$dias_da_semana = array(
    'Domingo',
    'Segunda-Feira',
    'Terça-Feira',
    'Quarta-Feira',
    'Quinta-Feira',
    'Sexta-Feira',
    'Sábado'
);
