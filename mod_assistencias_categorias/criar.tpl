<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form id="form-para-validar" class="form-horizontal form-bordered" action="criar.php_addUrl_" method="post" enctype="multipart/form-data">

                <!-- colar aqui os itens do formulário-->


                <div class="form-group form-group-sm">
                    <div class="col-xs-6">
                        <label class="col-lg-12" >Nome </label>
                        <div class="col-lg-12 input-status">
                            <input id="nome_categoria" name="nome_categoria" maxlength="250"  class="form-control" placeholder=""  type="text">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="col-lg-12">Cor</label>
                        <div class="col-lg-12">
                            <div class="input-group input-colorpicker colorpicker-element">
                                <input id="cor_cat" name="cor_cat" value="#cb5519" class="form-control" type="text">
                                <span class="input-group-addon"><i style="background-color: #cb5519"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

<div class="form-group form-group-sm text-center">
    <label>Só para comerciais<br>
        <label class="switch switch-primary">
            <input type="hidden" name="comercial" value="0">
            <input type="checkbox" name="comercial" id="comercial" value="1" >
            <span></span>
        </label>
</div>
<div class="form-group form-group-sm">
    <div class="col-xs-12">
        <label class="col-lg-12" >Observações </label>
        <div class="col-lg-12">
             <textarea id="descricao" rows="10" name="descricao" class="form-control">_descricao_</textarea>
        </div>
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