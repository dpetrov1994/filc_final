<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form id="form-para-validar" class="form-horizontal form-bordered" action="criar.php_addUrl_" method="post" enctype="multipart/form-data">

                <!-- colar aqui os itens do formulário-->

                
            <div class="form-group form-group-sm">
                <div class="col-xs-12">
                    <label class="col-lg-12" >Nome </label>
                    <div class="col-lg-12 input-status">
                        <input id="nome_perfil" name="nome_perfil" maxlength="250"  class="form-control" placeholder=""  type="text">
                    </div>
                </div>
            </div>
<div class="form-group form-group-sm">
            <div class="col-xs-6">
                <label class="col-lg-12" >1 - Muito pouca</label>
                <div class="col-lg-12">
                    <textarea id="n1" name="n1" rows="10" class="form-control"></textarea>
                </div>
            </div>
            <div class="col-xs-6">
                <label class="col-lg-12" >2 - Pouca</label>
                <div class="col-lg-12">
                    <textarea id="n2" name="n2" rows="10" class="form-control"></textarea>
                </div>
            </div></div><div class="form-group form-group-sm">
            <div class="col-xs-6">
              <label class="col-lg-12">3 - Rasoável</label>
              <div class="col-lg-12">
                  <textarea id="n3" name="n3" rows="10" class="form-control"></textarea>
              </div>
            </div>
            <div class="col-xs-6">
                <label class="col-lg-12" >4 - Boa</label>
                <div class="col-lg-12">
                    <textarea id="n4" name="n4" rows="10" class="form-control"></textarea>
                </div>
            </div></div><div class="form-group form-group-sm">
            <div class="col-xs-6">
                <label class="col-lg-12" >5 - Muito Boa</label>
                <div class="col-lg-12">
                    <textarea id="n5" name="n5" rows="10" class="form-control"></textarea>
                </div>
            </div>
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