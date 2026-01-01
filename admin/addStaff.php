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
    include_once "../include/navbar1.php"
    ?>

    <?php
    if(isset($_GET['updateId'])){
        $updateId = (int)$_GET['updateId'];

        include_once "../include/connect.php";
        $sql = "SELECT * FROM staff where id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("i", $updateId);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    
                    $id = $row['id'];
                    $dor = $row['dor'];
                    $name = $row['name'];
                    $fname = $row['fname'];
                    $salary = $row['salary'];
                    $aadhar = $row['aadhar'];
                    $comments = $row['comments'];

                }
                
            }
        }
    }
    ?>


    <!-- Add staff form -->
    <section class="bg-white">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-2 text-xl font-bold text-gray-900"><?php if(isset($_GET['updateId'])){ echo "Edit:- " . $name; } else {echo "Add a Staff";}?></h2>
            <form action="./queries.php" method="POST">
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                   <!--  hidden id --> 
                    <input type="hidden" name="id" value="<?php if(isset($_GET['updateId'])){ echo $id; }?>">
                    <!--  dor -->
                    <div class="w-full">
                        <label for="dor" class="block mb-1 text-sm font-medium text-gray-900">Date of Joining</label>
                        <input type="date" name="dor" id="dor" value="<?php if(isset($_GET['updateId'])){ echo $dor; } else {echo date("Y-m-d");} ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2" placeholder="Staff Name" required="">
                    </div>
                    <!--  Name -->
                    <div class="sm:col-span-2">
                        <label for="name" class="block mb-1 text-sm font-medium text-gray-900">Staff Name</label>
                        <input type="text" name="name" id="name" value="<?php if(isset($_GET['updateId'])){ echo $name; } ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2" placeholder="Staff Name" required="">
                    </div>
                    <!--  F.Name -->
                    <div class="w-full">
                        <label for="fname" class="block mb-1 text-sm font-medium text-gray-900">Father Name</label>
                        <input type="text" name="fname" id="fname" value="<?php if(isset($_GET['updateId'])){ echo $fname; } ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2" placeholder="Father Name" required="">
                    </div>
                    <!--  Salary -->
                    <div class="w-full">
                        <label for="salary" class="block mb-1 text-sm font-medium text-gray-900">Salary</label>
                        <input type="number" name="salary" id="salary" value="<?php if(isset($_GET['updateId'])){ echo $salary; } ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2" placeholder="Enter Salary" required="">
                    </div>
                    <!--  Aadhar -->
                    <div class="w-full">
                        <label for="aadhar" class="block mb-1 text-sm font-medium text-gray-900">Aadhar No.</label>
                        <input type="text" name="aadhar" id="aadhar" value="<?php if(isset($_GET['updateId'])){ echo $aadhar; } ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2" placeholder="Aadhar No." required="">
                    </div>
                    <!--  Comments -->
                    <div class="sm:col-span-2">
                        <label for="comments" class="block mb-1 text-sm font-medium text-gray-900">Comments About Staff Member</label>
                        <textarea id="comments" name="comments" rows="2" value="<?php if(isset($_GET['updateId'])){ echo $comments; } ?>" class="block p-2 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Your description here"></textarea>
                    </div>
                </div>
                <button type="submit" name="addStaffSubmit" class="inline-flex items-center px-5 py-2 mt-3 sm:mt-6 text-sm font-medium text-center text-white bg-black rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-gray-800">
                    Add Staff
                </button>
            </form>
        </div>
    </section>


    <?php
    include_once "../include/footer.php"
    ?>
</body>

</html>