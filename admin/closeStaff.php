<?php
include("../include/functions/session.php");
session();
session_timeout();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff</title>
    <link rel="stylesheet" href="../output.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body>
<?php
    date_default_timezone_set("Asia/Calcutta");
    include_once "../include/navbar1.php"
?>


    <!--  Close Employess List table Here -->
    <div class="relative overflow-x-auto shadow-md">
        <table id="closeStaffTable" class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-900 uppercase bg-[#64CCC5]">
                <tr>
                    <th scope="col" colspan="9" class="text-lg px-4 py-4 bg-gray-700 text-white text-center">
                        Closed Staff Table
                    </th>
                </tr>
                <tr>
                    <th scope="col" class="px-1 py-2 border border-gray-400">
                        ID
                    </th>
                    <th scope="col" class="px-1 py-2 border border-gray-400">
                        Name
                    </th>
                    <th scope="col" class="px-1 py-2 border border-gray-400">
                        F.Name
                    </th>
                    <th scope="col" class="px-1 py-2 border border-gray-400">
                    D.O.R (YYYY-MM-RR)
                    </th>
                    <th scope="col" class="px-1 py-2 border border-gray-400">
                        Salary
                    </th>
                    <th scope="col" class="px-1 py-2 border border-gray-400">
                        Aadhar No.
                    </th>
                    <th scope="col" class="px-1 py-2 border border-gray-400">
                        <span>Date of Close</span>
                    </th>
                    <th scope="col" class="px-1 py-2 border border-gray-400">
                        <span>Remaining Balance</span>
                    </th>
                    
                </tr>
            </thead>
            <tbody>

            <?php
            include_once "../include/connect.php";
            $sql = "SELECT * FROM staff where delete_status = 1 and status = 0 ";
            $stmt = $conn->prepare($sql);
        
            if ($stmt) {
                if ($stmt->execute()) {
                    $result = $stmt->get_result(); // Get the result set
            
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // You can access the columns by their names in the $row array
                            $id = (int)$row['id'];
                            $dor = $row['dor'];
                            $name = $row['name'];
                            $fname = $row['fname'];
                            $salary = (int)$row['salary'];
                            $aadhar = $row['aadhar'];
                            $doc = $row['doc'];
                     ?>

                    <tr class="bg-white border-b hover:bg-gray-50 text-gray-800">
                    <th id="staffId" scope="row" class="px-4 py-2 border border-gray-400 font-medium text-gray-900 whitespace-nowrap IdClassDom">
                        <?php echo $id; ?>
                    </th>
                    <td class="px-1 py-2 border border-gray-400 font-semibold">
                        <a href="./profile.php?staffId=<?php echo $id; ?>">
                            <?php echo $name; ?>
                        </a>
                    </td>
                    <td class="px-1 py-2 border border-gray-400">
                    <?php echo $fname; ?>
                    </td>
                    <td class="px-1 py-2 border border-gray-400 DOJClassDom">
                    <?php 
                    $dateJoining = new DateTime($dor);
                    echo $dateJoining->format('d-M-Y');
                    ?>
                    </td>
                    <td class="px-1 py-2 border border-gray-400">
                    <?php echo $salary; ?>
                    </td>
                    <td class="px-1 py-2 border border-gray-400">
                    <?php echo $aadhar; ?>
                    </td>
                    <td class="px-1 py-2 border border-gray-400">
                    <?php 
                    $dateClosing = new DateTime($doc);
                    echo $dateClosing->format('d-M-Y');
                    ?>
                    </td>
                    <td class="px-1 py-2 border border-gray-400">
                    <?php 
                    include_once("../include/functions/remBalance.php");
                    echo $remBalance = remBalance($id,$salary,$dor,$doc);
                    ?>
                    </td>
            
                    
                </tr>       
                        <?php }
                    } else {
                        echo "No records found.";
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
    <?php include_once "../include/footer.php" ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/0ef3c59d0f.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <script>
        let table = new DataTable('#closeStaffTable');
    </script>
</body>

</html>