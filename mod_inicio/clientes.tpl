<style>
    .widget {
        margin-bottom: 5px !important;
    }
</style>

<div class="row">
    <div class="col-lg-6">
        <div class="block">
            <div class="block-title"><h4>Ocupação total por cliente</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group form-group-sm">
                        <div class="input-group input-group-xs" style="width: 100%">
                            <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                <input id="inicio_ocupacao_cliente" name="inicio_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Início" type="text">
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input id="fim_ocupacao_cliente" name="fim_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Fim" type="text">
                                <span class="input-group-btn">
                                        <button type="submit" onclick="ocupacao_cliente()" class="btn btn-effect-ripple btn-primary btn-sm" style="overflow: hidden; position: relative;"><i class="fa fa-angle-right"></i> <span class="hidden-xs"></span></button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div id="ocupacao_cliente"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="block">
            <div class="block-title"><h4>Tempo total por cliente</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group form-group-sm">
                        <div class="input-group input-group-xs" style="width: 100%">
                            <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                <input id="inicio_tempo_cliente" name="inicio_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Início" type="text">
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input id="fim_tempo_cliente" name="fim_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Fim" type="text">
                                <span class="input-group-btn">
                                        <button type="submit" onclick="tempo_cliente()" class="btn btn-effect-ripple btn-primary btn-sm" style="overflow: hidden; position: relative;"><i class="fa fa-angle-right"></i> <span class="hidden-xs"></span></button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div id="tempo_cliente"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="block">
            <div class="block-title"><h4>Percentagem de faturação por cliente</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group form-group-sm">
                        <div class="input-group input-group-xs" style="width: 100%">
                            <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                <input id="inicio_percentagem_faturacao_cliente" name="inicio_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Início" type="text">
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input id="fim_percentagem_faturacao_cliente" name="fim_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Fim" type="text">
                                <span class="input-group-btn">
                                        <button type="submit" onclick="percentagem_faturacao_cliente()" class="btn btn-effect-ripple btn-primary btn-sm" style="overflow: hidden; position: relative;"><i class="fa fa-angle-right"></i> <span class="hidden-xs"></span></button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div id="percentagem_faturacao_cliente"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="block">
            <div class="block-title"><h4>Faturação total por cliente</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group form-group-sm">
                        <div class="input-group input-group-xs" style="width: 100%">
                            <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                <input id="inicio_faturacao_cliente" name="inicio_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Início" type="text">
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input id="fim_faturacao_cliente" name="fim_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Fim" type="text">
                                <span class="input-group-btn">
                                        <button type="submit" onclick="faturacao_cliente()" class="btn btn-effect-ripple btn-primary btn-sm" style="overflow: hidden; position: relative;"><i class="fa fa-angle-right"></i> <span class="hidden-xs"></span></button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div id="faturacao_cliente"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="block">
            <div class="block-title"><h4>Top 10 pendente por cliente</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <div>_totalPendentes_</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="block">
            <div class="block-title"><h4>Top 10 crédito por cliente</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <div>_totalCredito_</div>
                </div>
            </div>
        </div>
    </div>
</div>