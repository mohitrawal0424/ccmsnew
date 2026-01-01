<!-- Manager Balance Table -->
<div class="overflow-x-auto border-2 border-black">
                <table id="managerBlanceTable" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
                      <tr class="text-white bg-blue-400 text-center text-xl border-2 border-gray-800">
                        <th colspan="7" class="p-4">Manager Balance</th>
                      </tr>
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-500">S. No.</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Manager Username</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Pending Amount</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php 

                      include("../include/connect.php");
                      include("../include/functions/getProductPeti.php");

                      $sql = "SELECT SUM(g.soldValue) as bill,u.username,g.createby,u.id as managerId FROM `gaadis` as g 
                      INNER JOIN user as u ON g.createby = u.id
                      WHERE g.createby <> 1 GROUP BY createby";
                      
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
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["username"]; ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo ($row["bill"]- moneyTransferByManager($row['managerId']));  ?> INR</td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border">
                              <!-- Modal toggle -->
                              <button id="addedClassForModalOpeningSeeInClasses"  data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="transferModalOpenBtn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" id="" type="button">
                                Transfer to Owner
                              </button>
                                <!-- <button class="text-sm text-white border border-black rounded-lg p-1 bg-blue-700">Transfer To Owner</button> -->
                              </td>
                              <!-- hidden Fields -->
                              <input type="hidden" class="managerId" value="<?php echo $row['managerId'] ?>">
                              <input type="hidden" class="bill" value="<?php echo ($row["bill"]- moneyTransferByManager($row['managerId'])); ?>">
                                <!-- hidden Fields -->
                              
                              </tr>            
                            
                          <?php  }
                          }
                        }
                      }
                        ?>
                    </tbody>
                </table>
</div>
<!-- Manager Balance Table -->