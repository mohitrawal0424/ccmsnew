<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->

</head>
<body>
    

<?php

// $startDate = new DateTime('2023-12-02');
// $startDate->add(new DateInterval('P1M')); // Add 1 month
// $nextMonth = $startDate->format('Y-m-d');

// echo $nextMonth; // Output: 2023-09
// echo "</br>";

// $startDate = new DateTime('2023-08-01');
// $startDate->add(new DateInterval('P1M')); // Add 1 month to move to the next month
// $startDate->setDate($startDate->format('Y'), $startDate->format('n'), $startDate->format('t')); // Set day to last day of the month
// $lastDateOfNextMonth = $startDate->format('Y-m-d');

// echo $lastDateOfNextMonth; // Output: 2023-09-30
date_default_timezone_set("Asia/Calcutta");
$salary = 9000;
$salarySum = [];

$startDate = new DateTime('2023-09-08');
$startDateDate = $startDate->format('Y-m-d');

$startDateEpoch = strtotime($startDateDate);
$lastDate = new DateTime(); // or last date
$lastDateDate = $lastDate->format('Y-m-d');
$lastDateEpoch = strtotime($lastDateDate);
echo "</br>";


if ($startDateEpoch <= $lastDateEpoch) {
    $previousDate = $startDateEpoch;
    $salarySum = [];

    while ($previousDate <= $lastDateEpoch) {
        $dayInString = date('Y-m-d', $previousDate);
        $dayObject = new DateTime($dayInString);
        $totalDaysInThatMonth = $dayObject->format('t');
        $oneDaySalary = $salary / $totalDaysInThatMonth;

        $salarySum[$dayInString] = $oneDaySalary;

        $previousDate += 86400; // Move to Next Day
    }
    $absentArray = [ '2023-10-10' => '2023-10-26',
     '2023-10-15' => '2023-10-25',
    '2023-10-20' => '2023-10-24'];
    print_r($absentArray);
    echo "</br>";
    echo "</br>";
    echo "</br>";
    echo "</br>";

    print_r(array_sum($salarySum));
    echo "</br>";
    echo "</br>";
    echo "</br>";

    print_r(array_sum($keysNotInBoth = array_diff_key($salarySum, $absentArray)));
}

echo "</br>";

// $previousDate = $startDate;
//     foreach ($paidDates as $repayDate => $values) {
//       $repayEpoch = strtotime($repayDate); // Convert repayment date to epoch format
//         while ($previousDate <= $repayEpoch) {
//           $installmentNew = ($initial_loan_amount * $roi / 100);
//           $alldues[date('Y-m-d', $previousDate)] = $installmentNew; // Store installment change for the date
//           $previousDate += 86400; // Move to the next day (86400 seconds = 1 day)
//         }
//       $previousDate = $repayEpoch + 86400; // Move to the next day after the repayment date
//       $initial_loan_amount -= $values['repay_amount'];
//     }

// Calculate the next month
// $nextMonth = clone $startDate;
// $nextMonth->modify('+1 month');

// // Calculate the first day of the next month
// $firstDayOfNextMonth = $nextMonth->format('Y-m-01');

// // Calculate the last day of the next month
// $lastDayOfNextMonth = $nextMonth->format('Y-m-t');

// // Calculate the total number of days in the next month
// $totalDaysInNextMonth = $nextMonth->format('t');

// echo "</br>";
// echo "Next Month: " . $nextMonth->format('Y-m') . PHP_EOL;
// echo "</br>";
// echo "First Day of Next Month: " . $firstDayOfNextMonth . PHP_EOL;
// echo "</br>";
// echo "Last Day of Next Month: " . $lastDayOfNextMonth . PHP_EOL;
// echo "</br>";
// echo "Total Number of Days in Next Month: " . $totalDaysInNextMonth . PHP_EOL;
// echo "</br>";






