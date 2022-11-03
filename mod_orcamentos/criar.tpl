<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <form id="form-para-validar" class="form-horizontal form-bordered" action="criar.php_addUrl_" method="post" enctype="multipart/form-data">

                <!-- colar aqui os itens do formulário-->

                
            <div class="form-group form-group-sm">
                <div class="col-xs-6">
                    <label class="col-lg-12" >REF ORC: </label>
                    <div class="col-lg-12 input-status">
                        <input id="ref" readonly name="ref" maxlength="250"  value="_ordDocumento_" class="form-control" placeholder=""  type="text">
                    </div>
                </div>
                <div class="col-xs-6">
                    <label class="col-lg-12" >Cliente</label>
                    <div class="col-lg-12 input-status">
                        <select id="id_cliente" name="id_cliente" required class="select-select2" data-placeholder="Selecione.." style="width:85%;">
                            <option></option>
                            _id_cliente_
                        </select>

                    </div>
                </div>


            </div>

                <div class="form-group form-group-sm">
                    <div class="col-xs-12 overflow-x-mobile">
                        <table class="table table-vcenter table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 5%" class="text-center"><i class="fa fa-bolt"></i></th>
                                <th style="width: 10%">Foto</th>
                                <th style="width: 15%">Nome Produto</th>
                                <th style="width:5%">Qnt.</th>
                                <th style="width: 8%">Preço S/IVA</th>
                                <th style="width: 8%">% IVA</th>
                                <th style="width: 7%">Desconto (%)</th>
                                <th style="width: 7%">Preço S/IVA C/Desc</th>
                                <th style="width: 7%">Valor IVA (€)</th>
                                <th style="width: 10%">Valor Final</th>
                            </tr>
                            </thead>
                            <tbody id="linhas">
                            _linhas_

                            </tbody>

                            <thead>

                            <th colspan="7"></th>
                            <th class="text-right">Valor IVA <br><b id="total_valor_iva"></b></th>
                            <th class="text-right">Valor Final <br> <b id="total_valor_liquido"></b></th>

                            </thead>
                        </table>
                        <div class="text-center"><a class="btn btn-info btn-xs"  href="javascript:void(0)" onclick="addLinha(this,'#linhas')" data-linha='_linha_'><i class="fa fa-plus"></i> Adicionar linha</a></div>
                    </div>
                </div>

                <div hidden>
                    <table  id="myTable" class="table table-vcenter table-bordered ">
                        <thead>
                        <tr class="header">
                            <th style="width: 30%">Referências</th>
                        </tr>
                        </thead>
                        <tbody class="body-for-modal">
                        _searchProdutos_
                        <div class="linhasProd"></div>
                        </tbody>
                    </table>
                </div>

<div class="form-group form-group-sm">
    <div class="col-xs-12">
        <label class="col-lg-12" >Observações </label>
        <div class="col-lg-12">
             <textarea id="descricao" rows="10" name="descricao" class="form-control">_descricao_</textarea>
        </div>
    </div>
</div>

                <!-- fim itens do formulário-->

                <div class="hidden">
                    <div>
                        <button type="submit" name="submit" id="botao_loading2" class="btn btn-effect-ripple btn-primary pull-right">Concluir</button>
                        <button type="reset" id="reset2" class="btn btn-effect-ripple btn-danger">Limpar</button>
                    </div>
                </div>
            </form>



            <div  class="form-horizontal form-bordered">
                <div class="form-group form-actions">
                    <div class="col-lg-12">
                        <a onclick="document.getElementById('botao_loading2').click()" id="botao_loading" class="btn btn-effect-ripple btn-primary pull-right" data-loading-text="<i class='fa fa-asterisk fa-spin'></i> Aguarde">Concluir</a>
                        <a onclick="window.history.back()" class="btn btn-effect-ripple btn-warning">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


