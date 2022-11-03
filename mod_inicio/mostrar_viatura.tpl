<link rel="stylesheet" href="../assets/layout/css/qrcode-reader.css">
<div class="sem-viatura hidden">

    <div class="block">
        <div class="row block-section" >
            <div class="col-xs-12">

                <div class="block-title">
                    <h1><b>Sem viatura atribuída</b></h1>
                </div>

                <div class="col-xs-12 text-center">
                    <a class="btn btn-success btn-lg openreader-single2 "  data-qrr-target='#single2'   data-qrr-audio-feedback='true' href="javascript:void(0)"> Ler QR </a>
                </div>

            </div>
        </div>
    </div>


</div>

<div class="com-viatura">

    <div class="block">
        <div class=" row block-section" >
            <div class="col-xs-12">

                <div class="block-title">
                    <h1><i class="fa fa-truck"></i> <b>_marca_ _modelo_</b></h1>
                </div>

                <div class="info-viatura">
                    <div class="left-side-info-viatura">
                        <h5><small class="text-muted">Matrícula:</small><br><b>[_matricula_]</b><br><small class="text-muted"><b>_kms_</b></small></h5>
                    </div>
                    <div class="right-side-buttons">
                        <!-- <a class="btn btn-success btn-xs openreader-single2 "  data-qrr-target='#single2'   data-qrr-audio-feedback='true' href="javascript:void(0)"
                            onclick="openModal('#modal-ler-qrcode-viatura')" > Ler QR </a>-->
                        <a class="btn bg-info text-dark btn-xs" href="javascript:void(0)" onclick="openModal('#modal-emprestar-viatura')" > Emprestar<br>Viatura </a>
                        <a class="btn btn-success btn-xs openreader-single2 "  data-qrr-target='#single2'   data-qrr-audio-feedback='true' href="javascript:void(0)"> Ler<br> QR </a>
                        <!--<a class="btn _estadoclassbtn_ btn-xs estado-viatura-btn" href="javascript:void(0)" onclick="openModal('#modal-estado-viatura')" > Estado <br>(_estadoviatura_)</a>-->
                    </div>
                </div>

                <div id="input-viaturas">
                    <label class="col-lg-12" >Data fim do seguro</label>
                    <div class="col-lg-12 input-status">
                        <input id="data_seguro" name="data_seguro" type="date" class="input-datepicker form-control" disabled  >

                    </div>

                    <label class="col-lg-12" >Data prox. Inspeção</label>
                    <div class="col-lg-12 input-status">
                        <input id="data_inspecao" name="data_inspecao" type="date" class="input-datepicker form-control" disabled >
                    </div>

                    <label class="col-lg-12">Km's para prox. Revisão</label>
                    <div class="col-lg-12 input-status">
                        <input id="kms_revisao" name="kms_revisao"  maxlength="250"  class="form-control" type="text" disabled >
                    </div>

                    <label class="col-lg-12">Km's para troca pneus</label>
                    <div class="col-lg-12 input-status">
                        <input id="kms_pneus" name="kms_pneus"  maxlength="250"  class="form-control" type="text" disabled >
                    </div>

                    <label class="col-lg-12" >Data prox. Lavagem</label>
                    <div class="col-lg-12 input-status">
                        <input id="data_lavagem" name="data_lavagem" type="date" class="input-datepicker form-control" disabled >
                    </div>

                   <!-- <label class="col-lg-12">Km's da viatura quando registada</label>
                    <div class="col-lg-12 input-status">
                        <input id="kms_inicio" name="kms_inicio"  maxlength="250"  class="form-control" type="text">
                    </div>-->

                    <!--<label class="col-lg-12">Preço por KM</label>
                    <div class="col-lg-12 input-status">
                        <input id="preco_km" name="preco_km"  maxlength="250"  class="form-control" type="text">
                    </div>-->

                    <label class="col-lg-12" >Observações </label>
                    <div class="col-lg-12 input-status">
                        <textarea id="descricao" rows="10" name="descricao" class="form-control">_descricao_</textarea>
                    </div>
                </div>
                <!--<div class="col-xs-12 text-center">
                    <a class="btn btn-info btn-xs" href="javascript:void(0)" onclick="updateInput('#input-viaturas','_id_viatura_', 'viaturas','', '1')">Ok <i class="fa fa-save" style="padding-left: 5px"></i>
                    </a>
                </div>-->


            </div>



        </div>
    </div>

</div>



<div id="modal-estado-viatura" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">

            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-estado-viatura')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>

            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" >
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h2>Estado da Viatura</h2>
                            </div>


                            <div>

                                <div class="col-lg-12 input-status">
                                    <label>Insira o estado da viatura</label>
                                    <select id="id_estado" name="id_estado" required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                                        _estadosviaturas_
                                    </select>
                                </div>

                            </div>

                            <div class="text-center">
                                <a class="btn btn-info mb-20" onclick="updateInput('#id_estado','_idestadoviaturalinha_', 'estados_viaturas_linhas', '#modal-estado-viatura')" href="javascript:void(0)" > Atualizar </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div id="modal-emprestar-viatura" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">

            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-emprestar-viatura');cancelarQRCode();"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>

            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" >
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h2>Emprestar Viatura</h2>
                            </div>

                            <div>

                                <div class="col-lg-12 input-status gerar-qrcode">
                                    <label>Tecnico</label>
                                    <select id="id_tecnico" name="id_tecnico" id_viatura = '_id_viatura_' required class="form-control" data-placeholder="Selecione.." style="width: 100%;">
                                        _tecnicos_
                                    </select>

                                    <div class="text-center">
                                        <a class="btn btn-info mb-20" onclick="gerarQRCodeViatura()" href="javascript:void(0)" > Gerar QRCode </a>
                                    </div>
                                </div>

                                <div class="col-lg-12 text-center mostrar-qrcode">
                                    <a class="not-modal qrcode-viatura" href="" target="_blank" download="filename.png"> <img class="qr-code-img" src='' width='150' height='150' alt=''/></a>

                                    <div class="text-center">
                                        <a class="btn btn-info mb-20" onclick="cancelarQRCode();" href="javascript:void(0)" > Cancelar </a>
                                    </div>
                                </div>

                                <div class="col-lg-12 text-center gif-success">
                                    <div class="text-center">
                                        <img src="success.gif" width="150px" height="150px">
                                    </div>
                                </div>

                            </div>



                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>