<?php
include("config.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST")
{
  // Email and password from form
  $myemail = mysqli_real_escape_string($db,$_POST['email']);
  $mypassword = mysqli_real_escape_string($db,$_POST['password']);
  $result = mysqli_query($db, "SELECT admin FROM users WHERE email = '$myemail' and password = '$mypassword'");
  $result = $result->fetch_array();
  $admin = intval($result[0]);

  if(!$admin)
  {
    $_SESSION['login_user'] = $myemail;
    header("location: game.php");
  }
  else if($admin)
  {
    $_SESSION['login_user'] = $myemail;
    header("location: admin.php");
  }
  else
  {
    $error = "Your Login Name or Password is invalid";
  }
}
?>
<html>
<head>
	<title>Sign In</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<form action="" method="post">
		<label for="email">Email:</label><br>
		<input type="text" name="email" class = "box"><br>

		<label for="password">Password:</label><br>
		<input type="password" name="password" class = "box"><br><br>

		<input type="submit" value="Sign in">
	</form>
    <div>
        <a href="registration.php"><button>Register</button></a>
    </div>
</body>
</html>