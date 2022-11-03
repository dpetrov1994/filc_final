<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 26/03/2018
 * Time: 19:07
 */

$arrayUtilizadores = getInfoTabela('utilizadores', ' and ativo = 1', '', 'id_utilizador');

$grupoUtilizadores = getInfoTabela('grupos_utilizadores','', '', 'id_utilizador');




$sql_preencher="select * from srv_clientes where ativo=1 and srv_clientes.PartyID != '' order by OrganizationName asc";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {

    $ops.="<option class='id_cliente' value='".$row_preencher["id_cliente"]."'>".$row_preencher["OrganizationName"]."</option>";
}

$content=str_replace("_id_cliente_",$ops,$content);

// <!-- onchange="pesquisar_produtos(this);" onkeyup="pesquisar_produtos(this);" -->


$linha = '
<tr class="linha orcamentos-linha">
    <td class="text-center eliminar-linha-orcamento"><a onclick="removerLinha(this);calcular_totais();" href="javascript:void(0)" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a></td>
    <td><img src="_src_" class="linha-imagem" style="width: 150px;height: 150px;object-fit: contain"></td>
    <td><textarea name="nome_produto[]"  onkeyup="pesquisaprof(this)" class="form-control nome_produto"></textarea></td>
    <td><input name="quantidade[]" value="1" onkeyup="calcular_iva(this)" onchange="calcular_iva(this)" type="number" step="1" min="1" class="form-control quantidade"></td>
    <td><input name="preco_sem_iva[]" value="0" onkeyup="calcular_iva(this)" onchange="calcular_iva(this)" class="form-control preco_sem_iva"></td>
    <td>
        <select name="percentagem_iva[]" onkeyup="calcular_iva(this)" onchange="calcular_iva(this)" class="form-control percentagem_iva">
            <option class="percentagem_iva" value="23">23</option>
            <option class="percentagem_iva" value="0">0</option>
        </select>
    </td>
    <td>
         <input name="desconto[]" value="0" onkeyup="calcular_iva(this)" onchange="calcular_iva(this)" type="number" class="form-control desconto">
    </td>
   
    <td><input readonly class="form-control preco_sem_iva_com_desconto"></td>
    <td><input name="valor_iva[]" readonly class="form-control valor_iva"></td>
    <td><input name="valor_liquido[]" value="0" readonly class="form-control valor_liquido"></td>
</tr>';




$linhas="";
$tdforTable="";
if(!isset($row)){
    for($i=0;$i<1;$i++){
        $linhas.=$linha;
        $linhas=str_replace("_src_","../assets/layout/img/placeholder.png",$linhas);
    }
}else{
    $sql_preencher="select * from orcamentos_linhas where id_orcamento='$id' order by id_orcamento_linha asc";
    $result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
    while ($row_preencher = $result_preencher->fetch_assoc()) {

        $sql_preencher2="select * from produtos where ativo=1 and id_produto='".$row_preencher['id_produto']."'";
        $result_preencher2=runQ($sql_preencher2,$db,"datalist de produtos");
        while ($row_preencher2 = $result_preencher2->fetch_assoc()) {
            $foto="../_contents/produtos/".$row_preencher2['id_produto']."/".$row_preencher2['foto'];
            if(!is_file($foto)){
                $foto="../assets/layout/img/placeholder.png";
            }
        }
        $tmp=$linha;
        $tmp=str_replace('value="1"','',$tmp);
        $tmp=str_replace('value="0"','',$tmp);
        $tmp=str_replace('_src_',$foto,$tmp);
        $tmp=str_replace('nome_produto"></textarea>','nome_produto">'.$row_preencher['nome_produto'].'</textarea>',$tmp);
        foreach ($row_preencher as $key => $value){
            $tmp=str_replace('name="'.$key.'[]"','name="'.$key.'[]" value="'.$value.'"',$tmp);
        }
        $linhas.=$tmp;
    }
}
$content=str_replace("_linhas_",$linhas,$content);

$linha=str_replace("_src_","../assets/layout/img/placeholder.png",$linha);
$content=str_replace("_linha_",$linha,$content);

$sql_preencher="select * from produtos where ativo=1";
$result_preencher=runQ($sql_preencher,$db,"datalist de produtos");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {
    $ops .= '<option value="'.$row_preencher['nome_produto'].'">';
    $foto="../_contents/produtos/".$row_preencher['id_produto']."/".$row_preencher['foto'];
    if(!is_file($foto)){
        $foto="../assets/layout/img/placeholder.png";
    }
    $tdforTable.='<tr><td data-preco-sem-iva="'.$row_preencher['preco_sem_iva'].'" data-img="'.$foto.'" class="linha-produtos">'.$row_preencher['nome_produto'].'</td></tr>';
}
$layout=str_replace("_listaProdutos_",$ops,$layout);
$content = str_replace('_searchProdutos_', $tdforTable, $content);

//verificamos se tem espaço suficiente para fazer upload

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

if(isset($row)) {

        $galeria = get_galeria($nomeTabela, $id);
        $content = str_replace("_ficheiros_", $galeria, $content);


    if($row['conf_nomeproduto'] == "0"){
        $content=str_replace('checked name="conf_nomeproduto" id="conf_nomeproduto"','name="conf_nomeproduto" id="conf_nomeproduto"', $content);
    }

    if($row['conf_descricaoproduto'] == "0"){
        $content=str_replace('checked name="conf_descricaoproduto" id="conf_descricaoproduto"','name="conf_descricaoproduto" id="conf_descricaoproduto"', $content);
    }

    if($row['conf_fotoproduto'] == "0"){
        $content=str_replace('checked name="conf_fotoproduto" id="conf_fotoproduto"','name="conf_fotoproduto" id="conf_fotoproduto"', $content);
    }

}