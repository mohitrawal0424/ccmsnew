<?php
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ccms";

    $conn = mysqli_connect($servername,$username,$password,$dbname);

    if(!$conn)
    {
        echo "Database connection error";
    }

?>
