<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== "Seller") {
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$seller_id = $_SESSION['user_id'];

$id          = $_POST['id'];
$name        = trim($_POST['name']);
$price       = $_POST['price'];
$category_id = $_POST['category_id'];

if ($name === "" || $price === "") {
    die("Name & Price required");
}

/* VERIFY OWNERSHIP  */
$check = $conn->prepare("SELECT image FROM products WHERE id = ? AND seller_id = ?");
$check->bind_param("ii", $id, $seller_id);
$check->execute();

$result = $check->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Unauthorized product update");
}

$image = $product['image'];

if (!empty($_FILES['image']['name'])) {

    $file = $_FILES['image'];

    if ($file['size'] > 2000000) {
        die("Image too large");
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $image = time() . "_" . rand(100,999) . "." . $ext;

    move_uploaded_file($file['tmp_name'], "../public/uploads/" . $image);
}

$sql = "UPDATE products 
        SET name = ?, price = ?, category_id = ?, image = ? 
        WHERE id = ? AND seller_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sdissi",
    $name,
    $price,
    $category_id,
    $image,
    $id,
    $seller_id
);

$stmt->execute();

header("Location: ../View/products.php");
exit;
?>
