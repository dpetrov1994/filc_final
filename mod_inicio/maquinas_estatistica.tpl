<style>
    .widget {
        margin-bottom: 5px !important;
    }
</style>

<div class="row">
    <div class="col-lg-6">
        <div class="block">
            <div class="block-title"><h4>Ocupação de servicos total por máquina</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group form-group-sm">
                        <div class="input-group input-group-xs" style="width: 100%">
                            <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                <input id="inicio_ocupacao_maquina" name="inicio_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Início" type="text">
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input id="fim_ocupacao_maquina" name="fim_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Fim" type="text">
                                <span class="input-group-btn">
                                        <button type="submit" onclick="ocupacao_maquina()" class="btn btn-effect-ripple btn-primary btn-sm" style="overflow: hidden; position: relative;"><i class="fa fa-angle-right"></i> <span class="hidden-xs"></span></button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div id="ocupacao_maquina"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="block">
            <div class="block-title"><h4>Servicos total por maquina</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group form-group-sm">
                        <div class="input-group input-group-xs" style="width: 100%">
                            <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                <input id="inicio_servicos_maquina" name="inicio_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Início" type="text">
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input id="fim_servicos_maquina" name="fim_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Fim" type="text">
                                <span class="input-group-btn">
                                        <button type="submit" onclick="servicos_maquina()" class="btn btn-effect-ripple btn-primary btn-sm" style="overflow: hidden; position: relative;"><i class="fa fa-angle-right"></i> <span class="hidden-xs"></span></button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div id="servicos_maquina"></div>
                </div>
            </div>
        </div>
    </div>
</div>

