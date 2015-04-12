<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Random URF Builds</title>
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
        <?php
        $connection = mysql_connect("YOUR_DATABASE_IP", "YOUR_DATABASE_USERNAME", "YOUR_DATABASE_PASSWORT") or die("Database Error!");
        mysql_select_db("YOUR_DATABASE_FOR_THIS_PAGES") or die("Database Error!");

        $query1 = "SELECT * FROM GameIdsList";
        $result1 = mysql_query($query1);
        ?>
    </head>
    <body>
        <h2>Over <span id="buildNumber"></span> Builds collected in URF Games!</h2>
        <form action="getMyBuild.php" method="get">
            <button style="font-size: 15px;">I want a build!</button>
        </form>
        <script>
            var buildsCollected = <?php echo mysql_num_rows($result1) * 10; ?>;
            var addPer100Ms;
            var span = document.getElementById("buildNumber");
            var precision = 80;
            var time = 3;

            function init() {
                addPer100Ms = Math.round(buildsCollected / precision);
                for (var i = 0; i <= precision; i++) {
                    window.setTimeout(addNumbers, i * ((time * 1000) / precision), i);
                }
            }

            function addNumbers(i) {
                if (i === precision) {
                    span.innerHTML = buildsCollected;
                } else {
                    span.innerHTML = (addPer100Ms * i);
                }
            }

            window.addEventListener("load", init);
        </script>
    </body>
</html>
