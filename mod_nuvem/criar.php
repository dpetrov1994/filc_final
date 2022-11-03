<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("ajax");

if(isset($_POST['submit'])){

    $id=0;
    $id_pasta_parent=$id;
    if(isset($_POST['id_parent'])){
        $id=$db->escape_string($_POST['id_parent']);
        $id_pasta_parent=$id;
        $sql="select * from pastas where id_pasta='$id'";
        $result=runQ($sql,$db,"VERIFICAR SE A APSTA EXISTE");
        if($result->num_rows==0){
        }else{
            $result=runQ($sql,$db,"SELECT SE EXISTE");
            while ($row = $result->fetch_assoc()) {
                $id_pasta_parent=$row['id_pasta'];
                $id_voltar=$row['id_parent'];
                $nome_real=$row['nome_real'];
            }
        }
    }

    $erros="";
    $scripts="";

    /**Validação de itens adicionais**/

    $ok=0;
    $nome_pasta=$db->escape_string($_POST['nome_pasta']);
    while($ok==0){
        $sql="select nome_pasta from pastas where nome_pasta='$nome_pasta' and id_parent='$id_pasta_parent'";
        $result=runQ($sql,$db,"renomear");
        if($result->num_rows==0){
            $ok=1;
        }else{
            while ($row = $result->fetch_assoc()) {
                $nome_pasta.=" (Cópia)";
            }
        }
    }

    if(strlen($nome_pasta)>200){
        $nome_pasta=substr($nome_pasta, 0, 200)."_RAND".rand(1,1000);
    }

    $nome_real=normalizeString(tirarAcentos($nome_pasta));

    /**FIM validação de itens adicionais**/
    if($erros==""){
        $sql="insert into pastas (nome_pasta,id_parent,tipo,nome_real,id_criou,created_at) values ('$nome_pasta','$id_pasta_parent','pasta','$nome_real','".$_SESSION['id_utilizador']."','".current_timestamp."')";
        $result=runQ($sql,$db,"INSERT");
        $insert_id=$db->insert_id;
        $nome_real.="_ID$insert_id";

        $sql="update pastas set id_item='$insert_id', nome_real='$nome_real' where id_pasta='$insert_id'";
        $result=runQ($sql,$db,"UPDATE ID ITEM PARA ISERTID");

        /**Operações adicionais que necessitem do $insert_id **/

        $dir="../_contents";
        if(!is_dir($dir)){
            mkdir($dir);
        }
        $dir.="/nuvem_pastas";
        if(!is_dir($dir)){
            mkdir($dir);
        }
        if($id_pasta_parent!=0){
            $pastas=get_chain_da_pasta($db,$insert_id,$nome_real);
            $objTmp = (object) array('aFlat' => array());
            array_walk_recursive($pastas, create_function('&$v, $k, &$t', '$t->aFlat[] = $v;'), $objTmp);
            $pastas=$objTmp->aFlat;

            unset($pastas[0]);

            $pastas=array_reverse($pastas);
            foreach ($pastas as $pasta){
                $dir.="/".$pasta;
                if(!is_dir($dir)){
                    mkdir($dir);
                }
            }
        }else{
            $dir.="/".$nome_real;
            mkdir($dir);
        }

        $sql="update pastas set dir='$dir' where id_pasta='$insert_id'";
        $result=runQ($sql,$db,"UPDATE ID ITEM PARA ISERTID");

        /**FIM perações adicionais que necessitem do $insert_id **/

        $sql="select * from pastas where id_pasta = $insert_id";
        $result=runQ($sql,$db,"SELECT INSERTED");
        while ($row = $result->fetch_assoc()) {
            $array_log=json_encode($row);
            criarLog($db,"pastas","id_pasta",$insert_id,"Criar",$array_log);
        }
    }
}

$db->close();
print 0;