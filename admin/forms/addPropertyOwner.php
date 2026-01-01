<?php
if (isset($_GET['OwnerEditId'])) {
    $ownerid = $_GET['OwnerEditId'];
}
?>
<div id="propertyOwnerForm" class="p-4 w-full max-w-2xl md:h-auto">
    <div class="p-4 bg-gray-700 rounded-lg shadow-2xl sm:p-5 border-2 border-black">
        <!-- Modal header -->
        <div class="flex justify-center items-center pb-3 mb-3 rounded-t border-b sm:mb-5">
            <h3 class="text-lg font-semibold text-white">
                Add Property Owner ( प्रॉपर्टी के मालिक की डिटेल्स नाम डालिये   )
            </h3>
        </div>
        <!-- Modal body -->
        <form action="./queries.php" method="POST">
            <div class="grid gap-4 mb-4 sm:grid-cols-2 text-white">
                <?php
                if (isset($_GET['OwnerEditId'])) { ?>
                    <input type="hidden" name="id" id="id" value="<?php echo $ownerid; ?>">
                    <?php }
                include("../include/connect.php");
                if(isset($_GET['OwnerEditId'])){

                    $sql = "SELECT * FROM rentpropertyowner WHERE id = $ownerid";
                    
                    $stmt = $conn->prepare($sql);
                if ($stmt) {
                    if ($stmt->execute()) {
                        $results = $stmt->get_result();
                        if ($results->num_rows > 0) {
                            $row = $results->fetch_assoc();
                            $name = $row["name"];
                            $date = $row["date"];
                        }
                    }
                }
            }
                ?>
                <div class="sm:col-span-2">
                    <label for="name" class="block mb-2 text-sm font-medium">Owner Name ( मालिक का नाम )</label>
                    <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Type Owner name" required="" <?php if(isset($_GET['OwnerEditId'])){ echo "value='".$name."'"; } ?>>
                </div>

                <div class="sm:col-span-2">
            <label for="date" class="block mb-2 text-sm font-medium">Date:</label>
            <input type="date" name="date" id="date" <?php if(isset($_GET['OwnerEditId'])){ echo "value='".$date."'"; } else { echo "value='".date('Y-m-d')."'"; } ?> class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
          </div>

            </div>
            <button name="rentownersubmit" id="rentownersubmit" type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
                Add Owner
            </button>
        </form>
    </div>
</div>