<?php
include ('../_template.php');
$content=file_get_contents("alterar_tema.tpl");

$id=1;
$sql="select * from _conf_cliente where id_conf='$id' ";
$result=runQ($sql,$db,1);
if($result->num_rows!=0){
    while ($row = $result->fetch_assoc()) {
        $content=str_replace("_nomeTema_",$row['tema'],$content);
        $tema=$row['tema'];
        $content=str_replace("_idParent_",$row['id_conf'],$content);
    }
    $directory = "$layoutDirectory/css/themes/";
    $scanned_directory = array_diff(scandir($directory), array('..', '.'));
    $temas="";
    foreach ($scanned_directory as $dir){
        $selected="";
        if($dir==$tema){
            $selected="selected";
        }
        $temas.="<option $selected value='".$dir."'>".$dir."</option>";
    }
    $content=str_replace("_temas_",$temas,$content);
    $status = "";
    if (isset($_POST['submit'])) {
        $erros=0;
        $erro="";

        $tema="";
        if(isset($_POST['tema'])){
            $tema=$db->escape_string($_POST['tema']);
        }else{
            $erro.=" TEMA -";
            $erros++;
        }
        if ($erros == 0) {
            $sql="update _conf_cliente set 
                tema='$tema' 
                where id_conf=$id";
            $result=runQ($sql,$db,4);

            $_SESSION['cfg']['temaPlataforma']=$tema;

            criarLog($db,"_conf_cliente","id_conf",$id,"Alterou tema para $tema",null);

            $location = "alterar_tema.php?cod=1&id=$id";

        } else {
            $erro .= " Falta de dados para processar pedido.";
            $location = "alterar_tema.php?cod=2&erro=$erro&id=$id";
        }

        header("location: $location");
    }

    $addUrl = "?id=$id";

}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Lamentamos mas não conseguimos encontrar nenhuma configuração válida. Contacte o administrador.",""));
}

include ('../_autoData.php');