<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 13/03/2018
 * Time: 00:05
 */

$tipos_inputs=[
    'input text' => '
            <div class="col-xs-6">
              <label class="col-lg-12">_label_</label>
              <div class="col-lg-12">
                  <input id="_nome_" name="_nome_" maxlength="250"  class="form-control" type="text">
              </div>
            </div>',
    'input data' => '
            <div class="col-xs-6">
                <label class="col-lg-12" >_label_</label>
                <div class="col-lg-12 input-status">
                    <input id="_nome_" name="_nome_" class="input-datepicker form-control">
                </div>
            </div>',
    'select' => '
            <div class="col-xs-6">
                <label class="col-lg-12" >_label_</label>
                <div class="col-lg-12 input-status">
                    <select id="_nome_" name="_nome_" class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                        <option></option>
                        __nome__
                    </select>
                </div>
            </div>',
    'textarea' => '
            <div class="col-xs-6">
                <label class="col-lg-12" >_label_</label>
                <div class="col-lg-12">
                    <textarea id="_nome_" name="_nome_" rows="10" class="form-control"></textarea>
                </div>
            </div>',
    'checkbox' => '
            <div class="col-xs-6">
                <div class="col-lg-12">
                    <label class="csscheckbox csscheckbox-primary">
                        _label_: 
                        <input type="hidden"   name="_nome_" value="0">
                        <input type="checkbox" name="_nome_" id="_nome_" value="1">
                        <span></span>
                    </label>
                </div>
            </div>',
    'checkbox switch' => '
            <div class="col-xs-6">
               <label>_label_</label><br>
               <label class="switch switch-primary">
                   <input type="hidden"   name="_nome_" value="0">
                   <input type="checkbox" name="_nome_" id="_nome_" value="1">
                   <span></span>
               </label>
            </div>',
    'file' =>              '
            <div class="col-xs-6">
                <label class="col-lg-12" >_label_</label>
                <div class="col-lg-12">
                    <input type="file" id="_nome_" name="_nome_">
                </div>
            </div>'
];

$novasColunas="";

$form='
            <div class="form-group form-group-sm">
                <div class="col-xs-12">
                    <label class="col-lg-12" >Nome </label>
                    <div class="col-lg-12 input-status">
                        <input id="nome__nomeColuna_" name="nome__nomeColuna_" maxlength="250"  class="form-control" placeholder=""  type="text">
                    </div>
                </div>
            </div>
';
$count=1;

$required="";

$autoPreencher="";

$regras="$('input[name*=nome__nomeColuna_]').rules('add', 'required');";
//gerar a query para criar a tabela
if(isset($_POST['gerarTabela_num'])){
    foreach ($_POST['gerarTabela_num'] as $num){
        $nome=$_POST["gerarTabela_nome_$num"][0];
        $tipo=$_POST["gerarTabela_tipo_$num"][0];
        $default=$_POST["gerarTabela_default_$num"][0];
        $mostraForm=$_POST["gerarTabela_form_$num"][0];
        $label=$_POST["gerarTabela_label_$num"][0];
        $input=$_POST["gerarTabela_input_$num"][0];
        $preencher_sql=$_POST["gerarTabela_sqlpreencher_$num"][0];
        $preencher_id=$_POST["gerarTabela_sqlid_$num"][0];
        $preencher_nome=$_POST["gerarTabela_sqlnome_$num"][0];

        $array_regras=array();
        if(isset($_POST["gerarTabela_regras_$num"])){
            $array_regras=$_POST["gerarTabela_regras_$num"];
        }

        if($nome!=""){
            $novasColunas.=" $nome $tipo DEFAULT $default, ";

            if($mostraForm=="SIM"){
                if($count<2){
                    $form.='<div class="form-group form-group-sm">';
                }

                $form.=$tipos_inputs[$input];
                $form=str_replace("_label_",$label,$form);
                $form=str_replace("_nome_",$nome,$form);

                if($count==2){
                    $form.="</div>";
                    $count=0;
                }
                $count++;

                foreach ($array_regras as $regra){
                    if($regra=="required"){
                        $required.="'$nome',";
                        $form=str_replace('name="'.$nome.'"','name="'.$nome.'" required',$form);
                    }
                    if($regra!=""){
                        $regras.="$('input[name*=$nome]').rules('add', '$regra');";
                    }
                }

                if($preencher_sql!=""){
                    $autoPreencher.='
                    $sql_preencher="'.$preencher_sql.'";
                    $result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
                    $ops="";
                    while ($row_preencher = $result_preencher->fetch_assoc()) {
                        $ops.="<option class=\''.$nome.'\' value=\'".$row_preencher["'.$preencher_id.'"]."\'>".$row_preencher["'.$preencher_nome.'"]."</option>";
                    }
                    $content=str_replace("_'.$nome.'_",$ops,$content);';
                }
            }
        }
    }
}

$form.='
<div class="form-group form-group-sm">
    <div class="col-xs-12">
        <label class="col-lg-12" >Observações </label>
        <div class="col-lg-12">
             <textarea id="descricao" rows="10" name="descricao" class="form-control">_descricao_</textarea>
        </div>
    </div>
</div>
';
$_subModulo=0;
if($_POST["subModulo"][0]=="sim"){
    $_subModulo=1;
}

$substituicoes=[
    '_form_'=>$form,
    '_regras_'=>$regras,
    '_autoPreencher_'=>$autoPreencher,
    '_novasColunas_'=>$novasColunas,
    '_required_'=>$required,
    '_subModulo_'=>$_subModulo,
    '_tabelaParent_'=>$_POST['tabelaParent'][0],
    '_colunaParent_'=>$_POST['colunaParent'][0],
    '_nomeTabela_'=>$_POST['nomeTabela'],
    '_nomeColuna_'=>$_POST['nomeColuna'],
    '_sqlInserirModulo_'=>$sqlInserirModulo
];

