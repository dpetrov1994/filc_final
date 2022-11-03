<div class="row">
    <div class="col-lg-12">
        <br>
    </div>
</div>


        <div class="row">


            <div class="col-lg-6">
                <div class="row">
                    <div class="col-xs-6">
                        <a href="javascript:void(0)" class="widget">
                            <div class="widget-content widget-content-mini text-right clearfix">
                                <div class="widget-icon pull-left themed-background">
                                    <i class="fa fa-clock-o text-light"></i>
                                </div>
                                <h2 class="widget-heading h3">
                                    <strong><span>_tempo_</span></strong>
                                </h2>
                                <span class="text-muted">Tempo Disponível</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-6">
                        <a href="javascript:void(0)" class="widget">
                            <div class="widget-content widget-content-mini text-right clearfix">
                                <div class="widget-icon pull-left themed-background">
                                    <i class="fa fa-arrows-h text-light"></i>
                                </div>
                                <h2 class="widget-heading h3">
                                    <strong><span>_movimentos_</span></strong>
                                </h2>
                                <span class="text-muted">Movimentos</span>
                            </div>
                        </a>
                    </div>
                </div>
                <br>
                <div class="block">
                    <div class="block-title"><h4><i class="fa fa-history"></i> Histórico Movimentos</h4>
                        <div class="block-options pull-right">
                            <a href="#modal-adicionar-movimento" class="btn btn-effect-ripple btn-default" data-toggle="modal"><span class="btn-ripple animate"></span><i class="fa fa-plus"></i></a>
                            <a href="detalhes.php?id=_idItem_&recalcular" class="btn btn-effect-ripple btn-default" data-toggle="tooltip" title="" data-original-title="Recalcular"><span class="btn-ripple animate"></span><i class="fa fa-calculator"></i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            _carregamentos_
                        </div>
                    </div>
                </div>


            </div>


            <div class="col-lg-6">
                <br>
                <br>
                <br>
                <div class="block">
                    <form class="form-horizontal form-bordered">


                        <!-- colar aqui os itens do formulário-->


                        <div class="form-group form-group-sm">
                            <div class="col-xs-6">
                                <label class="CasoQueiramosMeterLarguraDaColuna" >Nome do contrato</label>
                                <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                                    <input id="nome_contrato" name="nome_contrato" disabled maxlength="250"  class="form-control" placeholder=""  type="text">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <label class="CasoQueiramosMeterLarguraDaColuna" >Cliente</label>
                                <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                                    <select id="id_cliente" name="id_cliente" disabled required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                                        <option></option>
                                        _id_cliente_
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <div class="col-xs-12">
                                <label class="CasoQueiramosMeterLarguraDaColuna" >Observações </label>
                                <div class="CasoQueiramosMeterLarguraDaColuna">
                                    <textarea id="descricao" rows="5" name="descricao" class="form-control">_descricao_</textarea>
                                </div>
                            </div>
                        </div>


                        <!-- fim itens do formulário-->

                        <div class="form-group">
                            <div class="col-xs-6 col-lg-4">
                                <div class="col-lg-12">
                                    <label>ID:</label> #_idItem_
                                    <br><a href="../logs/index.php?&id_item=_idItem_&nome_tabela=clientes_contratos" target="_blank"><i class="fa fa-history"></i> Histórico (_cntRevisoes_)</a>

                                </div>
                                <div class="col-lg-12">
                                    <label>Estado:</label> _ativo_
                                </div>
                            </div>
                            <div class=" col-xs-6 col-lg-4">
                                <label class="CasoQueiramosMeterLarguraDaColuna" >Criado por: </label>
                                <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                                    <a href="../utilizadores/detalhes.php?id=_idCriou_">_nomeCriou_</a>
                                    <br>_dataCriado_
                                </div>
                            </div>
                            <div class=" col-xs-6 col-lg-4">
                                <label class="CasoQueiramosMeterLarguraDaColuna" >Editado por: </label>
                                <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                                    <a href="../utilizadores/detalhes.php?id=_idAtualizou_">_nomeAtualizou_</a>
                                    <br>_dataAtualizado_
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
</div>



<div id="modal-adicionar-movimento" class="modal " role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><strong>Adicionar movimento</strong></h3>
            </div>
            <div class="modal-body" id="modal-adicionar-movimento-body" style="">
                _adicionarMovimento_
            </div>
        </div>
    </div>
</div>