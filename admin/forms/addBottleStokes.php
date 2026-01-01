<div id="bottlestokesform" class="p-4 w-full max-w-2xl md:h-auto">
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
            <form action="#">
            <div class="grid gap-4 mb-4 sm:grid-cols-2 text-white">

                    <div class="sm:col-span-2">
                        <label for="productIdS" class="block mb-2 text-sm font-medium">Select Product </label>
                        <select name="productIdS" id="productIdS" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Type product name" required="">
                        <?php 
                            include("../include/connect.php");
                            
                            $sql = "SELECT * FROM `product` ORDER BY name ASC";
                            $stmt = $conn-> prepare($sql);
                            if ($stmt) {
                                // $stmt->bind_param("i", $managerId);
                                if ($stmt->execute()) {
                                    $result = $stmt->get_result(); // Get the result set
                                    if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) { ?>
                                                
                                            <option value="<?php echo $row['id'] ?>" ><?php echo convertToLitre($row['size']) ?> <?php echo $row['name']; ?> ( S.Price : <?php echo $row["price"] ?> INR)</option>
                                            <?php }
                                    }
                                } else {
                                    echo '<option value="">Something Wrong</option>';
                                }
                            } 
                            ?>
                        </select>
                    </div>
    
                    <div class="sm:col-span-2">
                        <label for="unitsBottle" class="block mb-2 text-sm font-medium">Quantity of Bottle</label>
                        <input type="number" name="unitsBottle" id="unitsBottle" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Enter Units" required="">
                    </div>

                    <!-- <div class="sm:col-span-2">
                        <label for="defBottle" class="block mb-2 text-sm font-medium">Leakage/Defected Bottle</label>
                        <input type="number" name="defBottle" id="defBottle" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Enter Defect/Leakage Units" required="">
                    </div> -->
                </div>
                <button name="stokeBottlesubmit" id="stokeBottlesubmit" type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
                    Add
                </button>
            </form>
        </div>
</div>