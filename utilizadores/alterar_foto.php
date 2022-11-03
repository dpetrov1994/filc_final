<?php
include ('../_template.php');
$content=file_get_contents("../utilizadores/alterar_foto.tpl");
if(isset($_GET['id'])) {
    
    $id=$db->escape_string($_GET['id']);

    $add_sql=" and (select count(*) from grupos_utilizadores where (id_grupo=1 or id_grupo=2) and id_utilizador=utilizadores.id_utilizador )=0 ";
    foreach ($_SESSION['grupos'] as $grupo){
        if($grupo==1){
            $add_sql="";
        }
        if($grupo==2){
            $add_sql=" and (select count(*) from grupos_utilizadores where id_grupo=1 and id_utilizador=utilizadores.id_utilizador )=0 ";
        }
    }

    $sql="select * from utilizadores where id_utilizador='$id' $add_sql";
    $result=runQ($sql,$db,"1");
    if($result->num_rows!=0){
        while ($row = $result->fetch_assoc()) {
            $nomeUtilizador=$row['nome_utilizador'];
            $fotoAntiga=$row['foto'];
            $content=str_replace("_fotoParent_",removerHTML($row['foto']),$content);
            $content=str_replace("_idParent_",removerHTML($row['id_utilizador']),$content);
            $content=str_replace("_nomeParent_",removerHTML($row['nome_utilizador']),$content);
        }

        if (isset($_POST['submit'])) {
            $erros = 0;
            $erro = "";
            if($_POST['imagemUpload']==""){
                $erro .= "Sem ficheiro";
                $erros++;
            }
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['imagemUpload']));
            $nomeUtilizadorFicheiro=normalizeString($nomeUtilizador);
            $imagem = $nomeUtilizadorFicheiro."_".date("Y-m-d_H-i-s").".png";

            $contentDir="../_contents/fotos_utilizadores";
            if(!is_dir($contentDir)){
                mkdir($contentDir);
            }

            $moveResult = file_put_contents("$contentDir/original_$imagem", $data);
            if ($moveResult != true) {
                $erro .= " O FICHEIRO NAO FOI CARREGADO PARA O SERVIDOR-";
                $erros++;
                @unlink($fileTmpLoc);
            }else{
                $target_file = "$contentDir/original_$imagem";
                $resized_file = "$contentDir/$imagem";
                $wmax = 200;
                $hmax = 200;
                resizeTransparent($target_file, $resized_file, $wmax, $hmax);
                @unlink($target_file);
            }
            //se a imagem não tiver nada
            if(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['imagemUpload'])=='iVBORw0KGgoAAAANSUhEUgAAAMYAAADGCAYAAACJm/9dAAAAr0lEQVR4nO3BMQEAAADCoPVPbQ0PoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHg1ldAABXpGVtgAAAABJRU5ErkJggg=='){
                unlink("$contentDir/$imagem");
                $imagem=$fotoAntiga;
            }

            if($fotoAntiga!="avatar.jpg" && $imagem!=$fotoAntiga){
                unlink("$contentDir/$fotoAntiga");
            }

            if ($erros == 0) {
                $sql="update utilizadores set foto='$imagem', updated_at='".current_timestamp."',id_editou='".$_SESSION['id_utilizador']."' where id_utilizador=$id";
                $result=runQ($sql,$db,4);

                if($_SESSION['id_utilizador']==$id){
                    $_SESSION['foto']=$imagem;
                }

                criarLog($db,"utilizadores","id_utilizador",$id,"Alterar foto de perfil.",null);

                $location="alterar_foto.php?cod=3&id=$id";
                if(isset($_GET['cod'])){
                    if($_GET['cod']==1){
                        $location="editar.php?cod=3&id=$id";
                    }
                }

            } else {
                $erro .= " Falta de dados para processar pedido.";
                $location = "alterar_foto.php?cod=2&erro=$erro&id=$id";
            }

            header("location: $location");
        }
        $pageScript='<script src="../utilizadores/crop_upload.js"></script>';
    }else{
        exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Lamentamos mas não pode aceder a esta página sem fornecer todos os dados necessários.",""));
    }
    
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Lamentamos mas não pode aceder a esta página sem fornecer todos os dados necessários.",""));
}
include ('../_autoData.php');