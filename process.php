<?php

    $url = $_GET['original'];
    $type = explode(".",$url)[3];
    $i  = $_GET['pos'];
    $query  = $_GET['query'];
    $ch = curl_init("https://api.tinify.com/shrink");
    $headers = [
        'Content-Type: application/json',
        'Authorization: Basic '.base64_encode('api:1CfLB5n6q7F85Rn8yLf8R1QwtTWTNGNf')
    ];

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS,'{"source": {"url": "'.$url.'"} }');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec ($ch);
    curl_close ($ch);
    $data = json_decode($server_output,true);
    $remoteURL = $data['output']['url'];
// Force download

$ch = curl_init($remoteURL);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);
header("Content-Disposition: attachment; filename=\"tinypixel-".$query."-".$i.".".$type."\"");
header("Content-type: image/".$type); 
header("Set-Cookie: fileLoading=true");
echo $server_output;
?>