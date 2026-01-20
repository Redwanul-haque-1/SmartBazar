<?php
session_start();
if(!isset($_SESSION['user_id'])){
    die("Unauthorized");
}



if(!isset($_COOKIE['user_email'])){
    
    session_unset();
    session_destroy();

    header("Location: ../../Common/login.php?msg=session_expired");
    exit;
}




require_once("../../Common/DatabaseConnection.php");

$id = $_SESSION['user_id'];

/* (MySQLi) */
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id); 
$stmt->execute();

$result = $stmt->get_result();
$user = null;

while ($row = $result->fetch_assoc()) {
    $user = $row;
}


$backLink = "#";

if ($_SESSION['role'] === "Admin") {
    $backLink = "adminDashboard.php";
 } 

?>

<!DOCTYPE html>
<html>
<head>
<title>My Profile</title>
<link rel="stylesheet" href="../public/css/styleProfile1.css">

</head>
<body>

<div class="profile-box"> 

<h2>My Profile</h2>

<a href="<?= $backLink ?>">Back</a>
<a href="../Controller/logout.php">Logout</a>

<hr>

<?php if($user['profile_image']): ?>
<img src="../public/uploads/<?= $user['profile_image'] ?>"><br>
<?php endif; ?>

<b>Name:</b> <span class="profile-value"><?= htmlspecialchars($user['name']) ?></span><br>
<b>Email:</b> <span class="profile-value"><?= htmlspecialchars($user['email']) ?></span><br>
<b>Phone:</b> <span class="profile-value"><?= htmlspecialchars($user['phone']) ?></span><br>
<b>Address:</b> <span class="profile-value"><?= htmlspecialchars($user['address']) ?></span><br>
<b>Gender:</b> <span class="profile-value"><?= htmlspecialchars($user['gender']) ?></span><br>
<b>Date of Birth:</b> <span class="profile-value"><?= htmlspecialchars($user['dob']) ?></span><br>
<b>Role:</b> <span class="profile-value"><?= htmlspecialchars($user['role']) ?></span><br>


<hr>

<a href="editProfile.php">Edit Profile</a> |
<a href="changePassword.php">Change Password</a> |
<a onclick="return confirm('Delete your account? This cannot be undone')" href="../Controller/deleteAccount.php">Delete Account</a>
</div>

</body>
</html>
