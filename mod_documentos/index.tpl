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
                    <div class="form-group col-xs-6 col-lg-3 ">
                        Ordenar
                        <select onchange="document.getElementById('form-pagina').submit()" id="o" name="o"  class="select-select2 input-sm" style="width: 100%;" data-placeholder="Selecione..">
                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            _ordenar_
                        </select>
                    </div>


                    <div class="form-group col-xs-6 col-lg-3 ">
                        Entidade
                        <select onchange="document.getElementById('form-pagina').submit()" id="id_cliente" name="id_cliente"  class="select-select2 input-sm" style="width: 100%;">
                            <option value="">Todos</option>
                            _clientes_
                        </select>
                    </div>

                    <div class="form-group col-xs-6 col-lg-3 ">
                        Tipo de Documento
                        <select onchange="document.getElementById('form-pagina').submit()" id="TransDocument" name="TransDocument"  class="select-select2 input-sm" style="width: 100%;">
                            <option value="">Todos</option>

                            _tipoDoc_
                        </select>
                    </div>

                    <div class="form-group col-xs-6 col-lg-2">
                        Serie do Documento
                        <select onchange="document.getElementById('form-pagina').submit()" id="TransSerial" name="TransSerial"  class="select-select2 input-sm" style="width: 100%;">
                            <option value="">Todas</option>
                            _serieDoc_
                        </select>
                    </div>

                    <div class="form-group col-xs-6 col-lg-2">
                        Ano
                        <select onchange="document.getElementById('form-pagina').submit()" id="ano" name="ano"  class="select-select2 input-sm" style="width: 100%;">
                            <option value="">Todos</option>
                            _anos_
                        </select>
                    </div>


                    <div class="form-group form-group-sm col-xs-12 col-lg-5">
                        <div style="display: flex; grid-column-gap: 5px">

                            <span class="hidden-xs">Entre datas </span>

                        </div>

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

                    <div class="form-group col-xs-12 col-lg-5">
                        <span class="hidden-xs">Pesquisa</span>
                        <div class="input-group input-group-sm">
                            <input id="example-input2-group2" value="_p_" name="p" class="form-control" placeholder="Pesquisar.." type="text">
                            <input id="example-input2-group2" value="srv_clientes" name="cols" class="form-control" placeholder="Pesquisar.." type="text" style="display: none">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-effect-ripple btn-primary" style="overflow: hidden; position: relative;"><i class="fa fa-search"></i> <span class="hidden-xs">Pesquisar</span></button>
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

