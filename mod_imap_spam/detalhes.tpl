<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form class="form-horizontal form-bordered">
                <div class="form-group">
                    <div class="col-md-4 col-xs-6">
                        <div class="col-lg-6">
                            <label>ID:</label> #_idItem_
                            <br><a href="../logs/index.php?&id_item=_idItem_&nome_tabela=imap_spam" target="_blank"><i class="fa fa-history"></i> Histórico (_cntRevisoes_)</a>

                        </div>
                        <div class="col-lg-6">
                            <label>Estado:</label> _ativo_
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-6">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Criado por: </label>
                        <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                            <a href="../utilizadores/detalhes.php?id=_idCriou_">_nomeCriou_</a>
                            <br>_dataCriado_
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-6">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Editado por: </label>
                        <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                            <a href="../utilizadores/detalhes.php?id=_idAtualizou_">_nomeAtualizou_</a>
                            <br>_dataAtualizado_
                        </div>
                    </div>
                </div>

                <!-- colar aqui os itens do formulário-->


                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Email </label>
                        <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                            <input id="nome_spam" name="nome_spam" maxlength="250"  class="form-control" placeholder=""  type="text">
                        </div>
                    </div>
                </div>


                <!-- fim itens do formulário-->

            </form>
        </div>
    </div>
</div>