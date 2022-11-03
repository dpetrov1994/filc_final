<style>
    .block {
        -webkit-box-shadow: 1px 2px 24px -4px #939393 !important;
        box-shadow: 1px 2px 24px -4px #939393 !important;
    }
</style>

<div id="overlay-layer" style="display: none">

        <i style="position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);font-size: 50px; color:gray" class="fa fa-spinner fa-spin"></i>

</div>

<textarea style="display: none;" id="json_com_colunas_selecionadas"></textarea>

<div class="row">

    <div class="col-lg-6">
        <div class="block">
            <div class="block-title"><h4>Relatórios</h4></div>
            <div class="block-section row">

                <div class="col-lg-12">
                    _primeirastabelas_

                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div id="containter_relacoes">

        </div>
    </div>


    <div class="col-lg-12">




        <div class="block">
            <div class="block-title "><h4>Condicoes</h4></div>
            <div class="block-section row">
                <div class="col-lg-12"  >


                    <div id="linhas">



                    </div>
                    <div class="col-lg-12 text-center">
                        <a href='javascript:void(0)' class="add-condicao btn btn-success" >Adicionar condicão</a>
                    </div>

                </div>

            </div>
        </div>


        <div class="block">
            <div class="block-title "><h4>Colunas Aritméticas</h4></div>
            <div class="block-section row">
                <div class="col-lg-12"  >

                    <div>
                        <i class="fa fa-info-circle text-info"></i> Aqui pode criar colunas cujo o valor será uma expressão matemática.
                        <br> Por exemplo, por utilizar operações aritméticas fundamentais como: adição, subtração, multiplicação e divisão.
                        <br> <span class="text-warning">O sistema não vai conseguir distinguir uma coluna de texto ou data de uma coluna numérica, por favor tenha isso em antenção.</span>
                        <br> É possível fazer uma multiplicação assim: <b>(elementos.uas * tarefas.valor)</b>
                        <br> É possível fazer uma subtração e obter diferença assim: <b>(tarefas.valor - tarefas.valorse)</b>
                        <br> <a href="javascript:void(0)" onclick="mostrarColunasDisponiveis()"><i class="fa fa-refresh"></i> Atualizar e mostrar colunas disponíveis</a>
                        <br>
                        <small class="text-info" id="colunas_selecionadas"></small>
                    </div>
                    <div id="linhas_aritmeticas">


                    </div>
                    <div class="col-lg-12 text-center">
                        <a href='javascript:void(0)' class="add-coluna btn btn-success" >Adicionar Coluna</a>
                    </div>

                </div>

            </div>
        </div>



        <div class="block">

            <div class="block-title "><h4>Testar</h4></div>
            <div class="block-section row">
                <div class="col-lg-12 text-center">
                    <a onclick="gerarSqlQuery(this,1)" href="javascript:void(0)" class="btn btn-info btn-block btn-lg" >   <i class="fa fa-download"></i> Ver/Testar Relatório (1000 registos)</a>
                </div>
            </div>

        </div>

        <div class="block">

            <div class="block-title "><h4>Guardar</h4></div>
            <div class="row">
                <div class="col-lg-12">


                        <div class="">
                            <label class="" >Nome do relatório </label>
                            <div class=" input-status">
                                <input id="nome_relatorio" name="nome_relatorio" maxlength="250"  class="form-control" placeholder=""  type="text">
                            </div>
                        </div>


                        <div class="">
                            <label class="" >Categoria </label>
                            <div class="autocomplete input-status">
                                <input id="categoria" name="categoria" maxlength="250"  class="form-control" placeholder=""  type="text">
                            </div>
                        </div>


                    <div class="">
                            <br>
                            <br>
                            <a onclick="gerarSqlQuery(this,0,1)" href="javascript:void(0)" class="btn btn-success btn-block btn-lg" >   <i class="fa fa-save"></i> Guardar</a>

                    </div>



                </div>
            </div>
        </div>



        <div class="coluna_aritmetica" style="display: none;">
            <div class="linha_coluna_aritmetica" style="padding: 10px;margin: 10px; border: 1px dashed gray">
                <label>Nome da coluna</label>
                <input class="form-control coluna-aritmetica-nome" type="text">
                <label>Expressão Matemática</label>
                <textarea class="form-control coluna-aritmetica-valor"></textarea>
            </div>
        </div>

        <div class="condicao" style="display: none">_linhacondicao_</div>

        <div class="subgrupo-condicao-temp"  style="display: none">

            _subgrupo_

        </div>

    </div>
</div>