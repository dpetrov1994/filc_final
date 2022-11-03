<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 26/03/2018
 * Time: 19:07
 */

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

}