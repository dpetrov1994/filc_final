var conta=0;
function adicionarLinha(){
    var linha='<tr>\n' +
        '                                <td class="hidden"><input name="gerarTabela_num[]" value="'+conta+'"></td>\n' +
        '                                <td>Nome:<br><input name="gerarTabela_nome_'+conta+'[]"><br>' +
        '                                    Tipo:<br><select style="height: 26px" name="gerarTabela_tipo_'+conta+'[]">\n' +
        '                                        <option>int(11)</option>\n' +
        '                                        <option>varchar(250)</option>\n' +
        '                                        <option>varchar(500)</option>\n' +
        '                                        <option>varchar(1000)</option>\n' +
        '                                        <option>varchar(5000)</option>\n' +
        '                                        <option>datetime</option>\n' +
        '                                        <option>timestamp</option>\n' +
        '                                        <option>text</option>\n' +
        '                                    </select><br>\n' +
        '                                    Default:<br><select style="height: 26px" name="gerarTabela_default_'+conta+'[]">\n' +
        '                                        <option></option>\n' +
        '                                        <option selected>null</option>\n' +
        '                                        <option>1</option>\n' +
        '                                        <option>0</option>\n' +
        '                                        <option>CURRENT_TIMESTAMP</option>\n' +
        '                                    </select>\n' +
        '                                   </td>\n' +
        '                                <td>\n' +
        '                                    FORM:<br><select style="height: 26px" name="gerarTabela_form_'+conta+'[]">\n' +
        '                                        <option>SIM</option>\n' +
        '                                        <option>NAO</option>\n' +
        '                                    </select><br>\n' +
        '                                    Label:<br><input name="gerarTabela_label_'+conta+'[]"><br>\n' +
        '                                    tipo:<br><select style="height: 26px" name="gerarTabela_input_'+conta+'[]">\n' +
        '                                        <option>input text</option>\n' +
        '                                        <option>input data</option>\n' +
        '                                        <option>select</option>\n' +
        '                                        <option>textarea</option>\n' +
        '                                        <option>checkbox</option>\n' +
        '                                        <option>checkbox switch</option>\n' +
        '                                        <option>file</option>\n' +
        '                                    </select><br>\n' +
        '                                </td>\n' +
        '                                <td>' +
        '                                   Sql Preecher select<br><input placeholder="deixar vazio se nao usar" name="gerarTabela_sqlpreencher_'+conta+'[]"><br>' +
        '                                   ID<br><input value="id_" name="gerarTabela_sqlid_'+conta+'[]"><br>' +
        '                                   NOME<br><input value="nome_" name="gerarTabela_sqlnome_'+conta+'[]"><br>' +
        '                                </td>\n' +
        '                                <td>' +
        '                                    Regras<br><select style="height: 50px" multiple name="gerarTabela_regras_'+conta+'[]">\n' +
        '                                        <option></option>\n' +
        '                                        <option>required</option>\n' +
        '                                        <option>dataPortuguesa</option>\n' +
        '                                        <option>email</option>\n' +
        '                                    </select>\n' +
        '                                </td>\n' +
        '                            </tr>';
    $("#linhas").append(linha);
    conta++;
    desativarInputsNaTabela();
}

function desativarInputsNaTabela() {
    var checked=document.getElementById("gerarTabela").checked;
    var disabled=true;
    if(checked==true){
        disabled=false;
    }
    $("#linhas input").prop('disabled', disabled);
    $("#linhas select").prop('disabled', disabled);
}
desativarInputsNaTabela();