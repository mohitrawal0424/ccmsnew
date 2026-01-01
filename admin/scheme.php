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
    <title>Scheme</title>
    <link rel="stylesheet" href="../output.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body>
<?php

date_default_timezone_set("Asia/Calcutta");
include_once "../include/navbar2.php";

?>
<div class="flex justify-between border-2 border-black bg-cyan-500 text-white py-2 px-5">
    <div class="text-2xl">Scheme</div>
    <button id="addSchemeBtn" class="bg-blue-600 p-2 rounded-lg border border-white">Add Scheme</button>
</div>
<!-- error and success message  -->
<?php if(isset($_GET['emessage'])){ 
  $message = $_GET["emessage"];
?>
  <div class="p-4 mb-4 text-md text-red-700 rounded-lg bg-red-100 border" role="alert">
     <?php  echo $message ?>
  </div>
<?php } ?>
<?php if(isset($_GET['smessage'])){ 
  $message = $_GET["smessage"];
?>
  <div class="p-4 mb-4 text-md text-green-700 rounded-lg bg-green-100 border" role="alert">
     <?php  echo $message ?>
  </div>
<?php } ?>
<!--  -->

<?php 
include("./forms/addSchemeForm.php");
?>
<!-- Scheme Table -->
<div class="overflow-x-auto border-2 border-black">
                <table id="schemeTable" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
                      <tr class="text-white bg-blue-400 text-center text-xl border-2 border-gray-800">
                        <th colspan="6" class="p-4">Scheme Table</th>
                      </tr>
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-500">S. No.</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Scheme</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                      <?php 

                      include("../include/connect.php");
                      include("../include/functions/getProductPeti.php");

                      $sql = "SELECT * FROM `scheme`";
                      
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
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border">
                                <?php 
                                if($row["fromItemType"] == 0){
                                    $productdetails = getProductName($row["fromItemID"]);
                                    echo "<span class='text-green-800 font-semibold text-lg'>";
                                    echo $row["fromNos"];
                                    echo (" (".$productdetails['name'] .'-'. $productdetails['size']." ml )");
                                    echo "</span>";
                                } elseif ($row["fromItemType"] == 1){
                                    echo "<span class='text-green-800 font-semibold text-lg'>";
                                    $petiDetails = getPetiName($row["fromItemID"]);
                                    echo $row["fromNos"];
                                    echo (" (".$petiDetails['name'] ."-". $petiDetails['size']."ml )(".$petiDetails["bottleNos"]." वाली पेटी )");
                                    echo "</span>";

                                }
                                echo " &nbsp&nbsp&nbsp&nbsp&nbsp पर   &nbsp&nbsp&nbsp&nbsp&nbsp  ";

                                if($row["toItemType"] == 0){
                                    echo "<span class='text-red-800 font-semibold text-lg'>";
                                    $productdetails = getProductName($row["toItemID"]);
                                    echo $row["toNos"];
                                    echo (" (".$productdetails['name'] .'-'. $productdetails['size']." ml )");
                                    echo "</span>";

                                } elseif ($row["toItemType"] == 1){
                                    echo "<span class='text-red-800 font-semibold text-lg'>";
                                    $petiDetails = getPetiName($row["toItemID"]);
                                    echo $row["toNos"];
                                    echo (" (".$petiDetails['name'] ."-". $petiDetails['size']."ml )(".$petiDetails["bottleNos"].")");
                                    echo "</span>";
                                }
                                ?>

                        
                            
                            </td>
                              <td class="px-4 py-3 border">
                                <button value="<?php echo $row["id"] ?>" class="schemedltbtn text-white bg-red-700 rounded-lg p-1 ">Delete</button>
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

<!--  -->
<?php
include_once "../include/footer.php";
?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="../include/js/scheme.js"></script>
<script>
        let table = new DataTable('#schemeTable');        
</script>
</body>
</html>