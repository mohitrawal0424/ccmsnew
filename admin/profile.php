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
    <title>Staff Profile</title>
    <link rel="stylesheet" href="../output.css">
</head>

<body>
    <?php
    date_default_timezone_set("Asia/Calcutta");
    include_once "../include/navbar1.php"
    ?>



    <!-- Enter Staff ID form -->
    <section class="bg-white">
    <div class="py-4 px-4 mx-auto max-w-2xl lg:py-2">
      <form action="queries.php" method="GET">
        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
          <div class="sm:col-span-2 relative">
            <form action="./queries.php" method="GET">
              <input type="number" name="inputStaffId" id="inputStaffId" class="bg-gray-50 border border-gray-800 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Enter Staff ID" required>
              <button type="submit" name="sumbitInputStaffId" id="sumbitInputStaffId" class="text-white absolute right-1 bottom-1 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Submit</button>
            </form>
          </div>
        </div>
      </form>
    </div>
  </section>


    <?php if (isset($_GET['staffId'])) {

        $staffId = (int)$_GET['staffId'];
        
        include_once "../include/connect.php";
        $sql = "SELECT * FROM staff where delete_status = 1 and id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $staffId);
            if ($stmt->execute()) {
                $result = $stmt->get_result(); // Get the result set

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // You can access the columns by their names in the $row array
                        $dor = $row['dor'];
                        $name = $row['name'];
                        $fname = $row['fname'];
                        $salary = (int)$row['salary'];
                        $aadhar = $row['aadhar'];
                        $doc = $row['doc'];
    ?>
<!-- <div class="bg-[#1AACAC] text-xl text-black text-center font-semibold px-3 py-4 border-4 border-black">Staff Profile</div> -->

<!-- alert Here -->
<div id="alertExpanse">
    <?php
    if (isset($_GET['smessage'])) {
        $message = $_GET['smessage'];
        echo '<div class="p-3 mb-3 text-md text-green-800 rounded-sm bg-green-100 border border-gray-800" role="alert">
        <span class="font-medium">' . $message . '
        </div>';
    }
    if (isset($_GET['emessage'])) {
        $message = $_GET['emessage'];
        echo '<div class="p-3 mb-3 text-md text-red-800 rounded-sm bg-red-100 border border-gray-800" role="alert">
        <span class="font-medium">' . $message . '</div>';
    }
?>
</div>
<?php 
if($doc != NULL){ ?>
<h1 class="text-red-500 bg-gray-200 py-2 text-center text-2xl font-semibold border-2 border-black"> This Staff Account is closed !</h1>
<?php }
?> 
                        <div class="border border-gray-800 rounded-lg shadow-lg p-4">
                            <div class="text-center">
                                <img src="../include/pp/profile-2398782_1280.png" alt="User's Profile Image" class="mx-auto w-16 h-16 rounded-full">
                                <h2 class="mt-2 text-2xl font-semibold"><?php echo $name; ?></h2>
                                <p class="text-gray-600">Staff's Job Title</p>
                            </div>
                            <div class="mt-4 border-2 border-gray-800 p-2 rounded">
                                <div class="flex justify-between items-center border-b border-gray-400">
                                    <span class="text-sm font-semibold text-gray-600">Staff ID:</span>
                                    <span class="text-sm text-gray-900 font-semibold"><?php echo $staffId; ?></span>
                                </div>
                                <div class="flex justify-between items-center mt-2 border-b border-gray-400">
                                    <span class="text-sm font-semibold text-gray-600">Father Name:</span>
                                    <span class="text-sm text-gray-900 font-semibold"><?php echo $fname; ?></span>
                                </div>
                                <div class="flex justify-between items-center mt-2 border-b border-gray-400">
                                    <span class="text-sm font-semibold text-gray-600">Salary:</span>
                                    <span class="text-sm text-gray-900 font-semibold"><?php echo $salary; ?></span>
                                </div>
                                <div class="flex justify-between items-center mt-2 border-b border-gray-400">
                                    <span class="text-sm font-semibold text-gray-600">Date of Joining:</span>
                                    <span class="text-sm text-gray-900 font-semibold"><?php
                                    $date = new DateTime($dor);
                                    echo $date->format('d-M-Y');
                                    ?></span>
                                </div>
                                <?php
                                if($doc){ ?>
                                    <div class="flex justify-between items-center mt-2 border-b border-gray-400">
                                    <span class="text-sm font-semibold text-gray-600">Date of Closing:</span>
                                    <span class="text-sm text-gray-900 font-semibold"><?php
                                    $date = new DateTime($doc);
                                    echo $date->format('d-M-Y');
                                    ?></span>
                                </div>
                                <?php }
                                
                                ?>
                                <div class="flex justify-between items-center mt-2 border-b border-gray-400">
                                    <span class="text-sm font-semibold text-gray-600">Aadhar No.:</span>
                                    <span class="text-sm text-gray-900 font-semibold"><?php echo $aadhar; ?></span>
                                </div>
                                <div class="flex justify-between items-center mt-2 border-b border-gray-400">
                                    <span class="text-sm font-semibold text-gray-600">Total Days:</span>
                                    <span class="text-sm text-gray-900 font-semibold"><?php 
                                    
                                    $date1 = new DateTime($dor);
                                    if($doc == NULL) {
                                        $date2 = new DateTime(date('Y-m-d'));
                                    }else {
                                        $date2 = new DateTime($doc);
                                    }
                                    $date2->modify('+1 day');
                                    // Calculate the interval between the two dates
                                    $interval = $date1->diff($date2);

                                    // Get the number of months and days from the interval
                                    $years = $interval->format('%y');
                                    $months = $interval->format('%m');
                                    $days = $interval->format('%d');
                                    echo "$years Years, $months Months ,$days  Days ";?>
                                    
                                    <span class="text-green-700"><?php  echo "(" . (int)($interval->days) ." Days)" ;  ?></span>
                                    </span>
                                </div>
                                <div class="flex justify-between items-center mt-2 border-b border-gray-400">
                                    <span class="text-lg font-semibold text-gray-600">Balance.:</span>
                                    <span class="text-lg text-gray-900 font-semibold"><?php 
                                    include_once("../include/functions/remBalance.php");
                                    echo $balance = remBalance($staffId,$salary,$dor,$doc);
                                    
                                    ?></span>
                                </div>
                            </div>
                        </div>

        <?php
                    }
                

        ?>

        <div class="max-w-full sm:max-w-md mx-auto bg-white shadow p-4 rounded-lg">
            <div class="overflow-x-auto">
            <form action="./queries.php" class="mb-5">
                <label for="bdaymonth">Select Month & Year:</label>
                <input type="hidden" name="idForSelectMonth" value="<?php echo $staffId; ?>">
                <input class="border border-gray-800 rounded" type="month" name="selectMonth" value="<?php echo date('Y-m'); ?>">
                <input class="text-white bg-blue-500 rounded border border-gray-800 p-1" name="selectMonthSubmit" type="submit">
            </form>

                <table class="w-full text-center">
                    <?php
                    // Get the current date
                    
                    if (isset($_GET['monthYear'])){
                        $monthYear = (string)$_GET['monthYear'];
                        $dateInString = $monthYear."-01";
                        $date = getdate(strtotime($dateInString));
                    }else {
                        $date = getdate();
                    }

                    $dayInNumber = $date['mday'];
                    $monthInNumber = $date['mon'];
                    $yearInNumber = $date['year'];

                    $firstDayForme = $yearInNumber . "-" . $monthInNumber . "-01";

                    // Get the value of day, month, year
                    $mday = $date['mday'];
                    $mon = $date['mon'];
                    $wday = $date['wday'];
                    $month = $date['month'];
                    $year = $date['year'];


                    $dayCount = $wday; // 6 //saturday
                    $day = $mday; //7

                    while ($day > 0) {
                        $days[$day--] = $dayCount--;
                        if ($dayCount < 0)
                            $dayCount = 6;
                    }

                    $dayCount = $wday;
                    $day = $mday;

                    if (checkdate($mon, 31, $year))
                        $lastDay = 31;
                    elseif (checkdate($mon, 30, $year))
                        $lastDay = 30;
                    elseif (checkdate($mon, 29, $year))
                        $lastDay = 29;
                    elseif (checkdate($mon, 28, $year))
                        $lastDay = 28;

                    $lastDayForme = $yearInNumber . "-" . $monthInNumber . "-" . $lastDay;


                    include_once "../include/connect.php";

                    $sql = "SELECT * FROM `attendance` WHERE dateOfAttendance BETWEEN ? AND ? AND staffId = ? ORDER BY dateOfAttendance ASC";
                    $stmt = $conn->prepare($sql);

                    $highlightDays = []; //for highlight days in Calender
                    $arrayForTables = []; //this array is for table record
                    if ($stmt) {
                        $stmt->bind_param("ssi", $firstDayForme, $lastDayForme, $staffId);
                        if ($stmt->execute()) {
                            $result = $stmt->get_result(); // Get the result set

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    // You can access the columns by their names in the $row array
                                    $status = (int)$row['status'];
                                    $dateDay = substr($row['dateOfAttendance'], 8);
                                    $dateDayfortable = $row['dateOfAttendance'];

                                    $highlightDay = [
                                        'status' => $status,
                                        'dateDay' => $dateDay,
                                    ];
                                    $arrayForTable = [
                                        'status' => $status,
                                        'dateDay' => $dateDayfortable,
                                    ];

                                    $highlightDays[] = $highlightDay;
                                    $arrayForTables[] = $arrayForTable;
                                }
                            }
                        }
                    }
                    // print_r($highlightDays);
                    while ($day <= $lastDay) {
                        $days[$day++] = $dayCount++;
                        if ($dayCount > 6)
                            $dayCount = 0;
                    }

                    // Days to highlight
                    // $day_to_highlight = array(8, 9, 10, 11, 12, 22,23,24,25,26);

                    echo ("<tr>");
                    echo ("<th colspan='7' class='text-xl py-2 border border-gray-700'>$month $year</th>");
                    echo ("</tr>");
                    echo ("<tr>");
                    echo ("<td class='bg-yellow-500 border border-gray-700'>Sun</td>");
                    echo ("<td class='bg-yellow-500 border border-gray-700'>Mon</td>");
                    echo ("<td class='bg-yellow-500 border border-gray-700'>Tue</td>");
                    echo ("<td class='bg-yellow-500 border border-gray-700'>Wed</td>");
                    echo ("<td class='bg-yellow-500 border border-gray-700'>Thu</td>");
                    echo ("<td class='bg-yellow-500 border border-gray-700'>Fri</td>");
                    echo ("<td class='bg-yellow-500 border border-gray-700'>Sat</td>");
                    echo ("</tr>");

                    $startDay = 0;
                    $d = $days[1];

                    echo ("<tr>");
                    while ($startDay < $d) {
                        echo ("<td class='border border-gray-700'></td>");
                        $startDay++;
                    }

                    //New code

                    for ($d = 1; $d <= $lastDay; $d++) {
                        // $found = false;
                        $bg = "bg-white";

                        // Check if $d exists in any 'dateDay' in the $highlightDays array
                        foreach ($highlightDays as $highlightDay) {
                            if ($d == $highlightDay['dateDay']) {
                                $status = (int)$highlightDay['status'];
                                if ($status === 1) {
                                    $bg = "bg-green-500";
                                } elseif ($status === 0) {
                                    $bg = "bg-red-500";
                                }
                            }
                        }

                        // Highlights the current day
                        if ($d == $mday) {
                            echo ("<td class='$bg border border-gray-700'>$d</td>");
                        } else {
                            echo ("<td class='$bg border border-gray-700'>$d</td>");
                        }

                        $startDay++;
                        if ($startDay > 6 && $d < $lastDay) {
                            $startDay = 0;
                            echo ("</tr>");
                            echo ("<tr>");
                        }
                    }


                    echo ("</tr>");
                    ?>
                </table>
                <br>
                <table>
                    <tr>
                        <td class="bg-green-500 text-black border border-gray-700 p-1">Present</td>
                        <td class="bg-red-500 text-black border border-gray-700 p-1">Absent</td>
                    </tr>
                </table>
                <br>
                <table id="attendRecordTable" class="w-full text-center bg-gray-200">
                    <thead>
                        <tr>
                            <th colspan='3' class='text-lg py-2 border border-gray-800'>Attendence Records Table (<?php echo $month ."-". $year ?>)</th>
                        </tr>
                        <tr>
                            <th class='text-sm py-1 border border-gray-800'>S.No.</th>
                            <th class='text-sm py-1 border border-gray-800'>Date</th>
                            <th class='text-sm py-1 border border-gray-800'>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php 
                            $i = 1;
                            foreach ($arrayForTables as $arrayForTable) {
                                    $status = (int)$arrayForTable['status'];
                                    if ($status === 1) {
                                    echo "<tr>
                                    <td class='text-sm py-1 border border-gray-800'>".$i++."</td>
                                    <td class='text-sm py-1 border border-gray-800'>".$arrayForTable['dateDay']."</td>
                                    <td class='text-sm py-1 border border-gray-800 bg-green-500'>Present</td>
                                    </tr>";
                                    } elseif ($status === 0) {
                                        echo "<tr>
                                        <td class='text-sm py-1 border border-gray-800'>".$i++."</td>
                                        <td class='text-sm py-1 border border-gray-800'>".$arrayForTable['dateDay']."</td>
                                        <td class='text-sm py-1 border border-gray-800 bg-red-500'>Absent</td>
                                        </tr>";
                                    }
                            }
                            ?>    
                    </tbody>
                </table>
            </div>
        </div>


        <!-- give advance section below -->
        <div class="px-2 py-1 bg-cyan-700 text-white font-semibold text-lg border-2 border-gray-800">Give Advance</div>


        <section class="bg-white">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-2 text-xl font-bold text-gray-900">Give Advance</h2>
            <form action="./queries.php" method="POST">
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                   <!--  hidden id --> 
                    <input type="hidden" name="idForAdvance" value="<?php echo $staffId; ?>">
                    <!--  dor -->
                    <div class="w-full">
                        <label for="doAdvance" class="block mb-1 text-sm font-medium text-gray-900">Date of Advance</label>
                        <input type="date" name="doAdvance" id="doAdvance" value="<?php echo date("Y-m-d"); ?>" class="bg-gray-50 border border-gray-800 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2" placeholder="Staff Name" required="">
                    </div>
                    <!--  Name -->
                    <div class="w-full">
                        <label for="name" class="block mb-1 text-sm font-medium text-gray-900">Staff Name</label>
                        <input type="text" name="name" id="name" value="<?php echo $name;  ?>" class="bg-gray-50 border border-gray-800 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2" placeholder="Staff Name" readonly>
                    </div>
                    <!--  F.Name -->
                    <div class="w-full">
                        <label for="fname" class="block mb-1 text-sm font-medium text-gray-900">Father Name</label>
                        <input type="text" name="fname" id="fname" value="<?php echo $fname; ?>" class="bg-gray-50 border border-gray-800 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2" placeholder="Father Name" readonly>
                    </div>
                    <!--  Amount -->
                    <div class="w-full">
                        <label for="advanceAmount" class="block mb-1 text-sm font-medium text-gray-900">Advance Amount</label>
                        <input type="number" name="advanceAmount" id="advanceAmount" class="bg-gray-50 border border-gray-800 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2" placeholder="Amount" required>
                    </div>
                    <!--  Comments -->
                    <div class="w-full">
                        <label for="comments" class="block mb-1 text-sm font-medium text-gray-900">Any Comments?</label>
                        <textarea id="comments" name="comments" rows="2" class="block p-2 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-800 focus:ring-primary-500 focus:border-primary-500" placeholder="Your Comments Here"></textarea>
                    </div>
                </div>
                <button type="submit" name="giveAdvanceSubmit" class="inline-flex items-center px-5 py-2 mt-3 sm:mt-6 text-sm font-medium text-center text-white bg-black rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-gray-800">
                    Give Advance
                </button>
            </form>
        </div>
    </section>

    <!-- Advance Table Section Here  -->

    <!-- Employess List table Here -->
    <div class="relative overflow-x-auto shadow-md">
        <table id="staffTable" class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-900 uppercase bg-[#64CCC5]">
                <tr>
                    <th scope="col" colspan="5" class="text-lg px-3 py-3 bg-gray-700 text-white text-center">
                        Advance Table
                    </th>
                </tr>
                <tr>
                    <th scope="col" class="px-1 py-2 border border-gray-600">
                        S.No.
                    </th>
                    <th scope="col" class="px-1 py-2 border border-gray-600">
                        Date of Advance (YYYY-MM-DD)
                    </th>
                    <th scope="col" class="px-1 py-2 border border-gray-600 text-center">
                        Amount
                    </th>
                    <th scope="col" class="px-1 py-2 border border-gray-600">
                    Comments
                    </th>
                    <?php if($role === 0){ ?>
                    <th scope="col" class="px-1 py-2 border border-gray-600">
                    Action
                    </th>
                    <?php  } ?>
                </tr>
            </thead>
            <tbody>

            <?php
            include_once "../include/connect.php";
            $sqlAdvance = "SELECT * FROM `advance` WHERE staffId = $staffId ORDER BY dateOfAdvance ASC";
            $stmtAdvance = $conn->prepare($sqlAdvance);
            $advanceSum = [];
            if ($stmtAdvance) {
                if ($stmtAdvance->execute()) {
                    $resultAdvance = $stmtAdvance->get_result(); // Get the result set
                    $i= 1;
                    if ($resultAdvance->num_rows > 0) {
                        while ($rowAdvance = $resultAdvance->fetch_assoc()) {
                            // You can access the columns by their names in the $row array
                        $id = (int)$rowAdvance['id'];
                        $date = (string)$rowAdvance['dateOfAdvance'];
                        $amount = (int)$rowAdvance['amount'];
                        $comments = (string)$rowAdvance['comments'];
                        $advanceSum[] = $amount;
                            
                     ?>

                    <tr class="bg-white border-b hover:bg-gray-50 text-gray-800">
                    <th id="staffId" scope="row" class="px-4 py-2 border border-gray-600 font-medium text-gray-900 whitespace-nowrap">
                        <?php echo $i++ ; ?>
                    </th>
                    <td class="px-1 py-2 border border-gray-600 font-semibold">
                        <?php echo $date; ?>
                    </td>
                    <td class="px-1 py-2 border border-gray-600 text-center">
                    <?php echo $amount; ?>
                    </td>
                    <td class="px-1 py-2 border border-gray-600">
                    <?php echo $comments; ?>
                    </td>
                    <?php if($role === 0){ ?>
                    <td class="px-1 py-2 border border-gray-600">
                    <a id="deleteBtnAdvanceID" href="" value="<?php echo $id;  ?>" class="text-white bg-red-500 px-2 py-1 rounded border border-gray-800 ml-2">Delete</a>
                    </td>
                    <?php  } ?>
                 
                </tr>    
                 
                        <?php } ?>
                        <tr>
                        <th scope="col" colspan="2" class="px-1 py-2 border border-gray-600 text-lg text-black text-center">
                            Total
                        </th>
                        <th class="px-1 py-2 border border-gray-600 text-lg text-black text-center">
                        <?php echo array_sum($advanceSum); ?>
                        </th>
                        </tr>  
                  <?php   } else { ?>
                    <tr>
                        <td colspan="4" class="px-1 py-2 border border-gray-600 text-lg text-black text-center"> No Records Found</td>
                    </tr>
                    <?php }
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



    <?php
    }else { ?>
        
        <div class="border-2 border-gray-900 p-4 bg-gray-300 text-red-500 font-bold rounded-lg my-2">
            Staff Not Found ! Please Enter Correct Staff ID
        </div>

    <?php  }
}
}
    } 
    // else {
    //     echo "Please Select Staff id";
    // }
    ?>

    <?php
    include_once "../include/footer.php"
    ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/0ef3c59d0f.js" crossorigin="anonymous"></script>
    <script src="../include/js/profile.js"></script>
</body>

</html>