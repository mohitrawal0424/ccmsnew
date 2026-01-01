<!-- property owner Table -->
<div class="overflow-x-auto border-2 border-black">
                <table id="renttable" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
                      <tr class="text-white bg-blue-400 text-center text-xl border-2 border-gray-800">
                        <th colspan="9" class="p-4">Rent List</th>
                      </tr>
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-500">S. No.</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Property Name</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Owner Name</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Date</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Amount Paid</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Mode of Trans</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT rt.*,rp.name as propertyName,rpo.name as ownername FROM `rent_transaction` as rt
                      JOIN rentedproperty as rp ON rt.property_id = rp.id
                      JOIN rentpropertyowner as rpo ON rp.owner_id = rpo.id";
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
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["propertyName"]; ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["ownername"]; ?></td>
                            <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php
                              echo $newDate = date("d-M-Y", strtotime($row["date"]));  
                               ?></td>
                               <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["amount"]; ?></td>
                               <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php 
                               echo $mode = ($row["trans_type"] == 1) ? 'Cash' : 'Adance'; ?>
                               </td>
                              <td class="px-4 py-3 border">
                                <a href="?addrent=1&rentEditId=<?php echo $row["id"]; ?>" value="<?php echo $row["id"] ?>" class="text-white bg-blue-700 rounded-lg p-1 px-4">Edit</a>
                                <a href="./delete.php?deleteRentTrans=<?php echo $row["id"]; ?>" value="<?php echo $row["id"] ?>" class="text-white bg-orange-700 rounded-lg p-1 px-4">Delete</a>
                              </td>
                              </tr>            
                            
                          <?php  } ?>  
                         <?php }
                        }
                      }
                        ?>
             
                    </tbody>
                </table>
            </div>

<!--  -->