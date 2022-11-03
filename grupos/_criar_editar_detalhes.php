<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 26/03/2018
 * Time: 19:07
 */

$sql_preencher="select * from grupos where ativo=1";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {
    $ops.="<option class='grupos' value='".$row_preencher["id_grupo"]."'>".$row_preencher["nome_grupo"]."</option>";
}
$content=str_replace("_grupos_",$ops,$content);


$linhaPrincipal='<div class="col-xs-6 col-sm-3 col-lg-2">
                        <ul class="toggle-menu">
                            <li class="">
                                <a data-toggle="tooltip" title="" data-original-title="_descricao_" href="javascript:void(0)" class="submenu text-primary"><i class="fa fa-angle-right"></i>  <span class="fa _icon_"></span> _nome_ </a>
                                <ul>
                                    _linhas_
                                    _submodulos_
                                </ul>
                            </li>
                        </ul>
                    </div>';
$linhaSecundaria='<li style="margin-left: 30px" data-toggle="tooltip" title="" data-placement="left" data-original-title="_descricao_">
                        <label class="csscheckbox csscheckbox-primary _desativo_">
                            <input type="checkbox" class="paraSelecionar" name="funcionalidades[]" value="_idModulo_|_id_">
                                <span></span> 
                                <i class=\'fa _icon_\'></i> 
                                _nome_
                        </label> 
                    </li>';

$linhaSub='<li class="open" style="padding-left: 30px">
                            <a data-toggle="tooltip" title="" data-original-title="_descricao_" href="javascript:void(0)" class="submenu text-primary"><i class="fa fa-angle-right"></i>  <span class="fa _icon_"></span> _nome_ </a>
                            <ul>
                                    _linhas_
                                    _submodulos_
                            </ul>
                        </li>';

$ListaModulos="";
foreach ($_SESSION['modulos'] as $modulo){
    //if($modulo['mostrar']==1 and $modulo['id_parent']==0){
    if($modulo['id_parent']==0){
        $ListaModulos.=$linhaPrincipal;
        $ListaModulos=str_replace("_nome_",($modulo['nome_modulo']),$ListaModulos);
        $ListaModulos=str_replace("_icon_",($modulo['icon']),$ListaModulos);
        $ListaModulos=str_replace("_descricao_",($modulo['descricao']),$ListaModulos);
        if($modulo['ativo']==0){
            $ListaModulos=str_replace("_desativo_","text-muted",$ListaModulos);
        }else{
            $ListaModulos=str_replace("_desativo_","",$ListaModulos);
        }
        $funcionalidades="";
        foreach ($modulo['funcionalidades'] as $func){
            $funcionalidades.=$linhaSecundaria;
            $funcionalidades=str_replace("_nome_",($func['nome_funcionalidade']),$funcionalidades);
            $funcionalidades=str_replace("_id_",($func['id_funcionalidade']),$funcionalidades);
            $funcionalidades=str_replace("_icon_",($func['icon']),$funcionalidades);
            $funcionalidades=str_replace("_descricao_",($func['descricao']),$funcionalidades);
            if($func['ativo']==0){
                $funcionalidades=str_replace("_desativo_","text-muted",$funcionalidades);
            }else{
                $funcionalidades=str_replace("_desativo_","",$funcionalidades);
            }
        }
        $ListaModulos=str_replace("_linhas_",$funcionalidades,$ListaModulos);
        $ListaModulos=str_replace("_idModulo_",($modulo['id_modulo']),$ListaModulos);

        $submodulos=RecursiveSubModulos($linhaSub,$linhaSecundaria,$_SESSION['modulos'],$modulo['id_modulo']);

        $ListaModulos=str_replace("_submodulos_",$submodulos,$ListaModulos);
    }
}
$content=str_replace("_modulos_",$ListaModulos,$content);