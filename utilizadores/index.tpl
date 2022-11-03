<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-section row">
                <div class="text-center"><a href="javascript:void(0)" class="btn btn-xs btn-primary mostra_filtros"><i class="fa fa-search"></i> Filtros/Pesquisa</a></div>

                                        <form id="form-pagina" action="_formAction__addUrl_" method="get">
                    <input type="hidden" class="" id="id" name="id"  value="_id_">
                    <div class="form-group col-xs-6 col-lg-2">
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
                    <div class="form-group col-xs-12 col-lg-8">
                        <span class="hidden-xs">Pesquisa</span>
                        <div class="input-group input-group-sm">
                            <input id="example-input2-group2" value="_p_" name="p" class="form-control" placeholder="Pesquisar.." type="text">
                            <span class="input-group-btn">
                            <button type="submit" class="btn btn-effect-ripple btn-primary" style="overflow: hidden; position: relative;"><i class="fa fa-search"></i> <span class="hidden-xs">Pesquisar</span></button>
                        </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Filtrar por grupo</label>
                        <select onchange="document.getElementById('form-pagina').submit()" id="grupo" name="grupo" class="select-select2" style="width: 100%;" >
                            <option value="0">Todos</option>
                            _grupos_
                        </select>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Estado de verificação do email</label>
                        <select onchange="document.getElementById('form-pagina').submit()" id="estado_email" name="estado_email" class="select-select2" style="width: 100%;" >
                            <option class='estado_email' value='0'>Todos</option>
                            <option class='estado_email' value='1'>Envio Pendente</option>
                            <option class='estado_email' value='2'>Verificação Pendente</option>
                            <option class='estado_email' value='3'>Verificado</option>
                        </select>
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

