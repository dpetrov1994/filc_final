<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form id="form-para-validar" class="form-horizontal form-bordered" action="editar.php_addUrl_" method="post" enctype="multipart/form-data">

                <!-- colar aqui os itens do formulário-->


                <div class="form-group form-group-sm ">
                    <div class="col-xs-12 [ESCONDER-PARA-TECNICOS]" style="padding-top: 0px">
                        <label class="col-lg-12" >Técnico</label>
                        <div class="col-lg-12 input-status">
                            <select id="id_utilizador" name="id_utilizador" class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                                <option></option>
                                _id_utilizador_
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm ">
                    <div class="col-xs-12" style="padding-top: 0px">
                        <label class="col-lg-12" >Cliente</label>
                        <div class="col-lg-12 input-status">
                            <select id="id_cliente" name="id_cliente" required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                                <option></option>
                                _clientes_
                            </select>
                        </div>
                    </div>

                </div>

                <div class="form-group form-group-sm">
                    <div class="col-xs-12" style="padding-top: 0px">

                        <label class="col-lg-12" >Data pretendida</label>

                        <div class="col-lg-12 input-status">
                            <input id="data_inicio" name="data_inicio" class="form-control"  type="datetime-local">
                        </div>

                    </div>
                </div>

                <div class="form-group form-group-sm ">
                    <div class="col-xs-12" style="padding-top: 0px">
                        <label class="col-lg-12" >Categoria</label>
                        <div class="col-lg-12 input-status">
                            <label class='csscheckbox csscheckbox-primary'><input type='radio' name='id_categoria' id='id_categoria' value='0'><span></span> Sem categoria</label><br>
                            _id_categoria_
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-sm ">
                    <div class="col-xs-12" style="padding-top: 0px">
                        <label class="col-lg-12" >Tipo</label>
                        <div class="col-lg-12 input-status">
                            <label class="csscheckbox csscheckbox-primary"><input type="radio" class="tipo_paragem" name="externa" value="0"><span></span> <i class="fa fa-home"></i> Interna</label><br>
                            <label class="csscheckbox csscheckbox-primary"><input type="radio" class="tipo_paragem" name="externa" value="1"><span></span> <i class="fa fa-truck"></i> Externa</label>

                        </div>
                    </div>
                </div>
                <!--<div class="form-group form-group-sm">

                    <div class="col-xs-12">

                        <label class="col-lg-12" >Quilômetros</label>

                        <div class="col-lg-12 input-status">
                            <input id="kilometros" name="kilometros" class="form-control" >
                        </div>

                    </div>

                </div>-->

                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <label class="col-lg-12" >Observações </label>
                        <div class="col-lg-12">
                            <textarea id="descricao" rows="5" name="descricao" class="form-control">_descricao_</textarea>
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