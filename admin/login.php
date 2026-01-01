<?php
session_start();
if (isset($_SESSION['username'])) {
    if ($_SESSION['role'] == 0) {
        header('location:dashboard.php');
    } elseif ($_SESSION['role'] == 1) {
        header('location:staff.php');
    }
} else {
    if (isset($_POST['submitlogin'])) {

        include '../include/connect.php';
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM user WHERE username = ? and password= ? ";
        $stmt = $conn->prepare($sql);
        if($stmt){
          $stmt->bind_param("ss", $username , $password );
          if($stmt->execute()){
            $results = $stmt->get_result();
            if($results->num_rows > 0){
              $row = $results->fetch_assoc();
              session_start();
              $_SESSION['username'] = $username;
              $_SESSION["id"] = $row["id"];
              $_SESSION['role'] = (int)$row['role'];
              $_SESSION['logintime'] = time();
              header('location:dashboardNav.php');
            } else {
              echo '<script>alert("Enter Correct Username & Password")</script>';
            }

          }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../output.css">
</head>
<body>

<?php
date_default_timezone_set("Asia/Calcutta");
?>
<!-- Navbar  -->
<nav class="bg-[#176B87] sticky w-full z-20 top-0 left-0 border-b border-gray-600">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
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





<div class="bg-slate-900">
    <div class="bg-gradient-to-b from-violet-600/[.15] via-transparent pt-20 pb-20">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                            Sign in to your account
                        </h1>
                        <form class="space-y-4 md:space-y-6" action="#" method="post">
                            <div>
                                <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                                <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter Your Username" required="">
                            </div>
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-start">
                                </div>
                            </div>
                            <button type="submit" name="submitlogin" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-blue-700 dark:focus:ring-primary-800">Sign in</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- footer -->
<?php include "../include/footer.php";  ?>


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
    
</body>
</html>