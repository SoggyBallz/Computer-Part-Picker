<?php
// Disable error reporting for production, comment out during development to see errors
error_reporting(0);

// Connect to the database
$db = mysqli_connect('localhost', 'girts', '', 'pc_part_picker');
if (!$db) {
  // Display an error message if the connection fails
  echo 'Connection error: ' . mysqli_connect_error();
}

// Start a session for user authentication
session_start();

// Check if the form is submitted (POST request)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Sanitize and retrieve user inputs
  $myemail = mysqli_real_escape_string($db, $_POST['email']);
  $mypassword = mysqli_real_escape_string($db, $_POST['password']);

  // Query the database to retrieve user information
  $res = mysqli_query($db, "SELECT id, password, admin FROM users WHERE email = '$myemail'");
  $row = mysqli_fetch_assoc($res);

  // Validate email address
  if (!filter_var($myemail, FILTER_VALIDATE_EMAIL)) {
    $error = "Please enter a valid email address.";
  } elseif (empty($myemail) || empty($mypassword)) {
    // Check if email and password are not empty
    $error = "Please enter your email and password.";
  } elseif (!$row || !password_verify($mypassword, $row['password'])) {
    // Check if the user exists and the password is correct
    $error = "Your Login Email or Password is invalid";
  } else {
    // Set session variable and redirect based on user role
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
    <!-- Sign-in form -->
    <form action="" method="post">
        <label for="email">Email:</label><br>
        <input type="email" name="email" class="box"><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" class="box"><br><br>

        <input type="submit" value="Sign in">
    </form>

    <!-- Link to registration page -->
    <a href="registration.php"><button class="button">Register</button></a>

    <!-- Display error message, if any -->
    <div style="font-size: 11px; color: #cc0000; margin-top: 10px">
        <?php if (isset($error)) { echo $error; }; ?>
    </div>
  </div>
</body>
</html>