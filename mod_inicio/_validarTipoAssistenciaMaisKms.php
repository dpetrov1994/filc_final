<?php

include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");

if(isset($_GET['id_assistencia'])){
    $id_assistencia=$db->escape_string($_GET['id_assistencia']);
    $assistencia = getInfoTabela('assistencias', " and id_assistencia = '$id_assistencia'");
    $assistencia=$assistencia[0];

    $externa=$assistencia['externa'];

    if($externa==1){

        //obter dados da viatura:
        $viatura = getInfoTabela('viaturas', " and id_tecnico = '".$_SESSION['id_utilizador']."'");
        $viatura=$viatura[0];

        //obter os kms de todas as paragens
        $kms_max=$viatura['kms_atuais'];
        $paragens = getInfoTabela('assistencias_clientes', " and id_assistencia = '".$id_assistencia."'");
        foreach ($paragens as $paragem){
            $kms_max+=$paragem['kilometros'];
        }
        //adicionar 20% aos kms para dar margem
        $kms_max=$kms_max+($kms_max*0.2);


        $dados_viatura='<div class="text-center">
<i class="fa fa-truck fa-2x"></i>
<br> 
'.$viatura['marca'].' '.$viatura['modelo'].' ['.$viatura['matricula'].']<br> com '.number_format($viatura['kms_atuais'],0,""," ")." Km's
</div>";

        print $dados_viatura.'
<br>
<input type="hidden" value="1" id="tipo_assistencia_fechar_assist" class="form-control"> <!-- se for externa vai 1 -->
<label>Insira os KM\'s atuais</label>
<input type="number" id="kilometros" data-min="'.$viatura['kms_atuais'].'" data-max="'.$kms_max.'" name="kilometros" class="form-control kilometros">
<input type="hidden" class="override_max_kms" value="0">
';
    }else{
        print '

<i class="fa fa-info-circle text-info"></i> <span class="text-info">Como é uma assistência interna não precisa de inserir os KM\'s e o tempo de viagem.</span>
                                    
<input type="hidden" value="0" id="tipo_assistencia_fechar_assist" class="form-control"> <!-- se for interna vai 0 -->
<input type="hidden" value="0" id="kilometros" name="kilometros" class="form-control kilometros">';
    }
}

$db->close();
