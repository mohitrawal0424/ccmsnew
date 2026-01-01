<?php
if (isset($_GET['advanceEditId'])) {
    $advanceid = $_GET['advanceEditId'];
}
?>
<div id="addAdvanceForm" class="p-4 w-full max-w-2xl md:h-auto">
    <div class="p-4 bg-gray-700 rounded-lg shadow-2xl sm:p-5 border-2 border-black">
        <!-- Modal header -->
        <div class="flex justify-center items-center pb-3 mb-3 rounded-t border-b sm:mb-5">
            <h3 class="text-lg font-semibold text-white">
                Add Advance
            </h3>
        </div>
        <!-- Modal body -->
        <form action="./queries.php" method="POST">
            <div class="grid gap-4 mb-4 sm:grid-cols-2 text-white">
                <?php
                if (isset($_GET['advanceEditId'])) { ?>
                    <input type="hidden" name="id" id="id" value="<?php echo $advanceid; ?>">
                    <?php }

                if(isset($_GET['advanceEditId'])){

                    $sql = "SELECT * FROM rentadvance WHERE id = $advanceid";
                    
                    $stmt = $conn->prepare($sql);
                if ($stmt) {
                    if ($stmt->execute()) {
                        $results = $stmt->get_result();
                        if ($results->num_rows > 0) {
                            $row = $results->fetch_assoc();
                            $owner = $row['ownerid'];
                            $amount = $row['amount'];
                            $date = $row['date'];
                        }
                    }
                }
            }
                ?>
                <!-- date  -->
                <div class="sm:col-span-2">
                <label for="date" class="block mb-2 text-sm font-medium">Date:</label>
                <input type="date" name="date" id="date" <?php if(isset($_GET['advanceEditId'])){ echo "value='".$date."'"; }else{ echo "value='".date('Y-m-d')."'"; } ?> class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
              </div>
                <!-- property owner  -->
                <div class="sm:col-span-2">
                        <label for="owner" class="block mb-2 text-sm font-medium">Select Owner ( मालिक को चुनिए ) </label>
                        <select name="owner" id="owner" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                        <?php 
                            
                            $sql = "SELECT * FROM `rentpropertyowner` ORDER BY name ASC";
                            $stmt = $conn-> prepare($sql);
                            if ($stmt) {
                                if ($stmt->execute()) {
                                    $result = $stmt->get_result(); // Get the result set
                                    if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) { 
                                                $selected = '';
                                            if($row['id'] == $owner){
                                            $selected = 'selected';
                                            }    
                                                ?>
                                                
                                            <option value="<?php echo $row['id'] ?>" <?php echo $selected; ?> ><?php echo $row['name']; ?></option>
                                            <?php }
                                    }
                                } else {
                                    echo '<option value="">Something Wrong</option>';
                                }
                            } 
                            ?>
                        </select>
                </div>
                <!-- amount  -->
                <div class="sm:col-span-2">
                    <label for="amount" class="block mb-2 text-sm font-medium">Amount</label>
                    <input type="number" name="amount" id="amount" <?php if(isset($_GET['advanceEditId'])){ echo "value='".$amount."'"; } ?> class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Enter Amount" required="">
                </div>


            </div>
            <button name="advancesubmitowner" id="advancesubmitowner" type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
                Add Advance
            </button>
        </form>
    </div>
</div>