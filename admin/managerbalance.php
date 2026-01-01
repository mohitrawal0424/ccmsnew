<?php
include("../include/functions/session.php");
session($allowmanger = 0);
session_timeout();
error_reporting(E_ALL); 
ini_set('display_errors', 1);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance</title>
    <link rel="stylesheet" href="../output.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body>
<?php

date_default_timezone_set("Asia/Calcutta");
include_once "../include/navbar2.php";
include("./forms/transferAmountModal.php");
include("../include/functions/functions.php");
?>

<div class="flex justify-center border-black border-b-2">
      <a href="./managerbalance.php?personRemainBalance=1" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2" href="">Balance</a>
      <a href="./managerbalance.php?personTransactionTable=1" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2" href="">Balance Transaction</a>
    </div>
</div>

<?php 
if(isset($_GET["personRemainBalance"])){
  include("./populateData/receiverBalanceTable.php");
}
if(isset($_GET["personTransactionTable"])){
  include("./populateData/receiverTransactionTable.php");
}
?>
<?php 
// include("./populateData/transferToOwnerTransactionTable.php");
?>
<!-- </div> -->
<?php
include_once "../include/footer.php";
?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
        var table = new DataTable('#managerBlanceTable');
        var table = new DataTable('#sendToOwnerTransaction');

</script>
<script src="../include/js/managerbalance.js"></script>
</body>
</html>