<?php

include "../include/connect.php";
include "../include/functions/functions.php";
date_default_timezone_set("Asia/Calcutta");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// code to add staff into table
if (isset($_POST['addStaffSubmit'])) {
    $id = (int)$_POST['id'];
    include "../include/connect.php";

    $dor = (string)($_POST['dor']);
    $name = htmlspecialchars($_POST['name']);
    $fname = htmlspecialchars($_POST['fname']);
    $salary = (int)$_POST['salary'];
    $aadhar = htmlspecialchars($_POST['aadhar']);
    $comments = htmlspecialchars($_POST['comments']);

    // Define the SQL query using INSERT INTO ... ON DUPLICATE KEY UPDATE
    $sql = "INSERT INTO `staff`(`id`, `dor`, `name`, `fname`, `salary`, `aadhar`, `comments`) VALUES (?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE `dor` = VALUES(`dor`), `name` = VALUES(`name`), `fname` = VALUES(`fname`), `salary` = VALUES(`salary`), `aadhar` = VALUES(`aadhar`), `comments` = VALUES(`comments`)";
    $stmt = $conn->prepare($sql);

    // Check if the SQL query is prepared successfully
    if ($stmt) {
        $stmt->bind_param("isssiss", $id, $dor, $name, $fname, $salary, $aadhar, $comments);

        // Check if the parameters are bound successfully
        if ($stmt->execute()) {
            $message = 'Staff Added/Updated Successfully !';
            header("Location:staff.php?smessage=" . $message);
        } else {
            $message = 'Some Problem Please Try again !';
            header("Location:staff.php?emessage=" . $message);
        }
    } else {
        // Handle the error if the SQL query preparation fails
        $message = 'Error preparing the SQL statement.';
        header("Location:staff.php?emessage=" . $message);
    }
}

//code to delete from staff table (but not from db table)
if (isset($_GET['staffId'])) {
    $staffId = (int)$_GET['staffId'];
    $sql = "UPDATE `staff` SET `delete_status`= 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $staffId);
        if ($stmt->execute()) {
            echo 1;
        }
    }
}

//code to add/update attendence for attendance table

if (isset($_GET["staffIdForAttend"]) && isset($_GET["date"]) && isset($_GET["attendType"]) && isset($_GET["dateOfJoining"])) {
    $response = [];

    $staffId = (int)$_GET["staffIdForAttend"];
    $date = (string)$_GET["date"];
    $attendType = (int)$_GET["attendType"];
    $dateOfJoining = (int)$_GET["dateOfJoining"];

    $sqlDOJCheck = "SELECT dor FROM `staff` WHERE id= ? ";
    $stmt2 = $conn->prepare($sqlDOJCheck);
    if ($stmt2) {
        $stmt2->bind_param("i", $staffId);
        if ($stmt2->execute()) {
            $result2 = $stmt2->get_result();
            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
                $attendDate = strtotime($date);
                $DOJ = strtotime($row2['dor']);
                $todayDate = strtotime(date("Y-m-d"));
                if ($attendDate < $DOJ or $attendDate > $todayDate) {
                    $response = [
                        'status' => false,
                        'error' => 'Please Select Date After Joining Date of Staff'
                    ];
                    echo json_encode($response);
                    die;
                }
            }
        }
    }

    $sql = "SELECT * FROM `attendance` where dateOfAttendance = ? and staffId = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("si", $date, $staffId);
        if ($stmt->execute()) {
            $result = $stmt->get_result(); // Get the result set
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $rowId = (int)$row['id'];
                $sqlUpdate = "UPDATE `attendance` SET `status`= ? where id = ?";
                $stmt = $conn->prepare($sqlUpdate);
                if ($stmt) {
                    $stmt->bind_param("ii", $attendType, $rowId);
                    if ($stmt->execute()) {
                        $response = [
                            'status' => true,
                            'msg' => 'Attendence Done'
                        ];
                        echo json_encode($response);
                    }
                }
            } else {
                $sql = "INSERT INTO `attendance`(`staffId`, `dateOfAttendance`, `status`) VALUES ( ? , ? , ? )";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("isi", $staffId, $date, $attendType);
                    if ($stmt->execute()) {
                        $response = [
                            'status' => true,
                            'msg' => 'Attendence Done'
                        ];
                        echo json_encode($response);
                    } else {
                        $response = [
                            'status' => false,
                            'error' => 'Query not executed'
                        ];
                        echo json_encode($response);
                    }
                } else {
                    $response = [
                        'status' => false,
                        'error' => 'query not prepared properly'
                    ];
                    echo json_encode($response);
                }
            }
        }
    }
}


// code to redirect date to staff.php

if (isset($_GET['submitDate'])) {
    $date = $_GET['attendanceDate'];
    header("Location:./staff.php?datequery=" . $date);
}


// cod to enter advance details in advance table
if (isset($_POST['giveAdvanceSubmit'])) {
    include "../include/connect.php";

    $staffId = (int)$_POST['idForAdvance'];
    $dor = (string)($_POST['doAdvance']);
    $advanceAmount = (int)$_POST['advanceAmount'];
    $comments = htmlspecialchars($_POST['comments']);

    // Define the SQL query using INSERT INTO ... ON DUPLICATE KEY UPDATE
    $sql = "INSERT INTO `advance`(`staffId`, `dateOfAdvance`, `amount`, `comments`) VALUES ( ? , ? , ? , ? )";
    $stmt = $conn->prepare($sql);

    // Check if the SQL query is prepared successfully
    if ($stmt) {
        $stmt->bind_param("isis", $staffId, $dor, $advanceAmount, $comments);

        // Check if the parameters are bound successfully
        if ($stmt->execute()) {
            $message = 'Advance Added Successfully !';
            header("Location:profile.php?staffId=" . $staffId . "&smessage=" . $message);
        } else {
            $message = 'Some Problem Please Try again !';
            // echo mysqli_error($conn);
            header("Location:profile.php?staffId=" . $staffId . "&emessage=" . $message);
        }
    } else {
        // Handle the error if the SQL query preparation fails
        $message = 'Error preparing the SQL statement.';
        header("Location:profile.php?staffId=" . $staffId . "&emessage=" . $message);
    }
}


//code get data from select Month and Year form to redirect to same 
if (isset($_GET['selectMonthSubmit'])) {
    $staffId = (int)$_GET['idForSelectMonth'];
    $monthYear = (string)$_GET['selectMonth'];
    header("Location:profile.php?staffId=" . $staffId . "&monthYear=" . $monthYear);
}

//code get staffid from profile and redirect to same 
if (isset($_GET['sumbitInputStaffId'])) {
    $staffId = (int)$_GET['inputStaffId'];
    header("Location:profile.php?staffId=" . $staffId);
}

