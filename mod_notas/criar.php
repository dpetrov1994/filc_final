<?phpinclude ('../_template.php');include ".cfg.php";$content=file_get_contents("criar.tpl");$content=str_replace("_descricao_","",$content);/**Preenchimento dos itens do formulário **/include ("_criar_editar_detalhes.php");/**FIM Preenchimento dos itens do formulário **/if(isset($_POST['submit'])){    $erros="";    $colunas="";    $valores="";    $scripts="";    if($_POST['pings']!=""){        $pings=json_decode($_POST['pings'],true);        if(is_array($pings)){            foreach ($pings as $id_utilizador => $nome_utilizador){                $nome_notificacao=$_SESSION['nome_utilizador']." identificou-o num comentário";                $nome_tabela="srv_clientes";                $nome_coluna="PartyID";                $id_item=$db->escape_string($_POST['id_item']);                $url_destino="https://$domain/mod_srvcliente/detalhes.php?id=$id_item";                $destinatarios=[$id_utilizador];                notificar($db,$nome_notificacao,$nome_tabela,$nome_coluna,$id_item,$url_destino,$destinatarios);            }        }    }    if($_POST['modulo']=='srv_clientes'){        $id_cliente=$db->escape_string($_POST['id_item']);        $sql="select FederalTaxID from srv_clientes where PartyID='$id_cliente'";        $result=runQ($sql,$db,"SELECT INSERTED");        while ($row = $result->fetch_assoc()) {            $_POST['id_item']=$row['FederalTaxID'];            $_POST['FederalTaxID']=$row['FederalTaxID'];        }    }    if(isset($_FILES['file'])) {        $_POST['foto'] = carregar_foto($_FILES['file'], $cfg_tamanhoMaxUpload);    }    $return=colunas_valores_criar($_POST,$db,$itensIgnorar,$itensObrigatorios,$subModulo,$colunaParent,$idParent);    $erros=$return['erros'];    $colunas=$return['colunas'];    $valores=$return['valores'];    /**Validação de itens adicionais**/    /**FIM validação de itens adicionais**/    if($erros==""){        $sql="insert into $nomeTabela ($colunas,id_criou,created_at) values ($valores,'".$_SESSION['id_utilizador']."','".current_timestamp."')";        $result=runQ($sql,$db,"INSERT");        $insert_id=$db->insert_id;        /**Operações adicionais que necessitem do $insert_id **/        $dir="../_contents/$nomeTabela";        if(!is_dir($dir)){            mkdir($dir);        }        $dir="../_contents/$nomeTabela/$insert_id";        if(!is_dir($dir)){            mkdir($dir);        }        moverFicheiros("../.tmp/".$_SESSION['id_utilizador'],$dir);        /**FIM perações adicionais que necessitem do $insert_id **/        $sql="select * from $nomeTabela where id_$nomeColuna = $insert_id";        $result=runQ($sql,$db,"SELECT INSERTED");        while ($row = $result->fetch_assoc()) {            $array_log=json_encode($row);            criarLog($db,$nomeTabela,"id_$nomeColuna",$insert_id,"Criar",$array_log);        }        if(isset($_POST['return_comentario'])){            $comentarios=getComentarios2($_POST['modulo'],$_POST['id_item'],$insert_id);            $comentario=$comentarios[0];            $comentario = (object)$comentario;            print (json_encode($comentario));            $db->close();            die();        }        $location="editar.php?$addUrl&cod=3";        if($subModulo==0){            $location.="&id=$insert_id";        }else{            $location.="&subItemID=$insert_id";        }    }else{        $erros.=" Falta de dados para processar pedido.";        $location="criar.php$addUrl&cod=2&erro=$erros";    }    header("location: $location");}$pageScript='<script src="criar.js"></script>';include ('../_autoData.php');