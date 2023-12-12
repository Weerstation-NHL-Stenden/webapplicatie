<?php
$servername = "mysql";
$dbname = "weerstation";
$username = "root";
$password = "qwerty";

try{
    $dbconnect= new PDO ("mysql:host=$servername;dbname=$dbname;charset=utf8","$username","$password");
    $query = "SELECT timedate, temp FROM weerstation ORDER BY timedate ASC LIMIT 10";
    $stmt = $dbconnect->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
}
catch(Exception $ex){
    echo $ex;
}

$dbconnect = null;
?>
