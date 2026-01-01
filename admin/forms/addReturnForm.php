<div class="flex justify-center items-center">
  <div id="addReturnForm" class="p-4 w-full max-w-2xl md:h-auto">
    <div class="p-4 bg-gray-700 rounded-lg shadow-2xl sm:p-5 border-2 border-black">
      <!-- Modal header -->
      <div class="flex justify-center items-center pb-3 mb-3 rounded-t border-b sm:mb-5">
        <h3 class="text-xl font-semibold text-white">
          Enter sold Items
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
      <!-- Modal body -->

      <form action="./queries.php" method="GET">
        <div class="grid gap-4 mb-4 sm:grid-cols-2 text-white">
          <div class="bg-white rounded-md p-2 m-2">
            <?php

            include("../include/connect.php");

            $dataArray = [];
            $gaadiDetails = gaadiDetails($recId);
            foreach ($gaadiDetails['gaadi'] as $key => $ro) {
              $dataArray['gaadi'][$key] = $ro;
            }

            $gaadiId = $gaadiDetails['gaadi']['id'];
            $discount = $gaadiDetails["gaadi"]['discount'];
            $amountPaidTotal = $dataArray['gaadi']['amountpaidTotal'] = ($gaadiDetails["amountpaidtable"]["total_amount"]) ? $gaadiDetails["amountpaidtable"]["total_amount"] : 0 ;
            $Expanse = $dataArray['gaadi']['gaadiExpanse'] = ($gaadiDetails["expanse"]) ? $gaadiDetails["expanse"] : 0;
            $remAmount = $dataArray['gaadi']['remAmount'] =  ($gaadiDetails["remainingAmount"]) ? $gaadiDetails["remainingAmount"] : 0;

            echo "<p class='text-black'> Gaadi Name: <span class='text-orange-600 font-bold'>" . $gaadiDetails["gaadi"]["name"] . "</span></p>";
            echo "<p class='text-black'> Receiver Name : <span id='custName' class='text-orange-600 font-bold'>" . $gaadiDetails["gaadi"]["recName"] . "</span></p>";
            echo "<p class='text-black'> Gaddi ID : <span class='text-orange-600 font-bold'>" . $gaadiDetails["gaadi"]["id"] . "</span></p>";
            echo "<p class='text-black'> Date : <span class='text-orange-600 font-bold'>";
            echo $newDate = date("d-M-Y", strtotime($gaadiDetails["gaadi"]["date"]));
            echo "</span></p>";
            echo "<input type='hidden' name='gaadiId' value='" . $gaadiDetails["gaadi"]["id"] . "' >";
            echo "<input type='hidden' name='gaadiAddDate' value='" . $gaadiDetails["gaadi"]["date"] . "' >";
            ?>
          </div>
          <!-- products list  -->
          <div class="sm:col-span-2 rounded-lg bg-white text-green-600 px-2 py-1">
            <ul>
              <div class="text-black text-xl bg-gray-200 rounded px-1">Bottle list</div>
              <?php

              include("../include/connect.php");

              $j = 1;
              $sql2 = "SELECT *,gd.id as gdid, pr.price as selPrice,pr.id as productID FROM `gaadidetails` as gd
                      INNER JOIN product as pr ON gd.itemid = pr.id
                      WHERE gd.itemtype = 0 and gd.gaadid = $recId";

              $stmt2 = $conn->prepare($sql2);
              $productTotalAmount = [];
              if ($stmt2) {
                if ($stmt2->execute()) {
                  $results2 = $stmt2->get_result();
                  if ($results2->num_rows > 0) {
                    while ($row2 = $results2->fetch_assoc()) {
                      $sellingPrice = (int)$row2["selPrice"];
                      $nos = (int)$row2['nos'];
                      $totPrice = $sellingPrice * soldItemByID($row2["gdid"]);
              ?>

                      <?php
                      if ($row2["IsInScheme"] == 1) { ?>
                        <li><?php echo $row2['name']; ?> (<?php echo $row2['size']; ?> ml ): <span class="text-blue-600"><?php echo $row2['nos'] ?> Nos </span> <span class="float-right text-green-600">Price: <?php echo "FREE" ?></span></li>
                      <?php } else {
                        $productTotalAmount[] = $totPrice;

                      ?>
                        <li><?php echo $row2['name']; ?> (<?php echo $row2['size']; ?> ml ): <span class="text-blue-600"><?php echo ($row2['nos'] - soldItemByID($row2["gdid"])) ?> Nos </span>
                          <!-- hidden fields  -->
                          <input id="noss" type="hidden" name="noss" value="<?php echo $row2["nos"]; ?>">
                          <input id="petiID" type="hidden" name="petiID" value="<?php echo $row2["gdid"]; ?>">
                          <input type="hidden" name="itemtype" id="itemtype" value="<?php echo $row2['itemtype'] ?>">
                          <!-- hidden fields  -->

                          <!-- return quantity input  -->
                          <input id="ReturnQuantity" type="number" class="border-2 border-gray-600 rounded-md m-2" placeholder="Enter Sold Quantity" name="ReturnQuantity">
                          <button class="border bg-blue-600 text-white p-1 rounded-lg returnQuantitySubmit">Sold</button>

                          <span class="float-right text-red-600">
                            <?php if (soldItemByID($row2["gdid"])) {

                              //data for invoice Download 
                              $dataArray['productlist'][$j]['name'] = $row2['name'] . " (" . convertToLitre($row2['size']) . ")";
                              $dataArray['productlist'][$j]['nos'] = soldItemByID($row2["gdid"]);
                              $dataArray['productlist'][$j]['price'] = $totPrice;
                              $dataArray['productlist'][$j]['priceofOne'] = $sellingPrice;
                            ?>
                              <span class="text-green-700">Sold Value: <?php echo soldItemByID($row2["gdid"]) . " X " . $sellingPrice . " = " . $totPrice ?> ₹ </span>

                            <?php } ?>
                        </li>
                      <?php }
                      $j++;
                      ?>
                      <br>

              <?php  }
                  }
                }
              }
              ?>
              <hr>
              <li><span class="float-right text-red-600">Total Sold Value: <?php echo array_sum($productTotalAmount); ?> INR</span></li>
            </ul>
          </div>
          <!-- peti lists  -->
          <div class="sm:col-span-2 rounded-lg bg-white text-green-600 px-2 py-1">
            <div class="text-black text-xl bg-gray-200 rounded px-1">Peti list</div>
            <ul>
              <?php

              include("../include/connect.php");

              $sql4 = "SELECT gd.*, gd.id as gdid, pr.name as name , pr.size as size ,p.price as sellPrice, p.bottleNos,p.id as petiID FROM `gaadidetails` as gd
                      INNER JOIN peti as p ON gd.itemid = p.id
                      INNER JOIN product as pr ON p.product_id = pr.id
                      WHERE gd.itemtype = 1 and gd.gaadid = $recId";

              $stmt4 = $conn->prepare($sql4);

              $petiTotalAmount = [];

              if ($stmt4) {
                if ($stmt4->execute()) {
                  $results4 = $stmt4->get_result();
                  if ($results4->num_rows > 0) {
                    while ($row4 = $results4->fetch_assoc()) {
                      $sellPrice1 = (int)$row4["sellPrice"];
                      $nos1 = (int)$row4["nos"];
                      $totalPetisPrice = $sellPrice1 * soldItemByID($row4["gdid"]);

                      if ($row4["IsInScheme"] == 0) {
                        $petiTotalAmount[] = $totalPetisPrice;
              ?>

                        <li><?php echo $row4['name']; ?> <?php echo $row4['size']; ?> ml (<?php echo $row4['bottleNos'] ?> Nos): <span class="text-blue-600"><?php echo ($row4['nos'] - soldItemByID($row4["gdid"])) ?> Nos</span>

                          <input id="noss" type="hidden" name="noss" value="<?php echo $row4["nos"]; ?>">
                          <input id="ReturnQuantity" type="number" class="border-2 border-gray-600 rounded-md m-2" placeholder="Enter Sold Quantity" name="ReturnQuantity">

                          <input id="petiID" type="hidden" name="petiID" value="<?php echo $row4["gdid"]; ?>">
                          <input type="hidden" name="itemtype" id="itemtype" value="<?php echo $row4['itemtype'] ?>">

                          <button class="border bg-blue-600 text-white p-1 rounded-lg returnQuantitySubmit">Sold</button>

                          <span class="float-right text-red-600 text-sm">
                            <?php if (soldItemByID($row4["gdid"])) {

                              $dataArray['productlist'][$j]['name'] = $row4['name'] . " " . convertToLitre($row4['size']) . " (" . $row4['bottleNos'] . " Nos)";
                              $dataArray['productlist'][$j]['nos'] = soldItemByID($row4["gdid"]);
                              $dataArray['productlist'][$j]['priceofOne'] = $sellPrice1;
                              $dataArray['productlist'][$j]['price'] = $totalPetisPrice;

                            ?>
                              <span class="text-green-700">Sold Value: <?php echo soldItemByID($row4["gdid"]) . " X " . $sellPrice1 . " = " . $totalPetisPrice ?> ₹ </span>
                            <?php } ?>
                        </li>

                      <?php  } else { ?>
                        <li><?php echo $row4['name']; ?> <?php echo $row4['size']; ?> ml (<?php echo $row4['bottleNos'] ?> Nos): <span class="text-blue-600"><?php echo $row4['nos'] ?> Nos </span>
                          <span class="float-right text-green-600">Sold Value: <?php echo "FREE"; ?></span>
                        </li>
                      <?php  }
                      $j++;
                      ?>
                      <br>
                      <hr>

              <?php  }
                  }
                }
              }
              ?>
              <hr>
              <li><span class="float-right text-red-600">Total Sold Value: <?php echo array_sum($petiTotalAmount); ?> INR</span></li>
            </ul>
          </div>
        </div>

        <!-- Pay and Discount input submit START  -->
        <div class="sm:col-span-2 text-md rounded-lg bg-white text-gray-700 px-2 py-1 mb-3">
          <input type="number" name="discountINRreturn" class="bg-gray-200 border-blue-600 border-2 rounded text-black m-2 p-1" placeholder="Enter Discount Amount">
          <button class="text-sm text-white bg-blue-600 rounded-lg p-2" name="applydiscount" type="submit">Apply Discount</button><br>
          <!-- Pay Amount  -->
          <div class="ExpanseInput border-2 border-gray-600 p-2">
            <input type="number" name="payamountreturn" class="bg-gray-200 border-blue-600 border-2 rounded text-black m-2 mt-2 p-1" placeholder="Enter Amount">
            <select name="payamounttype" class="bg-gray-200 border-blue-600 border-2 rounded text-black m-2 mt-2 p-1" placeholder="Pay Amount">
              <option value="1">Cash</option>
              <option value="2">Online/Bank</option>
            </select>

            <button class="text-sm text-white bg-blue-600 rounded-lg p-2" name="payamountsubmitgaadi" type="submit">Pay Amount</button>
          </div>
          <!-- pay Expanse  -->
          <div class="ExpanseInput border-2 border-gray-600 p-2">
            <input type="number" name="payexpanse" class="bg-gray-200 border-blue-600 border-2 rounded text-black m-2 mt-2 p-1" placeholder="Enter Expanse Amount">
            <input type="text" name="expType" class="bg-gray-200 border-blue-600 border-2 rounded text-black m-2 mt-2 p-1" placeholder="Enter Expanse Type">
            <button class="text-sm text-white bg-blue-600 rounded-lg p-2" name="addExpanseSubmit" type="submit">Add Expanse ( Add खर्चा )</button>
          </div>
        </div>
        <!-- Pay and Discount input submit END  -->

        <!-- bill discount and remaining amount details START  -->
        <div class="relative overflow-x-auto" id="billdiscountpaymentdetails">
          <table class="w-full text-sm text-left rtl:text-right text-gray-500 mb-2">
            <tbody>
              <tr class="bg-white border border-gray-800">
                <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap border border-gray-800">
                  Total Sold (कुल सामान बिका):
                </th>
                <td class="px-3 py-2 text-gray-700">
                  <?php echo $totalbill = (array_sum($productTotalAmount) + array_sum($petiTotalAmount));
                  $dataArray['gaadi']['totalbill'] = $totalbill;
                  ?>
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
                  echo $amountPaidTotal;
                  ?>
                </td>
              </tr>
              <tr class="bg-white border border-gray-800">
                <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap border border-gray-800">
                  Expanse:
                </th>
                <td class="px-3 py-2 text-gray-700">
                  <?php
                  echo $Expanse;
                  ?>
                </td>
              </tr>
              <tr class="bg-white border border-gray-800">
                <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap border border-gray-800">
                  Remaining Amount (बकाया राशि) :
                </th>
                <td class="px-3 py-2 text-gray-700">
                  <?php echo $remAmount;
                  ?>
                </td>
              </tr>
              
            </tbody>
          </table>
        </div>
        <!-- bill discount and remaining amount details END  -->

        <!-- hidden Fields  -->
        <input type="hidden" name="gaadiIDD" value="<?php echo $recid; ?>">
        <input type="hidden" name="totalBill" value="<?php echo $totalbill ?>">
        <input type="hidden" name="totalbillHidden" value="<?php echo $totalbill ?>">
        <input type="hidden" name="discountHidden" value="<?php echo $discount ?>">
        <input type="hidden" name="amountPaidHidden" value="<?php echo $amountPaidTotal ?>">
        <input type="hidden" name="expanseHidden" value="<?php echo $Expanse ?>">
        <input type="hidden" name="remainingAmountHidden" value="<?php echo $remAmount ?>">
        <input type="hidden" name="person_id" value="<?php echo $gaadiDetails["gaadi"]["personId"] ?>">
        <!-- hidden Fields  -->

        <div class="flex justify-between">
          <?php
          addGaadiDetails($totalbill,$remAmount,$amountPaidTotal,$Expanse, $recId);
          ?>
          <button name="soldCloseGaadi" id="soldCloseGaadi" type="submit" class="text-white inline-flex items-center bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
            Close Gaadi
          </button>

          <button id="downloadInvoice" class="text-white inline-flex items-center bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
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