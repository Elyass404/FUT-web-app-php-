<?php
include ('connection.php');

// $diving = mysqli_real_escape_string($con, $_POST['diving')]; //to prevent sql injections

$bring_nationalities = "SELECT * FROM nationalities";
$bring_clubs = "SELECT * FROM clubs";

$result_nationalities = mysqli_query($con,$bring_nationalities);
$result_clubs = mysqli_query($con,$bring_clubs);

if(isset($_GET['id'])){
    echo($_GET['id']."----");
}

$id = intval($_GET['id']);
echo( $id + 100);

$check_position_query =" SELECT position FROM players WHERE player_id= $id";
$check_position_row= mysqli_query($con, $check_position_query);
$check_position_result = mysqli_fetch_assoc($check_position_row);


if($check_position_result['position'] !== "gk"){  
    echo("herrrrrrrrrrrrre");
    $bring_players_data = "SELECT *
    FROM players 
    JOIN player_stats ON player_stats.player_id = players.player_id 
    WHERE players.player_id = $id";
    $result_data = mysqli_query($con,$bring_players_data);
    $player = mysqli_fetch_assoc($result_data);
}else{
    echo("ooooooooooo");
    $bring_players_data = "SELECT *
    FROM players 
    JOIN goalkeeper_stats ON goalkeeper_stats.player_id = players.player_id
    WHERE players.player_id = $id";
    $result_data = mysqli_query($con,$bring_players_data);
    $player = mysqli_fetch_assoc($result_data);
}



echo($player['name']);

if(isset($_POST['update-player-btn'])){
  

    $player_name = $_POST['full_name'];
  
    $photo = $_FILES['photo']['name'];
      $temp_file = $_FILES['photo']['tmp_name'];
      $folder = "../players_images/$photo";
      move_uploaded_file($temp_file, $folder);
    
      $club = $_POST['club'];
      $position = $_POST['player-position']; 
      $nationality = $_POST['nationality'];
      $rating = $_POST['rating'];
  
      //players stats
      $pace = $_POST['pace'];
      $shooting = $_POST['shooting'];
      $passing = $_POST['passing'];
      $dribling = $_POST['dribbling'];
      $defending = $_POST['defending'];
      $physical = $_POST['physical'];
  
      //goalkeeper stats 
      $diving = $_POST['diving'];
      $handling = $_POST['handling'];
      $kicking = $_POST['kicking'];
      $reflexes = $_POST['reflexes'];
      $speed = $_POST['speed'];
      $positioning = $_POST['positioning'];

      $update_player = "UPDATE players 
      SET name = '$player_name',
      photo = '$photo',
      position= '$position',
      nationality_id= '$nationality',
      club_id= '$club',
      rating= '$rating'
      WHERE player_id = $id
      ";
  // the query to update the player in the palyers table 
      $result_player= mysqli_query($con,$update_player);
  
    if($result_player){
  
    if ($position == "gk"){
      $gk_stats_table = "UPDATE goalkeeper_stats SET
      diving =  '$diving',
      handling =  '$handling',
      kicking= '$kicking',
      reflexes= '$reflexes',
      speed= '$speed',
      positioning= '$positioning'
      WHERE player_id = $id
      ";

      mysqli_query($con,$gk_stats_table);
      header("location:dashboard.php");

    }else{

      $player_stats_table ="UPDATE player_stats SET
      pace = '$pace',
      shooting = '$shooting',
      passing= '$passing',
      dribling= '$dribling',
      defending= '$defending',
      physical= '$physical'
      WHERE player_id = $id
      ";
          mysqli_query($con,$player_stats_table);
  
        }
      }
      header("location:dashboard.php");
  
  }
  

?>



