<?php
//connect to DB
$username="root";
$password="";
$host="127.0.0.1";
$database="blog";
$connected=new PDO("mysql: host = $host;dbname=$database;charset=utf8", $username, $password);


// if (mysqli_connect_error()) 
//     die("cannot conect : " . mysqli_connect_error());
// else
//     echo "db connected </br>";




 

?>