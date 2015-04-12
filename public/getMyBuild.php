<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Your Build</title>
        <link href="style.css" type="stylesheet">
        <link rel="icon" href="../picutres/WebLogo.png" type="image/png">
        <style>
            body{
                text-align: center;
                margin-left: auto;
                margin-right: auto;
                font-family: sans-serif;
                background-image: url("../picutres/Background.png");
                background-position: center top;
                background-size: auto;
                background-repeat: no-repeat;
            }
        </style>
        <script>
            window.addEventListener("load", init);
            var rulesShown = false;
            function init() {
                document.getElementById("rulesbutton").addEventListener("click", buttonEvent);
            }
            function buttonEvent() {
                var rulesdiv = document.getElementById("rules");
                if (rulesShown) {
                    rulesdiv.style.display = "none";
                    rulesShown = false;
                } else {
                    rulesdiv.style.display = "block";
                    rulesShown = true;
                }
            }
        </script>
    </head>
    <body>
        <?php
        $apiKey = "YOUR_API_KEY";

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

        $summeronsSpells = array(
            1 => "SummonerBoost.png",
            2 => "Clairvoyance",
            3 => "SummonerExhaust.png",
            4 => "SummonerClairvoyance.png",
            6 => "SummonerHaste.png",
            7 => "SummonerHeal.png",
            11 => "SummonerSmite.png",
            12 => "SummonerTeleport.png",
            13 => "SummonerMana.png",
            14 => "SummonerDot.png",
            21 => "SummonerBarrier.png"
        );

        $connection = mysql_connect("YOUR_DATABASE_IP", "YOUR_DATABASE_USERNAME", "YOUR_DATABASE_PASSWORT") or die("Database Error!");
        mysql_select_db("YOUR_DATABASE_FOR_THIS_PAGES") or die("Database Error!");

        $query1 = "SELECT * FROM GameIdsList";
        $result1 = mysql_query($query1);
        $rows = mysql_num_rows($result1);

        $random1 = rand(2, $rows + 2);

        $query2 = "SELECT gameID FROM GameIdsList WHERE primeKey = " . $random1;
        $result2 = mysql_query($query2);
        $gameID;

        while ($row = mysql_fetch_object($result2)) {
            $gameID = $row->gameID;
        }

        $url = 'https://euw.api.pvp.net/api/lol/euw/v2.2/match/' . $gameID . '?api_key=' . $apiKey;

        $response1 = curl_request($url);

        if ($response1['httpCode'] == 200) {
            $gameData = json_decode($response1['response'], TRUE);

            $player = rand(0, 9);

            $playerdata = $gameData['participants'][$player];
            //print_r($playerdata);
            ?>

            <img src="http://ddragon.leagueoflegends.com/cdn/5.6.2/img/champion/<?php
        $result3 = mysql_query('SELECT * FROM champions WHERE id=' . $playerdata['championId'] . ';');
        echo mysql_fetch_object($result3)->keyName;
            ?>.png">
            <img src="http://ddragon.leagueoflegends.com/cdn/5.6.2/img/spell/<?php echo $summeronsSpells[$playerdata['spell1Id']] ?>">
            <img src="http://ddragon.leagueoflegends.com/cdn/5.6.2/img/spell/<?php echo $summeronsSpells[$playerdata['spell2Id']] ?>">
            <div>
                <?php
                $count = 0;
                while ($count < 7) {
                    if ($playerdata['stats']['item' . $count] != 0) {
                        ?> <img src="http://ddragon.leagueoflegends.com/cdn/5.6.2/img/item/<?php echo $playerdata['stats']['item' . $count]; ?>.png"> <?php
                    } else {
                        ?> <img src="../picutres/Clear.png"> <?php
                    }
                    $count++;
                }
                ?>
            </div>
            <?php
        } else {
            echo 'Error!<br>HttpCode: ' . $response1['httpCode'];
        }
        ?>
        <form action="getMyBuild.php" method="get">
            <button style="font-size: 15px;">A new one pls!</button>
        </form>
        <br/>
        <button id="rulesbutton" style="font-size: 15px;">Rules</button>
        <br>
        <div id="rules" style="display: none; background-color: rgba(0, 0, 0, 0.1); width: 40%; margin-left: auto; margin-right: auto; text-align: left;">
            <ul style="list-style: disc;">
                <li>You allowed to build items, if they aren't complete or the slot is empty!</li>
                <li>If you make a video and use this site, it would be nice if you like this site in the description!</li>
                <li>Have fun!</li>
            </ul>
        </div>

    </body>
</html>
