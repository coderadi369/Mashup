<?php

    //require(__DIR__ . "/../includes/config.php");


   $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name="mashup";

// Create connection
$conn = new mysqli($servername, $username, $password,$db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


//echo json_encode("place_retrival can be done");

//echo $_GET["place"];


$places=[];

$sql = "SELECT * FROM mashup WHERE place_name LIKE '".$_GET["place"]."' LIMIT 1";


        //echo $sql;

       //$sql = "SELECT * FROM mashup "."WHERE  place_name like '%".$_GET["geo"]."%'";


    $result = $conn->query($sql);
      
       if($result->num_rows>0)
      {
           while($row = $result->fetch_assoc())
           {
             array_push($places, $row); 
           }
     }
     else
     {
        echo "failed";
     }



print (json_encode($places));



?>