// code to add Manager into Db table
if (isset($_POST['addManagerSubmit'])) {
    $id = (int)$_POST['id'];
    include "../include/connect.php";

    $dor = (string)($_POST['dor']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Check if the username has changed or if it's a new record
    $isUsernameChanged = true; // Initialize as true by default
    $originalUsername = null; // To store the original username

    if ($id > 0) {
        $sqlOriginalUsername = "SELECT `username` FROM `user` WHERE `id` = ?";
        $stmtOriginalUsername = $conn->prepare($sqlOriginalUsername);
        if ($stmtOriginalUsername) {
            $stmtOriginalUsername->bind_param('i', $id);
            if ($stmtOriginalUsername->execute()) {
                $resultOriginalUsername = $stmtOriginalUsername->get_result();
                if ($resultOriginalUsername->num_rows > 0) {
                    $originalUsername = $resultOriginalUsername->fetch_assoc()['username'];
                    $isUsernameChanged = $originalUsername !== $username;
                }
            }
        }
    }

    if ($isUsernameChanged) {
        // The username has changed, so check for its existence
        $sqlUsernameCheck = "SELECT * FROM `user` WHERE `username` = ?";
        $stmtUsernameCheck = $conn->prepare($sqlUsernameCheck);
        if ($stmtUsernameCheck) {
            $stmtUsernameCheck->bind_param('s', $username);
            if ($stmtUsernameCheck->execute()) {
                $resultsUsernameCheck = $stmtUsernameCheck->get_result();
                if ($resultsUsernameCheck->num_rows > 0) {
                    $message = 'This Username already Exist! Use a different Username';
                    header("Location:managers.php?emessage=" . $message);
                    exit; // Stop further execution
                }
            }
        }
    }

    // Define the SQL query using INSERT INTO ... ON DUPLICATE KEY UPDATE
    $sql = "INSERT INTO `user`(`id`, `dor`, `username`, `password`) VALUES (?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE `dor` = VALUES(`dor`), `username` = VALUES(`username`), `password` = VALUES(`password`)";
    $stmt = $conn->prepare($sql);

    // Check if the SQL query is prepared successfully
    if ($stmt) {
        $stmt->bind_param("isss", $id, $dor, $username, $password);
        // Check if the parameters are bound successfully
        if ($stmt->execute()) {
            $message = $id > 0 ? 'Staff Updated Successfully!' : 'Staff Added Successfully!';
            header("Location:managers.php?smessage=" . $message);
        } else {
            $message = 'Some Problem Please Try again!';
            header("Location:managers.php?emessage=" . $message);
        }
    } else {
        // Handle the error if the SQL query preparation fails
        $message = 'Error preparing the SQL statement.';
        header("Location:managers.php?emessage=" . $message);
    }
}



//code to delete manager from table and database both
if (isset($_GET['managerId'])) {
    $res = [];
    $managerId = (int)$_GET['managerId'];
    $sql = "UPDATE `user` SET `delete_status`= 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $managerId);
        if ($stmt->execute()) {
            $res = [
                'status' => true,
                'msg' => 'Delete Done'
            ];
            echo json_encode($res);
        } else {
            $res = [
                'status' => false,
                'msg' => 'query not executed'
            ];
            echo json_encode($res);
        }
    } else {
        $res = [
            'status' => false,
            'msg' => 'query not prepared'
        ];
        echo json_encode($res);
    }
}

//code to delete advance entry from table and database both
if (isset($_GET['advanceDBid'])) {
    $res = [];
    $advanceDBid = (int)$_GET['advanceDBid'];
    $sql = "DELETE FROM `advance` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $advanceDBid);
        if ($stmt->execute()) {
            $res = [
                'status' => true,
                'msg' => 'Delete Done'
            ];
            echo json_encode($res);
        } else {
            $res = [
                'status' => false,
                'msg' => 'query not executed'
            ];
            echo json_encode($res);
        }
    } else {
        $res = [
            'status' => false,
            'msg' => 'query not prepared'
        ];
        echo json_encode($res);
    }
}


//code to delete from staff table (but not from db table)
if (isset($_GET['staffIdClose']) && isset($_GET['doc'])) {
    $staffId = (int)$_GET['staffIdClose'];
    $doc = (string)$_GET['doc'];
    $sql = "UPDATE `staff` SET `status`= 0 , `doc` = ? WHERE id = ? ";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("si", $doc, $staffId);
        if ($stmt->execute()) {
            echo 1;
        }
    }
}

//code to enter product details in product table
if (isset($_GET['productName']) and isset($_GET['bottleSize']) and isset($_GET['price']) and isset($_GET['bprice'])) {
    if (isset($_GET['id'])) {
        $id = (int)$_GET["id"];
    }
    $productName = (string)$_GET['productName'];
    $bottleSize = (int)$_GET['bottleSize'];
    $price = (float)$_GET['price'];
    $bprice = (float)$_GET['bprice'];

    $res = [];
    // $sql = "INSERT INTO `product` (`name`, `size`, `price`, `bprice`) values ( ?, ?, ? , ?)";
    $sql = "INSERT INTO `product`(`id`, `name`, `size`, `price`, `bprice`) VALUES (?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `size` = VALUES(`size`), `price` = VALUES(`price`), `bprice` = VALUES(`bprice`)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("isiii", $id, $productName, $bottleSize, $price, $bprice);
        if ($stmt->execute()) {
            $res = [
                'status' => true,
                'msg' => 'Product Created Successfully ( प्रोडक्ट बना दिया गया है !)'
            ];
            echo json_encode($res);
        } else {
            $res = [
                'status' => false,
                'msg' => 'Somthing Wrong ( कुछ खराबी है ! )'
            ];
            echo json_encode($res);
        }
    } else {
        $res = [
            'status' => false,
            'msg' => 'Somthing Wrong ( कुछ खराबी है ! )'
        ];
        echo json_encode($res);
    }
}

//code to enter bottle Peti details in DB
if (isset($_GET['productId']) and isset($_GET['bottleNos']) and isset($_GET['priceSet']) and isset($_GET['bpriceSet'])) {
    $productId = (int)$_GET['productId'];
    $bottleNos = (int)$_GET['bottleNos'];
    $priceSet = (float)$_GET['priceSet'];
    $bpriceSet = (float)$_GET['bpriceSet'];

    $res = [];
    $sql = "INSERT INTO `peti` (`product_id`, `bottleNos`, `price`, `bprice`) values ( ?, ?, ?, ? )";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iiii", $productId, $bottleNos, $priceSet, $bpriceSet);
        if ($stmt->execute()) {
            $res = [
                'status' => true,
                'msg' => 'Product Set/Box Successfully ( प्रोडक्ट Set/Box दिया गया है !)'
            ];
            echo json_encode($res);
        } else {
            $res = [
                'status' => false,
                'msg' => 'Somthing Wrong ( कुछ खराबी है ! )'
            ];
            echo json_encode($res);
        }
    } else {
        $res = [
            'status' => false,
            'msg' => 'Somthing Wrong ( कुछ खराबी है ! )'
        ];
        echo json_encode($res);
    }
}

