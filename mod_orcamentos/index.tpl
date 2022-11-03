<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-section row">


                <form id="form-pagina" action="_formAction__addUrl_" method="get">
                    <input type="hidden" class="" id="id" name="id"  value="_id_">
                    <div class="form-group col-xs-4 col-lg-2">
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
                        Cliente
                        <select onchange="document.getElementById('form-pagina').submit()" id="cliente" name="cliente"  class="select-select2 input-sm" style="width: 100%;">
                            <option value="todos">Todos</option>
                            _clientes_
                        </select>
                    </div>

                    <div class="form-group form-group-sm col-xs-12 col-lg-5">
                        <span class="hidden-xs">Entre datas</span>
                        <div class="input-group input-group-xs" style="width: 100%">
                            <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                <input id="data_inicio" name="data_inicio" value="_data_inicio_" class="form-control" autocomplete="off" placeholder="Data Início" type="text">
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input id="data_fim" name="data_fim" value="_data_fim_" class="form-control" autocomplete="off" placeholder="Data Fim" type="text">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-effect-ripple btn-primary btn-sm" style="overflow: hidden; position: relative;"><i class="fa fa-search"></i> <span class="hidden-xs"></span></button>
                                </span>
                            </div>
                        </div>
                    </div>

                  <!--  <div class="form-group col-xs-6 col-lg-3 ">
                        Empleado
                        <select onchange="document.getElementById('form-pagina').submit()" id="funcionario" name="funcionario"  class="select-select2 input-sm" style="width: 100%;">
                            <option tipo class="todos" value="todos">Todos</option>
                            _funcionarios_
                        </select>
                    </div>
                    <div class="form-group col-xs-6 col-lg-2 ">
                        Tipo
                        <select onchange="document.getElementById('form-pagina').submit()" id="tipo" name="tipo"  class="select-select2 input-sm" style="width: 100%;">
                            <option tipo class="todos" value="todos">Todos</option>
                            <option selected tipo class="abertos" value="abertos">Sin venta</option>
                            <option tipo class="fechados" value="fechados">Con venta</option>
                        </select>
                    </div>
-->

                    <div class="form-group col-xs-12 col-lg-12">
                        <span class="hidden-xs">Pesquisar</span>
                        <div class="input-group input-group-sm">
                            <input id="example-input2-group2" value="_p_" name="p" class="form-control" placeholder="Buscar.." type="text">
                            <span class="input-group-btn">
                            <button type="submit" class="btn btn-effect-ripple btn-primary" style="overflow: hidden; position: relative;"><i class="fa fa-search"></i> <span class="hidden-xs">Pesquisar</span></button>
                        </span>
                        </div>
                    </div>



                </form>
            </div>
            <form id="form-acao-varios" method="post" action="">
                <div class="overflow-x-mobile">
                    _resultados_
                </div>
            </form>
            _paginacao_
             _funcionalidadesMultiplos_
        </div>
    </div>
</div>



<!-- Large modal -->

<div class="modal fade bd-example-modal-lg" id="modal_orc_to_fac" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-header" style="color:#fff;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity: 1; color:#fff; font-size:30px;">&times;</button>
            <h3 class="modal-title"><strong>Seleccione la tienda que realizó la venta</strong></h3>
        </div>
        <div class="modal-content" style="min-height: 170px">

            <form id="form-para-validar"  class="form-horizontal form-bordered" action="orc_to_fac.php?id=_idItem_" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="block"  style="margin-bottom: 200px">


                            <div class="col-xs-12"  style="padding-top: 50px;">
                                <input class="form-control" id="id_documento" style="display: none" readonly name="id">
                                <label class="col-lg-12" > Tiendas </label>
                                <div class="col-lg-12" >
                                    <select style="width: 100%;margin-bottom: 20px;" id="lojas" name="loja" class="select-select2 not-disable" required>_lojas_</select>
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin: 100px 0px 20px 0;">
                                <button type="submit" name="submit" class="btn btn-effect-ripple btn-primary pull-right">Concluir</button>
                                <button class="btn btn-effect-ripple btn-primary pull-left" type="button" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">

        </div>
    </div>
</div>
