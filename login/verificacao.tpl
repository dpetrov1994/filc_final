<div class="block animation-fadeInQuick login-block">
    <div class="block-title">
        <div class="block-options pull-right">
            <a href="index.php" class="btn btn-effect-ripple btn-primary" data-toggle="tooltip" data-placement="left" title="Iniciar Sessão"><i class="fa fa-user"></i></a>
        </div>
        <h2>_nomePagina_</h2>
    </div>
    <form id="form-reminder" action="verificar.php" method="post" class="form-horizontal">
        <div class="form-group">
            <div class="col-xs-12">
                <input type="text" id="reminder-email" value="_email_" name="reminder-email" class="form-control" placeholder="Email..">
            </div>
        </div>
        <div id="status">
            _status_
        </div>
        <div class="form-group form-actions">
            <div class="col-xs-12 text-right">
                <button name="verificar" type="submit" class="btn btn-effect-ripple btn-sm btn-primary"><i class="fa fa-send"></i> Enviar</button>
            </div>
        </div>
    </form>
</div>
