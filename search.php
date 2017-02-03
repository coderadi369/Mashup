<?php

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

    // numerically indexed array of places
    $places = [];

    $sql = "SELECT * FROM mashup "."WHERE  place_name like '%".$_GET["geo"]."%'";

     // echo $sql;

    $result = $conn->query($sql);
      
       if($result->num_rows>0)
      {
           while($row = $result->fetch_assoc())
           {
           	 array_push($places, $row["place_name"]); 
           }
     }
    
       
      else
      {
      	echo "Data is absent";
      }  

    // TODO: search database for places matching $_GET["geo"], store in $places

    // output places as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($places, JSON_PRETTY_PRINT));

?>