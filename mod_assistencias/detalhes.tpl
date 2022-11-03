<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form class="form-horizontal form-bordered">


                <div class="form-group">
                    <div class="col-md-6 col-xs-6">
                        <label class="col-lg-12" >Criado por: </label>
                        <div class="col-lg-12 input-status">
                            <a href="../utilizadores/detalhes.php?id=_idCriou_">_nomeCriou_</a>
                            <br>_dataCriado_
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-6">
                        <label class="col-lg-12" >Editado por: </label>
                        <div class="col-lg-12 input-status">
                            <a href="../utilizadores/detalhes.php?id=_idAtualizou_">_nomeAtualizou_</a>
                            <br>_dataAtualizado_
                        </div>
                    </div>
                </div>



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

                <!--
                <div class="form-group hide-in-modal">
                    <div class="col-md-4 col-xs-6">
                        <div class="col-lg-6">
                            <label>ID:</label> #_idItem_
                            <br><a href="../logs/index.php?&id_item=_idItem_&nome_tabela=assistencias" target="_blank"><i class="fa fa-history"></i> Histórico (_cntRevisoes_)</a>

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
                -->


                <!-- fim itens do formulário-->

            </form>
        </div>
    </div>
</div>