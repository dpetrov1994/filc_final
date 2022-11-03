<?php
include('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");

/**  FILTROS ADICIONAIS */

$data_inicio="";
$data_fim="";
if((isset($_GET['data_inicio']) and isset($_GET['data_fim'])) and ($_GET['data_inicio']!="" and  $_GET['data_fim']!="")){
    $data_inicio=($_GET['data_inicio']);
    $data_fim=($_GET['data_fim']);

    $data_inicio_sql=data_portuguesa($_GET['data_inicio']);
    $data_fim_sql=data_portuguesa($_GET['data_fim']);
    $add_sql.=" and (created_at>='$data_inicio_sql 00:00:00' and created_at<='$data_fim_sql 23:59:59') ";
}
$content=str_replace("_data_inicio_",$data_inicio,$content);
$content=str_replace("_data_fim_",$data_fim,$content);

$lido="Todos";
if(isset($_GET['lido']) && $_GET['lido']!="todos"){
    $lido=$db->escape_string($_GET['lido']);
    $add_sql.=" and lido='$lido' ";
}
$estado_lido=[
    "0"=>"Não Lido",
    "1"=>"Lido"
];
$ops="";
foreach ($estado_lido as $key=>$val){
    $selected="";
    if($lido!="Todos"){
        if($key==$lido){
            $selected='selected';
        }
    }
    $ops.="<option $selected value='".$key."'>".$val."</option>";
}
$content=str_replace("_lido_",$ops,$content);


$de_email="Todos";
if(isset($_GET['de_email']) && $_GET['de_email']!="todos"){
    $de_email=$db->escape_string($_GET['de_email']);
    $add_sql.=" and de_email='$de_email' ";
}

$sql="select de_email, de_nome from $nomeTabela group by de_email";
$result=runQ($sql,$db,"VERIFICAR EXISTENTE");
$ops="";
while ($row = $result->fetch_assoc()) {
    $selected="";
    if($de_email!="Todos"){
        if($row['de_email']==$de_email){
            $selected='selected';
        }
    }
    $ops.="<option $selected value='".$row['de_email']."'>".$row['de_nome']." ".$row['de_email']."</option>";
}
$content=str_replace("_deEmail_",$ops,$content);


$para_email="Todos";
if(isset($_GET['para_email']) && $_GET['para_email']!="todos"){
    $para_email=$db->escape_string($_GET['para_email']);
    $add_sql.=" and para_email='$para_email' ";
}

$sql="select para_email, para_nome from $nomeTabela group by para_email";
$result=runQ($sql,$db,"VERIFICAR EXISTENTE");
$ops="";
while ($row = $result->fetch_assoc()) {
    $selected="";
    if($para_email!="Todos"){
        if($row['para_email']==$para_email){
            $selected='selected';
        }
    }
    $ops.="<option $selected value='".$row['para_email']."'>".$row['para_nome']." ".$row['para_email']."</option>";
}
$content=str_replace("_paraEmail_",$ops,$content);


/** fFIM FILTROS ADICIONAIS */

include ("../_igualEmTodasTabelas.php");
$tr=0;
$sql="SELECT count(".$nomeTabela.".id_".$nomeColuna.") FROM ".$nomeTabela." $innerjoin WHERE 1 $add_sql";
$result=runQ($sql,$db,"CONTAR RESULTADOS");
while ($row = $result->fetch_assoc()) {
    $tr=$row['count('.$nomeTabela.'.id_'.$nomeColuna.')']; // total rows
}
if($tr>0){
    include "../_paginacao.php";

    if($subModulo==0){
        include "../_funcionalidades.php";
    }else{
        include "../_funcionalidadesSubModulos.php";
    }

    $tbody="";

    $add_sql=str_replace("order by"," group by $nomeTabela.id_$nomeColuna order by",$add_sql);
    if(!isset($_GET['excel'])){$add_sql.=" LIMIT ".(($pn-1)*$pr)." , $pr";}
    $sql="SELECT * FROM $nomeTabela $innerjoin  WHERE 1 $add_sql";
    $result=runQ($sql,$db,"LOOP PELOS RESULTADOS");
    while ($row = $result->fetch_assoc()) {
        //$tbody.=$linhaTD; -> movido para baixo

        /**colunas personalizadas **/

        if($row['spam']==1){
            $row['spam']="<i data-toggle='tooltip' title='SPAM' class='text-danger fa fa-minus-circle'></i>";
        }else{
            $row['spam']="";
        }

        if($row['de_nome']!=""){
            $row['de_nome'].="<br>";
        }
        if($row['para_nome']!=""){
            $row['para_nome'].="<br>";
        }


        if($row['data_email']!="0000-00-00 00:00:00"){
            $data_email=date("d/m/Y H:i",strtotime($row['data_email']));
            $data_raw=$row['data_email'];
        }else{
            $data_email=date("d/m/Y H:i",strtotime($row['created_at']));
            $data_raw=$row['created_at'];
        }

        $diff=humanTiming($data_raw);



        $row['nome_imap']="<small class='text-muted'>".$data_email." - $diff atrás</small><h4 style='margin-top: 0px'><strong><a href='detalhes.php?id=".$row['id_imap']."'>".$row['nome_imap']."</a></strong></h4>";

        $row['descricao']=strip_tags($row['descricao']);
        $row['descricao']=cortaStr($row['descricao'],300);
        $row['descricao']="<small class='text-muted'>".$row['descricao']."</small>";


        if($row['com_anexos']==1){
            $row['com_anexos']="<i class='fa fa-paperclip'></i>";
        }else{
            $row['com_anexos']="";
        }

        if($row['estado']!=0){
            $row['estado']="<i class='fa fa-times text-danger' data-toggle='tooltip' title='".$row['estado']."'></i>";
        }else{
            $row['estado']="<i class='fa fa-check text-success' data-toggle='tooltip' title='Entregue'></i>";
        }


        if($row['enviado']==1){
            $row['enviado']="<i data-toggle='tooltip' title='Enviado' class='text-muted fa fa-arrow-up'></i>";
            $row['tdLabel']="td-label-warning";
            $row['lido']="<a href='javascript:void(0)' data-toggle='popover' data-placement='left' data-html='true' data-trigger='click' data-content='"."'><i class='fa fa-envelope-o'></i></a>";
            if($row['tracking_info']!=""){
                $tracking_info=json_decode($row['tracking_info'],true);
                if(is_array($tracking_info)){
                    $row['tdLabel']="td-label-default";
                    $dados_t="";
                    foreach ($tracking_info as $t){



                        if (strpos($row['para_email'], '@gmail.com') !== false || ($t['device']['os']=="Windows XP" && $t['device']['browser']=='Firefox 11.0')) {
                            $dados_t.="
                            <small>
                            Data: <b>".date("d/m/Y H:i",strtotime($t['date']))."</b><br>
                            Dispositivo: <b>Gmail Server</b><br>
                            </small>
                            <hr>
                            ";
                        }else{
                            $dados_t.="
                            <small>
                            Data: <b>".date("d/m/Y H:i",strtotime($t['date']))."</b><br>
                            Dispositivo: <b>".$t['device']['deviceType']."</b><br>
                            OS: <b>".$t['device']['os']."</b><br>
                            Browser: <b>".$t['device']['browser']."</b><br>
                            IP: <b>".$t['ip']."</b>
                            </small>
                            <hr>
                            
                            ";
                        }


                    }

                    $row['lido']="<a href='javascript:void(0)' data-toggle='popover' data-placement='bottom' data-html='true' data-trigger='click' data-content='<div class=\"text-center\">Aberto ".count($tracking_info)."x<hr> </div>".$dados_t."' class=''><i class='fa fa-envelope-open-o'></i></a>";

                }
            }
        }else{

            if($row['lido']==1){
                $row['tdLabel']="td-label-default";
                $nome_utilizador="";
                $data_lido=date("d/m/Y H:i",strtotime($row['data_lido']));
                $diff=humanTiming($row['data_lido']);
                $sql2="select * from utilizadores where id_utilizador='".$row['id_utilizador_lido']."'";
                $result2=runQ($sql2,$db,"utilizador que abriu o email");
                while ($row2 = $result2->fetch_assoc()) {
                    $nome_utilizador=$row2['nome_utilizador'];
                }
                $row['lido']="<a href='javascript:void(0)' data-toggle='popover' data-placement='left' data-html='true' data-trigger='click' data-content='".$data_lido."<br>".$nome_utilizador."'><i class='fa fa-envelope-open-o'></i></a>";
            }else{
                $row['tdLabel']="td-label-success";
                $row['lido']="<a href='javascript:void(0)' data-toggle='popover' data-placement='left' data-html='true' data-trigger='click' data-content='"."'><i class='fa fa-envelope-o'></i></a>";
            }

            $row['enviado']="<i data-toggle='tooltip' title='Recebido' class='text-info fa fa-arrow-down'></i>";

        }



        /** FIM colunas personalizadas**/

        $linhaTmp=$linhaTD;
        $linhaTmp=rules_for_rows($rules_for_rows,$row,$linhaTmp,$linkDasTabelas);

        foreach ($row as $coluna=>$valor){
            $linhaTmp=str_replace("_".$coluna."_",$valor,$linhaTmp);
        }

        $linhaTmp=str_replace("_funcionalidades_",$funcionalidades,$linhaTmp);
        if($subModulo==0){
            $linhaTmp=str_replace("_idItem_",$row['id_'.$nomeColuna],$linhaTmp);
        }else{
            $linhaTmp=str_replace("_subItemID_",$row['id_'.$nomeColuna],$linhaTmp);
            $linhaTmp=str_replace("_idItem_",$idParent,$linhaTmp);
        }

        $tbody.=$linhaTmp;
    }

    if($subModulo==0){
        $content=str_replace("_id_",$id,$content);
    }else{
        $content=str_replace("_id_",$idParent,$content);
    }

    $resultados=str_replace("_tbody_",$tbody,$tplTabela);

    if(isset($_GET['excel'])){
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Content-Disposition: attachment; filename=".$nomeTabela."_".time().".xls");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        $tempalte_excel=str_replace('_resultados_',$resultados,$tempalte_excel);
        print $tempalte_excel;
        die();
    }
}else{
    $resultados="_semResultados_";
}
$pageScript="";
include ('../_autoData.php');