<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form class="form-horizontal form-bordered">
                <div class="form-group">
                    <div class="col-md-4 col-xs-6">
                        <div class="col-lg-6">
                            <label>ID:</label> #_idItem_
                            <br><a href="../logs/index.php?&id_item=_idItem_&nome_tabela=produtos" target="_blank"><i class="fa fa-history"></i> Histórico (_cntRevisoes_)</a>

                        </div>
                        <div class="col-lg-6">
                            <label>Estado:</label> _ativo_
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-6">
                        <label class="col-lg-12" >Criado por: </label>
                        <div class="col-lg-12 input-status">
                            <a href="../utilizadores/editar.php?id=_idCriou_">_nomeCriou_</a>
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
                            <input id="nome_produto" name="nome_produto" maxlength="250"  class="form-control" placeholder=""  type="text">
                        </div>
                    </div>
                    <div class="col-xs-6 col-lg-6">
                        <label class="col-lg-12">Preço</label>
                        <div class="col-lg-12">
                            <input id="preco_sem_iva" name="preco_sem_iva" maxlength="250"  class="form-control" type="text">
                        </div>
                    </div>
                </div>


                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <label class="col-lg-12" >Descrição do produto e características </label>
                        <div class="col-lg-12">
                            _descricao_
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <div class="col-lg-12 text-center">
                        <img src="_foto_" id="preview" class="img-thumbnail">
                        <br>
                        <br>
                        <div class="col-xs-6 col-xs-offset-3">
                            <input   type="file" onchange="readURL(this,'preview')" id="file" name="file" accept="image/*" class="inputfile inputfile-2"><label for="file" class="" id="file_label"><i class="fa fa-upload"></i> <span>Selecione uma imagem </span></label>
                        </div>
                    </div>
                </div>


                <!-- fim itens do formulário-->

            </form>
        </div>
    </div>
</div>