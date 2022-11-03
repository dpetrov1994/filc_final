<br>
<div class="row">


    <div class="col-lg-8">
        <div class="block">
            <h3 class="text-primary"><b>_nome_imap_</b></h3>
            <div class="text-muted" style="font-size: 12px">
                <label>Data do e-mail:</label> _data_email_<br>
                <label>Data Sincronizado:</label> _created_at_<br>
                <label>De:</label> _de_nome_ - _de_email_<br>
                <label>Para:</label> _para_nome_ - _para_email_<br>
                <label>CC:</label> _cc_<br>
            </div>
            <div class="corpo_email" style="background: white; color:black;padding: 10px;border-radius: 16px">
                _descricao_
            </div>
            <h4>Anexos</h4>
            _ficheiros_
            <br>

            <div class="text-right"><a href="javascript:void(0)" onclick="getFormResponder(_idItem_)" class="btn btn-primary"><i class="fa fa-share"></i> Responder a todos</a></div>

            <br>
            <br>
        </div>
    </div>
    <div class="col-lg-4">

        <div class="block">
            <h4>Aberturas do email</h4>
            <div style="max-height: 300px;overflow-y: scroll">
                _lido_
            </div>

        </div>

        <div class="block">
            <h4>Respostas</h4>
            <div style="max-height: 300px;overflow-y: scroll">
                _respostas_
            </div>

        </div>

        <div class="block">
            <h4>Meta</h4>
            <div class="row">

                <div class="form-group">
                    <div class="">
                        <div class="col-lg-12">
                            <label>UID:</label><br> _uid_<br>
                            <label>MESSAGE-ID:</label><br> <span style="word-break: break-all">_message_id_</span><br>
                            <label>IN REPLY TO:</label><br> _in_reply_to_<br>
                            <label>REFERENCES:</label><br> _references_to_<br>
                        </div>
                    </div>
                    <div class="">
                        <div class="col-lg-12">
                            <label>ID:</label> #_idItem_
                            <br><a href="../logs/index.php?&id_item=_idItem_&nome_tabela=imap" target="_blank"><i class="fa fa-history"></i> Histórico (_cntRevisoes_)</a>

                        </div>
                        <div class="col-lg-12">
                            <label>Estado:</label> _ativo_
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Criado por: </label>
                        <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                            <a href="../utilizadores/detalhes.php?id=_idCriou_">_nomeCriou_</a>
                            <br>_dataCriado_
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Editado por: </label>
                        <div class="CasoQueiramosMeterLarguraDaColuna input-status">
                            <a href="../utilizadores/detalhes.php?id=_idAtualizou_">_nomeAtualizou_</a>
                            <br>_dataAtualizado_
                        </div>
                    </div>
                </div>

                <!-- colar aqui os itens do formulário-->


                <!-- fim itens do formulário-->


        </div>
        </div>
    </div>
</div>