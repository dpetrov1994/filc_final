<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form id="form-para-validar" class="form-horizontal form-bordered" action="editar.php_addUrl_" method="post" enctype="multipart/form-data">

                <!-- colar aqui os itens do formulário-->



                <div class="form-group form-group-sm">
                    <div class="col-xs-6">
                        <label class="col-lg-12" >Nome </label>
                        <div class="col-lg-12 input-status">
                            <input id="nome_produto" name="nome_produto" maxlength="250"  class="form-control" placeholder=""  type="text">
                        </div>
                    </div>
                    <div class="col-xs-6 col-lg-6">
                        <label class="col-lg-12">Preço</label>
                        <div class="col-lg-12">
                            <input id="preco_sem_iva" name="preco_sem_iva" maxlength="250"  class="form-control" type="text">
                        </div>
                    </div>
                </div>


                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <label class="col-lg-12" >Descrição do produto e características </label>
                        <div class="col-lg-12">
                            <textarea id="descricao" rows="10" name="descricao" class="ckeditor">_descricao_</textarea>
                        </div>
                    </div>
                </div>


                <div class="form-group form-group-sm">
                    <div class="col-lg-12 text-center">
                        <img src="_foto_" id="preview" class="img-thumbnail">
                        <br>
                        <br>
                        <div class="col-xs-6 col-xs-offset-3">
                            <input   type="file" onchange="readURL(this,'preview')" id="file" name="file" accept="image/*" class="inputfile inputfile-2"><label for="file" class="" id="file_label"><i class="fa fa-upload"></i> <span>Selecione uma imagem </span></label>
                        </div>
                    </div>
                </div>


                <!-- fim itens do formulário-->

                <div class="hidden">
                    <div>
                        <button type="submit" name="submit" id="botao_loading2" class="btn btn-effect-ripple btn-primary pull-right">Concluir</button>
                        <button type="reset" id="reset2" class="btn btn-effect-ripple btn-danger">Limpar</button>
                    </div>
                </div>
            </form>

            <div  class="form-horizontal form-bordered">
                <div class="form-group form-actions">
                    <div class="col-lg-12">
                        <a onclick="document.getElementById('botao_loading2').click()" id="botao_loading" class="btn btn-effect-ripple btn-primary pull-right" data-loading-text="<i class='fa fa-asterisk fa-spin'></i> Aguarde">Concluir</a>
                        <a onclick="window.history.back()" class="btn btn-effect-ripple btn-warning">Voltar</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>