






<div class="grafico-eficiencia " style="padding-top: 10px">
    <div class="text-center"><small class="text-muted">Gráfico de eficiência</small></div>
    _progressbar_
</div>

<div class="alertas-viaturas">
    _alertaviaturas_
</div>

<!-- antes
<div class="block">
    <div class="row block-section" >
        <div class="col-xs-12">

            <div class="block-title">
                <h2>Assistências Iniciadas</h2>
            </div>


            _assistencias_iniciadas_


            <div class="sem-dados-assistencias_iniciadas">
                <div class="well well-sm text-center"><i class="text-muted"> Sem dados</i>  </div>
            </div>


        </div>
    </div>
</div> -->

<div>

    <h3 class="text-center">Serviços em curso</h3>

    <div class="assistencias_iniciadas assistencias-clientes">
        _assistencias_iniciadas_
    </div>


    <div class="sem-dados-assistencias_iniciadas">
        <div class="well well-sm text-center"><i class="text-muted"> Sem dados</i>  </div>
    </div>
    <br>
    <div class="text-center">
        <a class='btn btn-info btn add-linha'  href='javascript:void(0)' onclick='addParagemClienteModal(this)' ><i class='fa fa-plus'></i> Iniciar um Serviço </a>
    </div>
    <br>
</div>


<div class="block">
    <div class="row block-section" >
        <div class="col-xs-12">

            <div class="block-title">
                <div class="block-options pull-right">
                    <a href="javascript:void(0)" onclick="openModal('#modal-criar-assistencia')" class="btn btn-effect-ripple btn-default" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Adicionar"><i class="fa fa-plus"></i></a>
                </div>
                <h2>Minha agenda</h2>
            </div>

            _agenda_

            <div class="sem-dados-agenda">
                <div class="well well-sm text-center"><i class="text-muted"> Sem dados</i>  </div>
            </div>


        </div>
    </div>
</div>





<div class="footer-mobile-tecnicos">
     <a class="viaturas" href="javascript:void(0)" onclick="openModal('#modal-ver-viatura')">
        <i class="fa fa-truck"></i>
     </a>
    <a class="lupa"  href="javascript:void(0)" onclick="openModal('#modal-ver-pesquisa')">
        <i class="fa fa-search"></i>
    </a>
</div>