?>
    
    <!-- <table class="w-full text-center">
        <?php
    // date_default_timezone_set("Asia/Calcutta");


    // echo $date = strtotime("2023-09-01");
    // print_r(getdate($date));



    // echo "</br>";
    // echo "</br>";
    // echo "</br>";
    // echo "</br>";
    // echo "</br>";
    // echo "</br>";
    // echo "</br>";

    //                 // Get the current date
    //                 print_r($date = getdate());
    //                 echo "</br>";

    //                 echo $dayInNumber = $date['mday'];
    //                 echo "</br>";

    //                 echo $monthInNumber = $date['mon'];
    //                 echo "</br>";

    //                 echo $yearInNumber = $date['year'];
    //                 echo "</br>";
                    
    //                 $firstDayForme = $yearInNumber . "-" . $monthInNumber . "-01";
    //                 echo "</br>";
                    
    //                 // Get the value of day, month, year
    //                 $mday = $date['mday'];
    //                 $mon = $date['mon'];
    //                 $wday = $date['wday'];
    //                 $month = $date['month'];
    //                 $year = $date['year'];
                    
                    
    //                 $dayCount = $wday;
    //                 $day = $mday;
                    
    //                 while ($day > 0) {
    //                     $days[$day--] = $dayCount--;
    //                     if ($dayCount < 0)
    //                     $dayCount = 6;
    //                 }

    //                 $dayCount = $wday;
    //                 $day = $mday;

    //                 if (checkdate($mon, 31, $year))
    //                 $lastDay = 31;
    //                 elseif (checkdate($mon, 30, $year))
    //                 $lastDay = 30;
    //                 elseif (checkdate($mon, 29, $year))
    //                 $lastDay = 29;
    //                 elseif (checkdate($mon, 28, $year))
    //                 $lastDay = 28;
                    
    //                 $lastDayForme = $yearInNumber . "-" . $monthInNumber . "-" . $lastDay;
                    
                    
    //                 include_once "../include/connect.php";
                    
    //                 $sql = "SELECT * FROM `attendance` WHERE dateOfAttendance BETWEEN ? AND ? AND staffId = ? ORDER BY dateOfAttendance ASC";
    //                 $stmt = $conn->prepare($sql);
                    
    //                 $highlightDays = []; //for highlight days in Calender
    //                 $arrayForTables = []; //this array is for table record
    //                 if ($stmt) {
    //                     $stmt->bind_param("ssi", $firstDayForme, $lastDayForme, $staffId);
    //                     if ($stmt->execute()) {
    //                         $result = $stmt->get_result(); // Get the result set
                            
    //                         if ($result->num_rows > 0) {
    //                             while ($row = $result->fetch_assoc()) {
    //                                 // You can access the columns by their names in the $row array
    //                                 $status = (int)$row['status'];
    //                                 $dateDay = substr($row['dateOfAttendance'], 8);
    //                                 $dateDayfortable = $row['dateOfAttendance'];

    //                                 $highlightDay = [
    //                                     'status' => $status,
    //                                     'dateDay' => $dateDay,
    //                                 ];
    //                                 $arrayForTable = [
    //                                     'status' => $status,
    //                                     'dateDay' => $dateDayfortable,
    //                                 ];

    //                                 $highlightDays[] = $highlightDay;
    //                                 $arrayForTables[] = $arrayForTable;
    //                             }
    //                         }
    //                     }
    //                 }
    //                 // print_r($highlightDays);
    //                 while ($day <= $lastDay) {
    //                     $days[$day++] = $dayCount++;
    //                     if ($dayCount > 6)
    //                     $dayCount = 0;
    //                 }

    //                 // Days to highlight
    //                 // $day_to_highlight = array(8, 9, 10, 11, 12, 22,23,24,25,26);
                    
    //                 echo ("<tr>");
    //                 echo ("<th colspan='7' class='text-xl py-2 border border-gray-700'>$month $year</th>");
    //                 echo ("</tr>");
    //                 echo ("<tr>");
    //                 echo ("<td class='bg-yellow-500 border border-gray-700'>Sun</td>");
    //                 echo ("<td class='bg-yellow-500 border border-gray-700'>Mon</td>");
    //                 echo ("<td class='bg-yellow-500 border border-gray-700'>Tue</td>");
    //                 echo ("<td class='bg-yellow-500 border border-gray-700'>Wed</td>");
    //                 echo ("<td class='bg-yellow-500 border border-gray-700'>Thu</td>");
    //                 echo ("<td class='bg-yellow-500 border border-gray-700'>Fri</td>");
    //                 echo ("<td class='bg-yellow-500 border border-gray-700'>Sat</td>");
    //                 echo ("</tr>");

    //                 $startDay = 0;
    //                 $d = $days[1];
                    
    //                 echo ("<tr>");
    //                 while ($startDay < $d) {
    //                     echo ("<td class='border border-gray-700'></td>");
    //                     $startDay++;
    //                 }
                    
    //                 //New code
                    
    //                 for ($d = 1; $d <= $lastDay; $d++) {
    //                     // $found = false;
    //                     $bg = "bg-white";
                        
    //                     // Check if $d exists in any 'dateDay' in the $highlightDays array
    //                     foreach ($highlightDays as $highlightDay) {
    //                         if ($d == $highlightDay['dateDay']) {
    //                             $status = (int)$highlightDay['status'];
    //                             if ($status === 1) {
    //                                 $bg = "bg-green-500";
    //                             } elseif ($status === 0) {
    //                                 $bg = "bg-red-500";
    //                             }
    //                         }
    //                     }
                        
    //                     // Highlights the current day
    //                     if ($d == $mday) {
    //                         echo ("<td class='$bg border border-gray-700'>$d</td>");
    //                     } else {
    //                         echo ("<td class='$bg border border-gray-700'>$d</td>");
    //                     }

    //                     $startDay++;
    //                     if ($startDay > 6 && $d < $lastDay) {
    //                         $startDay = 0;
    //                         echo ("</tr>");
    //                         echo ("<tr>");
    //                     }
    //                 }


    //                 echo ("</tr>");
                    ?>
                </table> -->

</body>
</html>