<?php
require_once("DatabaseConnection.php");

if(isset($_POST['name'])){
    
    $name = trim($_POST['name']);

    if($name === ""){
        echo "";
        exit;
    }

    $sql = "SELECT id FROM users WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);   
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "This name already exists";
    } else {
        echo "Name available";
    }
}
