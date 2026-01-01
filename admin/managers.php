<?php
include("../include/functions/session.php");
session($allowmanger = 0);
session_timeout();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Managers</title>
  <link rel="stylesheet" href="../output.css">
</head>

<body>


  <?php
  date_default_timezone_set("Asia/Calcutta");
  include_once "../include/navbar1.php"
  ?>





  <!-- alert Here -->
  <div id="alertExpanse">
    <?php
    if (isset($_GET['smessage'])) {
      $message = $_GET['smessage'];
      echo '<div class="p-3 mb-3 text-md text-green-800 rounded-sm bg-green-50 border border-gray-800" role="alert">
        <span class="font-medium">' . $message . '
        </div>';
    }
    if (isset($_GET['emessage'])) {
      $message = $_GET['emessage'];
      echo '<div class="p-3 mb-3 text-md text-red-800 rounded-sm bg-red-50 border border-gray-800" role="alert">
        <span class="font-medium">' . $message . '</div>';
    }
    ?>
  </div>
  <!-- Employess List table Here -->
  <div class="relative overflow-x-auto shadow-md">
    <table id="staffTable" class="w-full text-sm text-left text-gray-500">
      <thead class="text-xs text-gray-900 uppercase bg-[#64CCC5]">
        <tr>
        <th scope="col" colspan="5" class="px-4 py-4 bg-gray-700 text-white">
    <div class="flex justify-between">
        <div class="text-lg">Manager Table</div>
        <div class="flex items-center">
            <a class="bg-blue-500 my-0.5 mx-0.5 p-1 border rounded-md border-white" href="./addmanager.php">Add Manager</a>
        </div>
    </div>
</th>

        </tr>
        <tr>
          <th scope="col" class="px-1 py-2 border border-gray-400">
            ID
          </th>
          <th scope="col" class="px-1 py-2 border border-gray-400">
            Username
          </th>
          <th scope="col" class="px-1 py-2 border border-gray-400">
            Password
          </th>
          <th scope="col" class="px-1 py-2 border border-gray-400">
            D.O.R (YYYY-MM-DD)
          </th>

          <th scope="col" class="px-1 py-2 border border-gray-400">
            <span>Actions</span>
          </th>
        </tr>
      </thead>
      <tbody>

        <?php
        include_once "../include/connect.php";
        $sql = "SELECT * FROM user where role = 1 and delete_status = 1";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
          if ($stmt->execute()) {
            $result = $stmt->get_result(); // Get the result set

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                // You can access the columns by their names in the $row array
                $id = (int)$row['id'];
                $username = $row['username'];
                $password = $row['password'];
                $dor = $row['dor'];
        ?>

                <tr class="bg-white border-b hover:bg-gray-50 text-gray-800">
                  <th id="staffId" scope="row" class="px-4 py-2 border border-gray-400 font-medium text-gray-900 whitespace-nowrap IdClassDom">
                    <?php echo $id; ?>
                  </th>
                  <td class="px-1 py-2 border border-gray-400 font-semibold">
                      <?php echo $username; ?>
                  </td>
                  <td class="px-1 py-2 border border-gray-400">
                    <?php echo $password; ?>
                  </td>
                  <td class="px-1 py-2 border border-gray-400 font-semibold">
                    <a href="./profile.php?staffId=<?php echo $id; ?>">
                      <?php echo $dor; ?>
                    </a>
                  </td>
                  <td class="px-1 py-2 border border-gray-400">
                    <a href="./addmanager.php?updateId=<?php echo $id; ?>"><button class="text-white bg-orange-500 px-2 py-1 rounded border border-gray-800 mr-2">Edit</button></a>
                    <a id="deleteBtn" href="" value="<?php echo $id;  ?>" class="text-white bg-red-500 px-2 py-1 rounded border border-gray-800 ml-2">Delete</a>
                  </td>

                </tr>
        <?php }
            } else {
              echo "<tr><td  colspan='5' class='text-center font-bold text-gray-800 text-lg'>No Records Found</td></tr>";
            }
          } else {
            echo "Failed to execute the SQL query.";
          }
        } else {
          echo "Error preparing the SQL statement.";
        }
        ?>
      </tbody>
    </table>
  </div>






  <?php include_once "../include/footer.php";
  ?>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="../include/js/manager.js"></script>
</body>

</html>