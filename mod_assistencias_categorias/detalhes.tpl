<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form class="form-horizontal form-bordered">
                <div class="form-group">
                    <div class="col-md-4 col-xs-6">
                        <div class="col-lg-6">
                            <label>ID:</label> #_idItem_
                            <br><a href="../logs/index.php?&id_item=_idItem_&nome_tabela=assistencias_categorias" target="_blank"><i class="fa fa-history"></i> Histórico (_cntRevisoes_)</a>

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
                    <div class="col-xs-6">
                        <label class="col-lg-12" >Nome </label>
                        <div class="col-lg-12 input-status">
                            <input id="nome_categoria" name="nome_categoria" maxlength="250"  class="form-control" placeholder=""  type="text">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="col-lg-12">Cor</label>
                        <div class="col-lg-12">
                            <div class="input-group input-colorpicker colorpicker-element">
                                <input id="cor_cat" name="cor_cat" class="form-control" type="text">
                                <span class="input-group-addon"><i style="background-color: #cb5519"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm text-center">
                    <label>Só para comerciais<br>
                        <label class="switch switch-primary">
                            <input type="hidden" name="comercial" value="0">
                            <input type="checkbox" name="comercial" id="comercial" value="1" >
                            <span></span>
                        </label>
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