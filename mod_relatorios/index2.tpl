<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-section row">
                <form id="form-pagina"  action="_formAction__addUrl_" method="get">
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
                            <button type="submit" class="btn btn-effect-ripple btn-primary" style="overflow: hidden; position: relative;"><i class="fa fa-search"></i></button>
                        </span>
                        </div>
                    </div>
                </form>
            </div>

            <div class="block-section row">

            _funcionalidadesMultiplos_
<form id="form-acao-varios" method="post" action="">
                <div class="table-responsive">
                    _resultados_
                </div>
            </form>
            _paginacao_
             _funcionalidadesMultiplos_
        </div>
    </div>
</div>

