<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Customer"){
    die("Unauthorized");
}

$id = $_POST['id'];
$qty = max(1, intval($_POST['qty']));

if(isset($_SESSION['cart'][$id])){
    $_SESSION['cart'][$id]['qty'] = $qty;
}

header("Location: ../View/cart.php");
exit;
?>
