<?php
include("../include/functions/session.php");
session($allowmanger = 0);
session_timeout();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counter Balance</title>
    <link rel="stylesheet" href="../output.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body>
<?php
date_default_timezone_set("Asia/Calcutta");
include_once "../include/navbarCounter.php";
include("./forms/transferCounterAmountModal.php");
include("../include/functions/functions.php");
?>

<div class="flex justify-center border-black border-b-2">
      <a href="./counterbalance.php?personRemainBalance=1" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2">Counter Balance</a>
      <a href="./counterbalance.php?personTransactionTable=1" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2"> Counter Balance Transaction</a>
</div>

<?php 
if(isset($_GET["personRemainBalance"])){
  include("./populateData/counterBalanceTable.php");
}
if(isset($_GET["personTransactionTable"])){
  include("./populateData/counterTransactionTable.php");
}
?>

<?php
include_once "../include/footer.php";
?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
        var table = new DataTable('#counterBalanceTable');
        var table = new DataTable('#sendToOwnerCounterTransaction');
</script>
<script src="../include/js/counterbalance.js"></script>
</body>
</html>
