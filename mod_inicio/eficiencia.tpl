<style>
    .widget {
        margin-bottom: 5px !important;
    }
</style>

<!-- Estados dos tecnicos -->
<div class="row">

    <div class="col-lg-6">
        <div class="block">
            <div class="block-title"><h4>Eficiência por dia</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group form-group-sm">
                        <div class="input-group input-group-xs" style="width: 100%">
                            <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                <input id="inicio_eficiencia_dia" name="inicio_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Início" type="text">
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input id="fim_eficiencia_dia" name="fim_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Fim" type="text">
                                <span class="input-group-btn">
                                        <button type="submit" onclick="eficiencia_dia()" class="btn btn-effect-ripple btn-primary btn-sm" style="overflow: hidden; position: relative;"><i class="fa fa-angle-right"></i> <span class="hidden-xs"></span></button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div id="eficiencia_dia"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="block">
            <div class="block-title"><h4>Tempos por dia</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group form-group-sm">
                        <div class="input-group input-group-xs" style="width: 100%">
                            <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                <input id="inicio_tempos_dia" name="inicio_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Início" type="text">
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input id="fim_tempos_dia" name="fim_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Fim" type="text">
                                <span class="input-group-btn">
                                        <button type="submit" onclick="tempos_dia()" class="btn btn-effect-ripple btn-primary btn-sm" style="overflow: hidden; position: relative;"><i class="fa fa-angle-right"></i> <span class="hidden-xs"></span></button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div id="tempos_dia"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="block">
            <div class="block-title"><h4>Ocupação por categoria</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group form-group-sm">
                        <div class="input-group input-group-xs" style="width: 100%">
                            <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                <input id="inicio_ocupacao_categoria" name="inicio_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Início" type="text">
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input id="fim_ocupacao_categoria" name="fim_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Fim" type="text">
                                <span class="input-group-btn">
                                        <button type="submit" onclick="ocupacao_categoria()" class="btn btn-effect-ripple btn-primary btn-sm" style="overflow: hidden; position: relative;"><i class="fa fa-angle-right"></i> <span class="hidden-xs"></span></button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div id="ocupacao_categoria"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="block">
            <div class="block-title"><h4>Tempo por categoria</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group form-group-sm">
                        <div class="input-group input-group-xs" style="width: 100%">
                            <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                <input id="inicio_tempo_categoria" name="inicio_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Início" type="text">
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input id="fim_tempo_categoria" name="fim_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Fim" type="text">
                                <span class="input-group-btn">
                                        <button type="submit" onclick="tempo_categoria()" class="btn btn-effect-ripple btn-primary btn-sm" style="overflow: hidden; position: relative;"><i class="fa fa-angle-right"></i> <span class="hidden-xs"></span></button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div id="tempo_categoria"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="block">
            <div class="block-title"><h4>Ocupação por tipo (externa/interna)</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group form-group-sm">
                        <div class="input-group input-group-xs" style="width: 100%">
                            <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                <input id="inicio_ocupacao_tipo" name="inicio_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Início" type="text">
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input id="fim_ocupacao_tipo" name="fim_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Fim" type="text">
                                <span class="input-group-btn">
                                        <button type="submit" onclick="ocupacao_tipo()" class="btn btn-effect-ripple btn-primary btn-sm" style="overflow: hidden; position: relative;"><i class="fa fa-angle-right"></i> <span class="hidden-xs"></span></button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div id="ocupacao_tipo"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="block">
            <div class="block-title"><h4>Tempos Interna/Externa</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group form-group-sm">
                        <div class="input-group input-group-xs" style="width: 100%">
                            <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                <input id="inicio_tempo_tipo" name="inicio_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Início" type="text">
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input id="fim_tempo_tipo" name="fim_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Fim" type="text">
                                <span class="input-group-btn">
                                        <button type="submit" onclick="tempo_tipo()" class="btn btn-effect-ripple btn-primary btn-sm" style="overflow: hidden; position: relative;"><i class="fa fa-angle-right"></i> <span class="hidden-xs"></span></button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div id="tempo_tipo"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="block">
            <div class="block-title"><h4>Ocupação por cliente</h4></div>
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
            <div class="block-title"><h4>Tempo por cliente</h4></div>
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
