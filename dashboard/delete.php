<?php
include ('connection.php');



if(isset($_GET['id'])){
    $id = $_GET['id'];

}

$check_position_query =" SELECT position FROM players WHERE player_id= $id";
$check_position_row= mysqli_query($con, $check_position_query);
$check_position_result = mysqli_fetch_assoc($check_position_row);

if($check_position_result['position'] !== "gk"){

    $delete_stats= "DELETE  FROM goalkeeper_stats
    WHERE player_id = $id
";
    $delete_row= mysqli_query($con, $delete_stats);

}else{
    $delete_stats = "DELETE FROM player_stats 
    WHERE   player_id = $id
    ";
    $delete_row= mysqli_query($con, $delete_stats);
}


$delete_player= "DELETE  FROM players 
WHERE players.player_id = $id
";
$delete_row= mysqli_query($con, $delete_player);

header("location:dashboard.php");

?>