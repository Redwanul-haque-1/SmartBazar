<?php session_start();
require_once("../../Common/DatabaseConnection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST['name']);
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];
    $phone = $_POST['phone'] ?? "";
    $address = $_POST['address'] ?? "";
    $gender = $_POST['gender'];
    $dob = $_POST['dob'] ?? null;
    $role = $_POST['role'];

    if (empty($email)) die("Email is required");
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) die("Invalid email format");

    $sql = "SELECT id FROM users WHERE LOWER(email)=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) die("Email already registered");

    $imgName = null;
    if (!empty($_FILES['profile_image']['name'])) {
        $file = $_FILES['profile_image'];
        if ($file['size'] > 2000000) die("Image too large");
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $imgName = time() . "_" . rand(100,999) . "." . $ext;
        move_uploaded_file($file['tmp_name'], "../public/uploads/".$imgName);
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $status = ($role === "Seller") ? "Pending" : "Approved";

    $sql = "INSERT INTO users 
    (name,email,phone,address,gender,dob,profile_image,password_hash,role,status)
    VALUES (?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name,$email,$phone,$address,$gender,$dob,$imgName,$hash,$role,$status]);

    echo "Registration successful. <a href='../../Common/login.php'>Login</a>";
}
?>
