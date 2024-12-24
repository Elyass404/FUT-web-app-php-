<?php

if(isset($_GET['id'])){
    $id = $_GET['id'];

}


$deletequery= "DELETE  FROM players 
JOIN player_stats ON players.player_id = player_stats.player_id
WHERE playes.player_id = $id
";



?>