<?php
include("../_funcoes.php");
include("../conf/dados_plataforma.php");
include("../login/valida.php");

$db=ligarBD("ajax");
$output="";


if(isset($_GET['id_assistencia'])){
    $id=$db->escape_string($_GET['id_assistencia']);
    $content="
                <div class=\"row\">
                    <div class=\"col-lg-12\">
                        <div class=\"block\" id=\"tabs\">
                            <div class=\"\">
                                <ul class=\"nav nav-tabs\" data-toggle=\"tabs\">
                                    _tabLinks_
                                </ul>
                            </div>
                            <!-- END Block Tabs Title -->
                
                            <!-- Tabs Content -->
                            <div class=\"tab-content\">
                                _tabContents_
                            </div>
                        </div>
                    </div>
                </div>
";
    $content=str_replace("_idagenda_",$id,$content);

    $tabLinks="";
    $tabContents="";
    foreach ($_SESSION['modulos'] as $modulo){
        if($modulo['url']=='mod_assistencias'){
            foreach ($modulo['funcionalidades'] as $funcionalidade){
                if($funcionalidade['url']=="detalhes.php" and $funcionalidade['disponivel']==1){
                    $tabLinks.="<li class=\"active\"><a href=\"#tab-detalhes\"><i class=\"fa fa-list-alt\"></i> Detalhes</a></li>";
                    $tabContents.="<div class=\"tab-pane active\" id=\"tab-detalhes\">
                    <form id=\"desativar-inputs\" class=\"form-horizontal form-bordered\">
                       <div class=\"form-group form-group-sm\">
                    <div class=\"col-xs-6 col-md-6\">
                        <label class=\"col-lg-12\" >Nome do agendamento </label>
                        <div class=\"col-lg-12 input-status\">
                            <input id=\"nome_agenda\" name=\"nome_agenda\" maxlength=\"250\"  class=\"form-control\" placeholder=\"\"  type=\"text\">
                        </div>
                    </div>

                    <div class=\"col-xs-6 col-md-6\">
                        <label class=\"col-lg-12\" >Cor (no calendário)</label>
                        <div class=\"col-lg-12 input-status\">
                            <div class=\"input-group input-colorpicker colorpicker-element\">
                                <input id=\"cor\" name=\"cor\" class=\"form-control\" value=\"#5ccdde\" type=\"text\">
                                <span class=\"input-group-addon\"><i style=\"background-color: #5ccdde;\"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=\"form-group form-group-sm\">


                    <div class=\"col-xs-12\">
                        <label class=\"col-lg-12\" >Data limite</label>
                        <div class=\"col-lg-12 input-status\">
                            <input id=\"data_fim\" name=\"data_fim\" required class=\"input-datepicker form-control\">
                        </div>
                    </div>
                    
                </div>
                <div class=\"form-group form-group-sm\">
                    <div class=\"col-xs-12\">
                        <label class=\"col-lg-12\" >Descrição </label>
                        <div class=\"col-lg-12\">
                            <textarea id=\"descricao\" rows=\"10\" name=\"descricao\" class=\"form-control\">_descricao_</textarea>
                        </div>
                    </div>
                </div>
                

                    </form>
                </div>";
                }
                if($funcionalidade['url']=="editar.php" and $funcionalidade['disponivel']==1){
                    $tabLinks.="
                    <li class=\"\"><a href=\"#tab-editar\"><i class=\"fa fa-edit\"></i> Editar</a></li>";
                    $tabContents.="
                    <div class=\"tab-pane\" id=\"tab-editar\">
                    <form id=\"form-editar-este\" class=\"form-horizontal form-bordered\" action=\"../mod_assistencias/editar.php?id=$id\" method=\"post\" enctype=\"multipart/form-data\">

                <div class=\"form-group form-group-sm\">
                    <div class=\"col-xs-6 col-md-6\">
                        <label class=\"col-lg-12\" >Nome do agendamento  </label>
                        <div class=\"col-lg-12 input-status\">
                            <input id=\"nome_agenda\" name=\"nome_agenda\" maxlength=\"250\"  class=\"form-control\" placeholder=\"\"  type=\"text\">
                        </div>
                    </div>

                    <div class=\"col-xs-6 col-md-6\">
                        <label class=\"col-lg-12\" >Cor (no calendário)</label>
                        <div class=\"col-lg-12 input-status\">
                            <div class=\"input-group input-colorpicker colorpicker-element\">
                                <input id=\"cor\" name=\"cor\" class=\"form-control\" value=\"#5ccdde\" type=\"text\">
                                <span class=\"input-group-addon\"><i style=\"background-color: #5ccdde;\"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=\"form-group form-group-sm\">


                    <div class=\"col-xs-12\">
                        <label class=\"col-lg-12\" >Data limite</label>
                        <div class=\"col-lg-12 input-status\">
                            <input id=\"data_fim\" name=\"data_fim\" required class=\"input-datepicker form-control\">
                        </div>
                    </div>
                   
                    
                </div>
                <div class=\"form-group form-group-sm\">
                    <div class=\"col-xs-12\">
                        <label class=\"col-lg-12\" >Descrição </label>
                        <div class=\"col-lg-12\">
                            <textarea id=\"descricao\" rows=\"10\" name=\"descricao\" class=\"form-control\">_descricao_</textarea>
                        </div>
                    </div>
                </div>
                


                <!-- fim itens do formulário-->

                <div class=\"form-group form-actions\">
                    <div class=\"col-lg-12\">
                        <button type=\"submit\" name=\"submit\" id=\"form-editar-este_botao_loading\" class=\"btn btn-effect-ripple btn-success pull-right btn-submit\" data-loading-text=\"<i class='fa fa-asterisk fa-spin'></i> Aguarde\">Concluir</button>
                        <button type=\"reset\" class=\"btn btn-effect-ripple btn-danger\">Limpar</button>
                    </div>
                </div>
            </form>
                </div>";
                }
                if($funcionalidade['url']=="reciclar.php" and $funcionalidade['disponivel']==1){
                    $tabLinks.="<li class=\"\"><a href=\"#tab-eliminar\"><i class=\"fa fa-trash\"></i> Eliminar</a></li>";
                    $tabContents.="<div class=\"tab-pane text-center\" id=\"tab-eliminar\"><br><br><a href='javascript:void(0)' onclick='$(\"#modal-detalhes-agenda\").modal(\"toggle\");confirmaModal(\"../mod_assistencias/reciclar.php?id=$id\")' class='btn btn-danger btn-effect-ripple' ><i class='fa fa-trash-o'></i> Eliminar</a><br><br></div>";
                }
            }
        }
    }
    $content=str_replace("_tabLinks_",$tabLinks,$content);
    $content=str_replace("_tabContents_",$tabContents,$content);

    $sql="select * from assistencias where id_assistencia='$id'";
    $result=runQ($sql,$db,"VERIFICAR EXISTENTE");
    if($result->num_rows!=0){
        while ($row = $result->fetch_assoc()) {
            /**Preenchimento dos itens do formulário*/

            include ("../mod_assistencias/_criar_editar_detalhes.php");

            /**FIM Preenchimento dos itens do formulário*/

            foreach ($row as $key=>$value){
                if(is_date($value)){
                    $value=strftime("%d/%m/%Y", strtotime($value));
                }

                if($value==1){ // para itens com cheked [ATENCAO: O NOME tem de vir antes do ID]
                    $content=str_replace('name="'.$key.'" id="'.$key.'"','name="'.$key.'" id="'.$key.'" checked=""',$content);
                }

                // PREENCHER OS CAMPOS NORMAILS [ATENCAO: O ID tem de vir antes do NOME]
                $content=str_replace('id="'.$key.'" name="'.$key.'"','id="'.$key.'" name="'.$key.'" value="'.$value.'"',$content);

                // PREENCHER OS SELECTS AUTOMATICOS
                $content=str_replace("class='".$key."' value='".$value."'","class='".$key."' value='".$value."' selected",$content);
            }
            $content = str_replace("_descricao_",$row['descricao'], $content);
            $content = str_replace("_hora_inicio_", strftime("%H:%M", strtotime($row['data_fim'])), $content);
            $content = str_replace("_hora_fim_", strftime("%H:%M", strtotime($row['data_fim'])), $content);


            $ativo="<span class='label label-success'>Não</span><br>".'<a href="javascript:void(0)" class="btn btn-warning btn-xs btn-effect-ripple" onclick="confirmaModal(\'reciclar.php?id='.$row['id_'.$nomeColuna].'\')"> <i class="fa fa-trash"></i> Mover para a reciclagem</a>';
        if($row['ativo']==0){
            $ativo="<span class='label label-warning'>Sim</span><br>".'<a href="javascript:void(0)" class="btn btn-info btn-xs btn-effect-ripple" onclick="confirmaModal(\'reciclar.php?id='.$row['id_'.$nomeColuna].'\')"> <i class="fa fa-backward"></i> Restaurar</a>';
        }
        $content=str_replace("_ativo_",$ativo,$content);

            $criated_at = strftime("%d/%m/%Y %H:%M:%S", strtotime($row['created_at']))." - ".humanTiming($row['created_at']);
            $content=str_replace("_dataCriado_",$criated_at,$content);
            if($row['updated_at'] !=null){
                $criated_at = strftime("%d/%m/%Y %H:%M:%S", strtotime($row['updated_at']))." - ".humanTiming($row['updated_at']);
                $content=str_replace("_dataAtualizado_",$criated_at,$content);
            }else{
                $content=str_replace("_dataAtualizado_","-",$content);
            }

            $id_editou=$row['id_editou'];
            $content=str_replace("_idAtualizou_",$id_editou,$content);
            $id_criou=$row['id_criou'];
            $content=str_replace("_idCriou_",$id_criou,$content);
        }

        /**Preenchimento dos itens do formulário*/


        /**FIM Preenchimento dos itens do formulário*/

        if($id_editou!=null){
            $sql="select nome_utilizador from utilizadores where id_utilizador=$id_editou";
            $result=runQ($sql,$db,"EDITOU");
            while ($row = $result->fetch_assoc()) {
                $content=str_replace("_nomeAtualizou_",removerHTML($row['nome_utilizador']),$content);
            }
        }else{
            $content=str_replace("_nomeAtualizou_","-",$content);
        }
        if($id_criou!=null) {
            $sql = "select nome_utilizador from utilizadores where id_utilizador=$id_criou";
            $result = runQ($sql, $db, "CRIOU");
            while ($row = $result->fetch_assoc()) {
                $content = str_replace("_nomeCriou_", removerHTML($row['nome_utilizador']), $content);
            }
        }else{
            $content=str_replace("_nomeCriou_","-",$content);
        }
    }
}
$output=$content;
print ($output);
$db->close();


