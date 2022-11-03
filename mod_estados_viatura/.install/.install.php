<label>Instalar módulo?</label> <a href=".install.php?instalar=1">Instalar!</a>
<?php
if(isset($_GET['instalar'])){
    include "../../_funcoes.php";
    include "../../conf/dados_plataforma.php";
    $db=ligarBD();
    $sql="insert into modulos (nome_modulo,url,icon,nomeTabela,nomeColuna,id_parent,descricao,mostrar,principal,id_criou,created_at) values ('Estados da Viatura','mod_estados_viatura','fa-plus','estados_viatura','estado_viatura','299','','1','0','1','2022-08-30 18:52:22')";
    $result=runQ($sql,$db,"INSERT");
    $insert_id=$db->insert_id;

    $sql="select * from modulos where id_modulo = $insert_id";
    $result=runQ($sql,$db,"SELECT INSERTED");
    while ($row = $result->fetch_assoc()) {
        $array_log=json_encode($row);
        criarLog($db,"modulos","id_modulo",$insert_id,"Criar (install)",$array_log);
    }
    $id_modulo=$insert_id;
    $funcs=[
        "insert into modulos_funcionalidades 
(id_modulo, so_em_reciclagem, icon, nome_funcionalidade, nome_em_reciclagem, descricao, url, principal, mostrar, confirmar, multiplos, mostrarDropdown, mostrar_subMenu, id_criou, created_at, ativo) 
values 
($id_modulo,'0','fa-list','Listar','','Apresentar registos.','index.php','0','1','0','0','0','0','".$_SESSION['id_utilizador']."','".current_timestamp."','1')",
        "insert into modulos_funcionalidades 
(id_modulo, so_em_reciclagem, icon, nome_funcionalidade, nome_em_reciclagem, descricao, url, principal, mostrar, confirmar, multiplos, mostrarDropdown, mostrar_subMenu, id_criou, created_at, ativo) 
values 
($id_modulo,'0','fa-plus','Criar','','Adicionar novo registo.','criar.php','0','1','0','0','0','0','".$_SESSION['id_utilizador']."','".current_timestamp."','1')",
        "insert into modulos_funcionalidades 
(id_modulo, so_em_reciclagem, icon, nome_funcionalidade, nome_em_reciclagem, descricao, url, principal, mostrar, confirmar, multiplos, mostrarDropdown, mostrar_subMenu, id_criou, created_at, ativo) 
values 
($id_modulo,'0','fa-edit','Editar','','Editar registo.','editar.php','0','0','0','0','1','1','".$_SESSION['id_utilizador']."','".current_timestamp."','1')",
        "insert into modulos_funcionalidades 
(id_modulo, so_em_reciclagem, icon, nome_funcionalidade, nome_em_reciclagem, descricao, url, principal, mostrar, confirmar, multiplos, mostrarDropdown, mostrar_subMenu, id_criou, created_at, ativo) 
values 
($id_modulo,'0','fa-list-alt','Detalhes','','Consultar registo.','detalhes.php','0','0','0','0','1','1','".$_SESSION['id_utilizador']."','".current_timestamp."','1')",
        "insert into modulos_funcionalidades 
(id_modulo, so_em_reciclagem, icon, nome_funcionalidade, nome_em_reciclagem, descricao, url, principal, mostrar, confirmar, multiplos, mostrarDropdown, mostrar_subMenu, id_criou, created_at, ativo) 
values 
($id_modulo,'0','fa-trash','Reciclagem','','Registos eliminados.','reciclagem.php','0','1','0','0','0','0','".$_SESSION['id_utilizador']."','".current_timestamp."','1')",
        "insert into modulos_funcionalidades 
(id_modulo, so_em_reciclagem, icon, nome_funcionalidade, nome_em_reciclagem, descricao, url, principal, mostrar, confirmar, multiplos, mostrarDropdown, mostrar_subMenu, id_criou, created_at, ativo) 
values 
($id_modulo,'0','fa-trash-o','Reciclar','Restaurar','Recuperar da reciclagem.','reciclar.php','0','0','1','1','1','0','".$_SESSION['id_utilizador']."','".current_timestamp."','1')",
        "insert into modulos_funcionalidades 
(id_modulo, so_em_reciclagem, icon, nome_funcionalidade, nome_em_reciclagem, descricao, url, principal, mostrar, confirmar, multiplos, mostrarDropdown, mostrar_subMenu, id_criou, created_at, ativo) 
values 
($id_modulo,'1','fa-times','Eliminar permanente','','Elimina permanentemente o registo.','eliminar_permanente.php','0','0','1','1','1','0','".$_SESSION['id_utilizador']."','".current_timestamp."','0')",
    ];
    foreach ($funcs as $func){
        $result = runQ($func, $db, "INSERT FUNCIONALIDADES");
        $id_func=$db->insert_id;

        $sql="insert into grupos_modulos_funcionalidades (id_grupo, id_funcionalidade, id_modulo) values ('1','$id_func','$id_modulo')";
        $result = runQ($sql, $db, "INSERT PERMISSOES");
    }

    $sql=file_get_contents(".tabela.sql");
    $result=runQ($sql,$db,"INSERT TABELA");
    $sql=file_get_contents(".tabela_primary_key.sql");
    $result=runQ($sql,$db,"primary_key TO TABELA");
    $sql=file_get_contents(".tabela_ai.sql");
    $result=runQ($sql,$db,"ADD AI TO TABELA");
    $db->close();

    unset($_SESSION['modulos']);

    header("location: ../index.php?cod=1");
}
