<?php
include("../include/functions/session.php");
session();
session_timeout();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="../output.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
</head>
<body>
<?php
date_default_timezone_set("Asia/Calcutta");
include_once "../include/navbar2.php";
include("../include/functions/functions.php");
session_timeout();

?>
<!-- error and success message  -->
<?php if(isset($_GET['emessage'])){ 
  $message = $_GET["emessage"];
  ?>
  <div class="p-4 mb-4 text-md text-red-700 rounded-lg bg-red-100 border" role="alert">
     <?php  echo $message ?>
  </div>
<?php } 
if(isset($_GET['smessage'])) {
  $message = $_GET["smessage"];
  ?>
  <div class="p-4 mb-4 text-md text-green-700 rounded-lg bg-green-100 border" role="alert">
  <?php  echo $message ?>
  </div>

<?php } ?>

    <div class="flex justify-center border-black border-b-2">
      <a href="./products.php?product=1" id="addBottleBtn" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2" href="">Add Bottle & Size</a>
      <a href="./products.php?productstoke=1" id="addBottleStokesBtn" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2" href="">Add Bottle Stokes</a>
      <a href="./products.php?bottlelist=1" id="bottleListBtn" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2" href="">Bottle List</a>
    </div>

    <div class="flex justify-center border-black border-b-2">
    <a href="./products.php?peti=1" id="addSetBtn" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2" href="">Add पेटी size</a>
    <a href="./products.php?petistoke=1" id="addStokesBtn" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2" href="">Add पेटी Stokes</a>
    <a href="./products.php?petilist=1" id="petiListBtn" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2" href="">Peti List</a>
    </div>

    <div class="flex justify-center border-black border-b-2">
    <!-- <a href="./products.php?defectproduct=1" class="text-white bg-yellow-600 border border-gray-900 rounded-lg p-2 m-2" href="">Add Defect Bottle</a> -->
    <!-- <a href="./products.php?defectPeti=1" class="text-white bg-yellow-600 border border-gray-900 rounded-lg p-2 m-2" href="">Add Defect Peti</a> -->
    <a href="./products.php?leakageBottle=1" class="text-white bg-yellow-600 border border-gray-900 rounded-lg p-2 m-2" href="">Add Leakage/Shortage</a>
    
    </div>
    <div class="flex justify-center border-black border-b-2">
    <a href="./addPerson.php" class="text-white bg-yellow-600 border border-gray-900 rounded-lg p-2 m-2" href="">Add Person</a>
    <a href="./personlist.php" class="text-white bg-yellow-600 border border-gray-900 rounded-lg p-2 m-2" href="">Person list</a>
  </div>

<?php 
include("./forms/alertModal.php"); 

if(isset($_GET["product"])){
  include("./forms/addBottleProduct.php");
}

if(isset($_GET["productstoke"])){
  include("./forms/addBottleStokes.php");
}

if(isset($_GET["bottlelist"])){
  include("./populateData/bottlelist.php");
}

if(isset($_GET["peti"])){
  include("./forms/addPeti.php");
}

if(isset($_GET["petistoke"])){
include("./forms/addPetiStokes.php");
}
if(isset($_GET["petilist"])){
  include("./populateData/petilist.php");
}

// if(isset($_GET["defectPeti"])){
// include("./forms/addDefectpeti.php");
// }

// if(isset($_GET["defectproduct"])){
// include("./forms/addDefectProduct.php");
// }
if(isset($_GET["leakageBottle"])){
  include("./forms/leakageBottle.php");
}

include_once "../include/footer.php";
?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<script src="../include/js/products.js"></script>
</body>
</html>