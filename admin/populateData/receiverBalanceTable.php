<!-- Manager Balance Table -->
<div class="overflow-x-auto border-2 border-black">
                <table id="managerBlanceTable" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
                      <tr class="text-white bg-blue-400 text-center text-xl border-2 border-gray-800">
                        <th colspan="7" class="p-4">Balance</th>
                      </tr>
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-500">S. No.</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Gaadi Id</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Staff Name</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Pending Amount</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php 

                      include("../include/connect.php");
                      include("../include/functions/getProductPeti.php");

                      $sql = "SELECT g.id as gaadi_id,
       g.name as gaadi_name,
       u.username as manager_name,
       u.id as manager_id,
       g.soldValue as cashBalance,
       COALESCE(SUM(CASE WHEN apg.type = 1 THEN apg.amount ELSE 0 END), 0) as cashPayments,
       COALESCE(SUM(CASE WHEN apg.type = 2 THEN apg.amount ELSE 0 END), 0) as onlinePayments,
       COALESCE(SUM(apg.amount), 0) as totalAmountPaid,
       (g.soldValue - COALESCE(SUM(apg.amount), 0)) as remainingBalance 
FROM `gaadis` g
JOIN user u ON g.createby = u.id 
JOIN amountpaidgaadis as apg ON g.id = apg.gaadi
WHERE u.role = 1
GROUP BY g.id, g.name, u.username, u.id, g.soldValue;";
                      
                      $stmt = $conn -> prepare($sql);
                      if($stmt){
                        if($stmt->execute()){
                          $results = $stmt->get_result();
                          if ($results->num_rows > 0) {
                          $i = 1;
                            while ($row = $results->fetch_assoc()) { 
                              $sql2 = "SELECT sum(amount) as sumamount FROM `transfertoowner` WHERE senderid = ? AND gaadi = ?";
                              $stmt2 = $conn -> prepare($sql2);
                              $stmt2 -> bind_param("ii", $row["manager_id"], $row["gaadi_id"]);
                              $stmt2 -> execute();
                              $result2 = $stmt2 -> get_result();
                              if($result2->num_rows > 0){
                                $transferedAmount = 0;
                                while($row2 = $result2->fetch_assoc()){
                                  $transferedAmount = $row2["sumamount"];
                                }
                              }
                                ?>
                              <input type="hidden" name="manager_id" value="<?php echo $row["manager_id"]; ?>">
                              <input type="hidden" name="gaadi_id" value="<?php echo $row["gaadi_id"]; ?>">
                              <input type="hidden" name="availableAmount" value="<?php echo $row["cashPayments"] - $transferedAmount; ?>">                        

                              <tr class="border">
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $i++; ?></td>  
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["gaadi_id"]; ?></td>  
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["manager_name"]; ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["cashPayments"] - $transferedAmount;  ?> INR</td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border">
                                <button id="transferAmountBtn" data-gaadi="<?php echo $row["gaadi_id"]; ?>" data-person="<?php echo $row["manager_id"]; ?>" data-availableBalance="<?php echo $row["cashPayments"]; ?>" data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="transferModalOpenBtn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                Transfer Balance
                              </button>

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
<!-- Manager Balance Table -->