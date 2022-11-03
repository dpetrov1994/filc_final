<?php


/**
 * Esta ferramenta corre todas as tabelas da base dedados,
 * apaga os indices existens e cria indices novos em todas as colunas que começam por id_
 * Não apaga as chaves primarias e também não adicoona indices novos nas chaves primarias
 */

include "../_funcoes.php";

function startsWith ($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}



$db=ligarBD();

$sql="show tables";
$result=runQ($sql,$db,0);
while($row = $result->fetch_assoc()) {
    foreach ($row as $key => $table){

        $indices=[];
        $primarias=[];
        $sql2="SHOW INDEX FROM $table";
        $result2=runQ($sql2,$db,1);
        while($row2 = $result2->fetch_assoc()) {
            if($row2['Key_name']!='PRIMARY'){
                if(!in_array($row2["Key_name"],$indices)){
                    $indices[]=$row2["Key_name"];
                }
            }else{
                if(!in_array($row2["Column_name"],$primarias)){
                    $primarias[]=$row2["Column_name"];
                }
            }
        }

        foreach ($indices as $index){
            $sql2="ALTER TABLE $table DROP INDEX $index;";
            $result2=runQ($sql2,$db,"apagar indice");
        }

        //criar indices
        $sql2="describe $table";
        $result2=runQ($sql2,$db,1);
        while($row2 = $result2->fetch_assoc()) {
            if(startsWith($row2['Field'],"id_") && !in_array($row2['Field'],$primarias)){
                $sql3="ALTER TABLE $table ADD INDEX(".$row2['Field'].");";
                $result3=runQ($sql3,$db,"criar indice");
            }

        }
    }
}

print "feito";
die();



?>