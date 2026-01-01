<div id="bottlesetform" class="p-4 w-full max-w-2xl md:h-auto">
<div class="p-4 bg-gray-700 rounded-lg shadow-2xl sm:p-5 border-2 border-black">
            <!-- Modal header -->
            <div class="flex justify-center items-center pb-3 mb-3 rounded-t border-b sm:mb-5">
                <h3 class="text-xl font-semibold text-white">
                    Add  पेटी size 
                </h3>
            </div>
            <!-- error div  -->
           <div id="errorDiv" class='text-red-400  p-2 mt-2 rounded-md text-xs hidden'> Can't be Empty</div>
            <!-- Modal body -->
            <form action="#">
            <div class="grid gap-4 mb-4 sm:grid-cols-2 text-white">

                    <div class="sm:col-span-2">
                        <label for="productId" class="block mb-2 text-sm font-medium">Select Product<span class="text-yellow-400">(example:- Cocacola, Sprite)</span></label>
                        <select name="productId" id="productId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Type product name" required="">

                            <?php 
                            include("../include/connect.php");
                            $sql = "SELECT * FROM `product` ORDER BY name ASC";
                            $stmt = $conn-> prepare($sql);
                            if ($stmt) {
                                if ($stmt->execute()) {
                                    $result = $stmt->get_result(); // Get the result set
                                    if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                
                                                echo '<option value="'.$row['id'].'">'.convertToLitre($row['size']) .' ' . $row['name'] .'</option>';
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
                        <label for="bottleNos" class="block mb-2 text-sm font-medium">No. of Bottles in One set <span class="text-yellow-400">( एक बॉक्स में कितनी बोतल आती है ! )</span></label>
                        <input type="number" name="bottleNos" id="bottleNos" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Enter bottle nos." required="">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="bpriceSet" class="block mb-2 text-sm font-medium">Buying Price of Box/Set</label>
                        <input type="float" name="bpriceSet" id="bpriceSet" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Price" required="">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="priceSet" class="block mb-2 text-sm font-medium">Selling Price of Box/Set</label>
                        <input type="float" name="priceSet" id="priceSet" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Price" required="">
                    </div>
                </div>
                <button name="petisubmit" id="petisubmit" type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
                    Add
                </button>
            </form>
        </div>
</div>