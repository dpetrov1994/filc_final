<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 31/03/2018
 * Time: 10:12
 */

$criar_avancado=1;
$selecionarDestinatarios='<div class="form-group">
                    <label class="col-md-3 control-label" for="state-normal">Mostrar membros de:</label>
                    <div class="col-md-6">
                        <select id="grupos" onchange="getUtilizadores(this.value)" class="select-select2" style="width: 100%;" data-placeholder="Selecione..">
                            <option></option>
                            _grupos_
                        </select>
                    </div>
                </div>
                <div class="form-group">
                <div class="col-lg-12">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 45%">
                                    <label>Utilizadores</label>
                                    <div class="input-status">
                                        <select class="form-control" id="potenciaisDestinatarios" multiple size="10">
                                           
                                        </select>
                                    </div>
                            </td>
                            <td style="width: 5%;text-align: center">
                                <div class="btn-group-vertical">
                                    <button type="button" class="btn btn-sm btn-primary" onclick="addDestinatarios()"><i class="fa fa-plus"></i></button>
                                    <button  type="button" class="btn btn-sm btn-danger" onclick="removeDestinatarios()"><i class="fa fa-minus"></i></button>
                                </div>
                            </td>
                            <td style="width: 45%">
                                    <label>Destinatários</label>
                                    <div class="input-status">
                                        <select id="utilizadores" size="10" required multiple name="utilizadores[]" class="form-control" >
                                        </select>
                                    </div>
                            </td>
                        </tr>
                    </table>
                </div>
                </div>';
include "criar.php";