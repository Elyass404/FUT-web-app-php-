<?php
$host = "localhost";
$user = "root";
$pw = "";
$ndb = "fut_champions";
$con = mysqli_connect($host,$user,$pw,$ndb);

if($con){
    echo"Connected successfully";
}else{
    echo"Not Connected";
}



?>