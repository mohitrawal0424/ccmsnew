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
                    <th scope="col" colspan="6" class="text-lg px-4 py-4 bg-gray-700 text-white text-center">
                        Staff Table
                    </th>
                    <th scope="col" class="text-lg px-1 py-2 bg-gray-700 text-white border border-gray-400">
                        <div class="bg-blue-500 my-0.5 mx-0.5 p-1 border rounded-md border-white text-center">
                            <a href="addStaff.php">Add Staff</a>
                        </div>
                    </th>
                    <th scope="col" class="text-lg px-1 py-2 bg-gray-700 text-white border border-gray-400">
                        <!-- <div class="bg-blue-500 my-0.5 mx-0.5 p-1 border rounded-md border-white text-center"> -->
                            <a href="addStaff.php">Select Date:-></a>
                        <!-- </div> -->
                    </th>
                    <th scope="col" class="text-lg px-1 py-2 bg-gray-700 text-gray-700 border border-gray-400">
                        <div class="text-center">
                            <form method="GET" action="./queries.php">
                                <input class="rounded-lg px-3" type="date" name="attendanceDate" id="attendanceDate" value="<?php 
                                if(isset($_GET['datequery'])){
                                    echo $_GET['datequery'];
                                }else{
                                    echo date("Y-m-d");
                                }
                                ?>">
                                <button class="bg-blue-500 rounded-lg text-white px-2 font-normal" name="submitDate" type="submit">Submit</button>
                            </form>
                        </div>
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
                        <span>Actions</span>
                    </th>
                    <th scope="col" class="px-1 py-2 border border-gray-400">
                        <span>Current Status</span>
                    </th>
                    <th scope="col" class="px-1 py-2 border border-gray-400">
                        <span>Attendence</span>
                    </th>
                </tr>
            </thead>
            <tbody>

            <?php
            include_once "../include/connect.php";
            $sql = "SELECT * FROM staff where delete_status = 1 and status = 1 ";
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
                            <?php if($role === 0 ){  ?>
                        <a href="./addStaff.php?updateId=<?php echo $id; ?>"><button class="text-white bg-orange-500 px-2 py-1 rounded border border-gray-800 mr-2">Edit</button></a>
                        <a id="deleteBtn" href="" value="<?php echo $id;  ?>" class="text-white bg-red-500 px-2 py-1 rounded border border-gray-800 ml-2">Delete</a>
                        <a id="closeBtn" href="" value="<?php echo $id;  ?>" class="text-white bg-yellow-500 px-2 py-1 rounded border border-gray-800 ml-2">Close</a>
                                <?php }  ?>
                    </td>
                    


                    <?php 
                    if(isset($_GET['datequery'])){
                        $date =  $_GET['datequery'];
                    }else{
                        $date = date("Y-m-d");
                    }
                    $sqlcheck = "SELECT status FROM attendance WHERE dateOfAttendance = ? and staffId = ?";
                    $stmts = $conn->prepare($sqlcheck);
                    if($stmts){
                        $stmts->bind_param("si", $date , $id);
                        if($stmts->execute()){
                            $results = $stmts->get_result();
                            if($results->num_rows > 0){
                                $rows = $results->fetch_assoc();
                                $status = (int)$rows['status'];
                                if ($status === 1){
                                    echo '<td class="px-1 py-2 border border-gray-400 font-bold text-center text-green-500"> Present </td>';
                                }elseif($status === 0){
                                    echo '<td class="px-1 py-2 border border-gray-400 font-bold text-center text-red-500"> Absent </td>';
                                }
                            }else {
                                echo '<td class="px-1 py-2 border border-gray-400 font-bold text-center"></td>';
                            }
                        }
                    }
                    ?>
                    <td class="px-1 py-2 border border-gray-400">
                        <div id="attendanceLegend" >
                            <a id="presentBtn" href="" data-custom-value="1" class="text-white bg-green-500 px-2 py-1 rounded border border-gray-800 mr-2">P</a>
                            <a id="absentBtn" href="" data-custom-value="0" class="text-white bg-cyan-500 px-2 py-1 rounded border border-gray-800 ml-2">A</a>
                        </div>
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
    <script src="../include/js/staff.js"></script>
    
    <script>
        let table = new DataTable('#staffTable');
    </script>
</body>

</html>