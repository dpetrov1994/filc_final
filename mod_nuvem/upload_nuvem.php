<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 10/04/2018
 * Time: 19:35
 */

include("../_funcoes.php");
include("../conf/dados_plataforma.php");
include("../login/valida.php");

/**
 * ano_letivo,
 * turmas, turma,
 * aula,
 * alunos, aluno,
 * professores, professor,
 * colaboradores, colaborador
 * ees, ee,
 * utilizadores, utilizador
 */

print_r($_POST);

if(!empty($_POST)){
    $db=ligarBD(1);

    unset($_POST['submit']);

    $dir="../_contents";
    if(!is_dir($dir)){
        mkdir($dir);
    }

    $dir.="/nuvem_pastas";
    if(!is_dir($dir)){
        mkdir($dir);
    }


    $id_parent=0;
    /** 1. VERIFICAR SE EXISTE A PASTA DO ANO LETIVO*/
    if(isset($_POST['id_ano_letivo'])) {
        $id_ano_letivo=$_POST['id_ano_letivo'];
        $nome_real="ano_letivo-$id_ano_letivo";
        $sql="select * from pastas where tipo='ano_letivo' and id_item='$id_ano_letivo'";
        $result=runQ($sql,$db,"SELECT SE EXISTE ANO LETIVO");
        if($result->num_rows==0) {

            $sql2="select nome_ano_letivo from anos_letivos where id_ano_letivo='$id_ano_letivo'";
            $result2=runQ($sql2,$db,"SELECT nome do ano letivo");
            while ($row2 = $result2->fetch_assoc()) {
                $nome_ano_letivo=$row2['nome_ano_letivo']." [#$id_ano_letivo]";
            }

            $sql2="insert into pastas (tipo,id_item,nome_real,nome_pasta,id_criou,created_at) VALUES ('ano_letivo','$id_ano_letivo','$nome_real','$nome_ano_letivo','".$_SESSION['id_utilizador']."','".current_timestamp."')";
            $result2=runQ($sql2,$db,"CRIAR SE NAO EXISITR ANO LETIVO");
        }
        $result=runQ($sql,$db,"SELECT SE EXISTE ANO LETIVO");
        while ($row = $result->fetch_assoc()) {
            $id_parent=$row['id_parent'];
            $id_pasta=$row['id_pasta'];
            $nome_real=$row['nome_real'];
        }
        $dir.="/$nome_real";
        if(!is_dir($dir)){
            mkdir($dir);
        }

        if(isset($_POST['id_turma'])){
            /** 2. VERIFICAR SE EXISTE A PASTA GERAL DAS TURMAS*/
            $nome_real="Turmas";
            $sql="select * from pastas where tipo='turmas' and id_parent='$id_pasta'";
            $result=runQ($sql,$db,"SELECT SE EXISTE PRINCIPAL TURMAS");
            if($result->num_rows==0){
                $sql2="insert into pastas (tipo,id_parent,nome_real,nome_pasta,id_criou,created_at) VALUES ('turmas','$id_pasta','$nome_real','$nome_real','".$_SESSION['id_utilizador']."','".current_timestamp."')";
                $result2=runQ($sql2,$db,"CRIAR SE NAO EXISITR PRINCIPAL TURMAS");
            }
            $result=runQ($sql,$db,"SELECT SE EXISTE ANO LETIVO");
            while ($row = $result->fetch_assoc()) {
                $id_parent=$row['id_parent'];
                $id_pasta=$row['id_pasta'];
                $nome_real=$row['nome_real'];
            }
            $dir.="/$nome_real";
            if(!is_dir($dir)){
                mkdir($dir);
            }

            /** 3. VERIFICAR SE EXISTE A PASTA DA TURMA*/
            $nome_real="turma-".$_POST['id_turma'];
            $id_turma=$db->escape_string($_POST['id_turma']);
            $sql="select * from pastas where tipo='turma' and id_item='$id_turma' and id_parent='$id_pasta'";
            $result=runQ($sql,$db,"SELECT SE EXISTE A TURMA");
            if($result->num_rows==0){
                $sql2="select nome_turma,abreviatura from turmas where id_turma='$id_turma'";
                $result2=runQ($sql2,$db,"SELECT nome da turma");
                while ($row2 = $result2->fetch_assoc()) {
                    $nome_turma=$row2['abreviatura']." [#$id_turma]";
                }

                $sql2="insert into pastas (tipo,id_item,id_parent,nome_real,nome_pasta,id_criou,created_at) VALUES ('turma','$id_turma','$id_pasta','$nome_real','$nome_turma','".$_SESSION['id_utilizador']."','".current_timestamp."')";
                $result2=runQ($sql2,$db,"CRIAR SE NAO EXISITR A TURMA");
            }
            $result=runQ($sql,$db,"SELECT SE EXISTE ANO LETIVO");
            while ($row = $result->fetch_assoc()) {
                $id_parent=$row['id_parent'];
                $id_pasta=$row['id_pasta'];
                $nome_real=$row['nome_real'];
            }
            $dir.="/$nome_real";
            if(!is_dir($dir)){
                mkdir($dir);
            }

            if(isset($_POST['id_aula'])){
                /** 2. VERIFICAR SE EXISTE A PASTA GERAL DAS TURMAS*/
                $nome_real="Aulas";
                $sql="select * from pastas where tipo='aulas' and id_parent='$id_pasta'";
                $result=runQ($sql,$db,"SELECT SE EXISTE PRINCIPAL TURMAS");
                if($result->num_rows==0){
                    $sql2="insert into pastas (tipo,id_parent,nome_real,nome_pasta,id_criou,created_at) VALUES ('aulas','$id_pasta','$nome_real','$nome_real','".$_SESSION['id_utilizador']."','".current_timestamp."')";
                    $result2=runQ($sql2,$db,"CRIAR SE NAO EXISITR PRINCIPAL TURMAS");
                }
                $result=runQ($sql,$db,"SELECT SE EXISTE ANO LETIVO");
                while ($row = $result->fetch_assoc()) {
                    $id_parent=$row['id_parent'];
                    $id_pasta=$row['id_pasta'];
                    $nome_real=$row['nome_real'];
                }
                $dir.="/$nome_real";
                if(!is_dir($dir)){
                    mkdir($dir);
                }

                $nome_real="aula-".$_POST['id_aula'];
                $id_aula=$db->escape_string($_POST['id_aula']);
                $sql="select * from pastas where tipo='aula' and id_item='$id_aula' and id_parent='$id_pasta'";
                $result=runQ($sql,$db,"SELECT SE EXISTE A AULA");
                if($result->num_rows==0){

                    $sql2="select nome_aula from aulas where id_aula='$id_aula'";
                    $result2=runQ($sql2,$db,"SELECT nome da aula");
                    while ($row2 = $result2->fetch_assoc()) {
                        $nome_aula=$row2['nome_aula']." [#$id_aula]";
                    }

                    $sql2="insert into pastas (tipo,id_item,id_parent,nome_real,nome_pasta,id_criou,created_at) VALUES ('aula','$id_aula','$id_pasta','$nome_real','$nome_aula','".$_SESSION['id_utilizador']."','".current_timestamp."')";
                    $result2=runQ($sql2,$db,"CRIAR SE NAO EXISITR A AULA");
                }
                $result=runQ($sql,$db,"SELECT SE EXISTE ANO LETIVO");
                while ($row = $result->fetch_assoc()) {
                    $id_parent=$row['id_parent'];
                    $id_pasta=$row['id_pasta'];
                    $nome_real=$row['nome_real'];
                }
                $dir.="/$nome_real";
                if(!is_dir($dir)){
                    mkdir($dir);
                }
            }

        }else if(isset($_POST['id_aluno'])){
            /** 1. VERIFICAR SE EXISTE A PASTA GERAL DOS ALUNOS*/
            $nome_real="Alunos";
            $sql="select * from pastas where tipo='alunos' and id_parent='$id_pasta'";
            $result=runQ($sql,$db,"SELECT SE EXISTE PRINCIPAL ALUNOS");
            if($result->num_rows==0){
                $sql2="insert into pastas (tipo,id_parent,nome_real,nome_pasta,id_criou,created_at) VALUES ('alunos','$id_pasta','$nome_real','$nome_real','".$_SESSION['id_utilizador']."','".current_timestamp."')";
                $result2=runQ($sql2,$db,"CRIAR SE NAO EXISITR PRINCIPAL ALUNOS");
            }

            $result=runQ($sql,$db,"SELECT SE EXISTE ANO LETIVO");
            while ($row = $result->fetch_assoc()) {
                $id_parent=$row['id_parent'];
                $id_pasta=$row['id_pasta'];
                $nome_real=$row['nome_real'];
            }
            $dir.="/$nome_real";
            if(!is_dir($dir)){
                mkdir($dir);
            }
            /** 2. VERIFICAR SE EXISTE A PASTA DO ALUNO*/
            $nome_real="aluno-".$_POST['id_aluno'];
            $id_aluno=$db->escape_string($_POST['id_aluno']);
            $sql="select * from pastas where tipo='aluno' and id_item='$id_aluno' and id_parent='$id_pasta'";
            $result=runQ($sql,$db,"SELECT SE EXISTE O ALUNO");
            if($result->num_rows==0){

                $sql2="select nome_aluno from alunos where id_aluno='$id_aluno'";
                $result2=runQ($sql2,$db,"SELECT nome do aluno");
                while ($row2 = $result2->fetch_assoc()) {
                    $nome_aluno=cortaNome($row2['nome_aluno'])." [#a$id_aluno]";
                }

                $sql2="insert into pastas (tipo,id_item,id_parent,nome_real,nome_pasta,id_criou,created_at) VALUES ('aluno','$id_aluno','$id_pasta','$nome_real','$nome_aluno','".$_SESSION['id_utilizador']."','".current_timestamp."')";
                $result2=runQ($sql2,$db,"CRIAR SE NAO EXISITR O ALUNO");
            }

            $result=runQ($sql,$db,"SELECT SE EXISTE ANO LETIVO");
            while ($row = $result->fetch_assoc()) {
                $id_parent=$row['id_parent'];
                $id_pasta=$row['id_pasta'];
                $nome_real=$row['nome_real'];
            }
            $dir.="/$nome_real";
            if(!is_dir($dir)){
                mkdir($dir);
            }
        }
        elseif(isset($_POST['id_professor'])){
            /** 1. VERIFICAR SE EXISTE A PASTA GERAL DOS PROFESSORES*/
            $nome_real="Professores";
            $sql="select * from pastas where tipo='professores' and id_parent='$id_pasta'";
            $result=runQ($sql,$db,"SELECT SE EXISTE PRINCIPAL PROFESSORES");
            if($result->num_rows==0){
                $sql2="insert into pastas (tipo,id_parent,nome_real,nome_pasta,id_criou,created_at) VALUES ('professores','$id_pasta','$nome_real','$nome_real','".$_SESSION['id_utilizador']."','".current_timestamp."')";
                $result2=runQ($sql2,$db,"CRIAR SE NAO EXISITR PRINCIPAL PROFESSORES");
            }

            $result=runQ($sql,$db,"SELECT SE EXISTE ANO LETIVO");
            while ($row = $result->fetch_assoc()) {
                $id_parent=$row['id_parent'];
                $id_pasta=$row['id_pasta'];
                $nome_real=$row['nome_real'];
            }
            $dir.="/$nome_real";
            if(!is_dir($dir)){
                mkdir($dir);
            }

            /** 2. VERIFICAR SE EXISTE A PASTA DO PROFESSOR*/
            $nome_real="professor-".$_POST['id_professor'];
            $id_professor=$db->escape_string($_POST['id_professor']);
            $sql="select * from pastas where tipo='professor' and id_item='$id_professor' and id_parent='$id_pasta'";
            $result=runQ($sql,$db,"SELECT SE EXISTE O PROFESSOR");
            if($result->num_rows==0){

                $sql2="select nome_professor from professores where id_professor='$id_professor'";
                $result2=runQ($sql2,$db,"SELECT nome do professor");
                while ($row2 = $result2->fetch_assoc()) {
                    $nome_professor=cortaNome($row2['nome_professor'])." [#p$id_professor]";
                }

                $sql2="insert into pastas (tipo,id_item,id_parent,nome_real,nome_pasta,id_criou,created_at) VALUES ('professor','$id_professor','$id_pasta','$nome_real','$nome_professor','".$_SESSION['id_utilizador']."','".current_timestamp."')";
                $result2=runQ($sql2,$db,"CRIAR SE NAO EXISITR O PROFESSOR");
            }

            $result=runQ($sql,$db,"SELECT SE EXISTE ANO LETIVO");
            while ($row = $result->fetch_assoc()) {
                $id_parent=$row['id_parent'];
                $id_pasta=$row['id_pasta'];
                $nome_real=$row['nome_real'];
            }
            $dir.="/$nome_real";
            if(!is_dir($dir)){
                mkdir($dir);
            }
        }
        elseif(isset($_POST['id_colaborador'])){
            /** 1. VERIFICAR SE EXISTE A PASTA GERAL DOS COLABORADORES*/
            $nome_real="Colaboradores";
            $sql="select * from pastas where tipo='colaboradores' and id_parent='$id_pasta'";
            $result=runQ($sql,$db,"SELECT SE EXISTE PRINCIPAL COLABORADORES");
            if($result->num_rows==0){
                $sql2="insert into pastas (tipo,id_parent,nome_real,nome_pasta,id_criou,created_at) VALUES ('colaboradores','$id_pasta','$nome_real','$nome_real','".$_SESSION['id_utilizador']."','".current_timestamp."')";
                $result2=runQ($sql2,$db,"CRIAR SE NAO EXISITR PRINCIPAL COLABORADORES");
            }

            $result=runQ($sql,$db,"SELECT SE EXISTE ANO LETIVO");
            while ($row = $result->fetch_assoc()) {
                $id_parent=$row['id_parent'];
                $id_pasta=$row['id_pasta'];
                $nome_real=$row['nome_real'];
            }
            $dir.="/$nome_real";
            if(!is_dir($dir)){
                mkdir($dir);
            }

            /** 2. VERIFICAR SE EXISTE A PASTA DO COLABORADOR*/
            $nome_real="colaborador-".$_POST['id_colaborador'];
            $id_colaborador=$db->escape_string($_POST['id_colaborador']);
            $sql="select * from pastas where tipo='colaborador' and id_item='$id_colaborador' and id_parent='$id_pasta'";
            $result=runQ($sql,$db,"SELECT SE EXISTE O COLABORADOR");
            if($result->num_rows==0){

                $sql2="select nome_colaborador from colaboradores where id_colaborador='$id_colaborador'";
                $result2=runQ($sql2,$db,"SELECT nome do colaborador");
                while ($row2 = $result2->fetch_assoc()) {
                    $nome_colaborador=$row2['nome_colaborador']." [#c$id_colaborador]";
                }

                $sql2="insert into pastas (tipo,id_item,id_parent,nome_real,nome_pasta,id_criou,created_at) VALUES ('colaborador','$id_colaborador','$id_pasta','$nome_real','$nome_colaborador','".$_SESSION['id_utilizador']."','".current_timestamp."')";
                $result2=runQ($sql2,$db,"CRIAR SE NAO EXISITR O COLABORADOR");
            }

            $result=runQ($sql,$db,"SELECT SE EXISTE ANO LETIVO");
            while ($row = $result->fetch_assoc()) {
                $id_parent=$row['id_parent'];
                $id_pasta=$row['id_pasta'];
                $nome_real=$row['nome_real'];
            }
            $dir.="/$nome_real";
            if(!is_dir($dir)){
                mkdir($dir);
            }
        }
        elseif(isset($_POST['id_ee'])){
            /** 1. VERIFICAR SE EXISTE A PASTA GERAL DOS EES*/
            $nome_real="Ees";
            $sql="select * from pastas where tipo='ees' and id_parent='$id_pasta'";
            $result=runQ($sql,$db,"SELECT SE EXISTE PRINCIPAL EES");
            if($result->num_rows==0){
                $sql2="insert into pastas (tipo,id_parent,nome_real,nome_pasta,id_criou,created_at) VALUES ('ees','$id_pasta','$nome_real','$nome_real','".$_SESSION['id_utilizador']."','".current_timestamp."')";
                $result2=runQ($sql2,$db,"CRIAR SE NAO EXISITR PRINCIPAL EES");
            }

            $result=runQ($sql,$db,"SELECT SE EXISTE ANO LETIVO");
            while ($row = $result->fetch_assoc()) {
                $id_parent=$row['id_parent'];
                $id_pasta=$row['id_pasta'];
                $nome_real=$row['nome_real'];
            }
            $dir.="/$nome_real";
            if(!is_dir($dir)){
                mkdir($dir);
            }

            /** 2. VERIFICAR SE EXISTE A PASTA DO EE*/
            $nome_real="ee-".$_POST['id_ee'];
            $id_ee=$db->escape_string($_POST['id_ee']);
            $sql="select * from pastas where tipo='ee' and id_item='$id_ee' and id_parent='$id_pasta'";
            $result=runQ($sql,$db,"SELECT SE EXISTE O EE");
            if($result->num_rows==0){
                $sql2="select nome_ee from ees where id_ee='$id_ee'";
                $result2=runQ($sql2,$db,"SELECT nome do ee");
                while ($row2 = $result2->fetch_assoc()) {
                    $nome_ee=cortaNome($row2['nome_ee'])." [#ee$id_ee]";
                }

                $sql2="insert into pastas (tipo,id_item,id_parent,nome_real,nome_pasta,id_criou,created_at) VALUES ('ee','$id_ee','$id_pasta','$nome_real','$nome_ee','".$_SESSION['id_utilizador']."','".current_timestamp."')";
                $result2=runQ($sql2,$db,"CRIAR SE NAO EXISITR O EE");
            }

            $result=runQ($sql,$db,"SELECT SE EXISTE ANO LETIVO");
            while ($row = $result->fetch_assoc()) {
                $id_parent=$row['id_parent'];
                $id_pasta=$row['id_pasta'];
                $nome_real=$row['nome_real'];
            }
            $dir.="/$nome_real";
            if(!is_dir($dir)){
                mkdir($dir);
            }
        }
    }

    if(isset($_POST['id_utilizador'])){
        /** 1. VERIFICAR SE EXISTE A PASTA GERAL DOS UTILIZADORES*/
        $nome_real="Utilizadores";
        $sql="select * from pastas where tipo='utilizadores' and id_parent='$id_pasta'";
        $result=runQ($sql,$db,"SELECT SE EXISTE PRINCIPAL UTILIZADORES");
        if($result->num_rows==0){
            $sql2="insert into pastas (tipo,id_parent,nome_real,nome_pasta,id_criou,created_at) VALUES ('utilizadores','$id_pasta','$nome_real','$nome_real','".$_SESSION['id_utilizador']."','".current_timestamp."')";
            $result2=runQ($sql2,$db,"CRIAR SE NAO EXISITR PRINCIPAL UTILIZADORES");
        }
        
        $result=runQ($sql,$db,"SELECT SE EXISTE ANO LETIVO");
        while ($row = $result->fetch_assoc()) {
            $id_parent=$row['id_parent'];
            $id_pasta=$row['id_pasta'];
            $nome_real=$row['nome_real'];
        }
        $dir.="/$nome_real";
        if(!is_dir($dir)){
            mkdir($dir);
        }

        /** 2. VERIFICAR SE EXISTE A PASTA DO UTILIZADOR*/
        $nome_real="utilizador-".$_POST['id_utilizador'];
        $id_utilizador=$db->escape_string($_POST['id_utilizador']);
        $sql="select * from pastas where tipo='utilizador' and id_item='$id_utilizador' and id_parent='$id_pasta'";
        $result=runQ($sql,$db,"SELECT SE EXISTE O UTILIZADOR");
        if($result->num_rows==0){

            $sql2="select nome_utilizador from utilizadores where id_utilizador='$id_utilizador'";
            $result2=runQ($sql2,$db,"SELECT nome do utilizador");
            while ($row2 = $result2->fetch_assoc()) {
                $nome_utilizador=$row2['nome_utilizador']." [#u$id_utilizador]";
            }

            $sql2="insert into pastas (tipo,id_item,id_parent,nome_real,nome_pasta,id_criou,created_at) VALUES ('utilizador','$id_utilizador','$id_pasta','$nome_real','$nome_utilizador','".$_SESSION['id_utilizador']."','".current_timestamp."')";
            $result2=runQ($sql2,$db,"CRIAR SE NAO EXISITR O UTILIZADOR");
        }
        
        $result=runQ($sql,$db,"SELECT SE EXISTE ANO LETIVO");
        while ($row = $result->fetch_assoc()) {
            $id_parent=$row['id_parent'];
            $id_pasta=$row['id_pasta'];
            $nome_real=$row['nome_real'];
        }
        $dir.="/$nome_real";
        if(!is_dir($dir)){
            mkdir($dir);
        }
    }
    
    if(isset($_POST['id_pasta'])){
        $nome_real="nuvem_pastas";
        $id_pasta=$db->escape_string($_POST['id_pasta']);
        $sql="select * from pastas where id_pasta='$id_pasta'";
        $result=runQ($sql,$db,"SELECT SE EXISTE PASTA");
        while ($row = $result->fetch_assoc()) {
            $id_parent=$row['id_parent'];
            $id_pasta=$row['id_pasta'];
            $nome_real=$row['nome_real'];
        }
        $pastas=get_chain_da_pasta($db,$id_pasta,$nome_real);
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
    }

    $de="../.tmp/".$_SESSION['id_utilizador'];
    $para=$dir;
    if(is_dir($de)){
        if(!is_dir($para)){
            mkdir($para);
        }
        $ficheiros=mostraFicheiros($de);
        foreach ($ficheiros as $ficheiro){
            copy("$de/$ficheiro","$para/$ficheiro");

            $sql2="insert into pastas_ficheiros (id_pasta,nome_real,nome_ficheiro,dir,id_criou,created_at) VALUES ($id_pasta,'$ficheiro','$ficheiro','$dir','".$_SESSION['id_utilizador']."','".current_timestamp."')";
            $result2=runQ($sql2,$db,"REGISTAR FICHEIRO");
            $insert_id=$db->insert_id;

            $nome_real="ID$insert_id"."_$ficheiro";

            $sql2="update pastas_ficheiros set nome_real='$nome_real' where id_ficheiro='$insert_id'";
            $result2=runQ($sql2,$db,"UPDATE FICHEIRO");
            rename("$para/$ficheiro","$para/$nome_real");

            //carregar ficheiro
            $sql="select * from pastas_ficheiros where id_ficheiro = $insert_id";
            $result=runQ($sql,$db,"SELECT INSERTED");
            while ($row = $result->fetch_assoc()) {
                $array_log=json_encode($row);
                criarLog($db,"pastas_ficheiros","ficheiro",$insert_id,'Criar (Carregou Ficheiro)',$array_log);
            }
            unlink("$de/$ficheiro");
        }
    }

    $db->close();
}