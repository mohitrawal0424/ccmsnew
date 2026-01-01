<div class="flex justify-center items-center">
    <div id="addCounterDetailsForm" class="p-4 w-full max-w-2xl md:h-auto">
        <?php $dataArray = []; ?>
        <div class="p-4 bg-gray-700 rounded-lg shadow-2xl sm:p-5 border-2 border-black">
            <!-- Modal header -->
            <div class="flex justify-center items-center pb-3 mb-3 rounded-t border-b sm:mb-5">
                <h3 class="text-xl font-semibold text-white">
                    Add Counter Details (Counter के माल की डिटेल्स डालिये )
                </h3>
            </div>
            <!-- error and success message  -->
            <?php if (isset($_GET['emessage'])) {
                $message = $_GET["emessage"];
            ?>
                <div class="p-4 mb-4 text-md text-red-700 rounded-lg bg-red-100 border" role="alert">
                    <?php echo $message ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['smessage'])) {
                $message = $_GET["smessage"];
            ?>
                <div class="p-4 mb-4 text-md text-green-700 rounded-lg bg-green-100 border" role="alert">
                    <?php echo $message ?>
                </div>
            <?php } ?>

            <!-- only message  -->
            <?php if (isset($_GET['message'])) {
                $message = $_GET["message"];
            ?>
                <div class="p-4 mb-4 text-md text-gray-900 rounded-lg bg-yellow-500 border" role="alert">
                    <?php echo $message ?>
                </div>
            <?php } ?>
            <!-- Modal body -->
            <form action="./queries.php" method="GET">
                <div class="grid gap-4 mb-4 sm:grid-cols-2 text-white">
                    <div class="bg-white rounded-md p-2 m-2" id="customerDetails">
                        <?php
                        include("../include/connect.php");
                        $sql = "SELECT g.*,s.name as recName,s.shopname FROM `counter` as g 
                            INNER JOIN `customer` as s ON g.receiverid = s.id
                            WHERE g.id = ?";
                        $stmt = $conn->prepare($sql);
                        if ($stmt) {
                            $stmt->bind_param("i", $recId);
                            if ($stmt->execute()) {
                                $result = $stmt->get_result(); // Get the result set
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $discount = $row['discount'];
                                    $amountpaid = $row['amountpaid'];
                                    //for adding data in $dataArray
                                    foreach($row as $key =>$ro){
                                        $dataArray['counter'][$key] = $ro;
                                    }

                                    echo "<p class='text-black'> Receiver Name : <span  id='custName' class='text-orange-600 font-bold'>" . $row['recName'] . "</span></p>";
                                    echo "<p class='text-black'> Counter ID : <span class='text-orange-600 font-bold'>" . $row['id'] . "</span></p>";
                                    echo "<p class='text-black'> Date : <span class='text-orange-600 font-bold'>"; 
                                    $date = new DateTime($row['date']);
                                    echo $date->format('d-M-Y');
                                    echo "</span></p>";
                                    if ($discount) {
                                    echo "<p class='text-black'> Discount : <span class='text-orange-600 font-bold'>" . $row['discount'] . "</span></p>";
                                    }

                                    echo "<input type='hidden' id='counterId' name='counterId' value='" . $row['id'] . "' >";
                                    echo "<input type='hidden' name='CounterAddDate' value='" . $row['date'] . "' >";
                                }
                            } else {
                                echo 'Something Error';
                            }
                        }
                        ?>
                    </div>
                    <div id="hideBtndiv">
                    <button id="hideBtn" class="bg-cyan-600 text-white p-2 rounded mt-7">Hide/Show Product Section</button>
                    </div>
                    
                    <!-- add product  -->
                    <div class="sm:col-span-2 bottleSection">
                        <label for="productDetails" class="block mb-2 text-sm font-medium">Select Product <span class="text-yellow-400 text-xs">(example:- यहाँ पर बोतल का नाम और quantity डालिये )</span></label>
                        <select name="productDetails" id="productDetails" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Type product name" required>

                            <?php
                            include("../include/connect.php");
                            $sql1 = "SELECT * FROM `product` ORDER BY name ASC";
                            $stmt1 = $conn->prepare($sql1);
                            if ($stmt1) {
                                // $stmt->bind_param("i", $managerId);
                                if ($stmt1->execute()) {
                                    $result1 = $stmt1->get_result(); // Get the result set
                                    if ($result1->num_rows > 0) {
                                        while ($row1 = $result1->fetch_assoc()) {

                                            echo '<option value="' . $row1['id'] . '">' . $row1['name'] . ' ' . convertToLitre($row1['size']) . ' ( Price: ' . $row1["price"] . ' INR )</option>';
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
                        <button id="addProductBtnInCounter" name="addProductBtnInCounter" type="submit" class="bg-blue-600 text-white p-2 rounded mt-7">Add product</button>
                    </div>
                    <div class="sm:col-span-2 rounded-lg bg-white text-green-600 px-2 py-1 bottleSection">
                    <div class="text-black text-xl bg-gray-200 rounded px-1 bottleSection">Bottle list</div>
                        <ul>
                            <!-- <ul id="productList"></ul> -->
                            <?php

                            include("../include/connect.php");

                            $sql2 = "SELECT *,gd.id as gdid, pr.price as selPrice,pr.id as productID FROM `counterdetails` as gd
                      INNER JOIN product as pr ON gd.itemid = pr.id
                      WHERE gd.itemtype = 0 and gd.counterid = $recId";

                            $stmt2 = $conn->prepare($sql2);
                            $productTotalAmount = [];
                            if ($stmt2) {
                                if ($stmt2->execute()) {
                                    $results2 = $stmt2->get_result();
                                    if ($results2->num_rows > 0) {
                                        $i = 1; 
                                        $j=1;?>

                                        <div class="relative overflow-x-auto" id="productlistDiv">
                                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 mb-2">
                                                <tbody>

                                                    <?php while ($row2 = $results2->fetch_assoc()) {
                                                        $sellingPrice = (int)$row2["selPrice"];
                                                        $nos = (int)$row2['nos'];
                                                        $totPrice = $sellingPrice * $nos;

                                                    ?>

                                                        <?php
                                                        if ($row2["IsInScheme"] == 1) { 
                                                            $dataArray['productlist'][$j]['name'] = $row2['name'] ." (". convertToLitre($row2['size']).")";
                                                            $dataArray['productlist'][$j]['nos'] = $row2['nos'];
                                                            $dataArray['productlist'][$j]['price'] = 'FREE';
                                                            
                                                            ?>

                                                            <tr class="bg-white border border-gray-800">
                                                                <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap border border-gray-800">
                                                                    <?php echo $i++ ?>
                                                                </th>
                                                                <td class="px-3 py-2 text-gray-700 border border-gray-800">
                                                                    <?php echo $row2['name']; ?> (<?php echo convertToLitre($row2['size']); ?> ) <span class="text-blue-600">
                                                                </td>
                                                                <td class="px-3 py-2 text-gray-700 border border-gray-800">
                                                                    <?php echo $row2['nos'] ?> Nos
                                                                </td>
                                                                <td class="px-3 py-2 text-gray-700 border border-gray-800">
                                                                    <button class="bg-red-500 rounded-lg p-1 text-white text-sm dltbtn" value="<?php echo $row2['gdid'] ?>">Delete</button>
                                                                </td>
                                                                <td class="px-3 py-2 text-gray-700 border border-gray-800">
                                                                    Price: FREE
                                                                </td>
                                                            </tr>
                                                        <?php } else {
                                                            $productTotalAmount[] = $totPrice;

                                                            $dataArray['productlist'][$j]['name'] = $row2['name'] ." (". convertToLitre($row2['size']).")";
                                                            $dataArray['productlist'][$j]['nos'] = $row2['nos'];
                                                            $dataArray['productlist'][$j]['price'] = $totPrice;
                                                        ?>
                                                            <tr class="bg-white border border-gray-800">
                                                                <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap border border-gray-800">
                                                                    <?php echo $i++ ?>
                                                                </th>
                                                                <td class="px-3 py-2 text-gray-700 border border-gray-800">
                                                                    <?php echo $row2['name']; ?> (<?php echo convertToLitre($row2['size']); ?> ) <span class="text-blue-600">
                                                                </td>
                                                                <td class="px-3 py-2 text-gray-700 border border-gray-800">
                                                                    <?php echo $row2['nos'] ?> Nos
                                                                </td>
                                                                <td class="px-3 py-2 text-gray-700 border border-gray-800">
                                                                    <button class="bg-red-500 rounded-lg p-1 text-white text-sm dltbtn" value="<?php echo $row2['gdid'] ?>">Delete</button>
                                                                </td>
                                                                <td class="px-3 py-2 text-gray-700 border border-gray-800">
                                                                    Price: <?php echo $totPrice; ?> INR
                                                                </td>
                                                                <!-- return Bottle input and button  -->
                                                                <td class="px-3 text-gray-700 border border-gray-800">
                                                                <div class="flex">
                                                                <!-- hidden fields  -->
                          <input id="availableStoke" type="hidden" name="availableStoke" value="<?php echo $row2["nos"]; ?>">
                          <input id="tableId" type="hidden" name="tableId" value="<?php echo $row2["gdid"]; ?>">
                          <input type="hidden" name="itemtype" id="itemtype" value="<?php echo $row2['itemtype'] ?>">
                          <input type="hidden" name="itemid" id="itemid" value="<?php echo $row2['itemid'] ?>">
                          <!-- hidden fields  -->
                                                                <input type="number" name="ReturnQuantity" id="ReturnQuantity" class="border border-black rounded" placeholder="Enter return peti">

                                                                <button type="submit" name="returnQuantitySubmit" class="bg-cyan-500 rounded-lg p-1 ml-2 text-white text-sm border-black border returnQuantitySubmit">Return</button>
                                                                
                                                                </div>
                                                                </td>
                                                            </tr>
                                                        <?php }
                                                        $j++;
                                                        ?>

                                                    <?php  } ?>

                                                </tbody>
                                            </table>
                                        </div>
                            <?php }
                                }
                            }
                            ?>
                            <hr>
                            <li><span class="float-right text-red-600">Total Amount: <?php echo array_sum($productTotalAmount); ?> INR</span></li>
                        </ul>
                    </div>
                    <!-- add peti  -->
                    <div class="sm:col-span-2">
                        <label for="petiDetails" class="block mb-2 text-sm font-medium">Select Peti and Quantity <span class="text-yellow-400">(example:- Cocacola, Sprite)</span></label>
                        <select name="petiDetails" id="petiDetails" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Type product name" required="">
                            <?php
                            include("../include/connect.php");
                            $sql3 = "SELECT p.*, pr.name, pr.size FROM `peti` as p INNER JOIN product as pr ON p.product_id = pr.id";
                            $stmt3 = $conn->prepare($sql3);
                            if ($stmt3) {
                                // $stmt->bind_param("i", $managerId);
                                if ($stmt3->execute()) {
                                    $result3 = $stmt3->get_result(); // Get the result set
                                    if ($result3->num_rows > 0) {
                                        while ($row3 = $result3->fetch_assoc()) {

                            ?>
                                            <option value="<?php echo $row3['id'] ?>"> <?php echo $row3['name'] ?> <?php echo convertToLitre($row3['size']); ?> <span class="text-blue-600 font-bold">( <?php echo $row3['bottleNos'] ?>nos)</span></option>
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
                        <button id="addPetiBtnInCounter" name="addPetiBtnInCounter" type="submit" class="bg-blue-600 text-white p-2 rounded mt-7">Add Peti</button>
                    </div>

                    <div class="sm:col-span-2 rounded-lg bg-white text-green-600 px-2 py-1">
                    <div class="text-black text-xl bg-gray-200 rounded px-1">Peti list</div>
                        <ul>
                            <!-- <ul id="productList"></ul> -->
                            <?php

                            include("../include/connect.php");

                            $sql4 = "SELECT gd.*, pr.name as name , pr.size as size ,p.price as sellPrice, p.bottleNos,p.id as petiID FROM `counterdetails` as gd
                      INNER JOIN peti as p ON gd.itemid = p.id
                      INNER JOIN product as pr ON p.product_id = pr.id
                      WHERE gd.itemtype = 1 and gd.counterid = $recId";

                            $stmt4 = $conn->prepare($sql4);
                            $petiTotalAmount = [];

                            if ($stmt4) {
                                if ($stmt4->execute()) {
                                    $results4 = $stmt4->get_result();
                                    if ($results4->num_rows > 0) {
                                        $i = 1;
                            ?>
                                        <div class="relative overflow-x-auto" id="petilistDiv">
                                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 mb-2">
                                                <tbody>

                                                    <?php while ($row4 = $results4->fetch_assoc()) {
                                                        $sellPrice1 = (int)$row4["sellPrice"];
                                                        $nos1 = (int)$row4["nos"];
                                                        $totalPetisPrice = $sellPrice1 * $nos1;
                                                        if ($row4["IsInScheme"] == 0) {

                                                            $petiTotalAmount[] = $totalPetisPrice;
                                                            $dataArray['productlist'][$j]['name'] = $row4['name'] ." ".convertToLitre($row4['size'])." (". $row4['bottleNos']." Nos)";
                                                            $dataArray['productlist'][$j]['nos'] = $row4['nos'];
                                                            $dataArray['productlist'][$j]['price'] = $totalPetisPrice;
                                                    ?>
                                                            <tr class="bg-white border border-gray-800">
                                                                <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap border border-gray-800">
                                                                    <?php echo $i++ ?>
                                                                </th>
                                                                <td class="px-3 py-2 text-gray-700 border border-gray-800">
                                                                    <?php echo $row4['name']; ?> <?php echo convertToLitre($row4['size']); ?> (<?php echo $row4['bottleNos'] ?> Nos)
                                                                </td>
                                                                <td class="px-3 py-2 text-gray-700 border border-gray-800">
                                                                    <?php echo $row4['nos'] ?> Nos
                                                                </td>
                                                                <td class="px-3 py-2 text-gray-700 border border-gray-800">
                                                                    <button class="bg-red-500 rounded-lg p-1 text-white text-sm dltbtn" value="<?php echo $row4['id'] ?>">Delete</button>
                                                                </td>
                                                                <td class="px-3 py-2 text-gray-700 border border-gray-800">
                                                                    Price: <?php echo $totalPetisPrice; ?> INR
                                                                </td>
                                                            <!-- return peti input and button  -->
                                                                <td class="px-3 text-gray-700 border border-gray-800">
                                                                <div class="flex">
                                                                <!-- hidden fields  -->
                          <input id="availableStoke" type="hidden" name="availableStoke" value="<?php echo $row4["nos"]; ?>">
                          <input id="tableId" type="hidden" name="tableId" value="<?php echo $row4["id"]; ?>">
                          <input type="hidden" name="itemtype" id="itemtype" value="<?php echo $row4['itemtype'] ?>">
                          <!-- hidden fields  -->
                                                                <input type="number" name="ReturnQuantity" id="ReturnQuantity" class="border border-black rounded" placeholder="Enter return peti">

                                                                <button type="submit" name="returnQuantitySubmit" class="bg-cyan-500 rounded-lg p-1 ml-2 text-white text-sm border-black border returnQuantitySubmit">Return</button>
                                                                
                                                                </div>
                                                                </td>

                                                            </tr>
                                                        <?php  } else {
                                                            
                                                            $dataArray['productlist'][$j]['name'] = $row4['name'] .convertToLitre($row4['size'])." (". $row4['bottleNos']."Nos )";
                                                            $dataArray['productlist'][$j]['nos'] = $row4['nos'];
                                                            $dataArray['productlist'][$j]['price'] = 'FREE';
                                                            
                                                            ?>
                                                            <tr class="bg-white border border-gray-800">
                                                                <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap border border-gray-800">
                                                                    <?php echo $i++ ?>
                                                                </th>
                                                                <td class="px-3 py-2 text-gray-700 border border-gray-800">
                                                                    <?php echo $row4['name']; ?> <?php echo convertToLitre($row4['size']); ?> (<?php echo $row4['bottleNos'] ?> Nos)
                                                                </td>
                                                                <td class="px-3 py-2 text-gray-700 border border-gray-800">
                                                                    <?php echo $row4['nos'] ?> Nos
                                                                </td>
                                                                <td class="px-3 py-2 text-gray-700 border border-gray-800">
                                                                    <button class="bg-red-500 rounded-lg p-1 text-white text-sm dltbtn" value="<?php echo $row4['id'] ?>">Delete</button>
                                                                </td>
                                                                <td class="px-3 py-2 text-gray-700 border border-gray-800">
                                                                    Price: FREE INR
                                                                </td>
                                                            </tr>
                                                        <?php  }
                                                        $j++;
                                                        ?>
                                                    <?php  } ?>
                                                </tbody>
                                            </table>
                                        </div>
                            <?php  }
                                }
                            }
                            ?>
                            <hr>
                            <li><span class="float-right text-red-600">Total Amount: <?php echo array_sum($petiTotalAmount); ?> INR</span></li>
                        </ul>
                    </div>
                </div>
                <!-- Pay and Discount input submit START  -->
                <div class="sm:col-span-2 text-md rounded-lg bg-white text-gray-700 px-2 py-1 mb-3">
                    <input type="number" name="discountCounter" class="bg-gray-200 border-blue-600 border-2 rounded text-black m-2 p-1" placeholder="Enter Discount Amount">
                    <button class="text-sm text-white bg-blue-600 rounded-lg p-2" name="applyCounterdiscount" type="submit">Apply Discount</button><br>
                    
                    <input type="number" name="payamount" class="bg-gray-200 border-blue-600 border-2 rounded text-black m-2 mt-2 p-1" placeholder="Pay Amount">
                    <button class="text-sm text-white bg-blue-600 rounded-lg p-2" name="payamountsubmit" type="submit">Pay Amount</button>
                </div>
                <!-- Pay and Discount input submit END  -->

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
                                    echo $amountpaid = ($amountpaid) ? $amountpaid : 0;
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

                <!-- some hidden inputs  -->
                <input type="hidden" value="<?php echo $totalbill; ?>" name="totalBill">
                <input type="hidden" value="<?php echo $recId ?>" name="counterid">
                <div class="flex justify-between">
                    <button name="submitCounterAllDetails" id="submitCounterAllDetails" type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
                        Add All details
                    </button>
                    <?php
                    addTotalBillCounter($totalbill, $recId);
                    ?>
                    <button id="downloadInvoice" class="text-white inline-flex items-center bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
                        Download Invoice
                    </button>
                </div>

                <!-- div for generating bill invoice  -->

            </form>
        </div>
    </div>
</div>

<!-- recipt  -->
<div id="receipt" class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto my-4 sm:my-10 hidden">
                <div class="sm:w-11/12 lg:w-3/4 mx-auto">
                  <div class="flex flex-col p-4 sm:p-10 bg-white shadow-md rounded-xl">
                    
                    <div class="flex justify-between">
                      <div>
                        <h1 class="mt-2 text-lg md:text-xl font-semibold text-blue-600">Tamanna Khaadya Bhandar</h1>
                      </div>
                      <div class="text-end">
                        <h2 class="text-2xl md:text-3xl font-semibold text-gray-800">Invoice #<?php echo $dataArray['counter']['id'] ?></h2>
                      </div>
                    
                    </div>
                 
                    <div class="mt-8 grid sm:grid-cols-2 gap-3">
                      <div>
                        <h3 class="text-lg font-semibold text-gray-800">Customer Name: <?php echo $dataArray['counter']['recName'] ?></h3>
                        <h3 class="text-lg font-semibold text-gray-800">Shop Name: <?php echo $dataArray['counter']['shopname'] ?></h3>
                      </div>
                     
              
                      <div class="sm:text-end space-y-2">
                       
                        <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                          <dl class="grid sm:grid-cols-5 gap-x-3">
                            <dt class="col-span-3 font-semibold text-gray-800">Invoice date: </dt>
                            <dd class="col-span-2 text-gray-500"><?php echo date('d-m-y') ?></dd>
                          </dl>
                          <dl class="grid sm:grid-cols-5 gap-x-3">
                            <dt class="col-span-3 font-semibold text-gray-800">GST: </dt>
                            <dd class="col-span-2 text-gray-500">10BUGPK4850B1Z8</dd>
                          </dl>
                          
                        </div>
                      </div>
                    </div>
                  
                    <div class="mt-6">
                      <div class="border border-gray-500 p-4 rounded-lg space-y-4">
                        <div class="hidden sm:grid sm:grid-cols-5">
                          <div class="sm:col-span-2 text-xs font-medium text-gray-500 uppercase">Item</div>
                          <div class="text-start text-xs font-medium text-gray-500 uppercase">Qty</div>
                          <div class="text-end text-xs font-medium text-gray-500 uppercase">Amount</div>
                        </div>
                    <?php 
                    foreach($dataArray['productlist'] as $key=> $product){ ?>
                   
                        <div class="hidden sm:block border-b border-gray-500"></div>
                        <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                              <div class="col-span-full sm:col-span-2">
                                <p class="font-medium text-gray-800"><?php echo $product['name'] ?></p>
                              </div>
                              <div>
                                <p class="text-gray-800"><?php echo $product['nos'] ?></p>
                              </div>
                            
                              <div>
                                <p class="sm:text-end text-gray-800"><?php echo $product['price'] ?></p>
                              </div>
                            </div>
                            <div class="sm:hidden border-b border-gray-500"></div>
                            <?php }
                    ?>
                    </div>
                    </div>
                
                    <div class="mt-8 flex sm:justify-end">
                      <div class="w-full max-w-2xl sm:text-end space-y-2">
              
                        <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                          <dl class="grid sm:grid-cols-5 gap-x-3">
                            <dt class="col-span-3 font-semibold text-gray-800">Total Bill:</dt>
                            <dd class="col-span-2 text-gray-500"><?php echo $dataArray['counter']['totalbill'] ?></dd>
                          </dl>
              
                          <dl class="grid sm:grid-cols-5 gap-x-3">
                            <dt class="col-span-3 font-semibold text-gray-800">Discount:</dt>
                            <dd class="col-span-2 text-gray-500"><?php echo $dataArray['counter']['discount'] ?></dd>
                          </dl>
              
                          <dl class="grid sm:grid-cols-5 gap-x-3">
                            <dt class="col-span-3 font-semibold text-gray-800">Amount paid:</dt>
                            <dd class="col-span-2 text-gray-500"><?php echo $dataArray['counter']['amountpaid'] ?></dd>
                          </dl>
              
                          <dl class="grid sm:grid-cols-5 gap-x-3">
                            <dt class="col-span-3 font-semibold text-gray-800">Due balance:</dt>
                            <dd class="col-span-2 text-gray-500"><?php echo ($dataArray['counter']['totalbill'] - $dataArray['counter']['discount'] - $dataArray['counter']['amountpaid']) ?></dd>
                          </dl>
                        </div>
              
                      </div>
                    </div>
              
                    <div class="mt-8 sm:mt-12">
                      <h4 class="text-lg font-semibold text-gray-800">Thank you!</h4>
                      <p class="text-gray-500">If you have any questions concerning this invoice, use the following contact information:</p>
                      <div class="mt-2">
                        <p class="block text-sm font-medium text-gray-800">+91 7488545475</p>
                      </div>
                    </div>
              
                    <p class="mt-5 text-sm text-gray-500">© Tamanna Khaadya Bhandar.</p>
                  </div>
              
                </div>
              </div>
     