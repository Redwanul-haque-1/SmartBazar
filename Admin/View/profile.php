<?php
session_start();
if(!isset($_SESSION['user_id'])){
    die("Unauthorized");
}



if(!isset($_COOKIE['user_email'])){
    
    // destroy session
    session_unset();
    session_destroy();

    // redirect to login
    header("Location: ../../Common/login.php?msg=session_expired");
    exit;
}




require_once("../../Common/DatabaseConnection.php");

$id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


$backLink = "#";

if ($_SESSION['role'] === "Admin") {
    $backLink = "adminDashboard.php";
 } 
//  elseif ($_SESSION['role'] === "Seller") {
//     $backLink = "../Dashboard/sellerDashboard.php";
// } elseif ($_SESSION['role'] === "Customer") {
//     $backLink = "../Dashboard/customerDashboard.php";
// }
?>

<!DOCTYPE html>
<html>
<head>
<title>My Profile</title>
<link rel="stylesheet" href="../public/css/style.css">
<style>
img{width:120px;height:120px;border-radius:10px;object-fit:cover}
</style>
</head>
<body>

<h2>My Profile</h2>

<a href="<?= $backLink ?>">⬅ Back</a>
<a href="../Controller/logout.php">Logout</a>

<hr>

<?php if($user['profile_image']): ?>
<img src="../public/uploads/<?= $user['profile_image'] ?>"><br>
<?php endif; ?>

<b>Name:</b> <?= htmlspecialchars($user['name']) ?><br>
<b>Email:</b> <?= htmlspecialchars($user['email']) ?><br>
<b>Phone:</b> <?= htmlspecialchars($user['phone']) ?><br>
<b>Address:</b> <?= htmlspecialchars($user['address']) ?><br>
<b>Gender:</b> <?= htmlspecialchars($user['gender']) ?><br>
<b>Date of Birth:</b> <?= htmlspecialchars($user['dob']) ?><br>
<b>Role:</b> <?= htmlspecialchars($user['role']) ?><br>

<hr>

<a href="editProfile.php">Edit Profile</a> |
<a href="changePassword.php">Change Password</a> |
<a onclick="return confirm('Delete your account? This cannot be undone')" href="deleteAccount.php">Delete Account</a>

</body>
</html>
