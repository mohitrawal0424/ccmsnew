<!-- Manager Balance Table -->
<div class="overflow-x-auto border-2 border-black">
                <table id="managerBlanceTable" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
                      <tr class="text-white bg-blue-400 text-center text-xl border-2 border-gray-800">
                        <th colspan="7" class="p-4">Balance</th>
                      </tr>
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-500">S. No.</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Staff Name</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Pending Amount</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php 

                      include("../include/connect.php");
                      include("../include/functions/getProductPeti.php");

                      $sql = "SELECT p.name,p.id as person_id,
                              SUM(CASE WHEN pb.type = 1 THEN pb.amount ELSE 0 END) AS creditInTable,
                              SUM(CASE WHEN pb.type = 2 THEN pb.amount ELSE 0 END) AS debitInTable
                              FROM `person_balance` as pb 
                              JOIN person as p ON pb.person_id = p.id
                              GROUP BY person_id";
                      
                      $stmt = $conn -> prepare($sql);
                      if($stmt){
                        if($stmt->execute()){
                          $results = $stmt->get_result();
                          if ($results->num_rows > 0) {
                          $i = 1;
                            while ($row = $results->fetch_assoc()) { 
                              // print_r($row);die;
                                ?>
                              <input type="hidden" name="person_id" value="<?php $row["person_id"]?>">
                              <input type="hidden" name="availableAmount" value="<?php echo ($row["creditInTable"] - $row["debitInTable"]) ?>">                        

                              <tr class="border">
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $i++; ?></td>  
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["name"]; ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo ($row["creditInTable"] - $row["debitInTable"]);  ?> INR</td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border">

                                <button id="transferAmountBtn" data-person="<?php echo $row["person_id"];?>" data-availableBalance="<?php echo ($row["creditInTable"] - $row["debitInTable"]) ?>"
                                data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="transferModalOpenBtn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
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