<div class="row" id="paraPDF">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-section row">


                <form id="form-pagina" action="_formAction__addUrl_" method="get">
                    <input type="hidden" class="" id="PartyID" name="PartyID"  value="_PartyID_">


                    <div class="col-lg-12 text-center">
                        <h3 style="margin: 0px;" class=" text-primary">Histórico de serviços c/iva </h3>
                    </div>

                    <div class="col-lg-4 text-center" style="font-size: 20px;line-height: 20px">
                        <h4  class=" text-primary">Empresa:<br> <b>_empresa_</b></h4>
                    </div>

                    <div class="col-lg-4 text-center" style="font-size: 20px;line-height: 20px">
                        <b>_alfabetico_</b><br>
                        _NomesDasEmpresas_
                        <small class="text-muted"><br><span id="nif">_FederalTaxID_</span></small>
                        <br><a class="btn btn-primary btn-xs" style="font-size: 12px" href="../mod_srvcliente/detalhes.php?id=_PartyID_"> Ver cliente </a>
                    </div>



                    <div class="col-lg-4 text-center" style="font-size: 20px;line-height: 20px">
                        <h4 class=" text-primary">ANO:<br> <b>_ano_</b></h4>
                    </div>



                </form>
            </div>

            <div class="text-right">
                <a class="btn btn-primary btn-xs" style="font-size: 12px" href="index.php_addUrl_&pdf=1"> <i class="fa fa-print"></i> Imprimir PDF </a>

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

