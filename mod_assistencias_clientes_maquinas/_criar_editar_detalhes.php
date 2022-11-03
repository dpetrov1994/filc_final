<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 26/03/2018
 * Time: 19:07
 */


                    $sql_preencher="select * from maquinas where ativo=1";
                    $result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
                    $ops="";
                    while ($row_preencher = $result_preencher->fetch_assoc()) {
                        $ops.="<option class='id_maquina' value='".$row_preencher["id_maquina"]."'>".$row_preencher["nome_maquina"]."</option>";
                    }
                    $content=str_replace("_id_maquina_",$ops,$content);
                    $sql_preencher="select * from assistencias where ativo=1";
                    $result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
                    $ops="";
                    while ($row_preencher = $result_preencher->fetch_assoc()) {
                        $ops.="<option class='id_assistencia' value='".$row_preencher["id_assistencia"]."'>".$row_preencher["nome_assistencia"]."</option>";
                    }
                    $content=str_replace("_id_assistencia_",$ops,$content);