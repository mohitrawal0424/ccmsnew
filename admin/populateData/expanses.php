<!-- Active Expanse Table -->
<div class="overflow-x-auto border-2 border-black">
                <table id="expansesTable" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
                      <tr class="text-white bg-blue-400 text-center text-xl border-2 border-gray-800">
                        <th colspan="9" class="p-4">Expanses Table</th>
                      </tr>
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-500">S. No.</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Expanse Type</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Amount </th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Date</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $totalAmountArray = [];
                      $sql = "SELECT * FROM `expanse`";
                      $stmt = $conn -> prepare($sql);
                      if($stmt){
                        if($stmt->execute()){
                          $results = $stmt->get_result();
                          if ($results->num_rows > 0) {
                          $i = 1;
                            while ($row = $results->fetch_assoc()) { 
                              $totalAmountArray[$row['id']] = $row["amount"];
                               
                                ?>
                              <tr class="border">
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $i++; ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["expType"]; ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["amount"]; ?></td>
                            <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php
                              echo $newDate = date("d-M-Y", strtotime($row["dor"]));  
                               ?></td>
                              <td class="px-4 py-3 border">
                                <a href="?addExpanse=1&expanseEditId=<?php echo $row["id"]; ?>" value="<?php echo $row["id"] ?>" class="text-white bg-blue-700 rounded-lg p-1 px-4">Edit</a>
                                <a href="./delete.php?deleteExpanseId=<?php echo $row["id"]; ?>" value="<?php echo $row["id"] ?>" class="text-white bg-orange-700 rounded-lg p-1 px-4">Delete</a>
                              </td>
                              </tr>            
                            
                          <?php  } ?>
                          <tr class="border">
                              <td scope="row" colspan="2" class="px-4 py-3 font-bold text-gray-600 whitespace-nowrap border">Total Amount</td>
                              <td scope="row" class="px-4 py-3 font-bold text-gray-600 whitespace-nowrap border"><?php echo array_sum($totalAmountArray); ?></td>
                              </tr>   
                         <?php }
                        }
                      }
                        ?>
             
                    </tbody>
                </table>
            </div>

<!--  -->