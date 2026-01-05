<?php
session_start();
require_once("DatabaseConnection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST['name']);
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];
    
    if(strlen($password) < 8){
   die("Password must be at least 8 characters <br><a href='signup.php'>Back</a>");
    }

    $phone = $_POST['phone'] ?? "";
    $address = $_POST['address'] ?? "";
    $gender = $_POST['gender'];
    $dob = $_POST['dob'] ?? null;
    $role = $_POST['role'];

    if (empty($email)) die("Email is required");
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) die("Invalid email format<br><a href='signup.php'>Back</a>");

    $sql = "SELECT id FROM users WHERE LOWER(email)=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) die("Email already registered<br><a href='signup.php'>Back</a>");


// AJAX
    $sql = "SELECT id FROM users WHERE name=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name]);
    if($stmt->rowCount() > 0){
        die("Name already exists");
    }


    $uploadDir = "";

    if ($role === "Admin") {
        $uploadDir = "../Admin/public/uploads/";
    } 
    elseif ($role === "Seller") {
        $uploadDir = "../Seller/public/uploads/";
    } 
    elseif ($role === "Customer") {
        $uploadDir = "../Customer/public/uploads/";
    } 
    else {
        die("Invalid role selected");
    }

    $imgName = null;
    if (!empty($_FILES['profile_image']['name'])) {
        $file = $_FILES['profile_image'];
        if ($file['size'] > 2000000) die("Image too large");
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $imgName = time() . "_" . rand(100,999) . "." . $ext;
        move_uploaded_file($file['tmp_name'], $uploadDir .$imgName);
    }

    //$hash = password_hash($password, PASSWORD_DEFAULT);
	$hash = $password;
    $status = ($role === "Seller") ? "Pending" : "Approved";

    $sql = "INSERT INTO users 
    (name,email,phone,address,gender,dob,profile_image,password_hash,role,status)
    VALUES (?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name,$email,$phone,$address,$gender,$dob,$imgName,$hash,$role,$status]);

    echo "Registration successful. <a href='login.php'>Login</a>";
}
?>
