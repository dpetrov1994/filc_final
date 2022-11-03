<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 26/03/2018
 * Time: 19:07
 */


                    $sql_preencher="select * from assistencias_clientes where ativo=1";
                    $result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
                    $ops="";
                    while ($row_preencher = $result_preencher->fetch_assoc()) {
                        $ops.="<option class='id_assistencia_cliente' value='".$row_preencher["id_assistencia_cliente"]."'>".$row_preencher["nome_assistencia_cliente"]."</option>";
                    }
                    $content=str_replace("_id_assistencia_cliente_",$ops,$content);
                    $sql_preencher="select * from utilizadores where ativo=1";
                    $result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
                    $ops="";
                    while ($row_preencher = $result_preencher->fetch_assoc()) {
                        $ops.="<option class='id_utilizador' value='".$row_preencher["id_utilizador"]."'>".$row_preencher["nome_utilizador"]."</option>";
                    }
                    $content=str_replace("_id_utilizador_",$ops,$content);
                    $sql_preencher="select * from srv_clientes where ativo=1";
                    $result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
                    $ops="";
                    while ($row_preencher = $result_preencher->fetch_assoc()) {
                        $ops.="<option class='id_cliente' value='".$row_preencher["id_cliente"]."'>".$row_preencher["OrganizationName"]."</option>";
                    }
                    $content=str_replace("_id_cliente_",$ops,$content);