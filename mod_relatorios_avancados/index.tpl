
<div class="row">
    <div class="col-lg-4">
        <div class="block">
            <div class="block-title"><h4>Análise</h4></div>
            <div class="block-section row">

                <div class="col-lg-12">
                    <a href="javascript:void(0)" onclick="get_form_relatorio('producao_despesas_kms_novo.php',this)"><i class="fa fa-file-text-o"></i> Produção vs Despesas</a><br>
                    <a href="javascript:void(0)" onclick="get_form_relatorio('quadro_producao_diario.php',this)"><i class="fa fa-file-text-o"></i> Quadro Diário de Produção Por Equipa</a><br>
                </div>

            </div>
            <br>
        </div>
    </div>
</div>


<div id="modal-relatorio" class="modal fade"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button style="color:#2aa3fb" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4><b id="modal-relatorio-title"></b></h4>
            </div>
            <div class="modal-body">
                <div id="modal-relatorio-body">
                </div>
            </div>
        </div>

    </div>
</div>
