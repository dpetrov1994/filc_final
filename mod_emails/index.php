<?phpinclude ('../_template.php');$content=file_get_contents("index.tpl");$tabela='<table class="table table-striped table-borderless table-vcenter table-hover">                    <thead>                    <tr>                        <th style="min-width: 100px" class="hidden-xs hidden-xs"></th>                        <th class=""></th>                        <th class="hidden-xs hidden-xs"></th>                        <th class="hidden-sm hidden-xs"></th>                        <th class="hidden-sm hidden-xs"></th>                        <th class="hidden-sm hidden-xs"></th>                        <th class="hidden-sm hidden-xs"></th>                    </tr>                    </thead>                    <tbody>                        _linhas_                    </tbody>                </table>';$linhaTabela= '<tr>                        <td class=" hidden-xs hidden-xs"><img src="../utilizadores/fotos/_foto_" alt="avatar" class="img-circle img-thumbnail img-thumbnail-avatar "></td>                        <td class=""><a target="_blank" href="../mod_perfil/index.php?id=_idUtilizador_"><strong>_nome_</strong></a></td>                        <td class="hidden-xs hidden-xs"><strong> _assunto_</strong></td>                        <td class="hidden-sm hidden-xs">_destinatario_</td>                        <td class="hidden-sm hidden-xs">_tipo_</td>                        <td class="hidden-sm hidden-xs">_created_at_</td>                        <td class="hidden-sm hidden-xs">_estado_</td>                         <td class="text-center">                            <div class="btn-group">                                <a href="javascript:void(0)" data-toggle="dropdown" class="btn btn-primary btn-effect-ripple dropdown-toggle" aria-expanded="false"> <span class="fa fa-bars"> <i class="caret"></i></span></a>                                <ul class="dropdown-menu dropdown-menu-right text-left">                                    _funcionalidades_                                </ul>                            </div>                        </td>                    </tr>';        $linhaFuncionalidade = '<li>                          <a _url_>                            <i class="fa _icon_ pull-right"></i>                            <i class="fa fa-question-circle" data-toggle="tooltip" title="" data-original-title="_descricao_"></i> _nome_                            </a>                      </li>';// *******************************************************************************************************************$innerjoin=" inner join utilizadores on utilizadores.id_utilizador=_emails_enviados.id_criou";$add_sql="";$nomeTabela="_emails_enviados";$chaveS="email";$op1="0";if(isset($_GET['op1'])){    $op1=$db->escape_string($_GET['op1']);    if($op1!="s"){        $add_sql.=" and tipo='$op1' ";    }    if($op1==0){        $content=str_replace("_op0_","selected",$content);    }    if($op1==1){        $content=str_replace("_op1_","selected",$content);    }}$content=str_replace("_op0_","",$content);$content=str_replace("_op1_","",$content);$pr=20; // resultados por páginaif(isset($_GET['pr'])){    $pr=$db->escape_string($_GET['pr']);}$prs=[    5,10,20,30,40,50,75,100];$opsPrs="";foreach ($prs as $e){    $selected="";    if($pr==$e){        $selected="selected";    }    $opsPrs.="<option $selected value='$e'>$e</option>";}$pn=1; //número de páginaif(isset($_GET['pn'])){    $pn=$db->escape_string($_GET['pn']);    $pn=preg_replace('#[^0-9]#', '', $pn);}$p="";// string de pesquisaif(isset($_GET['p'])){    $p=$db->escape_string($_GET['p']);}$content=str_replace("_p_",$p,$content);$pesquisa=str_replace("  ","",$p);if($pesquisa!="" and $pesquisa!=" "){    $palavras=str_replace(" ","+",$pesquisa);    $palavras=explode("+",(($palavras)));    $add_sql.="";    foreach ($palavras as $palavra){        if($palavra!=""){            $add_sql.=" and ( ".$nomeTabela.".assunto LIKE '%$palavra%' or                               nome_utilizador LIKE '%$palavra%' or                              ".$nomeTabela.".id_$chaveS LIKE '%$palavra%'            ) ";        }    }}$o="$nomeTabela.created_at desc"; //ordenar defaultif(isset($_GET['o'])){    $o=$db->escape_string($_GET['o']);}$ordenar=[    "nome_utilizador asc"=>"Utilizador ASC",    "nome_utilizador desc"=>"Utilizador DESC",    "assunto asc"=>"Assunto ASC",    "assunto desc"=>"Assunto DESC",    "$nomeTabela.created_at asc"=>"Data criação ASC",    "$nomeTabela.created_at desc"=>"Data criação DESC"];$opsOrdenar="";$add_sql2=$add_sql."";foreach ($ordenar as $key=>$value){    $selected="";    if($o==$key){        $selected="selected";        $add_sql2=$add_sql." order by $o "; //ete add_sql é para o select *        $add_sql.=" order by $o"; //este add_sql é para o count    }    $opsOrdenar.="<option $selected value='$key'>$value</option>";}// *******************************************************************************************************************$tr=0;// número total de resultados$linhas="";$paginacao="";//contar o número total de resultados$sql="SELECT count(distinct(".$nomeTabela.".id_".$chaveS."))FROM ".$nomeTabela." $innerjoin WHERE 1 $add_sql";$result=runQ($sql,$db,"1");while ($row = $result->fetch_assoc()) {    $tr=$row['count(distinct('.$nomeTabela.'.id_'.$chaveS.'))']; // total rows}if($tr>0){    /***************************************************** PAGINACAO *******************************/    if(is_file("_paginacao.php")){        include "_paginacao.php";    }elseif(is_file("../_paginacao.php")){        include "../_paginacao.php";    include "../_funcionalidades.php";    }    /*************************************************** APRESENTACAO DE RESULTADOS **************************/    $add_sql2.=" LIMIT ".(($pn-1)*$pr)." , $pr";    $sql="    SELECT     *,".$nomeTabela.".created_at as DataCriado    FROM ".$nomeTabela."     $innerjoin     WHERE 1 $add_sql2";    $result=runQ($sql,$db,"2");    while ($row = $result->fetch_assoc()) {        $linhas.=$linhaTabela;        $linhas=str_replace("_id_",$row['id_'.$chaveS],$linhas);        $linhas=str_replace("_foto_",($row['foto']),$linhas);        $linhas=str_replace("_nome_",($row['nome_utilizador']),$linhas);        $linhas=str_replace("_idUtilizador_",($row['id_utilizador']),$linhas);        $linhas=str_replace("_assunto_",($row['assunto']),$linhas);        $linhas=str_replace("_destinatario_",($row['destinatario']),$linhas);        if($row['tipo']==1){            $linhas=str_replace("_tipo_","SMS",$linhas);        }else{            $linhas=str_replace("_tipo_","E-MAIL",$linhas);        }        if($row['estado']!="0"){            $estado='<small class="text-danger">  '.removerHTML($row['estado']).'</small>';        }else{            $estado='<small class="label label-success">  Enviado</small>';        }        $linhas=str_replace("_estado_",$estado,$linhas);        $linhas=str_replace("_created_at_",humanTiming($row['DataCriado']),$linhas);        //inserimos o menu de ações        include("../_funcionalidades.php");    }    $resultados=str_replace("_linhas_",$linhas,$tabela);}else{    $resultados="_semResultados_";}$pageScript="";$content=str_replace("_prs_",$opsPrs,$content);$content=str_replace("_ordenar_",$opsOrdenar,$content);$content=str_replace("_resultados_",$resultados,$content);$content=str_replace("_paginacao_",$paginacao,$content);include ('../_autoData.php');