<div class="row">
    <div class="col-lg-12"><br></div>
</div>
<div class="row">
    <div class="col-xs-12">
        <a class="btn btn-block btn-lg btn-primary"  href="../_contents/assistencias_clientes_pdfs/_idItem_/_nomepdf_"><i class="fa fa-download"></i> <b>Descarregar Relatório</b></a>
        <br>
    </div>

</div>

<div class="row">
    <div class="col-lg-6">
        <div class="block">
            <form id="form-para-validar" class="form-horizontal form-bordered" action="editar.php_addUrl_" method="post" enctype="multipart/form-data">

                <!-- colar aqui os itens do formulário-->
            <div class="form-group form-group-sm">
                <div class="col-xs-6">
                    <label class="col-lg-12" >Nº Pedido </label>
                    <div class="col-lg-12 input-status">
                        <input disabled id="nome_assistencia_cliente" name="nome_assistencia_cliente" maxlength="250"  class="form-control" placeholder=""  type="text">
                    </div>
                </div>
                <div class="col-xs-6 input-status">
                    <label class="csscheckbox csscheckbox-primary"><input type="radio" checked="" name="externa" value="0"><span></span> <i class="fa fa-home"></i> Interna</label><br>
                    <label class="csscheckbox csscheckbox-primary"><input type="radio" name="externa" id="externa" value="1"><span></span> <i class="fa fa-truck"></i> Externa</label>

                </div>
            </div>
<div class="form-group form-group-sm">
            <div class="col-xs-6">
                <label class="col-lg-12" >Cliente</label>
                <div class="col-lg-12 input-status">
                    <select id="id_cliente" name="id_cliente" disabled required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                        <option></option>
                        _id_cliente_
                    </select>
                </div>
            </div>
            <div class="col-xs-6">
                <label class="col-lg-12" >Técnico</label>
                <div class="col-lg-12 input-status">
                    <select id="id_utilizador" name="id_utilizador" disabled required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                        <option></option>
                        _id_utilizador_
                    </select>
                </div>
            </div>
</div>

<div class="form-group form-group-sm">
            <div class="col-xs-6">
                <label class="col-lg-12" >Data inicio</label>
                <div class="col-lg-12 input-status">
                    <input id="data_inicio" value="_datainicio_" name="data_inicio" class="form-control"  type="datetime-local">
                </div>
            </div>
            <div class="col-xs-6">
                <label class="col-lg-12" >Data fim</label>
                <div class="col-lg-12 input-status">
                    <input id="data_fim" value="_datafim_" name="data_fim" class="form-control"  type="datetime-local">
                </div>
            </div>
</div>

<div class="form-group form-group-sm">
            <div class="col-xs-12">
                <label class="col-lg-12" >Tempo de serviço</label>
                <div class="col-lg-12 input-status">
                    <input class="form-control" disabled value="_tempoServico_" type="time">
                </div>
            </div>
            </div>
<div class="form-group form-group-sm">
            <div class="col-xs-6">
                <label class="col-lg-12" >Tempo pausas</label>
                <div class="col-lg-12 input-status">
                    <input class="form-control" value="_tempoPausa_" name="segundos_pausa" type="time">
                </div>
            </div>
            <div class="col-xs-6">
                <label class="col-lg-12" >Tempo de viagem (iva e volta)</label>
                <div class="col-lg-12 input-status">
                    <input class="form-control" value="_tempoViagem_" name="tempo_viagem" type="time">
                </div>
            </div>
</div>


<div class="form-group form-group-sm">
            <div class="col-xs-12">
                <label class="col-lg-12" >Tempo a descontar no contrato/faturar</label>
                <div class="col-lg-12 input-status">
                    <input class="form-control" value="_tempoContabilizar_" name="tempo_contabilizar" type="time">
                </div>
            </div>
</div>
<div class="form-group form-group-sm">
            <div class="col-xs-12">
                <label class="col-lg-12" >Contrato a descontar</label>
                <div class="col-lg-12 input-status">
                    <select id="id_contrato" name="id_contrato" required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                        <option value="0">Nenhum</option>
                        _id_contrato_
                    </select>
                </div>
            </div>

