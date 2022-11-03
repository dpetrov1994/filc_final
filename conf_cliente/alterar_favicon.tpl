<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-title"><h4>Alteração de favicon</h4></div>
            <form id="form-para-validar"  class="form-horizontal form-bordered" enctype='multipart/form-data' action="alterar_favicon.php" method="post" >
                <div class="form-group">
                    <label class="col-md-3 control-label" >
                        <img src="_layoutDirectory_/img/favicon.png" alt="avatar" id="preview" class=" img-thumbnail img-thumbnail-avatar">
                    </label>
                    <div class="col-md-6">
                        <label>Alterar favicon</label>
                            <input name="foto" type="file" onchange="readURL(this,'preview')" accept="image/png" id="file">
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