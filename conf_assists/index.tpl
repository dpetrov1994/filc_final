<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="text-center"><a href="javascript:void(0)" class="btn btn-xs btn-primary mostra_filtros"><i class="fa fa-search"></i> Filtros/Pesquisa</a></div>

                                        <form id="form-pagina" class="form-horizontal form-bordered" action="index.php_addUrl_" method="post">

                                            <div class="form-group">
                                                <label class="col-md-3 control-label" >Dominio da plataforma (sem "https://")</label>
                                                <div class="col-md-6">
                                                    <input id="dominio" name="dominio" type="text" class="form-control">
                                                </div>
                                            </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" >Dias para aviso do Seguro</label>
                    <div class="col-md-6">
                        <input id="dias_para_aviso_seguro" name="dias_para_aviso_seguro" type="text" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" >Dias para aviso da Inspeção</label>
                    <div class="col-md-6">
                        <input id="dias_para_aviso_inspecao" name="dias_para_aviso_inspecao" type="text" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" >Dias para aviso da lavagem</label>
                    <div class="col-md-6">
                        <input id="dias_para_aviso_lavagem" name="dias_para_aviso_lavagem" type="text" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" >Intervalo de tempo para prolongar a lavagem (dias)</label>
                    <div class="col-md-6">
                        <input id="intervalo_tempo_lavagem" name="intervalo_tempo_lavagem" type="text" class="form-control">
                    </div>
                </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label" > Dia da semana para inserir KM's das viaturas</label>
                                                <div class="col-md-6">
                                                    <select id="dia_semana_viaturas" name="dia_semana_viaturas" class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                                                        _dia_semana_viaturas_
                                                    </select>
                                                </div>
                                            </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" >Tempo para o aviso do contrato de horas (h)</label>
                    <div class="col-md-6">
                        <input id="horas_aviso_contrato_horas" name="horas_aviso_contrato_horas" type="text" class="form-control">
                    </div>
                </div>

            <div class="form-group">
                <label class="col-md-3 control-label" >Gráfico de Eficiência - Numero de Horas</label>
                <div class="col-md-6">
                    <input id="horas_grafico_eficiencia" name="horas_grafico_eficiencia" type="text" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" > Emails para CC (Envio de PDF após terminar as  assistências)</label>
                <div class="col-md-6">
                    <input id="emails_cc" name="emails_cc" class="input-tags">
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-3 control-label" > Utilizador que vai receber notificações de novos contratos e movimentos de horas</label>
                <div class="col-md-6">
                    <select id="id_utilizador_notificar" name="id_utilizador_notificar" class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                        <option value="0">Não definido</option>
                        _id_utilizador_notificar_
                    </select>
                </div>
            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label" > Documentos de venda, (faturas) (positivos) (usado para calculo de vendas)</label>
                                                <div class="col-md-6">
                                                    <select id="documentos_fac" name="documentos_fac[]" multiple class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                                                        _documentos_fac_
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label" > Documentos de venda (Notas de credito) (negativos) (usado para calculo de vendas)</label>
                                                <div class="col-md-6">
                                                    <select id="documentos_nc" name="documentos_nc[]" multiple class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                                                        _documentos_nc_
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group form-actions">
                    <button type="submit" id="concluir" name="submit" class="btn btn-effect-ripple btn-success pull-right btn-submit" style="overflow: hidden; position: relative;">Concluir</button>
                    <button type="reset" class="btn btn-effect-ripple btn-danger" style="overflow: hidden; position: relative;">Limpar</button>
                </div>
            </form>
        </div>
    </div>
</div>