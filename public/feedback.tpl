<div class="block animation-fadeInQuick login-block">
    <!-- Login Title -->
    <div class="block-title">
        <h2>_nomePagina_</h2>
    </div>
    <!-- END Login Title -->
    _status_
    <!-- Login Form -->

    <form id="form-pagina"  class="form-horizontal form-bordered" enctype="multipart/form-data" action="feedback.php?hash=_hash_" method="post">
        <div class="form-group hidden">
            <input id="id_assistencia_cliente" value="_id_assistencia_cliente_" name="id_assistencia_cliente" maxlength="250" class="form-control" type="text">
            <input id="id_utilizador" value="_id_utilizador_" name="id_utilizador" maxlength="250" class="form-control" type="text">
            <input id="id_cliente" value="_id_cliente_" name="id_cliente" maxlength="250" class="form-control" type="text">
        </div>
        <div class="form-group col-lg-12">
            <label class="col-md-12" for="state-normal">Como classifica o serviço prestado?</label>
            <div class="col-md-12">
                <label class="radio-inline" for="classificacao">
                    <label style="width: 70px"><input id="" name="classificacao" value="1" type="radio"> 1 <i class="fa fa-star text-warning"></i></label>
                    <label style="width: 70px"><input id="" name="classificacao" value="2" type="radio"> 2 <i class="fa fa-star text-warning"></i></label>
                    <label style="width: 70px"><input id="" name="classificacao" value="3" type="radio"> 3 <i class="fa fa-star text-warning"></i></label>
                    <label style="width: 70px"><input id="" name="classificacao" value="4" type="radio"> 4 <i class="fa fa-star text-warning"></i></label>
                    <label style="width: 70px"><input id="" checked="" name="classificacao" value="5" type="radio"> 5 <i class="fa fa-star text-warning"></i></label>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-12" for="state-normal">Observações que achar relevantes</label>
            <div class="col-md-12">
                <textarea id="resposta" maxlength="250" rows="6" name="descricao" placeholder="Escreva aqui.." class="form-control"></textarea>
            </div>
        </div>
        <div class="form-group form-actions">
            <button type="submit" name="submit" id="botao_loading" class="btn btn-effect-ripple btn-success pull-right btn-submit" style="overflow: hidden; position: relative;" data-loading-text="<i class='fa fa-asterisk fa-spin'></i> Aguarde">Submeter</button>
        </div>

    </form>
    <!-- END Login Form -->
</div>
