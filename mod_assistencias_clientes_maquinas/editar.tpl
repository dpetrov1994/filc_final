<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form id="form-para-validar" class="form-horizontal form-bordered" action="editar.php_addUrl_" method="post" enctype="multipart/form-data">

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