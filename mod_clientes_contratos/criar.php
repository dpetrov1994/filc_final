<?phpinclude('../_template.php');include ".cfg.php";$content=file_get_contents("criar.tpl");$content=str_replace("_descricao_","",$content);/**Preenchimento dos itens do formulário **/include ("_criar_editar_detalhes.php");/**FIM Preenchimento dos itens do formulário **/if(isset($_POST['submit'])){    $erros="";    $colunas="";    $valores="";    $scripts="";    if(isset($_FILES['file'])) {        $_POST['foto'] = carregar_foto($_FILES['file'], $cfg_tamanhoMaxUpload);    }    $_POST['segundos_restantes']=$_POST['horas']*60*60;    $return=colunas_valores_criar($_POST,$db,$itensIgnorar,$itensObrigatorios,$subModulo,$colunaParent,$idParent);    $erros=$return['erros'];    $colunas=$return['colunas'];    $valores=$return['valores'];    /**Validação de itens adicionais**/    /**FIM validação de itens adicionais**/    if($erros==""){        $sql="insert into $nomeTabela ($colunas,id_criou,created_at) values ($valores,'".$_SESSION['id_utilizador']."','".current_timestamp."')";        $result=runQ($sql,$db,"INSERT");        $insert_id=$db->insert_id;        /**Operações adicionais que necessitem do $insert_id **/        if($_SESSION['tecnico']==1){            $row['nome_cliente']="";            $id_cliente=$db->escape_string($_POST['id_cliente']);            $nome_cliente="";            $sql2 = "select * from srv_clientes where id_cliente='" .$id_cliente ."'";            $result2 = runQ($sql2, $db, 0);            while ($row2 = $result2->fetch_assoc()) {                $nome_cliente = $row2['OrganizationName'];            }            $titulo=cortaNome($_SESSION['nome_utilizador'])." criou um contrato para o cliente $nome_cliente";            notificar($db,$titulo,"clientes_contratos","contrato",$insert_id,"/mod_clientes_contratos/detalhes.php?id=$insert_id",[$_SESSION['cfg']['id_utilizador_notificar']]);        }        /**FIM perações adicionais que necessitem do $insert_id **/        $sql="select * from $nomeTabela where id_$nomeColuna = $insert_id";        $result=runQ($sql,$db,"SELECT INSERTED");        while ($row = $result->fetch_assoc()) {            $array_log=json_encode($row);            criarLog($db,$nomeTabela,"id_$nomeColuna",$insert_id,"Registo Criado",$array_log);        }        $location="detalhes.php?id=".$insert_id;        if($subModulo==0){            //$location.="&id=$insert_id";        }else{            //$location.="&subItemID=$insert_id";        }    }else{        $erros.=" Falta de dados para processar pedido.";        $location="criar.php$addUrl&cod=2&erro=$erros";    }    header("location: $location");}$pageScript='<script src="criar.js"></script>';include ('../_autoData.php');