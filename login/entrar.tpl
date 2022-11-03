<div class="status">
    _status_
</div>
<span id="countdown"></span>
<div class="block animation-fadeInQuick login-block">
    <!-- Login Title -->
    <div class="block-title">
        <h2>_nomePagina_</h2>
    </div>
    <!-- END Login Title -->
    <!-- Login Form -->
    <form id="form-login" action="entrar.php" method="post" class="form-horizontal">

        <div class="form-group">
            <label for="login-email" class="col-xs-12"> Nº de Funcionário ou Email </label>
            <div class="col-xs-12">
                <input type="text" id="token"  value="_token_" name="token" class="hidden">
                <input type="text" id="login-email"  value="_email_"  name="login-email" class="form-control" placeholder="Email...">
            </div>
        </div>
        <div class="form-group">
            <label for="login-password" class="col-xs-12">Palavra-passe</label>
            <div class="col-xs-12">
                <input type="password"  id="login-password" value="_pass_" name="login-password" class="form-control" placeholder="Password">
            </div>
        </div>
        <div class="form-group hidden">
            <div class="col-xs-12">

                <label class="csscheckbox csscheckbox-primary pull-right"><i class="fa fa-lock"></i> Entrar automaticamente <input name="lembrar" _checked_ type="checkbox"> <span></span> </label>
            </div>
        </div>
        <div class="form-group form-actions">
            <div class="col-xs-8">
                <label class="">
                    <a href="recuperar.php">Esqueci-me da palavra-passe.</a>
                </label>
            </div>
            <div class="col-xs-4 text-right">
                <button name="entrar" type="submit" id="bnt_entrar" class="btn btn-effect-ripple btn-sm btn-primary">Entrar</button>
            </div>
        </div>
    </form>
    <!-- END Login Form -->
</div>