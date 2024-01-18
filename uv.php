<?php
require_once("databse.php");

$dataurl = "uvtabledata.php";

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $start = filter_input(INPUT_POST, "start", FILTER_SANITIZE_SPECIAL_CHARS);
    $end = filter_input(INPUT_POST, "end", FILTER_SANITIZE_SPECIAL_CHARS);
    if(isset($start) && isset($end)){
        $dataurl = $dataurl . "?start=" . $start . "&end=" . $end;
    }
}
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
            <div class="chartcontainer">
                <canvas id="uvChart" width="400" height="200"></canvas>
            </div>
            <script>
                fetch('<?=$dataurl?>')
                    .then(response => response.json())
                    .then(data => {
                        const timedate = data.map(item => item.timedate);
                        const uv = data.map(item => item.uv);

                        const ctx = document.getElementById('uvChart').getContext('2d');
                        const tempChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: timedate,
                                datasets: [{
                                    label: 'UV',
                                    data: uv,
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

                function beforePrintHandler () {
                    for (let id in Chart.instances) {
                        Chart.instances[id].resize();
                    }
                }

                window.addEventListener('beforeprint', () => {
                    uvChart.resize(600, 600);
                });
                window.addEventListener('afterprint', () => {
                    uvChart.resize();
                });
            </script>
            <form action="uv.php" method="POST">
                <label for="start">Start Date:</label>
                <input type="date" id="start" name="start">

                <label for="end">End Date:</label>
                <input type="date" id="end" name="end">

                <button type="submit">Update Chart</button>
            </form>
        </main>
    </body>
</html>