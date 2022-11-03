<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form id="form-para-validar" class="form-horizontal form-bordered" action="criar.php_addUrl_" method="post" enctype="multipart/form-data">

                <!-- colar aqui os itens do formulário-->


                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Nome Identificador </label>
                        <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                            <input id="nome_carregamento" name="nome_carregamento" maxlength="250"  class="form-control" placeholder=""  type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm _esconderDoForm_">
                    <div class="col-xs-6">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Cliente</label>
                        <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                            <select id="id_cliente" name="id_cliente" onchange="get_contratos_do_cliente(this.value)" required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                                <option></option>
                                _id_cliente_
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Contrato</label>
                        <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                            <select id="id_contrato" name="id_contrato" required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                                <option></option>
                                _id_contrato_
                            </select>
                        </div>
                    </div></div><div class="form-group form-group-sm">
                    <div class="col-xs-6">
                        <label class="CasoQueiramosMeterLarguraDaColuna">Tempo a adicionar</label>
                        <div class="CasoQueiramosMeterLarguraDaColuna">
                            <input id="segundos" name="segundos" required maxlength="250"  class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="CasoQueiramosMeterLarguraDaColuna">Unidade</label>
                        <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                            <select id="unidade" name="unidade" required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                                <option value="h">Horas</option>
                                <option value="m">Minutos</option>
                            </select>
                        </div>
                    </div>


                </div>

             <!--   <div class="form-group form-group-sm">
                    <div class="col-xs-12 text-center">
                        <label>Gerar notificação para pagamento</label><br>
                        <label class="switch switch-primary">
                            <input type="hidden"   name="gerar_pagamento" value="0">
                            <input type="checkbox" onchange="mostrarEsconderElem('.gerar-pagamento')" name="gerar_pagamento" id="gerar_pagamento" value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="col-xs-12 gerar-pagamento" style="display: none">
                        <label class="CasoQueiramosMeterLarguraDaColuna">Valor em €</label>
                        <div class="CasoQueiramosMeterLarguraDaColuna">
                            <input id="valor" name="valor" required maxlength="250"  class="form-control" type="text">
                        </div>
                    </div>

                </div>-->

                <!--
                <div class="form-group form-group-sm">
                    <div class="col-xs-12 text-center">
                        <label>Expira</label><br>
                        <label class="switch switch-primary">
                            <input type="hidden"   name="expira" value="0">
                            <input type="checkbox" onchange="mostrarEsconderElem('.data-expira')" name="expira" id="expira" value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="col-xs-12 data-expira" style="display: none;">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Data Expira</label>
                        <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                            <input id="data_expira" name="data_expira" required class="input-datepicker form-control">
                        </div>
                    </div>

                </div>
                --->
                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Observações </label>
                        <div class="CasoQueiramosMeterLarguraDaColuna">
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