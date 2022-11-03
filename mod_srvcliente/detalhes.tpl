<style>
    .block{
        -webkit-box-shadow: 1px 2px 24px -4px #939393!important;
        box-shadow: 1px 2px 24px -4px #939393!important;
    }

</style>
<div class="hidden">
<a href="javascript:void(0)" onclick="mostrar_sidebar_notas()" class="btn-warning btn btn-xs text-light text-center btn-notas" style="z-index: 999;position: fixed; bottom: 20px;right: 20px;padding: 5px 10px 5px 10px;border-radius: 10px;color:black">
    <span class="label label-primary nav-users-indicator" style="left: -4px;">_cntNotas_</span>
    <i class="fa fa-bell"></i> Lembretes
</a>
</div>

<div class="sidebar-notas" style="right: -300px">
    <div class="row">
        <div class="col-lg-12 text-center">
            <a href="javascript:void(0)" onclick="criarNota('_FederalTaxID_')" class="btn btn-primary"><i class="fa fa-plus"></i> Adicionar Lembrete</a>
        </div>
        <div class="col-lg-12" id="notas">
            _notas_
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-2" style="font-size: 18px;line-height: 19px">
        <!--<small>_classificacao_</small><br>-->
        <h3><b>_NomesDasEmpresas_</b>
            <small class="text-muted">
                <span id="nif">_FederalTaxID_</span>
            </small>
        </h3>
    </div>
    <div class="col-lg-3 _esconderParaFuncionarios_" style="font-size: 18px">
        <small style="font-size: 12px">KM's e tempo deslocação (ida e volta):</small>
        <div class="input-group _esconderParaFuncionarios_">
            <span class="input-group-btn">
            <button type="button" class="btn " style="font-size: 14px;background: transparent;border-bottom: 1px solid #303439;"><i class="fa fa-truck text-muted"></i></button>
            </span>
            <input onkeyup="ajaxKms('_idItem_')" onchange="ajaxKms('_idItem_')" style="font-size: 12px;background: transparent" id="kms" name="kms" class="form-control" value="_kms_" placeholder="Escreva aqui.." type="text">
        </div>
        <div class="input-group _esconderParaFuncionarios_">
            <span class="input-group-btn">
                <button type="button" class="btn " style="font-size: 14px;background: transparent;border-bottom: 1px solid #303439;"><i class="fa fa-clock-o text-muted"></i></button>
            </span>
            <input onkeyup="ajaxTempo('_idItem_')" onchange="ajaxTempo('_idItem_')" style="font-size: 12px;background: transparent" id="tempo" name="tempo" class="form-control" value="_tempo_" placeholder="Escreva aqui.." type="time">
        </div>
    </div>



    <div class="col-lg-3 text-center">
        <i class="fa fa-money _corDivida_" style="font-size: 20px"></i>
        <br>
        Valor pendente c/iva:<br>
        _Divida_

    </div>




</div>

<div class="row">
    <div class="col-lg-12"><br></div>
</div>


