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
    
    
<form id="form-para-validar"  class="form-horizontal form-bordered" action="smtp.php" method="post">
    
    
    
<div class="form-group">    
    
    
    
    
<label class="col-md-3 control-label" >Dados Atuais</label>    
    
    
    
    
<div class="col-md-6">    
    
    
    
    
    
<a href="smtp_testar.php"> Testar conexão</a>    
    
    
    
    
</div>    
    
    
    
</div>    
    
    
    
<div class="form-group">    
    
    
    
    
<label class="col-md-3 control-label" >HOST SMTP</label>    
    
    
    
    
<div class="col-md-6">    
    
    
    
    
    
<input id="host" value="_host_" name="host" class="form-control" placeholder="smtp.gmail.com" type="text">    
    
    
    
    
</div>    
    
    
    
</div>    
    
    
    
<div class="form-group">    
    
    
    
    
<label class="col-md-3 control-label" >PORT SMTP</label>    
    
    
    
    
<div class="col-md-6">    
    
    
    
    
    
<input id="port" value="_port_" name="port" class="form-control" placeholder="587" type="text">    
    
    
    
    
</div>    
    
    
    
</div>    
    
    
    
<div class="form-group">    
    
    
    
    
<label class="col-md-3 control-label" >Nome from:</label>    
    
    
    
    
<div class="col-md-6">    
    
    
    
    
    
<input id="nome" value="_nomeFrom_" name="nome" class="form-control" type="text">    
    
    
    
    
</div>    
    
    
    
</div>    
    
    
    
<div class="form-group">    
    
    
    
    
<label class="col-md-3 control-label" >User</label>    
    
    
    
    
<div class="col-md-6">    
    
    
    
    
    
<input id="user" value="_user_" name="user" class="form-control" placeholder="email@host.com" type="email">    
    
    
    
    
</div>    
    
    
    
</div>    
    
    
    
<div class="form-group">    
    
    
    
    
<label class="col-md-3 control-label" >Pass</label>    
    
    
    
    
<div class="col-md-6">    
    
    
    
    
    
<input id="pass" value="_pass_" name="pass" class="form-control" placeholder="" type="password">    
    
    
    
    
</div>    
    
    
    
</div>    
    
    
    
<div class="form-group">    
    
    
    
    
<label class="col-md-3 control-label" >Reply:</label>    
    
    
    
    
<div class="col-md-6">    
    
    
    
    
    
<input id="reply" value="_reply_" name="reply" class="form-control" type="text">    
    
    
    
    
</div>    
    
    
    
</div>    
    
    
    
<div class="form-group">    
    
    
    
    
<label class="col-md-3 control-label" >Reply Nome:</label>    
    
    
    
    
<div class="col-md-6">    
    
    
    
    
    
<input id="replyNome" name="replyNome" class="form-control" value="_replyNome_" type="text">    
    
    
    
    
</div>    
    
    
    
</div>    
    
    
    
<div class="form-group form-actions">    
    
    
    
    
<button type="submit" name="submit" id="botao_loading" class="btn btn-effect-ripple btn-success pull-right btn-submit" style="overflow: hidden; position: relative;" data-loading-text="<i class='fa fa-asterisk fa-spin'></i> Aguarde">Concluir</button>    
    
    
    
    
<button type="reset" class="btn btn-effect-ripple btn-danger" style="overflow: hidden; position: relative;">Limpar</button>    
    
    
    
</div>    
    
    
</form>    
    
</div>    
</div></div>