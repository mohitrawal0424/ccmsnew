<?php 
function productProfit(){
    include("../include/connect.php");
                                
        $sql = "SELECT * FROM `solditems` as gd
        INNER JOIN product as p ON gd.idFromGaadiDetails = p.id 
        WHERE itemtype = 0";
        $stmt = $conn-> prepare($sql);
        $productProfit = [];
        if ($stmt) {
            // $stmt->bind_param("i", $ids);
            if ($stmt->execute()) {
                $result = $stmt->get_result(); // Get the result set
                if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $profit = ((int)$row["price"] - (int)$row["bprice"])*(int)$row["nos"];
                            $productProfit[] = $profit;   
                        
                        }
                }
            }
        } 
        return (array_sum($productProfit));
}

function petiProfit(){
    // need to change this get profit from solddetails
    include("../include/connect.php");
                                
        $sql = "SELECT * FROM `gaadidetails` as gd
        INNER JOIN peti as p ON gd.itemid = p.id 
        WHERE itemtype = 1 AND IsInScheme = 0";
        $stmt = $conn-> prepare($sql);
        $petiProfit = [];
        if ($stmt) {
            // $stmt->bind_param("i", $ids);
            if ($stmt->execute()) {
                $result = $stmt->get_result(); // Get the result set
                if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $profit = ((int)$row["price"] - (int)$row["bprice"])*(int)$row["nos"];
                            $petiProfit[] = $profit;   
                        
                        }
                }
            }
        } 
        return (array_sum($petiProfit));
}

//for gaadi
function addTotalBill($totalbill , $id){
        include("../include/connect.php");

        $sql = "UPDATE `gaadis` SET `totalbill` = ? WHERE id = ?";
        $stmt = $conn-> prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ii", $totalbill, $id);
            if ($stmt->execute()) {
                // echo "done";
            }
        } 
}

function addGaadiDetails($total ,$remain = 0 ,$amountpaid, $expanse, $id){
    include("../include/connect.php");
    $total = (int)$total;
    $remain = (int)$remain;
    $amountpaid = (int)$amountpaid;
    $expanse = (int)$expanse;
    $id = (int)$id;


    $sql = "UPDATE `gaadis` SET `soldValue` = ?,`remaining_amount` = ?,`amountpaid` = ?,`expanse` = ? WHERE id = ?";
    $stmt = $conn-> prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iiiii", $total,$remain,$amountpaid,$expanse, $id);
        if ($stmt->execute()) {
            // echo "done";
        }
    } 
}

function convertToLitre($ml) {
    $ml = (int)$ml;
    if($ml >= 1000){
        $litre = $ml / 1000;
        return $litre . " Litre";
    }else{
        return $ml . " ml";
    }
}

function insertDetails($itemId, $type, $itemNos, $gaadiId, $isInScheme, $table,$gaadiORcounter){

    global $res;
    global $message;
    include "../include/connect.php";
    $sql = "INSERT INTO ". $table ." (itemid, itemtype, nos, ".$gaadiORcounter.",IsInScheme) VALUES ( ? , ? , ? , ? , ? )";
    $stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("iiiii", $itemId, $type , $itemNos , $gaadiId,$isInScheme);
    if ($stmt->execute()) {

        include "../include/functions/updateStoke.php";

        updateStockDetails($itemId , $type , $itemNos, $stokeType= 2);
        echo "data entered";

        $res = [
            'status' => true,
            'msg' => "Done"
        ];
        return $message = "Item Added";
    }else {
        $res = [
            'status' => false,
            'msg' => $conn->error
        ];
        return $message = "Some Problem";
        // return $message = $conn->error;

    }
}
}

function updateDetails($id, $currentNos, $itemId, $type , $itemNos , $table){
    global $res;
    global $message;
    include "../include/connect.php";

    $sql = "UPDATE ". $table ." SET `nos`= ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("ii", $currentNos, $id);
    if ($stmt->execute()) {

        include "../include/functions/updateStoke.php";

        updateStockDetails($itemId , $type , $itemNos, $stokeType= 2);
        echo "data entered";

        $res = [
            'status' => true,
            'msg' => "Done"
        ];
        return $message = "Item Added";
    }else {
        $res = [
            'status' => false,
            'msg' => $conn->error
        ];
        // return $conn->error;
        return $message = "Some Problem";
    }
}
}

