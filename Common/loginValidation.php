<?php
session_start();
require_once("DatabaseConnection.php");

$email = strtolower(trim($_POST['email']));
$password = $_POST['password'];


$sql = "SELECT * FROM users WHERE LOWER(email) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);   
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();   






if ($user && $password === $user['password_pass'])
{

    if ($user['status'] === "Blocked") die
	("
        <h3>Your account is blocked</h3>
        <a href='login.php'> Back</a>
    ");
    if ($user['status'] === "Pending") die
	("
        <h3>Waiting for admin approval</h3>
        <a href='login.php'> Back</a>
    ");

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['name'] = $user['name'];


 setcookie("user_email", $email, time() + 500, "/");



    if ($user['role']=="Admin") header("Location: ../Admin/View/adminDashboard.php");
    if ($user['role']=="Seller") header("Location: ../Seller/View/sellerDashboard.php");
    if ($user['role']=="Customer") header("Location: ../Customer/View/customerDashboard.php");

} else {
    echo "Invalid login";

}
?>
<br>
<a href="login.php"> Back</a><br><br>
