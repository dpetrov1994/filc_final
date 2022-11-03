<?php
include('../_template.php');
include ".cfg.php";
$content=file_get_contents("detalhes.tpl");

if(isset($_GET['modal'])){
    $content=file_get_contents("detalhes_modal.tpl");
}

$content=str_replace("_idItem_",$id,$content);

if(!isset($_GET['id_ticket'])){
    $_GET['id_ticket']=0;
}
if(!isset($_SESSION['janelas_abertas'])){
    $_SESSION['janelas_abertas']=[];
}
if(!isset($_SESSION['janelas_abertas'][$_GET['id_ticket']])){
    $_SESSION['janelas_abertas'][$_GET['id_ticket']]=[];
}
if(!in_array($id,$_SESSION['janelas_abertas'][$_GET['id_ticket']])){
    $_SESSION['janelas_abertas'][$_GET['id_ticket']][]=$id;
}
$sql="select * from $nomeTabela where id_$nomeColuna='$id'";
$result=runQ($sql,$db,"VERIFICAR EXISTENTE");
if($result->num_rows!=0) {
    while ($row = $result->fetch_assoc()) {
        /**Preenchimento dos itens do formulário*/
        if ($row['lido'] == 0) {
            $sql2 = "update $nomeTabela set lido=1, id_utilizador_lido='" . $_SESSION['id_utilizador'] . "',data_lido='" . current_timestamp . "' where id_$nomeColuna='" . $row['id_' . $nomeColuna] . "'";
            $result2 = runQ($sql2, $db, "update lido");
        }
    }
}

$sql="select * from $nomeTabela where id_$nomeColuna='$id'";
$result=runQ($sql,$db,"VERIFICAR EXISTENTE");
if($result->num_rows!=0){
    while ($row = $result->fetch_assoc()) {/**Preenchimento dos itens do formulário*/

        include ("_criar_editar_detalhes.php");
        $row['top']=25;
        $row['right']=25;
        if(isset($_GET['id_ticket'])){
            foreach ($_SESSION['janelas_abertas'][$_GET['id_ticket']] as $id_janela){
                $row['top']+=50;
            }
        }

        $row['respostas']="";
        $assunto=strtolower($row['nome_imap']);
        $assunto=str_replace("re: ","",$assunto);
        $assunto=str_replace("re:","",$assunto);
        $sql2="select * from $nomeTabela where nome_imap like '%".$assunto."' and id_imap!='".$row['id_imap']."' order by data_email asc";
        $result2=runQ($sql2,$db,"VERIFICAR EXISTENTE");
        if($result2->num_rows!=0){
            while ($row2 = $result2->fetch_assoc()) {
                $enviado="<i data-toggle='tooltip' title='Recebido' class='text-info fa fa-arrow-down'></i>";
                if($row2['enviado']==1){
                    $enviado="<i data-toggle='tooltip' title='Enviado' class='text-success fa fa-arrow-up'></i>";
                }
                $row['respostas'].="
<tr>
<td style='width: 20px'>$enviado</td>
<td>
                <small class='text-muted'>".date("d/m/Y H:i",strtotime($row2['data_email'])).", ".humanTiming($row2['data_email'])." atrás</small><br>
                <small class='text-info'>".$row2['de_email']."</small>
                <br>
                <a href='detalhes.php?id=".$row2['id_imap']."'><h4 style='margin: 0px'><strong>".$row2['nome_imap']."</strong></h4></a>
                </td>
                </tr>";
            }
        }
        if($row['respostas']==""){
            $row['respostas']="_semResultados_";
        }else{
            $row['respostas']="<table class='table table-vcenter'><tbody>".$row['respostas']."</tbody></table>";
        }

        $cc=json_decode($row['cc'],true);
        if(!is_array($cc)){
            $cc=[];
        }
        $row['cc']="";
        foreach ($cc as $cc_email){
            $row['cc'].=" $cc_email,";
        }
        $row['cc']=substr($row['cc'], 0, -1);


        /**FIM Preenchimento dos itens do formulário*/
        $dados_t="";
        if($row['enviado']==1){
            if($row['tracking_info']!=""){
                $tracking_info=json_decode($row['tracking_info'],true);
                if(is_array($tracking_info)){


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
                }
            }
        }else{

            if($row['lido']==1){
                $nome_utilizador="";
                $data_lido=date("d/m/Y H:i",strtotime($row['data_lido']));
                $diff=humanTiming($row['data_lido']);
                $sql2="select * from utilizadores where id_utilizador='".$row['id_utilizador_lido']."'";
                $result2=runQ($sql2,$db,"utilizador que abriu o email");
                while ($row2 = $result2->fetch_assoc()) {
                    $nome_utilizador=$row2['nome_utilizador'];
                }

                $dados_t.="<small>$data_lido<br>$nome_utilizador</small><hr>";
            }

        }

        $row['lido']="$dados_t";


        $content=replaces_no_formulario($content,$row,$nomeTabela,$nomeColuna,$db);
    }




    /**Preenchimento dos itens do formulário*/

    //

    /**FIM Preenchimento dos itens do formulário*/

    if(!isset($_GET['modal'])){
        $pageScript='<script src="detalhes.js"></script>';
    }

}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod 2","Não foi encontrado nenhum registo com o ID:".$id,""));
}

if(!isset($_GET['modal'])){
    include ('../_autoData.php');
}else{

    print $content;


}

