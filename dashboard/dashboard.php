<?php
include("connection.php");

$count_players_query ="SELECT COUNT(*) as total_players FROM players";
$count_players_result= mysqli_query($con,$count_players_query);
$count_players= mysqli_fetch_assoc($count_players_result);

$count_countries_query ="SELECT COUNT(*) as total_countries FROM nationalities";
$count_countries_result= mysqli_query($con,$count_countries_query);
$count_countries= mysqli_fetch_assoc($count_countries_result);

$count_clubs_query ="SELECT COUNT(*) as total_clubs FROM clubs";
$count_clubs_result= mysqli_query($con,$count_clubs_query);
$count_clubs= mysqli_fetch_assoc($count_clubs_result);

$average_rating_query= "SELECT ROUND( AVG(rating) , 2) as average_rating FROM players";
$average_rating_result = mysqli_query($con,$average_rating_query);
$average_rating= mysqli_fetch_assoc($average_rating_result);

$bring_nationalities = "SELECT * FROM nationalities";
$bring_clubs = "SELECT * FROM clubs";


$result_nationalities = mysqli_query($con,$bring_nationalities);
$result_clubs = mysqli_query($con,$bring_clubs);

if(isset($_POST['add_player'])){
  

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

    $add_player = "INSERT INTO players (name,photo,position,nationality_id,club_id,rating)
    VALUES ('$player_name','$photo','$position','$nationality','$club','$rating')
    ";
// the query to add the player into the palyers table 
    $result_player= mysqli_query($con,$add_player);


    if($result_player){
      $get_id = mysqli_insert_id($con);

      if ($position == "gk"){
        $gk_stats_table = " INSERT INTO goalkeeper_stats (player_id,diving,handling,kicking, reflexes, speed, positioning)
        VALUES ('$get_id','$diving','$handling','$kicking','$reflexes','$speed','$positioning')
        ";

      mysqli_query($con,$gk_stats_table);
      }else{
        $player_stats_table =" INSERT INTO player_stats (player_id,pace,shooting,passing, dribling, defending, physical)
        VALUES ('$get_id','$pace','$shooting','$passing','$dribling','$defending','$physical')
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

<div class="flex h-screen bg-gray-100">

  <!-- sidebar -->
  <div class="hidden md:flex flex-col w-64 bg-gray-800">
    <div class="flex items-center justify-center h-16 bg-gray-900">
      <span class="text-white font-bold uppercase">FUT champions</span>
    </div>
    <div class="flex flex-col flex-1 overflow-y-auto">
      <nav class="flex-1 px-2 py-4 bg-gray-800">
        <a href="#" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700">
          <i class="pr-4 fa-solid fa-people-group"></i>
          Players List
        </a>
        <a href="#" class="flex items-center px-4 py-2 mt-2 text-gray-100 hover:bg-gray-700">
          <i class="pr-4 fa-solid fa-earth-africa"></i>
          Nationalities
        </a>
        <a href="#" class="flex items-center px-4 py-2 mt-2 text-gray-100 hover:bg-gray-700">
          <i class="pr-4 fa-regular fa-futbol"></i>
          Clubs
        </a>
        <a href="#" class="flex items-center px-4 py-2 mt-2 text-gray-100 hover:bg-gray-700">
          <i class="pr-4 fa-solid fa-court-sport"></i>
          Players in Field
        </a>
      </nav>
    </div>
  </div>

  <!-- Main content -->
  <div class="flex flex-col flex-1 overflow-y-auto">
    <div class="flex items-center justify-between h-16 bg-yellow-500 border-b border-gray-200">
      <div class="flex items-center px-4">
        <button class="text-gray-500 focus:outline-none focus:text-gray-700">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        <input class="mx-4 w-full border rounded-md px-4 py-2" type="text" placeholder="Search">
      </div>
    </div>

    <!-- Add Player Button Above Cards -->
    <div class="p-4 bg-gray-100">
      <div class="flex justify-end mb-4">
        <button id="addPlayerBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-md shadow-md transition duration-200">
          <a href="#">
          <i class="fa-solid fa-user-plus mr-2"></i> Add Player
        </a>
        </button>
      </div>

      <!-- Cards Section -->
      
      <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">
        <!-- Card Item 1 Start -->
        <div class="rounded-lg border border-stroke bg-white px-6 py-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
          <div class="flex items-center justify-start mb-4">
            <i class="fa-solid fa-people-group text-4xl text-gray-800"></i>
          </div>
          <div class="mt-4 flex items-end justify-between px-4">
            <div>
              <h4 class="text-xl font-semibold text-gray-800"><?= $count_players['total_players'] ?></h4>
              <span class="text-sm text-gray-500">Total Players</span>
            </div>
          </div>
        </div>
        <!-- Card Item 1 End -->

        <!-- Card Item 2 Start -->
        <div class="rounded-lg border border-stroke bg-white px-6 py-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
          <div class="flex items-center justify-start mb-4">
            <i class="fa-solid fa-chart-simple text-4xl text-gray-800"></i>
          </div>
          <div class="mt-4 flex items-end justify-between px-4">
            <div>
              <h4 class="text-xl font-semibold text-gray-800"><?= $average_rating['average_rating'] ?></h4>
              <span class="text-sm text-gray-500">Rating Average</span>
            </div>
          </div>
        </div>
        <!-- Card Item 2 End -->

        <!-- Card Item 3 Start -->
        <div class="rounded-lg border border-stroke bg-white px-6 py-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
          <div class="flex items-center justify-start mb-4">
            <i class="fa-solid fa-earth-africa text-4xl text-gray-800"></i>
          </div>
          <div class="mt-4 flex items-end justify-between px-4">
            <div>
              <h4 class="text-xl font-semibold text-gray-800"><?= $count_countries['total_countries'] ?></h4>
              <span class="text-sm text-gray-500">Total Countries</span>
            </div>
          </div>
        </div>
        <!-- Card Item 3 End -->

        <!-- Card Item 4 Start -->
        <div class="rounded-lg border border-stroke bg-white px-6 py-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
          <div class="flex items-center justify-start mb-4">
            <i class="fa-solid fa-futbol text-4xl text-gray-800 "></i>
          </div>
          <div class="mt-4 flex items-end justify-between px-4">
            <div>
              <h4 class="text-xl font-semibold text-gray-800"><?= $count_clubs['total_clubs'] ?></h4>
              <span class="text-sm text-gray-500">Total Clubs</span>
            </div>
          </div>
        </div>
        <!-- Card Item 4 End -->
      </div>
    </div>

    <!-- Player List Section -->
    <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
      <div class="max-w-full overflow-x-auto">
        <table class="w-full table-auto">
          <thead>
            <tr class="bg-gray-800 text-left text-white">
              <th class="min-w-[150px] px-4 py-4 font-medium xl:pl-11">ID</th>
              <th class="min-w-[150px] px-4 py-4 font-medium">Name</th>
              <th class="min-w-[150px] px-4 py-4 font-medium">Post</th>
              <th class="min-w-[150px] px-4 py-4 font-medium">Nationality</th>
              <th class="min-w-[150px] px-4 py-4 font-medium">Current Club</th>
              <th class="min-w-[150px] px-4 py-4 font-medium">Rating</th>
              <th class="min-w-[150px] px-4 py-4 font-medium">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-gray-100 text-gray-900">

          <?php
          
          $query = "SELECT *,
          nationality_name,
          nationality_logo,
          club_logo
          FROM players
          join nationalities on players.nationality_id = nationalities.nationality_id
          join clubs on players.club_id = clubs.club_id
          ";
          $result = mysqli_query($con,$query);
          while($player = mysqli_fetch_assoc($result)):
  
          ?>
          
          
            <tr>
              <td class="border-b border-gray-300 px-4 py-5 pl-9 xl:pl-11"><p><?=$player["player_id"] ?></p></td>
              <td class="border-b border-gray-300 px-4 py-5"><?=$player["name"] ?></td>
              <td class="border-b border-gray-300 px-4 py-5"><?=$player["position"]?></td>
              <td class="border-b border-gray-300 px-4 py-5"><img src="<?=$player["nationality_logo"] ?>" alt="" title="<?=$player["nationality_name"] ?>"></td>
              <td class="border-b border-gray-300 px-4 py-5"><img src="<?=$player["club_logo"]?>" alt="" width="40" height="40"></td>
              <td class="border-b border-gray-300 px-4 py-5"><?=$player["rating"] ?></td>
              <td class="border-b border-gray-300 px-4 py-5">
                <div class="flex items-center space-x-3.5">
                  <button class="hover:text-blue-500"><a href="show.php?id=<?=$player["player_id"] ?>"><i class="fa-solid fa-eye"></i></button></a>
                  <button class="hover:text-blue-500"><a href="edit.php"><i class="fa-solid fa-pen"></i></button></a>
                  <button class="hover:text-blue-500"><a href="delete.php"><i class="fa-solid fa-trash"></i></button></a>
                </div>
              </td>
            </tr>
            <?php endwhile; ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<div id="addModal" class=" absolute right-0 top-0 h-full bg-gray-800 bg-opacity-60 grid grid-cols-12 gap-8 py-8 mx-auto w-full hidden ">
<section class="bg-gray-600 form-height col-span-12 lg: col-start-4 col-end-10 px-6 py-8 overflow-y-scroll hide-scrollbar text-white rounded-lg">
    <form action="dashboard.php" class="flex flex-col gap-4" method="POST" enctype="multipart/form-data">
        <input id="id-input" type="hidden">

        <div id="name-input" class="flex flex-col gap-1">
            <label for="player-name" class="text-base font-medium">Full Name</label>
            <input name="full_name" type="text" id="player-name-input" class="input-colors input-colors rounded py-2 px-3 ">
            <span id="name-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Name must be at least 2 letters and no digits.</span>
        </div>
        
        <div id="photo-input" class="flex flex-col gap-1">
            <label for="player-photo" class="text-base font-medium">Photo</label>
            <input name="photo" type="file" id="player-photo" class=" input-colors rounded py-2 px-3">
            <span id="photo-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Photo must be a valid URL with a CDN image.</span>
        </div>

        <div id="position-input" class="flex flex-col gap-1 w-xl">
            <label for="player-position" class="text-base font-medium" >Position</label>
            <select name="player-position" id="player-position" class="input-colors rounded py-2  px-3">
                <option value="" selected>Select Position</option>
                <option value="gk">Goal Keeper</option>
                <option value="rb">Right Back</option>
                <option value="rcb">Right Center Back</option>
                <option value="lcb">Left Center Back</option>
                <option value="lb">Left Back</option>
                <option value="rm">Right Midfield</option>
                <option value="cm">Center Midfield</option>
                <option value="lm">Left Midfield</option>
                <option value="rw">Right Wing</option>
                <option value="st">Striker</option>
                <option value="lw">Left Wing</option>
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
                <option value="<?=$nationality["nationality_id"] ?>"><?=$nationality["nationality_name"] ?></option>
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
                <option value="<?= $club["club_id"]?>"><?= $club["club_name"]?></option>
               <?php endwhile; ?>

            </select>
            <span id="club-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Please select a club.</span>
        </div>
        
        
        <div id="rating-input" class="flex flex-col gap-1">
            <label for="rating" class="text-base font-medium">Rating</label>
            <input name="rating" type="number" id="rating" class="input-colors rounded py-2 px-3">
            <span id="rating-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Rating must be between 10 and 99.</span>
        </div>


        <div id="players-only-inputs" class="hidden flex flex-col gap-4">

            <div class=" max-w-full flex flex-row gap-2" >

        <div id="pace-input" class="w-1/2 flex flex-col gap-1">
            <label for="pace" class="text-base font-medium">Pace</label>
            <input name="pace" type="number" id="pace" class="input-colors rounded py-2 px-3">
            <span id="pace-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
        
        <div id="shooting-input" class="w-1/2 flex flex-col gap-1">
            <label for="shooting" class="text-base font-medium">Shooting</label>
            <input name="shooting" type="number" id="shooting" class="input-colors rounded py-2 px-3">
            <span id="shooting-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
    </div>
    <div class=" max-w-full flex flex-row gap-2" >

        <div id="passing-input" class="w-1/2 flex flex-col gap-1">
            <label for="passing" class="text-base font-medium">Passing</label>
            <input name="passing" type="number" id="passing" class="input-colors rounded py-2 px-3">
            <span id="passing-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
        
        <div id="dribbling-input" class="w-1/2 flex flex-col gap-1">
            <label for="dribbling" class="text-base font-medium">Dribbling</label>
            <input name="dribbling" type="number" id="dribbling" class="input-colors rounded py-2 px-3">
            <span id="dribbling-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
    </div>
    <div class=" max-w-full flex flex-row gap-2" >
        <div id="defending-input" class="w-1/2 flex flex-col gap-1">
            <label for="defending" class="text-base font-medium">Defending</label>
            <input name="defending" type="number" id="defending" class="input-colors rounded py-2 px-3">
            <span id="defending-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
        
        <div id="physical-input" class="w-1/2 flex flex-col gap-1">
            <label for="physical" class="text-base font-medium">Physical</label>
            <input name="physical" type="number" id="physical" class="input-colors rounded py-2 px-3">
            <span id="physical-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
    </div>
    </div>

    <div id="goalkeeper-only-inputs" class="hidden flex flex-col gap-4">
        <div class=" max-w-full flex flex-row gap-2" >

        <div id="diving-input" class="w-1/2 flex flex-col gap-1">
            <label for="diving" class="text-base font-medium">Diving</label>
            <input name="diving" type="number" id="diving" class="input-colors rounded py-2 px-3">
            <span id="diving-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
        
        <div id="handling-input" class="w-1/2 flex flex-col gap-1">
            <label for="handling" class="text-base font-medium">Handling</label>
            <input name="handling" type="number" id="handling" class="input-colors rounded py-2 px-3">
            <span id="handling-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>

        </div>

        <div class=" max-w-full flex flex-row gap-2" >
            
        <div id="kicking-input" class="w-1/2 flex flex-col gap-1">
            <label for="kicking" class="text-base font-medium">Kicking</label>
            <input name="kicking" type="number" id="kicking" class="input-colors rounded py-2 px-3">
            <span id="kicking-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
        
        <div id="reflexes-input" class="w-1/2 flex flex-col gap-1">
            <label for="reflexes" class="text-base font-medium">Reflexes</label>
            <input name="reflexes" type="number" id="reflexes" class="input-colors rounded py-2 px-3">
            <span id="reflexes-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>

        </div>

        <div class=" max-w-full flex flex-row gap-2" >
        <div id="speed-input" class=" w-1/2 flex flex-col gap-1">
            <label for="speed" class="text-base font-medium">Speed</label>
            <input name="speed" type="number" id="speed" class="input-colors rounded py-2 px-3">
            <span id="speed-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>
        
        <div id="positioning-input" class="w-1/2 flex flex-col gap-1">
            <label for="positioning" class="text-base font-medium">Positioning</label>
            <input name="positioning" type="number" id="positioning" class="input-colors rounded py-2 px-3">
            <span id="positioning-error" class="text-red-600 text-sm hidden"><i class="fa-solid fa-diamond-exclamation"></i> Value must be between 10 and 99.</span>
        </div>  

        </div>
        

        

    </div>
<button type="submit" name ="add_player" id="add-player-btn" class=" bg-violet-700 text-white w-full px-8 py-4 rounded ">add player</button>
<button type="button" id="update-player-btn" class=" bg-orange-500 text-white w-full px-8 py-4 rounded hidden">Save Changes</button>
<button type="button" id="cancel-update-player-btn" class=" bg-red-500 text-white w-full px-8 py-4 rounded ">cancel</button>
        
    </form>
</section>
</div>
<script src="../assets/interaction.js"></script>
</body>
</html>
