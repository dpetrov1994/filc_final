<div class="row _rowMap_">
    <div class="col-lg-12">
        <div class="block">

            <form id="form-pagina" class="form-horizontal form-bordered" action="index.php_addUrl_" method="post">
                _mapear_
            </form>
        </div>
    </div>
</div>

<div class="row _rowExport_">
    <div class="col-lg-6">
        <div class="block">
            <div class="block-title">
                <h4><i class="fa fa-arrow-circle-down"></i> Exportar</h4>
            </div>
            <div class="block-section row">
                <div class="alert alert-info">
                    <h4><strong><i class="fa fa-question-circle"></i> Exportar</strong></h4>
                    <p>Utilize esta funcionalidade para exportar dados em formato CSV.</p>
                </div>
            </div>

            <form id="form-para-validar" class="form-horizontal form-bordered" action="_export.php" method="post" enctype="multipart/form-data">

                <!-- colar aqui os itens do formulário-->


                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Selecione a tabela que deseja exportar</label>
                        <div class="col-lg-12">
                            <select id="tabela" name="tabela" class="select-select2" style="width: 100%;" data-placeholder="Selecione..">
                                <option></option>
                                _tabelas_
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Delimitador de colunas</label>
                        <div class="col-lg-12">
                            <input required class="form-control" name="delimitador" value=";">
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm hidden">
                    <div class="col-xs-12">
                        <label class="CasoQueiramosMeterLarguraDaColuna" >Selecione o formato</label>
                        <div class="col-lg-12">
                            <select id="formato" name="formato" class="select-select2" style="width: 100%;" data-placeholder="Selecione..">
                                <option value="csv">csv</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group form-actions text-right">
                    <button class="btn btn-success btn-effect-ripple">Exportar</button>
                </div>

            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="block">
            <div class="block-title">
                <h4><i class="fa fa-arrow-circle-up"></i> Importar</h4>
            </div>
            <div class="block-section row">
                <div class="alert alert-info">
                    <h4><strong><i class="fa fa-question-circle"></i> Importar</strong></h4>
                    <p>Importe dados para a plataforma através de um ficheiro CSV. <br>
                        <b>- A primeira linha tem de conter os nomes das colunas da tabela;</b> <br>
                        <b>- Pode ter qualquer ordem;</b> <br>
                        <b>- Cada linha identificada com parágrafo.</b></p>
                </div>
                <div class="alert alert-warning">
                    <h4><strong><i class="fa fa-exclamation-triangle"></i> Aviso</strong></h4>
                    <p>Aconselhamos que faça uma <a href="../mod_backups/index.php">cópia de segurança</a>.</p>
                </div>
            </div>
                <form id="form-para-validar" class="form-horizontal form-bordered" action="index.php" method="post" enctype="multipart/form-data">
                    <div class="form-group form-group-sm">
                        <div class="col-xs-12">
                            <label class="CasoQueiramosMeterLarguraDaColuna" >Selecione a tabela para a qual deseja importar os dados</label>
                            <div class="col-lg-12">
                                <select id="tabela" name="tabela" class="select-select2" style="width: 100%;" data-placeholder="Selecione..">
                                    <option></option>
                                    _tabelas_
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-xs-12">
                            <label class="CasoQueiramosMeterLarguraDaColuna" >Delimitador de colunas</label>
                            <div class="col-lg-12">
                                <input required class="form-control" name="delimitador" value=";">
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-xs-12">
                            <div class="col-lg-12">
                                <input required type="file" id="file" name="file" accept=".csv" class="inputfile inputfile-2"><label for="file" class="" id="file_label"><i class="fa fa-upload"></i> <span>Selecione um ficheiro </span></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-actions text-right">
                        <button class="btn btn-success btn-effect-ripple">Seguinte</button>
                    </div>
                </form>
        </div>
    </div>
</div>

