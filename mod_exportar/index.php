<?php
include('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");

$tabelas=[];
$sql="show tables";
$result=runQ($sql,$db,0);
while($row = $result->fetch_assoc()) {
    foreach ($row as $key => $table){
        $table_name=$table;
        $table_name=str_replace("_"," ",$table_name);
        $table_name=strtoupper($table_name);
        $tabelas[$table]=$table_name;
    }
}
$ops="";
foreach ($tabelas as $tabela=>$table_name){
    $ops.="<option value='".$tabela."'>".$table_name."</option>";
}
$content=str_replace("_tabelas_",$ops,$content);

if(isset($_POST['importar'])){

    $tabela = $db->escape_string($_GET['mapear']);
    $delimitador = $db->escape_string($_GET['delimitador']);

    $coluna_da_tabela_para_update="";
    if($_POST['coluna_da_tabela_para_update']!='nao_atualizar'){
        $coluna_da_tabela_para_update=$db->escape_string($_POST['coluna_da_tabela_para_update']);
    }
    $coluna_do_csv_para_update=$db->escape_string($_POST['coluna_do_csv_para_update']);
    unset($_POST['coluna_da_tabela_para_update']);
    unset($_POST['coluna_do_csv_para_update']);
    unset($_POST['importar']);

    $tmp = "../.tmp/importar/".$_SESSION['id_utilizador'];
    $csv=file_get_contents($tmp."/"."$tabela.csv");
    $primeira_linha = strtok($csv, "\n");
    $colunas_csv=explode($delimitador,$primeira_linha);

    $mapa_colunas_csv=[];
    $sql_importar="";
    foreach ($_POST as $colunaCSV => $colunaTABELA){
        if($colunaTABELA=="nao_importar"){
            unset($_POST[$colunaCSV]);
        }else{
            foreach ($colunas_csv as $key => $value){
                if($value==$colunaCSV){
                    $mapa_colunas_csv[]=[
                        'colunaCSV'=>$db->escape_string($colunaCSV),
                        'colunaTABELA'=>$db->escape_string($colunaTABELA),
                        'coordNaLinha'=>$key,
                    ];
                }
            }

        }
    }


    $coordNaLinhaParaDarUpdate="none";
    foreach ($colunas_csv as $key => $value){
        if($key==$coluna_do_csv_para_update){
            $coordNaLinhaParaDarUpdate=$key;
        }
    }

    $handle = fopen($tmp."/".$tabela.".csv", "r");
    if ($handle) {
        $c=0;
        while (($line = fgets($handle)) !== false) {
            if($c>0){
                $line=explode($delimitador,$line);


                $update=0;
                if(is_int($coordNaLinhaParaDarUpdate) && $coluna_da_tabela_para_update!=""){
                    $val_update=$db->escape_string($line[$coordNaLinhaParaDarUpdate]);
                    if($val_update!=""){
                        $sql="select * from $tabela where $coluna_da_tabela_para_update='".$val_update."'";
                        $result=runQ($sql,$db,"ver se damos update");
                        if($result->num_rows==1){
                            $update=1;
                        }
                    }
                }

                if($update==1){
                    $colunas_e_valores = "";
                    foreach ($mapa_colunas_csv as $mapa) {
                        $valor = $db->escape_string($line[$mapa['coordNaLinha']]);
                        $valor=utf8_encode($valor);
                        $coluna=$mapa['colunaTABELA'];
                        $colunas_e_valores .= "$coluna='$valor',";
                    }
                    $colunas_e_valores = substr($colunas_e_valores, 0, -1);
                    $sql = "update $tabela set $colunas_e_valores where $coluna_da_tabela_para_update='$val_update'";
                }else{
                    $colunas="";
                    $valores="";
                    foreach ($mapa_colunas_csv as $mapa){
                        $valor=$db->escape_string($line[$mapa['coordNaLinha']]);
                        $valor=utf8_encode($valor);
                        $coluna=$mapa['colunaTABELA'];

                        $colunas.="$coluna,";
                        $valores.="'$valor',";
                    }
                    $colunas=substr($colunas, 0, -1);
                    $valores=substr($valores, 0, -1);

                    $sql="insert into $tabela ($colunas) values ($valores)";
                }

                $result=runQ($sql,$db,"exec insert/update [$sql]");

            }
            $c++;
        }
        fclose($handle);
        unlink($tmp."/".$tabela.".csv");
        header("location: index.php?cod=1");
        $db->close();
        die();
    } else {
        // error opening the file.
        header("location: index.php?cod=2&erro=Erro ao abrir o ficheiro");
        $db->close();
        die();
    }

    die();
}

if(isset($_GET['mapear'])) {
    $tabela = $db->escape_string($_GET['mapear']);
    $delimitador = $db->escape_string($_GET['delimitador']);

    $tmp = "../.tmp/importar/".$_SESSION['id_utilizador'];
    $csv=file_get_contents($tmp."/"."$tabela.csv");
    $primeira_linha = strtok($csv, "\n");

    $colunas_csv=explode($delimitador,$primeira_linha);

    $erro="";
    $exemplos=[];
    $handle = fopen($tmp."/".$tabela.".csv", "r");
    if ($handle) {
        $c=0;
        while (($line = fgets($handle)) !== false) {
            $line=explode($delimitador,$line);
            if(count($line)!=count($colunas_csv)){
                $erro="Existe uma ou mais linhas onde o numero de colunas não coincide com o cabeçalho.";
            }
            if($c==1){
                foreach ($line as $val){
                    $exemplos[]=$val;
                }
            }
            $c++;
        }

        fclose($handle);
    } else {
        // error opening the file.
        header("location: index.php?cod=2&erro=Erro ao abrir o ficheiro");
        $db->close();
        die();
    }

    if($erro!=""){
        header("location: index.php?cod=2&erro=$erro");
        $db->close();
        die();
    }else{
        $colunas_tabela=[];
        $sql="describe $tabela";
        $result=runQ($sql,$db,0);
        $ops="<option value='nao_importar'>Não importar</option>";
        $ops2="<option value='nao_atualizar'>Não atualizar registos</option>";
        while($row = $result->fetch_assoc()) {
            if($row['Key']!="PRI"){
                $ops.="<option value='".$row['Field']."'>".$row['Field']." - ".$row['Type']."</option>";
            }
            $ops2.="<option value='".$row['Field']."'>".$row['Field']." - ".$row['Type']."</option>";

        }


        $colunas_csv=explode($delimitador,$primeira_linha);

        $ops_colunas_csv="";
        foreach ($colunas_csv as $key=>$coluna_csv){
            $ops_colunas_csv.="<option value='$coluna_csv'>$coluna_csv</option>";
        }

        $mapear='<div class="form-group">
                    <h3 class="text-center" >Atualizar registos em vez de criar novos?</h3>
                    <small class="text-info">Selecione a a coluna do CSV e a coluna da tabela que tem de dar "Match" para o sistema atualizar o registo em vez de criar um novo.</small><br>
                    <label>Coluna da tabela</label>
                    <select name="coluna_da_tabela_para_update" class="form-control select-select2">
                        '.$ops2.'
                    </select>
                    <label>Coluna do csv</label>
                    <select name="coluna_do_csv_para_update" class="form-control select-select2">
                        '.$ops_colunas_csv.'
                    </select>
                </div>
                <h3 class="text-center">Mapeamento de colunas</h3>';

        foreach ($colunas_csv as $key=>$coluna_csv){
            $ops_tmp=$ops;

            if(!isset($exemplos[$key])){
                $exemplos[$key]="";
            }
            if($exemplos[$key]!=""){
                $ops_tmp=str_replace("value='".$coluna_csv."'","value='".$coluna_csv."' selected","$ops_tmp");
            }
            $mapear.='<div class="form-group">
                    <label class="" >'.$coluna_csv.'</label>
                    <select name="'.$coluna_csv.'" class="form-control select-select2">
                        '.$ops_tmp.'
                    </select>
                    <small class="text-info">'.$exemplos[$key].'</small>
                </div>';
        }

        $mapear.="<div class=\"form-group form-actions text-right\">
                        <button class=\"btn btn-success btn-effect-ripple\" type='submit' name='importar'>Executar importação</button><br>
                        <small class='text-danger'>Não é possível reverter esta operação</small>
                    </div>";

        $content=str_replace("_mapear_",$mapear,$content);

    }


    $content=str_replace("_rowExport_","hidden",$content);
    $content=str_replace("_rowMap_","",$content);
}else{
    $content=str_replace("_rowMap_","hidden",$content);
    $content=str_replace("_rowExport_","",$content);
}

if(isset($_FILES['file']['tmp_name']) && isset($_POST)) {

    $tabela = $db->escape_string($_POST['tabela']);
    $delimitador = $db->escape_string($_POST['delimitador']);

    $tmp = "../.tmp/importar/";
    if (!is_dir($tmp)) {
        mkdir($tmp);
    }
    $tmp .= $_SESSION['id_utilizador'];
    if (!is_dir($tmp)) {
        mkdir($tmp);
    }
    $tmp_loc = $_FILES['file']['tmp_name'];
    $file_name = $_FILES['file']['name'];
    $ext = explode(".", $file_name);
    $ext = $ext[1];

    if ($ext == "csv") {
        move_uploaded_file($_FILES['file']['tmp_name'], $tmp . "/" . "$tabela.csv");
        header("location: index.php?mapear=$tabela&delimitador=$delimitador");
        $db->close();
        die();
    } else {
        header("location: index.php?cod=2&erro=Formato de ficheiro inválido.");
        $db->close();
        die();
    }
}



$pageScript="";
include ('../_autoData.php');