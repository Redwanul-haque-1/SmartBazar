<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Customer"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$id = $_POST['id'];
$qty = max(1, intval($_POST['qty']));

$sql = "SELECT id,name,price,image FROM products WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$product){
    die("Product not found");
}

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

// if item exists → add qty
if(isset($_SESSION['cart'][$id])){
    $_SESSION['cart'][$id]['qty'] += $qty;
} else {
    $_SESSION['cart'][$id] = [
        "name" => $product['name'],
        "price" => $product['price'],
        "image" => $product['image'],
        "qty" => $qty
    ];
}

header("Location: ../View/cart.php");
exit;
?>