<div class="row">

    <div class="col-lg-6">

        <div class="block" style="min-height: 143px;">
            <div class="block-title"><h4><i class="fa fa-info-circle"></i> Informação</h4></div>
            <div class="row" style="margin-bottom: 20px;">

                _info_
            </div>
        </div>




        <div class="block" style="min-height: 143px;">
            <div class="block-title"><h4><i class="fa fa-comments-o"></i> Comentários</h4>   </div>
            <div class="col-lg-12">
                _comentariosSAGE_
                <br>
            </div>
            <div id="comments-container">

            </div>


        </div>


        <div class="block" style="min-height: 143px;">
            <div class="block-title" style="margin-bottom: 5px"><h4><i class="fa fa-folder"></i> Documentação do Cliente </h4></div>
            <div class="row">
                <form action="detalhes.php?id=_idItem_&apagar" method="post" class="form-dos-documentos">

                    <div id="documentos" style="margin-bottom: 10px;">_documentos_</div>
                    <button type="submit" style="color:black" class="btn btn-warning btn-xs eliminar-documentos"><i class="fa fa-trash-o"></i> Eliminar documentos selecionados</button>

                </form>

            </div>

            <div class="dropzoneDocumentos">_dropZone_</div>
            <br>
        </div>

        <div class="block">
            <div class="row block-section" >
                <div class="col-xs-12">

                    <div class="block-title d-flex">
                        <h2>Assistências</h2>
                        <a class="arrow-down-trigger text-right" onclick="mostrarEsconder('expand_assistencias')" style="text-align: center;margin-left: auto;position: relative;right: 15px;" href="javascript:void(0)"><i class="fa fa-arrow-down"></i></a>
                    </div>


                    <div class="row" style="margin-bottom: 20px;">

                        <div class="assistencias-clientes" id="expand_assistencias" style="display: none;">

                            _assistencias_

                        </div>

                    </div>


                </div>
            </div>
        </div>



    </div>


    <div class="col-lg-6">


            <div class="block" style="min-height: 143px;">
                <div class="block-title" style="margin-bottom: 5px;"><h4>Histórico de Faturação </h4></div>
                <div class="block-section">
                    <p style="margin-top: 20px;margin-bottom: 20px">
                        <span class="dynamicsparkline" style="width: 100%;height: 50px">Loading..</span>
                    </p>
                </div>
                <div class="row servicos-row" >

                  _servicos_
                </div>



            </div>
    </div>

    <div class="col-lg-6 hidden">
        <div class="block">
            <div class="block-title"><h4><i class="fa fa-map"></i> Mapa</h4></div>
            <div class="row">
                <div class="col-lg-12">
                    <a href="javascript:void(0)" onclick="getLocation()" class="btn btn-warning btn-xs"><i class="fa fa-compass"></i> Localizar</a><br>
                    <div class="" id="mapa">
                        <div id="mapid" class="text-center"></div>
                    </div>

                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>



    <div class="col-lg-6">


        <div class="block">
            <div class="row block-section" >
                <div class="col-xs-12">

                    <div class="block-title d-flex">
                        <h2>Máquinas</h2>
                        <a class="arrow-down-trigger text-right" onclick="mostrarEsconder('expand_maquinas')" style="text-align: center;margin-left: auto;position: relative;right: 15px;" href="javascript:void(0)"><i class="fa fa-arrow-down"></i></a>
                    </div>


                    <div class="row" style="margin-bottom: 20px;">


                        <div class="col-xs-12" style="display: block;">

                            <div class="row ">

                                <div class="col-lg-12 to-expand-div" style="display: none;" id="expand_maquinas">
                                    _maquinas_
                                </div>

                            </div>

                        </div>


                    </div>


                </div>
            </div>
        </div>




    </div>



</div>



<div id="modal-nova-localizacao" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Nova localização</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="../mod_srvcliente/_atualizar_geo.php" id="criar_geolocalizacao" method="post">
                            <div class="col-lg-12">
                                <input class="form-control" name="nome" required placeholder="Nome (ex: adega, escritório...)">
                                <input class="hidden" name="id_cliente" value="_id_">
                                <input class="hidden" name="latitude" id="modal-latitude" >
                                <input class="hidden" name="longitude" id="modal-longitude" >
                            </div>
                            <div class="col-lg-12 text-right">
                                <button type="submit" name="criar" id="criar_localizacao_btn" class="btn btn-success btn-effect-ripple btn-sm"><i class="fa fa-plus"></i> Adicionar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



<div id="modal-editar-localizacao" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Atualizar localização</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="../mod_srvcliente/_atualizar_geo.php" id="editar_geolocalizacao" method="post">
                            <div class="col-lg-12">
                                <label>Selecione a localização que deseja atualizar</label>
                                <select class="form-control select-select2" required name="id_geo" id="modal-atualizar-idGeo" onchange="selecionarLocalizacao('modal-atualizar-idGeo')">
                                    <option></option>
                                    _listaGeo_
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label>Nome (ex: adega, escritório...)</label>
                                <input class="form-control" name="nome" id="modal-atualizar-nome" placeholder="Nome (ex: adega, escritório...)">
                                <input class="hidden" name="id_cliente" value="_id_">
                                <input class="hidden" name="latitude" id="modal-editar-latitude" >
                                <input class="hidden" name="longitude" id="modal-editar-longitude" >
                            </div>
                            <div class="col-lg-12 text-right">
                                <button type="submit" name="editar" id="editar_localizacao_btn" class="btn btn-success btn-effect-ripple btn-sm">Atualizar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>