<?php

$ServerName = "localhost";
$Username = "39506";
$Password = "Bte0k";
$DatabaseName = "db_39506";

$Connection = new mysqli($ServerName, $Username, $Password, $DatabaseName);
if($Connection->Connect_Error) {
    die("Connection Failed" . $Connection->Connect_Error);
}

// Test query
$Query = "SELECT * FROM `SchadeServer` where ToiletID = '0F'";
$Result = $Connection->query($Query);

if ($Result->num_rows > 0) {
    // output data of each row
    while($Row = $Result->fetch_assoc()) {
      echo '<img src="data:image/'.$Row["BestandType"].';base64,'.base64_encode($Row['Bewijs']).'"/>';
    }
  } 
$Connection->close();
