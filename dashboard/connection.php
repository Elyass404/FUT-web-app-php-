<?php
use Dotenv\Dotenv;

require '../vendor/autoload.php'; // Composer autoloader

// Load .env file from the root of your project
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


$host = getenv('host');
$ndb = getenv('ndb');
$user = getenv('user');
$pw = getenv('pw');
$con = mysqli_connect($host,$user,$pw,$ndb);



// $host = "localhost";
// $user = "root";
// $pw = "";
// $ndb = "fut_champions";
// $con = mysqli_connect($host,$user,$pw,$ndb);

if($con){
    echo"Connected successfully";
}



?>