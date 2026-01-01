<?php
if (isset($_GET['propertyEditId'])) {
    $propertyid = $_GET['propertyEditId'];
}
?>
<div id="addpropertyForm" class="p-4 w-full max-w-2xl md:h-auto">
    <div class="p-4 bg-gray-700 rounded-lg shadow-2xl sm:p-5 border-2 border-black">
        <!-- Modal header -->
        <div class="flex justify-center items-center pb-3 mb-3 rounded-t border-b sm:mb-5">
            <h3 class="text-lg font-semibold text-white">
                Add Property Details ( प्रॉपर्टी की डिटेल्स डालिये   )
            </h3>
        </div>
        <!-- Modal body -->
        <form action="./queries.php" method="POST">
            <div class="grid gap-4 mb-4 sm:grid-cols-2 text-white">
                <?php
                if (isset($_GET['propertyEditId'])) { ?>
                    <input type="hidden" name="id" id="id" value="<?php echo $propertyid; ?>">
                    <?php }

                if(isset($_GET['propertyEditId'])){

                    $sql = "SELECT * FROM rentedproperty WHERE id = $propertyid";
                    
                    $stmt = $conn->prepare($sql);
                if ($stmt) {
                    if ($stmt->execute()) {
                        $results = $stmt->get_result();
                        if ($results->num_rows > 0) {
                            $row = $results->fetch_assoc();
                            $name = $row["name"];
                            $owner = $row["owner_id"];
                            $date = $row["date"];
                        }
                    }
                }
            }
                ?>
                <!-- date  -->
                <div class="sm:col-span-2">
                <label for="date" class="block mb-2 text-sm font-medium">Date:</label>
                <input type="date" name="date" id="date" <?php if(isset($_GET['propertyEditId'])){ echo "value='".$date."'"; }else{ echo "value='".date('Y-m-d')."'"; } ?> class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
              </div>
              <!-- name  -->
                <div class="sm:col-span-2">
                    <label for="name" class="block mb-2 text-sm font-medium">Property Name ( प्रॉपर्टी का नाम )</label>
                    <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Type property name" required="" <?php if(isset($_GET['propertyEditId'])){ echo "value='".$name."'";} ?>>
                </div>
                <!-- property owner  -->
                <div class="sm:col-span-2">
                        <label for="owner" class="block mb-2 text-sm font-medium">Select Property Owner ( प्रॉपर्टी के मालिक को चुनिए ) </label>
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


            </div>
            <button name="rentpropertysubmit" id="rentpropertysubmit" type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
                Add Property
            </button>
        </form>
    </div>
</div>