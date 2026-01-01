<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CocaCola Salary Management</title>
    <link rel="stylesheet" href="./output.css">
</head>
<?php
date_default_timezone_set("Asia/Calcutta");
?>
<body>

<!-- Navbar  -->
<nav class="bg-[#176B87] sticky w-full z-20 top-0 left-0 border-b border-gray-600">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <!-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="Flowbite Logo"> -->
        <span class="self-center text-2xl font-semibold whitespace-nowrap text-white">Trisha Manager</span>
    
    <div class="flex md:order-2">
        <!-- <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 border border-white">Login</button> -->
        <button id="menu-toggle" data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-sticky" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
          </svg>
      </button>
    </div>
    <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
      <ul class="flex flex-col p-4 md:p-0 mt-4 text-white font-medium border border-gray-100 rounded-lg md:flex-row md:space-x-8 md:mt-0 md:border-0">
        <!-- <li>
          <a href="http://localhost/ccms/public_html/ccms/admin/dashboard.php" class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0" aria-current="page">DashBoard</a>
        </li>
        <li>
          <a href="http://localhost/ccms/public_html/ccms/admin/staff.php" class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Staff/Employees</a>
        </li>
        <li>
          <a href="http://localhost/ccms/public_html/ccms/admin/attendence.php" class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Attendence</a>
        </li>
        <li>
          <a href="http://localhost/ccms/public_html/ccms/admin/profile.php" class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Profile</a>
        </li> -->
      </ul>
    </div>
    </div>
  </nav>
    
<!--hero section -->
  <!-- Hero -->
  <div class="bg-slate-900">
  <div class="bg-gradient-to-b from-violet-600/[.15] via-transparent pt-20 pb-20">
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-24 space-y-8">
      
      <!-- Title -->
      <div class="max-w-3xl text-center mx-auto">
        <h1 class="block font-medium text-gray-200 text-4xl sm:text-5xl md:text-6xl lg:text-7xl">
          CocaCola Salary Management System
        </h1>
      </div>
      <!-- End Title -->

      <div class="max-w-3xl text-center mx-auto">
        <p class="text-lg text-gray-400">Manage all Your Staff's activity</p>
      </div>

      <!-- Buttons -->
      <!-- <div class="text-center">
        <a href="admin/adminlogin.php" class="inline-flex justify-center text-xl items-center gap-x-3 text-center bg-gradient-to-tl from-blue-600 to-violet-600 shadow-lg shadow-transparent hover:shadow-blue-700/50 border border-transparent text-white font-medium rounded-full focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-white py-3 px-6">
          Admin Login
          <svg class="w-2.5 h-2.5" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </a>
      </div> -->
      <div class="text-center">
        <a href="./admin/login.php" class="inline-flex justify-center text-xl items-center gap-x-3 text-center bg-gradient-to-tl from-blue-600 to-violet-600 shadow-lg shadow-transparent hover:shadow-blue-700/50 border border-transparent text-white font-medium rounded-full focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 py-3 px-6 focus:ring-offset-gray-800" href="#">
          Login
          <svg class="w-2.5 h-2.5" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </a>
      </div>
      <!-- End Buttons -->
    </div>
  </div>
</div>
<!-- End Hero -->


<?php include_once "./include/footer.php";
?>
</body>
</html>