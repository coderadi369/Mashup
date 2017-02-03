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


    // ensure proper usage
    if (!isset($_GET["sw"], $_GET["ne"]))
    {
        echo "1";
        http_response_code(400);
        exit;
    }

   // ensure each parameter is in lat,lng format
    if (!preg_match("/^-?\d+(?:\.\d+)?,-?\d+(?:\.\d+)?$/", $_GET["sw"]) ||
        !preg_match("/^-?\d+(?:\.\d+)?,-?\d+(?:\.\d+)?$/", $_GET["ne"]))
    {
        echo "2";
        http_response_code(400);
        exit;
    }

    

    // explode southwest corner into two variables
    list($sw_lat, $sw_lng) = explode(",", $_GET["sw"]);

    // explode northeast corner into two variables
    list($ne_lat, $ne_lng) = explode(",", $_GET["ne"]);

/*

    echo $sw_lat;

    echo "<br/>";

    echo $sw_lng;

    echo "<br/>";

    echo $ne_lat;

    echo "<br/>";

    echo $ne_lng;

    echo "<br/>";

  */  
 
 $places = [];




    // find 10 cities within view, pseudorandomly chosen if more within view


    if ($sw_lng <= $ne_lng)
    {
        // doesn't cross the antimeridian
       

        $sql = "SELECT * FROM mashup WHERE (" .$sw_lat .' <= latitude OR latitude <='.$ne_lat.")  OR (".$sw_lat." <= longitude OR longitude <= ".$ne_lng.") GROUP BY country_code, place_name, admin_code1 ORDER BY RAND() LIMIT 10";


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


    }
    else
    {
        // crosses the antimeridian


     $sql = "SELECT * FROM mashup WHERE(" .$sw_lat ."<= latitude OR latitude <=".$ne_lat.")  OR (".$sw_lat." <= longitude OR longitude <= ".$ne_lng.") GROUP BY country_code, place_name, admin_code1 ORDER BY RAND() LIMIT 10";


       /* $rows = CS50::query("SELECT * FROM places WHERE ? <= latitude AND latitude <= ? AND (? <= longitude OR longitude <= ?) GROUP_BY country_code, place_name, admin_code1 ORDER BY RAND() LIMIT 10", $sw_lat, $ne_lat, $sw_lng, $ne_lng);
       */

       //echo $sql;


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


    }

    // output places as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($places, JSON_PRETTY_PRINT));

?>