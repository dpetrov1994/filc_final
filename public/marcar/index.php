<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 08/09/2018
 * Time: 18:35
 */

include_once("../../_funcoes.php");
include_once("../../conf/dados_plataforma.php");

$cfg_nome_funcionalidade="Marcar";
$layout=file_get_contents("index.html");
$db=ligarBD('index.php');

if(isset($_GET['marcar'])){
    $email=$db->escape_string($_GET['email']);
    $nome=$db->escape_string($_GET['nome']);
    $id_servico=$db->escape_string($_GET['id_servico']);
    $data=$db->escape_string($_GET['data_inicio']);
    $bloco_horas=$db->escape_string($_GET['bloco_horas']);
    $tmp=explode(" - ",$bloco_horas);
    $hora_inicio=$tmp[0];
    $hora_fim=$tmp[1];

    $data_inicio=$data." $hora_inicio";
    $data_fim=$data." $hora_fim";


    $sql="select * from clientes where email='$email'";
    $result=runQ($sql,$db,"verificamos se o cliente exisiste");
    if($result->num_rows==0){
        $sql="insert into clientes (email,nome,descricao) values ('$email','$nome','Registado automatiamente via app/web')";
        $result=runQ($sql,$db,"inserrimos o cliente");
        $id_cliente=$db->insert_id;
    }else{
        while ($row = $result->fetch_assoc()) {
            $id_cliente=$row['id_cliente'];
        }
    }

    $sql="select nome_servico from servicos";
    $result=runQ($sql,$db,"get nome_servico");
    while ($row = $result->fetch_assoc()) {
        $nome_servico=$row['nome_servico'];
    }

    $sql="insert into marcacoes (descricao, id_cliente, data_inicio, data_fim, id_servico, id_criou, created_at) 
          values ('Registado automatiamente via app/web','$id_cliente','$data_inicio','$data_fim','$id_servico','0','".current_timestamp."')";
    $result=runQ($sql,$db,"inserimos a marcação");
    $insert_id=$db->insert_id;

    $destinatarios_email=[];
    //enviar noptificao para os emails da configuração
    $sql="select * from _conf_assists";
    $result=runQ($sql,$db,"get emails dos admins");
    while ($row = $result->fetch_assoc()) {
        $destinatarios_email=explode(",",$row['emails_notificacao']);
    }

    $link=str_replace("index.php","",urlAtual);
    $link=str_replace("public/marcar/","mod_marcacoes/detalhes.php?id=$insert_id",$link);

    $nome_notificacao = "Nova marcação";
    $nome_tabela = "marcacoes";
    $nome_coluna = "id_marcacao";
    $id_item = $insert_id;
    $url_destino = $link;
    $texto_email = '
                            <h2 align="center" >Nova marcação ('.$data.' '.$hora_inicio.'-'.$hora_fim.' )</h2>
                            <h3 align="center" style="font-size: 12px">
                            Inserido por ' . $nome . '<br>
                            Serviço: ' . $nome_servico . '<br>
                            </h3>
                            <p align="center" style="width: 100%">
                                <h1 align="center" style="width: 100%">
                                    <table align="center" bgcolor="#5ccdde" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
                                        <tr>
                                            <td align="center" height="55" style=" padding: 0 35px 0 35px; font-family: Arial, sans-serif; font-size: 22px;" class="button">
                                                <a href="'.$link.'" style="color: #ffffff; text-align: center; text-decoration: none;">Confirmar/Recusar</a>
                                            </td>
                                        </tr>
                                    </table>
                                </h1>
                                </p>
                            </br>
                            <p><b>Pode também entrar na nossa plataforma utilizando a APP ou através da hiperligação:<br> <a href="' . $link . '">' . $link . '</a></b></p>
                           ';

    notificar($nome_notificacao, $nome_tabela, $nome_coluna, $id_item, $url_destino, $destinatarios = [], $destinatarios_email, $texto_email);

    header("index.php?cod=1");
}


/** preencher os serviços $linha */
$linha='<span class="radio_button_label" style="height:150px "><input id="servico_id_servico_" name="id_servico" type="radio" required value="id_servico"/><label for="servico_id_servico_" style="text-align: center"><div class="circle">_valor_€</div><br>_nome_servico_</label></span>';
$sql="select * from servicos where ativo=1 order by nome_servico asc";
$result=runQ($sql,$db,"servicos get");
$linhas="";
while ($row = $result->fetch_assoc()) {
    $linhas.=$linha;
    $linhas=str_replace("_id_servico_",$row['id_servico'],$linhas);
    $linhas=str_replace("_nome_servico_",$row['nome_servico'] ,$linhas);
    $linhas=str_replace("_valor_",$row['valor'] ,$linhas);
}
$layout=str_replace("_servicos_",$linhas,$layout);
/** fim preencher os serviços $linha */

/** preencher os dias */

$segunda_feira=current_timestamp;
while (date("w",strtotime($segunda_feira))!=1){
    $segunda_feira=date("Y-m-d",strtotime("-1 day",strtotime($segunda_feira)));
}

$ultimo_dia=date("Y-m-d",strtotime("+3 month -1 day",strtotime(current_timestamp)));

$linha='<span class="calendario" style="height:40px "><input id="escolher_dia_" name="data_inicio" type="radio" value="_val_" _disabled_ required/><label for="escolher_dia_"><div class="small_square _disabled_">_dia_</div></label></span>';
$linhas="
   
    ";
$meses="";
$data_atual=$segunda_feira;
$mes_atual=date("n",strtotime($data_atual));
while ($data_atual<=$ultimo_dia){

    $disabled="";
    if(in_array(date("w",strtotime($data_atual)),$_SESSION['ignorar_dias']) || $data_atual<current_timestamp){
        $disabled="disabled";
    }
    $sql="select * from marcacoes where data_inicio='$data_atual' and ativo=1 and confirmado=1";
    $result=runQ($sql,$db,"contar marcacoes");
    if($result->num_rows>=count($_SESSION['blocos_marcacoes'])){
        $disabled="disabled";
    }

    if(in_array($data_atual." 00:00:00",$_SESSION['cfg']['dias_bloqueados'])){
        $disabled="disabled";
    }

    $linhas.=$linha;
    $linhas=str_replace("_data_inicio_",date("d/m/Y",strtotime($data_atual)),$linhas);
    $linhas=str_replace("_val_",date("Y-m-d",strtotime($data_atual)),$linhas);
    $linhas=str_replace("_dia_da_semana_",dia_da_semana($data_atual),$linhas);
    $linhas=str_replace("_dia_",date("d",strtotime($data_atual)) ,$linhas);
    $linhas=str_replace("_disabled_",$disabled ,$linhas);



    $data_atual=date("Y-m-d",strtotime("+1 day",strtotime($data_atual)));

    if($mes_atual!=date("n",strtotime($data_atual))){
        $meses.="
        
        <div style='float:left;'>
            <h3>".$cfg_meses[date("n",strtotime($data_atual))-1]."</h3>
            <span class='calendario'>Seg</span>
            <span class='calendario'>Ter</span>
            <span class='calendario'>Qua</span>
            <span class='calendario'>Qui</span>
            <span class='calendario'>Sex</span>
            <span class='calendario'>Sáb</span>
            <span class='calendario'>Dom</span>
            $linhas
        </div>";
        $mes_atual=date("n",strtotime($data_atual));
        $linhas="";
    }
}
$layout=str_replace("_dias_",$meses,$layout);
/** FIM preencher os dias */
$db->close();
$content="";
include_once ("../../_footer.php");
include_once ("../../_autoData.php");
