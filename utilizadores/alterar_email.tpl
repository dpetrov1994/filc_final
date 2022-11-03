
<div class="alert alert-info alert-dismissable">
    <h4><strong><i class="fa fa-info-circle"></i> Informação</strong></h4>
    <p>Receberá uma mensagem na sua caixa de correio com o pedido de verificação.</p>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-title"><h4>Alteração de e-mail</h4></div>
            <form id="form-login" class="form-horizontal form-bordered" enctype='multipart/form-data' action="alterar_email.php_addUrl_" method="post" >
                <div class="form-group hidden">
                    <label class="col-md-3 control-label" >ID</label>
                    <div class="col-md-6">
                        <input id="id" name="id" class="form-control" placeholder="..."  value="_idParent_" type="text">
                    </div>
                </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" >Novo email</label>
                        <div class="col-md-6">
                            <input id="email" name="email" maxlength="250" class="form-control" placeholder="" type="text">
                        </div>
                    </div>
                <div class="form-group form-actions">
                    <button type="submit" id="concluir" name="submit" class="btn btn-effect-ripple btn-success pull-right btn-submit" style="overflow: hidden; position: relative;">Concluir</button>
                    <button type="reset" class="btn btn-effect-ripple btn-danger" style="overflow: hidden; position: relative;">Limpar</button>
                </div>
            </form>
        </div>
    </div>
</div>