$dir="../".$_POST['url'];
mkdir($dir);
$ficheirosParaEditar=mostraFicheiros("../.modelo");

foreach ($ficheirosParaEditar as $ficheiro){
    $tmp=file_get_contents("../.modelo/$ficheiro");
    foreach ($substituicoes as $sub=>$val){
        $tmp=str_replace($sub,$val,$tmp);
    }
    $myfile = fopen("$dir/$ficheiro", "w") or die("Unable to open file!");
    fwrite($myfile, $tmp);
    fclose($myfile);
}

$sql=file_get_contents("$dir/.tabela.sql");
$result=runQ($sql,$db,"INSERT TABELA");
$sql=file_get_contents("$dir/.tabela_primary_key.sql");
$result=runQ($sql,$db,"primary_key TO TABELA");
$sql=file_get_contents("$dir/.tabela_ai.sql");
$result=runQ($sql,$db,"ADD AI TO TABELA");


$id_modulo=$insert_id;

$funcs=[
"insert into modulos_funcionalidades 
(id_modulo, so_em_reciclagem, icon, nome_funcionalidade, nome_em_reciclagem, descricao, url, principal, mostrar, confirmar, multiplos, mostrarDropdown, mostrar_subMenu, id_criou, created_at, ativo) 
values 
($id_modulo,'0','fa-list','Listar','','Apresentar registos.','index.php','0','1','0','0','0','0','".$_SESSION['id_utilizador']."','".current_timestamp."','1')",
"insert into modulos_funcionalidades 
(id_modulo, so_em_reciclagem, icon, nome_funcionalidade, nome_em_reciclagem, descricao, url, principal, mostrar, confirmar, multiplos, mostrarDropdown, mostrar_subMenu, id_criou, created_at, ativo) 
values 
($id_modulo,'0','fa-plus','Criar','','Adicionar novo registo.','criar.php','0','1','0','0','0','0','".$_SESSION['id_utilizador']."','".current_timestamp."','1')",
"insert into modulos_funcionalidades 
(id_modulo, so_em_reciclagem, icon, nome_funcionalidade, nome_em_reciclagem, descricao, url, principal, mostrar, confirmar, multiplos, mostrarDropdown, mostrar_subMenu, id_criou, created_at, ativo) 
values 
($id_modulo,'0','fa-edit','Editar','','Editar registo.','editar.php','0','0','0','0','1','1','".$_SESSION['id_utilizador']."','".current_timestamp."','1')",
"insert into modulos_funcionalidades 
(id_modulo, so_em_reciclagem, icon, nome_funcionalidade, nome_em_reciclagem, descricao, url, principal, mostrar, confirmar, multiplos, mostrarDropdown, mostrar_subMenu, id_criou, created_at, ativo) 
values 
($id_modulo,'0','fa-list-alt','Detalhes','','Consultar registo.','detalhes.php','0','0','0','0','1','1','".$_SESSION['id_utilizador']."','".current_timestamp."','1')",
"insert into modulos_funcionalidades 
(id_modulo, so_em_reciclagem, icon, nome_funcionalidade, nome_em_reciclagem, descricao, url, principal, mostrar, confirmar, multiplos, mostrarDropdown, mostrar_subMenu, id_criou, created_at, ativo) 
values 
($id_modulo,'0','fa-trash','Reciclagem','','Registos eliminados.','reciclagem.php','0','1','0','0','0','0','".$_SESSION['id_utilizador']."','".current_timestamp."','1')",
"insert into modulos_funcionalidades 
(id_modulo, so_em_reciclagem, icon, nome_funcionalidade, nome_em_reciclagem, descricao, url, principal, mostrar, confirmar, multiplos, mostrarDropdown, mostrar_subMenu, id_criou, created_at, ativo) 
values 
($id_modulo,'0','fa-trash-o','Reciclar','Restaurar','Recuperar da reciclagem.','reciclar.php','0','0','1','1','1','0','".$_SESSION['id_utilizador']."','".current_timestamp."','1')",
"insert into modulos_funcionalidades 
(id_modulo, so_em_reciclagem, icon, nome_funcionalidade, nome_em_reciclagem, descricao, url, principal, mostrar, confirmar, multiplos, mostrarDropdown, mostrar_subMenu, id_criou, created_at, ativo) 
values 
($id_modulo,'1','fa-times','Eliminar permanente','','Elimina permanentemente o registo.','eliminar_permanente.php','0','0','1','1','1','0','".$_SESSION['id_utilizador']."','".current_timestamp."','0')",
];

foreach ($funcs as $func){
    $result = runQ($func, $db, "INSERT FUNCIONALIDADES");
    $id_func=$db->insert_id;

    $sql="insert into grupos_modulos_funcionalidades (id_grupo, id_funcionalidade, id_modulo) values ('1','$id_func','$id_modulo')";
    $result = runQ($sql, $db, "INSERT PERMISSOES");
}

mkdir("$dir/.install");

copy("$dir/.tabela.sql","$dir/.install/.tabela.sql");
unlink("$dir/.tabela.sql");

copy("$dir/.tabela_primary_key.sql","$dir/.install/.tabela_primary_key.sql");
unlink("$dir/.tabela_primary_key.sql");

copy("$dir/.tabela_ai.sql","$dir/.install/.tabela_ai.sql");
unlink("$dir/.tabela_ai.sql");

copy("$dir/.install.php","$dir/.install/.install.php");
unlink("$dir/.install.php");

unset($_SESSION['modulos']);
