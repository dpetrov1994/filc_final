<div id="page-content-sidebar">
    <div  class="block-section text-center">
        <h3><i class="fa _iconModulo_"></i> _nomeModulo_ </h3>
    </div>
    <!-- END Compose Message -->

    <!-- Collapsible Navigation -->
    <a href="javascript:void(0)" class="btn btn-block btn-effect-ripple btn-primary visible-xs" data-toggle="collapse" data-target="#email-nav" ><span class="pull-left">Submenu </span>  <i class="fa fa-toggle-down pull-right"></i></a>
    <div id="email-nav" class="collapse navbar-collapse remove-padding">

        <div class="block-section">
            <ul class="nav nav-pills nav-stacked">
                _menuSecundario_
            </ul>
        </div>
        <div class="block-section">

        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="block">
            _status_
            <div class="text-center"><a href="javascript:void(0)" class="btn btn-xs btn-primary mostra_filtros"><i class="fa fa-search"></i> Filtros/Pesquisa</a></div>

                                        <form id="form-pagina" class="form-horizontal form-bordered" action="enviar_email.php_addUrl_" method="post">
                <div class="form-group">
                    <div class="col-md-12">
                        <h2>Email de confirmação de <a href="_perfilUrl_?id=_idParent_">_nomeParent_</a></h2>
                    </div>
                </div>

                    <blockquote class="pull-left">
                        <p><label>Verificação do email:</label> _estadoVerificado_</p>
                        <p>Enviar mensagem de verificação de email para o endreço: </p>
                        <small>_emailParent_</small>
                    </blockquote>
                <div class="form-group form-actions">
                    <button type="submit" id="concluir" name="submit" class="btn btn-effect-ripple btn-success pull-right btn-submit" style="overflow: hidden; position: relative;">Enviar e Continuar</button>
                    <button type="reset" class="btn btn-effect-ripple btn-danger" style="overflow: hidden; position: relative;">Limpar</button>
                </div>
            </form>
        </div>
    </div>
</div>