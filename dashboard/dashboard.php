<?php
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">
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
        <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-md shadow-md transition duration-200">
          <i class="fa-solid fa-user-plus mr-2"></i> Add Player
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
              <h4 class="text-xl font-semibold text-gray-800">11</h4>
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
              <h4 class="text-xl font-semibold text-gray-800">87,6</h4>
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
              <h4 class="text-xl font-semibold text-gray-800">120</h4>
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
              <h4 class="text-xl font-semibold text-gray-800">60</h4>
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
            <tr>
              <td class="border-b border-gray-300 px-4 py-5 pl-9 xl:pl-11"><p>15</p></td>
              <td class="border-b border-gray-300 px-4 py-5"><p>Ilyass Mar</p></td>
              <td class="border-b border-gray-300 px-4 py-5"><p>Striker</p></td>
              <td class="border-b border-gray-300 px-4 py-5"><p>Morocco</p></td>
              <td class="border-b border-gray-300 px-4 py-5"><p>FC Barcelona</p></td>
              <td class="border-b border-gray-300 px-4 py-5"><p>92</p></td>
              <td class="border-b border-gray-300 px-4 py-5">
                <div class="flex items-center space-x-3.5">
                  <button class="hover:text-blue-500"><i class="fa-solid fa-eye"></i></button>
                  <button class="hover:text-blue-500"><i class="fa-solid fa-pen"></i></button>
                  <button class="hover:text-blue-500"><i class="fa-solid fa-trash"></i></button>
                </div>
              </td>
            </tr>
            <!-- Add more rows here -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

</body>
</html>
