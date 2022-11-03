<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form id="form-para-validar" class="form-horizontal form-bordered" action="editar.php_addUrl_" method="post" enctype="multipart/form-data">

                <!-- colar aqui os itens do formulário-->

                
            <div class="form-group form-group-sm">
                <div class="col-xs-12">
                    <label class="col-lg-12" >Nome </label>
                    <div class="col-lg-12 input-status">
                        <input id="nome_grupo" name="nome_grupo" maxlength="250"  class="form-control" placeholder=""  type="text">
                    </div>
                </div>
            </div>
<div class="form-group form-group-sm">
            <div class="col-xs-6">
              <label class="col-lg-12">Nome do responsável</label>
              <div class="col-lg-12">
                  <input id="nome_responsavel" name="nome_responsavel" maxlength="250"  class="form-control" type="text">
              </div>
            </div>
            <div class="col-xs-6">
              <label class="col-lg-12">Contacto do responsavel</label>
              <div class="col-lg-12">
                  <input id="contacto" name="contacto" maxlength="250"  class="form-control" type="text">
              </div>
            </div></div><div class="form-group form-group-sm">
            <div class="col-xs-6">
              <label class="col-lg-12">Contacto alternativo</label>
              <div class="col-lg-12">
                  <input id="contacto_alternativo" name="contacto_alternativo" maxlength="250"  class="form-control" type="text">
              </div>
            </div>
            <div class="col-xs-6">
              <label class="col-lg-12">NIF</label>
              <div class="col-lg-12">
                  <input id="nif" name="nif" maxlength="250"  class="form-control" type="text">
              </div>
            </div></div><div class="form-group form-group-sm">
            <div class="col-xs-6">
              <label class="col-lg-12">Morada</label>
              <div class="col-lg-12">
                  <input id="morada" name="morada" maxlength="250"  class="form-control" type="text">
              </div>
            </div>
            <div class="col-xs-6">
              <label class="col-lg-12">Código Postal</label>
              <div class="col-lg-12">
                  <input id="cod_post" name="cod_post" maxlength="250"  class="form-control" type="text">
              </div>
            </div></div><div class="form-group form-group-sm">
            <div class="col-xs-6">
              <label class="col-lg-12">Localidade</label>
              <div class="col-lg-12">
                  <input id="localidade" name="localidade" maxlength="250"  class="form-control" type="text">
              </div>
            </div>
            <div class="col-xs-6">
                <label class="col-lg-12" >Cliente</label>
                <div class="col-lg-12 input-status">
                    <select id="id_cliente" name="id_cliente" required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                        <option></option>
                        _id_cliente_
                    </select>
                </div>
            </div></div><div class="form-group form-group-sm">
            <div class="col-xs-6">
                <label class="col-lg-12" >Simulação</label>
                <div class="col-lg-12 input-status">
                    <select id="id_simulacao" name="id_simulacao" required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                        <option></option>
                        _id_simulacao_
                    </select>
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