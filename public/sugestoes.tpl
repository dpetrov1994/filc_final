<div class="block animation-fadeInQuick login-block">
    <!-- Login Title -->
    <div class="block-title">
        <h2>_nomePagina_</h2>
    </div>
    <!-- END Login Title -->
    _status_
    <!-- Login Form -->
    <div class="text-center"><a href="javascript:void(0)" class="btn btn-xs btn-primary mostra_filtros"><i class="fa fa-search"></i> Filtros/Pesquisa</a></div>

                                        <form id="form-pagina" class="form-horizontal form-bordered" enctype="multipart/form-data" action="_servidorSugestoes_" method="post">
        <div class="form-group hidden">
            <input id="id_utilizador" value="_idUtilizador_" name="id_utilizador" maxlength="250" class="form-control" type="text">
            <input id="nome_utilizador" value="_nomeUtilizador_" name="nome_utilizador" maxlength="250" class="form-control" type="text">
            <input id="nome_plataforma" value="_nomePlataforma_" name="nome_plataforma" maxlength="250" class="form-control" type="text">
            <input id="nome_empresa" value="_nomeEmpresa_"  name="nome_empresa" maxlength="250" class="form-control" type="text">
            <input id="dominio" value="_actualLink_" name="dominio" maxlength="250" class="form-control" type="text">
            <input id="user_form" value="1" name="user_form" maxlength="250" class="form-control" type="text">
        </div>
        <div class="form-group">
            <label class="col-md-12" >Sugestão/Correção</label>
            <p class="col-md-12">Ocasionamente, erros (bugs) podem acabar por ficar activos na plataforma.
                   Se encontrar algum destes erros, por favor descreva-os utilizando o formulário abaixo.</p>
            <div class="col-md-12">
                <textarea id="sugestao" maxlength="1000" rows="10" name="sugestao" class="form-control"></textarea>
            </div>
        </div>
        <div class="form-group form-actions">
            <button type="submit" name="submit" id="botao_loading" class="btn btn-effect-ripple btn-success pull-right btn-submit" style="overflow: hidden; position: relative;" data-loading-text="<i class='fa fa-asterisk fa-spin'></i> Aguarde">Concluir</button>
            <button type="reset" class="btn btn-effect-ripple btn-danger" style="overflow: hidden; position: relative;">Limpar</button>
        </div>

    </form>
    <!-- END Login Form -->
</div>
