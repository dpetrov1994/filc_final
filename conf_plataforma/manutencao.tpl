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
</div></div><div class="row">
<div class="col-lg-12">
<div class="block">

_status_

<form id="form-pagina-2"  class="form-horizontal form-bordered" action="manutencao.php" method="post">

<div class="form-group">


<label class="col-md-3 control-label" >IP whitelist - manutenção</label>


<div class="col-md-6">


<textarea class="form-control" rows="10" name="ips">_ips_</textarea>


</div>

</div>

<div class="form-group">


<label class="col-md-3 control-label" >Manutenção</label>


<div class="col-md-6">


<label class="switch switch-primary"><input name="manutencao" _manutencao_ type="checkbox"><span></span></label>


</div>

</div>

<div class="form-group">


<label class="col-md-3 control-label" >Plataforma</label>


<div class="col-md-6">


<label class="switch switch-primary"><input name="plataforma" _plataforma_ type="checkbox"><span></span></label>


</div>

</div>

<div class="form-group form-actions">


<button type="submit" name="submit" id="botao_loading" class="btn btn-effect-ripple btn-success pull-right btn-submit" style="overflow: hidden; position: relative;" data-loading-text="<i class='fa fa-asterisk fa-spin'></i> Aguarde">Concluir</button>


<button type="reset" class="btn btn-effect-ripple btn-danger" style="overflow: hidden; position: relative;">Limpar</button>

</div>

</form>
</div>
</div></div>