function isItemExists($itemid, $itemType,$gaadiId, $table){

    include "../include/connect.php";
    $ress = [];

    if($table == "counterdetails"){
        $sql = "SELECT * FROM ".$table." WHERE itemid = ? and itemtype = ? and counterid = ?";
    }elseif($table == "gaadidetails"){
        $sql = "SELECT * FROM ".$table." WHERE itemid = ? and itemtype = ? and gaadid = ?";
    }
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("iii", $itemid, $itemType, $gaadiId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $ress["num_rows"] = $result->num_rows;
            $row = $result->fetch_assoc();
            $ress["nos"] = $row["nos"];
            $ress['id'] = $row["id"];
            return $ress;
        }else{
        echo $conn->error;
        }
    }else{
        echo $conn->error;
    }

}

function itemStokeDetail($itemid, $itemType){

    include "../include/connect.php";
    $ress = [];

    $sql = "SELECT SUM(CASE WHEN stoketype = 1 THEN nos ELSE 0 END) AS addedSum,
    SUM(CASE WHEN stoketype = 2 THEN nos ELSE 0 END) AS removedSum FROM `stokes` WHERE itemtype = ? and itemid = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ii", $itemType, $itemid);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $ress["nums"] = $row['addedSum'] - $row['removedSum'];
            return $ress;
        }
    }

}

function soldItemByID($id){
    include "../include/connect.php";

    $sql = "SELECT sum(nos) as sum FROM `solditems` WHERE idFromGaadiDetails = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            return $row['sum'];
        }
    }

}

function moneyTransferByManager($id){
    include "../include/connect.php";

    $sql = "SELECT SUM(amount) as paidamount FROM `transfertoowner` WHERE senderid = ? ";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            return $row['paidamount'];
        }
    }

}

// function getdatafromTransferToOwnerTable (){
    
//     include "../include/connect.php";

//     $sql = "SELECT * FROM `transfertoowner` ORDER BY `transfertoowner`.`id` DESC";
//     $stmt = $conn->prepare($sql);
//     if ($stmt) {
//         if ($stmt->execute()) {
//             $result = $stmt->get_result();
//             return $result->fetch_all();
//         }
//     }
// }

function getUserName($id){
    include "../include/connect.php";

    $sql = "SELECT username FROM `user` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row['username'];
        }
    }
}

// get person/receiverName
function getReceiverName($id){
    include "../include/connect.php";

    $sql = "SELECT name FROM `person` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row['name'];
        }
    }
}

//for counter 
function addTotalBillCounter($totalbill , $id){
    include("../include/connect.php");

    $sql = "UPDATE `counter` SET `totalbill` = ? WHERE id = ?";
    $stmt = $conn-> prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $totalbill, $id);
        if ($stmt->execute()) {
            // echo "done";
        }
    } 
}

//for counter 
function amountTypeAndTotal($id){
    include("../include/connect.php");
    $returnArray = [];

    $sql = "SELECT 
    SUM(CASE WHEN type = 1 THEN amount ELSE 0 END) AS cash_total,
    SUM(CASE WHEN type = 2 THEN amount ELSE 0 END) AS online_total
FROM 
    `amountpaidgaadis`
WHERE 
    gaadi = ?";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i",$id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            $returnArray['cash_total'] = $row["cash_total"];
            $returnArray['online_total'] = $row["online_total"];
            $returnArray['total_amount'] = $row["online_total"] + $row["cash_total"];
            return $returnArray;
        }
    } 
}

function moneyPaidToGaadiAndReceiver($personid){
    include "../include/connect.php";

    $sql = "SELECT sum(amount) as amountPaid FROM `amountpaidgaadis` as apg
    JOIN gaadis as g ON apg.gaadi = g.id WHERE g.receiverid = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $personid);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row['amountPaid'];
        }
    }

}

//gaadi Expanse
function gaadiExpanse($gaadi_id){
    include("../include/connect.php");

    $sql = "SELECT sum(amount) as gaadiExpanse FROM `expanse` WHERE gaadi_id = ?";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i",$gaadi_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            return $row["gaadiExpanse"];
        }
    } 
}