</div>


                <div class="form-group form-group-sm">

                    <div class="col-xs-6">
                        <label class="col-lg-12" >Km's de viagem (iva e volta)</label>
                        <div class="col-lg-12 input-status">
                            <input class="form-control" id="kilometros" name="kilometros" type="number">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="col-lg-12" >Preço por KM</label>
                        <div class="col-lg-12 input-status">
                            <input class="form-control" id="preco_km" name="preco_km" type="number">
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <label class="col-lg-12" >Categoria</label>
                        <div class="col-lg-12 input-status">
                            <select id="id_categoria" name="id_categoria" required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                                <option value="0">Sem Categoria</option>
                                _id_categoria_
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
                        <button type="submit" name="submit" id="botao_loading" class="btn btn-effect-ripple btn-success pull-right btn-submit" data-loading-text="<i class='fa fa-asterisk fa-spin'></i> Aguarde">Guardar e atualizar relatório</button>
                        <button type="reset" class="btn btn-effect-ripple btn-danger">Limpar</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <div class="col-lg-6">
        <div class="block">
            <div class="block-section" >
                <div class="row">
                    <div class="col-xs-12">

                        <div class="block-title">
                            <h2>Máquinas</h2>
                        </div>

                        <div class='linha-assistencia-cliente-maquina' id_assistencia_cliente="_id_assistencia_cliente_">

                            _maquinasassistencia_

                        </div>

                        <div class="text-center adicionar-maquina">
                            <a class="btn btn-info btn add-linha" href="javascript:void(0)" onclick="addMaquinaModal(this)"><i class="fa fa-plus"></i> Adicionar maquina </a>

                        </div>
                        <br>

                    </div>
                </div>
            </div>
        </div>


        <div class="block">
            <div class="block-title"><h4><i class="fa fa-map"></i> Local de assinatura</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="" id="mapa">
                        <div id="mapid" class="text-center"></div>
                    </div>

                    <br>
                    <br>
                </div>
            </div>
        </div>

    </div>

</div>


<div id="modal-adicionar-maquinas" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">
            <input class="hidden id_assistencia_cliente_modal" readonly>
            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><a href="javascript:void(0)" class="go-back-arrow" onclick="closeModal('#modal-adicionar-maquinas')">  <i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>
            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" style="margin-bottom: 20px">
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h2>Adicionar Maquina</h2>
                            </div>


                            <!-- Preenchido com AJAX -->
                            <label>Máquinas</label>
                            <div>
                                <div style="display: flex; grid-gap: 10px">
                                    <select id="id_maquina" name="id_maquina" required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                                        <option></option>
                                        _opsMaquinas_
                                    </select>
                                    <a href="javascript:void(0)" onclick="openModal('#modal-criar-maquina', '1', '_idCliente_')" class="btn btn-effect-ripple btn-success pull-right btn-submit"><i class="fa fa-plus"></i></a>
                                </div>


                                <a style="margin-top: 25px; cursor: pointer"  onclick="addMaquina()" class="btn btn-effect-ripple btn-success pull-right btn-submit">Adicionar</a>
                            </div>


                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>



<!--
<div class="block-section">
    <div class="col-xs-12">

        <div class="col-xs-6">
            <a href="javascript:void(0)" class="go-back-arrow" onclick="closeModal('#modal-mostrar-detalhes-maquina')">  <i class="fa fa-angle-left"></i> Voltar </a>
        </div>
        <div class="col-xs-6 text-right">
            <a class="btn btn-info" onclick="OpenModalHistoricoMaquina(_id_maquina_)"  href="javascript:void(0)"> Ver historico </a>
        </div>
    </div>
</div>-->


<div id="modal-mostrar-detalhes-maquina" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">
            <input class="hidden" id="id_assistencia_cliente_maquina_modal" readonly>
            <input class="hidden" id="id_maquina" readonly>
            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-mostrar-detalhes-maquina');">  <i class="fa fa-angle-left"></i> Voltar </a></h3>
                <a class="pull-right text-light" href="javascript:void(0)" onclick="confirmaModalAjax2()"> <i class="fa fa-trash"></i> </a>
            </div>
            <div class="modal-body" style="padding: 10px;">

                <!-- Preenchido com AJAX -->


            </div>
            <div style="margin-left: 10px;margin-right: 10px;"><a href="javascript:void(0)" class="btn btn-block btn-info" onclick="closeModal('#modal-mostrar-detalhes-maquina')">  <i class="fa fa-angle-left"></i> Voltar </a></div>

        </div>
    </div>
</div>
