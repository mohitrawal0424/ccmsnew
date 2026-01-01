
<div id="schemeForm" class="hidden p-4 w-full max-w-2xl md:h-auto">
<div class="p-4 bg-gray-700 rounded-lg shadow-2xl sm:p-5 border-2 border-black">
            <!-- Modal header -->
            <div class="flex justify-center items-center pb-3 mb-3 rounded-t border-b sm:mb-5">
                <h3 class="text-xl font-semibold text-white">
                    Add Bottle Stokes
                </h3>
            </div>
            <!-- error div  -->
           <div id="errorDiv" class='text-red-400  p-2 mt-2 rounded-md text-xs hidden'> Can't be Empty</div>
            <!-- Modal body -->
            <form action="./queries.php" method="POST">
            <div class="grid gap-4 mb-4 sm:grid-cols-2 text-white">


                <!-- scheme-from  -->
                    <div class="sm:col-span-2">
                        <label for="schemeStartDate" class="block mb-2 text-sm font-medium">Scheme Start Date </label>
                        <input type="date" name="schemeStartDate" id="schemeStartDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Enter Date" value="<?php echo date('Y-m-d') ?>" required="">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="schemeEndDate" class="block mb-2 text-sm font-medium">Scheme End Date</label>
                        <input type="date" name="schemeEndDate" id="schemeEndDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Enter Date">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="fromScheme" class="block mb-2 text-sm font-medium">Select Scheme on Bottle/Peti <span class="text-green-400">(जिस बोतल/पति पर स्कीम देनी है वो चुनिए ) </span></label>
                        <select name="fromScheme" id="fromScheme" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Type product name" required="">
                        <?php 
                            include("../include/connect.php");
                            
                            $sql = "SELECT id as ids, name, size, NULL as bottleNos, 0 as itemType FROM `product`
                            UNION
                            SELECT p.id as ids, pr.name, pr.size, p.bottleNos, 1 as itemType 
                            FROM `peti` as p INNER JOIN product as pr ON p.product_id = pr.id";
                            $stmt = $conn-> prepare($sql);
                            if ($stmt) {
                                // $stmt->bind_param("i", $managerId);
                                if ($stmt->execute()) {
                                    $result = $stmt->get_result(); // Get the result set
                                    if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                if($row['itemType'] == 0){
                                                    echo '<option value="'.$row['ids'].'-'.$row['itemType'].'">'.$row['name'] .' ' . $row['size'].'ml (Bottle)</option>';
                                                } elseif ($row['itemType'] == 1){ ?>
                                                    <option value="<?php echo $row['ids'].'-'.$row['itemType']; ?>"> <?php echo $row['name'] ?> <?php  echo $row['size'] ?> ml  <span class="text-blue-600 font-bold">( <?php echo $row['bottleNos'] ?>nos)(Peti)</span></option>
                                               <?php }
                                            }
                                    }
                                } else {
                                    echo '<option value="">Something Wrong</option>';
                                }
                            } 
                            ?>
                        </select>
                    </div>
    
                    <div class="sm:col-span-2">
                        <label for="fromitem" class="block mb-2 text-sm font-medium">Quantity of Bottle/Peti <span class="text-green-400"> (जितने बोतल/पेटी पर स्कीम देनी है वो डालिये ) </span></label>
                        <input type="number" name="fromitem" id="fromitem" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Enter Units" required="">
                    </div>
                    <!-- scheme-to  -->
                    <div class="sm:col-span-2">
                        <label for="toScheme" class="block mb-2 text-sm font-medium">Select Scheme on Bottle/Peti <span class="text-yellow-400">( जिस प्रोडक्ट/पेटी को स्कीम में देना है  ) </span></label>
                        <select name="toScheme" id="toScheme" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Type product name" required="">
                        <?php 
                            include("../include/connect.php");
                            
                            $sql = "SELECT id as ids, name, size, NULL as bottleNos, 0 as itemType FROM `product`
                            UNION
                            SELECT p.id as ids, pr.name, pr.size, p.bottleNos, 1 as itemType 
                            FROM `peti` as p INNER JOIN product as pr ON p.product_id = pr.id";
                            $stmt = $conn-> prepare($sql);
                            if ($stmt) {
                                // $stmt->bind_param("i", $managerId);
                                if ($stmt->execute()) {
                                    $result = $stmt->get_result(); // Get the result set
                                    if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                if($row['itemType'] == 0){
                                                    echo '<option value="'.$row['ids'].'-'.$row['itemType'].'">'.$row['name'] .' ' . $row['size'].'ml (Bottle)</option>';
                                                } elseif ($row['itemType'] == 1){ ?>
                                                    <option value="<?php echo $row['ids'].'-'.$row['itemType']; ?>"> <?php echo $row['name'] ?> <?php  echo $row['size'] ?> ml  <span class="text-blue-600 font-bold">( <?php echo $row['bottleNos'] ?>nos)(Peti)</span></option>
                                               <?php }
                                            }
                                    }
                                } else {
                                    echo '<option value="">Something Wrong</option>';
                                }
                            } 
                            ?>
                        </select>
                    </div>
    
                    <div class="sm:col-span-2">
                        <label for="toitem" class="block mb-2 text-sm font-medium">Quantity of Bottle/Peti <span class="text-yellow-400"> ( जितनी बोतल/पेटी स्कीम में देनी है  ) </span></label>
                        <input type="number" name="toitem" id="toitem" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Enter Units" required="">
                    </div>
                </div>
                <button name="schemesubmit" id="schemesubmit" type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
                    Add Scheme
                </button>
            </form>
        </div>
</div>