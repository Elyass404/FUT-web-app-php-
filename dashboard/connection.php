<?php
use Dotenv\Dotenv;

require '../vendor/autoload.php'; // Composer autoloader

// Load .env file from the root of your project
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


/*Connect to the database using the enviroment variables you declared in the .eenv file, with
the help of $_ENV super global variable*/
$con = mysqli_connect($_ENV['host'],$_ENV['user'],$_ENV['pw'],$_ENV['ndb'],);



// $host = "localhost";
// $user = "root";
// $pw = "";
// $ndb = "fut_champions";
// $con = mysqli_connect($host,$user,$pw,$ndb);

if($con){
    echo"Connected successfully";
}



?>