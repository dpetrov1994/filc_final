<?php

include "../../_funcoes.php";
include "../dados_plataforma.php";

$db=ligarBD();

/* aurora email tracking*/

include "minibots.class.php";
$minibots= new Minibots();
include "Mobile_Detect.php";
include "detect.php";
$d = new Detect();

$domain = ((@$_SERVER['HTTP_HOST']));
$sql="select * from _conf_assists where id_conf=1";
$result=runQ($sql,$db,"dominio");
while ($row = $result->fetch_assoc()) {
    $domain=$row['dominio'];
}



if (isset($_GET["code"]) && !empty($_GET["code"]))
{



    $code=$db->escape_string($_GET["code"]);
    $sql = "select * from imap where tracking_code='$code'";
    $result=runQ($sql,$db,"conf assists");
    while($row = $result->fetch_assoc()){

        $tracking_info=json_decode($row['tracking_info'],true);
        if(!is_array($tracking_info)){
            $tracking_info=[];
        }


        $ip=$minibots->getIP();
        $geo="";
        //$geo=$minibots->doGeoIp($ip);
        $tracking_info[]=[
            'date'=>current_timestamp,
            'browser'=>$_SERVER['HTTP_USER_AGENT'],
            'ip'=>$ip,
            'geo'=>$geo,
            'device'=>[
                'deviceType'=>$d->deviceType(),
                'os'=>$d->os(),
                'browser'=>$d->browser(),
                'brand'=>$d->brand(),
            ]
        ];

        $tracking_info=json_encode($tracking_info);
        $sql2 = "update imap set tracking_info='$tracking_info', lido=1 where tracking_code='$code'";
        $result2=runQ($sql2,$db,"update tracking");
    }

    $img="blank.png";

}

$db->close();

$graphic_http='https://'.$domain."/blank.png";
$filesize = filesize('../../blank.png');
//Now actually output the image requested, while disregarding if the database was affected
header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private', false);
header('Content-Disposition: attachment; filename="blank.png"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . $filesize);
readfile($graphic_http);