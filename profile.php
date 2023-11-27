<?php
error_reporting(0);
$db = mysqli_connect('localhost', 'girts', '', 'pc_part_picker');
if (!$db) {
  echo 'Connection error: ' . mysqli_connect_error();
}
session_start();

$myemail = $_SESSION['login_user'];
$res = mysqli_query($db, "SELECT name, password FROM users WHERE email = '$myemail'");
$row = mysqli_fetch_assoc($res);
$newPassword = $_POST["newPassword"];
$newPassword1 = $_POST["againnewPassword"];

if ($newPassword == $newPassword1) {
    $sql = "UPDATE users SET password = '$newPassword' WHERE email = '$myemail'";
}
else {
    $error = "Passwords does't match";
}
if (isset($_POST['delete_profile'])) {
  // Perform actions to delete the profile
  // You may want to add additional confirmation steps or validation
  $delete_sql = "DELETE FROM users WHERE email = '$myemail'";
  mysqli_query($db, $delete_sql);
  header("Location: index.php"); // Redirect to the homepage or a login page after deletion
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Profile</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script>
        function confirmDelete() {
            var confirmDelete = confirm("Are you sure you want to delete your profile?");
            if (confirmDelete) {
                // If the user confirms, submit the form with the delete_profile action
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</head>
<header>
    <nav>
      <ul>
        <li><a href="main.php">Home</a></li>
        <li><a href="build.php">Build a Computer</a></li>
        <li><a href="prebuilds.php">Pre-Builds</a></li>
        <li><a href="mybuilds.php">My Computers</a></li>
        <li><div class="dropdown">
            <button class="dropbtn">Profile</button>
            <div class="dropdown-content">
            <a href="profile.php">Profile</a>
            <a href="cart.php">My Cart</a>
            <a href="index.php">Logout</a>
            </div>
        </li>
      </ul>
    </nav>
  </header>
<body>
    <h2>Your Profile</h2>
    
    <h2>Your Information</h2>
    
    <p><strong>Name:</strong> <span id="name"><?php echo $row['name']; ?></span></p>
    <p><strong>Email:</strong> <span id="email"><?php echo $myemail; ?></span></p>
    
</head>
<body>
    <h2>Change Password</h2>
    
    <form method="post">
        <label style ='color:white;' for="newPassword">New Password:</label>
        <input type="password" id="newPassword" name="newPassword" required><br>

        <label style ='color:white;' for="againnewPassword">Repeat New Password:</label>
        <input type="password" id="againnewPassword" name="againnewPassword" required><br>

        <input type="submit" value="Change Password">
        <div style = "font-size:14px; color:#cc0000; margin-top:10px"><?php if (isset($error)){echo $error;}; ?></div>
    </form>
    <h2>Delete Profile</h2>
    <form id="deleteForm" method="post">
        <input type="hidden" name="delete_profile" value="true">
        <button type="button" onclick="confirmDelete()">Delete Profile</button>
    </form>
</body>
</html>