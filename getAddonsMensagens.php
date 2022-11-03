<?php

include ("_funcoes.php");
include ("conf/dados_plataforma.php");
include ("login/valida.php");
if(isset($_GET['addUrl']) && $_GET['addUrl']==1){
    $addUrl="../";
}else{
    $addUrl="";
}

$addon_mensagens="<li class=\"dropdown-header\">
                      <strong>Mensagens</strong>
                  </li>";
$db=ligarBD("MENSAGENS");
$sql="select * from  mensagens
      inner join utilizadores_mensagens on utilizadores_mensagens.id_mensagem=mensagens.id_mensagem
      where id_utilizador=".$_SESSION['id_utilizador']." order by created_at desc limit 9 ";
$result=runQ($sql,$db,0);
if($result->num_rows==0){
    $addon_mensagens.='    
    <li class="">
        <small class="text-muted" >
        </small>
    </li>';
}else{
    while($row = $result->fetch_assoc()) {

        $sql2 = "select nome_utilizador from utilizadores where id_utilizador=" . $row['id_criou'];
        $result2 = runQ($sql2, $db, 0);
        while ($row2 = $result2->fetch_assoc()) {
            $nomeUtilizador = $row2['nome_utilizador'];
        }

        $textomensagemCurto = removerHTML(cortaStr(($row['nome_mensagem']), 22));
        $textomensagemCompleto=removerHTML(($row['nome_mensagem']));
        $urlNotificao = "../mod_mensagens/abrir.php?id=".$row['id_mensagem'];
        $star="";
        if(is_null($row['visto_em'])){
            $star="<small class='fa fa-envelope text-warning'></small>";
        }
        $addon_mensagens.='    
        <li class="">
            <a href="'.$urlNotificao.'" title="'.$textomensagemCompleto.'" >
               <small>'.$star.' '.$textomensagemCurto.'</small>
            </a>
        </li>';
    }
}
$urlNotificao=$addUrl."mod_mensagens/index.php";
$addon_mensagens.='<li class="dropdown-header text-center">
                        <strong><a href="'.$urlNotificao.'">Mostrar tudo</a></strong>
                   </li>';
$db->close();
print $addon_mensagens;

