<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form class="form-horizontal form-bordered">
                <div class="form-group">
                    <div class="col-md-4 col-xs-6">
                        <div class="col-lg-6">
                            <label>ID:</label> #_idItem_
                            <br><a href="../logs/index.php?&id_item=_idItem_&nome_tabela=viaturas" target="_blank"><i class="fa fa-history"></i> Histórico (_cntRevisoes_)</a>

                        </div>
                        <div class="col-lg-6">
                            <label>Estado:</label> _ativo_
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-6">
                        <label class="col-lg-12" >Criado por: </label>
                        <div class="col-lg-12 input-status">
                            <a href="../utilizadores/detalhes.php?id=_idCriou_">_nomeCriou_</a>
                            <br>_dataCriado_
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-6">
                        <label class="col-lg-12" >Editado por: </label>
                        <div class="col-lg-12 input-status">
                            <a href="../utilizadores/detalhes.php?id=_idAtualizou_">_nomeAtualizou_</a>
                            <br>_dataAtualizado_
                        </div>
                    </div>
                </div>

                <!-- colar aqui os itens do formulário-->

    <div class="detalhes-assistencia">
        <div>


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

        </div>

        <div class="col-xs-12">

            <div class="block-title">
                <h2>Transferências do Veículo</h2>
                <div class="input-status pull-right filtro-data-viatura">
                    <label> Filtrar por data </label>
                    <input id="data_transferencia" class="input-datepicker form-control" autocomplete="off" onchange="filtrarViaturaData(_idItem_,this.value)">
                    <a style="align-self: center; padding-left: 5px;" href="javascript:void(0)" onclick="cancelarFiltro(_idItem_)"><i class="fa fa-times"></i></a>
                </div>
            </div>

            <div class="assistencias-clientes historico-viaturas">
                _transferencias_
            </div>

            <div class="sem-dados-transferencias">
                <div class="well well-sm text-center"><i class="text-muted"> Sem dados</i>  </div>
            </div>

        </div>


    </div>

                <!-- fim itens do formulário-->

            </form>
        </div>
    </div>
</div>