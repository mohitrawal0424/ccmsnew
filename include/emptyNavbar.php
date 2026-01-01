<?php
date_default_timezone_set("Asia/Calcutta");
?>

<nav class="bg-[#176B87] sticky w-full z-20 top-0 left-0 border-b border-gray-600">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <!-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="Flowbite Logo"> -->
    <span class="self-center text-2xl font-semibold whitespace-nowrap text-white">Trisha Manager</span>

    <div class="flex md:order-2">
      <a href="./logout.php"><button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 border border-white">Logout</button></a>
      <button id="menu-toggle" data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-sticky" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
        </svg>
      </button>
    </div>
   
  </div>
</nav>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    var menuToggle = document.getElementById('menu-toggle');
    var menuContainer = document.getElementById('navbar-sticky');
    var isOpen = false;

    menuToggle.addEventListener('click', function() {
      isOpen = !isOpen;
      menuContainer.style.display = isOpen ? 'block' : 'none';
    });
  });
</script>