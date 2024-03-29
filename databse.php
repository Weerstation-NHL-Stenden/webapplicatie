<?php
require_once("secrets.php");

  
  
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
    $sql = $dbconnect->prepare("SELECT temp, rain, airPress, humidity, windspeed, winddirection, co2, timedate, uv, light FROM weerstation ORDER BY timedate DESC LIMIT 1");
    $sql->execute();
    $result = $sql->fetchAll();
    $dbconnect = null;
    return $result;
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

    return $sql->fetch()[0];
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

    return $sql->fetch()[0];
  }
    $maxReading = maxReading();
    $last_reading = getLastReadings();
    $minReading = minReading();
?>
<?php
$result = getLastReadings()[0];
?>
