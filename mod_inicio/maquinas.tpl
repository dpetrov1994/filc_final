<div class="row block-section">
    <div class="col-xs-12">
        <div class="well">

            <div class="block-title">
                <h3 class="h4"><strong>Alertas das Viaturas</strong></h3>
            </div>

            _viaturas_

        </div>
    </div>
</div>

<div class="row block-section">
    <div class="col-xs-12">
        <div class="well">

            <div class="block-title">
                <h3 class="h4"><strong>Assistências Iniciadas</strong></h3>
            </div>

            _assistencias_iniciadas_

            <div class="sem-dados-assistencias_iniciadas">
                <div class="well well-sm text-center"><i class="text-muted"> Sem dados</i>  </div>
            </div>

        </div>
    </div>
</div>

<div class="row block-section">
    <div class="col-xs-12">
        <div class="well">

            <div class="block-title">
                <h3 class="h4"><strong> Agenda </strong></h3>
            </div>

            _agenda_

            <div class="sem-dados-agenda">
                <div class="well well-sm text-center"><i class="text-muted"> Sem dados</i>  </div>
            </div>

        </div>
    </div>
</div>


<div class="footer-mobile-tecnicos">
    <a class="viaturas" href="#">
        <i class="fa fa-truck"></i>
    </a>
    <a class="agenda"  href="#">
        <i class="fa fa-calendar"></i>
    </a>
    <a class="lupa"  href="#">
        <i class="fa fa-search"></i>
    </a>
    <a class="adicionar"  href="#">
        <i class="fa fa-plus"></i>
    </a>

</div>


<div id="modal-adicionar-paragem" class="modal " role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><strong>Adicionar Cliente</strong></h3>
            </div>
            <div class="modal-body" style="padding: 20px;">

                <label>Cliente</label>
                <div>
                    <select id="id_cliente" name="id_cliente" required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                        <option></option>
                        _clientes_
                    </select>
                    <input class="hidden" id="id_assistencia_modal" readonly>
                    <a style="margin-top: 25px; cursor: pointer"  onclick="addParagemCliente()" class="btn btn-effect-ripple btn-success pull-right btn-submit">Adicionar</a>
                </div>

            </div>
        </div>
    </div>
</div>



<div id="modal-adicionar-maquinas" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><strong> Adicionar Máquinas </strong></h3>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <input class="hidden" id="id_assistencia_cliente_modal" readonly>
                <!-- Preenchido com AJAX -->

            </div>
        </div>
    </div>
</div>