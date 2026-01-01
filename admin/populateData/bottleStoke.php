<!-- bottle stokes  -->
<div class="overflow-x-auto border-2 border-black">
  <table id="bottlestoketable" class="w-full text-sm text-left text-gray-500">
    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
      <tr class="text-white bg-blue-400 text-center text-xl border-b-2 border-gray-800">
        <th colspan="6" class="p-4">Bottle Stoke Table</th>
      </tr>
      <tr>
        <th scope="col" class="px-4 py-3 border border-gray-500">Product name</th>
        <th scope="col" class="px-4 py-3 border border-gray-500">Units</th>
        <th scope="col" class="px-4 py-3 border border-gray-500">Units</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT
                      SUM(CASE WHEN s.stoketype = 1 THEN s.nos ELSE 0 END) AS addedSum,
                      SUM(CASE WHEN s.stoketype = 2 THEN s.nos ELSE 0 END) AS removedSum,
                      pr.name,pr.size,pr.id as bottleID FROM `stokes` as s
                      INNER JOIN product as pr ON s.itemid = pr.id
                      WHERE itemtype = 0 GROUP BY itemid";

      $stmt = $conn->prepare($sql);
      if ($stmt) {
        if ($stmt->execute()) {
          $results = $stmt->get_result();
          if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) { ?>

              <tr class="border">
                <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row['name'] ?> <?php echo convertToLitre($row['size']); ?></td>
                <td class="px-4 py-3 border"><?php echo $row['addedSum'] - $row["removedSum"] ?></td>
                <td class="px-4 py-3 border">
                  <input class="border border-gray-900 rounded quantityinput" type="number" name="enterStoke" id="enterStoke" placeholder="Enter Quantity">
                  <a href="#" data-stokeType="1" value="<?php echo $row["bottleID"] ?>" class="text-white bg-blue-700 rounded-lg p-1 px-4 addstokeClass">Add</a>
                  <a href="#" data-stokeType="2" value="<?php echo $row["bottleID"] ?>" class="text-white bg-orange-700 rounded-lg p-1 px-4 removestokeClass">Remove</a>
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