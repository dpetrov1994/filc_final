<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form class="form-horizontal form-bordered">
                <div class="form-group">
                    <div class="col-md-4 col-xs-6">
                        <div class="col-lg-6">
                            <label>ID:</label> #_idItem_
                            <br><a href="../logs/index.php?&id_item=_idItem_&nome_tabela=orcamentos" target="_blank"><i class="fa fa-history"></i> Histórico (_cntRevisoes_)</a>

                        </div>
                        <div class="col-lg-6 mover-para-reciclagem">
                            <label>Estado:</label> _ativo_
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-6">

                        <div class="col-lg-12 input-status">
                            <label>Creado por: </label><a href="../utilizadores/editar.php?id=_idCriou_"> _nomeCriou_</a>
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


                 <span style="display:none" class="_statusdodocumento_"></span>

                </div>


                <!-- colar aqui os itens do formulário-->


                <div class="form-group form-group-sm">
                    <div class="col-xs-6 _admin_">
                        <label class="col-lg-12" >REF ORC: </label>
                        <div class="col-lg-12 input-status">
                            <input id="ref" name="ref" maxlength="250"  class="form-control" placeholder=""  type="text">
                        </div>
                    </div>
                    <div class="col-xs-6 _admin_">
                        <label class="col-lg-12" >Cliente</label>
                        <div class="col-lg-12 input-status">
                            <select id="id_cliente" name="id_cliente" required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                                <option></option>
                                _id_cliente_
                            </select>
                        </div>
                    </div>

                </div>

                <div class="form-group form-group-sm text-center">
                    <label>Fechado<br>
                        <label class="switch switch-primary">
                            <input type="hidden" name="fechado" value="0">
                            <input type="checkbox" disabled name="fechado" id="fechado" value="1" >
                            <span></span>
                        </label>
                </div>

                <div class="form-group form-group-sm">
                    <div class="col-xs-12 overflow-x-mobile">
                        <table class="table table-vcenter table-bordered">
                            <thead>
                            <tr>

                                <th style="width: 10%">Foto</th>
                                <th style="width: 15%">Nome Produto</th>
                                <th style="width:5%">Qnt.</th>
                                <th style="width: 8%">Preço S/IVA</th>
                                <th style="width: 8%">% IVA</th>
                                <th style="width: 7%">Desconto (%)</th>
                                <th style="width: 7%">Preço S/IVA C/Desc</th>
                                <th style="width: 7%">Valor IVA (€)</th>
                                <th style="width: 10%">Valor Final</th>

                            </tr>

                            </thead>
                            <tbody id="linhas">
                            _linhas_
                            </tbody>

                            <thead>
                            <th colspan="6"></th>
                            <th class="text-right">Valor IVA <br><b id="total_valor_iva"></b></th>
                            <th class="text-right">Valor Final <br> <b id="total_valor_liquido"></b></th>
                            </thead>
                        </table>
                    </div>
                </div>

                <div hidden>
                    <table  id="myTable" class="table table-vcenter table-bordered ">
                        <thead>
                        <tr class="header">
                            <th style="width: 30%">Referências</th>
                        </tr>
                        </thead>
                        <tbody class="body-for-modal">
                        _searchProdutos_
                        <div class="linhasProd"></div>
                        </tbody>
                    </table>
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

            </form>
        </div>
    </div>
</div>


