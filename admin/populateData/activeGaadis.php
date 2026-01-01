<!-- Scheme Table -->
<?php
if(isset($_GET["receiverPerson"])){
  $personId = $_GET["receiverPerson"];
}
?>
<div class="overflow-x-auto border-2 border-black">
                <table id="activeGaadiTable" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
                      <tr class="text-white bg-blue-400 text-center text-xl border-2 border-gray-800">
                        <th colspan="8" class="p-4">Active Gaadi</th>
                      </tr>
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-500">S. No.</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Gaadi ID</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Gaadi Name</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Receiver Name</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Manager</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Date</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Remaining Amount</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php 

                      include("../include/connect.php");
                      include("../include/functions/getProductPeti.php");

                      if($personId){
                        $sql = "SELECT g.*,s.name as dname FROM `gaadis` as g
                      INNER JOIN person as s ON g.receiverid = s.id WHERE isSold = 0 and s.id= $personId";
                      } else {
                      $sql = "SELECT g.*,s.name as dname FROM `gaadis` as g
                      INNER JOIN person as s ON g.receiverid = s.id WHERE isSold = 0";
                      }
                      
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
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["name"] ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["dname"] ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["createby"] ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php
                              echo $newDate = date("d-M-Y", strtotime($row["date"]));  
                               ?></td>
                               <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["remaining_amount"] ?></td>
                              <td class="px-4 py-3 border">
                                <a href="./loadGaadi.php?receiverid=<?php echo $row["id"]; ?>" value="<?php echo $row["id"] ?>" class="text-white bg-blue-700 rounded-lg p-1 px-4">Edit</a>
                                <a href="./returnGaadi.php?receiverid=<?php echo $row["id"]; ?>" value="<?php echo $row["id"] ?>" class="text-white bg-orange-700 rounded-lg p-1 px-4">Sold Maal</a>
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