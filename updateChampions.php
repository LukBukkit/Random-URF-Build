<?php

$apiKey = 'YOUR_API_KEY';

$connection = mysql_connect("YOUR_DATABASE_IP", "YOUR_DATABASE_USERNAME", "YOUR_DATABASE_PASSWORT");
mysql_select_db("YOUR_DATABASE_FOR_THIS_PAGES");

function curl_request($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return array(
        "httpCode" => $httpCode,
        "response" => $response
    );
}

$request = curl_request('https://global.api.pvp.net/api/lol/static-data/euw/v1.2/champion?champData=info&api_key=' . $apiKey);

if ($request['httpCode'] == 200) {
    $championArray = json_decode($request['response'], TRUE)['data'];
    foreach ($championArray AS $champion) {
        echo "ID: ".$champion['id']."\n Key: ".$champion['key']."\n Name: ".$champion['name']."\n";
        $query1 = "INSERT INTO champions (id, keyName, name) VALUES (" .$champion['id'].", '" . $champion['key'] . "', '" . str_replace("'", "\'", $champion['name']) . "')";
        //$query1 = "UPDATE champions Set id=".$champion['id'].", keyName='".$champion['key'] ."',name='".str_replace("'", "\'", $champion['name'])."';";
        mysql_query($query1);
    }
    echo 'Success!';
} else {
    echo 'Error!';
}