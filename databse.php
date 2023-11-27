<?php
  $servername = "localhost";
  $dbname = "weerstation";
  $username = "weerstation";
  $password = "Kjeltmeteent";

  
  
  function getLastReadings() {
    global $servername, $username, $password, $dbname;

    try{
		$dbconnect= new PDO ("mysql:host=$servername;dbname=$dbname;charset=utf8","$username","$password");
	}catch(Exception $ex){
		echo $ex;
    }
    
    if(!isset($dbconnect)){
      die("Geen connectie");
    }
    $sql = $dbconnect->prepare("SELECT temp, rain, airPress, humidity, windspeed, winddirection, co2, timedate FROM weerstation ORDER BY timedate DESC LIMIT 1");
    $sql->execute();
    return $sql->fetch();
  }

  function minReading() {
    global $servername, $username, $password, $dbname;

    try{
		$dbconnect= new PDO ("mysql:host=$servername;dbname=$dbname;charset=utf8","$username","$password");
	}catch(Exception $ex){
		echo $ex;
    }
    
    if(!isset($dbconnect)){
      die("Geen connectie");
    }

    $sql = $dbconnect->prepare("SELECT MIN(temp) AS min_waarde, timedate FROM weerstation WHERE DATE(timedate) = CURDATE()");
    $sql->execute();

    return $sql->fetch();
  }

  function maxReading() {
    global $servername, $username, $password, $dbname;

    try{
		$dbconnect= new PDO ("mysql:host=$servername;dbname=$dbname;charset=utf8","$username","$password");
	}catch(Exception $ex){
		echo $ex;
    }
    
    if(!isset($dbconnect)){
      die("Geen connectie");
    }

    $sql = $dbconnect->prepare("SELECT MAX(temp) AS max_waarde, timedate FROM weerstation WHERE DATE(timedate) = CURDATE()");
    $sql->execute();

    return $sql->fetch();
  }
    $maxReading = maxReading();
    $last_reading = getLastReadings();
    $minReading = minReading();
?>

  <!doctype HTML>
<html>
	<head> 
		<title> weerstation </title> 
		<meta charset="utf-8">
	</head>
	<body>
    <div>
			<?php
			if ($last_reading) {
          echo "De laatst gemeten tempratuur is " . $last_reading['temp'] . " graden";
          echo " op datum: " . $last_reading['timedate'];
      }
      ?>
    </div>
    <div>
    <?php
      if ($minReading) {
        echo "De laagste waarde van vandaag is: " . $minReading['min_waarde'] . " graden";
        echo " op datum: " . $minReading['timedate'];
    }
    ?> 
    </div>
    <div>
    <?php 
      if ($maxReading) {
      echo "De hoogste waarde van vandaag is: " . $maxReading['max_waarde'] . " graden";
      echo " op datum: " . $minReading['timedate'];
      }
      $dbconnect = null;   
			?>
    </div>

	</body> 
</html> 