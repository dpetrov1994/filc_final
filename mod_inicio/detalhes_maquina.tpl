
<div class="text-center" style="margin-bottom: 10px">

    <h4><b>_nomecliente_</b></h4>
    <h5 class="">
        Máquina: <br><b class="">_nomemaquina_  ( _ref_ )</b>

    </h5>
    <a class="btn btn-main btn-xs  " style="grid-gap: 10px" onclick="OpenModalHistoricoMaquina()"  href="javascript:void(0)"><i class="fa fa-history"></i> Histórico desta máquina </a>

</div>

<div class="block">
    <div class="block-section" >
        <div class="col-xs-12">
            <div class="block-title">
                <h2>Garantia</h2>
            </div>
            <div class="text-center">
                <label>Serviço coberto por garantia?</label><br>
                <label class="switch switch-primary">
                    <input type="checkbox" value="on" onclick="updateInput('#garantia','_id_assistencia_cliente_maquina_', 'assistencias_clientes_maquinas','','0',0);getListaMaquinasAssistencia([ID-ASSISTENCIA-CLIENTE],1000)" name="garantia" id="garantia">
                    Não <span></span> Sim
                </label>
            </div>
            <br>
        </div>
    </div>
</div>

<div class="block">
    <div class="block-section" >
        <div class="col-xs-12">
            <div class="block-title">
                <h2>Revisão</h2>
            </div>
            <div class="text-center">
                <label>Este serviço é uma revisão periódica?</label><br>
                <label class="switch switch-primary">
                    <input type="checkbox" value="on" onclick="mostrarSeChecked('#div-horas-revisao',this.checked);updateInput('#revisao_periodica','_id_assistencia_cliente_maquina_', 'assistencias_clientes_maquinas','','0',0);getListaMaquinasAssistencia([ID-ASSISTENCIA-CLIENTE],1000)" name="revisao_periodica" id="revisao_periodica">
                    Não <span></span> Sim
                </label>
            </div>
            <div class="text-left" id="div-horas-revisao" style="display: none;">
                <label>Nº horas da revisão</label><br>
                <input type="number" class="form-control" value="[HORAS-REVISAO]" min="[REVISAO-ANTERIOR]" onblur="updateInput('#horas_revisao','_id_assistencia_cliente_maquina_', 'assistencias_clientes_maquinas','','0',0);getListaMaquinasAssistencia([ID-ASSISTENCIA-CLIENTE],1000)" name="horas_revisao" id="horas_revisao" placeholder="Insira aqui as horas desta revisão..">


            </div>
            <div class="text-center">[REVISOES-ANTERIORES]</div>
            <br>
        </div>
    </div>
</div>


<div class="block">
    <div class="block-section" >
        <div class="col-xs-12">

            <div class="block-title">
                <h2>Defeito</h2>
            </div>

            <textarea id="defeitos" name="defeitos" rows="5" onblur="updateInput('#defeitos','_id_assistencia_cliente_maquina_', 'assistencias_clientes_maquinas','','0',0);getListaMaquinasAssistencia([ID-ASSISTENCIA-CLIENTE],1000)" class="form-control">_defeitos_</textarea>
            <br>
        </div>
    </div>
</div>




<div class="block">
    <div class="block-section" >
        <div class="col-xs-12">

            <div class="block-title">
                <h2>Atividade</h2>
            </div>

            <textarea id="atividade" name="atividade" rows="5" onblur="updateInput('#atividade','_id_assistencia_cliente_maquina_', 'assistencias_clientes_maquinas','','0',0)" class="form-control">_atividade_</textarea>

            <br>
        </div>
    </div>
</div>


<div class="block">
    <div class="block-section" >
        <div class="col-xs-12">

            <div class="block-title">
                <h2>Peças</h2>
            </div>

            <textarea id="descricao_pecas" name="descricao_pecas" rows="5" onblur="updateInput('#descricao_pecas','_id_assistencia_cliente_maquina_', 'assistencias_clientes_maquinas','','0',0)" class="form-control">_descricaopecas_</textarea>

            <br>
        </div>
    </div>
</div>

<!--
<div class="block bloco-pecas">
    <div class="block-section" >
        <div class="col-xs-12">

            <div class="block-title">
                <h2>Peças</h2>
            </div>

            <div class="table-responsive">

                <table class="table table-striped table-hover table-bordered table-vcenter">
                    <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center">Peça</th>
                        <th class="text-center">Qnt</th>
                    </tr>
                    </thead>
                    <tbody id="linhas-pecas" class="linhas-pecas">
                    _linhaspecas_
                    </tbody>

                </table>

            </div>

            <div class="text-center"><a class="btn btn-main btn-xs add-linha"  href="javascript:void(0)" onclick="addLinha(this,'#linhas-pecas');" data-linha='_linha_'><i class="fa fa-plus"></i> Adicionar linha</a></div>
            <div class="text-right" style="margin-top: 10px">

                <a class="btn btn-success btn-xs" href="javascript:void(0)" onclick="atualizarPecas('_id_assistencia_cliente_maquina_')"> Ok <i class="fa fa-save" style="padding-left: 5px"></i>
                </a>
            </div>
            <br>
        </div>
    </div>
</div>
-->


<div class="block">
    <div class="block-section" >
        <div class="col-xs-12">

            <div class="block-title">
                <h2>Observações</h2>
            </div>

            <textarea id="descricao" name="descricao" rows="5" onblur="updateInput('#descricao','_id_assistencia_cliente_maquina_', 'assistencias_clientes_maquinas','','0',0)" class="form-control">_descricaoassistenciaclientemaquina_</textarea>

            <br>
        </div>
    </div>
</div>

<div class="block">
    <div class="block-section" >
        <div class="col-xs-12">
            <div class="block-title">
                <h2>Conclusão do serviço nesta máquina.</h2>
            </div>
            <div class="text-center">
                <label>Ficou Concluído</label><br>
                <label class="switch switch-primary">
                    <input type="checkbox" value="on" onclick="mostrarSeChecked('#outros-servicos-com-esta-maquina',this.checked);updateInput('#concluido','_id_assistencia_cliente_maquina_', 'assistencias_clientes_maquinas','','0',0);getListaMaquinasAssistencia([ID-ASSISTENCIA-CLIENTE],1000)" name="concluido" checked id="concluido">
                    Não <span></span> Sim
                </label>
            </div>
            <div id="outros-servicos-com-esta-maquina" style="display: block">[outros-servicos-com-esta-maquina]</div>
            <br>
        </div>
    </div>
</div>





