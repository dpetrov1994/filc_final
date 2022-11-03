<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form id="form-para-validar" class="form-horizontal form-bordered" action="editar.php_addUrl_" method="post" enctype="multipart/form-data">

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
                    </div></div>
                <div class="text-center">
                    <a href="javascript:void(0);" onclick="validar_imap()">Testar Conexão e listar pastas</a>
                </div>
                <div id="result"></div>
                <hr>

                <div class="form-group form-group-sm">
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
                <hr>
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
                        <div class="text-center">
                            <label>Email de destino para teste</label>
                            <input class="form-control" id="destino_teste">
                            <a href="javascript:void(0);" onclick="validar_smtp()">Enviar email de teste</a>
                        </div>
                        <div id="result_envio"></div>
                    </div>

                    <hr>
                    <div class="form-group form-group-sm">
                        <div class="col-xs-12">
                            <label class="CasoQueiramosMeterLarguraDaColuna" >Observações </label>
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