<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "Customer"){
    die("Unauthorized");
}

require_once("../Model/DatabaseConnection.php");

$customer_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'] ?? [];

if(empty($cart)){
    die("Cart is empty");
}

// calculate total
$total = 0;
foreach($cart as $item){
    $total += $item['qty'] * $item['price'];
}

// create order
$orderSql = "INSERT INTO orders(customer_id,total,status) VALUES(?,?,?)";
$stmt = $conn->prepare($orderSql);
$stmt->execute([$customer_id,$total,"Placed"]);
$order_id = $conn->lastInsertId();

// insert items
$itemSql = "INSERT INTO order_items(order_id,product_id,quantity,price)
            VALUES(?,?,?,?)";
$itemStmt = $conn->prepare($itemSql);

foreach($cart as $pid=>$item){
    $itemStmt->execute([$order_id,$pid,$item['qty'],$item['price']]);
}

// clear cart
unset($_SESSION['cart']);

echo "Order placed successfully! <a href='../Customer/shop.php'>Shop more</a>";
?>
