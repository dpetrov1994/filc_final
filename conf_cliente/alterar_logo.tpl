
<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-title"><h4>Alteração do logo</h4></div>
            <form id="form-para-validar"  class="form-horizontal form-bordered" enctype='multipart/form-data' action="alterar_logo.php_addUrl_" method="post" >
                <div class="form-group">
                    <label class="col-md-3 control-label" >
                        <img src="_layoutDirectory_/img/icon144.png" alt="avatar" class=" img-thumbnail img-thumbnail-avatar-2x">
                    </label>
                    <div class="col-md-6">
                        <label>Alterar logotípo</label>
                        <div class="imageBox">
                            <div class="thumbBox"></div>
                            <div class="spinner" style="display: none">Loading...</div>
                        </div>
                        <div class="col-lg-12">
                            <input type="file" id="file" >
                        </div>
                        <div class="col-lg-12">
                            <br>
                            <button class="btn btn-primary btn-lg" type="button" id="btnZoomIn" ><i class="fa fa-search-plus fa-2x"></i></button>
                            <button class="btn btn-primary btn-lg" type="button" id="btnZoomOut" ><i class="fa fa-search-minus fa-2x"></i></button>
                            <button class="btn btn-success btn-lg" type="button" id="btnCrop" ><i class="fa fa-check fa-2x"></i></button>
                        </div>
                    </div>
                    <input class="hidden" type="text" name="imagemUpload" id="imagemUpload" value="">
                </div>
                <div class="form-group form-actions">
                    <button type="submit"  id="BTNconcluir" name="submit" class="btn btn-effect-ripple btn-primary pull-right hidden" >Concluir</button>
                    <button type="reset" class="btn btn-effect-ripple btn-danger" style="overflow: hidden; position: relative;">Limpar</button>
                </div>
            </form>
        </div>
    </div>
</div>