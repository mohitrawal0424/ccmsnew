<!-- Add Customer form -->
<?php
    if(isset($_GET['expanseEditId'])){
        $updateId = (int)$_GET['expanseEditId'];

        include_once "../include/connect.php";
        $sql = "SELECT * FROM expanse where id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("i", $updateId);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    
                    $id = $row['id'];
                    $dor = $row['dor'];
                    $expType = $row['expType'];
                    $amount = $row['amount'];
                }
                
            }
        }
    }
?>

<section class="bg-white">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-2 text-xl font-bold text-gray-900"></h2>
            <form action="./queries.php" method="POST">
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                   <!--  hidden id --> 
                   <input type="hidden" name="id" value="<?php if(isset($_GET['expanseEditId'])){ echo $id; }?>">
                    <!--  dor -->
                    <div class="sm:col-span-2">
                        <label for="dor" class="block mb-1 text-sm font-medium text-gray-900">Date</label>
                        <input type="date" name="dor" id="dor" value="<?php if(isset($_GET['expanseEditId'])){ echo $dor; } else {echo date("Y-m-d");} ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2" required="">
                    </div>
                    <!--  Expanse Type -->
                    <div class="sm:col-span-2">
                        <label for="expType" class="block mb-1 text-sm font-medium text-gray-900">Expanse Type ( खर्चा का प्रकार )</label>
                        <input type="text" name="expType" value="<?php if(isset($_GET['expanseEditId'])){ echo $expType; } ?>" id="expType" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2" required="">
                    </div>
                    <!--  Amount -->
                    <div class="sm:col-span-2">
                        <label for="amount" class="block mb-1 text-sm font-medium text-gray-900">Amount</label>
                        <input type="number" name="amount" id="amount" value="<?php if(isset($_GET['expanseEditId'])){ echo $amount; } ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2" placeholder="Enter Amount" required="">
                    </div>
                </div>
                <button type="submit" name="addExpanseSubmit" class="inline-flex items-center px-5 py-2 mt-3 sm:mt-6 text-sm font-medium text-center text-white bg-black rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-gray-800">
                    Add Expanse
                </button>
            </form>
        </div>
    </section>