<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form id="form-para-validar" class="form-horizontal form-bordered" action="criar.php_addUrl_" method="post" enctype="multipart/form-data">                <!-- colar aqui os itens do formulário-->                <div class="form-group">
                    <div class="col-xs-6 col-lg-4">
                        <label class="col-lg-12" >Nome da funcionalidade</label>
                        <div class="col-lg-12">
                            <input id="nome_funcionalidade" name="nome_funcionalidade" maxlength="250" class="form-control" placeholder="..." type="text">
                        </div>
                    </div>
                    <div class="col-xs-6 col-lg-4">
                        <label class="col-lg-12">Caminho / URL</label>
                        <div class="col-lg-12">
                            <input id="url" name="url" class="form-control" placeholder="eg: index.php" type="text">
                        </div>
                    </div>
                    <div class="col-xs-6 col-lg-4">
                        <label class="col-lg-12">Ordem</label>
                        <div class="col-lg-12">
                            <input id="ordem" name="ordem" class="form-control" placeholder="" type="number" step="1">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label class="col-lg-12"> Icon (font-awesome)</label>
                        <div class="col-lg-12">
                            <input id="icon" name="icon" class="form-control" placeholder="eg: fa-cube" type="text">
                            <small><a href="_layoutDirectory_/icons.html" target="_blank"> Mostrar icons disponiveis</a></small>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="col-lg-12" >Quem pode aceder a esta funcionalidade</label>
                        <div class="col-lg-12">
                            <select id="grupos" multiple name="grupos[]" class="select-select2" style="width: 100%;" data-placeholder="Selecione..">
                                <option disabled></option>
                                _grupos_
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-3 col-xs-6 text-center">
                        <div class="col-lg-12">
                            <label>Mostrar apenas em Reciclagem<br>
                                <label class="switch switch-primary">
                                    <input type="hidden" name="so_em_reciclagem" value="0">
                                    <input type="checkbox" name="so_em_reciclagem" id="so_em_reciclagem" value="1" >
                                    <span></span>
                                </label>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6 text-center">
                        <div class="col-lg-12">
                            <label>Mostrar sub-menu<br>
                                <label class="switch switch-primary">
                                    <input type="hidden" name="mostrar_subMenu" value="0">
                                    <input type="checkbox" name="mostrar_subMenu" id="mostrar_subMenu" value="1" >
                                    <span></span>
                                </label>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="col-lg-12" >Nome diferente em reciclagem</label>
                        <div class="col-lg-12">
                            <input id="nome_em_reciclagem" name="nome_em_reciclagem" class="form-control" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label class="col-lg-12" >Descrição</label>
                        <div class="col-lg-12">
                            <textarea id="descricao" name="descricao" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                </div>                <div class="form-group">
                    <div class="col-sm-3 col-xs-6 text-center">
                        <div class="col-lg-12">
                            <label>Mostrar no menu
                                <br><small class="text-muted">secundario lateral</small><br>
                            <label class="switch switch-primary">
                                <input type="hidden" name="mostrar" value="0">
                                <input type="checkbox" name="mostrar" id="mostrar" value="1" >
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6 text-center">
                        <label>Pedir confirmação <br><small class="text-muted"> com modal</small><br>
                        <label class="switch switch-primary">
                            <input type="hidden" name="confirmar" value="0">
                            <input type="checkbox" name="confirmar" id="confirmar" value="1" >
                            <span></span>
                        </label>
                    </div>
                    <div class="col-sm-3 col-xs-6 text-center">
                        <label>Mostrar no dropdown  <br><small class="text-muted">secundario</small><br>
                        <label class="switch switch-primary">
                            <input type="hidden" name="mostrarDropdown" value="0">
                            <input type="checkbox" name="mostrarDropdown" id="mostrarDropdown" value="1" >
                            <span></span>
                        </label>
                    </div>
                    <div class="col-sm-3 col-xs-6 text-center">
                        <label>Suporta multiplos itens <br><small class="text-muted">selecionados</small><br>
                        <label class="switch switch-primary">
                            <input type="hidden" name="multiplos" value="0">
                            <input type="checkbox" name="multiplos" id="multiplos" value="1" >
                            <span></span>
                        </label>
                    </div>
                </div>                <!-- fim itens do formulário-->                <div class="form-group form-actions">
                    <div class="col-lg-12">
                        <button type="submit" name="submit" id="botao_loading" class="btn btn-effect-ripple btn-success pull-right btn-submit" data-loading-text="<i class='fa fa-asterisk fa-spin'></i> Aguarde">Concluir</button>
                        <button type="reset" class="btn btn-effect-ripple btn-danger">Limpar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>