function gaadiDetails($id){

    $gaadiArray = [];
    include("../include/connect.php");

    $sql = "SELECT g.*,s.name as recName,s.id as personId FROM `gaadis` as g 
                            INNER JOIN `person` as s ON g.receiverid = s.id
                            WHERE g.id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
              $stmt->bind_param("i", $id);
              if ($stmt->execute()) {
                $result = $stmt->get_result(); // Get the result set
                if ($result->num_rows > 0) {
                  $gaadiArray['gaadi'] = $row = $result->fetch_assoc();
                }
            }
        }
    //expanse
    $gaadiArray['expanse'] = gaadiExpanse($id);
    //AmountPaid
    $gaadiArray['amountpaidtable'] = amountTypeAndTotal($id);
    //remainingPaid
    $gaadiArray['remainingAmount'] = ($row["soldValue"] - $row["discount"] - $gaadiArray['amountpaidtable']['total_amount'] - $gaadiArray["expanse"]);

    return $gaadiArray;

}

function getPetiStokes($petiId){

    include("../include/connect.php");

    $sql = "SELECT
            SUM(CASE WHEN s.stoketype = 1 THEN s.nos ELSE 0 END) AS addedSum,
            SUM(CASE WHEN s.stoketype = 2 THEN s.nos ELSE 0 END) AS removedSum
            FROM `stokes` as s
            WHERE itemtype = 1 and itemid = ? GROUP BY itemid";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
              $stmt->bind_param("i", $petiId);
              if ($stmt->execute()) {
                $result = $stmt->get_result(); // Get the result set
                if ($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  return ((int)$row['addedSum'] - (int)$row['removedSum']);
                }
            }
        }
}

function getPetiDetails($petiId){

    include("../include/connect.php");

    $sql = "SELECT * FROM peti WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
              $stmt->bind_param("i", $petiId);
              if ($stmt->execute()) {
                $result = $stmt->get_result(); // Get the result set
                if ($result->num_rows > 0) {
                  return $row = $result->fetch_assoc();
                //   return ((int)$row['addedSum'] - (int)$row['removedSum']);
                }
            }
        }
}

// function insertData($tableName, $data, $types) {
//     include("../include/connect.php");

//     // Check connection
//     if ($conn->connect_error) {
//         die("Connection failed: " . $conn->connect_error);
//     }

//     // Prepare the SQL statement
//     $fields = implode(", ", array_keys($data));
//     $placeholders = implode(", ", array_fill(0, count($data), '?'));
//     $sql = "INSERT INTO $tableName ($fields) VALUES ($placeholders)";

//     // Prepare and bind
//     $stmt = $conn->prepare($sql);
//     if ($stmt === false) {
//         die("Error preparing statement: " . $conn->error);
//     }

//     // Dynamically bind parameters
//     $stmt->bind_param($types, ...array_values($data));

//     // Execute the statement
//     if ($stmt->execute() === false) {
//         die("Error executing statement: " . $stmt->error);
//     } else {
//         echo "Record inserted successfully.";
//     }

//     // Close the statement and connection
//     $stmt->close();
//     $conn->close();
// }

function insertData($tableName, $data, $types) {
    include("../include/connect.php");

    // Check connection
    if ($conn->connect_error) {
        return false;
    }

    // Prepare the SQL statement
    $fields = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), '?'));
    $sql = "INSERT INTO $tableName ($fields) VALUES ($placeholders)";

    // Prepare and bind
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false;
    }

    // Dynamically bind parameters
    $stmt->bind_param($types, ...array_values($data));

    // Execute the statement
    $result = $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    return $result;
}


function updateData($tableName, $data, $types, $where) {

    include("../include/connect.php");
    // Check connection
    if ($conn->connect_error) {
        return false;
    }

    // Prepare the SQL statement
    $fields = implode(" = ?, ", array_keys($data)) . " = ?";
    $sql = "UPDATE $tableName SET $fields WHERE $where";

    // Prepare and bind
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false;
    }

    // Dynamically bind parameters
    $stmt->bind_param($types, ...array_values($data));

    // Execute the statement
    $result = $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    return $result;
}

