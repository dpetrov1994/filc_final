<div class="text-center" style="margin-bottom: 10px">
    <h4><b>_nomecliente_</b><br><b class="text-muted">_data_</b></h4>
</div>

<div class="block bloco-alerta-clientes">
    <div class="block-section" >
        <div class="col-xs-12">

            <div class="block-title">
                <h2>Alertas do Cliente</h2>
            </div>

            <div class="alertas-cliente">
                _alertacliente_
            </div>

        </div>
    </div>
</div>

<div class="block [ESCONDER-COMERCIAL]">
    <div class="block-section" >
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

<div class="block">
    <div class="block-section">
        <div class="col-xs-12">

            <div class="block-title">
                <h2>Observações gerais do serviço</h2>
            </div>


            <textarea id="descricao_assistencia_cliente" name="descricao" rows="5" onblur="updateInput('#descricao_assistencia_cliente','_id_assistencia_cliente_', 'assistencias_clientes','','0',0)" class="form-control">_descricaoassistenciacliente_</textarea>
            <br>
        </div>

    </div>
</div>


<div [ESCONDER-SE-NAO-EM-PAUSA] class="bloco-play text-center">
    <a class="btn btn-default btn-block btn-play" href="javascript:void(0)" onclick="colocarEmPausa(_id_assistencia_cliente_)"><i class="fa fa-play"></i> Retomar Serviço</a>
</div>
<div [ESCONDER-SE-EM-PAUSA] class="bloco-pausa text-center">
    <a class="btn btn-default btn-block btn-pausa" href="javascript:void(0)" onclick="colocarEmPausa(_id_assistencia_cliente_)"><i class="fa fa-pause"></i> Colocar em pausa</a>
</div>
<div [ESCONDER-SE-EM-PAUSA] class="bloco-terminar-assinar">
    <div class="text-center">
        <a class="btn btn-info btn-block " href="javascript:void(0)" onclick="abrirModalAssinatura(_id_assistencia_cliente_)"><i class="fa fa-check"></i> Assinar</a>
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
                                        _maquinas_
                                    </select>
                                    <a href="javascript:void(0)" onclick="openModal('#modal-criar-maquina', '1', '_id_cliente_')" class="btn btn-effect-ripple btn-success pull-right btn-submit"><i class="fa fa-plus"></i></a>
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



