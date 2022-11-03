<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 26/03/2018
 * Time: 19:07
 */

$disco=espacoDisco($cfg_espacoDisco,$cfg_espacoReservadoSys);
$livre="sem dados";
foreach ($disco as $d){
    if($d['nome']=='Livre'){
        $livre=$d['tamanho'];
    }
}
if($livre<=0){
    $content=str_replace("_dropZone_","<h3>Espaço em disco insuficiente</h3>",$content);
}else{
    $content=str_replace("_dropZone_", '<form style="height: auto" action="_upload_media.php" id="myAwesomeDropzone" class="dropzone dz-clickable">
                                                    <i class="fa fa-cloud-upload"  ></i>
                                                </form>',$content);
}

$galeria = get_galeria($nomeTabela, $id);
$content = str_replace("_ficheiros_", $galeria, $content);

$de_email="";
$para_email="";
$cc=[];
$assunto_resposta="";
$texto_resposta="";
$controlo_ticket="";
if(isset($_GET['id_reponder_para'])){
    $id_responder_para=$db->escape_string($_GET['id_reponder_para']);
    $sql_preencher="select * from $nomeTabela where id_imap='$id_responder_para'";
    $result_preencher=runQ($sql_preencher,$db,"obter email para responder");
    $ops="";
    while ($row_preencher = $result_preencher->fetch_assoc()) {
        $texto_resposta="<br><br>".$_SESSION['nome_utilizador']."<br><div style='padding-left:10px;margin-left:10px;border-left:1px solid gray'>".$row_preencher['descricao']."</div>";
        if($row_preencher['enviado']==1){
            $de_email=$row_preencher['de_email'];
            $para_email=$row_preencher['para_email'];
        }else{
            $de_email=$row_preencher['para_email'];
            $para_email=$row_preencher['de_email'];
        }

        $cc=json_decode($row_preencher['cc'],true);
        if(!is_array($cc)){
            $cc=[];
        }
        $assunto_resposta="Re: ".$row_preencher['nome_imap'];
    }

    if(isset($_GET['id_ticket']) && $_GET['id_ticket']!=0){
        if($assunto_resposta==""){
            $id_ticket=$db->escape_string($_GET['id_ticket']);
            $sql2="select * from tickets where id_ticket='$id_ticket' ";
            $result2=runQ($sql2,$db,"ir buscar o assunto do ticket");
            while ($row2 = $result2->fetch_assoc()) {
                $assunto_resposta=$row2['nome_ticket'];
            }
        }


        $content=str_replace("criar.php_addUrl_","../mod_imap/criar.php?goTo=../mod_tickets/detalhes.php?id=".$_GET['id_ticket']."&id_ticket=".$_GET['id_ticket'],$content);
        $texto_resposta="";
        $controlo_ticket=' <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <h4 class="text-center">Controlo do Assunto/Ticket</h4>
                    </div>
                    <div class="col-xs-6">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Definir espera</label>
                        <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                            <label class="csscheckbox csscheckbox-primary">
                                <input name="nosso_lado" value="1" type="hidden">
                                <input name="nosso_lado" value="0" type="checkbox" checked>
                                <span></span> Espera de Cliente
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Enviar com introdução e despedida de "Aurora"</label>
                        <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                            <label class="csscheckbox csscheckbox-primary">
                                <input name="aurora" value="0" type="hidden">
                                <input name="aurora" value="1" type="checkbox" checked>
                                <span></span> Sim
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                ';
    }
}
$content=str_replace("_descricaoResposta_",$texto_resposta,$content);
$content=str_replace("_controloTicket_",$controlo_ticket,$content);

$sql_preencher="select * from _conf_imap where ativo=1";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {
    $selected="";
    if(decryptData($row_preencher["utilizador"])==$de_email){
        $selected="selected";
    }
    $ops.="<option $selected class='id_conf' value='".$row_preencher["id_conf"]."'>".$row_preencher["nome_conf"]."</option>";
}
$content=str_replace("_id_conf_",$ops,$content);


$sql2="select para_email, para_nome from $nomeTabela where ativo=1 group by para_email";
$result2=runQ($sql2,$db,"VERIFICAR EXISTENTE");
$ops="";
while ($row2 = $result2->fetch_assoc()) {
    $selected="";
    if($row2["para_email"]==$para_email){
        $selected="selected";
    }
    $ops.="<option $selected value='".$row2['para_email']."'>".$row2['para_nome']." [".$row2['para_email']."]</option>";
}
$content=str_replace("_paraEmail_",$ops,$content);

$sql2="select para_email, para_nome from $nomeTabela where ativo=1 group by para_email";
$result2=runQ($sql2,$db,"VERIFICAR EXISTENTE");
$ops="";
while ($row2 = $result2->fetch_assoc()) {
    $selected="";
    if(in_array($row2['para_email'],$cc)){
        $selected="selected";
    }
    $ops.="<option $selected value='".$row2['para_email']."'>".$row2['para_nome']." [".$row2['para_email']."]</option>";
}
$content=str_replace("_ccEnviar_",$ops,$content);