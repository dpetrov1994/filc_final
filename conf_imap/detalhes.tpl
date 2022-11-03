<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form class="form-horizontal form-bordered">
                <div class="form-group">
                    <div class="col-md-4 col-xs-6">
                        <div class="col-lg-6">
                            <label>ID:</label> #_idItem_
                            <br><a href="../logs/index.php?&id_item=_idItem_&nome_tabela=_conf_imap" target="_blank"><i class="fa fa-history"></i> Histórico (_cntRevisoes_)</a>

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
                    <label class="CasoQueiramosMeterLarguraDaColuna" >Nome </label>
                    <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                        <input id="nome_conf" name="nome_conf" maxlength="250"  class="form-control" placeholder=""  type="text">
                    </div>
                </div>
            </div>
<div class="form-group form-group-sm">
    <div class="col-xs-12">
        <h4 class="text-center">IMAP</h4>
    </div>
            <div class="col-xs-6">
              <label class="col-lg-12">Servidor</label>
              <div class="col-lg-12">
                  <input id="servidor" name="servidor" required maxlength="250"  class="form-control" type="text">
              </div>
            </div>
            <div class="col-xs-6">
              <label class="col-lg-12">Utilizador</label>
              <div class="col-lg-12">
                  <input id="utilizador" name="utilizador" required maxlength="250"  class="form-control" type="text">
              </div>
            </div></div><div class="form-group form-group-sm">
            <div class="col-xs-6">
              <label class="col-lg-12">Password</label>
              <div class="col-lg-12">
                  <input id="password" name="password" required maxlength="250"  class="form-control" type="text">
              </div>
            </div>
            <div class="col-xs-6">
              <label class="col-lg-12">Encriptação</label>
              <div class="col-lg-12">
                  <input id="encryption" name="encryption" required maxlength="250"  class="form-control" type="text">
              </div>
            </div></div><div class="form-group form-group-sm">
            <div class="col-xs-6">
              <label class="col-lg-12">Prefixo das pastas</label>
              <div class="col-lg-12">
                  <input id="folder_prefix" name="folder_prefix" maxlength="250"  class="form-control" type="text">
              </div>
            </div>
            <div class="col-xs-6">
              <label class="col-lg-12">Pasta dos recebidos</label>
              <div class="col-lg-12">
                  <input id="inbox_folder_name" name="inbox_folder_name" maxlength="250"  class="form-control" type="text">
              </div>
            </div></div><div class="form-group form-group-sm">
            <div class="col-xs-6">
              <label class="col-lg-12">Pasta dos enviados</label>
              <div class="col-lg-12">
                  <input id="sent_folder_name" name="sent_folder_name" maxlength="250"  class="form-control" type="text">
              </div>
            </div>
            </div>

                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <h4 class="text-center">SMTP</h4>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <label class="col-lg-12">Servidor SMTP</label>
                        <div class="col-lg-12">
                            <input id="servidor_smtp" name="servidor_smtp" required maxlength="250"  class="form-control" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-xs-6">
                        <label class="col-lg-12">Porta</label>
                        <div class="col-lg-12">
                            <input id="porta" name="porta" required maxlength="250"  class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="col-lg-12">Nome nos emails</label>
                        <div class="col-lg-12">
                            <input id="nome" name="nome" required maxlength="250"  class="form-control" type="text">
                        </div>
                    </div>
                </div>
<div class="form-group form-group-sm">
    <div class="col-xs-12">
        <label class="CasoQueiramosMeterLarguraDaColuna" >Observações </label>
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