//code to enter Peti Stokes into DB
if (isset($_GET['productId']) and isset($_GET['productSetId']) and isset($_GET['units'])) {
    $productId = (int)$_GET['productId'];
    $productSetId = (int)$_GET['productSetId'];
    $units = (int)$_GET['units'];

    $res = [];
    $sql = "INSERT INTO `stokesbox` (`product_id`, `productset_id`, `units`) values ( ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iii", $productId, $productSetId, $units);
        if ($stmt->execute()) {
            $res = [
                'status' => true,
                'msg' => 'Product Set/Box Successfully ( प्रोडक्ट Set/Box दिया गया है !)'
            ];
            echo json_encode($res);
        } else {
            $res = [
                'status' => false,
                'msg' => 'Somthing Wrong ( कुछ खराबी है ! )'
            ];
            echo json_encode($res);
        }
    } else {
        $res = [
            'status' => false,
            'msg' => $conn->error
        ];
        echo json_encode($res);
    }
}

//code to enter Bottle Stokes into DB
if ((isset($_GET['productIdB']) || isset($_GET['petiId'])) && (isset($_GET['unitsBottle']) || isset($_GET['unitsPeti']))) {

    $itemid = isset($_GET['productIdB']) ? (int)$_GET['productIdB'] : (int)$_GET['petiId'];
    $itemtype = isset($_GET['productIdB']) ? 0 : 1;
    $nos = isset($_GET['unitsBottle']) ? (int)$_GET['unitsBottle'] : (int)$_GET["unitsPeti"];
    $stokeType = isset($_GET['stokeType']) ? (int)$_GET['stokeType'] : 1;


    $sql = "INSERT INTO `stokes` (`itemid`, `itemtype`, `nos`, `stoketype`) values ( ? , ? , ? , ? )";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iiii", $itemid, $itemtype, $nos, $stokeType);
        if ($stmt->execute()) {
            $res = [
                'status' => true,
                'msg' => 'Product/Peti stoke added Successfully ( प्रोडक्ट/Peti stoke add दिया गया है !)'
            ];
            echo json_encode($res);
        } else {
            $res = [
                'status' => false,
                'msg' => 'Somthing Wrong ( कुछ खराबी है ! )'
            ];
            echo json_encode($res);
        }
    } else {
        $res = [
            'status' => false,
            'msg' => 'Somthing Wrong ( कुछ खराबी है ! )'
        ];
        echo json_encode($res);
    }
}

//code to enter gaadi details in DB;
if (isset($_GET['addProductBtnInGaadi']) || isset($_GET['addPetiBtnInGaadi'])) {

    $res = [];
    $message = "";
    $gaadiId = (int)$_GET['gaadiId'];
    $table = 'gaadidetails';
    $gaadiORcounter = "gaadid";

    if ($_GET['bottleNos'] == "" and $_GET['petiNos'] == "") {
        $message =  "Enter One peti or product";
        header("location:./loadGaadi.php?receiverid=" . $gaadiId . "&message=" . $message);
        die;
    }

    $itemId = $_GET['bottleNos'] == "" ? (int)$_GET['petiDetails'] : (int)$_GET['productDetails'];
    $type = $_GET['bottleNos'] == "" ? 1 : 0;
    $itemNos = $_GET['bottleNos'] == "" ? (int)$_GET['petiNos'] : (int)$_GET['bottleNos'];

    $availableStoke = itemStokeDetail($itemId, $type);

    if ($availableStoke["nums"] < $itemNos) {
        $message =  "Stoke not available";
        header("location:./loadGaadi.php?receiverid=" . $gaadiId . "&message=" . $message);
        die;
    }

    // check if the same petiID/productID is already used then just add amount on this
    $itemIdExists = isItemExists($itemId, $type, $gaadiId, $table);

    if ($itemIdExists['num_rows'] == 1) {
        $oldNos = (int)($itemIdExists['nos']);
        $accumlativeNos = $oldNos + $itemNos;
        $message = updateDetails($itemIdExists['id'], $accumlativeNos, $itemId, $type, $itemNos, $table);
    } else {
        $isInScheme = 0;
        $message = insertDetails($itemId, $type, $itemNos, $gaadiId, $isInScheme, $table, $gaadiORcounter);
    }

    $gaadiAddDate = strtotime($_GET["gaadiAddDate"]);
    $gaadiEndDate = time();


    $sqlScheme = "SELECT * FROM `scheme`";
    $stmtScheme = $conn->prepare($sqlScheme);
    if ($stmtScheme->execute()) {
        $resultScheme = $stmtScheme->get_result();
        if ($resultScheme->num_rows > 0) {
            while ($rowScheme = $resultScheme->fetch_assoc()) {
                $schemeEndDate = time();
                if (strtotime($rowScheme["startdate"]) >= strtotime($gaadiAddDate)) {
                    $fromNos = (int)$rowScheme["fromNos"];
                    $toNos = (int)$rowScheme["toNos"];
                    $rounds = intval($itemNos / $fromNos);
                    $toId = (int)$rowScheme["toItemID"];
                    $toType = (int)$rowScheme["toItemType"];
                    $toNos = (int)$rowScheme["toNos"];

                    if ($rowScheme["fromItemID"] == $itemId and $rowScheme["fromItemType"] == $type) {
                        $isInScheme = 1;
                        for ($x = 1; $x <= $rounds; $x++) {
                            insertDetails($toId, $toType, $toNos, $gaadiId, $isInScheme, $table, $gaadiORcounter);
                            $message = "Item Added";
                        }
                    }
                }
            }
        }
    }

    //res
    header("location:./loadGaadi.php?receiverid=" . $gaadiId . "&message=" . $message);
}


// Create Gaadi and store in DB

if (isset($_POST['submitReceiver'])) {

    $gaadiReceiverId = (int)$_POST['receiverid'];
    $gaadiName = isset($_POST['gaadiName']) ? $_POST['gaadiName'] : NULL;
    $dateofGaadi = $_POST['dateofGaadi'];
    $createdBy = (int)$_POST["createdBy"];


    $sql = "INSERT INTO `gaadis` (`date`, `receiverid`, `name`,`createby`) values ( ? , ? , ? , ? )";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sisi", $dateofGaadi, $gaadiReceiverId, $gaadiName, $createdBy);
        if ($stmt->execute()) {
            // I want to return id just created with above insert query
            $lastInsertId = $conn->insert_id;

            header("location:./loadGaadi.php?receiverid=" . $lastInsertId);
            exit();
        } else {
            echo $message = "something Wrong";
        }
    } else {
        echo $message = "something Wrong";
    }
}

// just to redirect Gaadi id to same page
if (isset($_POST["submitGaadiID"])) {
    $gaadiIDD = (int)$_POST["enterGaadiID"];
    $sql = "SELECT * FROM `gaadis` WHERE id = ? and isSold = 0";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $gaadiIDD);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                header("location:./loadGaadi.php?receiverid=" . $gaadiIDD);
                exit();
            } else {
                $message = "Gaadi id not Found ( कृपया सही गाडी नंबर डालिये ! )";
                header("location:./loadGaadi.php?emessage=" . $message);
            }
        } else {
            $message = "something Wrong";
            header("location:./loadGaadi.php?emessage=" . $message);
        }
    } else {
        $message = "something Wrong";
        header("location:./loadGaadi.php?emessage=" . $message);
    }
}

