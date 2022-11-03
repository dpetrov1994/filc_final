<style>
    .widget {
        margin-bottom: 5px !important;
    }
</style>

<!-- Estados dos tecnicos -->
<div class="row" style="border-bottom: 1px dashed #b8b8b8;padding-bottom: 10px">
    <div class="col-lg-4">
        <div class="block">

            <div class="block-title"><h4>Tempo por categoria</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group form-group-sm">
                        <div class="input-group input-group-xs" style="width: 100%">
                            <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                <input id="inicio1" name="inicio1" value="" class="form-control" autocomplete="off" placeholder="Data Início" type="text">
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input id="fim1" name="fim1" value="" class="form-control" autocomplete="off" placeholder="Data Fim" type="text">
                                <span class="input-group-btn">
                                        <button type="submit" onclick="tempos_categoria()" class="btn btn-effect-ripple btn-primary btn-sm" style="overflow: hidden; position: relative;"><i class="fa fa-angle-right"></i> <span class="hidden-xs"></span></button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div id="tempos_cat">
                        <canvas id="mycanvas"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-lg-8">
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
</div>
