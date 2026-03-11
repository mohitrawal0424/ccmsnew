<?php
    
    $servername = "localhost";
    $username = "u211410577_ccms";
    $password = "Mv9z>RG78k#";
    $dbname = "u211410577_ccms";

    $conn = mysqli_connect($servername,$username,$password,$dbname);

    if(!$conn)
    {
        echo "Database connection error";
    }

?>
