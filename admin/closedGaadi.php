<?php
include("../include/functions/session.php");
session($allowmanager = 0);
session_timeout();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Load Gaadi</title>
    <link rel="stylesheet" href="../output.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body>
<?php

date_default_timezone_set("Asia/Calcutta");
include_once "../include/navbar2.php";

?>
<div class="flex justify-between border-2 border-black bg-cyan-500 text-white py-2 px-5">
    <div class="text-2xl">Closed gaadi</div>
    <!-- <button id="addGaadiBtn" class="bg-blue-600 p-2 rounded-lg border border-white">Add Gaadi</button> -->
</div>
<!-- Closed Gaadi Tabel Between This -->
<div class="overflow-x-auto border-2 border-black">
                <table id="closedGaadiTable" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
                      <tr class="text-white bg-blue-400 text-center text-xl border-2 border-gray-800">
                        <th colspan="7" class="p-4">Closed Gaadi</th>
                      </tr>
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-500">S. No.</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Gaadi ID</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Receiver Name</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Date</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Close/Sold Date</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Total Bill</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php 

                      include("../include/connect.php");
                      include("../include/functions/getProductPeti.php");

                      $sql = "SELECT g.*,s.name as dname FROM `gaadis` as g
                      INNER JOIN person as s ON g.receiverid = s.id WHERE isSold = 1";
                      
                      $stmt = $conn -> prepare($sql);
                      if($stmt){
                        if($stmt->execute()){
                          $results = $stmt->get_result();
                          if ($results->num_rows > 0) {
                          $i = 1;
                            while ($row = $results->fetch_assoc()) { 
                               
                                ?>
                              <tr class="border">
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $i++; ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["id"]; ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["dname"] ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php
                              echo $newDate = date("d-M-Y", strtotime($row["date"]));  
                               ?></td>
                               <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php
                              echo $newDate = date("d-M-Y", strtotime($row["closedate"]));  
                               ?></td>
                               <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["totalbill"] ?></td>
                               <td>
                               <a href="./returnGaadi.php?receiverid=<?php echo $row["id"]; ?>" value="<?php echo $row["id"] ?>" class="text-white bg-blue-700 rounded-lg p-1 px-4">Info</a>
                               </td>
                              </tr>            
                            
                          <?php  }
                          }
                        }
                      }
                        ?>
                    </tbody>
                </table>
            </div>
<!-- Closed Gaadi Tabel Between This -->
<?php
include_once "../include/footer.php";
?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
        let table = new DataTable('#closedGaadiTable');        
</script>
</body>
</html>