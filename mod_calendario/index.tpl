<!-- FullCalendar Block -->

    <div id="calendar"></div>

<!-- END FullCalendar Block -->



<div id="modal-marcar-evento" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><strong>Criar lembrete</strong></h3>
            </div>
            <div class="modal-body">
                _formCriar_
            </div>
            <div class="modal-footer">
                <span class="pull-right">
                     &nbsp;&nbsp;&nbsp;<button type="button" id="botao_loading" onclick="document.getElementById('submeter_form').click()" class="btn btn-effect-ripple btn-success pull-right btn-submit" data-loading-text="<i class='fa fa-asterisk fa-spin'></i> Aguarde">Concluir</button>
                </span>
            </div>
        </div>
    </div>
</div>

<div id="modal-detalhes-evento" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><strong>Detalhes</strong></h3>
            </div>
            <div id="modal-detalhes-evento-content">

            </div>
        </div>
    </div>
</div>
