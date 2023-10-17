<?php
  $servername = "mysql";
  $dbname = "weerstation";
  $username = "root";
  $password = "qwerty";

  
  
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
    $sql = $dbconnect->prepare("SELECT uitkomst, tijd FROM weerstation ORDER BY tijd DESC LIMIT 1");
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

    $sql = $dbconnect->prepare("SELECT MIN(uitkomst) AS min_waarde, tijd FROM weerstation WHERE DATE(tijd) = CURDATE()");
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

    $sql = $dbconnect->prepare("SELECT MAX(uitkomst) AS max_waarde, tijd FROM weerstation WHERE DATE(tijd) = CURDATE()");
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
          echo "De laatst gemeten tempratuur is " . $last_reading['uitkomst'] . " graden";
          echo " op datum: " . $last_reading['tijd'];
      }
      ?>
    </div>
    <div>
    <?php
      if ($minReading) {
        echo "De laagste waarde van vandaag is: " . $minReading['min_waarde'] . " graden";
        echo " op datum: " . $minReading['tijd'];
    }
    ?> 
    </div>
    <div>
    <?php 
      if ($maxReading) {
      echo "De hoogste waarde van vandaag is: " . $maxReading['max_waarde'] . " graden";
      echo " op datum: " . $minReading['tijd'];
      }
      $dbconnect = null;   
			?>
    </div>

	</body> 
</html> 