// apply discount gaadis
if (isset($_GET["applydiscount"])) {
    if ($_GET["discountINR"]) {
        $discount = (int)$_GET["discountINR"];
        $returnUrl = "loadGaadi.php";
    }
    if ($_GET["discountINRreturn"]) {
        $discount = (int)$_GET["discountINRreturn"];
        $returnUrl = "returnGaadi.php";
    }
    $gaadiId = (int)$_GET["gaadiId"];

    $sql = "UPDATE `gaadis` SET `discount`= ? WHERE `id` = ? ";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $discount, $gaadiId);
        if ($stmt->execute()) {
            header("location:./" . $returnUrl . "?receiverid=" . $gaadiId . "&discount=" . $discount);
            exit();
        } else {
            $message = "Discount Not Applied ! somthing wrong";
            header("location:./" . $returnUrl . "?emessage=" . $message);
        }
    } else {
        $message = "Discount Not Applied ! somthing wrong";
        header("location:./" . $returnUrl . "?emessage=" . $message);
    }
}

// add Scheme in DB 
if (isset($_POST["schemesubmit"])) {
    $fromScheme = $_POST["fromScheme"];
    $fromItemNos = (int)$_POST["fromitem"];
    $toScheme = $_POST["toScheme"];
    $toItemNos = (int)$_POST["toitem"];
    $startDate = $_POST["schemeStartDate"];
    $endDate = $_POST["schemeEndDate"] == "" ? NULL : $_POST["schemeEndDate"];

    list($fromItemId, $fromItemType) = explode("-", $fromScheme);
    list($toItemId, $toItemType) = explode("-", $toScheme);

    $sql = "INSERT INTO `scheme`(`startdate`,`enddate`,`fromItemID`, `fromItemType`, `fromNos`, `toItemID`, `toItemType`, `toNos`) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssiiiiii", $startDate, $endDate, $fromItemId, $fromItemType, $fromItemNos, $toItemId, $toItemType, $toItemNos);
        if ($stmt->execute()) {
            $message = "Scheme Added Successfully";
            header("location:./scheme.php?smessage=" . $message);
            // echo $conn->error;
            exit();
        } else {
            $message = "Somthing Wrong (scheme not added)";
            header("location:./scheme.php?emessage=" . $message);
            // echo $conn->error;

        }
    } else {
        $message = "Somthing Wrong (scheme not added)";
        header("location:./scheme.php?emessage=" . $message);
        // echo $conn->error;

    }
}

// Sold/Close entry in DB of Gaddi
if (isset($_GET["soldCloseGaadi"])) {

    $entry = 1;
    $gaadiId = (int)$_GET["gaadiId"];
    $date = date('Y-m-d');

    $person_id = (int)$_GET["person_id"];
    $amount = (int)$_GET["remainingAmountHidden"];
    $type = 1;

    $sql = "UPDATE `gaadis` SET `isSold`= ? , `closedate` = ?, `remaining_amount` = ? WHERE `id` = ? ";
    $stmt = $conn->prepare($sql);

    $sql2 = "INSERT INTO `person_balance`(`person_id`, `amount`, `type`,`gaadi`) VALUES ( ? , ? , ? , ? )";
    $stmt2 = $conn->prepare($sql2);

    if ($stmt and $stmt2) {
        $stmt->bind_param("isii", $entry, $date, $amount ,$gaadiId);
        $stmt2->bind_param("iiii", $person_id, $amount, $type, $gaadiId);

        if ($stmt->execute() and $stmt2->execute()) {
            header("location:./closedGaadi.php?receiverid=" . $gaadiId);
            exit();
        } else {
            // echo $conn->error;
            $message = "Gaadi Not Closed ! something wrong";
            header("location:./loadGaadi.php?emessage=" . $message);
        }
    } else {
        // echo $conn->error;
        $message = "Gaadi Not Closed ! something wrong";
        header("location:./loadGaadi.php?emessage=" . $message);
    }
}

//finally submit all Gaadi Details
if (isset($_GET["submitGaadiAllDetails"])) {
    $id = (int)$_GET["gaadiIDD"];
    $totalbill = (int)$_GET["totalBill"];

    addTotalBill($totalbill, $id);
    header("location:./loadGaadi.php");
}

// retrun peti 
if (isset($_GET["id"]) and isset($_GET["returnQuantity"])) {

    $id = (int)$_GET["id"];
    $soldQuantity = (int)$_GET["returnQuantity"];
    $itemType = (int)$_GET['itemType'];
    $gaadiID = (int)$_GET['gaadiID'];
    $response = [];

    $sql = "INSERT INTO `solditems`(`idFromGaadiDetails`, `nos`, `itemType`, `gaadiID`) VALUES ( ? , ? , ? , ? )";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iiii", $id, $soldQuantity, $itemType, $gaadiID);
        if ($stmt->execute()) {
            $message = "Added Successfully";
            $response = [
                'status' => true,
                'error' => 'Added Successfully'
            ];
            echo json_encode($response);
            exit();
        } else {
            $message = "Somthing Wrong (scheme not added)";
            $response = [
                'status' => false,
                'error' => $conn->error
            ];
            echo json_encode($response);
        }
    } else {
        $message = "Somthing Wrong (scheme not added)";
        $response = [
            'status' => false,
            'error' => $conn->error
        ];
        echo json_encode($response);
    }
}

// Return Items in Counter
if (isset($_GET["requestName"]) && ($_GET["requestName"] == "counterQuatityReturn")) {
    $response = [];

    $tableName = (string)$_GET["table"];
    $id = (int)$_GET["tableId"];
    $data['nos'] = $updatedQuantity = (int)$_GET['updatedQuantity'];
    $where = "id = ".$id;

    //preparing data for stoke updation
    $stokeUpdateData = [];
    $stokeUpdateData['itemid'] = $_GET['itemId'];
    $stokeUpdateData['itemtype'] = $_GET['itemType'];
    $stokeUpdateData['nos'] = $_GET['returnQuantity'];
    $stokeUpdateData['stoketype'] = 1;

    include("../include/connect.php");

    // Start a transaction
    $conn->begin_transaction();

    try {
        $result1 = updateData($tableName, $data, 'i', $where);
        $result2 = insertData('stokes', $stokeUpdateData, 'iiii');

        if ($result1 && $result2) {
            $conn->commit();
            $response['status'] = true;
            $response['msg'] = "stoke Updated";
            echo json_encode($response);
        } else {
            $conn->rollback();
            $response['status'] = false;
            $response['msg'] = "Failed to insert all records";
            echo json_encode($response);
        }
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        $response['status'] = false;
        $response['msg'] = 'Error occurred: ' . $e->getMessage();
        echo json_encode($response);
    }

    // Close connection
    $conn->close();
}

