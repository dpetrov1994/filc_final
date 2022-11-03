<?php



$posicao=recursivePosicao($cfg_id_modulo);
$it = new RecursiveIteratorIterator(new RecursiveArrayIterator($posicao));
$posicao = iterator_to_array($it,false);
$posicao=array_reverse($posicao);

$historicoPaginas="";
foreach ($posicao as $pos){
    foreach ($_SESSION['modulos'] as $modulo){
        if($modulo['id_modulo']==$pos && $modulo['nomeTabela'] != 'entities'){
            $historicoPaginas.="<li><a href='../".$modulo['url']."/index.php_addUrl_'><i class='fa ".$modulo['icon']."'></i>  ".$modulo['nome_modulo']."</a></li>";
            if($cfg_id_modulo==$pos){
                $historicoPaginas.="<li><i class='fa $cfg_icon_funcionalidade'></i> $cfg_nome_funcionalidade</li>";
            }elseif ($cfg_id_parent==$pos){

                if(isset($_GET['id'])){
                    $id=$db->escape_string($_GET['id']);
                    if($modulo['nomeTabela']!="" and $modulo['nomeColuna']!=""){
                        //$sql="select nome_".$modulo['nomeColuna']." from ".$modulo['nomeTabela']." where id_".$modulo['nomeColuna']."='$id'";
                        //$result=runQ($sql,$db,"NOME DO ITEM PARENT");
                        //while ($row = $result->fetch_assoc()) {
                        //    $historicoPaginas.="<li><a href='../".$modulo['url']."/detalhes.php?id=$id'> ".$row["nome_".$modulo['nomeColuna'].""]."</a></li>";
                        //}
                    }
                }

            }
        }
    }
}
$historicoPaginas='<div class="header-section nav-mini-hide pull-right" style="height: 50px"><ul class="breadcrumb breadcrumb-top">'.$historicoPaginas.'</ul></div>';

