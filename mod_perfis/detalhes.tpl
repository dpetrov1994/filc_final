<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form class="form-horizontal form-bordered">
                <div class="form-group">
                    <div class="col-md-4 col-xs-6">
                        <div class="col-lg-6">
                            <label>ID:</label> #_idItem_
                            <br><a href="../logs/index.php?&id_item=_idItem_&nome_tabela=mod_perfis" target="_blank"><i class="fa fa-history"></i> Histórico (_cntRevisoes_)</a>

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
                            <input id="nome_perfil" name="nome_perfil" maxlength="250"  class="form-control" placeholder=""  type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-xs-6">
                        <label class="col-lg-12" >1 - Muito pouca</label>
                        <div class="col-lg-12">
                            <textarea id="n1" name="n1" rows="10" class="form-control">_n1_</textarea>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="col-lg-12" >2 - Pouca</label>
                        <div class="col-lg-12">
                            <textarea id="n2" name="n2" rows="10" class="form-control">_n2_</textarea>
                        </div>
                    </div></div><div class="form-group form-group-sm">
                    <div class="col-xs-6">
                        <label class="col-lg-12">3 - Rasoável</label>
                        <div class="col-lg-12">
                            <textarea id="n3" name="n3" rows="10" class="form-control">_n3_</textarea>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="col-lg-12" >4 - Boa</label>
                        <div class="col-lg-12">
                            <textarea id="n4" name="n4" rows="10" class="form-control">_n4_</textarea>
                        </div>
                    </div></div><div class="form-group form-group-sm">
                    <div class="col-xs-6">
                        <label class="col-lg-12" >5 - Muito Boa</label>
                        <div class="col-lg-12">
                            <textarea id="n5" name="n5" rows="10" class="form-control">_n5_</textarea>
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

            </form>
        </div>
    </div>
</div>