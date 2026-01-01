<?php 
function updateStockDetails($itemId, $type, $itemNos, $stoketype){
    // global $res;
    include "../include/connect.php";
    $sql = "INSERT INTO `stokes` (itemid, itemtype, nos, stoketype) VALUES ( ? , ? , ? , ? )";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iiii", $itemId, $type , $itemNos , $stoketype);
        if ($stmt->execute()) {
            return 1;
            // echo "stoke updated";

            // $res = [
            //     'status' => true,
            //     'msg' => $conn->error
            // ];
        }else {
            // echo "something wrong";
            // $res = [
            //     'status' => false,
            //     'msg' => $conn->error
            // ];
        }
    }
}