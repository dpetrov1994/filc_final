<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-section row">


                                        <form id="form-pagina" action="_formAction__addUrl_" method="get">
                    <input type="hidden" class="" id="id" name="id"  value="_id_">


                                            <div class="form-group col-xs-6 col-lg-2 ">
                                                Ordenar
                                                <select onchange="document.getElementById('form-pagina').submit()" id="o" name="o"  class="select-select2 input-sm" style="width: 100%;" data-placeholder="Selecione..">
                                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                                    _ordenar_
                                                </select>
                                            </div>
                                            <div class="form-group col-xs-4 col-lg-2 ">
                                                Tecnicos
                                                <select onchange="document.getElementById('form-pagina').submit()" id="id_utilizador" name="id_utilizador"  class="form-control input-sm" style="width: 100%;">
                                                    <option value="Todos" class="">Todos</option>
                                                    _utilizadores_
                                                </select>
                                            </div>
                                            <div class="form-group col-xs-4 col-lg-1 ">
                                                Categoria
                                                <select onchange="document.getElementById('form-pagina').submit()" id="id_categoria" name="id_categoria"  class="form-control input-sm" style="width: 100%;">
                                                    <option value="Todas" class="id_categoria">Todos</option>
                                                    _id_categoria_
                                                </select>
                                            </div>
                                            <div class="form-group col-xs-4 col-lg-2 ">
                                                Cliente
                                                <select onchange="document.getElementById('form-pagina').submit()" id="id_cliente" name="id_cliente"  class="select-select2 input-sm" style="width: 100%;">
                                                    <option value="Todas" class="id_cliente">Todos</option>
                                                    _id_cliente_
                                                </select>
                                            </div>

                                            <div class="form-group form-group-sm col-xs-12 col-lg-3">
                                                <div style="display: flex; grid-column-gap: 5px">

                                                    <span class="hidden-xs">Entre datas </span>
                                                    <!--(
                                                    <span class="hidden-xs" style="font-size: 12px; position: relative; top:-2px"> <input type="checkbox" id="data_vencimento" name="data_vencimento" value="1" style="position: relative;top:2px; margin-right: 2px"> Aplicar por Data de Vencimento </span>
                                                    )-->
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

                                            <div class="form-group col-xs-12 col-lg-2">
                                                <span class="hidden-xs">Pesquisa</span>
                                                <div class="input-group input-group-sm">
                                                    <input id="example-input2-group2" value="_p_" name="p" class="form-control" placeholder="Pesquisar.." type="text">
                                                    <span class="input-group-btn">
                            <button type="submit" class="btn btn-effect-ripple btn-primary" style="overflow: hidden; position: relative;"><i class="fa fa-search"></i></button>
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

