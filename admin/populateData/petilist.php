<!-- Bottle List -->
<div class="overflow-x-auto border-2 border-black">
                <table id="petilisttable" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
                      <tr class="text-white bg-blue-400 text-center text-xl border-2 border-gray-800">
                        <th colspan="7" class="p-4">Peti List</th>
                      </tr>
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-500">S. No.</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">ID</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Name</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Size/Quantity of Bottle</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Buying Price</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Selling Price</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php 

                      include("../include/connect.php");
                      include("../include/functions/getProductPeti.php");

                      $sql = "SELECT p.*,pr.name,pr.size FROM peti as p
                      JOIN product as pr ON p.product_id = pr.id";
                      
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
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["name"]." (".convertToLitre($row['size']).")" ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["bottleNos"] ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["bprice"] ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["price"] ?></td>
                              
                              <td class="px-4 py-3 border">
                                <a href="./products.php?peti=1&petiid=<?php echo $row["id"]; ?>" value="<?php echo $row["id"] ?>" class="text-white bg-red-700 rounded-lg p-1 px-4 petideleteclass">Delete</a>
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