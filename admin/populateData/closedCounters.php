<!-- Scheme Table -->
<div class="overflow-x-auto border-2 border-black">
                <table id="closedCounterTable" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
                      <tr class="text-white bg-blue-400 text-center text-xl border-2 border-gray-800">
                        <th colspan="9" class="p-4">Closed Counter</th>
                      </tr>
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-500">S. No.</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Counter ID</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Customer Name</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Date </th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Bill</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Amount Paid</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Remaining Amount</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php 

                      include("../include/connect.php");
                      include("../include/functions/getProductPeti.php");

                      $sql = "SELECT c.*,cu.name as cusName FROM `counter` as c
                      INNER JOIN customer as cu on c.receiverid = cu.id WHERE c.isClosed = 1";
                      
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
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["cusName"] ?></td>
                            <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php
                              echo $newDate = date("d-M-Y", strtotime($row["date"]));  
                               ?></td>
                               <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["totalbill"] ?></td>
                               <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["amountpaid"] ?></td>
                               <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo ($row["totalbill"]-$row['amountpaid']) ?></td>
                              <td class="px-4 py-3 border">
                                <a href="./counter.php?counterid=<?php echo $row["id"]; ?>" value="<?php echo $row["id"] ?>" class="text-white bg-blue-700 rounded-lg p-1 px-4">Edit</a>
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