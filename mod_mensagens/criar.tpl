<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form id="form-para-validar" class="form-horizontal form-bordered" action="_formAction__addUrl_" method="post" enctype="multipart/form-data">

                <!-- colar aqui os itens do formulário-->

                    _para_



                    <div class="form-group form-group-sm">
                        <div class="col-xs-12">
                            <label class="col-lg-12" >Assunto </label>
                            <div class="col-lg-12 input-status">
                                <input id="nome_mensagem" name="nome_mensagem" maxlength="250"  class="form-control" placeholder=""  type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-xs-12">
                            <label class="col-lg-12" >Mensagem </label>
                            <div class="col-lg-12">
                                <textarea id="descricao" rows="10" name="descricao" class="form-control">_descricao_</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- fim itens do formulário-->
                    <div class="form-group form-actions hidden">
                        <div class="col-lg-12">
                            <button type="submit" name="submit" id="botao_submit"  class="btn btn-effect-ripple btn-success pull-right btn-submit" data-loading-text="<i class='fa fa-asterisk fa-spin'></i> Aguarde">Concluir</button>
                            <button type="reset" id="botao_reset" class="btn btn-effect-ripple btn-danger">Limpar</button>
                        </div>
                    </div>
            </form>

            <div class="form-group form-actions" style="padding: 20px">
                 <label><i class="fa fa-paperclip"></i> Anexos</label>
                 <form action="" class="dropzone" id="myAwesomeDropzone"></form>
            </div>

            <div class="form-horizontal form-bordered">
                <div class="form-group form-actions">
                    <div class="col-lg-12">
                        <button type="button" onclick="document.getElementById('botao_submit').click()" id="botao_loading" class="btn btn-effect-ripple btn-success pull-right btn-submit" data-loading-text="<i class='fa fa-asterisk fa-spin'></i> Aguarde">Concluir</button>
                        <button type="button" onclick="document.getElementById('botao_reset').click()" class="btn btn-effect-ripple btn-danger">Limpar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>