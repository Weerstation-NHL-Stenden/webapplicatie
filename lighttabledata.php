<?php
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET["start"]) && isset($_GET["end"])){
        getByDate($_GET["start"], $_GET["end"]);
    }
    else{
        getAll();
    }
}
function getAll(){
    try{
        require("secrets.php");
        $dbconnect= new PDO ("mysql:host=$servername;dbname=$dbname;charset=utf8","$username","$password");
        $query = "SELECT timedate, light FROM weerstation ORDER BY timedate DESC LIMIT 200";
        $stmt = $dbconnect->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($data);
    }
    catch(Exception $ex){
        echo $ex;
    }

    $dbconnect = null;
}

function getByDate($startdate, $enddate){
    try{
        require("secrets.php");
        $dbconnect= new PDO ("mysql:host=$servername;dbname=$dbname;charset=utf8","$username","$password");
        $query = "SELECT timedate, light FROM weerstation WHERE timedate >= :start AND timedate <= :end ORDER BY timedate ASC";
        $stmt = $dbconnect->prepare($query);
        $stmt->bindParam(':start', $startdate, PDO::PARAM_STR);
        $stmt->bindParam(':end', $enddate, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($data);
    }
    catch(Exception $ex){
        echo $ex;
    }

    $dbconnect = null;
}
?>
