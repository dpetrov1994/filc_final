<?php
$paginacao="";
$ultimaPagina = ceil($tr / $pr);
if($ultimaPagina < 1){
    $ultimaPagina = 1;
}
if ($pn < 1) {
    $pn = 1;
} else if ($pn > $ultimaPagina) {
    $pn = $ultimaPagina;
}
if ($ultimaPagina != 1) {
    if ($pn > 1) {
        $previous = $pn - 1;
        $paginacao.='<li class="next"><a href="' . $_SERVER['PHP_SELF'] . '?_addUrl_&pn=' . $previous . '"> <i class="fa fa-chevron-left"></i></a></li>';
        for ($i = $pn - 4; $i < $pn; $i++) {
            if ($i > 0) {
                $paginacao.= '<li><a href="' . $_SERVER['PHP_SELF'] . '?_addUrl_&pn=' . $i . '">'.$i.'</a></li>';
            }
        }
    }
    $paginacao.= '<li class="active"><a href="javascript:void(0)">'.$pn.'</a></li>';
    for ($i = $pn + 1; $i <= $ultimaPagina; $i++) {
        $paginacao.= '<li><a href="' . $_SERVER['PHP_SELF'] . '_addUrl_&pn=' . $i . '">'.$i.'</a></li>';
        if ($i >= $pn + 4) {
            break;
        }
    }
    if ($pn != $ultimaPagina) {
        $next = $pn + 1;
        $paginacao.='<li class="next"><a href="' . $_SERVER['PHP_SELF'] . '_addUrl_&pn=' . $next . '"> <i class="fa fa-chevron-right"></i></a></li>';
    }
}
if($paginacao!=""){
$paginacao='<div class="block-section">
                <div class="text-center">
                    <ul class="pagination  remove-margin">
                        '.$paginacao.'
                    </ul>
                </div>
            </div>';
}
$res='      <div class="col-lg-12" style="padding-bottom: 5px">
                   <small> Página <b>_pn_</b> de _ultimaPagina_</small>
                   <small class="pull-right"> <b>_tr_</b> registos encontrados.<br>
                   <a href="index.php?excel=1_addUrl_" class="btn btn-success btn-xs pull-right hidden" data-toggle="tooltip" title="Descarrega todos os resultados num ficheiro .xls. (Respeita os filtros)"><i class="fa fa-file-excel-o"></i> Exportar</a>
</small>
                </div> _resultados_';
$res=str_replace("_pn_",$pn,$res);
$res=str_replace("_tr_",$tr,$res);
$res=str_replace("_ultimaPagina_",$ultimaPagina,$res);
$content=str_replace("_resultados_",$res,$content);
if(isset($pre_url)){
    $paginacao=str_replace("_addUrl_","_addUrl_&nomeTabela=$nomeTabela",$paginacao);
    $paginacao=str_replace("?_addUrl_","_addUrl_&nomeTabela=$nomeTabela",$paginacao);
}

