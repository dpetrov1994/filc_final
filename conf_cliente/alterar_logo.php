<?php
include ('../_template.php');
$content=file_get_contents("alterar_logo.tpl");

if (isset($_POST['submit'])) {
    $erros = 0;
    $erro = "";

    if($_POST['imagemUpload']=="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMYAAADGCAYAAACJm/9dAAAAr0lEQVR4nO3BMQEAAADCoPVPbQ0PoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHg1ldAABXpGVtgAAAABJRU5ErkJggg=="){
        $erro .= "Sem ficheiro";
        $erros++;
    }

    if ($erros == 0) {

        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['imagemUpload']));

        $imagem = "logo.png";
        $moveResult = file_put_contents("$layoutDirectory/img/original_$imagem", $data);
        if ($moveResult != true) {
            $erro .= " O FICHEIRO NAO FOI CARREGADO PARA O SERVIDOR-";
            $erros++;
        }else{
            $target_file = "$layoutDirectory/img/original_$imagem";
            $tamanhos=[
                'icon29.png'=>'29',
                'icon36.png'=>'36',
                'icon40.png'=>'40',
                'icon48.png'=>'48',
                'icon50.png'=>'50',
                'icon57.png'=>'57',
                'icon58.png'=>'58',
                'icon60.png'=>'60',
                'icon72.png'=>'72',
                'icon76.png'=>'76',
                'icon80.png'=>'80',
                'icon87.png'=>'87',
                'icon96.png'=>'96',
                'icon100.png'=>'100',
                'icon114.png'=>'114',
                'icon120.png'=>'120',
                'icon144.png'=>'144',
                'icon152.png'=>'152',
                'icon167.png'=>'167',
                'icon180.png'=>'180'
            ];
            foreach ($tamanhos as $nome =>$tamanho){
                $resized_file = "$layoutDirectory/img/$nome";
                $wmax = $tamanho;
                $hmax = $tamanho;
                resizeTransparent($target_file, $resized_file, $wmax, $hmax);
            }
        }
        criarLog($db,"_conf_cliente","id_conf",$id,"Alterou logo.",null);
        $location = "alterar_logo.php?cod=1&";
    } else {
        $erro .= " Falta de dados para processar pedido.";
        $location = "alterar_logo.php?cod=2&erro=$erro";
    }
    header("location: $location");
}

$pageScript='        <!-- Load and execute javascript code used only in this page -->
        <script src="crop_upload.js"></script>';

$content = str_replace('_status_', $status, $content);
include "../_autoData.php";