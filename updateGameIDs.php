<?php

$apiKey = 'YOUR_API_KEY';

$connection = mysql_connect("YOUR_DATABASE_IP", "YOUR_DATABASE_USERNAME", "YOUR_DATABASE_PASSWORT");
mysql_select_db("YOUR_DATABASE_FOR_THIS_PAGES");

$query1 = "SELECT timestamp FROM options";
$oldTimestamp = mysql_query($query1);
$newTimestamp;
while ($row = mysql_fetch_object($oldTimestamp)) {
    echo "Old Time: " . date("d.m.Y H:i", $row->timestamp) . "\n";
    $newTimestamp = (int) $row->timestamp + 300;
}
echo "New Time: " . date("d.m.Y H:i", $newTimestamp) . "\n";

$query2 = "UPDATE options SET timestamp=" . $newTimestamp;
$update = mysql_query($query2);

$url = 'https://euw.api.pvp.net/api/lol/euw/v4.1/game/ids?beginDate=' . $newTimestamp . '&api_key=' . $apiKey;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    $GameIdArray = json_decode($response, TRUE);

    foreach ($GameIdArray as $value) {
        $query2 = "INSERT INTO GameIdsList (time, gameID) VALUES (" . $newTimestamp . "," . $value . ")";
        $result = mysql_query($query2);
    }
} else {
    echo "=> Error! \n\n";
}
