<!-- peti stokes -->
<div class="overflow-x-auto border-2 border-black">
    <table id="petistoketable" class="w-full text-sm text-left text-gray-500">
      <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
        <tr class="text-white bg-blue-400 text-center text-xl border-2 border-gray-800">
          <th colspan="6" class="p-4">Stokes History</th>
        </tr>
        <tr>
          <th scope="col" class="px-4 py-3 border border-gray-500">S.No</th>
          <th scope="col" class="px-4 py-3 border border-gray-500">Name</th>
          <th scope="col" class="px-4 py-3 border border-gray-500">Item Type</th>
          <th scope="col" class="px-4 py-3 border border-gray-500">Stoke Type</th>
          <th scope="col" class="px-4 py-3 border border-gray-500">Quantity</th>
          <th scope="col" class="px-4 py-3 border border-gray-500">Date and Time</th>

        </tr>
      </thead>
      <tbody>

        <?php
        $sql = "SELECT * FROM `stokes` ORDER BY `stokes`.`id` DESC";
        $sno = 1;
        $stmt = $conn->prepare($sql);
        if ($stmt) {
          if ($stmt->execute()) {
            $results = $stmt->get_result();
            if ($results->num_rows > 0) {
              while ($row = $results->fetch_assoc()) { 
                ?>
                <tr class="border">
                  <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $sno++ ?></td>
                    <td class="px-4 py-3 border">
                    <?php
                    if ($row['itemtype'] == 0) {
                      $productdetails = getProductName($row['itemid']);
                      echo $productdetails['name'] . " " . convertToLitre($productdetails['size']);
                    } elseif ($row['itemtype'] == 1) {
                      $petidetails = getPetiName($row['itemid']);
                      echo $petidetails['name'] . " " . convertToLitre($petidetails['size']) . " - (" . $petidetails['bottleNos'] . " Bottles)";
                    } ?>
                    </td>
                    <td class="px-4 py-3 border">
                    <?php
                    if ($row['itemtype'] == 0) {
                      echo "Bottle";
                    } elseif ($row['itemtype'] == 1) {
                      echo "Peti";
                    } ?>
                    </td>

                    <td class="px-4 py-3 border">
                    <?php
                    if ($row['stoketype'] == 1) {
                      echo "Added";
                    } elseif ($row['stoketype'] == 2) {
                      echo "Removed";
                    } ?>
                    </td>
                    <td class="px-4 py-3 border"><?php echo $row['nos'] ?></td>
                    <td class="px-4 py-3 border"><?php echo date('d-M-Y H:i:s', strtotime($row['timestamp'])) ?></td>
                   
                  </tr>

              <?php  }
                }
                }
        }
        ?>

      </tbody>
    </table>
  </div>