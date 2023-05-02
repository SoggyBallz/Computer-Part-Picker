<?php
error_reporting (0);
$db = mysqli_connect('localhost','girts','','pc_part_picker');
if(!$db)
{
  echo 'Connection error: '. mysqli_connect_error();
}
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $myemail = mysqli_real_escape_string($db, $_POST['email']);
  $mypassword = mysqli_real_escape_string($db, $_POST['password']);
  $res = mysqli_query($db, "SELECT id, password, admin FROM users WHERE email = '$myemail'");
  $row = mysqli_fetch_assoc($res);

  if(!filter_var($myemail, FILTER_VALIDATE_EMAIL)){
    $error = "Please enter a valid email address.";
  }
  elseif (empty($myemail) || empty($mypassword)){
    $error = "Please enter your email and password.";
  }
  elseif (!$row || !password_verify($mypassword, $row['password'])){
    $error = "Your Login Email or Password is invalid";
  }
  else{
    $_SESSION['login_user'] = $myemail;
    header($row['admin'] ? "location: admin.php" : "location: main.php");
  }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign In</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <h1>Computer Part Picker</h1>
  <div class="center-form">
	<form action="" method="post">
		<label for="email">Email:</label><br>
		<input type="email" name="email" class = "box"><br>

		<label for="password">Password:</label><br>
		<input type="password" name="password" class = "box"><br><br>

		<input type="submit" value="Sign in">
	</form>
  <a href=registration.php><button class="button">Register</button></a>
  <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php if (isset($error)){echo $error;}; ?></div>
  </div>
</body>
</html>