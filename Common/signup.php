<?php session_start(); ?>
<!DOCTYPE html>
<html><head>
<title>Register</title>
<link rel="stylesheet" href="../Admin/public/css/style.css">
<script src="JS/password.js" defer></script>
</head>
<body>



<!-- AJAX -->
<script>
let timer = null;

document.addEventListener("DOMContentLoaded", ()=>{

  const nameInput = document.getElementById("name");
  const msg = document.getElementById("nameMsg");

  nameInput.addEventListener("keyup", ()=>{

    clearTimeout(timer);   // debounce so it doesn’t spam server

    timer = setTimeout(()=>{

        let name = nameInput.value;

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                msg.innerHTML = this.responseText;

                if(this.responseText.includes("exists")){
                    msg.style.color = "red";
                } else {
                    msg.style.color = "green";
                }
            }
        };

        xhttp.open("POST", "checkName.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("name=" + encodeURIComponent(name));

    }, 100);
  });

});
</script>


<h2>Register</h2>
<form action="signUpValidation.php" method="POST" enctype="multipart/form-data">
<a href="index.php">⬅ Back</a><br><br>
<!-- <label>Name</label>
<input type="text" name="name" required> -->
<label>Name</label>
<input type="text" id="name" name="name" required>
<small id="nameMsg" style="color:red;"></small>

<label>Email</label>
<input type="email" name="email" required>

<label>Password</label>
<input type="password" id="password" name="password" required>
<small id="passMsg" style="color:red;"></small>
<br>
<label>Phone</label>
<input type="text" name="phone">

<label>Address</label>
<textarea name="address"></textarea>

<label>Gender</label>
<select name="gender" required>
<option>Male</option>
<option>Female</option>
<option>Other</option>
</select>

<label>Date of Birth</label>
<input type="date" name="dob">

<label>Profile Picture</label>
<input type="file" name="profile_image" accept="image/*">

<label>User Type</label>
<select name="role" required>
<option value="Customer">Customer</option>
<option value="Seller">Seller</option>
<option value="Admin">Admin</option>
</select>

<button type="submit">Register</button>
</form>
<br>
<a href="login.php">Already have an account?</a>
</body></html>
