<?php

/* 
@param $staffId = staff Id 
@return array of absent dates of staffId
*/

function absentArrayFn($staffId)
{
    date_default_timezone_set("Asia/Calcutta");
    include("../include/connect.php");
    $absentArray = [];
    $sqlAbsent = "Select dateOfAttendance FROM attendance WHERE staffId = ? and status = 0";
    $stmtAbsent = $conn->prepare($sqlAbsent);
    if ($stmtAbsent) {
        $stmtAbsent->bind_param("i", $staffId);
        if ($stmtAbsent->execute()) {
            $resultAbsent = $stmtAbsent->get_result();
            if ($resultAbsent->num_rows > 0) {
                while ($rowAbsent = $resultAbsent->fetch_assoc()) {
                    // array_push($absentArray, $rowAbsent['dateOfAttendance']);
                    $absentArray[$rowAbsent['dateOfAttendance']] = $rowAbsent['dateOfAttendance'];
                }
            }
        } else {
            echo "not executed";
        }
    } else {
        echo "not prepared";
    }
    echo "</br>";
    return $absentArray;
}

/* 
@param $staffId = staff Id 
@return Total paid amount to staffId
*/

function advanceTotal($staffId)
{
    date_default_timezone_set("Asia/Calcutta");
    include("../include/connect.php");

    $sqlAdvance = "SELECT amount FROM `advance` WHERE staffId = ? ORDER BY dateOfAdvance ASC";
    $stmtAdvance = $conn->prepare($sqlAdvance);
    $amounts = 0;
    if ($stmtAdvance) {
        $stmtAdvance->bind_param("i",$staffId);
        if ($stmtAdvance->execute()) {
            $resultAdvance = $stmtAdvance->get_result(); // Get the result set
            if ($resultAdvance->num_rows > 0) {
                
                while ($rowAdvance = $resultAdvance->fetch_assoc()) {
                    $amount = (int)$rowAdvance['amount'];
                    $amounts += $amount;
                }
            }
        }
    }
    return $amounts;
}


/* 
@param $salary = salary of staff
@param $staffId = staff Id 
@param $doj Date of joining or dor
@return remaining Salary
*/

function remBalance($staffId,$salary,$DOJ,$doc)
{
    date_default_timezone_set("Asia/Calcutta");

    $staffId = (int)$staffId;
    $salary = (int)$salary;
    $DOJ = (string)$DOJ;

    $salarySum = [];
    $startDate = new DateTime($DOJ);
    $startDateDate = $startDate->format('Y-m-d');

    $startDateEpoch = strtotime($startDateDate);
    $todayDate = new DateTime(); // or last date
    $todayDateDate = $todayDate->format('Y-m-d');
    if($doc == NULL){
        $lastDateEpoch = strtotime($todayDateDate);
    }else {
        $lastDateEpoch = strtotime($doc);
    }


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
        
        $absentArray = absentArrayFn($staffId); //absent dates in an array
        // $absentCount = count($absentArray); //absent Count
        $advanceTotal = advanceTotal($staffId);
    
        $totalSalary = array_sum(array_diff_key($salarySum, $absentArray));
        return $remSalary = round($totalSalary - $advanceTotal);
    }
    
}