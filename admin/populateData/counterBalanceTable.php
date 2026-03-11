<!-- Counter Balance Table -->
<div class="overflow-x-auto border-2 border-black">
                <table id="counterBalanceTable" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
                      <tr class="text-white bg-blue-400 text-center text-xl border-2 border-gray-800">
                        <th colspan="7" class="p-4">Counter Balance</th>
                      </tr>
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-500">S. No.</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Counter Id</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Customer Name</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Counter Date</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Pending Amount</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php 
                      include("../include/connect.php");
                  $TotalReminingForTransfer = [];
                      $sql = "SELECT c.id as counter_id, c.totalbill, c.discount, c.customerName,
                      c.date as counterDate,
       u.username as manager_name, u.id as manager_id,
       COALESCE(SUM(CASE WHEN apc.type = 1 THEN apc.amount ELSE 0 END), 0) as cashPayments,
       COALESCE(SUM(CASE WHEN apc.type = 2 THEN apc.amount ELSE 0 END), 0) as onlinePayments,
       COALESCE(SUM(apc.amount), 0) as totalAmountPaid,
       (c.totalbill - c.discount - COALESCE(SUM(apc.amount), 0)) as remainingBalance 
FROM `counter` c
JOIN user u ON c.created_by = u.id 
LEFT JOIN amountpaidcounters as apc ON c.id = apc.counter
WHERE u.role = 1
GROUP BY c.id, c.customerName, u.username, u.id, c.totalbill, c.discount
ORDER BY c.id DESC;";
                      
                      $stmt = $conn -> prepare($sql);
                      if($stmt){
                        if($stmt->execute()){
                          $results = $stmt->get_result();
                          if ($results->num_rows > 0) {
                          $i = 1;
                            while ($row = $results->fetch_assoc()) { 
                              $sql2 = "SELECT sum(amount) as sumamount FROM `transfertoownercounter` WHERE senderid = ? AND counter = ?";
                              $stmt2 = $conn -> prepare($sql2);
                              $stmt2 -> bind_param("ii", $row["manager_id"], $row["counter_id"]);
                              $stmt2 -> execute();
                              $result2 = $stmt2 -> get_result();
                              $transferedAmount = 0;
                              if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                  $transferedAmount = $row2["sumamount"];
                                }
                              }
                              $remainingBill_exceptTransfered = $row['totalbill'] - $row['discount'] - $row['onlinePayments'];
                              $availableBalanceToManger = $remainingBill_exceptTransfered - $transferedAmount;
                              $TotalReminingForTransfer[] = $availableBalanceToManger;
                                ?>
                              <input type="hidden" name="manager_id" value="<?php echo $row["manager_id"]; ?>">
                              <input type="hidden" name="counter_id" value="<?php echo $row["counter_id"]; ?>">
                              <input type="hidden" name="availableAmount" value="<?php echo $availableBalanceToManger; ?>">                        

                              <tr class="border">
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $i++; ?></td>  
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["counter_id"]; ?></td>  
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["customerName"]; ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["counterDate"]; ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $availableBalanceToManger;  ?> INR</td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border">
                                <button id="transferAmountBtn" data-counter="<?php echo $row["counter_id"]; ?>" data-person="<?php echo $row["manager_id"]; ?>" data-availableBalance="<?php echo $availableBalanceToManger; ?>" data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="transferModalOpenBtn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
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
                    <tfoot>
                      <tr class="bg-green-100 border-t-2 border-gray-800">
                        <td colspan="4" class="px-4 py-3 text-right font-bold text-gray-800 border">Total Pending Amount:</td>
                        <td class="px-4 py-3 font-bold text-green-700 text-lg border"><?php echo number_format(array_sum($TotalReminingForTransfer)); ?> INR</td>
                        <td class="border"></td>
                      </tr>
                    </tfoot>
                </table>
</div>
<!-- Counter Balance Table -->
