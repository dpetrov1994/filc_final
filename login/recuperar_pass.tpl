<div class="block animation-fadeInQuick login-block">
    <!-- Login Title -->
    <div class="block-title">
        <h2>_nomePagina_</h2>
    </div>
    <!-- END Login Title -->

    <!-- Login Form -->
    <form id="form-login" action="recuperar_pass.php" method="post" class="form-horizontal">
        <input type="text" id="login-email"  name="login-email" class="form-control hidden" value="_idUtilizador_">
        <div class="form-group">
            <label for="login-password" class="col-xs-12">Palavra-passe nova</label>
            <div class="col-xs-12">
                <input type="password" autofocus id="login-password" name="login-password" class="form-control" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="login-password" class="col-xs-12">Repita a palavra-passe</label>
            <div class="col-xs-12">
                <input type="password"  id="login-password2" name="login-password2" class="form-control" placeholder="">
            </div>
        </div>
        <div class="status">
            _status_
        </div>
        <div class="form-group form-actions">
            <div class="col-xs-4 text-right">
                <button name="recuperar" type="submit" class="btn btn-effect-ripple btn-sm btn-success">Confirmar</button>
            </div>
        </div>
    </form>
    <!-- END Login Form -->
</div>