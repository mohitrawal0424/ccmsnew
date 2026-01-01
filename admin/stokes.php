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
  <title>Stokes</title>
  <link rel="stylesheet" href="../output.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>

<body>

  <?php
  date_default_timezone_set("Asia/Calcutta");
  include_once "../include/navbar2.php";
  include("../include/functions/functions.php");
  include("../include/functions/getProductPeti.php");

  ?>
  <div class="flex justify-center border-black border-b-2">
    <a href="./stokes.php?action=bottleStoke" id="addBottleBtn" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2" href="">Bottle Stokes</a>
    <a href="./stokes.php?action=petiStoke" id="addBottleStokesBtn" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2" href="">Peti Stokes</a>
  </div>
  <div class="flex justify-center border-black border-b-2">
    <a href="./stokes.php?action=defectbottleStoke" id="addBottleBtn" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2" href="">Defect Bottle Stokes</a>
    <a href="./stokes.php?action=defectpetiStoke" id="addBottleStokesBtn" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2" href="">Defect Peti Stokes</a>
  </div>
  <div class="flex justify-center border-black border-b-2">
    <a href="./stokes.php?action=stokesHistory" id="addStokesHistoryBtn" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2" href="">Stokes History</a>
  </div>

  <?php

  include("../include/connect.php");
  include("./forms/alertModal.php");
  if (isset($_GET["action"])) {
    if ($_GET["action"] == "bottleStoke") {
      include("./populateData/bottleStoke.php");
    }
    if ($_GET["action"] == "petiStoke") {
      include("./populateData/petiStoke.php");
    }
    if ($_GET["action"] == "defectbottleStoke") {
      include("./populateData/defectbottleStoke.php");
    }
    if ($_GET["action"] == "defectpetiStoke") {
      include("./populateData/defectpetiStoke.php");
    }
     if ($_GET["action"] == "stokesHistory") {
      include("./populateData/stokeshistory.php");
    }
  }

  include_once "../include/footer.php";
  ?>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="../include/js/stokes.js"></script>
</body>

</html>