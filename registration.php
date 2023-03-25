<?php
include("config.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
  $myemail = mysqli_real_escape_string($db,$_POST['email']);
  $mypassword = mysqli_real_escape_string($db,$_POST['password']);

  $chk_query = "SELECT * FROM user WHERE email='$myemail'";
  $chk_res = mysqli_query($db, $chk_query);

  if(mysqli_num_rows($chk_res) > 0){
    $error = "Error: Email already exists in the database.";
  }
  else
  {
    $sql = "INSERT INTO user (email, password, admin) VALUES ('$myemail', '$mypassword', 0)";

    if (mysqli_query($db, $sql))
    {
      header("Location: main.php");
    }
    else
    {
      echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }
  }
  mysqli_close($db);
}
?>
<html>
<head>
	<title>Register</title>
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

		<input type="submit" value="Register">
	</form>
</body>
</html>