//code to enter Leakage/shortage Bottle Stokes into DB
if ((isset($_GET['DproductIdB']) || isset($_GET['DpetiId'])) && (isset($_GET['DunitsBottle']) || isset($_GET['DunitsPeti']))) {

    $itemid = isset($_GET['DproductIdB']) ? (int)$_GET['DproductIdB'] : (int)$_GET['DpetiId'];
    $itemtype = isset($_GET['DproductIdB']) ? 0 : 1;
    $nos = isset($_GET['DunitsBottle']) ? (int)$_GET['DunitsBottle'] : (int)$_GET["DunitsPeti"];
    $stokeType = 1;

    $petiStoke = getPetiStokes($itemid);
    $response = [];
    if ($petiStoke > 0) {

        $petiDetails = getPetiDetails($itemid);
        $bottleNos_in_Peti = $petiDetails['bottleNos'];
        $bottleId = $petiDetails['product_id'];

        $effectedPetis = ceil($nos / $bottleNos_in_Peti); //petis to deduct from stoke db
        $effectedPetisData = [
            "itemid" => $itemid,
            "itemtype" => 1,
            "nos" => $effectedPetis,
            "stoketype" => 2
        ];

        $sepratedBottles = $bottleNos_in_Peti * $effectedPetis - $nos; //bottles to enter in stoke
        $sepratedBottlesData = [
            "itemid" => $bottleId,
            "itemtype" => 0,
            "nos" => $sepratedBottles,
            "stoketype" => 1
        ];

        $leakageBottleData = [
            "itemid" => $bottleId,
            "itemtype" => 0,
            "nos" => $nos,
            "stoketype" => 1
        ];

        include("../include/connect.php");

        // Start a transaction
        $conn->begin_transaction();

        try {
            // Attempt to insert data
            $result1 = insertData('stokes', $sepratedBottlesData, 'iiii');
            $result2 = insertData('stokes', $effectedPetisData, 'iiii');
            $result3 = insertData('defectstokes', $leakageBottleData, 'iiii');

            // Check if all inserts were successful
            if ($result1 && $result2 && $result3) {
                // Commit transaction
                $conn->commit();
                $response['status'] = true;
                $response['msg'] = "stoke Updated";
                echo json_encode($response);
            } else {
                // Rollback transaction
                $conn->rollback();
                $response['status'] = false;
                $response['msg'] = "Failed to insert all records";
                echo json_encode($response);
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $conn->rollback();
            $response['status'] = false;
            $response['msg'] = 'Error occurred: ' . $e->getMessage();
            echo json_encode($response);
        }

        // Close connection
        $conn->close();
    } else {
        $response['status'] = false;
        $response['msg'] = "Stoke Not Found";
        echo json_encode($response);
    }


    // $sql = "INSERT INTO `defectstokes` (`itemid`, `itemtype`, `nos`, `stoketype`) values ( ? , ? , ? , ? )";
    // $stmt = $conn->prepare($sql);
    // if ($stmt) {
    //     $stmt->bind_param("iiii", $itemid, $itemtype, $nos, $stokeType);
    //     if ($stmt->execute()) {
    //         $res = [
    //             'status' => true,
    //             'msg' => 'Product/Peti stoke added Successfully ( प्रोडक्ट/Peti stoke add दिया गया है !)'
    //         ];
    //         echo json_encode($res);
    //     } else {
    //         $res = [
    //             'status' => false,
    //             'msg' => 'Somthing Wrong ( कुछ खराबी है ! )'
    //         ];
    //         echo json_encode($res);
    //     }
    // } else {
    //     $res = [
    //         'status' => false,
    //         'msg' => 'Somthing Wrong ( कुछ खराबी है ! )'
    //     ];
    //     echo json_encode($res);
    // }
}

// code to add person into table
if (isset($_POST['addPersonSubmit'])) {
    include "../include/connect.php";
    $name = htmlspecialchars($_POST['name']);

    // Define the SQL query using INSERT INTO ... ON DUPLICATE KEY UPDATE
    $sql = "INSERT INTO `person`(`name`) VALUES ( ? )";
    $stmt = $conn->prepare($sql);

    // Check if the SQL query is prepared successfully
    if ($stmt) {
        $stmt->bind_param("s", $name);

        // Check if the parameters are bound successfully
        if ($stmt->execute()) {
            $message = 'Person Added/Updated Successfully !';
            header("Location:products.php?smessage=" . $message);
        } else {
            $message = 'Some Problem Please Try again !';
            header("Location:products.php?emessage=" . $message);
        }
    } else {
        // Handle the error if the SQL query preparation fails
        $message = 'Error preparing the SQL statement.';
        header("Location:products.php?emessage=" . $message);
    }
}

// Transfer amount from manager to admin
if (isset($_GET['availAmount']) and isset($_GET['amount']) and isset($_GET['mode']) and isset($_GET['managerId_1']) and isset($_GET['gaadiId'])) {
    include "../include/connect.php";
    
    $availAmount = (int)$_GET['availAmount'];
    $amount = (int)$_GET['amount'];
    $managerId = (int)$_GET['managerId_1'];
    $gaadiId = (int)$_GET['gaadiId'];
    $mode = (int)$_GET['mode'];
    // echo json_encode($availAmount, $amount, $managerId, $gaadiId, $mode);

    $sql = "INSERT INTO `transfertoowner`(`senderid`, `amount`, `mode`, `gaadi`) VALUES ( ? , ? , ? , ? )";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("iiii", $managerId, $amount, $mode, $gaadiId);
        if ($stmt->execute()) {
            $res = [
                'status' => true,
                'msg' => 'EveryThing is fine'
            ];
            echo json_encode($res);
        } else {
            $res = [
                'status' => false,
                'msg' => 'Somthing Wrong ( कुछ खराबी है ! )'
            ];
            echo json_encode($res);
        }
    } else {
        $res = [
            'status' => false,
            'msg' => 'Somthing Wrong ( कुछ खराबी है ! )'
        ];
        echo json_encode($res);
    }
}

// code to add Counter Customer details into table
if (isset($_POST['addCustomerSubmit'])) {
    $id = (int)$_POST['id'];
    include "../include/connect.php";

    $dor = (string)($_POST['dor']);
    $name = htmlspecialchars($_POST['name']);
    $shopname = htmlspecialchars($_POST['shop']);
    $phone = (int)($_POST['ph']);

    // Define the SQL query using INSERT INTO ... ON DUPLICATE KEY UPDATE
    $sql = "INSERT INTO `customer`(`id`, `dor`, `name`, `shopname`, `phone`) VALUES (?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE `dor` = VALUES(`dor`), `name` = VALUES(`name`), `shopname` = VALUES(`shopname`), `phone` = VALUES(`phone`)";
    $stmt = $conn->prepare($sql);

    // Check if the SQL query is prepared successfully
    if ($stmt) {
        $stmt->bind_param("isssi", $id, $dor, $name, $shopname, $phone);

        // Check if the parameters are bound successfully
        if ($stmt->execute()) {
            echo $message = 'Customer Added/Updated Successfully !';
            header("Location:customers.php?smessage=" . $message);
        } else {
            // echo $conn->error;
            echo $message = 'Some Problem Please Try again !';
            header("Location:customers.php?emessage=" . $message);
        }
    } else {
        // Handle the error if the SQL query preparation fails
        echo $message = 'Error preparing the SQL statement.';
        header("Location:customers.php?emessage=" . $message);
    }
}

//code to delete from staff table (but not from db table)
if (isset($_GET['deleteCustId'])) {
    $Id = (int)$_GET['deleteCustId'];
    $sql = "UPDATE `customer` SET `isDeleted`= 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $Id);
        if ($stmt->execute()) {
            echo 1;
        }
    }
}

