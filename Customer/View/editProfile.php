<?php
session_start();
if(!isset($_SESSION['user_id'])){
    die("Unauthorized");
}

require_once("../Model/DatabaseConnection.php");

$id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Profile</title>
<link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

<h2>Edit Profile</h2>

<a href="profile.php">⬅ Back</a>

<hr>

<form action="updateProfile.php" method="POST" enctype="multipart/form-data">

<label>Name</label>
<input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

<label>Phone</label>
<input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">

<label>Address</label>
<textarea name="address"><?= htmlspecialchars($user['address']) ?></textarea>

<label>Gender</label>
<select name="gender">
<option <?= $user['gender']=="Male"?"selected":"" ?>>Male</option>
<option <?= $user['gender']=="Female"?"selected":"" ?>>Female</option>
<option <?= $user['gender']=="Other"?"selected":"" ?>>Other</option>
</select>

<label>Date of Birth</label>
<input type="date" name="dob" value="<?= $user['dob'] ?>">

<label>Profile Image</label>
<input type="file" name="profile_image" accept="image/*">

<button type="submit">Save Changes</button>

</form>

</body>
</html>
