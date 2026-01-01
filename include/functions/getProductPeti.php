<?php 

function getProductName($id){
    $ids = (int)$id;
    include("../include/connect.php");
                                
        $sql = "SELECT * FROM `product` Where id = ? ";
        $stmt = $conn-> prepare($sql);
        $product = [];
        if ($stmt) {
            $stmt->bind_param("i", $ids);
            if ($stmt->execute()) {
                $result = $stmt->get_result(); // Get the result set
                if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                        $product['name'] = $row["name"];
                        $product['size'] = $row["size"];
                        }
                }
            }
        } 
        return $product;
}

function getPetiName($id){
    $ids = (int)$id;
    include("../include/connect.php");
                                
        $sql = "SELECT p.*, pr.name, pr.size FROM `peti` as p INNER JOIN product as pr ON p.product_id = pr.id WHERE p.id = ?";
        $stmt = $conn-> prepare($sql);
        $peti = [];
        if ($stmt) {
            $stmt->bind_param("i", $ids);
            if ($stmt->execute()) {
                $result = $stmt->get_result(); // Get the result set
                if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                        $peti['name'] = $row["name"];
                        $peti['size'] = $row["size"];
                        $peti['bottleNos'] = $row["bottleNos"];
                        }
                }
            }
        } 
        return $peti;
}


?>