<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">
<link rel="stylesheet" href="../styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<div id="addModal" class=" absolute right-0 top-0 h-full bg-gray-800 bg-opacity-60 grid grid-cols-12 gap-8 py-8 mx-auto w-full ">
<section class="bg-gray-600 form-height col-span-12 lg: col-start-4 col-end-10 px-6 py-8 overflow-y-scroll hide-scrollbar text-white rounded-lg">
    <form action="edit.php?id=<?= $id ?>" class="flex flex-col gap-4" method="POST" enctype="multipart/form-data">
        <input id="id-input" type="hidden">

        <div id="name-input" class="flex flex-col gap-1">
            <label for="player-name" class="text-base font-medium">Full Name</label>
            <input name="full_name" type="text" id="player-name-input" value="<?= $player['name'] ;?>" class="input-colors input-colors rounded py-2 px-3 ">
            <span id="name-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Name must be at least 2 letters and no digits.</span>
        </div>
        
        <div id="photo-input" class="flex flex-col gap-1">
            <label for="player-photo" class="text-base font-medium">Photo</label>
            <input name="photo" type="file" id="player-photo" value="<?= $player['photo'] ;?>" class=" input-colors rounded py-2 px-3">
            <span id="photo-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Photo must be a valid URL with a CDN image.</span>
        </div>

        <div id="position-input" class="flex flex-col gap-1 w-xl">
            <label for="player-position" class="text-base font-medium" >Position</label>
            <select name="player-position" id="player-position" class="input-colors rounded py-2  px-3">
                <option value="" >Select Position</option>
                <option value="gk" <?=$player["position"]== "gk" ? 'selected' :''; ?>>Goal Keeper</option>
                <option value="rb" <?=$player["position"]== "rb" ? 'selected' :''; ?>>Right Back</option>
                <option value="rcb" <?=$player["position"]== "rcb" ? 'selected' :''; ?>>Right Center Back</option>
                <option value="lcb" <?=$player["position"]== "lcb" ? 'selected' :''; ?>>Left Center Back</option>
                <option value="lb" <?=$player["position"]== "lb" ? 'selected' :''; ?>>Left Back</option>
                <option value="rm" <?=$player["position"]== "rm" ? 'selected' :''; ?>>Right Midfield</option>
                <option value="cm" <?=$player["position"]== "cm" ? 'selected' :''; ?>>Center Midfield</option>
                <option value="lm" <?=$player["position"]== "lm" ? 'selected' :''; ?>>Left Midfield</option>
                <option value="rw" <?=$player["position"]== "rw" ? 'selected' :''; ?>>Right Wing</option>
                <option value="st" <?=$player["position"]== "st" ? 'selected' :''; ?>>Striker</option>
                <option value="lw" <?=$player["position"]== "lw" ? 'selected' :''; ?>>Left Wing</option>
            </select>
            <span id="position-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Please select a position.</span>
        </div>
        
        <div id="nationality-input" class="flex flex-col gap-1">
            <label for="player-nationality" class="text-base font-medium">Nationality</label>
            <select name="nationality" id="player-nationality" class="input-colors rounded py-2 px-3">
                <option value="">Select Nationality</option>
                <?php
                while($nationality = mysqli_fetch_assoc($result_nationalities)):
                ?>
                <option value="<?=$nationality["nationality_id"] ?>" <?=$nationality["nationality_id"]== $player["nationality_id"] ? 'selected' :''; ?>><?=$nationality["nationality_name"] ?></option>
                <?php endwhile;?>
            </select>
            <span id="nationality-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Please select a nationality.</span>
        </div>
        
        <div id="current-club-input" class="flex flex-col gap-1">
            <label for="current-club" class="text-base font-medium">Current Club</label>
            <select name="club" id="player-club" class="input-colors rounded py-2 px-3">
              <option value="">Select Club</option>
              <?php
              while($club = mysqli_fetch_assoc($result_clubs)):
              ?>
                <option value="<?= $club["club_id"]?>" <?=$club["club_id"]== $player["club_id"] ? 'selected' :''; ?>><?= $club["club_name"]?></option>
               <?php endwhile; ?>

            </select>
            <span id="club-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Please select a club.</span>
        </div>
        
        
        <div id="rating-input" class="flex flex-col gap-1">
            <label for="rating" class="text-base font-medium">Rating</label>
            <input name="rating" type="number" id="rating" value="<?= $player["rating"]?>"  class="input-colors rounded py-2 px-3">
            <span id="rating-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Rating must be between 10 and 99.</span>
        </div>


        <div id="players-only-inputs" class="hidden flex flex-col gap-4">

            <div class=" max-w-full flex flex-row gap-2" >

        <div id="pace-input" class="w-1/2 flex flex-col gap-1">
            <label for="pace" class="text-base font-medium">Pace</label>
            <input name="pace" type="number" id="pace" value="<?= $player['pace'] ?>" class="input-colors rounded py-2 px-3">
            <span id="pace-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
        
        <div id="shooting-input" class="w-1/2 flex flex-col gap-1">
            <label for="shooting" class="text-base font-medium">Shooting</label>
            <input name="shooting" type="number" id="shooting" value="<?= $player['shooting'] ?>" class="input-colors rounded py-2 px-3">
            <span id="shooting-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
    </div>
    <div class=" max-w-full flex flex-row gap-2" >

        <div id="passing-input" class="w-1/2 flex flex-col gap-1">
            <label for="passing" class="text-base font-medium">Passing</label>
            <input name="passing" type="number" id="passing" value="<?= $player['passing'] ?>" class="input-colors rounded py-2 px-3">
            <span id="passing-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
        
        <div id="dribbling-input" class="w-1/2 flex flex-col gap-1">
            <label for="dribbling" class="text-base font-medium">Dribbling</label>
            <input name="dribbling" type="number" id="dribbling" value="<?= $player['dribling'] ?>" class="input-colors rounded py-2 px-3">
            <span id="dribbling-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
    </div>
    <div class=" max-w-full flex flex-row gap-2" >
        <div id="defending-input" class="w-1/2 flex flex-col gap-1">
            <label for="defending" class="text-base font-medium">Defending</label>
            <input name="defending" type="number" id="defending" value="<?= $player['defending'] ?>" class="input-colors rounded py-2 px-3">
            <span id="defending-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
        
        <div id="physical-input" class="w-1/2 flex flex-col gap-1">
            <label for="physical" class="text-base font-medium">Physical</label>
            <input name="physical" type="number" id="physical" value="<?= $player['physical'] ?>" class="input-colors rounded py-2 px-3">
            <span id="physical-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
    </div>
    </div>

    <div id="goalkeeper-only-inputs" class="hidden flex flex-col gap-4">
        <div class=" max-w-full flex flex-row gap-2" >

        <div id="diving-input" class="w-1/2 flex flex-col gap-1">
            <label for="diving" class="text-base font-medium">Diving</label>
            <input name="diving" type="number" value="<?= $player['diving'] ?>" id="diving" class="input-colors rounded py-2 px-3">
            <span id="diving-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
        
        <div id="handling-input" class="w-1/2 flex flex-col gap-1">
            <label for="handling" class="text-base font-medium">Handling</label>
            <input name="handling" type="number" id="handling" value="<?= $player['handling'] ?>" class="input-colors rounded py-2 px-3">
            <span id="handling-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>

        </div>

        <div class=" max-w-full flex flex-row gap-2" >
            
        <div id="kicking-input" class="w-1/2 flex flex-col gap-1">
            <label for="kicking" class="text-base font-medium">Kicking</label>
            <input name="kicking" type="number" id="kicking" value="<?= $player['kicking'] ?>" class="input-colors rounded py-2 px-3">
            <span id="kicking-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
        
        <div id="reflexes-input" class="w-1/2 flex flex-col gap-1">
            <label for="reflexes" class="text-base font-medium">Reflexes</label>
            <input name="reflexes" type="number" id="reflexes" value="<?= $player['reflexes'] ?>" class="input-colors rounded py-2 px-3">
            <span id="reflexes-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>

        </div>

        <div class=" max-w-full flex flex-row gap-2" >
        <div id="speed-input" class=" w-1/2 flex flex-col gap-1">
            <label for="speed" class="text-base font-medium">Speed</label>
            <input name="speed" type="number" id="speed" value="<?= $player['speed'] ?>" class="input-colors rounded py-2 px-3">
            <span id="speed-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
        
        <div id="positioning-input" class="w-1/2 flex flex-col gap-1">
            <label for="positioning" class="text-base font-medium">Positioning</label>
            <input name="positioning" type="number" id="positioning" value="<?= $player['positioning'] ?>" class="input-colors rounded py-2 px-3">
            <span id="positioning-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>  

        </div>
        

        

    </div>
