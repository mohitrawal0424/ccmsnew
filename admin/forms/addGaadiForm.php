<div class="flex justify-center items-center">
<div id="addGaadiForm" class="p-4 w-full max-w-2xl md:h-auto">
<div class="p-4 bg-gray-700 rounded-lg shadow-2xl sm:p-5 border-2 border-black">
            <!-- Modal header -->
            <div class="flex justify-center items-center pb-3 mb-3 rounded-t border-b sm:mb-5">
                <h3 class="text-xl font-semibold text-white">
                    Load Gaadi details ( गाडी के माल की डिटेल्स डालिये )
                </h3>
            </div>
           <!-- error and success message  -->
            <?php if(isset($_GET['emessage'])){ 
              $message = $_GET["emessage"];
            ?>
              <div class="p-4 mb-4 text-md text-red-700 rounded-lg bg-red-100 border" role="alert">
                 <?php  echo $message ?>
              </div>
            <?php } ?>
            <?php if(isset($_GET['smessage'])){ 
              $message = $_GET["smessage"];
            ?>
              <div class="p-4 mb-4 text-md text-green-700 rounded-lg bg-green-100 border" role="alert">
                 <?php  echo $message ?>
              </div>
            <?php } ?>

              <!-- only message  -->
<?php if(isset($_GET['message'])){ 
  $message = $_GET["message"];
  ?>
  <div class="p-4 mb-4 text-md text-gray-900 rounded-lg bg-yellow-500 border" role="alert">
     <?php  echo $message ?>
  </div>
  <?php } ?>
            <!-- Modal body -->
            <form action="./queries.php" method="GET">
            <div class="grid gap-4 mb-4 sm:grid-cols-2 text-white">
                    <div class="bg-white rounded-md p-2 m-2">
                    <?php 
                    $dataArray = [];

                            $sql = "SELECT g.*,s.name as recName FROM `gaadis` as g 
                            INNER JOIN `person` as s ON g.receiverid = s.id
                            WHERE g.id = ?";
                            $stmt = $conn-> prepare($sql);
                            if ($stmt) {
                                $stmt->bind_param("i", $recId);
                                if ($stmt->execute()) {
                                    $result = $stmt->get_result(); // Get the result set
                                    if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {  
                                            $discount = $row['discount'];
                                            $amountpaid = $row['amountpaid'];

                                            foreach($row as $key =>$ro){
                                                $dataArray['gaadi'][$key] = $ro;
                                            }

                                            echo "<p class='text-black'> Gaadi Name: <span class='text-orange-600 font-bold'>".$row['name']."</span></p>";
                                            echo "<p class='text-black'> Receiver Name : <span id='custName' class='text-orange-600 font-bold'>".$row['recName']."</span></p>";
                                            echo "<p class='text-black'> Gaddi ID : <span class='text-orange-600 font-bold'>".$row['id']."</span></p>";
                                            echo "<p class='text-black'> Date : <span class='text-orange-600 font-bold'>";
                                            $date = new DateTime($row['date']);
                                            echo $date->format('d-M-Y');
                                            echo "</span></p>";
                                            echo "<input type='hidden' name='gaadiId' value='".$row['id']."' >";
                                            echo "<input type='hidden' name='gaadiAddDate' value='".$row['date']."' >";
                                            }
                                    }
                                } else {
                                    echo 'Something Error';
                                }
                            } 
                    ?>

                    </div>
                    <div class="hidebtndiv">
                    <button id="hideBtn" class="bg-cyan-600 text-white p-2 rounded mt-7">Show/Hide Product List</button>
                    </div>
                <!-- add product  -->
                    <div class="sm:col-span-2 bottleSection">
                        <label for="productDetails" class="block mb-2 text-sm font-medium">Select Product<span class="text-yellow-400 text-xs">(example:- यहाँ पर बोतल का नाम और quantity डालिये )</span></label>
                        <select name="productDetails" id="productDetails" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Type product name" required>

                            <?php 
                  
                            $sql1 = "SELECT * FROM `product` ORDER BY name ASC";
                            $stmt1 = $conn-> prepare($sql1);
                            if ($stmt1) {
                                // $stmt->bind_param("i", $managerId);
                                if ($stmt1->execute()) {
                                    $result1 = $stmt1->get_result(); // Get the result set
                                    if ($result1->num_rows > 0) {
                                            while ($row1 = $result1->fetch_assoc()) {
                                                
                                                echo '<option value="'.$row1['id'].'">'.convertToLitre($row1['size']) .' ' . $row1['name'] .' ( Price: '. $row1["price"] .' INR )</option>';
                                            }
                                    }
                                } else {
                                    echo '<option value="">None</option>';
                                }
                            } 
                            ?>
                        </select>
                    </div>
                    <!-- no of bottle  -->
                    <div class="w-full bottleSection">
                        <label for="bottleNos" class="block mb-2 text-sm font-medium">Quantity <span class="text-yellow-400">(of Product)</span></label>
                        <input type="number" name="bottleNos" id="bottleNos" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Enter bottle nos.">
                    </div>
                    <div class="w-full bottleSection">
                            <button id="addProductBtnInGaadi" name="addProductBtnInGaadi" type="submit" class="bg-blue-600 text-white p-2 rounded mt-7">Add product</button>
                    </div>
                    <div class="sm:col-span-2 rounded-lg bg-white text-green-600 px-2 py-1 bottleSection">
                      <div class="text-black text-xl bg-gray-200 rounded px-1">Bottle list</div>
                        <ul>
                        <!-- <ul id="productList"></ul> -->
                        <?php 
                    $j = 1;
                      $sql2 = "SELECT *,gd.id as gdid, pr.price as selPrice,pr.id as productID FROM `gaadidetails` as gd
                      INNER JOIN product as pr ON gd.itemid = pr.id
                      WHERE gd.itemtype = 0 and gd.gaadid = $recId";
                      
                      $stmt2 = $conn -> prepare($sql2);
                      $productTotalAmount = [];
                      if($stmt2){
                        if($stmt2->execute()){
                          $results2 = $stmt2->get_result();
                          if ($results2->num_rows > 0) {
                            while ($row2 = $results2->fetch_assoc()) { 
                                $sellingPrice = (int)$row2["selPrice"];
                                $nos = (int)$row2['nos'];
                                $totPrice = $sellingPrice*$nos;

                                ?>
    
                              <?php 
                              if($row2["IsInScheme"] == 1){ 

                                $dataArray['productlist'][$j]['name'] = $row2['name'] ." (". convertToLitre($row2['size']).")";
                                $dataArray['productlist'][$j]['nos'] = $row2['nos'];
                                $dataArray['productlist'][$j]['price'] = 'FREE';
                                $dataArray['productlist'][$j]['priceofOne'] = 0;
                                ?>

                                <li><?php echo $row2['name']; ?> (<?php echo convertToLitre($row2['size']); ?> ): <span class="text-blue-600"><?php echo $row2['nos'] ?> Nos </span>
                                <button class="bg-red-500 rounded-lg p-1 text-white text-sm my-2 dltbtn" value="<?php echo $row2['gdid'] ?>">Delete</button>
                                <span class="float-right text-green-600">Price: <?php echo "FREE" ?></span></li>

                              <?php }else { 

                                $productTotalAmount[] = $totPrice;
                                $dataArray['productlist'][$j]['name'] = $row2['name'] ." (". convertToLitre($row2['size']).")";
                                $dataArray['productlist'][$j]['nos'] = $row2['nos'];
                                $dataArray['productlist'][$j]['priceofOne'] = $sellingPrice;
                                $dataArray['productlist'][$j]['price'] = $totPrice;
                                ?>
                                <li><?php echo $row2['name']; ?> (<?php echo convertToLitre($row2['size']); ?> ): <span class="text-blue-600"><?php echo $row2['nos'] ?> Nos </span>
                                <button class="bg-red-500 rounded-lg p-1 text-white text-sm my-2 dltbtn" value="<?php echo $row2['gdid'] ?>">Delete</button>
                                <span class="float-right text-red-600">Price: <?php echo $row2['nos']." X ".$sellingPrice." ₹ = ".$totPrice; ?> ₹</span></li>
                                
                              <?php }
                              $j++;
                                }
                          }
                        }
                      }
                        ?>
                        <hr>
                        <li><span class="float-right text-red-600">Total Amount: <?php echo array_sum($productTotalAmount); ?> INR</span></li>
                        </ul>
                    </div>
            <!-- add peti  -->
                    <div class="sm:col-span-2">
                        <label for="petiDetails" class="block mb-2 text-sm font-medium">Select Peti and Quantity<span class="text-yellow-400">(example:- Cocacola, Sprite)</span></label>
                        <select name="petiDetails" id="petiDetails" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Type product name" required="">
                        <?php 
                            $sql3 = "SELECT p.*, pr.name, pr.size FROM `peti` as p INNER JOIN product as pr ON p.product_id = pr.id";
                            $stmt3 = $conn-> prepare($sql3);
                            if ($stmt3) {
                                // $stmt->bind_param("i", $managerId);
                                if ($stmt3->execute()) {
                                    $result3 = $stmt3->get_result(); // Get the result set
                                    if ($result3->num_rows > 0) {
                                            while ($row3 = $result3->fetch_assoc()) { 
                                                
                                                ?>
                                                <option value="<?php echo $row3['id'] ?>"> <?php echo convertToLitre($row3['size']) ?> <?php  echo $row3['name']; ?> <span class="text-blue-600 font-bold">( <?php echo $row3['bottleNos'] ?>nos)</span></option>
                                        <?php    }
                                    }
                                } else {
                                    echo '<option value="">Something Wrong</option>';
                                }
                            } 
                            ?>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="petiNos" class="block mb-2 text-sm font-medium">Quantity <span class="text-yellow-400">(of Peti)</span></label>
                        <input type="number" name="petiNos" id="petiNos" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Enter Peti nos.">
                    </div>
                    <div class="w-full">
                            <button id="addPetiBtnInGaadi" name="addPetiBtnInGaadi" type="submit" class="bg-blue-600 text-white p-2 rounded mt-7">Add Peti</button>
                    </div>

                    <div class="sm:col-span-2 rounded-lg bg-white text-green-600 px-2 py-1">
                    <div class="text-black text-xl bg-gray-200 rounded px-1">Peti list</div>
                        <ul>
                        <!-- <ul id="productList"></ul> -->
                        <?php 

                      $sql4 = "SELECT gd.*, pr.name as name , pr.size as size ,p.price as sellPrice, p.bottleNos,p.id as petiID FROM `gaadidetails` as gd
                      INNER JOIN peti as p ON gd.itemid = p.id
                      INNER JOIN product as pr ON p.product_id = pr.id
                      WHERE gd.itemtype = 1 and gd.gaadid = $recId";
                      
                      $stmt4 = $conn -> prepare($sql4);

                      $petiTotalAmount = [];

                      if($stmt4){
                        if($stmt4->execute()){
                          $results4 = $stmt4->get_result();
                          if ($results4->num_rows > 0) {
                            while ($row4 = $results4->fetch_assoc()) { 
                                $sellPrice1 = (int)$row4["sellPrice"];
                                $nos1 = (int)$row4["nos"];
                                $totalPetisPrice = $sellPrice1 * $nos1;
                                if($row4["IsInScheme"] == 0){
                                    $petiTotalAmount[] = $totalPetisPrice;
                                    $dataArray['productlist'][$j]['name'] = $row4['name'] ." ".convertToLitre($row4['size'])." (". $row4['bottleNos']." Nos)";
                                    $dataArray['productlist'][$j]['nos'] = $row4['nos'];
                                    $dataArray['productlist'][$j]['priceofOne'] = $sellPrice1;
                                    $dataArray['productlist'][$j]['price'] = $totalPetisPrice;
                                    ?>
                                    
                              <li><?php echo $row4['name']; ?> <?php echo convertToLitre($row4['size']); ?> (<?php echo $row4['bottleNos'] ?> Nos): <span class="text-blue-600"><?php echo $row4['nos'] ?> Nos </span>
                              <button class="bg-red-500 rounded-lg p-1 text-white text-sm my-2 dltbtn" value="<?php echo $row4['id'] ?>" >Delete</button>
                              <span class="float-right text-red-600">Price: <?php echo $row4['nos']." X ".$sellPrice1." ₹ = ".$totalPetisPrice; ?> ₹</span>
                            </li>

                              <?php  } else { 
                                $dataArray['productlist'][$j]['name'] = $row4['name'] .convertToLitre($row4['size'])." (". $row4['bottleNos']."Nos )";
                                $dataArray['productlist'][$j]['nos'] = $row4['nos'];
                                $dataArray['productlist'][$j]['price'] = 'FREE';
                                $dataArray['productlist'][$j]['priceofOne'] = 0;
                                
                                ?>
                                <li><?php echo $row4['name']; ?> <?php echo convertToLitre($row4['size']); ?> (<?php echo $row4['bottleNos'] ?> Nos): <span class="text-blue-600"><?php echo $row4['nos'] ?> Nos </span><button class="bg-red-500 rounded-lg p-1 text-white text-sm my-2 dltbtn" value="<?php echo $row4['id'] ?>" >Delete</button>
                              <span class="float-right text-green-600">Price: <?php echo "FREE"; ?></span></li>
                             <?php  }
                        $j++;  
                        }
                          }
                        }
                      }
                        ?>

                        <hr>
                        <li><span class="float-right text-red-600">Total Amount: <?php echo array_sum($petiTotalAmount); ?> INR</span></li>
                        </ul>
                    </div>
                </div>

                <!-- bill discount and remaining amount details START  -->
                <div class="relative overflow-x-auto" id="billdiscountpaymentdetails">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 mb-2">
                        <tbody>
                            <tr class="bg-white border border-gray-800">
                                <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap border border-gray-800">
                                    Total Bill (कुल बिल):
                                </th>
                                <td class="px-3 py-2 text-gray-700">
                                    <?php echo $totalbill = (array_sum($productTotalAmount) + array_sum($petiTotalAmount)); ?>
                                </td>
                            </tr>
                            <?php if ($discount) { ?>
                                <tr class="bg-white border border-gray-800">
                                    <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap border border-gray-800">
                                        Discount (छूट):
                                    </th>
                                    <td class="px-3 py-2 text-gray-700">
                                        <?php echo $discount = ($discount) ? $discount : 0; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr class="bg-white border border-gray-800">
                                <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap border border-gray-800">
                                    Amount Paid (राशि का भुगतान):
                                </th>
                                <td class="px-3 py-2 text-gray-700">
                                    <?php
                                $stmt->bind_param("i", $recId);
                                    $amountpaidArray = amountTypeAndTotal($recId);
                                    echo $amountpaidArray["total_amount"];
                                    ?>
                                </td>
                            </tr>
                            <tr class="bg-white border border-gray-800">
                                <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap border border-gray-800">
                                    Remaining Amount (बकाया राशि) :
                                </th>
                                <td class="px-3 py-2 text-gray-700">
                                    <?php echo ($totalbill - $amountpaid - $discount); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- bill discount and remaining amount details END  -->

                <input type="hidden" value="<?php echo $recid; ?>" name="gaadiIDD">
                <input type="hidden" value="<?php echo $totalbill ?>" name="totalBill">
                <div class="flex justify-between">
                    <button name="submitGaadiAllDetails" id="submitGaadiAllDetails" type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
                        Add All details
                    </button>
                    <?php 
                    addTotalBill($totalbill,$recId);
                    ?>
                    <button  id="downloadInvoice" class="text-white inline-flex items-center bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
                        Download Invoice
                    </button>
                </div>
            </form>
        </div>
</div>
</div>
<?php 
include("./receipt.php");
receipt($dataArray);
?>