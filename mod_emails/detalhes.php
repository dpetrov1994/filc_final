<?phpinclude ('../_template.php');$content=file_get_contents("detalhes.tpl");if(isset($_GET['id'])) {    $id=$db->escape_string($_GET['id']);    $sql="select * from _emails_enviados where id_email=$id";    $result=runQ($sql,$db,"1");    if($result->num_rows!=0){        while ($row = $result->fetch_assoc()) {            $content=str_replace("_idParent_",$row['id_email'],$content);            $content=str_replace("_nomePrato_",$row['assunto'],$content);            $content=str_replace("_nomeDestinatario_",$row['destinatario'],$content);            $content=str_replace("_ficheiro_","docs/".$row['ficheiro'],$content);            if($row['tipo']==1){                $content=str_replace("_tipo_","SMS",$content);            }else{                $content=str_replace("_tipo_","E-MAIL",$content);            }            if($row['estado']==0){                $estado='<label class="label label-success">  ENVIADO</label>';            }else{                $estado='<label class="label label-danger">  '.removerHTML($row['estado']).'</label>';            };            $content=str_replace("_estadoParent_",$estado,$content);            $criated_at = strftime("%d/%m/%Y %H:%M:%S", strtotime($row['created_at']))." - ".humanTiming($row['created_at']);            $content=str_replace("_dataCriado_",$criated_at,$content);            $id_criou=$row['id_criou'];            $content=str_replace("_idCriou_",$id_criou,$content);        }        $sql="select nome_utilizador from utilizadores where id_utilizador=$id_criou";        $result=runQ($sql,$db,"1");        while ($row = $result->fetch_assoc()) {            $content=str_replace("_nomeCriou_",removerHTML($row['nome_utilizador']),$content);        }    }else{        exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Lamentamos mas não pode aceder a esta página sem fornecer todos os dados necessários.",""));    }    $addUrl = "?id=$id";}else{    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Lamentamos mas não pode aceder a esta página sem fornecer todos os dados necessários.",""));}include ('../_autoData.php');