<button type="submit" name ="add_player" id="add-player-btn" class=" bg-violet-700 text-white w-full px-8 py-4 rounded hidden">add player</button>
<button type="submit" name="update-player-btn" id="update-player-btn" class=" bg-orange-500 text-white w-full px-8 py-4 rounded ">Save Changes</button>
<button type="button" id="cancel-update-player-btn" class=" bg-red-500 text-white w-full px-8 py-4 rounded "><a href="dashboard.php">cancel</a></button>
        
    </form>
</section>
</div>

<script>
    let goalKeeperInputs = document.getElementById("goalkeeper-only-inputs");
    let playersInputs = document.getElementById("players-only-inputs");
    let position = document.getElementById("player-position");
    let cancelFormBtn = document.getElementById("cancel-update-player-btn");


function showingInputs(){
    if(position.value == "gk"){
      goalKeeperInputs.classList.remove("hidden");
      playersInputs.classList.add("hidden");

  }else if(position.value == "") {
      goalKeeperInputs.classList.add("hidden");
      playersInputs.classList.add("hidden");

  }else {
      goalKeeperInputs.classList.add("hidden");
      playersInputs.classList.remove("hidden");
  }  
}

cancelFormBtn.addEventListener("click", function(){
modal.classList.add("hidden");
});

showingInputs();

position.addEventListener('change',showingInputs);

</script>
</body>
</html>