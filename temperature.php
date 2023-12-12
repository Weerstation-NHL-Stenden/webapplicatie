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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <title>Weatherstation</title>
    </head>
    <body>
        <?php include_once("header.html")?>
        <main id="graphmain">
            <canvas id="tempChart" width="400" height="200"></canvas>
            <script>
                fetch('temptabledata.php')
                    .then(response => response.json())
                    .then(data => {
                        const timedate = data.map(item => item.timedate);
                        const temp = data.map(item => item.temp);

                        const ctx = document.getElementById('tempChart').getContext('2d');
                        const tempChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: timedate,
                                datasets: [{
                                    label: 'Temperature',
                                    data: temp,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    x: {
                                        ticks: {
                                            maxTicksLimit: 20
                                        }
                                    },
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
            </script>
        </main>
    </body>
</html>