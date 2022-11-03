<style>
    .widget {
        margin-bottom: 5px !important;
    }
</style>

<div class="row">
    <div class="col-lg-6">
        <div class="block">
            <div class="block-title"><h4>Orçamentos pendentes por cliente</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group form-group-sm">
                        <div class="input-group input-group-xs" style="width: 100%">
                            <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                <input id="inicio_orcamentos_clientes" name="inicio_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Início" type="text">
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input id="fim_orcamentos_clientes" name="fim_eficiencia" value="" class="form-control" autocomplete="off" placeholder="Data Fim" type="text">
                                <span class="input-group-btn">
                                        <button type="submit" onclick="orcamentos_clientes()" class="btn btn-effect-ripple btn-primary btn-sm" style="overflow: hidden; position: relative;"><i class="fa fa-angle-right"></i> <span class="hidden-xs"></span></button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div id="orcamentos_clientes"></div>
                </div>
            </div>
        </div>
    </div>

</div>
