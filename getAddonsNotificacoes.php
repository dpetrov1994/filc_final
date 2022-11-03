<?php
include ("_funcoes.php");
include ("conf/dados_plataforma.php");
include ("login/valida.php");
if(isset($_GET['addUrl']) && $_GET['addUrl']==1){
    $addUrl="../";
}else{
    $addUrl="";
}

$addon_notificacoes="<li class=\"dropdown-header\">
                      <strong>Notificações</strong>
                  </li>";
$db=ligarBD("NOTIFICACAOES");
$sql="select * from  notificacoes
      inner join utilizadores_notificacoes on utilizadores_notificacoes.id_notificacao=notificacoes.id_notificacao
      where utilizadores_notificacoes.id_utilizador=".$_SESSION['id_utilizador']." order by created_at desc limit 9 ";
$result=runQ($sql,$db,0);
if($result->num_rows==0){
    $addon_notificacoes.='    
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

        $textoNotificacaoCurto = removerHTML(cortaStr(($row['nome_notificacao']), 22));
        $textoNotificacaoCompleto=removerHTML(($row['nome_notificacao']));
        $urlNotificao = $row['url'];
        $star="";
        if(is_null($row['visto_em'])){
            $star="<small class='fa fa-bell text-warning'></small>";
        }
        $addon_notificacoes.='    
        <li class="">
            <a href="'.$urlNotificao.'" title="'.$textoNotificacaoCompleto.'" >
               <small>'.$star.' '.$textoNotificacaoCurto.'</small>
            </a>
        </li>';
    }
}
$urlNotificao=$addUrl."notificacoes/index.php";
$addon_notificacoes.='<li class="dropdown-header text-center">
                        <strong><a href="'.$urlNotificao.'">Mostrar tudo</a></strong>
                   </li>';
$db->close();
print $addon_notificacoes;

