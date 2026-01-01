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
    <title>Rent</title>
    <link rel="stylesheet" href="../output.css">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
</head>

<body>
    <?php
    date_default_timezone_set("Asia/Calcutta");
    include_once "../include/navbarRent.php";
    include_once "../include/connect.php";
    include("./forms/alert.php");
    ?>


   <div class="flex justify-center border-black border-b-2">
      <a href="?addpropertyowner=1" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2">Add Property Owner</a>
      <a href="?addproperty=1" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2">Add Property</a>
      <a href="?addrent=1" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2">Add Rent Entry</a>
      <a href="?addadvance=1" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2">Add Advance</a>
    </div>
    <div class="flex justify-center border-black border-b-2">
      <a href="?propertyownertable=1" class="text-white bg-cyan-600 border border-gray-900 rounded-lg p-2 m-2">Property Owner List</a>
      <a href="?propertytable=1" class="text-white bg-cyan-600 border border-gray-900 rounded-lg p-2 m-2">Property List</a>
      <a href="?renttable=1" class="text-white bg-cyan-600 border border-gray-900 rounded-lg p-2 m-2">Rent Entries</a>
      <a href="?advancetable=1" class="text-white bg-cyan-600 border border-gray-900 rounded-lg p-2 m-2">Advance Entries</a>
    </div>
    <?php

    if(isset($_GET["addpropertyowner"])){
        include("./forms/addPropertyOwner.php");
    }
    if(isset($_GET["addproperty"])){
        include("./forms/addProperty.php");
    }
    if(isset($_GET["addrent"])){
        include("./forms/addRentEntry.php");
    }
    if(isset($_GET["addadvance"])){
        include("./forms/addAdvance.php");
    }
    if(isset($_GET["propertyownertable"])){
        include("./populateData/propertyownertable.php");
    }
    if(isset($_GET["propertytable"])){
        include("./populateData/propertytable.php");
    }
    if(isset($_GET["renttable"])){
        include("./populateData/renttable.php");
    }
    if(isset($_GET["advancetable"])){
        include("./populateData/rentadvancetable.php");
    }

    include_once "../include/footer.php";
    ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> -->
    <script src="../include/js/generate.js"></script>
    <!-- <script src="../include/js/expanse.js"></script> -->
</body>
</html>