<div class="block animation-fadeInQuick login-block">
    <div class="block-title">
        <div class="block-options pull-right">
            <a href="index.php" class="btn btn-effect-ripple btn-primary" data-toggle="tooltip" data-placement="left" title="Iniciar Sessão"><i class="fa fa-user"></i></a>
        </div>
        <h2>_nomePagina_</h2>
    </div>
    <form id="form-reminder" action="recuperar.php" method="post" class="form-horizontal">
        <div class="form-group">
            <div class="col-xs-12">
                <input type="text" id="reminder-email" name="reminder-email"  class="form-control" placeholder="Email de recuperação..">
            </div>
        </div>
        <div id="status">
            _status_
        </div>
        <div class="form-group form-actions">
            <div class="col-xs-12 text-right">
                <button name="recuperar" type="submit" class="btn btn-effect-ripple btn-sm btn-primary"><i class="fa fa-check"></i> Recuperar</button>
            </div>
        </div>
    </form>
</div>
