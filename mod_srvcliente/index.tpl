<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-section row">

                <form id="form-pagina" action="_formAction__addUrl_" method="get">
                    <input type="hidden" class="" id="id" name="id"  value="_id_">
                    <div class="form-group col-xs-12 col-lg-12">
                        <div class="input-group input-group-sm">
                            <span class="hidden-xs">Pesquisa</span>
                            <input id="example-input2-group2" value="_p_" name="p" class="form-control" placeholder="Pesquisar.." type="text">
                            <span class="input-group-btn" style="    vertical-align: bottom;">
                              <button type="submit" class="btn btn-effect-ripple btn-primary" style="overflow: hidden; position: relative;"><i class="fa fa-search"></i> <span class="hidden-xs"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-xs-6 col-lg-3">
                        Mostrar
                        <select onchange="document.getElementById('form-pagina').submit()" id="pr" name="pr" class="select-select2" style="width: 100%;" data-placeholder="Selecione..">
                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            _prs_
                        </select>
                    </div>
                    <div class="form-group col-xs-6 col-lg-3 ">
                            Ordenar
                            <select onchange="document.getElementById('form-pagina').submit()" id="o" name="o"  class="select-select2 input-sm" style="width: 100%;" data-placeholder="Selecione..">
                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                _ordenar_
                            </select>
                    </div>
                    <div class="form-group col-xs-6 col-lg-2 ">
                            País
                            <select onchange="document.getElementById('form-pagina').submit()" id="pais" name="pais"  class="select-select2 input-sm" style="width: 100%;" data-placeholder="Selecione..">
                                <option value="todos">Todos</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                _paises_
                            </select>
                    </div>
                    <div class="form-group col-xs-6 col-lg-2">
                            Valor Pendente?
                            <select onchange="document.getElementById('form-pagina').submit()" id="pendente" name="pendente"  class="select-select2 input-sm" style="width: 100%;" data-placeholder="Selecione..">
                                <option value="todos">Todos</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                _pendente_
                            </select>
                    </div>
                    <div class="form-group col-xs-6 col-lg-2 ">
                        Classificação
                        <select onchange="document.getElementById('form-pagina').submit()" id="classificacaoFiltro" name="classificacaoFiltro"  class="select-select2 input-sm" style="width: 100%;" data-placeholder="Selecione..">
                            <option value="todos">Todos</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            _classificacaoFiltro_
                        </select>
                    </div>

                </form>
            </div>


            <div class="row hidden">
                <div class="col-lg-12">
                    <div class="text-center">
                        <a class="btn btn-primary btn-xs" href="_formAction__addUrl_&excel">Gerar Excel</a>
                    </div>
                </div>
            </div>

            <form id="form-acao-varios" method="post" action="">
                <div class="">
                    _resultados_
                </div>
            </form>
            _paginacao_
             _funcionalidadesMultiplos_
        </div>
    </div>
</div>

