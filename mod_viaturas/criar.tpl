<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form id="form-para-validar" class="form-horizontal form-bordered" action="criar.php_addUrl_" method="post" enctype="multipart/form-data">

                <!-- colar aqui os itens do formulário-->

                

                <div class="form-group form-group-sm">
                    <div class="col-xs-6">
                        <label class="col-lg-12" >Marca </label>
                        <div class="col-lg-12 input-status">
                            <input id="marca" name="marca" maxlength="250"  class="form-control" placeholder=""  type="text">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="col-lg-12" >Modelo </label>
                        <div class="col-lg-12 input-status">
                            <input id="modelo" name="modelo" maxlength="250"  class="form-control" placeholder=""  type="text">
                        </div>
                    </div>
                </div>

<div class="form-group form-group-sm">
            <div class="col-xs-6">
              <label class="col-lg-12">Matricula</label>
              <div class="col-lg-12">
                  <input id="matricula" name="matricula" required maxlength="250"  class="form-control" type="text">
              </div>
            </div>
            <div class="col-xs-6">
                <label class="col-lg-12" >Data fim do seguro</label>
                <div class="col-lg-12 input-status">
                    <input id="data_seguro" name="data_seguro" required class="input-datepicker form-control" autocomplete="off">
                </div>
            </div></div><div class="form-group form-group-sm">
            <div class="col-xs-6">
                <label class="col-lg-12" >Data prox. Inspeção</label>
                <div class="col-lg-12 input-status">
                    <input id="data_inspecao" name="data_inspecao" required class="input-datepicker form-control" autocomplete="off">
                </div>
            </div>
            <div class="col-xs-6">
              <label class="col-lg-12">Km's para prox. Revisão</label>
              <div class="col-lg-12">
                  <input id="kms_revisao" name="kms_revisao" required maxlength="250"  class="form-control" type="text">
              </div>
            </div></div><div class="form-group form-group-sm">
            <div class="col-xs-6">
              <label class="col-lg-12">Km's para troca pneus</label>
              <div class="col-lg-12">
                  <input id="kms_pneus" name="kms_pneus" required maxlength="250"  class="form-control" type="text">
              </div>
            </div>
            <div class="col-xs-6">
                <label class="col-lg-12" >Data prox. Lavagem</label>
                <div class="col-lg-12 input-status">
                    <input id="data_lavagem" name="data_lavagem" required class="input-datepicker form-control" autocomplete="off">
                </div>
            </div></div><div class="form-group form-group-sm">
            <div class="col-xs-6">
              <label class="col-lg-12">Km's atuais</label>
              <div class="col-lg-12">
                  <input id="kms_inicio" name="kms_inicio" required maxlength="250"  class="form-control" type="text">
              </div>
            </div>
            <div class="col-xs-6">
              <label class="col-lg-12">Preço por KM</label>
              <div class="col-lg-12">
                  <input id="preco_km" name="preco_km" required maxlength="250"  class="form-control" type="text">
              </div>
            </div></div>


                <div class="form-group form-group-sm">
                    <div class="col-xs-12 col-lg-6">
                        <div class="col-xs-12">
                            <label>Estado da viatura</label>
                            <select id="id_estado_viatura" name="id_estado_viatura" autocomplete="off" required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                                <option></option>
                                _estadosviaturas_
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-lg-6">
                        <div class="col-xs-12">
                            <label>Viatura atribuída a:</label>
                            <select id="id_tecnico" name="id_tecnico" required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                                <option value="0">Nenhum</option>
                                _tecnicos_
                            </select>
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