<?php
// Suppress error reporting for security purposes
error_reporting(0);

// Establish a connection to the database
$db = mysqli_connect('localhost', 'girts', '', 'pc_part_picker');

// Check for a successful database connection
if (!$db) {
    echo 'Connection error: ' . mysqli_connect_error();
}

// Start the session to retrieve user information
session_start();

// Retrieve user information from the database based on the session email
$myemail = $_SESSION['login_user'];
$res = mysqli_query($db, "SELECT name, password, admin FROM users WHERE email = '$myemail'");
$row = mysqli_fetch_assoc($res);

// Retrieve the new password values from the form
$newPassword = $_POST["newPassword"];
$newPassword1 = $_POST["againnewPassword"];

// Check if the user is an admin
$isAdmin = $row['admin'];
// Define the navigation bar based on user role
$navBar = $isAdmin ? 'admin_navbar.php' : 'user_navbar.php';

// Check if the new passwords match
if ($newPassword == $newPassword1) {
    // Update the user's password in the database
    $sql = "UPDATE users SET password = '$newPassword' WHERE email = '$myemail'";
} else {
    // Set an error message if the passwords don't match
    $error = "Passwords don't match";
}

// Check if the delete_profile action is triggered
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
        // JavaScript function to confirm profile deletion
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
    <!-- Your navigation bar -->
    <?php
        // Include the appropriate navigation bar file
        include($navBar);
        ?>
</header>
<body>
    <h2>Your Profile</h2>
    
    <h2>Your Information</h2>
    
    <!-- Display user information -->
    <p><strong>Name:</strong> <span id="name"><?php echo $row['name']; ?></span></p>
    <p><strong>Email:</strong> <span id="email"><?php echo $myemail; ?></span></p>

    <!-- Change Password Form -->
    <h2>Change Password</h2>
    <form method="post">
        <label style ='color:white;' for="newPassword">New Password:</label>
        <input type="password" id="newPassword" name="newPassword" required><br>

        <label style ='color:white;' for="againnewPassword">Repeat New Password:</label>
        <input type="password" id="againnewPassword" name="againnewPassword" required><br>

        <input type="submit" value="Change Password">
        <div style="font-size:14px; color:#cc0000; margin-top:10px"><?php if (isset($error)) { echo $error; }; ?></div>
    </form>

    <!-- Delete Profile Form -->
    <h2>Delete Profile</h2>
    <form id="deleteForm" method="post">
        <input type="hidden" name="delete_profile" value="true">
        <button type="button" onclick="confirmDelete()">Delete Profile</button>
    </form>
</body>
</html>