// Create Counter and store in DB

if (isset($_POST['submitCounter'])) {

    $counterReceiverId = (int)$_POST['receiverid'];
    // $gaadiName = isset($_POST['gaadiName']) ? $_POST['gaadiName'] : NULL;
    $dateofGaadi = $_POST['dateofCounter'];
    $createdBy = (int)$_POST["createdBy"];


    $sql = "INSERT INTO `counter`(`receiverid`, `created_by`, `date`) VALUES (? , ? , ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iis", $counterReceiverId, $createdBy, $dateofGaadi);
        if ($stmt->execute()) {
            // I want to return id just created with above insert query
            $lastInsertId = $conn->insert_id;

            header("location:./counter.php?counterid=" . $lastInsertId);
            exit();
        } else {
            echo $message = "something Wrong";
        }
    } else {
        echo $message = "something Wrong";
    }
}

//code to enter counter details in DB;

if (isset($_GET['addProductBtnInCounter']) || isset($_GET['addPetiBtnInCounter']) || isset($_GET["returnPetisSubmit"])) {

    $res = [];
    $message = "";
    $CounterId = (int)$_GET['counterId'];
    $table = 'counterdetails';
    $gaadiORcounter = "counterid";

    if ($_GET['bottleNos'] == "" and $_GET['petiNos'] == "") {
        $message =  "Enter One peti or product";
        header("location:./counter.php?counterid=" . $CounterId . "&message=" . $message);
        die;
    }

    $itemId = $_GET['bottleNos'] == "" ? (int)$_GET['petiDetails'] : (int)$_GET['productDetails'];
    $type = $_GET['bottleNos'] == "" ? 1 : 0;
    $itemNos = $_GET['bottleNos'] == "" ? (int)$_GET['petiNos'] : (int)$_GET['bottleNos'];

    $availableStoke = itemStokeDetail($itemId, $type);

    if ($availableStoke["nums"] < $itemNos) {
        $message =  "Stoke not available";
        header("location:./counter.php?counterid=" . $CounterId . "&message=" . $message);
        die;
    }


    // check if the same petiID/productID is already used then just add amount on this
    $itemIdExists = isItemExists($itemId, $type, $CounterId, $table);
    // print_r($itemIdExists);

    if ($itemIdExists['num_rows'] == 1) {
        echo "exists";
        $oldNos = (int)($itemIdExists['nos']);
        $accumlativeNos = $oldNos + $itemNos;
        $message = updateDetails($itemIdExists['id'], $accumlativeNos, $itemId, $type, $itemNos, $table);
    } else {
        echo " not exists";
        $isInScheme = 0;
        $message = insertDetails($itemId, $type, $itemNos, $CounterId, $isInScheme,  $table, $gaadiORcounter);
    }

    $gaadiAddDate = strtotime($_GET["CounterAddDate"]);
    $gaadiEndDate = time();


    $sqlScheme = "SELECT * FROM `scheme`";
    $stmtScheme = $conn->prepare($sqlScheme);
    if ($stmtScheme->execute()) {
        $resultScheme = $stmtScheme->get_result();
        if ($resultScheme->num_rows > 0) {
            while ($rowScheme = $resultScheme->fetch_assoc()) {
                $schemeEndDate = time();
                if (strtotime($rowScheme["startdate"]) >= strtotime($gaadiAddDate)) {
                    $fromNos = (int)$rowScheme["fromNos"];
                    $toNos = (int)$rowScheme["toNos"];
                    $rounds = intval($itemNos / $fromNos);
                    $toId = (int)$rowScheme["toItemID"];
                    $toType = (int)$rowScheme["toItemType"];
                    $toNos = (int)$rowScheme["toNos"];

                    if ($rowScheme["fromItemID"] == $itemId and $rowScheme["fromItemType"] == $type) {
                        $isInScheme = 1;
                        for ($x = 1; $x <= $rounds; $x++) {
                            insertDetails($toId, $toType, $toNos, $CounterId, $isInScheme, $table, $gaadiORcounter);
                            $message = "Item Added";
                        }
                    }
                }
            }
        }
    }

    //res
    header("location:./counter.php?counterid=" . $CounterId . "&message=" . $message);
}

//finally submit all counter Details

if (isset($_GET["submitCounterAllDetails"])) {
    $id = (int)$_GET["counterid"];
    $totalbill = (int)$_GET["totalBill"];

    addTotalBillCounter($totalbill, $id);
    header("location:./counter.php");
}

// just to redirect Gaadi id to same page
if (isset($_POST["submitCounterID"])) {
    $counterID = (int)$_POST["enterCounterID"];
    $sql = "SELECT * FROM `counter` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $counterID);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                header("location:./counter.php?counterid=" . $counterID);
                exit();
            } else {
                $message = "Gaadi id not Found ( कृपया सही गाडी नंबर डालिये ! )";
                header("location:./counter.php?emessage=" . $message);
            }
        } else {
            $message = "something Wrong";
            header("location:./counter.php?emessage=" . $message);
        }
    } else {
        $message = "something Wrong";
        header("location:./counter.php?emessage=" . $message);
    }
}

// apply discount counter
if (isset($_GET["applyCounterdiscount"])) {
    $discount = (int)$_GET["discountCounter"];
    $counterid = (int)$_GET["counterid"];

    $sql = "UPDATE `counter` SET `discount`= ? WHERE `id` = ? ";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $discount, $counterid);
        if ($stmt->execute()) {
            header("location:./counter.php?counterid=" . $counterid . "&discount=" . $discount);
            exit();
        } else {
            $message = "Discount Not Applied ! somthing wrong";
            header("location:./counter.php?emessage=" . $message);
        }
    } else {
        $message = "Discount Not Applied ! somthing wrong";
        header("location:./counter.php?emessage=" . $message);
    }
}

// pay amount counter
if (isset($_GET["payamountsubmit"])) {
    $amountPaid = (int)$_GET["payamount"];
    $counterid = (int)$_GET["counterid"];

    $sql = "UPDATE `counter` SET `amountpaid`= ? WHERE `id` = ? ";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $amountPaid, $counterid);
        if ($stmt->execute()) {
            header("location:./counter.php?counterid=" . $counterid . "&amountpaid=" . $amountPaid);
            exit();
        } else {
            $message = "Amount Not Paid ! somthing wrong";
            header("location:./counter.php?emessage=" . $message);
        }
    } else {
        $message = "Amount Not Paid ! somthing wrong";
        header("location:./counter.php?emessage=" . $message);
    }
}

