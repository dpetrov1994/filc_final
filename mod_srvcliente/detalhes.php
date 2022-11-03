<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("detalhes.tpl");

$content=str_replace("_idItem_",$id,$content);
$content=str_replace("_link_",urlencode(str_replace("?","&",$actual_link)),$content);

/*
$sql="select * from $nomeTabela where FederalTaxID!='' and PartyID!=''";
$result=runQ($sql,$db,"VERIFICAR EXISTENTE");
if($result->num_rows!=0) {
    while ($row = $result->fetch_assoc()) {
        $registosCliente = getInfoTabela("srv_clientes", " and FederalTaxID = '".$row["FederalTaxID"]."'  order by empresa desc");

        if(!is_dir("../_contents/docs/".$row['FederalTaxID'])) {
            mkdir("../_contents/docs/" . $row['FederalTaxID']);
        }

        foreach ($registosCliente as $c){
            if(is_dir("../_contents/docs/".$row['PartyID'])) {
                $ficheiros = mostraFicheiros("../_contents/docs/" . $row['PartyID']);
                if (is_array($ficheiros)) {
                    foreach ($ficheiros as $ficheiro) {
                        moverFicheiros("../_contents/docs/" . $row['PartyID'],"../_contents/docs/" . $row['FederalTaxID']);
                        //copy("../_contents/docs/" . $row['PartyID'] . "/$ficheiro", "../_contents/docs/" . $row['FederalTaxID'] . "/$ficheiro");
                        //unlink("../_contents/docs/" . $row['PartyID'] . "/$ficheiro");
                    }
                }
                rmdir("../_contents/docs/".$row['PartyID']);
            }


        }


    }
}
die();
*/

$comments="";

