<?php
include('../_template.php');
include ".cfg.php";
$content=file_get_contents("detalhes.tpl");

$content=str_replace("_idItem_",$id,$content);




if(isset($_GET['recalcular'])){

    recalcularHorasContrato($id);

    $db->close();
    header("location: detalhes.php?id=$id&cod=1");
    die();
}

$sql="select * from $nomeTabela where id_$nomeColuna='$id'";
$result=runQ($sql,$db,"VERIFICAR EXISTENTE");
if($result->num_rows!=0){
    while ($row = $result->fetch_assoc()) {/**Preenchimento dos itens do formulário*/

        include ("_criar_editar_detalhes.php");

        /**FIM Preenchimento dos itens do formulário*/

        $row['tempo']=secondsToTime($row['segundos_restantes']);
        $content=replaces_no_formulario($content,$row,$nomeTabela,$nomeColuna,$db);
        $id_cliente=$row['id_cliente'];
        $id_contrato=$row['id_contrato'];
    }

    $adicionar_movimento=file_get_contents("../mod_clientes_contratos_carregamentos/criar.tpl");
    $adicionar_movimento=str_replace("_esconderDoForm_","hidden",$adicionar_movimento);
    $adicionar_movimento=str_replace("_descricao_","",$adicionar_movimento);
    $adicionar_movimento=str_replace("criar.php_addUrl_","../../mod_clientes_contratos_carregamentos/criar.php?goTo=../mod_clientes_contratos/detalhes.php?id=$id",$adicionar_movimento);

    $content=str_replace("_adicionarMovimento_",$adicionar_movimento,$content);
    $content=str_replace("_esconderDoForm_","hidden",$content);
    $content=str_replace("_descricao_","hidden",$content);
    include ("../mod_clientes_contratos_carregamentos/_criar_editar_detalhes.php");


    /**Preenchimento dos itens do formulário*/

    $carregamentos="";
    $sql="select * from clientes_contratos_carregamentos where id_contrato='$id' and ativo=1 order by id_carregamento desc";
    $result=runQ($sql,$db,"historico de carregamentos");
    $content=str_replace("_movimentos_",$result->num_rows,$content);
    if($result->num_rows!=0) {
        $linhas="";


        while ($row = $result->fetch_assoc()) {
            $row['nome_utilizador']="Aurora";
            $sql2="select * from utilizadores where id_utilizador='".$row['id_criou']."'";
            $result2=runQ($sql2,$db,"nome do user");
            while ($row2 = $result2->fetch_assoc()) {
                $row['nome_utilizador']=$row2['nome_utilizador'];
            }
            $balanco_atual=$row['balanco_anterior']+($row['segundos']);

            $cor="text-success";
            if($row['segundos']<0){
                $cor="text-danger";
            }

            $pendente="";
            if($row['validado']==0){
                if($_SESSION['tecnico']==0){
                    $pendente="<a href='javascript:void(0)' class='aprovar-carregamento-".$row['id_carregamento']."' onclick='aprovarMovimento(".$row['id_carregamento'].")'><small class=''><i class='fa fa-warning text-warning'></i> Pendente</small></a>";
                }else{
                    $pendente="<a href='javascript:void(0)' class='aprovar-carregamento-".$row['id_carregamento']."' ><small class=''><i class='fa fa-warning text-warning'></i> Pendente</small></a>";
                }
            }

            $linhas.="
<tr>
    <td>
        <small class='text-muted'><i class='fa fa-user'></i>".$row['nome_utilizador']."</small><br>
        ".date("d/m/Y H:i",strtotime($row['created_at']))."<br>
        $pendente
    </td>
    <td>".$row['nome_carregamento']."<br><small class='text-muted'>".$row['descricao']."</small></td>
    <td class='text-right $cor'><b>".secondsToTime($row['segundos'])."</b></td>
    <td class='text-right'>".secondsToTime($balanco_atual)."<br><small class='text-muted'>".secondsToTime($row['balanco_anterior'])."</small></td>
</tr>";
        }
        $carregamentos="<table class='table table-vcenter'>
<thead>
<tr>
    <th>Data</th>
    <th>Descrição</th>
    <th class='text-right'>Ação</th>
    <th class='text-right'>Balanço</th>
</tr>
</thead>
<tbody>$linhas</tbody>
</table>";
    }else{
        $carregamentos="_semResultados_";
    }
    $content=str_replace("_carregamentos_",$carregamentos,$content);

    /**FIM Preenchimento dos itens do formulário*/


    $pageScript='<script src="detalhes.js"></script>';
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod 2","Não foi encontrado nenhum registo com o ID:".$id,""));
}
include ('../_autoData.php');