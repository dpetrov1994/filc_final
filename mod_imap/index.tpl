<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-section row">


                <form id="form-pagina" action="_formAction__addUrl_" method="get">
                    <input type="hidden" class="" id="id" name="id"  value="_id_">
                    <div class="form-group col-xs-6 col-lg-1">
                        Mostrar
                        <select onchange="document.getElementById('form-pagina').submit()" id="pr" name="pr" class="select-select2" style="width: 100%;" data-placeholder="Selecione..">
                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            _prs_
                        </select>
                    </div>
                    <div class="form-group col-xs-6 col-lg-2 ">
                        Ordenar
                        <select onchange="document.getElementById('form-pagina').submit()" id="o" name="o"  class="select-select2 input-sm" style="width: 100%;" data-placeholder="Selecione..">
                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            _ordenar_
                        </select>
                    </div>
                    <div class="form-group col-xs-6 col-lg-3 ">
                        Remetente
                        <select onchange="document.getElementById('form-pagina').submit()" id="de_email" name="de_email"  class="select-select2 input-sm" style="width: 100%;" data-placeholder="Selecione..">
                            <option value="todos">Todos</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            _deEmail_
                        </select>
                    </div>
                    <div class="form-group col-xs-6 col-lg-3 ">
                        Destinatário
                        <select onchange="document.getElementById('form-pagina').submit()" id="para_email" name="para_email"  class="select-select2 input-sm" style="width: 100%;" data-placeholder="Selecione..">
                            <option value="todos">Todos</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            _paraEmail_
                        </select>
                    </div>
                    <div class="form-group col-xs-6 col-lg-3 ">
                        Estado
                        <select onchange="document.getElementById('form-pagina').submit()" id="lido" name="lido"  class="select-select2 input-sm" style="width: 100%;" data-placeholder="Selecione..">
                            <option value="todos">Todos</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            _lido_
                        </select>
                    </div>
                    <div class="form-group form-group-sm col-xs-12 col-lg-6">
                        <span class="hidden-xs">Entre datas</span>
                        <div class="input-group input-group-xs" style="width: 100%">
                            <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                <input id="data_inicio" name="data_inicio" value="_data_inicio_" class="form-control" placeholder="Data início" type="text">
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input id="data_fim" name="data_fim" value="_data_fim_" class="form-control" placeholder="Data fim" type="text">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-effect-ripple btn-primary btn-sm" style="overflow: hidden; position: relative;"><i class="fa fa-search"></i> <span class="hidden-xs"></span></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-xs-12 col-lg-6">
                        <span class="hidden-xs">Pesquisa</span>
                        <div class="input-group input-group-sm">
                            <input id="example-input2-group2" value="_p_" name="p" class="form-control" placeholder="Pesquisar.." type="text">
                            <span class="input-group-btn">
                            <button type="submit" class="btn btn-effect-ripple btn-primary" style="overflow: hidden; position: relative;"><i class="fa fa-search"></i> </button>
                        </span>
                        </div>
                    </div>

                </form>
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

