<?php
$footer = '
<small>
    Data da última sincronização: _dataSync_<br>
    <small>Desenvolvido por <a href="https://petrovnetwork.com/" target="_blank">PetrovNetwork</a></small>
</small>
';

if(isset($_SESSION['id_utilizador'])){
    $sql ="SELECT * FROM _conf_cliente WHERE id_conf='1'";
    $result=runQ($sql,$db,1);
    if($result->num_rows==1){
        while($row = $result->fetch_assoc()) {
            $footer=str_replace("_dataSync_",date("d/m/Y H:i",strtotime($row['data_sync']))." - ".humanTiming($row['data_sync']),$footer);
        }
    }
}
$footer=str_replace("_dataSync_","",$footer);
