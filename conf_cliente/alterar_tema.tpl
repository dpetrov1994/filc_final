<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-title"><h4>Alteração do tema</h4></div>
            <form id="form-para-validar"  class="form-horizontal form-bordered" enctype='multipart/form-data' action="alterar_tema.php_addUrl_" method="post" >
                <div class="form-group">
                    <label class="col-md-3 control-label" >
                        Selecione um tema
                    </label>
                    <div class="col-md-6">
                        <select id="tema" name="tema" class="select-select2" style="width: 100%;" data-placeholder="Selecione..">
                            <option value="default.css">default.css</option>
                            _temas_
                        </select>
                    </div>
                </div>
                <div class="form-group form-actions">
                    <button type="submit"  id="BTNconcluir" name="submit" class="btn btn-effect-ripple btn-success pull-right btn-submit" >Concluir</button>
                    <button type="reset" class="btn btn-effect-ripple btn-danger" style="overflow: hidden; position: relative;">Limpar</button>
                </div>
            </form>
        </div>
    </div>
</div>