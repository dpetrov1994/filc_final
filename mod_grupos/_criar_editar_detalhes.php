<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 26/03/2018
 * Time: 19:07
 */


                    $sql_preencher="select * from clientes order by nome_cliente asc";
                    $result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
                    $ops="";
                    while ($row_preencher = $result_preencher->fetch_assoc()) {
                        $ops.="<option class='id_cliente' value='".$row_preencher["id_cliente"]."'>".$row_preencher["nome_cliente"]."</option>";
                    }
                    $content=str_replace("_id_cliente_",$ops,$content);
                    $sql_preencher="select * from simulacoes order by nome_simulacao asc";
                    $result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
                    $ops="";
                    while ($row_preencher = $result_preencher->fetch_assoc()) {
                        $ops.="<option class='id_simulacao' value='".$row_preencher["id_simulacao"]."'>".$row_preencher["nome_simulacao"]."</option>";
                    }
                    $content=str_replace("_id_simulacao_",$ops,$content);