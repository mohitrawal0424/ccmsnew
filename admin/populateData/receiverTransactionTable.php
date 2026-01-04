<!-- Manager Balance Table -->
<div class="overflow-x-auto border-2 border-black">
                <table id="sendToOwnerTransaction" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
                      <tr class="text-white bg-blue-400 text-center text-xl border-2 border-gray-800">
                        <th colspan="7" class="p-4">Transaction</th>
                      </tr>
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-500">S. No.</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Name</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Amount</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Gaadi ID</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Mode</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php 
                      include "../include/connect.php";

                      $sql = "SELECT * FROM `transfertoowner` as tto
                      JOIN user ON tto.senderid = user.id
                      ORDER BY tto.timestamp DESC;";
                      $stmt = $conn->prepare($sql);
                      if ($stmt) {
                          if ($stmt->execute()) {
                              $result = $stmt->get_result();
                              $i =1;
                              while ($row = $result->fetch_assoc()) {
                                ?>
                      
                              <tr class="border">
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $i++; ?> </td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row['username']; ?> </td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row['amount']; ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row['gaadi']; ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border">
                                <?php 
                                  if($row['mode'] == 1){
                                    echo "Cash";
                                  } elseif($row['mode'] == 2){
                                    echo "Direct Bank Transfer / UPI";
                                  } else {
                                    echo "N/A";
                                  }
                                ?>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border">
                                  <?php 
                                      $date = new DateTime($row['timestamp']);
                                      echo $date->format('d-m-Y H:i:s');
                                  ?>
                              </td>
                
                            </tr>        
                            
                          <?php  
                          }      
                          }
                      }    
                        ?>
                    </tbody>
                </table>
</div>
<!-- Manager Balance Table -->