<?php
require_once("databse.php");
getLastReadings();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/normalize.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <title>Weatherstation</title>
    </head>
    <body>
        <?php include_once("header.html")?>
        <main>
            <a href="temperature.php" class="item">
                <img class="icon" src="img/thermometer.svg">
                <p class="itemname">Temperature</p>
                <p class="itemvalue"><?=$result[0]?>&deg;C</p>
                <img class="more" src="img/nav-arrow-right.svg">
            </a>
            <div class="item">
                <img class="icon" src="img/strong-wind.svg">
                <p class="itemname">Wind speed</p>
                <p class="itemvalue"><?=$result[4]?> km/h</p>
                <img class="more" src="img/nav-arrow-right.svg">
            </div>
            <div class="item">
                <img class="icon" src="img/humidity.svg">
                <p class="itemname">Humidity</p>
                <p class="itemvalue"><?=$result[3]?>%</p>
                <img class="more" src="img/nav-arrow-right.svg">
            </div>
            <div class="item">
                <img class="icon" id="compass" src="img/compass_east.svg">
                <p class="itemname">Wind direction</p>
                <?php
                    if($result[5] >= 45 && $result[5] < 135){
                        $winddirection = "East";
                    }
                    if($result[5] >= 135 && $result[5] < 225){
                        $winddirection = "South";
                    }
                    if($result[5] >= 225 && $result[5] < 315){
                        $winddirection = "West";
                    }
                    if($result[5] < 45 || $result[5] >= 315){
                        $winddirection = "North";
                    }

                ?>
                <p class="itemvalue"><?=$winddirection?></p>
                <img class="more" src="img/nav-arrow-right.svg">
            </div>
            <div class="item">
                <img class="icon" src="img/cloud.svg">
                <p class="itemname">CO2</p>
                <p class="itemvalue"><?=$result[4]?> PPM</p>
                <img class="more" src="img/nav-arrow-right.svg">
            </div>
            <div class="item">
                <img class="icon" src="img/rain.svg">
                <p class="itemname">Rain</p>
                <p class="itemvalue"><?=$result[1]?> mm/h</p>
                <img class="more" src="img/nav-arrow-right.svg">
            </div>
        </main>
    </body>
</html>