//payamount gaadi
if (isset($_GET["payamountsubmitgaadi"])) {
    //not required now bcoz removed from addgaadipage

    // if(isset($_GET["payamount"])){
    //     $amountPaid = (int)$_GET["payamount"];
    //     $returnUrl = "loadGaadi.php";
    //     $type = NULL;
    // }
    if (isset($_GET["payamountreturn"])) {
        $amountPaid = (int)$_GET["payamountreturn"];
        $returnUrl = "returnGaadi.php";
        $type = $_GET["payamounttype"];
    }
    $gaadiid = (int)$_GET["gaadiId"];

    $sql = "INSERT INTO `amountpaidgaadis`(`gaadi`, `amount`, `type`) VALUES ( ? , ? , ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iii", $gaadiid, $amountPaid, $type);
        if ($stmt->execute()) {
            header("location:./" . $returnUrl . "?receiverid=" . $gaadiid . "&amountpaid=" . $amountPaid);
            exit();
        } else {
            echo $conn->error;
            $message = "Amount Not Paid ! somthing wrong";
            header("location:./" . $returnUrl . "?receiverid=" . $gaadiid . "&emessage=" . $message);
        }
    } else {
        echo $conn->error;
        $message = "Amount Not Paid ! somthing wrong";
        header("location:./" . $returnUrl . "?receiverid=" . $gaadiid . "&emessage=" . $message);
    }
}

// Close Counter Entry on clicking of close Btn
if (isset($_GET["closecounterid"])) {
    echo $counterid = (int)$_GET["closecounterid"];
    // echo "Hello";die;

    $sql = "UPDATE `counter` SET `isClosed`= 1 WHERE `id` = ? ";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $counterid);
        if ($stmt->execute()) {
            header("location:./counter.php");
            exit();
        } else {
            $message = "Counter Not closed ! somthing wrong";
            header("location:./counter.php?emessage=" . $message);
        }
    } else {
        $message = "Counter Not closed ! somthing wrong";
        header("location:./counter.php?emessage=" . $message);
    }
}


// ajax return for invoice counter download
if (isset($_POST["counterIdforInvoice"])) {

    $dataArray = [];
    $counterId = (int)$_POST["counterIdforInvoice"];

    //fetching counter details and adding in Array

    $sql = "SELECT g.*,s.name as recName,s.shopname FROM `counter` as g 
            INNER JOIN `customer` as s ON g.receiverid = s.id
            WHERE g.id = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $counterId);
        if ($stmt->execute()) {
            $result = $stmt->get_result(); // Get the result set
            if ($result->num_rows > 0) {
                $rows = $result->fetch_assoc();
                foreach ($rows as $key => $row) {
                    $dataArray['counter'][$key] = $row;
                }
            }
        }
    }
    //checking is counter really available
    if (empty($dataArray)) {
        $dataArray['status'] = false;
        echo json_encode($dataArray);
        die;
    }


    // fetching productdetails and adding in array
    $sql2 = "SELECT *,gd.id as gdid, pr.price as selPrice,pr.id as productID FROM `counterdetails` as gd
                      INNER JOIN product as pr ON gd.itemid = pr.id
                      WHERE gd.itemtype = 0 and gd.counterid = $counterId";

    $stmt2 = $conn->prepare($sql2);
    $productTotalAmount = [];
    if ($stmt2) {
        if ($stmt2->execute()) {
            $results2 = $stmt2->get_result();
            if ($results2->num_rows > 0) {
?>
                                                    <?php
                                                    $i = 1;
                                                    while ($row2 = $results2->fetch_assoc()) {
                                                        $sellingPrice = (int)$row2["selPrice"];
                                                        $nos = (int)$row2['nos'];
                                                        $totPrice = $sellingPrice * $nos;

                                                        if ($row2["IsInScheme"] == 1) {
                                                            $dataArray['productlist'][$i]['name'] = $row2['name'] . " (" . convertToLitre($row2['size']) . ")";
                                                            $dataArray['productlist'][$i]['nos'] = $row2['nos'];
                                                            $dataArray['productlist'][$i]['price'] = 'FREE';
                                                        } else {
                                                            $productTotalAmount[] = $totPrice;

                                                            $dataArray['productlist'][$i]['name'] = $row2['name'] . " (" . convertToLitre($row2['size']) . ")";
                                                            $dataArray['productlist'][$i]['nos'] = $row2['nos'];
                                                            $dataArray['productlist'][$i]['price'] = $totPrice;
                                                        }
                                                        $i++;
                                                    }
                                                }
                                            }
                                        }

                                        // fetching petidetails and adding in array
                                        $sql4 = "SELECT gd.*, pr.name as name , pr.size as size ,p.price as sellPrice, p.bottleNos,p.id as petiID FROM `counterdetails` as gd
