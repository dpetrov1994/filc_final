
<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-title"><h4>Alteração de assinatura</h4></div>
            <div class="text-center"><a href="javascript:void(0)" class="btn btn-xs btn-primary mostra_filtros"><i class="fa fa-search"></i> Filtros/Pesquisa</a></div>

                                        <form id="form-pagina" class="form-horizontal form-bordered" enctype='multipart/form-data' action="alterar_assinatura.php_addUrl_" method="post" >
                <div class="form-group">
                    <div class="col-md-12">
                        <h2>Assinatura de <a href="_perfilUrl_?id=_idParent_">_nomeParent_</a></h2>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <div class=" text-center" id="div_assinatura" style="padding-bottom: 35px">
                            <label class="col-lg-12" >Assinatura atual </label>
                            <img src="_dirAssinatura_?.js">
                            <br>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class=" text-center" id="div_assinatura" style="padding-bottom: 35px">
                            <label class="col-lg-12" ><i class="fa fa-pencil"></i> Nova assinatuira </label>
                            <div class="input-status col-lg-12" id="signature-pad">
                                <canvas class="signature-pad border-right border-top border-bottom border-left" style="width: 400px;height: 200px" ></canvas><br>
                                <button type="button" id="clear" class="btn btn-info btn-xs"><i class="fa fa-eraser"></i> Limpar</button>
                            </div>
                            <small id="assinatura-error" style="display: none;" class="help-block animation-slideUp">Este campo é de preenchimento obrigatório.</small>
                            <br>
                            <hr>
                        </div>
                    </div>
                </div>
                <input id="assinatura" name="assinatura" type="text" required style="display: none">

                <div class="form-group form-actions">
                    <button type="button" onclick="validarAssinatura()"  id="" name="submit" class="btn btn-effect-ripple btn-primary pull-right" >Concluir</button>
                    <button type="submit"  id="botao_loading_original" name="submit" class="btn btn-effect-ripple btn-primary pull-right hidden" >Concluir</button>
                    <button type="reset" class="btn btn-effect-ripple btn-danger" style="overflow: hidden; position: relative;">Limpar</button>
                </div>
            </form>
        </div>

    </div>
</div>