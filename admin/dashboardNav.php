<?php
include("../include/functions/session.php");
session();
session_timeout();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CocaCola Salary Management</title>
    <link rel="stylesheet" href="../output.css">
</head>
<body>
<?php
date_default_timezone_set("Asia/Calcutta");
include_once "../include/emptyNavbar.php" 
?>

<div class="flex justify-center items-center h-screen">
  <div class="flex flex-col">
    <a href="./dashboard.php"><button class="text-white bg-cyan-600 p-4 m-4 rounded-lg font-semibold border border-black w-full">Staff Panel</button></a>
    <a href="./dashboardproduct.php"><button class="text-white bg-cyan-600 p-4 m-4 rounded-lg font-semibold border border-black w-full">Cocacola Product Panel</button></a>
    <a href="./dashboardCounter.php"><button class="text-white bg-cyan-600 p-4 m-4 rounded-lg font-semibold border border-black w-full">Counter Panel</button></a>
    <a href="./rent.php"><button class="text-white bg-cyan-600 p-4 m-4 rounded-lg font-semibold border border-black w-full">Rent Panel</button></a>
  </div>
</div>


<?php include_once "../include/footer.php";

?>
</body>
</html>