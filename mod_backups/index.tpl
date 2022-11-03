<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-title">
                <h4><i class="fa fa-download"></i> Backups</h4>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <h3 class="text-center"><i class="fa fa-hdd-o"></i> Criar cópia de segurança</h3>

                    <div class="alert alert-success">
                        <h4><strong><i class="fa fa-save"></i> Info</strong></h4>
                        <p>Esta funcionalidade permite descarregar toda a informação que está contida na base de dados e todos os seus ficheiros.</p>
                    </div>

                    <div class="text-center">
                        <a class="btn btn-primary btn-effect-ripple" onclick="criar_backup()" href="javascript:void(0)"><i class="fa fa-play"></i> Iniciar <small>(processo demorado)</small></a>
                    </div>
                    <div class="hidden" id="grupoProgress3">
                        <div class="text-center">
                            Aguarde.. (Processo demorado)<br>
                            <small class="text-info" id="progresso"></small>
                        </div>
                        <div class="text-center">
                            <i class="fa fa-asterisk fa-2x fa-spin text-primary"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h3 class="text-center"><i class="fa fa-upload"></i> Restaurar</h3>

                    <div class="alert alert-info">
                        <h4><strong><i class="fa fa-question-circle"></i> Info</strong></h4>
                        <p>Se tiver alguma cópia de segurança poderá restaura-la utilizando esta funcionalidade.</p>
                    </div>
                    <div class="alert alert-warning">
                        <h4><strong><i class="fa fa-exclamation-triangle"></i> Atenção</strong></h4>
                        <p>Os dados atuais serão substituídos pelos dados importados!</p>
                    </div>

                    <div class="text-center">
                        <form id="form-para-validar" action="_restaurar_backup.php" method="post" enctype="multipart/form-data">
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <td style="width: 55%" class="text-right"><input required type="file" id="file" name="file" accept=".bak" class="inputfile inputfile-2"><label style="width: 200px" for="file" class="" id="file_label"><i class="fa fa-upload"></i> <span>Selecione um ficheiro </span></label></td>
                                    <td style="width: 45%" class="text-left"><a class="btn btn-primary btn-effect-ripple" onclick="confirmar_restauro()" href="javascript:void(0)"><i class="fa fa-play"></i> Iniciar</a></td>
                                </tr>
                                </tbody>
                            </table>
                            <button class="hidden" id="restaurar" name="restaurar" type="submit"></button>
                        </form>
                     </div>
                    <div class="hidden" id="progress_restauro">
                        <div class="text-center">
                            Aguarde.. (Processo demorado)<br>
                            <small class="text-info" id="progresso2"></small>
                        </div>
                        <div class="text-center">
                            <i class="fa fa-asterisk fa-2x fa-spin text-primary"></i>
                        </div>
                    </div>
                    <br>
                </div>
            </div>

            <div class="row border-top">
                <div class="col-lg-6">
                    <h3 class="text-center"><i class="fa fa-database"></i> Base de dados</h3>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Variável</th>
                            <th class="text-right">Valor</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><b>Nº de tabelas</b></td>
                            <td class="text-right">_tabelas_</td>
                        </tr>
                        <tr>
                            <td><b>Nº de registos</b></td>
                            <td class="text-right">_registos_</td>
                        </tr>
                        <tr>
                            <td><b>Tamanho da BD</b></td>
                            <td class="text-right">_tamanho_</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="block-section">
                        <i onclick="downloadBD()" class="btn btn-effect-ripple btn-block btn-primary" ><i class="fa fa-cloud-download"></i> Descarregar .sql</i>
                        <div class="hidden" id="grupoProgress2">
                            <div class="text-center">
                                Aguarde.. (Processo demorado)
                            </div>
                            <div class="text-center">
                                <i class="fa fa-asterisk fa-2x fa-spin text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h3 class="text-center"><i class="fa fa-pie-chart"></i> Ficheiros em disco</h3>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Pasta</th>
                            <th class="text-right">Tamanho</th>
                            <th class="text-right">Percentagem</th>
                        </tr>
                        </thead>
                        <tbody>
                        _linhas_
                        </tbody>
                    </table>
                    <div class="block-section">
                        <i onclick="downloadZip()" class="btn btn-effect-ripple btn-block btn-primary" ><i class="fa fa-cloud-download"></i> Descarregar .zip</i>
                        <div class="hidden" id="grupoProgress">
                            <div class="text-center">
                                Aguarde.. (Processo demorado)
                            </div>
                            <div class="text-center">
                                <i class="fa fa-asterisk fa-2x fa-spin text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


<a href="#modal-restauro" class="hidden" data-toggle="modal" id="confirma_restauro"></a>
<div id="modal-restauro" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><strong>Tem a certeza?</strong></h3>
            </div>
            <div class="modal-content">
                <div class="alert alert-warning">
                    <h4><strong><i class="fa fa-exclamation-triangle"></i> Atenção</strong></h4>
                    <p>Os dados atuais serão substituídos pelos dados importados!</p>
                </div>
            </div>
            <div class="modal-footer">
                <div id="confirmaModal_botoes" class="form-group form-actions">
                    <div class="col-xs-6">
                        <button class="btn btn-effect-ripple btn-danger btn-block" type="button" data-dismiss="modal" aria-hidden="true">Não</button>
                    </div>
                    <div class="col-xs-6 pull-right">
                        <a href="javascript:void(0)" onclick="sim()" id="confirma_restauro_sim" class="btn btn-effect-ripple btn-primary  btn-block">Sim</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>