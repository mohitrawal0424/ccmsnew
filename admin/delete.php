<?php
include "../include/connect.php";
include "../include/functions/updateStoke.php";
date_default_timezone_set("Asia/Calcutta");


//code to delete gaadidetails
if (isset($_GET['itemId'])) {

    $res = [];
    $id = (int)$_GET['itemId'];
    $sqlGET = "SELECT * FROM `gaadidetails` WHERE id = $id";
    $stmtget = $conn->prepare($sqlGET);

    if ($stmtget->execute()) {
        $results = $stmtget->get_result();
        $row = $results->fetch_assoc();

        $itemid = (int)$row["itemid"];
        $type = (int)$row["itemtype"];
        $itemNos = (int)$row["nos"];
    }

    $sql = "DELETE FROM `gaadidetails` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute() and updateStockDetails($itemid, $type, $itemNos, $stokeType = 1) == 1) {

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


//code to delete schemeId
if (isset($_GET['SchemeId'])) {

    $res = [];
    $itemId = (int)$_GET['SchemeId'];
    $sql = "DELETE FROM `scheme` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $itemId);
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

//code to delete gaadidetails
if (isset($_GET['itemIdCounter'])) {

    $res = [];
    $id = (int)$_GET['itemIdCounter'];
    $sqlGET = "SELECT * FROM `counterdetails` WHERE id = $id";
    $stmtget = $conn->prepare($sqlGET);

    if ($stmtget->execute()) {
        $results = $stmtget->get_result();
        $row = $results->fetch_assoc();

        $itemid = (int)$row["itemid"];
        $type = (int)$row["itemtype"];
        $itemNos = (int)$row["nos"];
    }

    $sql = "DELETE FROM `counterdetails` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute() and updateStockDetails($itemid, $type, $itemNos, $stokeType = 1) == 1) {

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
//code to delete peti
if (isset($_GET['petiDeleteId'])) {

    $res = [];
    $itemId = (int)$_GET['petiDeleteId'];
    $sql = "DELETE FROM `peti` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $itemId);
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

//code to delete bottle
if (isset($_GET['bottleDeleteId'])) {

    $res = [];
    $itemId = (int)$_GET['bottleDeleteId'];
    $sql = "DELETE FROM `product` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $itemId);
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

//delete expanse id's
if (isset($_GET['deleteExpanseId'])) {

    $id = (int)$_GET['deleteExpanseId'];

    $sql = "DELETE FROM `expanse` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo $message = 'Expanse Deleted Successfully !';
            header("Location:expanse.php?smessage=" . $message);
        } else {
            echo $message = 'Some Problem Please Try again !';
            header("Location:expanse.php?emessage=" . $message);
        }
    } else {
        echo $message = 'Error preparing the SQL statement.';
        header("Location:expanse.php?emessage=" . $message);
    }
}

//delete Owner/property/Rent
if (isset($_GET['deleteOwner']) or isset($_GET['deleteproperty']) or isset($_GET['deleteRentTrans']) or isset($_GET['deleteadvance'])) {
    if(isset($_GET['deleteOwner'])){
        $id = (int)$_GET['deleteOwner'];
        $table = 'rentpropertyowner';
        $redirect = 'propertyownertable=1';
    }
    if(isset($_GET['deleteproperty'])){
        $id = (int)$_GET['deleteproperty'];
        $table = 'rentedproperty';
        $redirect = 'propertytable=1';
    }
    if(isset($_GET['deleteRentTrans'])){
        $id = (int)$_GET['deleteRentTrans'];
        $table = 'rent_transaction';
        $redirect = 'renttable=1';
    }
    if(isset($_GET['deleteadvance'])){
        $id = (int)$_GET['deleteadvance'];
        $table = 'rentadvance';
        $redirect = 'advancetable=1';
    }

    $sql = "DELETE FROM `$table` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo $message = 'Entry Deleted Successfully !';
            header("Location:rent.php?".$redirect."&smessage=" . $message);
        } else {
            echo $message = 'Some Problem Please Try again !';
            header("Location:rent.php?".$redirect."&emessage=" . $message);
        }
    } else {
        echo $message = 'Error preparing the SQL statement.';
        header("Location:rent.php?".$redirect."&emessage=" . $message);
    }
}
