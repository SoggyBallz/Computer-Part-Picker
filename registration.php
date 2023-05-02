<?php
$db = mysqli_connect('localhost','girts','','pc_part_picker');
if(!$db)
{
  echo 'Connection error: '. mysqli_connect_error();
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
  $myname = mysqli_real_escape_string($db,$_POST['name']);
  $myemail = mysqli_real_escape_string($db,$_POST['email']);
  $mypassword = password_hash(mysqli_real_escape_string($db,$_POST['password']), PASSWORD_DEFAULT);

  $chk_query = "SELECT * FROM users WHERE email='$myemail'";
  $chk_res = mysqli_query($db, $chk_query);

  if(!filter_var($myemail, FILTER_VALIDATE_EMAIL)){
    $error = "Please enter a valid email address.";
  }
  elseif(empty($myname) || empty($myemail) || empty($mypassword)){
    $error = "Please enter your name, email and password.";
  }
  else{
    if(mysqli_num_rows($chk_res) > 0){
      $error = "Error: Email already exists in the database.";
    }
    else
    {
      $sql = "INSERT INTO users (name, email, password, admin) VALUES ('$myname', '$myemail', '$mypassword', 0)";
  
      if (mysqli_query($db, $sql))
      {
        $_SESSION['login_user'] = $myemail;
        header("Location: main.php");
      }
      else
      {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
      }
    }
    mysqli_close($db);
  }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <h1><a style="text-decoration:none; color:blue;" href=index.php>Computer Part Picker</a></h1>
  <div class="center-form">
	<form action="" method="post">
    <label for="name">Name:</label><br>
		<input type="name" name="name" class = "box"><br>

		<label for="email">Email:</label><br>
		<input type="email" name="email" class = "box"><br>

		<label for="password">Password:</label><br>
		<input type="password" name="password" class = "box"><br><br>

		<input type="submit" value="Register">
    <div style = "font-size:14px; color:#cc0000; margin-top:10px"><?php if (isset($error)){echo $error;}; ?></div>
	</form>
  </div>
</body>
</html>