<div id="modal-assinatura_assistencia" class="modal modal-assinatura_assistencia" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">
            <input class="hidden" id="id_assistencia_cliente_modal" readonly>
            <div class="modal-header">
                <button type='button' class='close hidden' aria-hidden='true'>×</button>
                <h3 class="modal-title"><a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-assinatura_assistencia')">  <i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>
            <div class="modal-body" style="padding: 10px;">

                <div class="text-center" style="margin-bottom: 5px">
                    <h4><b class="nomeCliente"><i class="fa fa-user"></i> _nomecliente_</b></h4>

                </div>

                <div class="block">
                    <div class="block-section">
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h2>Tempos e KM's</h2>
                            </div>

                            <input type="hidden" id="latitude">
                            <input type="hidden" id="longitude">

                            <div class="d-flex-c" style="grid-gap: 10px; margin: 10px 0;">
                                <div class="row">
                                <div class="col-lg-12 input-status">
                                    <label>Hora de fim do serviço</label>
                                    <span style="display: flex; grid-gap: 20px"> <input id="data_fim_assinar_paragem" name="data_fim" class="form-control"  type="time">   <a class="btn btn-xs" style="background: #606060;color: white;align-self: center;" onclick="colocarTempoAtual('#data_fim_assinar_paragem')"> Hora atual </a></span>

                                </div>
                                <!--
                                <div class="col-lg-12 input-status">
                                    <label>Insira as horas do serviço</label>
                                    <span style="display: flex; grid-gap: 20px"> <input id="horas_assistencia" name="horas_assistencia" value="00:30" class="form-control"  type="time">
                                    </span>
                                </div>
                                -->
                                <input type="hidden" id="tipo-assistencia" value="[TIPO-ASSISTENCIA]">
                                <div class="[ESCONDER-PARA-INTERNAS] [ESCONDER-COMERCIAL] col-lg-12" style="margin-top: 20px">
                                        <div class="row">
                                            <div class="col-lg-6 col-xs-6 input-status">
                                                <label>Distância em KM's<br> (ida e volta)</label>
                                                <input type="number" id="kilometros" name="kilometros" value="0" class="form-control kilometros">
                                            </div>
                                            <div class="col-lg-6 col-xs-6 input-status">
                                                <label>Tempo de Viagem<br> (ida e volta)</label>
                                                <span style="display: flex; grid-gap: 20px"> <input id="tempo_viagem" name="tempo_viagem" value="00:30" class="form-control"  type="time">
                                                </span>
                                            </div>
                                    </div>
                                </div>

                                    <div class="col-lg-12 input-status">
                                        <label>Tempo pausas</label>
                                        <span style="display: flex; grid-gap: 20px"> <input id="tempo_pausa" name="tempo_pausa" value="00:00" class="form-control"  type="time">
                                                </span>
                                    </div>
                                <div class="[ESCONDER-PARA-EXTERNAS]">
                                    <div class="col-lg-12 ">
                                        <i class="fa fa-info-circle text-info"></i> <span class="text-info"> Como é uma assistência interna não precisa de inserir os KM's e o tempo de viagem.</span>
                                    </div>
                                </div>
                                </div>



                                <div class="col-lg-12 input-status [ESCONDER-COMERCIAL]">
                                    <label class="text-center" style="width: 100%;">Serviço concluído?</label>
                                    <span style="display: flex; grid-gap: 20px">
                                        <table style="margin:0px" class="table table-borderless table-vcenter">
                                                <tbody>
                                                <tr>
                                                    <td class="text-right"><b class="">Não</b></td>
                                                    <td class="text-center" style="width: 60px">
                                                        <label class="switch switch-primary">
                                                            <input type="checkbox" value="1" checked onchange="mostrarSeNaoChecked('.mostrar-se-por-terminar',this.checked);mostrarSeChecked('.mostrar-servicos-a-terminar',this.checked);" name="servico_concluido" id="servico_concluido">
                                                            <span></span>
                                                        </label>
                                                    </td>
                                                    <td class="text-left"><b class="">Sim</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-center"><small class="text-danger info_maquinas_pendentes" ></small></td>
                                                </tr>
                                                </tbody>
                                            </table>

                                    </span>
                                </div>
                                <div class="col-lg-12 input-status mostrar-se-por-terminar" style="display: none">
                                    <label>Marcar já a próxima visita:</label><br>
                                    <small class="text-muted"><i class="fa fa-info-circle text-info"></i> Deixe vazio se não souber.</small>
                                    <span style="display: flex; grid-gap: 20px"> <input id="data_proxima_visita" name="data_proxima_visita" class="form-control"  type="datetime-local"></span>


                                </div>
                                <div class="col-lg-12 input-status mostrar-servicos-a-terminar [ESCONDER-COMERCIAL]">
                                    <div class="aviso-assistencias-por-terminar">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="block [ESCONDER-COMERCIAL]">
                    <div class="block-section">
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h2>Contrato de horas</h2>
                            </div>

                            _pacotes_

                        </div>
                    </div>
                </div>

                <div class="block [ESCONDER-COMERCIAL]">
                    <div class="block-section">
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h2>Emails</h2>
                            </div>

                            <div class="text-center">
                                <label>Enviar email para cliente com o relatório?</label><br>
                                <label class="switch switch-primary">
                                    <input type="checkbox" class="enviar-email" checked value="1"  name="enviar_email" id="enviar_email">
                                    <span></span>
                                </label>
                            </div>


                            <div class="table-responsive">

                                <table class="table table-striped table-hover table-bordered table-vcenter">

                                    <thead>
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-center">Email</th>
                                        </tr>
                                    </thead>

                                    <tbody id="linhas-emails" class="linhas-emails">

                                        _linhasemails_

                                    </tbody>

                                </table>

                            </div>

                            <div class="text-center" style="margin-top: 25px"><a class="btn btn-info btn-xs add-linha"  href="javascript:void(0)" onclick="addLinha(this,'#linhas-emails');" data-linha="_linhaassinatura_"><i class="fa fa-plus"></i> Adicionar destinatários</a></div>
                            <br>
                        </div>
                    </div>
                </div>




                <div class="block [ESCONDER-COMERCIAL]">
                    <div class="block-section">
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h2>Assinar</h2>
                            </div>

                            <input id="comercial" type="hidden" value="[COMERCIAL]">

                            <div class=" text-center assinatura-atual" id="div_assinatura">

                                <span><input type="checkbox" checked name="substituir_assinatura" class="substituir-assinatura" style="margin-right: 5px">Substituir assinatura</span><br><br>

                                <label class="CasoQueiramosMeterLarguraDaColuna" > Assinatura atual </label>
                                <br>
                                <img class="assinatura-atual-img" src="_dirAssinatura_">
                                <br>

                            </div>

                            <div class="row">
                                <div class=" text-center" id="div_assinatura">
                                    <label class="CasoQueiramosMeterLarguraDaColuna" ><i class="fa fa-pencil"></i> _nova_ Assinatura </label>
                                    <div class="input-status col-lg-12" id="signature-pad">
                                        <canvas class="signature-pad " style="width: 100%;height: 300px; border: 2px dashed gray" ></canvas><br>

                                        <button type="button" id="clear" class="btn btn-main btn-xs"><i class="fa fa-eraser"></i> Limpar assinatura</button>
                                        <br>
                                        <br>
                                        <label>Nome da assinatura</label><br>
                                        <input class="form-control" placeholder="Nome da assinatura" value="_nomeAssinatura_" id="nome_assinatura">
                                        <br>
                                    </div>

                                    <input id="assinatura" name="assinatura" type="text"  style="display: none">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="text-center" style="margin-top: 5px">
                    <a class="btn btn-info btn-block assinar" href="javascript:void(0)"><i class="fa fa-check"></i> Terminar Serviço </a>
                    <h3 class="text-center text-muted" id="assinar-aguarde" style="display: none"><i class="fa fa-spinner fa-spin"></i><br> Aguarde..</h3>
                </div>
                <br>


        </div>
    </div>
</div>
</div>
