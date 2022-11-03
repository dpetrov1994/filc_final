_msg_
<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-title"><h4>Alteração de password</h4></div>
            <form id="form-login" class="form-horizontal form-bordered" enctype='multipart/form-data' action="alterar_pass.php_addUrl_" method="post" >

                    <div class="form-group">
                        <label class="col-md-3 control-label" >Nova Palavra-passe</label>
                        <div class="col-md-6">
                            <input id="login-password" name="login-password" class="form-control" placeholder="" type="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" >Repita palavra-passe</label>
                        <div class="col-md-6">
                            <input id="login-password2" name="login-password2" class="form-control" placeholder="" type="password">
                        </div>
                    </div>
                <input name="primeiro_login" value="_primeiro_login_" class="hidden">
                <div class="form-group form-actions">
                    <button type="submit" id="concluir" name="submit" class="btn btn-effect-ripple btn-success pull-right btn-submit" style="overflow: hidden; position: relative;">Concluir</button>
                    <button type="reset" class="btn btn-effect-ripple btn-danger" style="overflow: hidden; position: relative;">Limpar</button>
                </div>
            </form>
        </div>
    </div>
</div>