<?php
include ('../_template.php');
$content=file_get_contents("index.tpl");

$id=1;
$sql="select * from _conf_cliente where id_conf='$id' ";
$result=runQ($sql,$db,1);
if($result->num_rows!=0){
    while ($row = $result->fetch_assoc()) {
        $content=str_replace("_nomeEmpresa_",$row['nome_empresa'],$content);
        $content=str_replace("_nomePlataforma_",$row['nome_plataforma'],$content);
        $content=str_replace("_url_",$row['site_empresa'],$content);
        $content=str_replace("_telemovel_",$row['telemovel'],$content);
        $content=str_replace("_telefone_",$row['telefone'],$content);
        $content=str_replace("_fax_",$row['fax'],$content);
        $content=str_replace("_morada_",$row['morada'],$content);
        $content=str_replace("_nif_",$row['nif'],$content);
        $content=str_replace("_nib_",$row['nib'],$content);
        $content=str_replace("_cor_",$row['cor'],$content);
        $content=str_replace("_email_",$row['email'],$content);

        $content=str_replace("_paragrafo1_",$row['paragrafo1'],$content);
        $content=str_replace("_apresentacao_",$row['apresentacao'],$content);
        $content=str_replace("_deveres_",$row['deveres'],$content);
        $content=str_replace("_antes_",$row['antes'],$content);
        $content=str_replace("_depois_",$row['depois'],$content);
        $content=str_replace("_ultimo_",$row['ultimo'],$content);

        $content=str_replace("_idParent_",$row['id_conf'],$content);
        $logo_cabecalho=$row['logo_cabecalho'];
        $logo_rodape=$row['logo_rodape'];
        $content=str_replace("_logo_cabecalho_",$logo_cabecalho,$content);
        $content=str_replace("_logo_rodape_",$logo_rodape,$content);
    }

    if (isset($_POST['submit'])) {
        $erros=0;
        $erro="";

        $storeFolder = "../.tmp/".$_SESSION['id_utilizador'];
        if(!is_dir($storeFolder)){
            mkdir($storeFolder);
        }


        $dir="../_contents";
        if(!is_dir($dir)){
            mkdir($dir);
        }
        $dir.="/config_cliente";
        if(!is_dir($dir)){
            mkdir($dir);
        }

        $novo_logo_cabecalho=$logo_cabecalho;
        if (!empty($_FILES) && isset($_FILES['logo_cabecalho']['tmp_name']) && $_FILES['logo_cabecalho']['tmp_name']!="") {
            $fileSize = $_FILES["logo_cabecalho"]["size"];
            if($fileSize<($cfg_tamanhoMaxUpload*1000*100)) {
                $ds = DIRECTORY_SEPARATOR;
                if (!is_dir($storeFolder)) {
                    mkdir($storeFolder);
                }
                $tempFile = $_FILES['logo_cabecalho']['tmp_name'];          //3
                $targetPath = dirname(__FILE__) . $ds . $storeFolder . $ds;  //4
                $fileName=normalizeString(tirarAcentos($_FILES['logo_cabecalho']['name']));
                $novo_logo_cabecalho=$fileName;
                $targetFile = $targetPath . $fileName;  //5
                if(move_uploaded_file($tempFile, $targetFile)){
                    if(is_image($targetFile)){
                        $dadosImagem=getimagesize($targetFile);
                        $w=$dadosImagem[0];
                        $h=$dadosImagem[1];

                        $max_w=1920;
                        $max_h=1080;

                        if( ($w>$max_w || $w==$max_w)  || ($h>$max_h || $h==$max_h)){
                            $ext=explode(".",$targetFile);
                            $ext=end($ext);
                            if($ext=='png'){
                                resizeTransparent("$targetFile","$targetFile",$max_w,$max_h);
                            }else{
                                img_resize("$targetFile","$targetFile",$max_w,$max_h,$ext);
                            }
                        }

                        unlink("$dir/$logo_cabecalho");

                    }else{
                        $erros.=" O fichiero não é uma imagem ";
                        unlink($targetFile);
                    }
                    @unlink($tempFile);
                }
            }else{
                $erros.=" Tamanho do ficheiro tem de ser inferior a $cfg_tamanhoMaxUpload MB";
            }
        }

        $novo_logo_rodape=$logo_rodape;
        if (!empty($_FILES) && isset($_FILES['logo_rodape']['tmp_name']) && $_FILES['logo_rodape']['tmp_name']!="") {
            $fileSize = $_FILES["logo_rodape"]["size"];
            if($fileSize<($cfg_tamanhoMaxUpload*1000*100)) {
                $ds = DIRECTORY_SEPARATOR;

                if (!is_dir($storeFolder)) {
                    mkdir($storeFolder);
                }
                $tempFile = $_FILES['logo_rodape']['tmp_name'];          //3
                $targetPath = dirname(__FILE__) . $ds . $storeFolder . $ds;  //4
                $fileName=normalizeString(tirarAcentos($_FILES['logo_rodape']['name']));
                $novo_logo_rodape=$fileName;
                $targetFile = $targetPath . $fileName;  //5
                if(move_uploaded_file($tempFile, $targetFile)){
                    if(is_image($targetFile)){
                        $dadosImagem=getimagesize($targetFile);
                        $w=$dadosImagem[0];
                        $h=$dadosImagem[1];

                        $max_w=1920;
                        $max_h=1080;

                        if( ($w>$max_w || $w==$max_w)  || ($h>$max_h || $h==$max_h)){
                            $ext=explode(".",$targetFile);
                            $ext=end($ext);
                            if($ext=='png'){
                                resizeTransparent("$targetFile","$targetFile",$max_w,$max_h);
                            }else{
                                img_resize("$targetFile","$targetFile",$max_w,$max_h,$ext);
                            }
                        }

                        unlink("$dir/$logo_rodape");

                    }else{
                        $erros.=" O fichiero não é uma imagem ";
                        unlink($targetFile);
                    }
                    @unlink($tempFile);
                }
            }else{
                $erros.=" Tamanho do ficheiro tem de ser inferior a $cfg_tamanhoMaxUpload MB";
            }
        }



        $nome_empresa="";
        if(isset($_POST['nome_empresa'])){
            $nome_empresa=$db->escape_string($_POST['nome_empresa']);
        }else{
            $erro.=" NOME EMPRESA -";
            $erros++;
        }
        $cor="";
        if(isset($_POST['cor'])){
            $cor=$db->escape_string($_POST['cor']);
        }else{
            $erro.=" COR -";
            $erros++;
        }

        if(isset($_POST['nome_plataforma']) && $_POST['nome_plataforma']!=""){
            $nome_plataforma=$db->escape_string($_POST['nome_plataforma']);
        }else{
            $erro.=" NOME PLATAFORMA -";
            $erros++;
        }

        $url="";
        if(isset($_POST['url'])){
            $url=$db->escape_string($_POST['url']);
        }
        $morada="";
        if(isset($_POST['morada'])){
            $morada=$db->escape_string($_POST['morada']);
        }
        $email="";
        if(isset($_POST['email'])){
            $email=$db->escape_string($_POST['email']);
        }
        $telemovel="";
        if(isset($_POST['telemovel'])){
            $telemovel=$db->escape_string($_POST['telemovel']);
        }
        $telefone="";
        if(isset($_POST['telefone'])){
            $telefone=$db->escape_string($_POST['telefone']);
        }
        $fax="";
        if(isset($_POST['fax'])){
            $fax=$db->escape_string($_POST['fax']);
        }
        $nif="";
        if(isset($_POST['nif'])){
            $nif=$db->escape_string($_POST['nif']);
        }
        $nib="";
        if(isset($_POST['nib'])){
            $nib=$db->escape_string($_POST['nib']);
        }


        $paragrafo1="";
        if(isset($_POST['paragrafo1'])){
            $paragrafo1=$db->escape_string($_POST['paragrafo1']);
        }
        $apresentacao="";
        if(isset($_POST['apresentacao'])){
            $apresentacao=$db->escape_string($_POST['apresentacao']);
        }
        $deveres="";
        if(isset($_POST['deveres'])){
            $deveres=$db->escape_string($_POST['deveres']);
        }
        $antes="";
        if(isset($_POST['antes'])){
            $antes=$db->escape_string($_POST['antes']);
        }
        $depois="";
        if(isset($_POST['depois'])){
            $depois=$db->escape_string($_POST['depois']);
        }
        $ultimo="";
        if(isset($_POST['ultimo'])){
            $ultimo=$db->escape_string($_POST['ultimo']);
        }

        if ($erros == 0) {
            $sql="update _conf_cliente set 
                nome_empresa='$nome_empresa', 
                nome_plataforma='$nome_plataforma', 
                site_empresa='$url', 
                morada='$morada', 
                telemovel='$email', 
                telefone='$telefone', 
                fax='$fax', 
                email='$email', 
                nif='$nif', 
                nib='$nib',
                cor='$cor',
                logo_cabecalho='$novo_logo_cabecalho',
                logo_rodape='$novo_logo_rodape',
                paragrafo1='$paragrafo1',
                apresentacao='$apresentacao',
                deveres='$deveres',
                antes='$antes',
                depois='$depois',
                ultimo='$ultimo'
                where id_conf=$id";
            $result=runQ($sql,$db,4);

            moverFicheiros($storeFolder,$dir);

            $_SESSION['cfg']['nomeEmpresa']=$nome_empresa;
            criar_watermark_png("../assets/layout/img/marcadeagua.png");

            $sql="select * from _conf_cliente where id_conf = $id";
            $result = runQ($sql, $db, "SELECT UPDATED");
            while ($row = $result->fetch_assoc()) {
                $array_log = json_encode($row);
                criarLog($db,"_conf_cliente","id_conf",$id,"Editar",$array_log);
            }
            $location = "index.php?cod=1&id=$id";
        } else {
            $erro .= " Falta de dados para processar pedido.";
            $location = "index.php?cod=2&erro=$erro&id=$id";
        }

        header("location: $location");
    }
    $content = str_replace('_status_', $status, $content);

    $pageScript='        <!-- Load and execute javascript code used only in this page -->
        <script src="mod_conf_cliente.js"></script>
        <script>$(function(){ ValidarFormulario.init(); });</script>';
    $addUrl = "?id=$id";
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Lamentamos mas não conseguimos encontrar nenhuma configuração válida. Contacte o administrador.",""));
}

include ('../_autoData.php');