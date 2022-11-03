<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form id="form-para-validar" class="form-horizontal form-bordered" action="editar.php_addUrl_" method="post" enctype="multipart/form-data">

                <!-- colar aqui os itens do formulário-->

                <div class="form-group form-group-sm">
                    <div class="col-xs-6">
                        <label class="col-lg-12">Nome do módulo</label>
                        <div class="col-lg-12">
                            <input id="nome_modulo" name="nome_modulo" class="form-control" placeholder="..." type="text">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="col-lg-12">Caminho / URL</label>
                        <div class="col-lg-12">
                            <input id="url" name="url" class="form-control" placeholder="eg: mod_modulos" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-xs-6">
                        <label class="col-lg-12">Icon (font-awesome)</label>
                        <div class="col-lg-12">
                            <input id="icon" name="icon" class="form-control" placeholder="eg: fa-cube" type="text">
                            <small><a href="_layoutDirectory_/icons.html" target="_blank"> Mostrar icons disponiveis</a></small>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="col-lg-12">Nome da tabela</label>
                        <div class="col-lg-12">
                            <input id="nomeTabela" name="nomeTabela" class="form-control" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-xs-6">
                        <label class="col-lg-12">Nome da coluna</label>
                        <div class="col-lg-12">
                            <input id="nomeColuna" name="nomeColuna" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="col-lg-12">Submódulo de:</label>
                        <div class="col-lg-12">
                            <select id="id_parent" name="id_parent" class="select-select2" style="width: 100%;" data-placeholder="Selecione..">
                                <option value="0">Nenhum</option>
                                _id_parent_
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <label class="col-lg-12" >Descrição do módulo e das suas funcionalidades</label>
                        <div class="col-lg-12">
                            <textarea id="descricao" rows="10" name="descricao" class="form-control">_descricao_</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <div class="col-sm-6 text-center">
                        <div class="col-lg-12">
                            <label>Mostrar no menu</label>
                            <small class="text-muted">Primário</small><br>
                            <label class="switch switch-primary">
                                <input type="hidden" name="mostrar" value="0">
                                <input type="checkbox" name="mostrar" id="mostrar" value="1" >
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6 text-center">
                        <label>É um módulo principal</label> <small class="text-muted">Index/dashboard</small><br>
                        <label class="switch switch-primary">
                            <input type="hidden" name="principal" value="0">
                            <input type="checkbox" name="principal" id="principal" value="1" >
                            <span></span>
                        </label>
                    </div>
                </div>

                <!-- fim itens do formulário-->

                <div class="form-group form-actions">
                    <div class="col-lg-12">
                        <button type="submit" name="submit" id="botao_loading" class="btn btn-effect-ripple btn-success pull-right btn-submit" data-loading-text="<i class='fa fa-asterisk fa-spin'></i> Aguarde">Concluir</button>
                        <button type="reset" class="btn btn-effect-ripple btn-danger">Limpar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>