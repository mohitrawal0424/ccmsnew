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
    <title>Defect Stokes</title>
    <link rel="stylesheet" href="../output.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body>
<?php

date_default_timezone_set("Asia/Calcutta");
include_once "../include/navbar2.php";
include("../include/functions/functions.php");

?>
    <!-- <div class="flex justify-center">
        <button id="addBottleBtn" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2" href="">Add Bottle & Size</button>
        <button id="addSetBtn" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2" href="">Add पेटी size</button>
        <button id="addStokesBtn" class="text-white bg-blue-600 border border-gray-900 rounded-lg p-2 m-2" href="">Add पेटी Stokes</button>
    </div> -->

<div class="overflow-x-auto border-2 border-black">
                <table id="petistoketable" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
                      <tr class="text-white bg-blue-400 text-center text-xl border-2 border-gray-800">
                        <th colspan="6" class="p-4">Defect पेटी Stoke Table</th>
                      </tr>
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Product name</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Units</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                      
                      <?php 

                      include("../include/connect.php");

                      $sql = "SELECT s.*,
                      SUM(CASE WHEN s.stoketype = 1 THEN s.nos ELSE 0 END) AS addedSum,
                      SUM(CASE WHEN s.stoketype = 2 THEN s.nos ELSE 0 END) AS removedSum,
                      p.bottleNos, pr.name,pr.size FROM `defectstokes` as s
                      INNER JOIN peti as p ON s.itemid= p.id
                      INNER JOIN product as pr ON p.product_id=pr.id
                      WHERE itemtype = 1 GROUP BY itemid";
                      
                      $stmt = $conn -> prepare($sql);
                      if($stmt){
                        if($stmt->execute()){
                          $results = $stmt->get_result();
                          if ($results->num_rows > 0) {
                            while ($row = $results->fetch_assoc()) { ?>
                              
                              <tr class="border">
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row['name'] ?> <?php  echo convertToLitre($row['size']); ?>  <span class="text-blue-600 font-bold">( <?php echo $row['bottleNos'] ?> piece वाली पेटी)</span></td>
                              <td class="px-4 py-3 border"><?php echo $row['addedSum'] - $row["removedSum"] ?></td>
                              </tr>            
                            
                          <?php  }
                          }
                        }
                      }
                        ?>
             
                    </tbody>
                </table>
            </div>
<!-- bottle stokes  -->
            <div class="overflow-x-auto border-2 border-black">
                <table id="bottlestoketable" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
                      <tr class="text-white bg-blue-400 text-center text-xl border-b-2 border-gray-800">
                        <th colspan="6" class="p-4">Defect Bottle Stoke Table</th>
                      </tr>
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Product name</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Units</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php 

                      include("../include/connect.php");

                      $sql = "SELECT s.*,
                      SUM(CASE WHEN s.stoketype = 1 THEN s.nos ELSE 0 END) AS addedSum,
                      SUM(CASE WHEN s.stoketype = 2 THEN s.nos ELSE 0 END) AS removedSum,
                      pr.name,pr.size FROM `defectstokes` as s
                      INNER JOIN product as pr ON s.itemid=pr.id
                      WHERE itemtype = 0 GROUP BY itemid";
                      
                      $stmt = $conn -> prepare($sql);
                      if($stmt){
                        if($stmt->execute()){
                          $results = $stmt->get_result();
                          if ($results->num_rows > 0) {
                            while ($row = $results->fetch_assoc()) { ?>
                              
                              <tr class="border">
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row['name'] ?> <?php  echo convertToLitre($row['size']); ?></td>
                              <td class="px-4 py-3 border"><?php echo ($row['addedSum']-$row['removedSum']) ?></td>
                          </tr>            
                            
                          <?php  }
                          }
                        }
                      }
                        ?>
                    </tbody>
                </table>
            </div>

<?php 
include_once "../include/footer.php";
?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="../include/js/stokes.js"></script>

    <script>
        let table = new DataTable('#petistoketable');
        let tablenew = new DataTable('#bottlestoketable');
    </script>
</body>
</html>