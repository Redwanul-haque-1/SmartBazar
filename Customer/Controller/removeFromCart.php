<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Customer"){
    die("Unauthorized");
}

$id = $_POST['id'];

unset($_SESSION['cart'][$id]);

header("Location: ../View/cart.php");
exit;
?>
