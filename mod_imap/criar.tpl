<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form id="form-para-validar" class="form-horizontal form-bordered form-criar-email" action="criar.php_addUrl_" method="post" enctype="multipart/form-data">

               _controloTicket_

                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Eviar como:</label>
                        <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                            <select id="id_conf" name="id_conf" required class="" data-placeholder="Selecione.." style="width: 100%;">
                                <option></option>
                                _id_conf_
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Destinatário</label>
                        <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                            <select id="para_email" name="para_email" required class="" data-placeholder="Selecione.." style="width: 100%;">
                                <option></option>
                                _paraEmail_
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >CC </label>
                        <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                            <select id="cc" name="cc[]" multiple class="" data-placeholder="Selecione.." style="width: 100%;">
                                <option></option>
                                _ccEnviar_
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Assunto </label>
                        <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                            <input id="nome_imap" name="nome_imap" maxlength="250"  class="form-control" placeholder=""  type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <textarea id="descricao" name="descricao" class="ckeditor">_descricaoResposta_</textarea>
                    </div>
                </div>

                <!-- fim itens do formulário-->
                <div class="hidden">
                    <div>
                        <button type="submit" name="submit" id="botao_enviar_email" class="btn btn-effect-ripple btn-primary pull-right">Concluir</button>
                        <button type="reset" id="reset2" class="btn btn-effect-ripple btn-danger">Limpar</button>
                    </div>
                </div>
            </form>
            <div  class="form-horizontal form-bordered" style="margin: 20px">
                <div class="form-group">
                    <label class="col-lg-12 text-center" ><i class="fa fa-picture-o"></i> Anexos </label>
                    <div class="col-lg-12 text-center">
                        <i class="fa fa-info-circle text-info"></i> Em vez de serem enviados como anexo, será enviado um link para cada ficheiro.<br><br>
                    </div>
                    <div class="col-lg-12">
                        _dropZone_
                    </div>
                </div>
            </div>
            <div  class="form-horizontal form-bordered">
                <div class="form-group form-actions">
                    <div class="col-lg-12">
                        <a onclick="document.getElementById('botao_enviar_email').click()" id="botao_enviar_email_fake" class="btn btn-effect-ripple btn-primary pull-right" data-loading-text="<i class='fa fa-asterisk fa-spin'></i> Aguarde">Concluir</a>
                        <a onclick="window.history.back()" class="btn btn-effect-ripple btn-warning">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>