<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form class="form-horizontal form-bordered">
                <!-- colar aqui os itens do formulário-->

                <div class="form-group form-group-sm">
                    <div class="col-xs-6">
                        <label class="col-lg-12">Data</label>
                        <div class="col-lg-12">
                            <input id="created_at" name="created_at" class="form-control" placeholder="..." type="text">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="col-lg-12">Hora</label>
                        <div class="col-lg-12">
                            <input id="hora_log" name="hora_log" value="_horaInicio_" class="form-control" placeholder="..." type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-xs-6">
                        <label class="col-lg-12">Utilizador que enviou</label>
                        <div class="col-lg-12">
                            <input id="nome_utilizador" name="nome_utilizador" value="_nome_utilizador_" class="form-control" placeholder="eg: fa-cube" type="text">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="col-lg-12">Estado (0=sucesso)</label>
                        <div class="col-lg-12">
                            <input id="estado" name="estado" class="form-control" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-xs-4">
                        <label class="col-lg-12">Assunto</label>
                        <div class="col-lg-12">
                            <input id="assunto" name="assunto" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <label class="col-lg-12">Destinatário</label>
                        <div class="col-lg-12">
                            <input id="destinatario" name="destinatario" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <label class="col-lg-12">Cópia no servidor</label>
                        <div class="col-lg-12">
                            <input id="ficheiro" name="ficheiro" class="form-control" type="text">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12" >Visualizar email</label>
                    <div class="col-md-12">
                        <iframe style="width: 100%;height: 700px" src="../_contents/emails_enviados/_ficheiro_"></iframe>
                    </div>
                </div>

                <!-- fim itens do formulário-->

            </form>
        </div>
    </div>
</div>