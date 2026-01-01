<!-- Show Error/Success Message -->
<div id="alertExpanse">
    <?php
    if (isset($_GET['smessage'])) {
        $message = $_GET['smessage'];
        echo '<div class="p-3 mb-3 text-md text-green-800 rounded-sm bg-green-50 border border-gray-800" role="alert">
        <span class="font-medium">' . $message . '
        </div>';
    }
    if (isset($_GET['emessage'])) {
        $message = $_GET['emessage'];
        echo '<div class="p-3 mb-3 text-md text-red-800 rounded-sm bg-red-50 border border-gray-800" role="alert">
        <span class="font-medium">' . $message . '</div>';
    }
    ?>
</div>
<!-- Active Customer Table -->
<div class="overflow-x-auto border-2 border-black">
                <table id="activeCustomerTable" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
                      <tr class="text-white bg-blue-400 text-center text-xl border-2 border-gray-800">
                        <th colspan="6" class="p-4">Customers</th>
                        <th class="bg-yellow-600">
                          <a href="./addCustomer.php">
                            <button class="bg-blue-700 p-1 m-1 rounded-lg border border-gray-200 font-normal px-2">Add Customer</button>
                          </a>
                        </th>
                      </tr>
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-500">S. No.</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Cust. ID</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Shop Name</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Customer Name</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Phone No.</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Date of Reg.</th>
                            <!-- <th scope="col" class="px-4 py-3 border border-gray-500">Total Bill</th> -->
                            <th scope="col" class="px-4 py-3 border border-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php 

                      include("../include/connect.php");
                      include("../include/functions/getProductPeti.php");

                      $sql = "SELECT * FROM `customer` WHERE isDeleted = 0 ORDER BY `customer`.`id` DESC";
                      
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
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["shopname"] ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["name"] ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["phone"] ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php
                              echo $newDate = date("d-M-Y", strtotime($row["dor"]));  
                               ?></td>
                              <td class="px-4 py-3 border">
                                <a href="./addCustomer.php?editId=<?php echo $row["id"]; ?>" value="<?php echo $row["id"] ?>" class="text-white bg-blue-700 rounded-lg p-1 px-4">Edit</a>
                                <a id="deleteBtn" href="" value="<?php echo $row["id"];  ?>" class="text-white bg-red-500 px-2 py-1 rounded border border-gray-800 ml-2">Delete</a>
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