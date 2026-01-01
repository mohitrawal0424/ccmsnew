<div class="flex justify-center items-center h-screen">
  <div id="addGaadiReceiverForm" class="hidden p-4 w-full max-w-2xl md:h-auto">
    <div class="p-4 bg-gray-700 rounded-lg shadow-2xl sm:p-5 border-2 border-black">
      <!-- Modal header -->
      <div class="flex justify-center items-center pb-3 mb-3 rounded-t border-b sm:mb-5">
        <h3 class="text-xl font-semibold text-white">
          Add Gaadi details (गाडी की डिटेल्स डालिये )
        </h3>
      </div>
      <!-- error div  -->
      <div id="errorDiv" class='text-red-400  p-2 mt-2 rounded-md text-xs hidden'> Can't be Empty</div>
      <!-- Modal body -->
      <form action="./queries.php" method="POST">
        <div class="grid gap-4 mb-4 sm:grid-cols-2 text-white">
          <!-- Gaadi Date  -->
          <div class="sm:col-span-2">
            <label for="dateofGaadi" class="block mb-2 text-sm font-medium">Date:</label>
            <input type="date" name="dateofGaadi" id="dateofGaadi" value="<?php echo date('Y-m-d'); ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Gaadi Name">
          </div>
          <!-- gaadi Name  -->
          <div class="sm:col-span-2">
            <label for="gaadiName" class="block mb-2 text-sm font-medium">Gaadi Name <span class="text-yellow-400">(optional)</span></label>
            <input type="text" name="gaadiName" id="gaadiName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Gaadi Name">
          </div>
          <!-- Gaadi Receiver Name  -->
          <div class="sm:col-span-2">
            <label for="receiverid" class="block mb-2 text-sm font-medium">Select Gaadi Receiver <span class="text-yellow-400">(example:- गाडी या माल ले जाने वाले का नाम !)</span></label>
            <select name="receiverid" id="receiverid" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Type product name" required="">
              <?php 
              include("../include/connect.php");
              $sql = "SELECT id,name FROM `person` ORDER BY name ASC";
              $stmt = $conn-> prepare($sql);
              if ($stmt) {
                // $stmt->bind_param("i", $managerId);
                if ($stmt->execute()) {
                  $result = $stmt->get_result(); // Get the result set
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      
                      echo '<option value="'.$row['id'].'">'.$row['name'] .'</option>';
                    }
                  }
                } else {
                  echo '<option value="">None</option>';
                }
              } 
              ?>
            </select>
          </div>
          <!-- Gaadi creater ID/Loggedin user  -->
          <input type="hidden" value="<?php echo $_SESSION["id"]; ?>" name="createdBy">
          <!-- submit btn  -->
          <button name="submitReceiver" id="submitReceiver" type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
            Create Gaadi
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
