<?php
session_start();
if(!isset($_SESSION['user_id'])){
    die("Unauthorized");
}

require_once("../../Common/DatabaseConnection.php");

$id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);   
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();



?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Profile</title>
<link rel="stylesheet" href="../public/css/styleEditProfile1.css">
</head>
<body>

<script src="../Controller/editProValidate.js" defer></script>

<div class = "edit-profile-box">
<h2>Edit Profile</h2>

<a href="profile.php">Back</a>


<form action="../Controller/updateProfile.php" method="POST" enctype="multipart/form-data">

<label>Name</label>
<input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
<br>

<label>Email</label>
<input type="text" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
<small id="emailMsg" style="color:red;"></small>
<br>


<label>Phone</label>
<input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">
<br>

<label>Address</label>
<textarea name="address"><?= htmlspecialchars($user['address']) ?></textarea>
<br>

<label>Gender</label>
<select name="gender">
<option <?= $user['gender']=="Male"?"selected":"" ?>>Male</option>
<option <?= $user['gender']=="Female"?"selected":"" ?>>Female</option>
<option <?= $user['gender']=="Other"?"selected":"" ?>>Other</option>
</select>
<br>

<label>Date of Birth</label>
<input type="date" name="dob" value="<?= $user['dob'] ?>" max="<?php echo date('Y-m-d'); ?>">
<br>

<label>Profile Image</label>
<input type="file" name="profile_image" accept="image/*">
<br>

<button type="submit">Save Changes</button>

</form>
</div>
</body>

</html>
