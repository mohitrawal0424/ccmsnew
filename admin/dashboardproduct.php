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
include_once "../include/navbar2.php";
include_once "../include/connect.php";
?>
   
<div> 
  
  <div class="block p-3 bg-white border border-gray-600 rounded-lg shadow hover:bg-gray-100 my-2 text-center">
      <span class="mb-2 text-xl font-bold tracking-tight text-gray-900">CocaCola Profit:</span>
      <span class="mb-2 text-xl font-bold tracking-tight text-green-500">
      <?php 

      include("../include/functions/functions.php");
      $productProfit = productProfit();
      $petiProfit = petiProfit();
      echo ($productProfit + $petiProfit);

      ?></span>
  </div>
</div>

<?php include_once "../include/footer.php";

?>
</body>
</html>