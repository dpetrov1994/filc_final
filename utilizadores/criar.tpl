<div class="row">
    <div class="col-lg-12">
        <!--<div class="alert alert-info alert-dismissable _hidden_">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><strong><i class="fa fa-info-circle"></i> Informação</strong></h4>
            <p>Está prestes a criar uma conta de utilizador para o <b>_tipo_</b> _nome_utilizador_.</p>
        </div>-->
        <div class="block">
            <form id="form-para-validar" class="form-horizontal form-bordered" action="criar.php_addUrl_" method="post" enctype="multipart/form-data">

                <!-- colar aqui os itens do formulário-->


                <div class="form-group form-group-sm">
                    <div class="col-xs-6 col-lg-4">
                        <label class="col-lg-12" >Nome </label>
                        <div class="col-lg-12 input-status">
                            <input id="nome_utilizador" value="" name="nome_utilizador" maxlength="250"  class="form-control" placeholder=""  type="text">
                        </div>
                    </div>
                    <div class="col-xs-6 col-lg-4">
                        <label class="col-lg-12">E-mail</label>
                        <div class="col-lg-12">
                            <input id="email" name="email" value="" maxlength="250"  class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-xs-6 col-lg-4">
                        <label class="col-lg-12">Cor na agenda</label>
                        <div class="col-lg-12">
                            <div class="input-group input-colorpicker colorpicker-element">
                                <input id="cor" name="cor" class="form-control" value="#cb5519" type="text">
                                <span class="input-group-addon"><i style="background-color: #cb5519"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-xs-6">
                        <label class="col-lg-12">Palavra-passe (<small><a href="javascript:void(0)" onclick="mostrarPass()" id="bnt_mostrar_pass"><i class="fa fa-eye"></i> Mostrar</a></small>)</label>
                        <div class="col-lg-12">
                            <input id="pass" name="pass" required maxlength="250"  class="form-control" type="password">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="col-lg-12" >Repita palavra-passe</label>
                        <div class="col-lg-12">
                            <input id="pass2" maxlength="250" name="pass2" class="form-control" placeholder="" type="password">
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-xs-12 text-center">
                        <button type="button" onclick="gerarPass()" class="btn btn-info">Gerar Palavra-passe</button>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <label class="col-lg-12" >Observações </label>
                        <div class="col-lg-12">
                            <textarea id="obs" rows="10" name="obs" class="form-control">_descricao_</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <label class="col-lg-12" >Membro de</label>
                        <div class="col-lg-12">
                            <select id="grupos" name="grupos[]" class="select-select2" style="width: 100%;" data-placeholder="Selecione..">
                                _grupos_
                            </select>
                        </div>
                    </div>
                </div>
             
                <!-- fim itens do formulário-->

                <div class="form-group form-actions">
                    <div class="col-lg-12">
                        <span class="pull-right">
                            <b class="hidden" style="cursor: pointer" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="Envia um email de boas vindas que contém a hiperligação para ativar a conta."><i class="fa fa-question-circle text-info"></i> Enviar email de verificação <label class="switch switch-primary"><input type="checkbox" name="notificar"> <span></span> </label></b>
                            <button type="submit" name="submit" id="botao_loading" class="btn btn-effect-ripple btn-success btn-submit" data-loading-text="<i class='fa fa-asterisk fa-spin'></i> Aguarde">Concluir</button>

                        </span>
                       <button type="reset" class="btn btn-effect-ripple btn-danger">Limpar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>