<?php
if (isset($_GET['bottleid'])) {
    $bottleid = $_GET['bottleid'];
}
?>
<div id="bottlesizeform" class="p-4 w-full max-w-2xl md:h-auto">
    <div class="p-4 bg-gray-700 rounded-lg shadow-2xl sm:p-5 border-2 border-black">
        <!-- Modal header -->
        <div class="flex justify-center items-center pb-3 mb-3 rounded-t border-b sm:mb-5">
            <h3 class="text-xl font-semibold text-white">
                Add Bottle Size
            </h3>
        </div>
        <!-- error div  -->
        <div id="errorDiv" class='text-red-400  p-2 mt-2 rounded-md text-xs hidden'> Category Name Can't be Empty</div>
        <!-- Modal body -->
        <form action="#">
            <div class="grid gap-4 mb-4 sm:grid-cols-2 text-white">
                <?php
                if (isset($_GET['bottleid'])) { ?>
                    <input type="hidden" name="id" id="id" value="<?php echo $bottleid; ?>">
                    <?php }

                include("../include/connect.php");
                include("../include/functions/getProductPeti.php");
                if(isset($_GET['bottleid'])){

                    $sql = "SELECT * FROM product WHERE id = $bottleid";
                    
                    $stmt = $conn->prepare($sql);
                if ($stmt) {
                    if ($stmt->execute()) {
                        $results = $stmt->get_result();
                        if ($results->num_rows > 0) {
                            $row = $results->fetch_assoc();
                            $bottlename = $row["name"];
                            $bottlesize = $row["size"];
                            $bottlebprice = $row["bprice"];
                            $bottlesprice = $row["price"];

                        }
                    }
                }
            }
                ?>
                <div class="sm:col-span-2">
                    <label for="name" class="block mb-2 text-sm font-medium">Product Name<span class="text-yellow-400">(example:- Cocacola, Sprite)</span></label>
                    <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Type product name" required="" <?php if(isset($_GET['bottleid'])){ echo "value='".$bottlename."'";} ?>>
                </div>

                <div class="sm:col-span-2">
                    <label for="size" class="block mb-2 text-sm font-medium">Size <span class="text-yellow-400">(कृपया साइज ml में डालना )(example:-200ml, 1500ml)</span></label>
                    <input type="number" name="size" id="size" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Enter size in ml" required="" <?php if(isset($_GET['bottleid'])){ echo "value='".$bottlesize."'"; echo "readonly";} ?>>
                </div>

                <div class="sm:col-span-2">
                    <label for="bprice" class="block mb-2 text-sm font-medium">Buying Price</label>
                    <input type="float" name="bprice" id="bprice" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Price" required=""
                    <?php if(isset($_GET['bottleid'])){ echo "value='".$bottlebprice."'"; echo "readonly";} ?>>
                </div>

                <div class="sm:col-span-2">
                    <label for="price" class="block mb-2 text-sm font-medium">Selling Price</label>
                    <input type="float" name="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Price" required=""
                    <?php if(isset($_GET['bottleid'])){ echo "value='".$bottlesprice."'"; echo "readonly";} ?>>
                </div>
            </div>
            <button name="productsubmit" id="productsubmit" type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
                Add
            </button>
        </form>
    </div>
</div>