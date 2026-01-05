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
    $stmt->execute([$name]);

    if($stmt->rowCount() > 0){
        echo "This name already exists";
    } else {
        echo "Name available";
    }
}
