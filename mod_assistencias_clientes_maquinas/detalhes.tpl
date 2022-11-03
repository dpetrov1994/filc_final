<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form class="form-horizontal form-bordered">
                <div class="form-group">
                    <div class="col-md-4 col-xs-6">
                        <div class="col-lg-6">
                            <label>ID:</label> #_idItem_
                            <br><a href="../logs/index.php?&id_item=_idItem_&nome_tabela=assistencias_clientes_maquinas" target="_blank"><i class="fa fa-history"></i> Histórico (_cntRevisoes_)</a>

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

                
            <div class="form-group form-group-sm">
                <div class="col-xs-12">
                    <label class="col-lg-12" >Nome </label>
                    <div class="col-lg-12 input-status">
                        <input id="nome_assistencia_cliente_maquina" name="nome_assistencia_cliente_maquina" maxlength="250"  class="form-control" placeholder=""  type="text">
                    </div>
                </div>
            </div>
<div class="form-group form-group-sm">
            <div class="col-xs-6">
                <label class="col-lg-12" >Máquina</label>
                <div class="col-lg-12 input-status">
                    <select id="id_maquina" name="id_maquina" required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                        <option></option>
                        _id_maquina_
                    </select>
                </div>
            </div>
            <div class="col-xs-6">
                <label class="col-lg-12" >Assistencia</label>
                <div class="col-lg-12 input-status">
                    <select id="id_assistencia" name="id_assistencia" required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                        <option></option>
                        _id_assistencia_
                    </select>
                </div>
            </div></div><div class="form-group form-group-sm">
            <div class="col-xs-6">
                <label class="col-lg-12" >Defeitos</label>
                <div class="col-lg-12">
                    <textarea id="defeitos" name="defeitos" required rows="10" class="form-control"></textarea>
                </div>
            </div>
            <div class="col-xs-6">
                <label class="col-lg-12" >Atividade</label>
                <div class="col-lg-12">
                    <textarea id="atividade" name="atividade" required rows="10" class="form-control"></textarea>
                </div>
            </div></div><div class="form-group form-group-sm">
            <div class="col-xs-6">
                <label class="col-lg-12" >Peças</label>
                <div class="col-lg-12">
                    <textarea id="pecas" name="pecas" required rows="10" class="form-control"></textarea>
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

            </form>
        </div>
    </div>
</div>