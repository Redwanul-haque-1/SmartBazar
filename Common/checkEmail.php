
<?php
session_start();
require_once("DatabaseConnection.php");

if (!isset($_SESSION['user_id'])) exit;

if (isset($_POST['email'])) {

    $email = strtolower(trim($_POST['email']));
    $uid   = $_SESSION['user_id'];

    if ($email === "") exit;

    // allow user's own email
    $sql = "SELECT id FROM users WHERE LOWER(email)=? AND id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $email, $uid);
    $stmt->execute();

    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        echo "Email already exists";
    } else {
        echo "OK";
    }
}
?>