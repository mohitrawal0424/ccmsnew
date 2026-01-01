<div class="overflow-x-auto border-2 border-black">
                <table id="petistoketable" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
                      <tr class="text-white bg-blue-400 text-center text-xl border-2 border-gray-800">
                        <th colspan="6" class="p-4">Defect पेटी Stoke Table</th>
                      </tr>
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Product name</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Units</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                      
                      <?php 

                      include("../include/connect.php");

                      $sql = "SELECT
                      SUM(CASE WHEN s.stoketype = 1 THEN s.nos ELSE 0 END) AS addedSum,
                      SUM(CASE WHEN s.stoketype = 2 THEN s.nos ELSE 0 END) AS removedSum,
                      p.bottleNos, pr.name,pr.size FROM `defectstokes` as s
                      INNER JOIN peti as p ON s.itemid= p.id
                      INNER JOIN product as pr ON p.product_id=pr.id
                      WHERE itemtype = 1 GROUP BY itemid";
                      
                      $stmt = $conn -> prepare($sql);
                      if($stmt){
                        if($stmt->execute()){
                          $results = $stmt->get_result();
                          if ($results->num_rows > 0) {
                            while ($row = $results->fetch_assoc()) { ?>
                              
                              <tr class="border">
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row['name'] ?> <?php  echo convertToLitre($row['size']); ?>  <span class="text-blue-600 font-bold">( <?php echo $row['bottleNos'] ?> piece वाली पेटी)</span></td>
                              <td class="px-4 py-3 border"><?php echo $row['addedSum'] - $row["removedSum"] ?></td>
                              </tr>            
                            
                          <?php  }
                          }
                        }
                      }
                        ?>
             
                    </tbody>
                </table>
            </div>