INNER JOIN peti as p ON gd.itemid = p.id
INNER JOIN product as pr ON p.product_id = pr.id
WHERE gd.itemtype = 1 and gd.counterid = $counterId";

                                        $stmt4 = $conn->prepare($sql4);
                                        $productTotalAmount = [];
                                        if ($stmt4) {
                                            if ($stmt4->execute()) {
                                                $results4 = $stmt4->get_result();
                                                if ($results4->num_rows > 0) {
                                                    ?>
                              <?php
                                                    //   $i = 1;
                                                    while ($row4 = $results4->fetch_assoc()) {
                                                        $sellingPrice = (int)$row4["sellPrice"];
                                                        $nos = (int)$row4['nos'];
                                                        $totPrice = $sellingPrice * $nos;

                                                        if ($row4["IsInScheme"] == 1) {

                                                            $dataArray['productlist'][$i]['name'] = $row4['name'] . convertToLitre($row4['size']) . " (" . $row4['bottleNos'] . "Nos )";
                                                            $dataArray['productlist'][$i]['nos'] = $row4['nos'];
                                                            $dataArray['productlist'][$i]['price'] = 'FREE';
                                                        } else {

                                                            $dataArray['productlist'][$i]['name'] = $row4['name'] . " " . convertToLitre($row4['size']) . " (" . $row4['bottleNos'] . " Nos)";
                                                            $dataArray['productlist'][$i]['nos'] = $row4['nos'];
                                                            $dataArray['productlist'][$i]['price'] = $totPrice;
                                                        }
                                                        $i++;
                                                    }
                                                }
                                            }
                                        }

                                        echo json_encode($dataArray);
                                    }

                                    // add Expanse in DB
                                    if (isset($_POST['addExpanseSubmit']) or isset($_GET["addExpanseSubmit"])) {
                                        $id = (int)$_POST['id'];

                                        if ((empty($_GET["payexpanse"]) and empty($_GET['expType'])) or (empty($_GET["payexpanse"]) or empty($_GET['expType']))) {
                                            $message = 'Please expanse Type and amount ';
                                            header("Location:" . $redirectUrl . "?emessage=" . $message);
                                        }

                                        $dor = isset($_POST['dor']) ? $_POST['dor'] : date("Y-m-d");
                                        $expanseType = isset($_POST['expType']) ? htmlspecialchars($_POST['expType']) : htmlspecialchars($_GET['expType']);
                                        $amount = isset($_POST['amount']) ? (int)$_POST['amount'] : (int)$_GET["payexpanse"];
                                        $gaadi =  isset($_GET["gaadiId"]) ? (int)$_GET["gaadiId"] : NULL;
                                        $redirectUrl = isset($_POST['addExpanseSubmit']) ? "expanse.php" : "returnGaadi.php?receiverid=" . $gaadi;


                                        // Define the SQL query using INSERT INTO ... ON DUPLICATE KEY UPDATE
                                        $sql = "INSERT INTO `expanse`(`id`, `dor`,`expType`,`amount`,`gaadi_id`) VALUES (?, ?, ?, ? , ?)
            ON DUPLICATE KEY UPDATE `dor` = VALUES(`dor`), `expType` = VALUES(`expType`), `amount` = VALUES(`amount`), `gaadi_id` = VALUES(`gaadi_id`)";
                                        $stmt = $conn->prepare($sql);

                                        if ($stmt) {
                                            $stmt->bind_param("issii", $id, $dor, $expanseType, $amount, $gaadi);

                                            if ($stmt->execute()) {
                                                echo $message = 'Expanse Added Successfully !';
                                                header("Location:" . $redirectUrl . "?smessage=" . $message);
                                            } else {
                                                // echo $conn->error;
                                                echo $message = 'Some Problem Please Try again !';
                                                header("Location:" . $redirectUrl . "?emessage=" . $message);
                                            }
                                        } else {
                                            // Handle the error if the SQL query preparation fails
                                            echo $message = 'Error preparing the SQL statement.';
                                            header("Location:" . $redirectUrl . "?emessage=" . $message);
                                        }
                                    }

                                    // Add property owner in DB
                                    if (isset($_POST['rentownersubmit'])) {
                                        $id = (int)$_POST['id'];
                                        include "../include/connect.php";

                                        echo $date = $_POST['date'];
                                        echo $name = htmlspecialchars($_POST['name']);

                                        // Define the SQL query using INSERT INTO ... ON DUPLICATE KEY UPDATE
                                        $sql = "INSERT INTO `rentpropertyowner`(`id`, `name`,`date`) VALUES (?, ?, ? )
            ON DUPLICATE KEY UPDATE `date` = VALUES(`date`), `name` = VALUES(`name`)";
                                        $stmt = $conn->prepare($sql);

                                        // Check if the SQL query is prepared successfully
                                        if ($stmt) {
                                            $stmt->bind_param("iss", $id, $name, $date);

                                            // Check if the parameters are bound successfully
                                            if ($stmt->execute()) {
                                                echo $message = 'Customer Added/Updated Successfully !';
                                                header("Location:rent.php?smessage=" . $message);
                                            } else {
                                                // echo $conn->error;
                                                echo $message = 'Some Problem Please Try again !';
                                                header("Location:rent.php?emessage=" . $message);
                                            }
                                        } else {
                                            // Handle the error if the SQL query preparation fails
                                            echo $message = 'Error preparing the SQL statement.';
                                            header("Location:rent.php?emessage=" . $message);
                                        }
                                    }

                                    // Add property owner in DB
                                    if (isset($_POST['rentpropertysubmit'])) {
                                        $id = (int)$_POST['id'];
                                        include "../include/connect.php";

                                        $date = $_POST['date'];
                                        $name = htmlspecialchars($_POST['name']);
                                        $owner_id = (int)$_POST['owner'];


                                        // Define the SQL query using INSERT INTO ... ON DUPLICATE KEY UPDATE
                                        $sql = "INSERT INTO `rentedproperty`(`id`, `name`,`owner_id`,`date`) VALUES (?, ?, ? , ?)
            ON DUPLICATE KEY UPDATE `date` = VALUES(`date`), `name` = VALUES(`name`), `owner_id` = VALUES(`owner_id`)";
                                        $stmt = $conn->prepare($sql);

                                        // Check if the SQL query is prepared successfully
                                        if ($stmt) {
                                            $stmt->bind_param("isis", $id, $name, $owner_id, $date);

                                            // Check if the parameters are bound successfully
                                            if ($stmt->execute()) {
                                                echo $message = 'Customer Added/Updated Successfully !';
                                                header("Location:rent.php?smessage=" . $message);
                                            } else {
                                                // echo $conn->error;
                                                echo $message = 'Some Problem Please Try again !';
                                                header("Location:rent.php?emessage=" . $message);
                                            }
                                        } else {
                                            // Handle the error if the SQL query preparation fails
                                            echo $message = 'Error preparing the SQL statement.';
                                            header("Location:rent.php?emessage=" . $message);
                                        }
                                    }

                                    // Add rent trans in DB
                                    if (isset($_POST['rententrysubmit'])) {
                                        $id = (int)$_POST['id'];
                                        include "../include/connect.php";

                                        $date = $_POST['date'];
                                        $amount = (int)$_POST['amount'];
                                        $property = (int)$_POST['property'];
                                        $trans_type = (int)$_POST['trans_type'];


                                        // Define the SQL query using INSERT INTO ... ON DUPLICATE KEY UPDATE
                                        $sql = "INSERT INTO `rent_transaction`(`id`, `property_id`,`trans_type`,`date`,`amount`) VALUES (?, ?, ? , ? , ?)
            ON DUPLICATE KEY UPDATE `date` = VALUES(`date`), `trans_type` = VALUES(`trans_type`), `property_id` = VALUES(`property_id`), `amount` = VALUES(`amount`)";
                                        $stmt = $conn->prepare($sql);

                                        // Check if the SQL query is prepared successfully
                                        if ($stmt) {
                                            $stmt->bind_param("iiisi", $id, $property, $trans_type, $date, $amount);

                                            // Check if the parameters are bound successfully
                                            if ($stmt->execute()) {
                                                echo $message = 'Customer Added/Updated Successfully !';
                                                header("Location:rent.php?smessage=" . $message);
                                            } else {
                                                // echo $conn->error;
                                                echo $message = 'Some Problem Please Try again !';
                                                header("Location:rent.php?emessage=" . $message);
                                            }
                                        } else {
                                            // Handle the error if the SQL query preparation fails
                                            echo $message = 'Error preparing the SQL statement.';
                                            header("Location:rent.php?emessage=" . $message);
                                        }
                                    }

                                    // Add rent trans in DB
                                    if (isset($_POST['advancesubmitowner'])) {
                                        $id = (int)$_POST['id'];
                                        include "../include/connect.php";

                                        $date = $_POST['date'];
                                        $amount = (int)$_POST['amount'];
                                        $owner = (int)$_POST['owner'];


                                        // Define the SQL query using INSERT INTO ... ON DUPLICATE KEY UPDATE
                                        $sql = "INSERT INTO `rentadvance`(`id`, `date`,`ownerid`,`amount`) VALUES (?, ?, ? , ?)
            ON DUPLICATE KEY UPDATE `date` = VALUES(`date`), `ownerid` = VALUES(`ownerid`), `amount` = VALUES(`amount`)";
                                        $stmt = $conn->prepare($sql);

                                        // Check if the SQL query is prepared successfully
                                        if ($stmt) {
                                            $stmt->bind_param("isii", $id, $date, $owner, $amount);

                                            // Check if the parameters are bound successfully
                                            if ($stmt->execute()) {
                                                echo $message = 'Advance Added Successfully !';
                                                header("Location:rent.php?smessage=" . $message);
                                            } else {
                                                echo $message = 'Some Problem Please Try again !';
                                                header("Location:rent.php?emessage=" . $message);
                                            }
                                        } else {
                                            // echo $conn->error;
                                            // Handle the error if the SQL query preparation fails
                                            echo $message = 'Error preparing the SQL statement.';
                                            header("Location:rent.php?emessage=" . $message);
                                        }
                                    }
