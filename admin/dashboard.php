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
include_once "../include/navbar1.php";
include_once "../include/connect.php";

$sql = "SELECT count(id) as totalStaff,SUM(salary) as totalSalary FROM `staff` WHERE delete_status = 1 and status = 1";
$stmt = $conn->prepare($sql);
if($stmt){
  if($stmt->execute()){
    $result = $stmt->get_result();
    if($result->num_rows > 0){
      $row = $result->fetch_assoc(); 
?>
   
<div> 
  <div class="block p-3 bg-white border border-gray-600 rounded-lg shadow hover:bg-gray-100 my-2 text-center">
      <span class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Total Active Employees:</span>
      <span class="mb-2 text-2xl font-bold tracking-tight text-green-500"><?php echo $row['totalStaff'] ?></span>
  </div>

  <div class="block p-3 bg-white border border-gray-600 rounded-lg shadow hover:bg-gray-100 my-2 text-center">
      <span class="mb-2 text-xl font-bold tracking-tight text-gray-900">Total Employees Salary:</span>
      <span class="mb-2 text-xl font-bold tracking-tight text-green-500"><?php echo $row['totalSalary'] ?></span>
  </div>
  <div class="block p-3 bg-white border border-gray-600 rounded-lg shadow hover:bg-gray-100 my-2 text-center">
      <span class="mb-2 text-xl font-bold tracking-tight text-gray-900">Total Amount Paid:</span>
      <span class="mb-2 text-xl font-bold tracking-tight text-green-500"><?php 
      
      $sqls = "SELECT SUM(amount) as amountPaid FROM `advance`";
      $stmts = $conn->prepare($sqls);
      if($stmts){
        if($stmts->execute()){
          $results = $stmts->get_result();
          if($results->num_rows > 0){
            $rows = $results->fetch_assoc();
            echo $rows["amountPaid"];
          }
        }
      }
      ?></span>
  </div>

</div>

<?php }
  }else {
    echo "some problem";
  }
}else{
  echo "some other problem";
}
?>

<?php include_once "../include/footer.php";

?>
</body>
</html>