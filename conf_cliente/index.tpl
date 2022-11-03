<div class="row">
    <div class="col-lg-12">
        <div class="block"><div class="block-title"><h3><i class="fa _icon_"></i> _nome_modulo_</h3></div>
            <form id="form-para-validar"  class="form-horizontal form-bordered" action="index.php_addUrl_" method="post" enctype="multipart/form-data">
                <div class="form-group hidden">
                    <label class="col-lg-12" >ID</label>
                    <div class="col-lg-12">
                        <input id="id" name="id" class="form-control" placeholder="..."  value="_idParent_" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-12" >Nome Plataforma</label>
                    <div class="col-lg-12">
                        <input id="nome_plataforma" maxlength="21" name="nome_plataforma" value="_nomePlataforma_" class="form-control" placeholder="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-12" >Nome Empresa</label>
                    <div class="col-lg-12">
                        <input id="nome_empresa" maxlength="250" name="nome_empresa" value="_nomeEmpresa_" class="form-control" placeholder="" type="text">
                        <small class="text-info">O que estiver aqui escrito será utilizado como marca de água em imagens.</small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-12" >Site da empresa</label>
                    <div class="col-lg-12">
                        <input id="url" name="url" maxlength="250" value="_url_" class="form-control" placeholder="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-12" >Morada</label>
                    <div class="col-lg-12">
                        <input id="morada" maxlength="250" name="morada" value="_morada_" class="form-control" placeholder="" type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-12" >Email</label>
                    <div class="col-lg-12">
                        <input id="email" name="email" maxlength="250" value="_email_" class="form-control" placeholder="" type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-12" >Telemóvel</label>
                    <div class="col-lg-12">
                        <input id="telemovel" maxlength="250" name="telemovel" value="_telemovel_" class="form-control" placeholder="" type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-12" >Telefone</label>
                    <div class="col-lg-12">
                        <input id="telefone" maxlength="250" name="telefone" value="_telefone_" class="form-control" placeholder="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-12" >Fax</label>
                    <div class="col-lg-12">
                        <input id="fax" name="fax" maxlength="250" value="_fax_" class="form-control" placeholder="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-12" >NIF</label>
                    <div class="col-lg-12">
                        <input id="nif" name="nif" maxlength="250" value="_nif_" class="form-control" placeholder="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-12" >NIB/IBAN</label>
                    <div class="col-lg-12">
                        <input id="nib" name="nib" maxlength="250" value="_nib_" class="form-control" placeholder="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-12" >Cor de destaque no PDF</label>
                    <div class="col-lg-12">
                        <div class="input-group input-colorpicker colorpicker-element">
                            <input id="cor" name="cor" class="form-control" value="_cor_" type="text">
                            <span class="input-group-addon"><i style="background-color: rgb(255,176,2);"></i></span>
                        </div>                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-xs-6">
                        <label class="col-lg-12" >Logotípo a mostrar no cabeçalho dos PDF's</label>
                        <div class="col-lg-12">
                            Alterar? <label class="switch switch-primary"><input onchange="toggleDisableInput(this.checked,'logo_cabecalho')" type="checkbox"><span></span></label>
                            <input type="file" id="logo_cabecalho" accept="image/*"  disabled onchange="readURL(this,'preview1')" name="logo_cabecalho">
                        </div>
                        <div class="col-lg-12">
                            <img style="max-width: 100%;height: auto" id="preview1" src="../_contents/config_cliente/_logo_cabecalho_">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="col-lg-12" >Logotípo a mostrar no rodapé dos PDF's</label>
                        <div class="col-lg-12">
                            Alterar? <label class="switch switch-primary"><input onchange="toggleDisableInput(this.checked,'logo_rodape')" type="checkbox"><span></span></label>
                            <input type="file" id="logo_rodape" accept="image/*" disabled onchange="readURL(this,'preview2')" name="logo_rodape">
                        </div>
                        <div class="col-lg-12">
                            <img style="max-width: 100%;height: auto" id="preview2" src="../_contents/config_cliente/_logo_rodape_">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-12" >1º paragrafro (PDF)</label>
                    <div class="col-lg-12">
                        <textarea id="paragrafo1" rows="5" name="paragrafo1" class="form-control">_paragrafo1_</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-12" >Texto de apresentação da empresa (PDF)</label>
                    <div class="col-lg-12">
                        <textarea id="apresentacao" rows="5" name="apresentacao" class="form-control">_apresentacao_</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-12" >Último paragrafo (PDF)</label>
                    <div class="col-lg-12">
                        <textarea id="ultimo" rows="5" name="ultimo" class="form-control">_ultimo_</textarea>
                    </div>
                </div>

                <div class="form-group form-actions">
                    <button type="submit" id="concluir" name="submit" class="btn btn-effect-ripple btn-success pull-right btn-submit" style="overflow: hidden; position: relative;">Concluir</button>
                    <button type="reset" class="btn btn-effect-ripple btn-danger" style="overflow: hidden; position: relative;">Limpar</button>
                </div>
            </form>
        </div>
    </div>
</div>