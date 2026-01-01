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
    <title>Return Gaadi</title>
    <link rel="stylesheet" href="../output.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script
			src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
			integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
			crossorigin="anonymous"
			referrerpolicy="no-referrer">
</script>
<script src="../include/js/generate.js"></script>
<script src="../include/js/returnGaadi.js"></script>
<script>
        let table = new DataTable('#activeGaadiTable');        
</script>
</head>
<body>
<?php

date_default_timezone_set("Asia/Calcutta");
include_once "../include/navbar2.php";
include("../include/functions/functions.php");

?>
<div class="flex justify-between border-2 border-black bg-cyan-500 text-white py-2 px-5">
    <div class="text-2xl">Return Gaadi Panel</div>
    <!-- <button id="addGaadiBtn" class="bg-blue-600 p-2 rounded-lg border border-white">Add Gaadi</button> -->
</div>
<!-- error and success message  -->
<?php if(isset($_GET['emessage'])){ 
  $message = $_GET["emessage"];
  ?>

  <div class="p-4 mb-4 text-md text-red-700 rounded-lg bg-red-100 border" role="alert">
     <?php  echo $message ?>
  </div>

  <?php } ?>

<?php include("./forms/alertModal.php") ?>

<?php 
if(isset($_GET['receiverid'])){
  $recId = (int)$_GET['receiverid'];
  include("./forms/addReturnForm.php");
}

?>

<?php
include_once "../include/footer.php";
?>

</body>
</html>