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
        <header>
            <div>
                <h1>Weatherstation</h1>
                <h2>Last update: <?=$result[7]?></h2>
            </div>
        </header>
        <main>
            <div class="item">
                <img class="icon" src="img/thermometer.svg">
                <p class="itemname">Temperature</p>
                <p class="itemvalue"><?=$result[0]?>&deg;C</p>
                <img class="more" src="img/nav-arrow-right.svg">
            </div>
            <div class="item">
                <img class="icon" src="img/strong-wind.svg">
                <p class="itemname">Wind speed</p>
                <p class="itemvalue"><?=$result[1]?> km/h</p>
                <img class="more" src="img/nav-arrow-right.svg">
            </div>
            <div class="item">
                <img class="icon" src="img/humidity.svg">
                <p class="itemname">Humidity</p>
                <p class="itemvalue"><?=$result[2]?>%</p>
                <img class="more" src="img/nav-arrow-right.svg">
            </div>
            <div class="item">
                <img class="icon" src="img/">
                <p class="itemname">Wind direction</p>
                <p class="itemvalue">West</p>
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
                <p class="itemvalue">2 mm/h</p>
                <img class="more" src="img/nav-arrow-right.svg">
            </div>
        </main>
    </body>
</html>