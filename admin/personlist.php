<?php
include("../include/functions/session.php");
session();
session_timeout();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff</title>
    <link rel="stylesheet" href="../output.css">
</head>

<body>
    <?php
    date_default_timezone_set("Asia/Calcutta");
    include_once "../include/navbar2.php"
    ?>

    <?php
        include_once "../include/connect.php";
        $sql = "SELECT 
    p.id,
    p.name,
    SUM(g.remaining_amount) AS total_remaining
FROM gaadis g
JOIN person p ON g.receiverid = p.id
GROUP BY p.id, p.name";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            if ($stmt->execute()) {
                $result = $stmt->get_result();
        
                
            }
        }
    
    ?>

    <!-- Bottle List -->
<div class="overflow-x-auto border-2 border-black">
                <table id="petilisttable" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-100 border-b border-gray-500">
                      <tr class="text-white bg-blue-400 text-center text-xl border-2 border-gray-800">
                        <th colspan="7" class="p-4">Remaining Amount List</th>
                      </tr>
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-500">S. No.</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Person ID</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Name</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Remaining amount</th>
                            <th scope="col" class="px-4 py-3 border border-gray-500">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                      <?php 

                      include("../include/connect.php");

                      $sql = "SELECT 
                    p.id,
                    p.name,
                    SUM(g.remaining_amount) AS total_remaining
                    FROM gaadis g
                    JOIN person p ON g.receiverid = p.id
                    GROUP BY p.id, p.name";
                      
                      $stmt = $conn -> prepare($sql);
                      if($stmt){
                        if($stmt->execute()){
                          $results = $stmt->get_result();
                          if ($results->num_rows > 0) {
                          $i = 1;
                            while ($row = $results->fetch_assoc()) { 
                               
                                ?>
                              <tr class="border">
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $i++; ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["id"]; ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["name"]; ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border"><?php echo $row["total_remaining"]; ?></td>
                              <td scope="row" class="px-4 py-3 text-gray-600 whitespace-nowrap border">
                              <a href="./loadGaadi.php?receiverPerson=<?php echo $row["id"]; ?>" value="<?php echo $row["id"] ?>" class="text-white bg-blue-700 rounded-lg p-1 px-4">All Gaddis</a>
                              </td>                              
                              </tr>            
                            
                          <?php  }
                          }
                        }
                      }
                        ?>
             
                    </tbody>
                </table>
            </div>

<!--  -->

    <?php
    include_once "../include/footer.php"
    ?>
</body>

</html>