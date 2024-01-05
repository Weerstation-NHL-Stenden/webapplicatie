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
            <a href="windspeed.php" class="item">
                <img class="icon" src="img/strong-wind.svg">
                <p class="itemname">Wind speed</p>
                <p class="itemvalue"><?=$result[4]?> km/h</p>
                <img class="more" src="img/nav-arrow-right.svg">
            </a>
            <div class="item">
                <img class="icon" src="img/humidity.svg">
                <p class="itemname">Humidity</p>
                <p class="itemvalue"><?=$result[3]?>%</p>
                <img class="more" src="img/nav-arrow-right.svg">
            </div>
            <div class="item">
                <?php
                if ($result[5] >= 337.5 || $result[5] < 22.5) {
                    $winddirection = "North";
                } elseif ($result[5] >= 22.5 && $result[5] < 67.5) {
                    $winddirection = "Northeast";
                } elseif ($result[5] >= 67.5 && $result[5] < 112.5) {
                    $winddirection = "East";
                } elseif ($result[5] >= 112.5 && $result[5] < 157.5) {
                    $winddirection = "Southeast";
                } elseif ($result[5] >= 157.5 && $result[5] < 202.5) {
                    $winddirection = "South";
                } elseif ($result[5] >= 202.5 && $result[5] < 247.5) {
                    $winddirection = "Southwest";
                } elseif ($result[5] >= 247.5 && $result[5] < 292.5) {
                    $winddirection = "West";
                } elseif ($result[5] >= 292.5 && $result[5] < 337.5) {
                    $winddirection = "Northwest";
                } else {
                    $winddirection = "Error";
                }
                $imageName = strtolower($winddirection);
                ?>
                <img class="icon" id="compass" src="img/compass_<?=$imageName?>.svg">
                <p class="itemname">Wind direction</p>
                <p class="itemvalue"><?=$winddirection?></p>
                <img class="more" src="img/nav-arrow-right.svg">
            </div>
            <div class="item">
                <img class="icon" src="img/cloud.svg">
                <p class="itemname">CO2</p>
                <p class="itemvalue"><?=$result[6]?> PPM</p>
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