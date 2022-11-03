<div class="row">
    <div class="col-lg-12">
        <div class="block"><div class="block-title"><h3><i class="fa _icon_"></i> _nome_modulo_</h3></div>
            <form id="form-para-validar" class="form-horizontal form-bordered" action="index.php_addUrl_" method="post" enctype="multipart/form-data">

                <!-- colar aqui os itens do formulário-->


                <div class="form-group">
                    <label class="col-md-3 control-label" >Nome da configuração</label>
                    <div class="col-md-6">
                        <input id="nome_conf" name="nome_conf" class="form-control" placeholder="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <h2>Dados plataforma - "footer"</h2>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Nome Plataforma</label>
                    <div class="col-md-6">
                        <input id="nome_plataforma" name="nome_plataforma"  class="form-control" placeholder="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >URL</label>
                    <div class="col-md-6">
                        <input id="url" name="url"  class="form-control" placeholder="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Versão</label>
                    <div class="col-md-6">
                        <input id="versao" name="versao" class="form-control" placeholder="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <h2>Meta tags</h2>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Meta-descricao</label>
                    <div class="col-md-6">
                        <input id="meta_descricao" name="meta_descricao" class="form-control" placeholder="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Meta-autor</label>
                    <div class="col-md-6">
                        <input id="meta_autor" name="meta_autor" class="form-control" Value="Denis Petrov" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Meta-keywords</label>
                    <div class="col-md-6">
                        <input id="meta_keywords" name="meta_keywords" class="input-tags">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Meta-robots</label>
                    <div class="col-md-6">
                        <input id="meta_robots" class=" form-control" name="meta_robots" >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <h2>Disco</h2>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Espaço em disco (GB)</label>
                    <div class="col-md-6">
                        <input id="espaco_disco" name="espaco_disco" class="form-control" placeholder="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Reservado para o sistema (GB)</label>
                    <div class="col-md-6">
                        <input id="espaco_reservado_sys" name="espaco_reservado_sys" class="form-control" placeholder="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Tamanho máximo de upload (MB)</label>
                    <div class="col-md-6">
                        <input id="tamanho_max_upload" name="tamanho_max_upload" class="form-control" placeholder="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <h2>Sms</h2>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Servidor SMS</label>
                    <div class="col-md-6">
                        <input id="servidor_sms" name="servidor_sms" class="form-control" placeholder="" type="email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Tamanho máximo de uma SMS</label>
                    <div class="col-md-6">
                        <input id="tamanho_sms" value="_tamanhoSms_" name="tamanho_sms" class="form-control" placeholder="" type="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Limite SMS/mês</label>
                    <div class="col-md-6">
                        <input id="limite_sms" name="limite_sms" class="form-control" placeholder="" type="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <h2>Sugestões/Correções</h2>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Servidor Sugestões</label>
                    <div class="col-md-6">
                        <input id="servidor_sugestoes" name="servidor_sugestoes" class="form-control" placeholder="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Servidor Licenca</label>
                    <div class="col-md-6">
                        <input id="lchk" name="lchk" class="form-control" placeholder="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >Chave de encriptação</label>
                    <div class="col-md-6">
                        <small class="text-danger"><i class="fa fa-exclamation-triangle"></i> Está no ficheiro: mod_backups/chave_encriptacao.txt</small>
                        <input id="chave" disabled name="chave" maxlength="16" minlength="16" class="form-control" placeholder="" type="text">
                        <small class="text-warning"><i class="fa fa-exclamation-triangle"></i> Esta é a chave de encriptação da sua base de dados, se alterar esta chave, os dados encriptados com a chave antiga não serão acessíveis.</small>

                    </div>
                </div>
                <!-- fim itens do formulário-->

                <div class="form-group form-actions">
                    <div class="col-lg-12">
                        <button type="submit" name="submit" id="botao_loading" class="btn btn-effect-ripple btn-success pull-right btn-submit" data-loading-text="<i class='fa fa-asterisk fa-spin'></i> Aguarde">Concluir</button>
                        <button type="reset" class="btn btn-effect-ripple btn-danger">Limpar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>