$sql="select * from $nomeTabela where id_$nomeColuna='$id'";
$result=runQ($sql,$db,"VERIFICAR EXISTENTE");
if($result->num_rows!=0){
    while ($row = $result->fetch_assoc()) {/**Preenchimento dos itens do formulário*/

        include ("_criar_editar_detalhes.php");

        $content=str_replace("_kms_",$row['kilometros'],$content);
        $content=str_replace("_tempo_",date("H:i",$row['tempo_viagem']),$content);

        /**FIM Preenchimento dos itens do formulário*/

        $script='<script>
        var options={
                zoom:6,
                center: {latitude:40.34654412118006, longitude:-4.94384765625}
                //marker_center: {latitude:41.157944, longitude:-8.629105, popup:"<a href=\'https://www.latlong.net/convert-address-to-lat-long.html\'>PORTO!</a>",open:1},
            };
                getMarkers('.$id.',options,true);

                //mostrar_mapa_cliente(0,"Inserido por: <b>_nome_utilizador_</b>");
            </script>';

        if(isset($_GET['latitude']) && isset($_GET['longitude'])) {
            $content=str_replace("_latitude_",$_GET['latitude'],$content);
            $content=str_replace("_longitude_",$_GET['longitude'],$content);

            $script='
        <script>
                var markers=[
                    {latitude:'.$_GET['latitude'].', longitude:'.$_GET['longitude'].', popup:"Nova localização.<br><a href=\'javascript:void(0)\' onclick=\'guardarLocalizacao('.$_GET['latitude'].','.$_GET['longitude'].')\'><i class=\'fa fa-save\'></i> Guardar</a><br><br><a href=\'javascript:void(0)\' class=\'text-danger\' onclick=\'cancelargeo('.$id.')\'><i class=\'fa fa-times\'></i> Cancelar</a> ",open:1}
                ];
            
                var options={
                    zoom:14,
                    center: {latitude:'.$_GET['latitude'].', longitude:'.$_GET['longitude'].'}
                };
                initMap(markers,options,true);
            </script>
        ';
        }



        $classificacao=$row['classificacao'];
        $row['classificacao']="";
        for($i=1;$i<=5;$i++){
            $estrela="";
            if($i<=$classificacao){
                $estrela="<i class='fa fa-star'></i>";
            }else{
                $estrela="<i class='fa fa-star-o'></i>";
            }
            $row['classificacao'].="<a href='javascript:void(0)' class='text-warning' onclick='classificarCliente(\"".$row['FederalTaxID']."\",$i,this)'>$estrela</a>";
        }





        $row['Divida']="";
        $divida_anterior=0;



        if($row['Telephone2'] == "" || $row['Telephone2'] == "XXX"){
            $row['Telephone2'] = "Não definido";
        }

        if($row['EmailAddress'] == "" || $row['EmailAddress'] == "XXX"){
            $row['EmailAddress'] = "Não definido";
        }

        if($row['morada'] == "" || $row['morada'] == "XXX"){
            $row['morada'] = "Não definido";
        }
        if($row['local'] == "" || $row['local'] == "XXX"){
            $row['local'] = "Não local";
        }
        if($row['cdpostal'] == "" || $row['cdpostal'] == "XXX"){
            $row['cdpostal'] = "Não definido";
        }

        if($row['morada2'] != ""){
            $row['morada2']='<div>Morada2: <small class="text-muted">'.$row['morada2'].'</small></div>';
        }

        $info = '  <div class="col-lg-12" style="display: block;">
         
            <div class="row ">
             <br>
                   <div class="col-lg-12" > 
                    <ul class="nav nav-tabs" data-toggle="tabs">
                        <li class="active"><a href="#_empresa_c"><i class="fa fa-phone-square"></i> Contactos</a></li>
                        <li><a href="#_empresa_m"><i class="fa fa-map-signs"></i> Moradas</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="_empresa_c">
                        
                            <div>Telefone: <small class="text-muted">'.$row['Telephone2'].'</small></div>
                            <div>Email: <small class="text-muted">'.$row['Telephone2'].'</small></div>
                        
                        </div>
                        <div class="tab-pane" id="_empresa_m">
                        
                          <div>País: <small class="text-muted">'.$row['pais'].'</small></div>
                          <div>Localidade: <small class="text-muted">'.$row['local'].'</small></div>
                          <div>Morada: <small class="text-muted">'.$row['morada'].'</small></div>
                          '. $row['morada2'].' 
                          <div>Codigo Postal: <small class="text-muted">'.$row['cdpostal'].'</small></div>
                          
                            
                        
                        </div>
                        
                    </div>
                    <br>
                </div>
              
            </div>
        
        </div>';


        $dividaTotal=0;
        $i=0;
        $historico="";
        $orcamentos="";
        $historico_quantidades="";
        $pdf_contactos_e_moradas="";

        $nomes_das_empresas="";
 

        $pendente=$row['pendente'];

        $sql2="select * from srv_clientes where PartyID='".$row['PartyID']."'";
        $result2=runQ($sql2,$db,"nomes do cliente");
        while ($row2 = $result2->fetch_assoc()) {
            $nomes_das_empresas.="".$row2['OrganizationName']."";
        }

        $cor="text-success";
        if($pendente<0){
            $cor="text-danger";
        }

        //if($pendente != "0" && $pendente != $divida_anterior){
        if($pendente != 0 ){
            $dividaTotal += $pendente;
            $divida_anterior=$pendente;
            $row['Divida'] .= "<span class='text-muted'><b class='$cor'> <a class='text-danger' href='../mod_documentos_pendentes/index.php?PartyID=".$row['PartyID']."'>".number_format($pendente,'2','.',',')." €</a> </b> </span><br>";
        }


        $row['Comments']=nl2br($row['Comments']);

        $info=str_replace("_Comments_",$row['Comments'],$info);
        if($row['Comments']!=""){
            $comments.="".$row['Comments']."<br>";
        }


        /**
         * GET FROM SaleTransactionDetails historico de vendas e de quantidades
         */
        $array_anos = [];
        $array_valores = [];
        $valores_ano_graph="";
        if($admin==1){
            $anos=[];
            $i=0;

            $sql2 = "select ano from srv_clientes_saletransaction where  PartyID='".$row['PartyID']."' GROUP by ano order by ano";

            $result2=runQ($sql2,$db,"YEAR(CreateDate)");
            while($row2 = $result2->fetch_assoc()){

                $anos[$i] = $row2['ano'];
                $i++;
            }



            $anos=array_unique($anos);
            asort($anos);


            $documentos_positivo=[];
            $documentos_negativo=[];
            $sql2="select * from _conf_assists";
            $result2=runQ($sql2,$db,"get emails dos admins");
            while ($row2 = $result2->fetch_assoc()) {
                $documentos_positivo=json_decode($row2['documentos_fac'],true);
                $documentos_negativo=json_decode($row2['documentos_nc'],true);
            }

            foreach($anos as $ano) {


                $valorTotalAno = 0;
                $sql2 = " SELECT * FROM srv_clientes_saletransaction  where PartyID='" . $row['PartyID'] . "' and ano='" . $ano . "' and ativo=1  order by CreateDate desc ";
                $result2=runQ($sql2,$db,"srv_clientes_saletransaction 1 ");
                while($row2 = $result2->fetch_assoc()){
                    $soma = $row2['TotalAmount'];
                    if(in_array($row2['TransDocument'],$documentos_negativo)){
                        $valorTotalAno += ($row2['TotalAmount']*-1);
                        if($ano==2021){
                            print "<b style='color:red'>".date("d/m/Y",strtotime($row2['CreateDate']))." ".$row2['TransDocument']." ".$row2['TransDocNumber']." - ".$row2['TotalAmount']."</b><br>";
                        }
                    }elseif(in_array($row2['TransDocument'],$documentos_positivo)){
                        $valorTotalAno += $row2['TotalAmount'];
                        if($ano==2021){
                            print "<b style='color:green'>".date("d/m/Y",strtotime($row2['CreateDate']))." ".$row2['TransDocument']." ".$row2['TransDocNumber']." + ".$row2['TotalAmount']."</b><br>";
                        }
                    }
                }

                if($ano==2021){
                    print "<b style='color:blue'>TOTAL:".$valorTotalAno."</b>";
                    //die();
                }

                $array_anos[$o] = $ano;
                $array_valores[$o] = number_format($valorTotalAno, 2, '.', '');
                $valores_ano_graph.=$valorTotalAno.",";

                $valorTotalAno =  number_format($valorTotalAno, 2, '.', ',');



                $valorTotalAno.=" €";
                $historico .= '
                <a href="../mod_documentos/index.php?id_cliente='.$row['PartyID'].'&ano=_ano_" class="btn btn-default">
                    <small style="color: black"><b>_ano_</b> - _mes_</small><br><b class="text-success" >_valorTotal_</b>
                </a>';
                $historico = str_replace("_ano_", $ano, $historico);
                $historico = str_replace("- _mes_", "", $historico);
                $historico = str_replace("_mes_", "0", $historico);
                $historico = str_replace("_valorTotal_", $valorTotalAno, $historico);

                $o++;
            }
            /**
             * GET FROM SaleTransactionDetails
             */

        }

        $content=str_replace("_NomesDasEmpresas_",$nomes_das_empresas,$content);

        if(isset($_GET['pdfInfo'])){

            $page="
<style>

table, tr,td,th{
border:1px solid gray;
border-collapse: collapse;
}

</style>
<page backtop=\"15mm\" backbottom=\"15mm\" backleft=\"5mm\" backright=\"5mm\">

    <page_header>
    </page_header>
    
    $pdf_contactos_e_moradas
        
    <page_footer>
    </page_footer>
</page>";
            guardarPDF($page,"Informação de ".$row['OrganizationName'].".pdf","p");
            $db->close();
            die();
        }

        if($historico==""){
            $historico="_semResultados_";
        }
        if($orcamentos==""){
            $orcamentos="_semResultados_";
        }

        if($historico_quantidades==""){
            $historico_quantidades="_semResultados_";
        }
        $content=str_replace("_orcamentos_",$orcamentos,$content);
        $content=str_replace("_servicos_",$historico,$content);
        $content=str_replace("_quantidades_",$historico_quantidades,$content);

      /*  if($dividaTotal != 0 && count($registosCliente) > 1){

            $cor="text-success";
            if($dividaTotal<0){
                $cor="text-warning";
            }
            $row['Divida'] .= "<small class='text-muted' style='font-size: 13px;'>TOTAL </small><b class='$cor'> ".number_format($dividaTotal,'2','.',',')." €</b> <br>";
        }*/




        if($row['Divida']==""){
            $row['Divida']="<small class='text-success'>Não tem <i class='fa fa-thumbs-up'></i></small>";
        }

        $content=str_replace("_info_",$info,$content);


        $notas="";
        $comentarios="";
        $c=0;
        $sql2 ="select * from srv_clientes_notas where FederalTaxID='".$row["FederalTaxID"]."' and ativo=1 and comentario = '0' order by created_at desc";
        $result2=runQ($sql2,$db,"tabela notas");
        while ($row2 = $result2->fetch_assoc()) {

            $sql3 ="select * from utilizadores where id_utilizador='".$row2["id_criou"]."'";
            $result3=runQ($sql3,$db,"tabela notas");
            while ($row3 = $result3->fetch_assoc()) {
                $nome_utilizador=$row3['nome_utilizador'];
            }
            $sql3 ="select * from utilizadores where id_utilizador='".$row2["id_editou"]."'";
            $result3=runQ($sql3,$db,"tabela notas");
            while ($row3 = $result3->fetch_assoc()) {
                $nome_utilizador=$row3['nome_utilizador'];
            }

            $notas.=$tpl_nota;

            $notas=str_replace("_id_nota_",$row2['id_nota'],$notas);

            if($row2['notificar_administradores']=="checked"){
                $notas=str_replace('id="notificaradminsnota'.$row2['id_nota'].'"','id="notificaradminsnota'.$row2['id_nota'].'" checked="'.$row2['notificar_administradores'].'"',$notas);
            }

            if($row2['mostrar_funcionarios']=="checked"){
                $notas=str_replace('id="mostrarfuncionariosnota'.$row2['id_nota'].'"','id="mostrarfuncionariosnota'.$row2['id_nota'].'" checked="'.$row2['mostrar_funcionarios'].'"',$notas);
            }

            $notas=str_replace("_cor_",$row2['cor'],$notas);
            $notas=str_replace("_nota_",($row2['descricao']),$notas);
            $notas=str_replace("_dataCriado_",date("d/m/Y H:s",strtotime($row2['created_at'])),$notas);
            $notas=str_replace("_nomeCriou_",$nome_utilizador,$notas);
            $notas=str_replace("_lembrar_",date("Y-m-d",strtotime($row2['data_lembrete'])),$notas);
            $c++;

        }


        $sql2 ="select * from srv_clientes_notas where FederalTaxID='".$row["FederalTaxID"]."' and ativo=1 and comentario = '1' order by created_at asc";
        $result2=runQ($sql2,$db,"tabela notas");
        while ($row2 = $result2->fetch_assoc()) {
            $utilizadorCriou = getInfoTabela('utilizadores', " and id_utilizador='" . $row2['id_criou'] . "' and ativo=1");
            $nome_utilizador = "";

            $data = "";
            $foto = "";
            if(isset($utilizadorCriou[0])) {
                $nome_utilizador = $utilizadorCriou[0]['nome_utilizador'];
                $data = strtotime($row2['created_at']);
                $data = date('d-m-Y H:i', $data);
                $foto = "../_contents/fotos_utilizadores/" . $utilizadorCriou[0]['foto'];
            }

            /*$comentarios.='<div class="col-lg-12 nota-editavel">

                                 <span><label style="font-size: 13px"> Criado por: '.strtoupper($nome_utilizador).' </label></span> <span style="font-size: 11px">('.$data.')</span>
                                   <span class="save-delete-nota">
                                    <a href="#" onclick="editarComentario('.$row2['id_nota'].', this)" class="btn"><i class="fa fa-save" ></i></a>
                                    <a href="#" onclick=\'confirmaModal("../mod_notas/reciclar.php?id='.$row2['id_nota'].'")\' class="btn"><i class="fa fa-trash"></i></a>
                                </span>
                                <p class="form form-control input-for-nota-editavel">'.$row2['descricao'].'</p>

                            </div>';*/

            $btnDelete="";
            if(in_array(1,$_SESSION['grupos']) || in_array(2,$_SESSION['grupos'])){
                $btnDelete=' <span class="save-delete-nota">
                       <!-- <a href="#" onclick="editarComentario(' . $row2['id_nota'] . ', this)" class="btn"><i class="fa fa-save" ></i></a>-->
                        <a href="#" onclick=\'confirmaModal("../mod_notas/reciclar.php?id=' . $row2['id_nota'] . '")\' class="btn"><i class="fa fa-trash"></i></a>
                        </span>';
            }
            $comentarios .= '
            <div class="col-lg-12 comentario-row">
                <span class="foto-utilizador"><img src="' . $foto . '" alt="' . $foto . '"></span>
                <div style="word-break: break-all;">
                    <div>
                     <span class="nome-utilizador"><b>' . $nome_utilizador . '</b> <label class="text-muted" style="font-size: 11px">(' . $data . ')</label></span>
                       '.$btnDelete.'
                    </div>
                    <p class="text-muted">' .  nl2br($row2['descricao']) . '</p>
                </div>
                
            </div>';
        }




        $content=str_replace("_linhascomentarios_",$comentarios,$content);

        $content=str_replace("_notas_",$notas,$content);
        $content=str_replace("_cntNotas_",$c,$content);

        $galeria=get_galeria('docs',$row['FederalTaxID']);

        $content=str_replace("_documentos_",$galeria,$content);








        // GET MAQUINAS DO CLIENTE
        $maquinas = getInfoTabela('maquinas'," and id_cliente ='$id'");

        $linhas_maquinas=' <div class="sem-dados-maquinas">
                <div class="well well-sm text-center"><i class="text-muted"> Sem máquinas atribuídas</i>  </div>
            </div>';

        if(isset($maquinas[0])){
            $linhas_maquinas="";


            foreach($maquinas as $maquina){

                $maquina['descricao_maquina'] = (strlen($maquina['descricao_maquina']) > 60) ? substr($maquina['descricao_maquina'],0,57).'...' : $maquina['descricao_maquina'];
                $maquina['defeitos'] = (strlen($maquina['defeitos']) > 60) ? substr($maquina['defeitos'],0,57).'...' : $maquina['defeitos'];

                $garantia="<small class='text-muted'>Sem garantia</small>";
                if($maquina['garantia']==1){
                    $garantia="<span class='label label-danger'><i class='fa fa-warning'></i> Garantia</span>";
                }

                $linhas_maquinas.=" 
                <div class='linha' onclick='OpenModalHistoricoMaquina(".$maquina['id_maquina'].")' id_maquina='".$maquina['id_maquina']."'>
                   <span>
                   <strong>".$maquina['nome_maquina']."</strong> (".$maquina['ref'].") <br> 
                   <small class='text-muted'>Obs:</small><i class='text-info'> ".$maquina['descricao_maquina']."</i> <br>
                   </span> 
                   
                   <a  href='#'>  <i class='fa fa-play'></i> </a> 
                </div>
      
         ";

            }

        }


        $content=str_replace('_maquinas_', $linhas_maquinas,$content);




        /* ASSISTENCIAS INICIADAS */

        $assistencias_clientes = getInfoTabela('assistencias_clientes',
            "  and id_cliente='$id' and assinado=1 and ativo=1 order by data_inicio desc ");


        $linha_assistencia_clientes = "";

        $linhas=' <div class="sem-dados-assistencias-clientes">
                <div class="well well-sm text-center"><i class="text-muted"> Sem assistências </i>  </div>
            </div>';

        if(isset($assistencias_clientes[0])) {
            $linhas = "";

            foreach ($assistencias_clientes as $assistencias_cliente) {

                $id_assistencia_cliente = $assistencias_cliente['id_assistencia_cliente'];

                $tipo_assistencia = "<small class='label label-default'><i class='fa fa-truck'></i> Externa</small>";
                if ($assistencias_cliente['externa'] == "0") {
                    $tipo_assistencia = "<small class='label label-danger'><i class='fa fa-home'></i> Interna</small>";
                }

                $data_inicio = "";
                if ($assistencias_cliente['data_inicio'] != "0000-00-00 00:00:00") {
                    if (date("d/m/Y", strtotime($assistencias_cliente['data_inicio'])) == date("d/m/Y", strtotime(current_timestamp))) {
                        $data_inicio = "Hoje às " . date("H:i", strtotime($assistencias_cliente['data_inicio']));
                    } elseif (date("d/m/Y", strtotime($assistencias_cliente['data_inicio'])) == date("d/m/Y", strtotime(current_timestamp . ' -1 days'))) {
                        $data_inicio = "Ontem às " . date("H:i", strtotime($assistencias_cliente['data_inicio']));
                    } else {
                        $data_inicio = $cfg_diasdasemana[date("w", strtotime($assistencias_cliente['data_inicio']))] . "/" . date("d, H:i", strtotime($assistencias_cliente['data_inicio']));
                    }

                    $data_inicio = "$data_inicio";
                }

                $categoria = getInfoTabela('assistencias_categorias', ' and id_categoria = "' . $assistencias_cliente['id_categoria'] . '"');
                $nome_categoria = "<small class='label' style='background: black'>Sem categoria</small>";
                if (isset($categoria[0])) {
                    $nome_categoria = "<small class='label' style='background: " . $categoria[0]['cor_cat'] . "'>" . $categoria[0]['nome_categoria'] . "</small>";
                }

                $tecnico = getInfoTabela('utilizadores', ' and id_utilizador="' . $assistencias_cliente['id_utilizador'] . '"');
                $nome_tecnico = $tecnico[0]['nome_utilizador'];

                $descricao = nl2br($assistencias_cliente['descricao']);
                if ($descricao != "") {
                    $descricao = "<br><code><small>$descricao</small></code>";
                }

                $maquinas = "";
                $maquinas_assistencia = getInfoTabela('assistencias_clientes_maquinas', ' and ativo=1 and id_assistencia_cliente = "' . $id_assistencia_cliente . '"');
                foreach ($maquinas_assistencia as $ma) {
                    $maquina = getInfoTabela('maquinas', ' and id_maquina= "' . $ma['id_maquina'] . '"');
                    $maquina = $maquina[0];

                    $garantia = "";
                    if ($ma['garantia'] == 1) {
                        $garantia = "<small class='text-warning garantia-info'><i class='fa fa-warning'></i> Garantia</small>";
                    }

                    $concluido = "";
                    if ($ma['concluido'] == 0) {
                        $concluido = "<small class='text-danger garantia-info'><i class='fa fa-warning'></i> Não Concluído</small>";
                    }

                    $revisao = "";
                    if ($ma['revisao_periodica'] == 1) {
                        $revisao = "<small class='text-info garantia-info'>Revisão: " . number_format($ma['horas_revisao'], 0, "", ".") . "h </small>";
                    }

                    $maquinas .= "<br><small>" . $maquina['nome_maquina'] . " (" . $maquina['ref'] . ") $concluido $garantia $revisao</small>";
                }

                $por_terminar = "";
                if ($assistencias_cliente['por_terminar'] == 1) {
                    $por_terminar = "<small class='text-danger '>Por terminar </small>";
                }

                if ($maquinas != "") {
                    $maquinas = "<br><small class='text-muted'>Máquinas:</small>$maquinas";
                }

                $linhas .= "
        <div class='well well-sm' style='cursor: pointer;margin-bottom: 5px' onclick='addAssistClienteMaquina(this, 1)' id_assistencia_cliente='$id_assistencia_cliente'>
           <b>$data_inicio</b> $por_terminar<br>
           $tipo_assistencia $nome_categoria<br>
                        <b>" . $assistencias_cliente['nome_assistencia_cliente'] . "</b> com <b><i class='fa fa-user'></i>$nome_tecnico</b>
                         $descricao
                         $maquinas
        </div>";

            }
        }
        $content = str_replace('_assistencias_', $linhas, $content);



        $nif=$row['FederalTaxID'];

        $sql2="select * from srv_clientes_geo where nif='$nif' order by nome_geo asc";
        $result2=runQ($sql2,$db,"1");
        $geo="";
        while ($row2 = $result2->fetch_assoc()) {
            $geo.="<option value='".$row2['id_geo']."'>".removerHTML($row2['nome_geo'])."</option>";
        }
        $content=str_replace('_listaGeo_',$geo,$content);

        foreach ($row as $key => $val){
            $content=str_replace("_".$key."_",$val,$content);
        }

    }
    $content=str_replace("_comentariosSAGE_",$comments,$content);
    if(isset($_GET['apagar'])){
        if(isset($_POST['eliminar'])){
            if(is_array($_POST['eliminar'])){
                foreach ($_POST['eliminar'] as $f){
                    if(is_file("../_contents/docs/$nif/$f")){
                        unlink("../_contents/docs/$nif/$f");
                    }else{
                        print "../_contents/docs/$nif/$f";
                    }

                }
            }
        }
        header("location: detalhes.php?id=$id&cod=1");
        $db->close();
        die();
    }


    /**Preenchimento dos itens do formulário*/

    $disco=espacoDisco($cfg_espacoDisco,$cfg_espacoReservadoSys);
    $livre="sem dados";
    foreach ($disco as $d){
        if($d['nome']=='Livre'){
            $livre=$d['tamanho'];
        }
    }
    if($livre<=0){
        $content=str_replace("_dropZone_","<h3>Espaço em disco insuficiente</h3>",$content);
    }else{
        $content=str_replace("_dropZone_", '<form action="" id="dropzoneClientes" class="dropzone dz-clickable">
                                                   
                                                </form>',$content);
    }

    /**FIM Preenchimento dos itens do formulário*/

    $pageScript='
<script src="../assets/layout/js/jquery.sparkline.min.js"></script>
<script src="detalhes.js"></script>
<script>



let array_anos = '.json_encode($array_anos).';
let array_valores = '.json_encode($array_valores).';
setTimeout(function (){
 
    // Bar chart
    
    /*
    new Chart(document.getElementById("bar-chart"), {
        type:"bar",
        data: {
            labels: array_anos,
            datasets: [
                {
                    label: "Valor faturado (€)",
                    backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                    data: array_valores
                }
            ]
        },
        options: {
            legend: { display: false },
            title: {
                display: true,
                text: "Faturação dos ultimos anos"
            }
        }
    });
    */
    
    


/* Sparklines can also take their values from the first argument
passed to the sparkline() function */
var myvalues = ['.$valores_ano_graph.'];

var ops={
                type: "line",
                width: "100%",
                height: "100px",
                tooltipOffsetX: -25,
                tooltipOffsetY: 20,
                lineColor: "#2793E6",
                fillColor: "#7abaeb",
                spotColor: "#555555",
                minSpotColor: "#555555",
                maxSpotColor: "#555555",
                highlightSpotColor: "#555555",
                highlightLineColor: "#555555",
                spotRadius: 3,
                tooltipPrefix: "",
                tooltipSuffix: " de faturação",
                tooltipFormat: "{{prefix}}{{y}}{{suffix}}"
}

$(".dynamicsparkline").sparkline(myvalues,ops);

}, 50)
    
</script>
<script src="../assets/layout/js/plugins/chartjs/Chart.min.js"></script>
<script src="../assets/layout/js/plugins/signature_pad.min.js"></script>'.$script;
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod 2","Não foi encontrado nenhum registo com o ID:".$id,""));
}
include ('../_autoData.php');