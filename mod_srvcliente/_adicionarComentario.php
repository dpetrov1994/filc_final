<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");

$id=$db->escape_string($_GET['idCliente']);
$descricao = $db->escape_string($_GET['descricao']);

$sql ="insert into srv_clientes_notas (FederalTaxID,descricao,cor,id_criou,created_at,mostrar_funcionarios,notificar_administradores,comentario) values ('$id','$descricao','#FEFF9C',".$_SESSION['id_utilizador'].",'".current_timestamp."','','','1')";
$result=runQ($sql,$db,2);
$idNota = $db->insert_id;


$data_atual = new DateTime('now', new DateTimeZone('Europe/Lisbon'));
$data=$data_atual->format('Y-m-d H:i');

$btnDelete="";
if(in_array(1,$_SESSION['grupos']) || in_array(2,$_SESSION['grupos'])){
   $btnDelete = '  <span class="save-delete-nota">
                           <!-- <a href="#" onclick="editarComentario(' .$idNota . ', this)" class="btn"><i class="fa fa-save" ></i></a>-->
                         <a href="#" onclick=\'confirmaModal("../mod_notas/reciclar.php?id=' .$idNota . '")\' class="btn"><i class="fa fa-trash"></i></a>
                       </span>  ';
}

$comentario='
            <div class="col-lg-12 comentario-row">
                <span class="foto-utilizador"><img src="../_contents/fotos_utilizadores/'.$_SESSION['foto'].'" alt="'.$_SESSION['foto'].'"></span>
               <div style="word-break: break-all;">
                  <div>
                       <span class="nome-utilizador"><b>'.$_SESSION['nome_utilizador'].'</b> <label class="text-muted" style="font-size: 11px">('.$data.')</label></span>
                        '.$btnDelete.'
                    </div>
                   <p class="text-muted">'. nl2br($_GET['descricao']).'</p>
                </div>
                
            </div>';

/*
$comentario='
        <div class="col-lg-12 nota-editavel">
                <span  style="font-size: 12px">Criado por: '.$_SESSION['nome_utilizador'].' </span> 
                <span style="font-size: 12px">('.current_timestamp.')</span>
                 <span class="save-delete-nota">
                    <a href="#" onclick="editarComentario('.$idNota.', this)" class="btn"><i class="fa fa-save text-info"></i></a>
                    <a href="#" onclick=\'confirmaModal("../mod_notas/reciclar.php?id='.$idNota.'")\' class="btn"><i class="fa fa-trash text-danger"></i></a>
                </span>
                
                <textarea class="form form-control input-for-nota-editavel" style="border-color: green">'.$descricao.'</textarea>
               
        </div>';*/

/*
$nota=$tpl_nota;
$nota=str_replace("_id_nota_",$idNota,$nota);
$nota=str_replace("_nota_",$descricao,$nota);
$nota=str_replace('id="mostrarfuncionariosnota'.$idNota.'"','id="mostrarfuncionariosnota'.$idNota.'" checked="checked"',$nota);

$notas=str_replace("_cor_",'#FEFF9C',$notas);
$nota=str_replace("_dataCriado_",date("d/m/Y H:s",strtotime(current_timestamp)),$nota);
$nota=str_replace("_nomeCriou_",$_SESSION['nome_utilizador'],$nota);

$array=['notas' => $nota, 'comentario'=>$comentario]; */

print $comentario;

$db->close();