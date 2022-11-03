<div class="row">
    <div class="col-lg-12">
        <div class="block">

            <form id="form-para-validar" class="form-horizontal form-bordered" action="editar.php_addUrl_" method="post">
                <div class="form-group hidden">
                    <label class="col-md-3 control-label" >ID</label>
                    <div class="col-md-6">
                        <input id="id" name="id" class="form-control" placeholder="..."  value="_idParent_" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <h2>Dados de início de sessão</h2>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Estado da conta de utilizador</label>
                    <div class="col-md-6">
                        <select class="select-select2" style="width: 100%;" data-placeholder="Selecione.." name="ativo">
                            <option _op1Ativo_ value="1">Ativo (Com acesso)</option>
                            <option _op0Ativo_ value="0">Desativo (Sem acesso)</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Email</label>
                    <div class="col-md-6">
                        <b>_emailParent_</b> [<small><a href="enviar_email.php?id=_idParent_"><i class="fa fa-send-o"></i> Enviar Email de verificação</a></small>]<br>
                        <select class="select-select2" style="width: 100%;" data-placeholder="Selecione.." name="verificado">
                            <option _op1Estado_ value="1">Verificado</option>
                            <option _op2Estado_ value="2">Não verificado</option>
                        </select>
                        <a href="alterar_email.php?id=_idParent_"> Alterar Email</a>

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Palavra-passe</label>
                    <div class="col-md-6">
                        <a href="alterar_pass.php?id=_idParent_"> Definir uma nova palavra-passe</a>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <h2>Dados adicionais</h2>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Fotografia</label>
                    <div class="col-md-6">
                        <img class="img-thumbnail-avatar" src="../_contents/fotos_utilizadores/_foto_"> <i class="fa fa-pencil"></i>
                        <a href="alterar_foto.php?id=_idParent_"> Alterar fotografia</a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Nome <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input id="nome" name="nome" maxlength="250" class="form-control" value="_nomeParent_" placeholder="..." type="text" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Cor na agenda <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <div class="input-group input-colorpicker colorpicker-element">
                            <input id="cor" name="cor" class="form-control" value="_cor_" type="text">
                            <span class="input-group-addon"><i style="background-color: #cb5519"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Mostrar no ecrã inicial <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <div class="input-group input-colorpicker colorpicker-element">
                                <label class="switch switch-primary">
                                    <input type="checkbox" name="mostrar_no_dashboard" id="mostrar_no_dashboard" value="1" >
                                    <span></span>
                                </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Técnico comercial <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <div class="input-group input-colorpicker colorpicker-element">
                                <label class="switch switch-primary">
                                    <input type="checkbox" name="comercial" id="comercial" value="1" >
                                    <span></span>
                                </label>
                        </div>
                    </div>
                </div>
                <!--
                <div class="form-group">
                    <label class="col-md-3 control-label" >Sexo <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <select id="sexo" name="sexo" class="select-select2 " data-placeholder="Sexo (selecione)" style="width: 100%;" required>
                            <option></option>
                            <option value="m">M</option>
                            <option value="f">F</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" >Data de nascimento <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input id="data_nascimento" name="data_nascimento"  class="form-control" value="_data_nascimento_" placeholder="..." type="date" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Contacto <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input id="contacto" name="contacto" maxlength="250" class="form-control" value="_contacto_" placeholder="..." type="text" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Contacto Alternativo <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input id="contacto_alternativo" name="contacto_alternativo" maxlength="250" class="form-control" value="_contactoAlternativo_" placeholder="..." type="text" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Contrinuinte <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input id="nif" name="nif" maxlength="250" class="form-control" value="_nif_" placeholder="..." type="text" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Morada <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input id="morada" name="morada" maxlength="250" class="form-control" value="_morada_" placeholder="..." type="text" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Código postal <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input id="cod_post" name="cod_post" maxlength="250" class="form-control" value="_cod_post_" placeholder="..." type="text" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Localidade <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input id="localidade" name="localidade" maxlength="250" class="form-control" value="_localidade_" placeholder="..." type="text" required>
                    </div>
                </div>
                -->

                <div class="form-group">
                    <label class="col-md-3 control-label" >Observações</label>
                    <div class="col-md-6">
                        <textarea id="obs" maxlength="1000" name="obs" class="form-control">_obsParent_</textarea>
                    </div>
                </div>


                <div class="">
                    _permissoes_
                </div>
                <div class="form-group form-actions">
                    <button type="submit" name="submit" id="botao_loading" class="btn btn-effect-ripple btn-success pull-right btn-submit" style="overflow: hidden; position: relative;" data-loading-text="<i class='fa fa-asterisk fa-spin'></i> Aguarde">Concluir</button>
                    <button type="reset" class="btn btn-effect-ripple btn-danger" >Limpar</button>
                </div>
            </form>
        </div>
    </div>
</div>