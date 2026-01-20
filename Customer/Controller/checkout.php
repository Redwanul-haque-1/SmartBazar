<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Customer"){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$customer_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'] ?? [];

if(empty($cart)){
    die("Cart is empty");
}

// total amount
$total = 0;
foreach($cart as $item){
    $total += $item['qty'] * $item['price'];
}


$orderSql = "INSERT INTO orders (customer_id, total, status) VALUES (?, ?, ?)";
$stmt = $conn->prepare($orderSql);
$status = "Placed";
$stmt->bind_param("ids", $customer_id, $total, $status);
$stmt->execute();

$order_id = $conn->insert_id;

// insert items
$itemSql = "INSERT INTO order_items (order_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?)";
$itemStmt = $conn->prepare($itemSql);

foreach ($cart as $pid => $item) {
    $itemStmt->bind_param(
        "iiid",
        $order_id,
        $pid,
        $item['qty'],
        $item['price']
    );
    $itemStmt->execute();
}

unset($_SESSION['cart']);

echo "Order placed successfully! <a href='../View/shop.php'>Shop more</a>";
?>
