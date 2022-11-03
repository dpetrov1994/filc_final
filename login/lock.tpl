<!-- Lock Header -->
<p class="text-center push-top-bottom animation-slideDown">
    <img src="_fotoUtilizador_" alt="avatar" class="img-circle img-thumbnail img-thumbnail-avatar-2x">
</p>
<h1 class="text-center text-light push-top-bottom animation-fadeInQuick">
    <strong>_nomeUtilizador_</strong><br>
    <small><em>_tipoUtilizador_</em></small>
</h1>
<!-- END Lock Header -->

<!-- Lock Form -->
<form action="lock.php" method="post" class="form-horizontal push animation-fadeInQuick">
    <div class="form-group">
        <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2">
            <div class="input-group input-group-lg">
                <input autofocus type="password" id="lock-password" name="lock-password" class="form-control form-control-borderless" placeholder="Palavra-passe..">
                <div class="input-group-btn">
                    <button type="submit" name="lock" class="btn btn-effect-ripple btn-block btn-primary"><i class="fa fa-unlock-alt"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
_status_
<p class="text-center animation-fadeInQuick">
    <a href="sair.php"><small>Não sou _nomeUtilizador_.</small></a>
</p>
<!-- END Lock Form -->